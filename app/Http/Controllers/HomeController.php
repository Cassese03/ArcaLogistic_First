<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Null_;
use Spatie\GoogleCalendar\Event;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



/**
 * Controller principale del webticket
 * Class HomeController
 * @package App\Http\Controllers
 */

class HomeController extends Controller{



    public function login(Request $request){

        $dati = $request->all();

        $psw = '0';
        if (isset($dati['login'])) {

            $utenti = DB::select('SELECT * from Operatore where Cd_Operatore = \''.$dati['Utente'].'\' ');

            if (sizeof($utenti) > 0) {
                $utente = $utenti[0];
                $password = DB::SELECT('SELECT * FROM Operatore WHERE Id_Operatore = '.$utente->Id_Operatore);

                if($password != null)
                    $password = $password[0]->Password;

                $passInserita = DB::SELECT('Select SubString(Convert(varchar(max), HASHBYTES(\'SHA2_256\', \''.$dati['Password'].'\'), 1), 3, 64) as Password ');

                if(sizeof($passInserita) < 1)
                    $passInserita = DB::SELECT('Select HASHBYTES(\'SHA2_256\', \''.$dati['Password'].'\') as Password');

                if($password != $passInserita[0]->Password) {
                    $ditta = DB::select('SELECT * from Ditta')[0];
                    $psw = '1';
                    return View::make('login', compact('ditta','psw'));
                }
                session(['utente' => $utente]);
                session()->save();
            }
            else
                {
                    $ditta = DB::select('SELECT * from Ditta')[0];
                    $psw = '2';
                    return View::make('login', compact('ditta','psw'));
                }

        }
        if (session()->has('utente')) {
            return Redirect::to('');
        }

        $ditta = DB::select('SELECT * from Ditta')[0];
        return View::make('login',compact('ditta','psw'));
    }
    public function logout(Request $request){
        session()->flush();
        return Redirect::to('login');
    }
    public function index(){
        if(!session()->has('utente')) {
            return Redirect::to('login');
        }

        $ditta = DB::select('SELECT * from Ditta')[0];

        return View::make('index',compact('ditta'));
    }

    public function articoli(){

        if(!session()->has('utente')) {
            return Redirect::to('login');
        }

        $articoli = DB::select('SELECT TOP 10 [Id_AR],[Cd_AR],[Descrizione] FROM AR Order By Id_AR DESC');

        return View::make('articoli',compact('articoli'));
    }

