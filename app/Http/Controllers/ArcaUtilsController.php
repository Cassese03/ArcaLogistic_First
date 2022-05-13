<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;



/**
 * Controller utilizzate per effettuare le chiamate Ajax
 * Class AjaxController
 * @package App\Http\Controllers
 */

class ArcaUtilsController extends Controller{


    /**
     * Aggiunge un prodotto con quantita 1 se è già presente aumenta la quantità di 1
     * @param $id_ordine
     * @return \Illuminate\Contracts\View\View
     */

    public static function calcola_totale_ordine($id_dotes){

        DB::update("Update dotes set dotes.reserved_1= 'RRRRRRRRRR' where dotes.id_dotes = $id_dotes exec asp_DO_End $id_dotes");


    }
    public static function aggiungi_articolo($id_ordine,$codice_articolo,$quantita,$magazzino_A,$fornitore = 0,$ubicazione_A,$lotto,$magazzino_P,$ubicazione_P){
        $lotto = '0';
        $pedana = DB::select('SELECT * from ARLotto where Cd_AR =  \'' . $codice_articolo . '\' and Cd_ARLotto = \''.$lotto.'\' ');
        if(sizeof($pedana)!= 0)
            $pedana = $pedana[0]->xCd_xPallet;
        else
            $pedana = '0';
        if ($lotto == 'Nessun Lotto')
        {
            $lotto='0';
        }
        if ($ubicazione_A == 'ND')
        {
            $ubicazione_A='0';
        }
        if ($ubicazione_P == 'ND')
        {
            $ubicazione_P='0';
        }
        $nuovaRiga = null;
        $cf = DB::select('SELECT * from CF Where Cd_CF IN (SELECT Cd_CF from DOTes WHere Id_DoTes = '.$id_ordine.')');
        if(sizeof($cf) > 0)
        {
            $cf = $cf[0];
            $articoli = DB::select
            ('
                SELECT Cd_AR,Descrizione,Cd_ARMisura
                from AR
                where Cd_AR = \'' . $codice_articolo . '\';
             ');
            $RIGA = DB::SELECT('SELECT * FROM DORig where Id_DoTes = \'' . $id_ordine . '\' ORDER BY RIGA DESC');
            $id_dorig = DB::SELECT('SELECT * FROM DORig where Id_DoTes = \'' . $id_ordine . '\' ORDER BY RIGA DESC');
            $id_dotes = DB::SELECT('SELECT * FROM DOTes where Id_DoTes = \'' . $id_ordine . '\'');
            if ($RIGA == null)
                $RIGA = '0';
            else
                $RIGA = $RIGA[0]->Riga;
            $RIGA++;
            if (sizeof($articoli) > 0) {
                $articolo = $articoli[0];
                $insert_righe_ordine['Id_DoTes'] = $id_ordine;
                $insert_righe_ordine['Cd_AR'] = $articolo->Cd_AR;
                $insert_righe_ordine['Riga'] = $RIGA;
                $insert_righe_ordine['Descrizione'] = $articolo->Descrizione;
                $insert_righe_ordine['Cd_MGEsercizio'] = date('Y');
                $insert_righe_ordine['Cd_ARMisura'] = $articolo->Cd_ARMisura;
                $insert_righe_ordine['Cd_VL'] = 'EUR';
                $insert_righe_ordine['Qta'] = $quantita;
                $insert_righe_ordine['QtaEvadibile'] = $quantita;
                $insert_righe_ordine['Cambio'] = 1;
                $insert_righe_ordine['PrezzoUnitarioV'] = '';
                if(str_replace(' ','',$id_dotes[0]->Cd_Do) != 'TRM'){
                    $sconto = DB::SELECT('SELECT * FROM CF WHERE Cd_CF = \'' . $cf->Cd_CF . '\'');
                    if (sizeof($sconto) != '0')
                        $insert_righe_ordine['ScontoRiga'] = $sconto[0]->Sconto;
                }
                if($id_dotes[0]->Cd_LS_1 != '') {
                    $prezzo = DB::SELECT('SELECT * FROM LSRevisione WHERE Cd_LS = \''.$id_dotes[0]->Cd_LS_1.'\'');
                    if(sizeof($prezzo) != '0')
                        $prezzo = DB::SELECT('SELECT * FROM LSArticolo WHERE Id_LSRevisione =\''.$prezzo[0]->Id_LSRevisione.'\' and Cd_AR = \''.$codice_articolo.'\' ');
                    if(sizeof($prezzo) != '0')
                        $insert_righe_ordine['PrezzoUnitarioV'] = $prezzo[0]->Prezzo;
                }

                if($insert_righe_ordine['PrezzoUnitarioV'] == '' || $id_dotes[0]->Cd_Do == 'TRM'){
                    $prezzo = DB::SELECT('SELECT * FROM DORIG WHERE Cd_AR = \''.$codice_articolo.'\' and Cd_DO =\'BC\' Order By Id_DORig DESC ');
                    if(sizeof($prezzo) == 0)
                        $insert_righe_ordine['PrezzoUnitarioV'] = '0';
                    else
                        $insert_righe_ordine['PrezzoUnitarioV'] = $prezzo[0]->PrezzoUnitarioV;
                }
                $insert_righe_ordine['Cd_Aliquota'] = $cf->Cd_Aliquota;
                if($insert_righe_ordine['Cd_Aliquota'] == '')
                    $insert_righe_ordine['Cd_Aliquota'] = '22';
                $insert_righe_ordine['Cd_CGConto'] = DB::SELECT('SELECT * FROM IMPOSTAZIONE WHERE Id_Impostazione = \'7\'')[0]->Cd_CGConto_1;
                $documento = DB::SELECT('SELECT * FROM DO WHERE Cd_DO = \''.$id_dotes[0]->Cd_Do.'\'');
                if($documento[0]->CliFor =='C')
                $insert_righe_ordine['Cd_CGConto'] = DB::SELECT('SELECT * FROM IMPOSTAZIONE WHERE Id_Impostazione = \'7\'')[0]->Cd_CGConto_2;
                if($insert_righe_ordine['Cd_CGConto'] == '')
                    $insert_righe_ordine['Cd_CGConto'] = $cf->Cd_CGConto_Mastro;
                /*
                                    $insert_righe_ordine['Cd_Aliquota_R'] = $articolo->Cd_Aliquota_V;

                                    $insert_righe_ordine['PrezzoTotaleV'] = $prezzo * $quantita;
                                $insert_righe_ordine['Cd_MG_A'] = $magazzino_A;
                */
                $insert_righe_ordine['Cd_MG_A'] = $magazzino_A;
                if(sizeof($id_dorig) != '0') {
                    if (str_replace(" ", "", $id_dorig[0]->Cd_DO) == 'TRM' && $id_dorig  [0]->Cd_CF == 'F000143')
                        $insert_righe_ordine['Cd_MG_A'] = '00003';
                }else{
                    if (str_replace(" ", "", $id_dotes[0]->Cd_Do) == 'TRM' && $id_dotes  [0]->Cd_CF == 'F000143')
                        $insert_righe_ordine['Cd_MG_A'] = '00003';
                }
                if(sizeof($id_dorig) != '0') {
                    if (str_replace(" ", "", $id_dorig[0]->Cd_DO) == 'TRM' && $id_dorig[0]->Cd_CF == 'F000765')
                        $insert_righe_ordine['Cd_MG_A'] = '00009';
                }else{
                    if (str_replace(" ", "", $id_dotes[0]->Cd_Do) == 'TRM' && $id_dotes[0]->Cd_CF == 'F000765')
                        $insert_righe_ordine['Cd_MG_A'] = '00009';
                }
                $insert_righe_ordine['Cd_MG_P'] = $magazzino_P;
                if(sizeof($id_dorig) != '0') {
                    if (str_replace(" ", "", $id_dorig[0]->Cd_DO) == 'TRM')
                        $insert_righe_ordine['Cd_MG_P'] = '00001';
                }else
                {
                    if (str_replace(" ", "", $id_dotes[0]->Cd_Do) == 'TRM')
                        $insert_righe_ordine['Cd_MG_P'] = '00001';
                }
/*
                $condizione = '';
                $condizione .= 'and Cd_ARLotto = \'' . $lotto . '\'';
                if ($ubicazione_A != '0')
                    $condizione .= 'and Cd_MGUbicazione_A =\'' . $ubicazione_A . '\'';
                if ($ubicazione_P != '0')
                    $condizione .= 'and Cd_MGUbicazione_P =\'' . $ubicazione_P . '\'';

                $tipo1 = DB::SELECT('SELECT * FROM DOTes WHERE Id_DOTes = \'' . $id_ordine . '\'');
                $tipo = $tipo1[0]->Cd_Do;
                $fornitore = $tipo1[0]->Cd_CF;
                if (str_replace(' ','',$tipo) == 'DTG' || str_replace(' ','',$tipo) == 'DTR') {
                    $i = '0';
                    $id_ordine_1 = DB::SELECT('SELECT * FROM DORig WHERE Id_DOTes=\'' . $id_ordine . '\' ');
                    foreach ($id_ordine_1 as $o) {
                        if ($o->Id_DORig_Evade != null) {
                            $Id_DoTes = $o->Id_DORig_Evade;
                            $Id_DoTes = DB::SELECT('SELECT * FROM DORig WHERE Id_DORig = \'' . $Id_DoTes . '\' ')[0]->Id_DOTes;
                            $i++;
                        }
                    }

                    $nuovo = DB::SELECT('SELECT * FROM DODOPREL WHERE Cd_DO = \'' . $tipo . '\'');
                    if ($nuovo != null) {
                        $nuovo = $nuovo[0]->Cd_DO_Prelevabile;
                        if ($i == 0)
                            $Id_DoTes = DB::table('DOTes')->insertGetId(['Cd_CF' => $fornitore, 'Cd_Do' => $nuovo]);

                        $insert_righe_ordine['Id_DoTes'] = $Id_DoTes;
                        /*$insert_righe_ordine['QtaEvasa'] = $insert_righe_ordine['Qta'];
                        $insert_righe_ordine['QtaEvadibile'] = '0';*//*


                        DB::table('DORig')->insertGetId($insert_righe_ordine);
                        $nuovaRiga = DB::SELECT('SELECT top 1 * FROM DORig order by Id_DORig desc ')[0]->Id_DORig;
                        if ($lotto != '0') {
                            DB::update("Update DoRig set Cd_ARLotto = '$lotto' where id_dorig = '$nuovaRiga'");
                        }
                        if ($pedana != '0'){
                            DB::update("Update DoRig set xCd_xPallet = '$pedana' where id_dorig = '$nuovaRiga'");
                        }
                        $insert_righe_ordine['Id_DoTes'] = $id_ordine;
                        $insert_righe_ordine['QtaEvasa'] = $insert_righe_ordine['Qta'];
                        $insert_righe_ordine['Id_DORig_Evade'] = $nuovaRiga;
                        ArcaUtilsController::calcola_totale_ordine($id_ordine);
                    }
                }
                $esiste = DB::select('SELECT * from DORig where Id_DoTes = ' . $id_ordine . ' and Cd_AR =  \'' . $codice_articolo . '\' and Cd_MG_A = \''.$magazzino_A.'\' and Cd_MG_P = \''.$magazzino_P.'\'  '.$condizione.' ');

                if (sizeof($esiste) == 0)
                {*/
                    DB::table('DORig')->insertGetId($insert_righe_ordine);
                    ArcaUtilsController::calcola_totale_ordine($id_ordine);

                }/*
                else
                {
                    $insert_righe_ordine['Qta'] = floatval($quantita) + floatval($esiste[0]->Qta);
                    $insert_righe_ordine['QtaEvadibile'] = floatval($quantita) + floatval($esiste[0]->QtaEvadibile);/*
                        $insert_righe_ordine['PrezzoUnitarioV'] = floatval($prezzo) + floatval($esiste[0]->PrezzoUnitarioV);
                        $insert_righe_ordine['PrezzoTotaleV'] = floatval($prezzo * $quantita) + floatval($esiste[0]->PrezzoTotaleV);*//*
                    $insert_righe_ordine['Cd_MG_A'] = $magazzino_A;
                    $insert_righe_ordine['Cd_MG_P'] = $magazzino_P;

                    DB::table('DORig')->where('Id_DORig', $esiste[0]->Id_DORig)->update($insert_righe_ordine);
                    $Id_DORig = $esiste[0]->Id_DORig;
                    if ($lotto != '0') {
                        DB::update("Update DoRig set Cd_ARLotto = '$lotto' where id_dorig = '$Id_DORig' ");
                    }
                    if ($ubicazione_A != '0') {
                        DB::update("Update DoRig set Cd_MGUbicazione_A = '$ubicazione_A' where id_dorig = '$Id_DORig'");
                    }
                    if ($ubicazione_P != '0') {
                        DB::update("Update DoRig set Cd_MGUbicazione_P = '$ubicazione_P' where id_dorig = '$Id_DORig'");
                    }
                    if ($pedana != '0'){
                        DB::update("Update DoRig set xCd_xPallet = '$pedana' where id_dorig = '$Id_DORig'");
                    }
                    ArcaUtilsController::calcola_totale_ordine($id_ordine);
                }

                if($nuovaRiga != null ){
                    DB::UPDATE('Update DoRig set QtaEvadibile= \'0\'WHERE Id_DoRig = \''.$nuovaRiga.'\'');
                    DB::UPDATE('Update DoRig set QtaEvasa= \''.$quantita.'\'WHERE Id_DoRig = \''.$nuovaRiga.'\'');
                    DB::update('Update dorig set Evasa = \'1\'   where Id_DoRig = \'' . $nuovaRiga . '\' ');
                    $Id_DoTes_old = DB::SELECT('SELECT * from DoRig where id_dorig = \'' . $nuovaRiga . '\' ')[0]->Id_DOTes;
                    DB::update("Update dotes set dotes.reserved_1= 'RRRRRRRRRR' where dotes.id_dotes = '$Id_DoTes_old'");
                    DB::statement("exec asp_DO_End '$Id_DoTes_old'");

                ArcaUtilsController::calcola_totale_ordine($id_ordine);
                /*
                $insert_righe_ordine['Id_DoTes'] = $id_ordine;
                $insert_righe_ordine['Qta'] = $quantita;
                $insert_righe_ordine['QtaEvadibile'] = $quantita;
                $insert_righe_ordine['QtaEvasa'] = $quantita;
                $insert_righe_ordine['Id_DORig_Evade'] = $nuovaRiga;
                $condizione  .='and Id_DORig_Evade = \''.$nuovaRiga.'\'';*/
            //}
        }
    }
    /*
        public static function scarica_articolo($id_ordine,$codice_articolo,$quantita,$magazzino,$fornitore = 0,$ubicazione,$lotto){

            if ($lotto == 'Nessun Lotto')
            {
                $lotto='0';
            }
            if ($ubicazione_A == 'ND')
            {
                $ubicazione_A='0';
            }
            if ($ubicazione_P == 'ND')
            {
                $ubicazione_P='0';
            }

            $cf = DB::select('SELECT * from CF Where Cd_CF IN (SELECT Cd_CF from DOTes WHere Id_DoTes = '.$id_ordine.')');
            if(sizeof($cf) > 0)
            {
                $cf = $cf[0];
                $articoli = DB::select
                ('
                    SELECT Cd_AR,Descrizione,Cd_ARMisura
                    from AR
                    where Cd_AR = \'' . $codice_articolo . '\';
                 ');
                $RIGA = DB::SELECT('SELECT * FROM DORig where Id_DoTes = \'' . $id_ordine . '\' ORDER BY RIGA DESC');
                if ($RIGA == null)
                    $RIGA = '0';
                else
                    $RIGA = $RIGA[0]->Riga;
                $RIGA++;
                if (sizeof($articoli) > 0) {
                    $articolo = $articoli[0];
                    $insert_righe_ordine['Id_DoTes'] = $id_ordine;
                    $insert_righe_ordine['Cd_AR'] = $articolo->Cd_AR;
                    $insert_righe_ordine['Riga'] = $RIGA;
                    $insert_righe_ordine['Descrizione'] = $articolo->Descrizione;
                    $insert_righe_ordine['Cd_MGEsercizio'] = date('Y');
                    $insert_righe_ordine['Cd_ARMisura'] = $articolo->Cd_ARMisura;
                    $insert_righe_ordine['Cd_VL'] = 'EUR';
                    $insert_righe_ordine['Qta'] = $quantita;
                    $insert_righe_ordine['QtaEvadibile'] = $quantita;
                    $insert_righe_ordine['Cambio'] = 1;
                    /*
                                        $insert_righe_ordine['PrezzoUnitarioV'] = $prezzo;
                                        $insert_righe_ordine['Cd_Aliquota_R'] = $articolo->Cd_Aliquota_V;
                                        $insert_righe_ordine['Cd_Aliquota'] = $articolo->Cd_Aliquota_V;
                                        $insert_righe_ordine['Cd_CGConto'] = $cf->Cd_CGConto_Mastro;
                                        $insert_righe_ordine['PrezzoTotaleV'] = $prezzo * $quantita;*//*
                $insert_righe_ordine['Cd_MG_A'] = $magazzino_A;
                $insert_righe_ordine['Cd_MG_P'] = $magazzino_P;
                $condizione='';
                $condizione  .='and Cd_ARLotto = \''.$lotto.'\'';
                if($ubicazione_A != '0')
                    $condizione .='and Cd_MGUbicazione_A =\''.$ubicazione_A.'\'';
                if($ubicazione_P != '0')
                    $condizione .='and Cd_MGUbicazione_P =\''.$ubicazione_P.'\'';

                $tipo1  = DB::SELECT('SELECT * FROM DOTes WHERE Id_DOTes = \''.$id_ordine.'\'');
                $tipo   = $tipo1[0]->Cd_Do;
                $fornitore= $tipo1[0]->Cd_CF;
                $nuovo = DB::SELECT('SELECT * FROM DODOPREL WHERE Cd_DO = \''.$tipo.'\'')[0]->Cd_DO_Prelevabile;

                $Id_DoTes = DB::table('DOTes')->insertGetId(['Cd_CF' => $fornitore, 'Cd_Do' => $nuovo]);
                $insert_righe_ordine['Id_DoTes'] = $Id_DoTes;
                $insert_righe_ordine['QtaEvasa'] = $insert_righe_ordine['QtaEvadibile'];



                DB::table('DORig')->insertGetId($insert_righe_ordine);
                $nuovaRiga = DB::SELECT('SELECT top 1 * FROM DORig order by Id_DORig desc ')[0]->Id_DORig;
                if ($lotto != '0')
                {
                    DB::update("Update DoRig set Cd_ARLotto = '$lotto' where id_dorig = '$nuovaRiga'");
                }
                $insert_righe_ordine['Id_DoTes'] = $id_ordine;
                $insert_righe_ordine['Qta'] = $quantita;
                $insert_righe_ordine['QtaEvadibile'] = $quantita;
                $insert_righe_ordine['QtaEvasa'] = $quantita;
                $insert_righe_ordine['Id_DORig_Evade'] = $nuovaRiga;
                $condizione  .='and Id_DORig_Evade = \''.$nuovaRiga.'\'';
                $esiste = DB::select('SELECT * from DORig where Id_DoTes = ' . $id_ordine . ' and Cd_AR =  \'' . $codice_articolo . '\' and Cd_MG_A = \''.$magazzino_A.'\' and Cd_MG_P = \''.$magazzino_P.'\'  '.$condizione.' ');
                if (sizeof($esiste) == 0)
                {
                    DB::table('DORig')->insertGetId($insert_righe_ordine);
                    $Id_DORig = DB::SELECT('SELECT top 1 * FROM DORig order by Id_DORig desc ')[0]->Id_DORig;;
                    if ($lotto != '0')
                    {
                        DB::update("Update DoRig set Cd_ARLotto = '$lotto' where id_dorig = '$Id_DORig'");
                    }
                    if ($ubicazione_A != '0') {
                        DB::update("Update DoRig set Cd_MGUbicazione_A = '$ubicazione_A' where id_dorig = '$Id_DORig' ");
                    }
                    if ($ubicazione_P != '0') {
                        DB::update("Update DoRig set Cd_MGUbicazione_P = '$ubicazione_P' where id_dorig = '$Id_DORig' ");
                    }
                    ArcaUtilsController::calcola_totale_ordine($id_ordine);

                }
                else
                {
                    $insert_righe_ordine['Qta'] = floatval($quantita) + floatval($esiste[0]->Qta);
                    $insert_righe_ordine['QtaEvadibile'] = floatval($quantita) + floatval($esiste[0]->QtaEvadibile);/*
                        $insert_righe_ordine['PrezzoUnitarioV'] = floatval($prezzo) + floatval($esiste[0]->PrezzoUnitarioV);
                        $insert_righe_ordine['PrezzoTotaleV'] = floatval($prezzo * $quantita) + floatval($esiste[0]->PrezzoTotaleV);*//*
                    $insert_righe_ordine['Cd_MG_A'] = $magazzino_A;
                    $insert_righe_ordine['Cd_MG_P'] = $magazzino_P;

                    DB::table('DORig')->where('Id_DORig', $esiste[0]->Id_DORig)->update($insert_righe_ordine);
                    $Id_DORig=$esiste[0]->Id_DORig;
                    if ($lotto != '0') {
                        DB::update("Update DoRig set Cd_ARLotto = '$lotto' where id_dorig = '$Id_DORig' ");
                    }
                    if ($ubicazione_A != '0') {
                        DB::update("Update DoRig set Cd_MGUbicazione_A = '$ubicazione_A' where id_dorig = '$Id_DORig'");
                    }
                    if ($ubicazione_P != '0') {
                        DB::update("Update DoRig set Cd_MGUbicazione_P = '$ubicazione_P' where id_dorig = '$Id_DORig'");
                    }

                    ArcaUtilsController::calcola_totale_ordine($id_ordine);
                }
            }
        }
    }
*/
    /*
        public static function trasporto_articolo($Cd_AR,$Cd_Do,$quantita,$Cd_MG,$ubicazione_P,$Cd_Mg_A,$ubicazione_A,$Cd_Cf,$lotto){


            $Id_DoTes = DB::table('DoTes')->InsertGetId(['cd_do' => $Cd_Do ,'cd_cf' => $Cd_Cf]);
            DB::update("Update dotes set dotes.reserved_1 = 'RRRRRRRRRR' where dotes.id_dotes = $Id_DoTes exec asp_DO_End $Id_DoTes");

            $Id_DoRig = DB::table('DoRig')->InsertGetId(['Id_DoTes'=>$Id_DoTes,'Cd_DO' => $Cd_Do , 'Cd_CF'=> $Cd_Cf, 'Cd_MG_P'=>$Cd_MG, 'Cd_MG_A'=>$Cd_Mg_A ,'Cd_AR'=>$Cd_AR,'Qta'=>$quantita]);
            DB::update("Update dotes set dotes.reserved_1 = 'RRRRRRRRRR' where dotes.id_dotes = $Id_DoRig exec asp_DO_End $Id_DoRig");

            if($lotto!='0')
            {
                DB::update("Update DoRig set Cd_ARLotto = '$lotto' where id_dotes = $Id_DoTes ");
            }
            if($ubicazione_A!='0')
            {
                DB::update("Update DoRig set Cd_MGUbicazione_A = '$ubicazione_A' where id_dotes = $Id_DoTes ");
            }
            if($ubicazione_P!='0')
            {
                DB::update("Update DoRig set Cd_MGUbicazione_P = '$ubicazione_P' where id_dotes = $Id_DoTes ");
            }

            return $Id_DoTes;
        }*/
    public static function trasporto_articolo($Cd_AR,$Cd_Do,$quantita,$Cd_MG,$ubicazione_P,$Cd_Mg_A,$ubicazione_A,$Cd_Cf,$lotto,$Id_DoTes){
        if ($quantita == '0')
            echo 'Impossibile trasportare la Quantita a 0';
        else {
            $condizione = 'WHERE Cd_AR = \'' . $Cd_AR . '\' and Cd_Do =\'' . $Cd_Do . '\' and Cd_MG_P = \'' . $Cd_MG . '\' and Cd_MG_A = \'' . $Cd_Mg_A . '\' and Id_DoTes = \'' . $Id_DoTes . '\' ';
            if ($lotto != '0')
                $condizione .= 'and Cd_ARLotto = \'' . $lotto . '\'';

            if ($ubicazione_A != '0')
                $condizione .= 'and Cd_MGUbicazione_A =\'' . $ubicazione_A . '\'';

            if ($ubicazione_P != '0')
                $condizione .= 'and Cd_MGUbicazione_P =\'' . $ubicazione_P . '\'';


            $esiste = DB::Select('SELECT * FROM DoRig ' . $condizione);
            if (sizeof($esiste) == 0) {
                $Id_MgMov = DB::table('DORig')->insertGetId(['Id_DOTes' => $Id_DoTes, 'Cd_DO' => $Cd_Do, 'Cd_CF' => $Cd_Cf, 'Cd_MG_P' => $Cd_MG, 'Cd_MG_A' => $Cd_Mg_A, 'Cd_AR' => $Cd_AR, 'Qta' => $quantita]);
                $Id_DoRig = DB::SELECT('SELECT * FROM MgMov WHERE Id_MgMov = \''.$Id_MgMov.'\' ')[0]->Id_DoRig;

                DB::update("Update dotes set dotes.reserved_1 = 'RRRRRRRRRR' where dotes.id_dotes = $Id_DoRig exec asp_DO_End $Id_DoRig");

                if ($lotto != '0') {
                    DB::update("Update DoRig set Cd_ARLotto = '$lotto' where id_dorig = $Id_DoRig ");
                }
                if ($ubicazione_A != '0') {
                    DB::update("Update DoRig set Cd_MGUbicazione_A = '$ubicazione_A' where id_dorig = $Id_DoRig ");
                }
                if ($ubicazione_P != '0') {
                    DB::update("Update DoRig set Cd_MGUbicazione_P = '$ubicazione_P' where id_dorig = $Id_DoRig ");
                }
            } else {
                $quantita1 = $quantita + intval($esiste[0]->Qta);
                $Id_DoRig = $esiste[0]->Id_DORig;
                DB::update("Update DoRig set Qta = '$quantita1' where id_dorig = $Id_DoRig ");
            }
        }
    }

    public static function modifica_articolo($id_ordine,$codice_articolo,$quantita,$magazzino_A,$fornitore = 0,$ubicazione_A,$lotto,$magazzino_P,$ubicazione_P){


        $cf = DB::select('SELECT * from CF Where Cd_CF IN (SELECT Cd_CF from DOTes WHere Id_DoTes = '.$id_ordine.')');
        if(sizeof($cf) > 0) {
            $cf = $cf[0];


            $articoli = DB::select('
                SELECT Cd_AR,Descrizione,Cd_ARMisura
                from AR
                where Cd_AR = \'' . $codice_articolo . '\';
             ');

            if (sizeof($articoli) > 0) {
                $articolo = $articoli[0];

                $insert_righe_ordine['Id_DoTes'] = $id_ordine;
                $insert_righe_ordine['Cd_AR'] = $articolo->Cd_AR;
                $insert_righe_ordine['Riga'] = 1;
                $insert_righe_ordine['Descrizione'] = $articolo->Descrizione;
                $insert_righe_ordine['Cd_MGEsercizio'] = date('Y');
                $insert_righe_ordine['Cd_ARMisura'] = $articolo->Cd_ARMisura;
                $insert_righe_ordine['Cd_VL'] = 'EUR';
                $insert_righe_ordine['Cambio'] = 1;
                $insert_righe_ordine['Qta'] = $quantita;
                $insert_righe_ordine['QtaEvadibile'] = $quantita;/*
                $insert_righe_ordine['PrezzoUnitarioV'] = $prezzo;
                $insert_righe_ordine['Cd_Aliquota_R'] = $articolo->Cd_Aliquota_V;
                $insert_righe_ordine['Cd_Aliquota'] = $articolo->Cd_Aliquota_V;
                $insert_righe_ordine['Cd_CGConto'] = $cf->Cd_CGConto_Mastro;
                $insert_righe_ordine['PrezzoTotaleV'] = $prezzo * $quantita;*/
                $insert_righe_ordine['Cd_MG_P'] = $magazzino_P;
                $insert_righe_ordine['Cd_MG_A'] = $magazzino_A;

                $esiste = DB::select('SELECT * from DORig where Id_DoTes = ' . $id_ordine . ' and Cd_AR =  \'' . $codice_articolo . '\' and Cd_ARLotto = \''.$lotto.'\'');
                if (sizeof($esiste) == 0) {
                    $Id_MGMov = DB::table('DORig')->insertGetId($insert_righe_ordine);
                    $Id_DoRig1= DB::select('Select * from mgmov where Id_Mgmov = \''.$Id_MGMov.'\'');
                    $Id_DoRig = $Id_DoRig1[0]->Id_DoRig;
                } else {
                    $insert_righe_ordine['Qta'] = $quantita;
                    $insert_righe_ordine['QtaEvadibile'] = $quantita;/*
                    $insert_righe_ordine['PrezzoUnitarioV'] = $prezzo;
                    $insert_righe_ordine['PrezzoTotaleV'] = $prezzo * $quantita;*/
                    $insert_righe_ordine['Cd_MG_P'] = $magazzino_P;
                    $insert_righe_ordine['Cd_MG_A'] = $magazzino_A;
                    DB::table('DORig')->where('Id_DORig', $esiste[0]->Id_DORig)->update($insert_righe_ordine);
                    $Id_DoRig=$esiste[0]->Id_DORig;
                    if ($lotto != '0') {
                        DB::update("Update DoRig set Cd_ARLotto = '$lotto' where id_dorig = $Id_DoRig ");
                    }
                    if ($ubicazione_P != '0') {
                        DB::update("Update DoRig set Cd_MGUbicazione_P = '$ubicazione_P' where id_dorig = $Id_DoRig ");
                    }
                    if ($ubicazione_A != '0') {
                        DB::update("Update DoRig set Cd_MGUbicazione_A = '$ubicazione_A' where id_dorig = $Id_DoRig ");
                    }

                    ArcaUtilsController::calcola_totale_ordine($id_ordine);
                    exit();
                }

            }

            if ($lotto != '0') {
                DB::update("Update DoRig set Cd_ARLotto = '$lotto' where id_dorig = $Id_DoRig ");
            }
            if ($ubicazione_P != '0') {
                DB::update("Update DoRig set Cd_MGUbicazione_P = '$ubicazione_P' where id_dorig = $Id_DoRig ");
            }
            if ($ubicazione_A != '0') {
                DB::update("Update DoRig set Cd_MGUbicazione_A = '$ubicazione_A' where id_dorig = $Id_DoRig ");
            }

            ArcaUtilsController::calcola_totale_ordine($id_ordine);
        }
    }

    /**
     * Diminuisce di 1 la quantità di una riga, se la quantità è 1 elimina la riga
     * @param $id_ordine
     * @return \Illuminate\Contracts\View\View
     */
    public static function rimuovi_articolo($id_ordine,$codice_articolo){


        $articoli = DB::select('
                        SELECT
                             Cd_AR
		                    ,Descrizione
		                    ,Cd_ARMisura

                        from AR
                        ');

        if(sizeof($articoli) > 0) {
            $articolo = $articoli[0];

            $esiste = DB::select('SELECT * from DORig where Id_DoTes = '.$id_ordine.' and Cd_AR =  \''.$codice_articolo.'\'');
            if(sizeof($esiste) > 0){

                if($esiste[0]->Qta > 1) {

                    $quantita = $esiste[0]->Qta - 1;
                    $insert_righe_ordine['Qta'] = $quantita;
                    $insert_righe_ordine['QtaEvadibile'] = $quantita;
                    $insert_righe_ordine['PrezzoTotaleV'] = $articolo->Prezzo * $quantita;
                    DB::table('DORig')->where('Id_DORig', $esiste[0]->Id_DORig)->update($insert_righe_ordine);

                } else {

                    ArcaUtilsController::rimuovi_riga($id_ordine,$codice_articolo);
                }
            }
        }

        ArcaUtilsController::calcola_totale_ordine($id_ordine);

    }

    /**
     * Diminuisce di 1 la quantità di una riga, se la quantità è 1 elimina la riga
     * @param $id_ordine
     * @return \Illuminate\Contracts\View\View
     */
    public static function rimuovi_riga($id_ordine,$codice_articolo){


        $articoli = DB::select('
                        SELECT
                             Cd_AR
		                    ,Descrizione
		                    ,Cd_ARMisura
		                    ,Cd_Aliquota_V

                        from AR
                        ');

        if(sizeof($articoli) > 0) {
            $esiste = DB::select('SELECT * from DORig where Id_DoTes = '.$id_ordine.' and Cd_AR =  \''.$codice_articolo.'\'');
            if(sizeof($esiste) > 0){
                DB::table('DORig')->where('Id_DORig', $esiste[0]->Id_DORig)->delete();
            }
        }

        ArcaUtilsController::calcola_totale_ordine($id_ordine);

    }



    /**
     * Diminuisce di 1 la quantità di una riga, se la quantità è 1 elimina la riga
     * @param $id_ordine
     * @return \Illuminate\Contracts\View\View
     */
    public static function modifica_riga($id_ordine,$id_riga,$prezzo,$quantita){

        $esiste = DB::select('SELECT * from DORig where Id_DoTes = '.$id_ordine.' and Id_DORig =  '.$id_riga);
        if(sizeof($esiste) > 0){

            $insert_righe_ordine['Qta'] = $quantita;
            $insert_righe_ordine['PrezzoUnitarioV'] = $prezzo;
            $insert_righe_ordine['QtaEvadibile'] = $quantita;
            $insert_righe_ordine['PrezzoTotaleV'] = $prezzo * $quantita;
            DB::table('DORig')->where('Id_DORig', $esiste[0]->Id_DORig)->update($insert_righe_ordine);
        }

        ArcaUtilsController::calcola_totale_ordine($id_ordine);

    }

    public static function calcola_totali_ordine(){

        ini_set('max_execution_time',0);
        $ordini = DB::select('SELECT * from DOTes');
        foreach($ordini as $o) {

            ArcaUtilsController::calcola_totale_ordine($o->Id_DoTes);
        }
    }


}