    public function modifica_articolo($id,Request $request){

        if(is_numeric($id)) {

            $dati = $request->all();

            if(isset($dati['modifica_articolo'])){
                unset($dati['modifica_articolo']);

                if(isset($dati['barcode']))  $barcodes = $dati['barcode']; unset($dati['barcode']);
                if(isset($dati['listino']))  $listini = $dati['listino']; unset($dati['listino']);


                if(isset($dati['gruppi'])){
                    list($dati['Cd_ARGruppo1'],$dati['Cd_ARGruppo2'],$dati['Cd_ARGruppo3']) = explode(';',$dati['gruppi']);
                    unset($dati['gruppi']);
                }

				if($dati['Cd_ARGruppo1'] == '') unset($dati['Cd_ARGruppo1']);
				if($dati['Cd_ARGruppo2'] == '') unset($dati['Cd_ARGruppo2']);
				if($dati['Cd_ARGruppo3'] == '') unset($dati['Cd_ARGruppo3']);

               /*
                    if(isset($dati['pezzi_confezione'])){
                        DB::table('ARARMisura')->where('Cd_AR',$dati['Cd_AR'])->where('Cd_ARMisura','CT')->update(array('UMFatt' => $dati['pezzi_confezione']));
                        unset($dati['pezzi_confezione']);
                    }
                */
                DB::table('AR')->where('Id_AR',$id)->update($dati);

                foreach($barcodes as $chiave => $valore){
                    if($valore != ''){
                        $esiste = DB::select('SELECT * FROM ARAlias where Riga = \''.$chiave.'\' and Cd_AR = \''.$dati['Cd_AR'].'\'');
                        if(sizeof($esiste) > 0) {
                            DB::table('ARAlias')->where('Riga',$chiave)->where('Cd_AR',$dati['Cd_AR'])->update(array('Alias' => $valore));
                        }  else DB::table('ARAlias')->insert(array('Alias' => $valore,'Riga' => $chiave,'CD_AR' => $dati['Cd_AR']/*,'Cd_ARMisura' => 'CT'*/));
                    } else {
                        $esiste = DB::select('SELECT * FROM ARAlias where Riga = \''.$chiave.'\' and Cd_AR = \''.$_POST['Cd_AR'].'\'');
                        if(sizeof($esiste) > 0) {
                            DB::table('ARAlias')->where('Riga',$chiave)->where('Cd_AR',$dati['Cd_AR'])->delete();
                        }
                    }
                }
/*
                if(isset($listini)) {
                    foreach ($listini as $chiave => $valore) {
                        DB::table('LSArticolo')->where('Id_LSArticolo', $chiave)->update(array('Prezzo' => $valore));
                    }
                }*/

            }

            if(isset($dati['elimina_articolo'])){
                DB::table('ARAlias')->where('Cd_AR',$dati['Cd_AR'])->delete();
                DB::table('LSArticolo')->where('Cd_AR',$dati['Cd_AR'])->delete();
                DB::table('ARARMisura')->where('Cd_AR',$dati['Cd_AR'])->delete();
                DB::table('AR')->where('Id_AR',$id)->delete();

                return Redirect::to('articoli');
            }



            $articoli = DB::select('SELECT * FROM AR where Id_AR = ' .$id);
            if(sizeof($articoli) > 0) {
                $articolo = $articoli[0];
                $gruppi = DB::select("SELECT ARGruppo1.Cd_ARGruppo1,ARGruppo2.Cd_ARGruppo2,ARGruppo3.Cd_ARGruppo3,CONCAT(ARGruppo1.Cd_ARGruppo1,';',ARGruppo2.Cd_ARGruppo2,';',ARGruppo3.Cd_ARGruppo3) as id,
                CONCAT(ARGruppo1.Descrizione,' - ',ARGruppo2.Descrizione,' - ',ARGruppo3.Descrizione) as Descrizione from ARGruppo3
                JOIN ARGruppo2 ON ARGruppo2.Cd_ARGruppo2 = ARGruppo3.Cd_ARGruppo2
                JOIN ARGruppo1 ON ARGruppo1.Cd_ARGruppo1 = ARGruppo2.Cd_ARGruppo1");

                $aliases = DB::select('SELECT * from ARAlias where Cd_AR = \'' . $articolo->Cd_AR . '\' order by Riga ASC');

                $listini = DB::select('SELECT LSArticolo.Id_LSArticolo,LS.Cd_LS,LS.Descrizione,LSArticolo.Prezzo from LSArticolo
                    JOIN LSRevisione ON LSArticolo.id_LSRevisione = LSRevisione.Id_LSRevisione
                    JOIN LS ON LS.Cd_LS = LSRevisione.Cd_LS
                    where LSArticolo.CD_AR = \''.$articolo->Cd_AR.'\'');

                $misure = DB::select('SELECT * FROM ARARMisura where Cd_AR = \''.$articolo->Cd_AR.'\'');
                $gruppoAR = DB::select("SELECT *,CONCAT(Cd_ARGruppo1,';',Cd_ARGruppo2,';',Cd_ARGruppo3) as id FROM ARGRUPPO123 where Cd_ARGruppo123 = '$articolo->Cd_ARGruppo1$articolo->Cd_ARGruppo2$articolo->Cd_ARGruppo3'");
                if($gruppoAR!=null)
                    $gruppoAR = $gruppoAR[0];

                return View::make('modifica_articolo', compact('articolo', 'gruppi','aliases','listini','misure','gruppoAR'));
            }
        }
    }
/*
    public function nuovo_articolo(Request $request){

        $dati = $request->all();

        if(isset($dati['nuovo_articolo'])){
            unset($dati['nuovo_articolo']);

            $redirect = '';
            if(isset($dati['redirect'])){
                $redirect = $dati['redirect'];
                unset($dati['redirect']);
            }
/*
            $prezzo_acquisto = $dati['prezzo_acquisto'];
            $prezzo_vendita = $dati['prezzo_vendita'];
            $barcode = $dati['barcode'];
/*
            unset($dati['prezzo_acquisto']);
            unset($dati['prezzo_vendita']);
            unset($dati['margine']);
            unset($dati['barcode']);


            DB::delete('DELETE from AR where Cd_AR = \''.$dati['Cd_AR'].'\'');/*
			DB::delete('DELETE from LSArticolo where Cd_AR = \''.$dati['Cd_AR'].'\'');
            DB::delete('DELETE from ARAlias where Cd_AR = \''.$dati['Cd_AR'].'\'');
            DB::delete('DELETE from ARARMisura where Cd_AR = \''.$dati['Cd_AR'].'\'');

/*
		    $pezzi = $dati['pezzi_confezione'];
            unset($dati['pezzi_confezione']);

            try {

                DB::beginTransaction();
/*
                $dati['Cd_Aliquota_V'] = '22';
                $id = DB::table('AR')->insertGetId($dati);

                $lsrevisione = DB::select('SELECT * from LSRevisione where Cd_LS = \'LMP\'')[0];
                DB::table('LSArticolo')->insert(array('Prezzo' => $prezzo_acquisto,'Id_LSRevisione' => $lsrevisione->Id_LSRevisione, 'Cd_AR' => $dati['Cd_AR']));

                $lsrevisione = DB::select('SELECT * from LSRevisione where Cd_LS = \'LS2181\'')[0];
                DB::table('LSArticolo')->insert(array('Prezzo' => $prezzo_vendita,'Id_LSRevisione' => $lsrevisione->Id_LSRevisione, 'Cd_AR' => $dati['Cd_AR']));



                DB::table('ARARMisura')->insert(array('CD_AR' => $dati['Cd_AR'],'Cd_ARMisura' => 'PZ','UMFatt' => 1,'DefaultMisura' => '1','Riga' => 1));
/*
                DB::table('ARARMisura')->insert(array('CD_AR' => $dati['Cd_AR'],'Cd_ARMisura' => 'CN','UMFatt' => $pezzi,'DefaultMisura' => '0','Riga' => 2));

                if($barcode != ''){
                    DB::table('ARAlias')->insert(array('Alias' => $barcode,'Riga' => 1,'Cd_AR' => $dati['Cd_AR']/* ,'Cd_ARMisura' => 'CN'));
                }

                DB::commit();
            } catch (\PDOException $e) {
                //Woopsy
                print_r($e);
                DB::rollBack();
            }



            if($redirect == '') $redirect = 'modifica_articolo/'.$id;
            return Redirect::to($redirect);


        }

        $nuovo_codice = DB::select('SELECT ISNULL(count(*)+1,1) as nuovo_codice from AR')[0]->nuovo_codice;
        $check = DB::select('SELECT * from AR where Cd_AR=\''.$nuovo_codice.'\'');
        while(sizeof($check) != 0 ) {
            $nuovo_codice++;
            $check = DB::select('SELECT * from AR where Cd_AR=\''.$nuovo_codice.'\'');
        }
        return View::make('nuovo_articolo', compact('nuovo_codice'));



    }*/

    public function magazzino(){
        if(!session()->has('utente')) {
            return Redirect::to('login');
        }

        return View::make('magazzino');
    }
    public function passivi(){
        if(!session()->has('utente')) {
            return Redirect::to('login');
        }
        $documenti = DB::select('SELECT * FROM DO WHERE Cd_Do in (\'DCF\') and CliFor = \'F\'');
        return View::make('passivi',compact('documenti'));
    }

    public function attivo(){

        $documenti = DB::select('SELECT * FROM DO WHERE Cd_DO in (\'PKS\',\'OVC\',\'OVS\') and CliFor = \'C\'');
        return View::make('attivo',compact('documenti'));
    }
/*
    public function altri(){

        $documenti = DB::select('SELECT * FROM DO WHERE TipoDocumento in (\'T\') and CliFor = \'F\'');
        return View::make('altri',compact('documenti'));
    }

    public function produzione2($cd_do){

        $cd_cf = 'FPROD';
        $documenti = DB::SELECT('SELECT TOP 10 [NumeroDoc],[DataDoc],[Id_DoTes] FROM DoTes where Cd_DO=\''.$cd_do.'\' and Cd_CF = \''.$cd_cf.'\' order by NumeroDoc desc');
        $numero_documento = DB::select('SELECT MAX(numeroDoc)+1 as num from DOTes where Cd_Do = \''.$cd_do.'\'')[0]->num;
        return View::make('produzione2',compact('documenti', 'cd_do','numero_documento','cd_cf'));
    }

    public function produzione2_tot($cd_do){

        $cd_cf = 'FPROD';
        $documenti = DB::SELECT('SELECT * FROM DoTes where Cd_DO=\''.$cd_do.'\' and Cd_CF = \''.$cd_cf.'\' order by NumeroDoc desc');
        $numero_documento = DB::select('SELECT MAX(numeroDoc)+1 as num from DOTes where Cd_Do = \''.$cd_do.'\'')[0]->num;
        return View::make('produzione2_tot',compact('documenti', 'cd_do','numero_documento','cd_cf'));
    }

    public function produzione3($id_dotes,$id_fornitore,Request $request){

        $dati = $request->all();
        if(isset($dati['elimina_riga'])){
            DB::table('DoRig')->where('Id_DORig',$dati['Id_DORig'])->delete();
        }

        if(isset($dati['esplodi_riga'])){

            $Id_DoRig = $dati['Id_DORig'];
            $Cd_AR = DB::SELECT('SELECT * FROM DoRig WHERE Id_DoRig = \''.$Id_DoRig.'\' ')[0]->Cd_AR;
            /*$Cd_ARLotto = DB::SELECT('SELECT * FROM DoRig WHERE Id_DoRig = \''.$Id_DoRig.'\' ')[0]->Cd_ARLotto;*//*
            $Cd_CF = DB::SELECT('SELECT * FROM DoRig WHERE Id_DoRig = \''.$Id_DoRig.'\' ')[0]->Cd_CF;
            $quantita = DB::SELECT('SELECT * FROM DoRig WHERE Id_DoRig = \''.$Id_DoRig.'\' ')[0]->Qta;
            $Id_DoTes = DB::SELECT('SELECT * FROM DoRig WHERE Id_DoRig = \''.$Id_DoRig.'\' ')[0]->Id_DOTes;
            $Cd_MG_P = DB::SELECT('SELECT * FROM DoRig WHERE Id_DoRig = \''.$Id_DoRig.'\' ')[0]->Cd_MG_P;
            $Cd_MGUbicazione_P = DB::SELECT('SELECT * FROM DoRig WHERE Id_DoRig = \''.$Id_DoRig.'\' ')[0]->Cd_MGUbicazione_P;
            $Id_DB = DB::SELECT('SELECT * FROM DB WHERE Cd_AR = \''.$Cd_AR.'\' ')[0]->Id_DB;
            $esploso = DB::SELECT('SELECT * FROM DBMateriale WHERE Id_DB = \''.$Id_DB.'\' ');
            $Riga = DB::SELECT('SELECT * FROM DoRig WHERE Id_DoRig = \''.$Id_DoRig.'\' ')[0]->Riga;


            foreach($esploso as $e) {

                $consumo = intval($e->Consumo) * $quantita;

                while ($consumo != '0') {

                    $Cd_ARLotto = DB::SELECT('SELECT SUM(QuantitaSign) as Giacenza,Cd_ARLotto from MGMov where Cd_AR= \'' . $e->Cd_AR . '\' and Cd_ARLotto is not null group by Cd_ARLotto order by Giacenza desc');

                    if($Cd_ARLotto!= null)
                        $Cd_ARLotto=$Cd_ARLotto[0]->Cd_ARLotto;

                    $giacenza = DB::SELECT('SELECT SUM(QuantitaSign) as Giacenza,Cd_ARLotto from MGMov where Cd_AR= \'' . $e->Cd_AR . '\' and Cd_ARLotto is not null group by Cd_ARLotto order by Giacenza desc');

                    if($giacenza != null)
                        $giacenza = $giacenza[0]->Giacenza;

                    if($giacenza == null)
                        $giacenza='0';

                    if($giacenza != '0'){
                        if($Cd_ARLotto != null){

                        if(intval($consumo)>(intval($giacenza))) {
                            $insertEsplosione['Qta'] = intval($giacenza);
                            $insertEsplosione['QtaEvadibile'] = intval($giacenza);
                            $consumo = intval($consumo)-intval($giacenza);
                        }else{
                            $insertEsplosione['Qta'] = intval($consumo);
                            $insertEsplosione['QtaEvadibile'] = intval($consumo);
                            $consumo = '0';

                        }
                        $insertEsplosione['Cd_AR'] = $e->Cd_AR;
                        $insertEsplosione['Cd_MG_P'] = $Cd_MG_P;
                        $insertEsplosione['Id_DoTes'] = $Id_DoTes;
                        if ($Cd_MGUbicazione_P != null) {
                            $insertEsplosione['Cd_MGUbicazione_P'] = $Cd_MGUbicazione_P;
                        }
                        if($Cd_ARLotto != null) {
                            $insertEsplosione['Cd_ARLotto'] = $Cd_ARLotto;
                        }
                        $insertEsplosione['TipoPC'] = 'C';
                        $insertEsplosione['Cd_CF'] = $Cd_CF;
                        $insertEsplosione['Riga'] = $Riga;
                        $Id_MgMov = DB::table('DORig')->insertGetId($insertEsplosione);
                        $Id_DoRig1 = DB::SELECT('SELECT * FROM MGMov WHERE Id_MgMov = \''.$Id_MgMov.'\' ')[0]->Id_DoRig;
                        DB::update("Update dorig set dorig.reserved_1= 'RRRRRRRRRR' where dorig.id_dorig = $Id_DoRig1");

                            } $giacenza = '0';
                        }
                        else{
                        $insertEsplosione['Cd_AR'] = $e->Cd_AR;
                        $insertEsplosione['Qta'] = intval($consumo);
                        $insertEsplosione['QtaEvadibile'] = intval($consumo);
                        $insertEsplosione['Cd_MG_P'] = $Cd_MG_P;
                        $insertEsplosione['Id_DoTes'] = $Id_DoTes;
                        if ($Cd_MGUbicazione_P != null)
                            $insertEsplosione['Cd_MGUbicazione_P'] = $Cd_MGUbicazione_P;
                        $insertEsplosione['TipoPC'] = 'C';
                        $insertEsplosione['Cd_CF'] = $Cd_CF;
                        $insertEsplosione['Riga'] = $Riga;
                        unset($insertEsplosione['Cd_ARLotto']);
                        $Id_MgMov = DB::table('DORig')->insertGetId($insertEsplosione);
                        $consumo = '0';

                            $Id_DoRig1 = DB::SELECT('SELECT * FROM MGMov WHERE Id_MgMov = \''.$Id_MgMov.'\' ')[0]->Id_DoRig;
                            DB::update("Update dorig set dorig.reserved_1= 'RRRRRRRRRR' where dorig.id_dorig = $Id_DoRig1");


                    }
                }
            }
            DB::update("Update DORig set TipoPC = 'P' where Id_DORig = '$Id_DoRig'");
            DB::update("Update dotes set dotes.reserved_1= 'RRRRRRRRRR' where dotes.id_dotes = $Id_DoTes exec asp_DO_End $Id_DoTes");
            DB::statement("exec asp_DO_End $Id_DoTes");

        }

        if(isset($dati['modifica_riga'])){

            unset($dati['modifica_riga']);
            $id_riga = $dati['Id_DORig'];
            unset($dati['Id_DORig']);

            list($dati['Cd_MG_A'],$dati['Descrizione'],$dati['Cd_MGUbicazione_A']) = explode(' - ',$dati['magazzino'] );
            unset($dati['magazzino']);
            unset($dati['Descrizione']);

            if($dati['Cd_MGUbicazione_A']=='ND')
            {
                unset($dati['Cd_MGUbicazione_A']);
            }

            if($dati['Cd_ARLotto']=='Nessun Lotto')
            {
                unset($dati['Cd_ARLotto']);
            }

            DB::table('DoRig')->where('Id_DoRig',$id_riga)->update(['Cd_MGUbicazione_A'=>Null]);
            DB::table('DoRig')->where('Id_DoRig',$id_riga)->update(['Cd_ARLotto'=>Null]);

            DB::table('DoRig')->where('Id_DORig',$id_riga)->update($dati);

            DB::update("Update dorig set dorig.reserved_1= 'RRRRRRRRRR' where dorig.id_dorig = $id_riga");
            DB::statement("exec asp_DO_End $id_dotes");

            DB::update("Update dotes set dotes.reserved_1= 'RRRRRRRRRR' where dotes.id_dotes = $id_dotes");
            DB::statement("exec asp_DO_End $id_dotes");

        }
        $fornitori = DB::select('SELECT * from CF where Fornitore = 1 and Cd_CF = \''.$id_fornitore.'\'');
        $documenti = DB::select('SELECT * from DOTes where Id_DoTes = \''.$id_dotes.'\'');
        if(sizeof($fornitori) > 0){
            $fornitore = $fornitori[0];
            $documento = $documenti[0];
            $documento->righe = DB::select('SELECT * from DORig where Id_DoTes = \''.$id_dotes.'\' order by Riga,Id_DoRig asc');
            $documento->totale = 0;
            foreach ($documento->righe as $r)
            {
                $r->lotti = DB::select('SELECT * FROM ARLotto WHERE Cd_AR = \''.$r->Cd_AR.'\' ');
            }

            $totali_documento = DB::select('SELECT * from DoTotali where Id_DoTes = \''.$id_dotes.'\'');
            if(sizeof($totali_documento) > 0) {
                $documento->imponibile = $totali_documento[0]->TotImponibileE;
                $documento->imposta = $totali_documento[0]->TotImpostaE;
                $documento->totale = $totali_documento[0]->TotaPagareE;
            }
            $articolo = DB::select('SELECT Cd_AR from DORig where Id_DoTes = \''.$id_dotes.'\' group by Cd_AR');

            return View::make('produzione3', compact('fornitore', 'id_dotes', 'documento','articolo'));

        }


    }
*/

    public function carico_magazzino(){

        $documenti = DB::select('SELECT * FROM DO WHERE TipoDocumento in (\'O\',\'P\') and CliFor = \'C\'');
        return View::make('carico_magazzino',compact('documenti'));
    }
    public function carico_magazzino1($documenti){


        return View::make('carico_magazzino1');
    }

    public function carico_magazzino2($documenti){
        $fornitori = DB::select('SELECT TOP 10 * from CF where Id_CF in(SELECT r.Id_CF FROM DORig d,Cf r WHERE d.Cd_CF=r.Cd_CF and Cd_DO = \''.$documenti  .'\' and QtaEvadibile > \'0\' and Cd_MGEsercizio =\'2022\' group by r.Id_CF ) and Cliente=\'1\'');
        if(sizeof($fornitori) > 0) {
            $fornitore = $fornitori[0];
            return View::make('carico_magazzino2', compact('documenti','fornitori'));
        }

    }

    public function carico_magazzino02($documenti){
        $fornitori = DB::select('SELECT TOP 10 * from CF where Id_CF in(SELECT r.Id_CF FROM DOTes d,Cf r WHERE d.Cd_CF = r.Cd_CF and Cd_DO = \''.$documenti  .'\' and RigheEvadibili > \'0\' and Cd_MGEsercizio =\'2022\'  group by r.Id_CF ) and Fornitore=\'1\'');
        if(sizeof($fornitori) > 0) {
            return View::make('carico_magazzino02', compact('documenti','fornitori'));
        }else{
            $fornitori = DB::select('SELECT TOP 10 * from CF where  Fornitore=\'1\'');
            return View::make('carico_magazzino02', compact('documenti','fornitori'));

        }

    }

    public function carico_magazzino3($id_fornitore,$cd_do){

        $fornitori = DB::select('SELECT * from CF where Id_CF = '.$id_fornitore.' order by Id_CF desc');
        if(sizeof($fornitori) > 0) {
            $fornitore = $fornitori[0];
            $documenti = DB::select(' SELECT TOP 10 * from DOTes where Cd_CF = \''.$fornitore->Cd_CF.'\' and Cd_DO = \''.$cd_do.'\' and RigheEvadibili > \'0\' order by Id_DOTes DESC');
            $numero_documento = DB::select('SELECT MAX(numeroDoc)+1 as num from DOTes WHERE Cd_MGEsercizio = \'2022\' and Cd_DO = \''.$cd_do.'\' ')[0]->num;
            return View::make('carico_magazzino3',compact('fornitore','documenti','cd_do','numero_documento'));

        }
    }
    public function carico_magazzino3_tot($id_fornitore,$cd_do){

        $fornitori = DB::select('SELECT * from CF where Id_CF = '.$id_fornitore.' order by Id_CF desc');
        if(sizeof($fornitori) > 0) {
            $fornitore = $fornitori[0];
            $documenti = DB::select('SELECT * from DOTes where Cd_CF = \''.$fornitore->Cd_CF.'\' and Cd_DO = \''.$cd_do.'\' and RigheEvadibili > \'0\' order by Id_DOTes DESC');
            $numero_documento = DB::select('SELECT MAX(numeroDoc)+1 as num from DOTes WHERE Cd_MGEsercizio = \'2022\' and Cd_DO = \''.$cd_do.'\'  ')[0]->num;
            return View::make('carico_magazzino3_tot',compact('fornitore','documenti','cd_do','numero_documento'));

        }
    }

    public function carico_magazzino03($id_fornitore,$cd_do){
        $cond='';
        $fornitori = DB::select('SELECT * from CF where Id_CF = '.$id_fornitore.' order by Id_CF desc');
        if(sizeof($fornitori) > 0) {
            $fornitore = $fornitori[0];
            $documenti = DB::select('SELECT TOP 10 [Id_DoTes],[NumeroDoc],[DataDoc],[NumeroDocRif],[DataDocRif]  from DOTes where Cd_CF = \''.$fornitore->Cd_CF.'\' and Cd_DO = \''.$cd_do.'\'  AND  DATEDIFF(DAY,GETDATE(),TimeIns) > -7 order by Id_DOTes DESC');
            $numero_documento = DB::select('SELECT MAX(numeroDoc)+1 as num from DOTes WHERE Cd_MGEsercizio = \'2022\' and Cd_DO = \''.$cd_do.'\'')[0]->num;
            $dodo = DB::SELECT('select * from DODOPrel where Cd_DO = \''.$cd_do.'\'');
            foreach ($dodo as $d){
                $cond .=', \''.$d->Cd_DO_Prelevabile.'\' ';
            }
            $doc_evadi = DB::SELECT('SELECT * FROM DoTes where Cd_CF = \''.$fornitore->Cd_CF.'\' and Cd_DO in (\'\''.$cond.') and RigheEvadibili >\'0\' order by Id_DoTes desc ');
            return View::make('carico_magazzino03',compact('fornitore','documenti','cd_do','numero_documento','doc_evadi','id_fornitore'));

        }
    }
    public function carico_magazzino03_tot($id_fornitore,$cd_do){
        $cond = '';
        $fornitori = DB::select('SELECT * from CF where Id_CF = '.$id_fornitore.' order by Id_CF desc');
        if(sizeof($fornitori) > 0) {
            $fornitore = $fornitori[0];
            $documenti = DB::select('SELECT * from DOTes where Cd_CF = \''.$fornitore->Cd_CF.'\' and Cd_DO = \''.$cd_do.'\' AND  DATEDIFF(DAY,GETDATE(),TimeIns) > -7 order by Id_DOTes DESC');
            $numero_documento = DB::select('SELECT MAX(numeroDoc)+1 as num from DOTes WHERE Cd_MGEsercizio = \'2022\' and Cd_DO = \''.$cd_do.'\' ')[0]->num;
            $dodo = DB::SELECT('select * from DODOPrel where Cd_DO = \''.$cd_do.'\'');
            foreach ($dodo as $d){
                $cond .=', \''.$d->Cd_DO_Prelevabile.'\' ';
            }
            $doc_evadi = DB::SELECT('SELECT * FROM DoTes where Cd_CF = \''.$fornitore->Cd_CF.'\' and Cd_DO in (\'\''.$cond.')  and RigheEvadibili >\'0\' order by Id_DoTes desc ');

            return View::make('carico_magazzino03_tot',compact('fornitore','documenti','cd_do','numero_documento','doc_evadi','id_fornitore'));

        }
    }
/*
    public function trasporto_fornitore($documenti){

        $fornitore = DB::select('SELECT * FROM Cf where Cd_CF in (\'F000143\',\'F000765\') Order By Id_Cf DESC');

        return View::make('trasporto_fornitore',compact('fornitore','documenti'));
    }
    public function trasporto_documento($cd_do,$cd_cf){

        $documenti = DB::SELECT('SELECT TOP 10 [NumeroDoc],[DataDoc],[Id_DoTes] FROM DoTes where Cd_DO=\''.$cd_do.'\' and Cd_CF = \''.$cd_cf.'\' order by NumeroDoc desc');
        $numero_documento = DB::select('SELECT MAX(numeroDoc)+1 as num from DOTes where Cd_Do = \''.$cd_do.'\'')[0]->num;


        return View::make('trasporto_documento',compact('documenti', 'cd_do','numero_documento','cd_cf'));
    }
    public function trasporto_documento_tot($cd_do,$cd_cf){

    $documenti = DB::SELECT('SELECT * FROM DoTes where Cd_DO=\''.$cd_do.'\' and Cd_CF = \''.$cd_cf.'\' order by NumeroDoc desc');
    $numero_documento = DB::select('SELECT MAX(numeroDoc)+1 as num from DOTes where Cd_Do = \''.$cd_do.'\'')[0]->num;


    return View::make('trasporto_documento_tot',compact('documenti', 'cd_do','numero_documento','cd_cf'));
}
    public function trasporto_magazzino($documenti,$Cd_Cf,$Id_DoTes){

        $articoli = DB::select('SELECT TOP 10 ar.[Id_AR],ar.[Cd_AR],ar.[Descrizione],ARLotto.[Cd_ARLotto] FROM AR LEFT JOIN ARLotto ON ar.Cd_AR = ARLotto.Cd_AR Order By Id_AR DESC');

        return View::make('trasporto',compact('articoli','documenti','Cd_Cf', 'Id_DoTes'));
    }

    public function trasporto_magazzino2($Cd_AR,$cd_do,$Cd_Cf,$Id_DoTes,$lotto){

        $where=' and ';
        if($lotto!='0')
        {
            $where .= 'MGMov.Cd_ARLotto = \''.$lotto .'\' and ';
        }
        $default  = DB::select('SELECT SUM(MGMov.QuantitaSign) as Giacenza,MGMov.Cd_MGUbicazione, m.Cd_Mg , m.Descrizione, MGMov.Cd_ARLotto FROM MGMov LEFT JOIN MG m ON m.Cd_MG = MGMov.Cd_Mg WHERE MGMov.Cd_AR = \''.$Cd_AR.'\' '.$where.' Mgmov.Cd_MG in (select Cd_MG_P from MGCausale where Cd_MGCausale=\''.$cd_do.'\')GROUP BY m.cd_mg,m.Descrizione,MGMov.Cd_MGUbicazione, MGMov.Cd_ARLotto ORDER BY Giacenza DESC');

        $giacenza = DB::select('SELECT SUM(MGMov.QuantitaSign) as Giacenza,MGMov.Cd_MGUbicazione, m.Cd_Mg , m.Descrizione, MGMov.Cd_ARLotto FROM MGMov LEFT JOIN MG m ON m.Cd_MG = MGMov.Cd_Mg WHERE MGMov.Cd_AR = \''.$Cd_AR.'\' '.$where.' Mgmov.Cd_MG !=(select Cd_MG_P from MGCausale where Cd_MGCausale=\''.$cd_do.'\')GROUP BY m.cd_mg,m.Descrizione,MGMov.Cd_MGUbicazione, MGMov.Cd_ARLotto ORDER BY Giacenza DESC  ');


        return View::make('trasporto_magazzino2',compact('Cd_AR','cd_do','Cd_Cf','giacenza','default', 'Id_DoTes','lotto'));

    }
    public function trasporto_magazzino2_tot($Cd_AR,$cd_do,$Cd_Cf,$Id_DoTes,$lotto){

        $where=' and ';
        if($lotto!='0')
        {
            $where .= 'MGMov.Cd_ARLotto = \''.$lotto .'\' and ';
        }

        $default  = DB::select('SELECT SUM(MGMov.QuantitaSign) as Giacenza,MGMov.Cd_MGUbicazione, m.Cd_Mg , m.Descrizione, MGMov.Cd_ARLotto FROM MGMov LEFT JOIN MG m ON m.Cd_MG = MGMov.Cd_Mg WHERE MGMov.Cd_AR = \''.$Cd_AR.'\' '.$where.' Mgmov.Cd_MG in (select Cd_MG_P from MGCausale where Cd_MGCausale=\''.$cd_do.'\')GROUP BY m.cd_mg,m.Descrizione,MGMov.Cd_MGUbicazione, MGMov.Cd_ARLotto ORDER BY Giacenza DESC');

        $giacenza = DB::select('SELECT SUM(MGMov.QuantitaSign) as Giacenza,MGMov.Cd_MGUbicazione, m.Cd_Mg , m.Descrizione, MGMov.Cd_ARLotto FROM MGMov LEFT JOIN MG m ON m.Cd_MG = MGMov.Cd_Mg WHERE MGMov.Cd_AR = \''.$Cd_AR.'\' '.$where.' Mgmov.Cd_MG !=(select Cd_MG_P from MGCausale where Cd_MGCausale=\''.$cd_do.'\')GROUP BY m.cd_mg,m.Descrizione,MGMov.Cd_MGUbicazione, MGMov.Cd_ARLotto ORDER BY Giacenza DESC  ');


        return View::make('trasporto_magazzino2_tot',compact('Cd_AR','cd_do','Cd_Cf','giacenza','default', 'Id_DoTes','lotto'));

    }
    public function trasporto_magazzino3($Cd_AR,$cd_do,$Cd_Cf,$Cd_MG,$Cd_MGUbicazione,$Cd_ARLotto,$Id_DoTes){

        $where = '';

        $default  = DB::select('SELECT SUM(MGMov.QuantitaSign) as Giacenza, m.Cd_Mg , m.Descrizione , MGMov.Cd_MGUbicazione FROM MGMov LEFT JOIN MG m ON m.Cd_MG = MGMov.Cd_Mg WHERE MGMov.Cd_AR = \''.$Cd_AR.'\' and   (MGMov.Cd_MGUbicazione!=\''.$Cd_MGUbicazione.'\' or mgmov.Cd_MGUbicazione is null)and m.Cd_MG in (select Cd_MG_A from MGCausale where Cd_MGCausale=\''.$cd_do.'\')GROUP BY m.cd_mg,m.Descrizione,MGMov.Cd_MGUbicazione ORDER BY Giacenza asc');
        foreach($default as $g) { if($g->Cd_MGUbicazione != null){$where.=' and (m.Cd_MG != \''.$g->Cd_Mg.'\' or MGUbicazione.Cd_MGUbicazione !=\''.$g->Cd_MGUbicazione.'\')  ';}else {$where.=' and (m.Cd_MG != \''.$g->Cd_Mg.'\' or MGUbicazione.Cd_MGUbicazione != \'0\' )  ';}}
        $default1 = DB::select('SELECT  m.Cd_Mg , m.Descrizione, MGUbicazione.Cd_MGUbicazione  FROM MGMov LEFT JOIN MG m ON m.Cd_MG = MGMov.Cd_Mg LEFT JOIN MGUbicazione ON MGMov.Cd_MG = MGUbicazione.Cd_Mg WHERE MGMov.Cd_AR != \'' . $Cd_AR . '\' '.$where.'  and m.Cd_MG in (select Cd_MG_A from MGCausale where Cd_MGCausale=\''.$cd_do.'\') GROUP BY m.cd_mg,m.Descrizione,MGUbicazione.Cd_MGUbicazione ORDER BY m.cd_mg ASC');


        $giacenza = DB::select('SELECT SUM(MGMov.QuantitaSign) as Giacenza, m.Cd_Mg , m.Descrizione , MGMov.Cd_MGUbicazione FROM MGMov LEFT JOIN MG m ON m.Cd_MG = MGMov.Cd_Mg WHERE MGMov.Cd_AR = \''.$Cd_AR.'\' and m.Cd_MG !=\''.$Cd_MG.'\'and (MGMov.Cd_MGUbicazione!=\''.$Cd_MGUbicazione.'\' or MGMov.Cd_MGUbicazione is null) GROUP BY m.cd_mg,m.Descrizione,MGMov.Cd_MGUbicazione ORDER BY Giacenza asc');

        foreach($giacenza as $g) { if($g->Cd_MGUbicazione != null){$where.=' and (m.Cd_MG != \''.$g->Cd_Mg.'\' or MGUbicazione.Cd_MGUbicazione !=\''.$g->Cd_MGUbicazione.'\')  ';}else {$where.=' and (m.Cd_MG != \''.$g->Cd_Mg.'\' or MGUbicazione.Cd_MGUbicazione != \'0\' )  ';}}

        $magazzini = DB::select('SELECT  m.Cd_Mg , m.Descrizione, MGUbicazione.Cd_MGUbicazione  FROM MGMov LEFT JOIN MG m ON m.Cd_MG = MGMov.Cd_Mg LEFT JOIN MGUbicazione ON MGMov.Cd_MG = MGUbicazione.Cd_Mg WHERE MGMov.Cd_AR != \'' . $Cd_AR . '\' '.$where.' and m.Cd_MG != \''.$Cd_MG.'\'  GROUP BY m.cd_mg,m.Descrizione,MGUbicazione.Cd_MGUbicazione ORDER BY m.cd_mg ASC');


        return View::make('trasporto_magazzino3',compact('Cd_AR','Cd_MG','cd_do','Cd_Cf','giacenza','Cd_MGUbicazione','magazzini','Cd_ARLotto','default','default1', 'Id_DoTes'));

    }
    public function trasporto_magazzino3_tot($Cd_AR,$cd_do,$Cd_Cf,$Cd_MG,$Cd_MGUbicazione,$Cd_ARLotto,$Id_DoTes){

        $where = '';

        $default  = DB::select('SELECT SUM(MGMov.QuantitaSign) as Giacenza, m.Cd_Mg , m.Descrizione , MGMov.Cd_MGUbicazione FROM MGMov LEFT JOIN MG m ON m.Cd_MG = MGMov.Cd_Mg WHERE MGMov.Cd_AR = \''.$Cd_AR.'\' and   (MGMov.Cd_MGUbicazione!=\''.$Cd_MGUbicazione.'\' or mgmov.Cd_MGUbicazione is null)and m.Cd_MG in (select Cd_MG_A from MGCausale where Cd_MGCausale=\''.$cd_do.'\')GROUP BY m.cd_mg,m.Descrizione,MGMov.Cd_MGUbicazione ORDER BY Giacenza asc');
        foreach($default as $g) { if($g->Cd_MGUbicazione != null){$where.=' and (m.Cd_MG != \''.$g->Cd_Mg.'\' or MGUbicazione.Cd_MGUbicazione !=\''.$g->Cd_MGUbicazione.'\')  ';}else {$where.=' and (m.Cd_MG != \''.$g->Cd_Mg.'\' or MGUbicazione.Cd_MGUbicazione != \'0\' )  ';}}
        $default1 = DB::select('SELECT  m.Cd_Mg , m.Descrizione, MGUbicazione.Cd_MGUbicazione  FROM MGMov LEFT JOIN MG m ON m.Cd_MG = MGMov.Cd_Mg LEFT JOIN MGUbicazione ON MGMov.Cd_MG = MGUbicazione.Cd_Mg WHERE MGMov.Cd_AR != \'' . $Cd_AR . '\' '.$where.'  and m.Cd_MG in (select Cd_MG_A from MGCausale where Cd_MGCausale=\''.$cd_do.'\') GROUP BY m.cd_mg,m.Descrizione,MGUbicazione.Cd_MGUbicazione ORDER BY m.cd_mg ASC');


        $giacenza = DB::select('SELECT SUM(MGMov.QuantitaSign) as Giacenza, m.Cd_Mg , m.Descrizione , MGMov.Cd_MGUbicazione FROM MGMov LEFT JOIN MG m ON m.Cd_MG = MGMov.Cd_Mg WHERE MGMov.Cd_AR = \''.$Cd_AR.'\' and m.Cd_MG !=\''.$Cd_MG.'\'and (MGMov.Cd_MGUbicazione!=\''.$Cd_MGUbicazione.'\' or MGMov.Cd_MGUbicazione is null) GROUP BY m.cd_mg,m.Descrizione,MGMov.Cd_MGUbicazione ORDER BY Giacenza asc');

        foreach($giacenza as $g) { if($g->Cd_MGUbicazione != null){$where.=' and (m.Cd_MG != \''.$g->Cd_Mg.'\' or MGUbicazione.Cd_MGUbicazione !=\''.$g->Cd_MGUbicazione.'\')  ';}else {$where.=' and (m.Cd_MG != \''.$g->Cd_Mg.'\' or MGUbicazione.Cd_MGUbicazione != \'0\' )  ';}}

        $magazzini = DB::select('SELECT  m.Cd_Mg , m.Descrizione, MGUbicazione.Cd_MGUbicazione  FROM MGMov LEFT JOIN MG m ON m.Cd_MG = MGMov.Cd_Mg LEFT JOIN MGUbicazione ON MGMov.Cd_MG = MGUbicazione.Cd_Mg WHERE MGMov.Cd_AR != \'' . $Cd_AR . '\' '.$where.' and m.Cd_MG != \''.$Cd_MG.'\'  GROUP BY m.cd_mg,m.Descrizione,MGUbicazione.Cd_MGUbicazione ORDER BY m.cd_mg ASC');


        return View::make('trasporto_magazzino3_tot',compact('Cd_AR','Cd_MG','cd_do','Cd_Cf','giacenza','Cd_MGUbicazione','magazzini','Cd_ARLotto','default','default1', 'Id_DoTes'));

    }

    public function trasporto_magazzino4($Cd_Do,$Cd_Cf,$Cd_MG,$Cd_Mg_A,$Id_DoTes, request $request){

        $dati = $request->all();
        if(isset($dati['elimina_riga'])){
            DB::table('DoRig')->where('Id_DORig',$dati['Id_DORig'])->delete();
        }
        if(isset($dati['modifica_riga'])){

            unset($dati['modifica_riga']);
            $id_riga = $dati['Id_DORig'];
            $dati['QtaEvadibile']=$dati['Qta'];
            unset($dati['Id_DORig']);


            DB::table('DoRig')->where('Id_DORig',$id_riga)->update($dati);

            DB::update("Update dotes set dotes.reserved_1= 'RRRRRRRRRR' where dotes.id_dotes = $Id_DoTes");
            DB::statement("exec asp_DO_End $Id_DoTes");
        }



        $doc = DB::Select('SELECT * FROM DoRig where Id_DoTes = \''.$Id_DoTes.'\'');

        if(sizeof($doc) > 0) {
            $Cd_Cf = DB::SELECT('SELECT * FROM CF WHERE Cd_CF = \''.$Cd_Cf.'\' ')[0];
            $docu = $doc[0];
            $docu->righe = DB::select('SELECT * from DORig where Id_DoTes = \'' . $Id_DoTes . '\'');
            return View::make('trasporto_magazzino4', compact( 'Cd_Do', 'Cd_Cf', 'Cd_MG',  'Cd_Mg_A', 'Id_DoTes', 'doc','docu'));

        }
        $Cd_Cf = DB::SELECT('SELECT * FROM CF WHERE Cd_CF = \''.$Cd_Cf.'\' ')[0];
            return View::make('trasporto_magazzino4', compact( 'Cd_Do', 'Cd_Cf', 'Cd_MG',  'Cd_Mg_A',  'Id_DoTes', 'doc'));

}
*/
    public function carico_magazzino4($id_fornitore,$id_dotes,Request $request){
        if(!session()->has('utente')) {
            return Redirect::to('login');
        }
        $dati = $request->all();
        if(isset($dati['elimina_riga'])){
            DB::table('DoRig')->where('Id_DORig',$dati['Id_DORig'])->delete();
        }
        if(isset($dati['modifica_riga'])){

            unset($dati['modifica_riga']);
            $id_riga = $dati['Id_DORig'];
            unset($dati['Id_DORig']);
            unset($dati['modal_lotto_m']);/*
            $dati['Cd_MGUbicazione_A'] = $dati['modal_ubicazione_A_m'];
            unset($dati['modal_ubicazione_A_m']);

            if($dati['Cd_MGUbicazione_A']=='')
            {
                unset($dati['Cd_MGUbicazione_A']);
            }*/


            DB::table('DoRig')->where('Id_DoRig',$id_riga)->update(['Cd_ARLotto'=>Null]);
            DB::table('DoRig')->where('Id_DoRig',$id_riga)->update(['Cd_MGUbicazione_A'=>Null]);

            DB::table('DoRig')->where('Id_DORig',$id_riga)->update($dati);

            DB::update("Update dotes set dotes.reserved_1= 'RRRRRRRRRR' where dotes.id_dotes = $id_dotes");
            DB::statement("exec asp_DO_End $id_dotes");
        }

        $fornitori= DB::select('SELECT * from CF where Id_CF = '.$id_fornitore);
        $documenti = DB::select('SELECT * from DOTes where Id_DoTes in ('.$id_dotes.')');
        $cd_do = DB::select('SELECT * from DOTes where Id_DoTes  in ('.$id_dotes.')')[0]->Cd_Do;
        if(sizeof($fornitori) > 0){
            $fornitore = $fornitori[0];
            $date = date('Y/m/d',strtotime('today')) ;
            foreach($documenti as $documento)
                $documento->righe = DB::select('SELECT * from DORig where Id_DoTes in ('.$id_dotes.') and Qta > \'0\' ORDER BY QtaEvadibile DESC');

            foreach ($documento->righe as $r)
            {
                $r->lotti = DB::select('SELECT * FROM ARLotto WHERE Cd_AR = \''.$r->Cd_AR.'\' AND DataScadenza > \''.$date.'\' ORDER BY TimeIns DESC');
            }
            $righe = DB::select('SELECT count(Riga) as Righe from DORig where Id_DoTes in ('.$id_dotes.') and QtaEvadibile > \'0\'')[0]->Righe;
            /* $totali_documento = DB::select('SELECT * from DoTotali where Id_DoTes = \''.$id_dotes.'\'');
             if(sizeof($totali_documento) > 0) {
                 $documento->imponibile = $totali_documento[0]->TotImponibileE;
                 $documento->imposta = $totali_documento[0]->TotImpostaE;
                 $documento->totale = $totali_documento[0]->TotaPagareE;
             }*/
            $articolo = DB::select('SELECT Cd_AR from DORig where Id_DoTes in ('.$id_dotes.') group by Cd_AR');
            $flusso= DB::SELECT('select * from DODOPrel where Cd_DO_Prelevabile =\''.$cd_do.'\'  ');
            return View::make('carico_magazzino4', compact('fornitore', 'id_dotes', 'documento','articolo','flusso','righe'));

        }

    }

    public function carico_magazzino00($articolo,$id_dotes,Request $request){
        if(!session()->has('utente')) {
            return Redirect::to('login');
        }
        $dati = $request->all();
        if(isset($dati['elimina_riga'])){
            DB::table('DoRig')->where('Id_DORig',$dati['Id_DORig'])->delete();
        }
        if(isset($dati['modifica_riga'])){

            unset($dati['modifica_riga']);
            $id_riga = $dati['Id_DORig'];
            unset($dati['Id_DORig']);
            unset($dati['modal_lotto_m']);/*
            $dati['Cd_MGUbicazione_A'] = $dati['modal_ubicazione_A_m'];
            unset($dati['modal_ubicazione_A_m']);

            if($dati['Cd_MGUbicazione_A']=='')
            {
                unset($dati['Cd_MGUbicazione_A']);
            }*/


            DB::table('DoRig')->where('Id_DoRig',$id_riga)->update(['Cd_ARLotto'=>Null]);
            DB::table('DoRig')->where('Id_DoRig',$id_riga)->update(['Cd_MGUbicazione_A'=>Null]);

            DB::table('DoRig')->where('Id_DORig',$id_riga)->update($dati);

            DB::update("Update dotes set dotes.reserved_1= 'RRRRRRRRRR' where dotes.id_dotes = $id_dotes");
            DB::statement("exec asp_DO_End $id_dotes");
        }
        $articolo =  str_replace("-","/",$articolo);
        $articolo =  str_replace("slash","/",$articolo);
        $documenti = DB::select('SELECT * from DOTes where Id_DoTes in ('.$id_dotes.')');
        $fornitori= DB::select('SELECT * from CF where Cd_CF = \''.$documenti[0]->Cd_CF.'\'');
        $cd_do = DB::select('SELECT * from DOTes where Id_DoTes  in ('.$id_dotes.')')[0]->Cd_Do;
        if(sizeof($fornitori) > 0){
            $fornitore = $fornitori[0];
            $date = date('Y/m/d',strtotime('today')) ;
            foreach($documenti as $documento)
                $documento->righe = DB::select('SELECT DORig.*,CF.Descrizione as DescrizioneCF from DORig LEFT JOIN CF ON DORig.Cd_CF = Cf.Cd_CF where Id_DoTes in ('.$id_dotes.') and Cd_AR = \''.$articolo.'\' and QtaEvadibile > \'0\' ORDER BY QtaEvadibile DESC');

            foreach ($documento->righe as $r)
            {
                $r->lotti = DB::select('SELECT * FROM ARLotto WHERE Cd_AR = \''.$r->Cd_AR.'\' AND DataScadenza > \''.$date.'\' ORDER BY TimeIns DESC');
            }
            $righe = DB::select('SELECT count(Riga) as Righe from DORig where Id_DoTes in ('.$id_dotes.') and Cd_AR = \''.$articolo.'\' and QtaEvadibile > \'0\'')[0]->Righe;
            $flusso= DB::SELECT('select * from DODOPrel where Cd_DO_Prelevabile =\''.$cd_do.'\'  ');
            $giacenza = DB::SELECT('SELECT SUM(QuantitaSign) as Giacenza FROM MGMov WHERE Cd_AR = \''.$articolo.'\' and Cd_MGEsercizio = \'2022\'')[0]->Giacenza;
            return View::make('carico_magazzino00', compact('fornitore', 'id_dotes', 'documento','articolo','flusso','righe','giacenza'));

        }

    }

    public function carico_magazzino04($id_fornitore,$id_dotes,Request $request){
        if(!session()->has('utente')) {
            return Redirect::to('login');
        }
        $dati = $request->all();
        if(isset($dati['elimina_riga'])){
            DB::table('DoRig')->where('Id_DORig',$dati['Id_DORig'])->delete();
        }
        if(isset($dati['modifica_riga'])){

            unset($dati['modifica_riga']);
            $id_riga = $dati['Id_DORig'];
            unset($dati['Id_DORig']);

            unset($dati['modal_lotto_m']);
            if($dati['modal_ubicazione_A_m'] != '0' ) {
                $dati['Cd_MGUbicazione_A'] = $dati['modal_ubicazione_A_m'];

                if ($dati['Cd_MGUbicazione_A'] == '') {
                    unset($dati['Cd_MGUbicazione_A']);
                }
            }
            unset($dati['modal_ubicazione_A_m']);

            DB::table('DoRig')->where('Id_DoRig',$id_riga)->update(['Cd_ARLotto'=>Null]);
            DB::table('DoRig')->where('Id_DoRig',$id_riga)->update(['Cd_MGUbicazione_A'=>Null]);

            DB::table('DoRig')->where('Id_DORig',$id_riga)->update($dati);

            DB::update("Update dotes set dotes.reserved_1= 'RRRRRRRRRR' where dotes.id_dotes = $id_dotes");
            DB::statement("exec asp_DO_End $id_dotes");
        }
        $fornitori= DB::select('SELECT * from CF where Id_CF = '.$id_fornitore);
        $documenti = DB::select('SELECT * from DOTes where Id_DoTes in ('.$id_dotes.')');
        $cd_do = DB::select('SELECT * from DOTes where Id_DoTes  in ('.$id_dotes.')')[0]->Cd_Do;
        if(sizeof($fornitori) > 0){
            $fornitore = $fornitori[0];
            $date = date('Y/m/d',strtotime('today')) ;
            foreach($documenti as $documento)
                $documento->righe = DB::select('SELECT * from DORig where Id_DoTes in ('.$id_dotes.') and Qta > \'0\'  ORDER BY QtaEvadibile DESC');

            foreach ($documento->righe as $r)
            {
                $r->lotti = DB::select('SELECT * FROM ARLotto WHERE Cd_AR = \''.$r->Cd_AR.'\'  AND DataScadenza > \''.$date.'\' ORDER BY TimeIns DESC ');
            }

            /* $totali_documento = DB::select('SELECT * from DoTotali where Id_DoTes = \''.$id_dotes.'\'');
             if(sizeof($totali_documento) > 0) {
                 $documento->imponibile = $totali_documento[0]->TotImponibileE;
                 $documento->imposta = $totali_documento[0]->TotImpostaE;
                 $documento->totale = $totali_documento[0]->TotaPagareE;
             }*/
            $articolo = DB::select('SELECT Cd_AR from DORig where Id_DoTes in ('.$id_dotes.') group by Cd_AR');
            $flusso= DB::SELECT('select * from DODOPrel where Cd_DO_Prelevabile =\''.$cd_do.'\'  ');

            return View::make('carico_magazzino04', compact('fornitore', 'id_dotes', 'documento','articolo'));

        }


    }
    /*
        public function scarico_magazzino(){
            $clienti = DB::select('SELECT * from CF where Cliente = 1 and Descrizione != \'\' order by Id_CF desc');
            return View::make('scarico_magazzino',compact('clienti'));
        }

        public function scarico_magazzino1(){
            $clienti = DB::select('SELECT * from CF where Cliente = 1 and Descrizione != \'\' order by Id_CF desc');
            return View::make('scarico_magazzino1',compact('clienti'));
        }


        public function scarico_magazzino2($documenti){

            $fornitori = DB::select('SELECT TOP 10 * from CF where Id_CF in(SELECT r.Id_CF FROM DORig d,Cf r WHERE d.Cd_CF=r.Cd_CF and Cd_DO = \''.$documenti  .'\' and QtaEvadibile != \'0\' group by r.Id_CF ) and Cliente = \'1\' order by Id_CF desc');

            if(sizeof($fornitori) > 0) {
                $fornitore = $fornitori[0];
                return View::make('scarico_magazzino2', compact('documenti','fornitori'));
            }

        }

        public function scarico_magazzino02($documenti){
            $fornitori = DB::select('SELECT TOP 10 * from CF where Id_CF in(SELECT r.Id_CF FROM DORig d,Cf r WHERE d.Cd_CF=r.Cd_CF and Cd_DO = \''.$documenti  .'\' and QtaEvadibile != \'0\' group by r.Id_CF ) and Cliente = \'1\' order by Id_CF desc');
            if(sizeof($fornitori) > 0) {
                $fornitore = $fornitori[0];
                return View::make('scarico_magazzino02', compact('documenti','fornitori'));
            }

        }



            public function carico_magazzino2($documenti){

            $fornitori = DB::select('SELECT * from CF where id_cf in(SELECT r.Id_CF FROM DORig d,Cf r WHERE d.Cd_CF=r.Cd_CF and TipoDocumento = \'P\' and QtaEvadibile != \'0\' group by r.Id_CF ) order by Id_CF desc');
            if(sizeof($fornitori) > 0) {
                $fornitore = $fornitori[0];
                return View::make('carico_magazzino2', compact('documenti','fornitori'));
            }

        }

        public function carico_magazzino02($documenti){

            $fornitori = DB::select('SELECT * from CF where id_cf in(SELECT r.Id_CF FROM DORig d,Cf r WHERE d.Cd_CF=r.Cd_CF and TipoDocumento = \'P\' and QtaEvadibile != \'0\' group by r.Id_CF ) order by Id_CF desc');
            if(sizeof($fornitori) > 0) {
                $fornitore = $fornitori[0];
                return View::make('carico_magazzino02', compact('documenti','fornitori'));
            }

        }

        public function scarico_magazzino2($id_cliente){

            $documenti = DB::select('SELECT * from DO where CliFor = \'C\' and TipoDocumento IN(\'O\')');
            $clienti = DB::select('SELECT * from CF where Id_CF = '.$id_cliente.' order by Id_CF desc');
            if(sizeof($clienti) > 0) {
                $cliente = $clienti[0];
                return View::make('scarico_magazzino2', compact('documenti','cliente'));
            }
        }

        public function scarico_magazzino02($id_cliente){

            $documenti = DB::select('SELECT * from DO where CliFor = \'C\' and TipoDocumento IN(\'B\')');
            $clienti = DB::select('SELECT * from CF where Id_CF = '.$id_cliente.' order by Id_CF desc');
            if(sizeof($clienti) > 0) {
                $cliente = $clienti[0];
                return View::make('scarico_magazzino02', compact('documenti','cliente'));
            }
        }

    public function scarico_magazzino3($id_cliente,$cd_do){

        $clienti = DB::select('SELECT * from CF where Id_CF = '.$id_cliente.' order by Id_CF desc');
        if(sizeof($clienti) > 0) {
            $cliente = $clienti[0];
            $documenti = DB::select('SELECT TOP 10 [Id_DoTes],[NumeroDoc],[DataDoc],[NumeroDocRif],[DataDocRif] from DOTes where Cd_CF = \''.$cliente->Cd_CF.'\' and Cd_DO = \''.$cd_do.'\' order by Id_DOTes DESC');
            $numero_documento = DB::select('SELECT MAX(numeroDoc)+1 as num from DOTes where Cd_Do = \''.$cd_do.'\'')[0]->num;
            return View::make('scarico_magazzino3',compact('cliente','documenti','cd_do','numero_documento'));

        }
    }

    public function scarico_magazzino03($id_cliente,$cd_do){

        $clienti = DB::select('SELECT * from CF where Id_CF = '.$id_cliente.' order by Id_CF desc');
        if(sizeof($clienti) > 0) {
            $cliente = $clienti[0];
            $documenti = DB::select('SELECT TOP 10 [Id_DoTes],[NumeroDoc],[DataDoc],[NumeroDocRif],[DataDocRif] from DOTes where Cd_CF = \''.$cliente->Cd_CF.'\' and Cd_DO = \''.$cd_do.'\' order by Id_DOTes DESC');
            $numero_documento = DB::select('SELECT MAX(numeroDoc)+1 as num from DOTes where Cd_Do = \''.$cd_do.'\'')[0]->num;
            $doc_evadi = DB::SELECT('SELECT * FROM DoTes where Cd_CF = \''.$cliente->Cd_CF.'\' and Cd_DO=\'OVC\' and RigheEvadibili >\'0\' order by Id_DoTes desc ');

            return View::make('scarico_magazzino03',compact('cliente','documenti','cd_do','numero_documento','doc_evadi','id_cliente'));

        }
    }
    public function scarico_magazzino3_tot($id_cliente,$cd_do){

    $clienti = DB::select('SELECT * from CF where Id_CF = '.$id_cliente.' order by Id_CF desc');
    if(sizeof($clienti) > 0) {
        $cliente = $clienti[0];
        $documenti = DB::select('SELECT * from DOTes where Cd_CF = \''.$cliente->Cd_CF.'\' and Cd_DO = \''.$cd_do.'\' order by Id_DOTes DESC');
        $numero_documento = DB::select('SELECT MAX(numeroDoc)+1 as num from DOTes where Cd_Do = \''.$cd_do.'\'')[0]->num;
        return View::make('scarico_magazzino3_tot',compact('cliente','documenti','cd_do','numero_documento'));

    }
}

    public function scarico_magazzino03_tot($id_cliente,$cd_do){

        $clienti = DB::select('SELECT * from CF where Id_CF = '.$id_cliente.' order by Id_CF desc');
        if(sizeof($clienti) > 0) {
            $cliente = $clienti[0];
            $documenti = DB::select('SELECT * from DOTes where Cd_CF = \''.$cliente->Cd_CF.'\' and Cd_DO = \''.$cd_do.'\' order by Id_DOTes DESC');
            $numero_documento = DB::select('SELECT MAX(numeroDoc)+1 as num from DOTes where Cd_Do = \''.$cd_do.'\'')[0]->num;
            $doc_evadi = DB::SELECT('SELECT * FROM DoTes where Cd_CF = \''.$cliente->Cd_CF.'\' and Cd_DO=\'OVC\' and RigheEvadibili >\'0\' order by Id_DoTes desc ');

            return View::make('scarico_magazzino03_tot',compact('cliente','documenti','cd_do','numero_documento','doc_evadi','id_cliente'));

        }
    }

    public function scarico_magazzino4($id_cliente,$id_dotes,Request $request){

        $dati = $request->all();
        if(isset($dati['elimina_riga'])){
            DB::table('DoRig')->where('Id_DORig',$dati['Id_DORig'])->delete();
            DB::update("Update dotes set dotes.reserved_1= 'RRRRRRRRRR' where dotes.id_dotes = $id_dotes");
            DB::statement("exec asp_DO_End $id_dotes");
        }

        if(isset($dati['modifica_riga'])){

            unset($dati['modifica_riga']);
            $id_riga = $dati['Id_DORig'];
            unset($dati['Id_DORig']);

            list($dati['Cd_MG_P'],$dati['Descrizione'],$dati['Cd_MGUbicazione_P']) = explode(' - ',$dati['magazzino'] );
            unset($dati['magazzino']);
            unset($dati['Descrizione']);

            if($dati['Cd_MGUbicazione_P']=='ND')
            {
                unset($dati['Cd_MGUbicazione_P']);
            }

            if($dati['Cd_ARLotto']=='Nessun Lotto')
            {
                unset($dati['Cd_ARLotto']);
            }

            DB::table('DoRig')->where('Id_DoRig',$id_riga)->update(['Cd_MGUbicazione_P'=>Null]);
            DB::table('DoRig')->where('Id_DoRig',$id_riga)->update(['Cd_ARLotto'=>Null]);

            DB::table('DoRig')->where('Id_DORig',$id_riga)->update($dati);

            DB::update("Update dotes set dotes.reserved_1= 'RRRRRRRRRR' where dotes.id_dotes = $id_dotes");
            DB::statement("exec asp_DO_End $id_dotes");
        }

        $clienti = DB::select('SELECT * from CF where Cliente = 1 and Id_CF = '.$id_cliente);
        $documenti = DB::select('SELECT * from DOTes where Id_DoTes = \''.$id_dotes.'\'');
        if(sizeof($clienti) > 0){
            $cliente = $clienti[0];
            $documento = $documenti[0];
            $documento->righe = DB::select('SELECT * from DORig where Id_DoTes = \''.$id_dotes.'\'');
            foreach ($documento->righe as $r)
            {
                $r->lotti = DB::select('SELECT * FROM ARLotto WHERE Cd_AR = \''.$r->Cd_AR.'\' ');
            }


            $totali_documento = DB::select('SELECT * from DoTotali where Id_DoTes = \''.$id_dotes.'\'');
            if(sizeof($totali_documento) > 0) {
                $documento->imponibile = $totali_documento[0]->TotImponibileE;
                $documento->imposta = $totali_documento[0]->TotImpostaE;
                $documento->totale = $totali_documento[0]->TotaPagareE;
            }
            $articolo = DB::select('SELECT Cd_AR from DORig where Id_DoTes = \''.$id_dotes.'\' group by Cd_AR');
            $flusso= DB::SELECT('select * from DODOPrel where Cd_DO_Prelevabile = \'OVC\' ');

            return View::make('scarico_magazzino4', compact('cliente', 'id_dotes', 'documento','articolo','flusso'));
        }
    }

    public function scarico_magazzino04($id_cliente,$id_dotes,Request $request){

        $dati = $request->all();
        if(isset($dati['elimina_riga'])){
            DB::table('DoRig')->where('Id_DORig',$dati['Id_DORig'])->delete();
            DB::update("Update dotes set dotes.reserved_1= 'RRRRRRRRRR' where dotes.id_dotes = $id_dotes");
            DB::statement("exec asp_DO_End $id_dotes");
        }


        if(isset($dati['modifica_riga'])){

            unset($dati['modifica_riga']);
            $id_riga = $dati['Id_DORig'];
            unset($dati['Id_DORig']);

            list($dati['Cd_MG_P'],$dati['Descrizione'],$dati['Cd_MGUbicazione_P']) = explode(' - ',$dati['magazzino'] );
            unset($dati['magazzino']);
            unset($dati['Descrizione']);

            if($dati['Cd_MGUbicazione_P']=='ND')
            {
                unset($dati['Cd_MGUbicazione_P']);
            }

            if($dati['Cd_ARLotto']=='Nessun Lotto')
            {
                unset($dati['Cd_ARLotto']);
            }

            DB::table('DoRig')->where('Id_DoRig',$id_riga)->update(['Cd_MGUbicazione_P'=>Null]);
            DB::table('DoRig')->where('Id_DoRig',$id_riga)->update(['Cd_ARLotto'=>Null]);

            DB::table('DoRig')->where('Id_DORig',$id_riga)->update($dati);

            DB::update("Update dotes set dotes.reserved_1= 'RRRRRRRRRR' where dotes.id_dotes = $id_dotes");
            DB::statement("exec asp_DO_End $id_dotes");
        }



        $clienti = DB::select('SELECT * from CF where Cliente = 1 and Id_CF = '.$id_cliente);
        $documenti = DB::select('SELECT * from DOTes where Id_DoTes = \''.$id_dotes.'\'');
        if(sizeof($clienti) > 0){
            $cliente = $clienti[0];
            $documento = $documenti[0];
            $documento->righe = DB::select('SELECT * from DORig where Id_DoTes = \''.$id_dotes.'\'');
            foreach ($documento->righe as $r)
            {
                $r->lotti = DB::select('SELECT * FROM ARLotto WHERE Cd_AR = \''.$r->Cd_AR.'\' ');
            }


            $totali_documento = DB::select('SELECT * from DoTotali where Id_DoTes = \''.$id_dotes.'\'');
            if(sizeof($totali_documento) > 0) {
                $documento->imponibile = $totali_documento[0]->TotImponibileE;
                $documento->imposta = $totali_documento[0]->TotImpostaE;
                $documento->totale = $totali_documento[0]->TotaPagareE;
            }
            $articolo = DB::select('SELECT Cd_AR from DORig where Id_DoTes = \''.$id_dotes.'\' group by Cd_AR');

            return View::make('scarico_magazzino04', compact('cliente', 'id_dotes', 'documento','articolo'));
        }
    }
*/
    public function inventario_magazzino(Request $request){
        if(!session()->has('utente')) {
            return Redirect::to('login');
        }
        $dati = $request->all();

        if(isset($dati['rettifica'])){
            $primo_carico = DB::select('SELECT * from MGMov where Cd_AR = \''.$dati['Cd_AR'].'\' and Ini = 1');
            if(sizeof($primo_carico) > 0){
                DB::insert('INSERT INTO MGMov (DataMov,PartenzaArrivo,Cd_MGEsercizio,Cd_AR,Cd_MG,Id_MGMovDes,Quantita,Ret) VALUES(\'20200101\',\'\',2020,\''.$dati['Cd_AR'].'\',\'00001\',27,'.$dati['quantita'].',1)');
            } else DB::insert('INSERT INTO MGMov (DataMov,PartenzaArrivo,Cd_MGEsercizio,Cd_AR,Cd_MG,Id_MGMovDes,Quantita,Ini) VALUES(\'20200101\',\'\',2020,\''.$dati['Cd_AR'].'\',\'00001\',27,'.$dati['quantita'].',1)');

        }

        return View::make('inventario_magazzino');
    }
    public function cercadoc(Request $request){
        if(!session()->has('utente')) {
            return Redirect::to('login');
        }
        $dati = $request->all();

        if(isset($dati['rettifica'])){
            $primo_carico = DB::select('SELECT * from MGMov where Cd_AR = \''.$dati['Cd_AR'].'\' and Ini = 1');
            if(sizeof($primo_carico) > 0){
                DB::insert('INSERT INTO MGMov (DataMov,PartenzaArrivo,Cd_MGEsercizio,Cd_AR,Cd_MG,Id_MGMovDes,Quantita,Ret) VALUES(\'20200101\',\'\',2020,\''.$dati['Cd_AR'].'\',\'00001\',27,'.$dati['quantita'].',1)');
            } else DB::insert('INSERT INTO MGMov (DataMov,PartenzaArrivo,Cd_MGEsercizio,Cd_AR,Cd_MG,Id_MGMovDes,Quantita,Ini) VALUES(\'20200101\',\'\',2020,\''.$dati['Cd_AR'].'\',\'00001\',27,'.$dati['quantita'].',1)');

        }

        return View::make('cercadoc');
    }

    public function phpinfo(){
        phpinfo();
    }

    public function calcola_totali_ordine(){
        ArcaUtilsController::calcola_totali_ordine();
    }



}
