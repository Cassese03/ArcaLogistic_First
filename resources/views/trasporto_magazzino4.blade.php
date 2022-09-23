<?php $magazzino_ord = DB::select('SELECT * from MG'); //TODO MANCANO GLI ALERT?>
    <!doctype html>
<html lang="en" class="md">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, shrink-to-fit=no, viewport-fit=cover">
    <link rel="apple-touch-icon" href="/img/icona_arca.png">
    <link rel="icon" href="/img/icona_arca.png">
    <link rel="stylesheet" href="/vendor/bootstrap-4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="/vendor/materializeicon/material-icons.css">
    <link rel="stylesheet" href="/vendor/swiper/css/swiper.min.css">
    <link id="theme" rel="stylesheet" href="/css/style.css" type="text/css">
    <title>Smart Logistic</title>
</head>

<style>
    @charset "UTF-8";

    .collapsable-source pre {
        font-size: small;
    }

    .input-field {
        display: flex;
        align-items: center;
        width: 260px;
        autocomplete:off;
    }

    .input-field label {
        flex: 0 0 auto;
        padding-right: 0.5rem;
        autocomplete:off;

    }

    .input-field input {
        flex: 1 1 auto;
        height: 20px;
        autocomplete:off;

    }

    .input-field button {
        flex: 0 0 auto;
        height: 28px;
        font-size: 20px;
        width: 40px;
        autocomplete:off;

    }

    .icon-barcode {
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center center;
        background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPjxzdmcgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiI+PHBhdGggZD0iTTAgNGg0djIwaC00ek02IDRoMnYyMGgtMnpNMTAgNGgydjIwaC0yek0xNiA0aDJ2MjBoLTJ6TTI0IDRoMnYyMGgtMnpNMzAgNGgydjIwaC0yek0yMCA0aDF2MjBoLTF6TTE0IDRoMXYyMGgtMXpNMjcgNGgxdjIwaC0xek0wIDI2aDJ2MmgtMnpNNiAyNmgydjJoLTJ6TTEwIDI2aDJ2MmgtMnpNMjAgMjZoMnYyaC0yek0zMCAyNmgydjJoLTJ6TTI0IDI2aDR2MmgtNHpNMTQgMjZoNHYyaC00eiI+PC9wYXRoPjwvc3ZnPg==);
    }

    .overlay {
        overflow: hidden;
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.3);
    }

    .overlay__content {
        top: 50%;
        position: absolute;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 90%;
        max-height: 90%;
        max-width: 800px;
    }

    .overlay__close {
        position: absolute;
        right: 0;
        padding: 0.5rem;
        width: 2rem;
        height: 2rem;
        line-height: 2rem;
        text-align: center;
        background-color: white;
        cursor: pointer;
        border: 3px solid black;
        font-size: 1.5rem;
        margin: -1rem;
        border-radius: 2rem;
        z-index: 100;
        box-sizing: content-box;
    }

    .overlay__content video {
        width: 100%;
        height: 100%;
    }

    .overlay__content canvas {
        position: absolute;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
    }

    #interactive.viewport {
        position: relative;
    }

    #interactive.viewport > canvas, #interactive.viewport > video {
        max-width: 100%;
        width: 100%;
    }

    canvas.drawing, canvas.drawingBuffer {
        position: absolute;
        left: 0;
        top: 0;
    }

    /* line 16, ../sass/_viewport.scss */
    .controls fieldset {
        border: none;
        margin: 0;
        padding: 0;
    }
    /* line 19, ../sass/_viewport.scss */
    .controls .input-group {
        float: left;
        autocomplete:off;

    }
    /* line 21, ../sass/_viewport.scss */
    .controls .input-group input, .controls .input-group button {
        display: block;
        autocomplete:off;

    }
    /* line 25, ../sass/_viewport.scss */
    .controls .reader-config-group {
        float: right;
    }
    /* line 28, ../sass/_viewport.scss */
    .controls .reader-config-group label {
        display: block;
    }
    /* line 30, ../sass/_viewport.scss */
    .controls .reader-config-group label span {
        width: 9rem;
        display: inline-block;
        text-align: right;
    }
    /* line 37, ../sass/_viewport.scss */
    .controls:after {
        content: '';
        display: block;
        clear: both;
    }

    /* line 22, ../sass/_viewport.scss */
    #result_strip {
        margin: 10px 0;
        border-top: 1px solid #EEE;
        border-bottom: 1px solid #EEE;
        padding: 10px 0;
    }
    /* line 28, ../sass/_viewport.scss */
    #result_strip ul.thumbnails {
        padding: 0;
        margin: 0;
        list-style-type: none;
        width: auto;
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;
    }
    /* line 37, ../sass/_viewport.scss */
    #result_strip ul.thumbnails > li {
        display: inline-block;
        vertical-align: middle;
        width: 160px;
    }
    /* line 41, ../sass/_viewport.scss */
    #result_strip ul.thumbnails > li .thumbnail {
        padding: 5px;
        margin: 4px;
        border: 1px dashed #CCC;
    }
    /* line 46, ../sass/_viewport.scss */
    #result_strip ul.thumbnails > li .thumbnail img {
        max-width: 140px;
    }
    /* line 49, ../sass/_viewport.scss */
    #result_strip ul.thumbnails > li .thumbnail .caption {
        white-space: normal;
    }
    /* line 51, ../sass/_viewport.scss */
    #result_strip ul.thumbnails > li .thumbnail .caption h4 {
        text-align: center;
        word-wrap: break-word;
        height: 40px;
        margin: 0px;
    }
    /* line 61, ../sass/_viewport.scss */
    #result_strip ul.thumbnails:after {
        content: "";
        display: table;
        clear: both;
    }

    @media (max-width: 603px) {
        /* line 2, ../sass/phone/_core.scss */
        #container {
            margin: 10px auto;
            -moz-box-shadow: none;
            -webkit-box-shadow: none;
            box-shadow: none;
        }
    }
    @media (max-width: 603px) {
        /* line 5, ../sass/phone/_viewport.scss */
        .reader-config-group {
            width: 100%;
        }

        .reader-config-group label > span {
            width: 50%;
        }

        .reader-config-group label > select, .reader-config-group label > input {
            max-width: calc(50% - 2px);
            autocomplete:off;

        }

        #interactive.viewport {
            width: 100%;
            height: auto;
            overflow: hidden;
        }

        /* line 20, ../sass/phone/_viewport.scss */
        #result_strip {
            margin-top: 5px;
            padding-top: 5px;
        }

        #result_strip ul.thumbnails {
            width: 100%;
            height: auto;
        }

        /* line 24, ../sass/phone/_viewport.scss */
        #result_strip ul.thumbnails > li {
            width: 150px;
        }
        /* line 27, ../sass/phone/_viewport.scss */
        #result_strip ul.thumbnails > li .thumbnail .imgWrapper {
            width: 130px;
            height: 130px;
            overflow: hidden;
        }
        /* line 31, ../sass/phone/_viewport.scss */
        #result_strip ul.thumbnails > li .thumbnail .imgWrapper img {
            margin-top: -25px;
            width: 130px;
            height: 180px;
        }
    }
</style>

<body class="color-theme-blue push-content-right theme-light">

<div class="loader justify-content-center ">
    <div class="maxui-roller align-self-center"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
</div>
<di class="wrapper">

    <!-- page main start -->
    <div class="page">
        <form class="searchcontrol">
            <div class="input-group">
                <div class="input-group-prepend">
                    <button type="button" class="input-group-text close-search"><i class="material-icons">keyboard_backspace</i></button>
                </div>
                <input type="text" id="cerca" class="form-control border-0" placeholder="Cerca Fornitore..." aria-label="Username">
            </div>
        </form>
        <header class="row m-0 fixed-header">
            <div class="left">
                <a style="padding-left:20px;" href="/magazzino/trasporto_documento/<?php echo $Cd_Do.'/'.$Cd_Cf->Cd_CF?>" ><i class="material-icons">arrow_back_ios</i></a>
            </div>
            <div class="col center">
                <a href="#" class="logo"><figure><img src="/img/logo_arca.png" alt=""></figure>Aggiungi Articoli</a>
            </div>
            <div class="right">
                <a style="padding-left:20px;" href="/" ><i class="material-icons">home</i></a>
            </div>
        </header>

        <div class="page-content">
            <div class="content-sticky-footer">
                <input type="text" id="cerca_articolo2" <?php /*onchange="controllo_articolo_smart();check();" onkeydown="controllo_articolo_smart();check();" */?> autofocus autocomplete="off">


                <div class="background bg-125"><img src="/img/background.png" alt=""></div>
                <div class="w-100">
                    <h1 class="text-center text-white title-background"><?php echo $Cd_Cf->Descrizione ?><br><small><?php echo $Cd_Do ?> <?php /* N.<?php echo $documento->NumeroDoc ?> Del <?php echo date('d/m/Y',strtotime($documento->DataDoc)) */ ?></small></h1>
                </div>


                <!--
                                 <fieldset class="reader-config-group" style="margin-top:50px;">
                                    <label>
                                        <span>Barcode-Type</span>
                                        <select name="decoder_readers">
                                            <option value="ean">EAN</option>
                                            <option value="ean_8">EAN-8</option>
                                        </select>
                                    </label>
                                </fieldset>
                -->


                <button style="margin-top:35px !important;width:80%;margin:0 auto;display:block;margin-bottom:0;" class="btn btn-primary" onclick="$('#modal_cerca_articolo').modal('show');">Aggiungi Prodotto</button>
                <?php if(sizeof($docu->righe) > 0){ ?>

                <div class="row">



                    <div class="col-sm-6" style="margin-top:0px;">
                        <ul class="list-group">

                            <?php foreach($docu->righe as $r){ $totale = 0; ?>

                            <li class="list-group-item">
                                <a href="#" onclick="" class="media">
                                    <div class="media-body">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6">
                                                <h5 <?php if($r->QtaEvadibile==0)echo 'style="color: red"'?>><?php echo $r->Cd_AR.' '.$r->Descrizione;?><br><?php  echo 'Prezzo : '.$r->PrezzoUnitarioV;?><?php /* echo  'Magazzino di Partenza: '.$r->Cd_MG_P;if($r->Cd_MGUbicazione_A != null) echo ' - '.$r->Cd_MGUbicazione_A;?><br><?php echo' Magazzino di Arrivo: '.$r->Cd_MG_A;?><br><?php if($r->Cd_ARLotto != Null)echo 'Lotto: '.$r->Cd_ARLotto;*/ ?></h5>
                                                <p <?php if($r->QtaEvadibile==0)echo 'style="color: red"'?>>Quantita': <?php echo floatval($r->Qta) ?></p>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6">

                                                <form  method="post" onsubmit="return confirm('Vuoi Eliminare Questa Riga ?')">
                                                    <button style="width:32%;" type="reset" name="segnalazione" value="" class="btn btn-warning btn-sm" onclick="$('#modal_segnalazione<?php echo $r->Id_DORig?>').modal('show');">
                                                        <i class="fa fa-exclamation-triangle" aria-hidden="true">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                                                                <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
                                                                <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
                                                            </svg>
                                                        </i>
                                                    </button>
                                                    <input type="hidden" id="codice" value="<?php echo $r->Cd_AR ?>">
                                                    <button style="width:32%;" type="reset" name="modifica_riga" value="<?php echo $r->Cd_AR;?>" class="btn btn-primary btn-sm" onclick="$('#modal_modifica_<?php echo $r->Id_DORig ?>').modal('show');">
                                                        <i class="bi bi-pencil">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                                            </svg>
                                                        </i>
                                                    </button>
                                                    <input type="hidden" name="Id_DORig" value="<?php echo $r->Id_DORig ?>">
                                                    <button  style="width:32%;" type="submit" name="elimina_riga" value="Elimina" class="btn btn-danger btn-sm" >
                                                        <i class="bi bi-trash-fill">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                                            </svg>
                                                        </i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <?php } ?>
                        </ul>
                    </div>
                <!--
                    <div class="col-sm-6">
                        <h3 style="text-align: center;margin-top: 25px">Riepilogo Documento</h3>
                        <h3 style="float: left;text-align: left;padding-left: 20px">Imponibile</h3>
                        <h3 style="float: right;text-align: right;padding-right: 20px">&nbsp;<?php /* echo number_format($documento->imponibile,2,',','.') ?>&nbsp;&euro;&nbsp;</h3><br><br>
                        <h3 style="float: left;text-align: left;padding-left: 20px">Imposta&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>
                        <h3 style="float: right;text-align: right;padding-right: 20px">&nbsp;<?php echo number_format($documento->imposta,2,',','.') ?>&nbsp;&euro;&nbsp;</h3><br><br>
                        <h3 style="float: left;text-align: left;padding-left: 20px">Totale&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>
                        <h3 style="float: right;text-align: right;padding-right: 20px">&nbsp;&nbsp;<?php echo number_format($documento->totale,2,',','.') */    ?>&nbsp;&euro;&nbsp;</h3><br><br>
                    </div>

                </div>
-->


                    <?php } ?>
                    <button style="margin-top:10px !important;width:80%;margin:0 auto;display:block;background-color:#007bff;border: #007bff" class="btn btn-primary" onclick="$('#modal_salva_documento').modal('show');">Salva Documento</button>


                </div>
            </div>

        </div>
        <!-- page main ends -->

    </div>

    <div class="modal" id="modal_cerca_articolo" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Carica Articolo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload()">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <label>Cerca Articolo</label>
                        <input class="form-control" type="text" id="cerca_articolo" value=""  placeholder="Inserisci barcode,codice o nome dell'articolo" autocomplete="off" autofocus>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload()">Chiudi</button>
                        <button type="button" class="btn btn-primary" onclick="cerca_articolo_smart();check();">Cerca Articolo</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal" id="modal_lista_articoli" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Carica Articolo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload()">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body" id="ajax_lista_articoli"></div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload()">Chiudi</button>
                        <button type="button" class="btn btn-primary" onclick="cerca_articolo_smart();">Carica Articolo</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php foreach($docu->righe as $r){ ?>
    <div class="modal" id="modal_segnalazione<?php echo $r->Id_DORig?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Segnalazione</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload()">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <input type="number" class="form-control" id="Segnala_riga" value="<?php echo $r->Id_DORig;?>" readonly><br>
                        <input type="text" class="form-control" id="Segnalazione" value="" placeholder="Inserire Segnalazione..."  autocomplete="off">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload()">Chiudi</button>
                        <button type="button" class="btn btn-primary" onclick="segnalazione();">Invia Segnalazione</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php } ?>
    <div class="modal" id="modal_carico" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Carica Articolo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload()">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="ajax_modal_carico"></div>
                        <input type="hidden" name="Cd_AR" id="modal_Cd_AR">
                        <label>Quantita</label>
                        <input class="form-control" type="number" id="modal_quantita" value="" required placeholder="Inserisci una Quantità" autocomplete="off" >
                        <!--
                            <label>Prezzo (&euro;)</label>
                            <input class="form-control" type="number" id="modal_prezzo" value="" required placeholder="Inserisci un Prezzo" autocomplete="off">
                            -->
                        <?php /*
                    <label>Magazzino Partenza</label>
                    <select class="form-control" type="number" id="modal_magazzino_P" value="" required placeholder="Inserisci un Magazzino" autocomplete="off";>
                        <?php /*foreach($magazzino_ord as $mp){?>
                        <option><?php echo $mp->Cd_MG.' - '.$mp->Descrizione;?></option>
                        <?php } *//*?>
                    </select>
                    <label>Magazzino Arrivo</label>
                    <select class="form-control" type="number" id="modal_magazzino_A" value="" required placeholder="Inserisci un Magazzino" autocomplete="off";>
                        <?php foreach($magazzino_ord as $mp){?>
                        <option magazzino="<?php echo $mp->Cd_MG?>"><?php echo $mp->Cd_MG.' - '.$mp->Descrizione;?></option>
                        <?php }?>
                    </select>
                    <?php if($documento->Cd_Do=='DTG'||$documento->Cd_Do=='DTR'){?>
                    <label>Ubicazione di Arrivo</label><small>(Facoltativo)</small>
                    <input type="text" class="form-control" id="modal_ubicazione_A" value="" placeholder="Inserire un Ubicazione..." autocomplete="off">
                    <?php } ?>
                    <label>Lotto</label>
                    <select class="form-control" type="number" id="modal_lotto" value="" required placeholder="Inserisci un Lotto" autocomplete="off";>
                    </select>
                    */?>



                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload()">Chiudi</button>
                        <button type="button" class="btn btn-primary" onclick="carica_articolo();">Carica Articolo</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal" id="modal_inserimento" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Articolo Mancante</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <input class="form-control" type="text" id="modal_inserimento_barcode" value="" autocomplete="off">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                        <button type="button" class="btn btn-primary" onclick="crea_articolo();">Crea Articolo</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal" id="modal_lista_articoli_daevadere" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Articolo da Evadere</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload()">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <label>Articolo</label>
                        <input class="form-control" type="text" id="modal_controllo_articolo" value=""  autocomplete="off" readonly>

                        <label>Quantita</label>
                        <input class="form-control" type="text" id="modal_controllo_quantita" value=""   autocomplete="off" readonly>


                        <input class="form-control" type="hidden" id="modal_controllo_lotto" value="0"  autocomplete="off" readonly>

                        <input class="form-control" type="hidden" id="modal_controllo_dorig" value=""  autocomplete="off" readonly>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload()">Chiudi</button>
                        <button type="button" class="btn btn-primary" onclick="location.reload()">Evadi Riga</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php foreach($docu->righe as $r ) { ?>
    <div class="modal" id="modal_modifica_<?php  echo $r->Id_DORig ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modifica Articolo <?php echo $r->Cd_AR ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload()">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="ajax_modal_modifica"></div>

                        <label>Quantita</label>
                        <input class="form-control" type="number" name="Qta" value="<?php echo floatval($r->Qta) ?>" required placeholder="Inserisci una Quantità" autocomplete="off" step="0.01">



                    <label>Prezzo (&euro;)</label>
                    <input class="form-control" type="number" name="PrezzoUnitarioV" value="<?php echo floatval($r->PrezzoUnitarioV) ?>" required placeholder="Inserisci un Prezzo" autocomplete="off"; step="0.01">

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="Id_DORig" value="<?php echo $r->Id_DORig ?>">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload()">Chiudi</button>
                        <button type="submit" name="modifica_riga" value="Salva" class="btn btn-primary">Salva</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php } ?>
    <div class="modal" id="modal_lista_salva" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Righe non Evase</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload()">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body" id="ajax_lista_documenti_1">
                    </div>
                    <?php foreach($docu->righe as $r) {?>
                    <input type="hidden" name="modal_Cd_ARLotto_c_<?php echo $r->Id_DORig?>" id="modal_Cd_ARLotto_c_<?php echo $r->Id_DORig?>">
                    <input type="hidden" name="modal_Cd_AR_c_<?php echo $r->Id_DORig?>" id="modal_Cd_AR_c_<?php echo $r->Id_DORig?>">
                    <input type="hidden" name="modal_Qta_c_<?php echo $r->Id_DORig?>" id="modal_Qta_c_<?php echo $r->Id_DORig?>">
                    <input type="hidden" name="modal_Prezzo_c_<?php echo $r->Id_DORig?>" id="modal_Prezzo_c_<?php echo $r->Id_DORig?>">

                <?php } ?>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload()">Chiudi</button>
                        <button type="button" class="btn btn-primary" onclick="invia();location.reload()">Salva Documento</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal" id="modal_salva_documento" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Salvataggio Documento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload()">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <label>Vuoi Salvare il Documento ? </label>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload()">No</button>
                        <button type="button" class="btn btn-primary" onclick="salva_documento()">Si</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal" id="modal_alertSegnalazione" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" onclick="location.reload()">&times;</button>
            <strong>Success!</strong><br> Segnalazione Effettuata</a>.
        </div>
    </div>



    <div class="modal" id="modal_alertQuantita" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="alert alert-warning alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" onclick="location.reload()">&times;</button>
            <strong>Alert!</strong><br> Inserire una quantita </a>.
        </div>
    </div>

    <div class="modal" id="modal_alertInserimento" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" onclick="location.reload()">&times;</button>
            <strong>Success!</strong><br> Articolo Inserito Correttamente</a>.
        </div>
    </div>

    <div class="modal" id="modal_alertUbicazione" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="alert alert-warning alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" onclick="location.reload()">&times;</button>
            <strong>Alert!</strong><br> Ubicazione inserita non corretta o inesistente</a>.
        </div>
    </div>

    <div class="modal" id="modal_alertTrovare" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="alert alert-warning alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" onclick="location.reload()">&times;</button>
            <strong>Alert!</strong><br> Nessun Articolo Trovato </a>.
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/vendor/bootstrap-4.1.3/js/bootstrap.min.js"></script>
    <script src="/vendor/cookie/jquery.cookie.js"></script>
    <script src="/vendor/sparklines/jquery.sparkline.min.js"></script>
    <script src="/vendor/circle-progress/circle-progress.min.js"></script>
    <script src="/vendor/swiper/js/swiper.min.js"></script>
    <script src="/js/main.js"></script>
    <script src="//webrtc.github.io/adapter/adapter-latest.js" type="text/javascript"></script>
    <script src="/dist/quagga.js" type="text/javascript"></script>
    <script src="/js/live_w_locator.js" type="text/javascript"></script>
    <script src="/js/jquery.scannerdetection.js" type="text/javascript"></script>

</body>
</html>

<script type="text/javascript">

    cd_cf =  '<?php echo $Cd_Cf->Cd_CF ?>';


    /* function cambioMagazzino(){
         magazzino = $('#modal_magazzino_A').val()
         $('#modal_ubicazione').children('option').hide();
         $('#modal_ubicazione').children("option[magazzino^=" + magazzino.substring(0,5) + "]").show();

     }*/


    function segnalazione(){
        Id_DoRig     = document.getElementById('Segnala_riga').value;
        Segnalazione = document.getElementById('Segnalazione').value;
        if(Id_DoRig!=''){
            $.ajax({
                url: "<?php echo URL::asset('ajax/segnalazione') ?>/<?php echo $Id_DoTes ?>/"+ Id_DoRig + "/-" + encodeURIComponent(Segnalazione),

            }).done(function (result) {
                $('#modal_alertSegnalazione').modal('show');
            });
        }
        if(Id_DoRig!=''){
            $.ajax({
                url: "<?php echo URL::asset('ajax/invia_mail') ?>/<?php echo $Id_DoTes ?>/"+ 0 + "/-" + Segnalazione
            }).done(function (result) {

            });
        }
    }

    function check(){
        check = document.getElementById('cerca_articolo').value;
        lunghezza = check.length;
        if(check.substring(0,3)==']C1'){
            document.getElementById('cerca_articolo').value=check.substring(3,lunghezza);
            check = document.getElementById('cerca_articolo').value;
            alert('GS1 Code aggiustato riprovare a cercare');
        }


    }

    function carica_articolo(){

        codice    =      $('#modal_Cd_AR').val();
        quantita  =      $('#modal_quantita').val();
        /* prezzo    =      $('#modal_prezzo').val();*/
        magazzino_A =      '00001 - Magazzino Centrale';
        magazzino_P =      '00001 - Magazzino Centrale';
        ubicazione_A  =    $('#modal_ubicazione_A').val();
        if(ubicazione_A == ''||ubicazione_A== null)
            ubicazione_A ='ND';
        lotto     =      $('#modal_lotto').val();


        if (quantita != '') {
            $.ajax({
                url: "<?php echo URL::asset('ajax/aggiungi_articolo_ordine') ?>/<?php echo $Id_DoTes ?>/" + codice + "/" + quantita + "/" + magazzino_A.substring(0,5) + "/" + ubicazione_A + "/" + lotto+"/"+ magazzino_P.substring(0,5) + "/" + 'ND'
            }).done(function (result) {
                $('#modal_carico').modal('hide');
                $('#modal_Cd_AR').val('');
                $('#modal_quantita').val('');
                if(result =='Ubicazione inserita inesistente in quel magazzino')
                    $('#modal_alertUbicazione').modal('show');
                if(result =='Articolo Caricato Correttamente ')
                    $('#modal_alertInserimento').modal('show');


            });

        } else
            $('#modal_alertQuantita').modal('show');
    }
    function modifica_articolo(){

        codice    =      document.getElementById('codice').value;
        quantita  =      $('#modal_quantita_m').val();
        /* prezzo    =      $('#modal_prezzo_m').val();*/
        magazzino =      $('#modal_magazzino_m').val();
        lotto     =      $('#modal_lotto_m').val();


        if(quantita != ''){
            $.ajax({
                url: "<?php echo URL::asset('ajax/modifica_articolo_ordine') ?>/<?php echo $Id_DoTes ?>/"+codice+"/"+quantita+"/"+magazzino_A.substring(0,5) + "/" + 'ND' + "/" + lotto+"/"+ magazzino_P.substring(0,5) + "/" + 'ND'

            }).done(function(result) {
                $('#modal_modifica').modal('hide');
                $('#modal_Cd_AR').val('');
                $('#modal_quantita').val('');
                $('#modal_magazzino').val();
                location.reload();

            });

        } else
            $('#modal_alertQuantita').modal('show');

    }
    /*
        function controllo_articolo_smart(){

            testo = $('#cerca_articolo2').val();
            testo  = testo.trimEnd();
            id_dotes ='<?php echo $Id_DoTes?>';
        id_dorig = "*****";

        if(testo != '') {
            $.ajax({
                url: "<?php echo URL::asset('ajax/controllo_articolo_smart') ?>/" + encodeURIComponent(testo)+"/"+id_dotes,
                context: document.body
            }).done(function (result) {
                if(result != '') {
                    $('#modal_cerca_articolo').modal('hide');
                    $('#modal_lista_articoli_daevadere').modal('show');
                    $('#ajax_lista_articoli').html(result);
                } else {
                    alert('nessun prodotto trovato');
                    segnalazioneControllo(id_dotes,id_dorig,testo);
                    location.reload();
                }
            });

        }

    }

    function segnalazioneControllo1(){

        id_dotes    = $('#id_dotes_C').val();

        id_dorig    =$('#id_dorig_C').val();

        Segnalazione=$('#Segnalazione_C').val();

        segnalazioneControllo(id_dotes,id_dorig,Segnalazione);
    }
    function segnalazioneControllo(id_dotes,id_dorig,Segnalazione){
        if(id_dotes!=''){
            $.ajax({
                url: "<?php echo URL::asset('ajax/segnalazione') ?>/<?php echo $Id_DoTes ?>/"+ id_dorig + "/" + Segnalazione
            }).done(function (result) {

            });
        }
        if(id_dotes!=''){
            $.ajax({
                url: "<?php echo URL::asset('ajax/invia_mail') ?>/<?php echo $Id_DoTes ?>/"+ 1 + "/" + Segnalazione
            }).done(function (result) {
                location.reload();
            });
        }
    }
*/
    function invia(){
        testo = 'Il documento (documento) è stato salvato.<br> Le righe del documento sono:';
        <?php foreach($docu->righe as $r){ ?>
        articolo = $('#modal_Cd_AR_c_<?php echo $r->Id_DORig?>').val();
        quantita = $('#modal_Qta_c_<?php echo $r->Id_DORig?>').val();
        lotto    = $('#modal_Cd_ARLotto_c_<?php echo $r->Id_DORig?>').val();
        quantita_evasa = $('#modal_QtaEvasa_c_<?php echo $r->Id_DORig?>').val();
        prezzo = $('#modal_Prezzo_c_<?php echo $r->Id_DORig?>').val();
        testo = testo +'<br> Articolo '+ articolo +' quantita\' '+ quantita +' prezzo '+ prezzo + '<br>';
        <?php } ?>
        $.ajax({
            url: "<?php echo URL::asset('ajax/invia_mail') ?>/<?php echo $Id_DoTes ?>/" + 3 + "/" + testo
        }).done(function (result) {

        });
    }
    function salva_documento(){

        Cd_Do    = '0';
        Id_DoTes = '<?php echo $Id_DoTes?>';
        magazzino_A  ='0';

        if(Id_DoTes!='')
            $.ajax({
                url: "<?php echo URL::asset('ajax/salva_documento1')?>/"+Id_DoTes+"/"+Cd_Do+"/"+magazzino_A.substring(0,5)

            }).done(function(result) {

                $('#modal_salva_documento').modal('hide');
                $('#modal_lista_salva').modal('show');
                $('#ajax_lista_documenti_1').html(result);

            });

    }
    /*
        function checkDoc(){
<?php foreach($docu->righe as $r){ ?>

    articolo = $('#modal_Cd_AR_c_<?php echo $r->Id_DORig?>').val();
        quantita = $('#modal_Qta_c_<?php echo $r->Id_DORig?>').val();
        lotto = $('#modal_Cd_ARLotto_c_<?php echo $r->Id_DORig?>').val();
        id_dorig = '00000'
        if (articolo != '' && quantita != '' && lotto != '') {
            testo = 'Articolo ' + articolo + '******  del lotto ' + lotto + ' con quantita ' + quantita + ' non evaso ';
            $.ajax({
                url: "<?php echo URL::asset('ajax/segnalazione_salva') ?>/<?php echo $Id_DoTes ?>/" + id_dorig + "/" + testo
            }).done(function (result) {
                alert('Segnalazione Effettuata');
                location.reload();
            });
        }
        <?php } ?>
    }
    function crea_articolo(){

        barcode = $('#modal_inserimento_barcode').val();
        if(barcode != '') {
            top.location.href = '/nuovo_articolo?redirect=/magazzino/carico4/<?php echo $Cd_Cf->Cd_CF ?>/<?php echo $Id_DoTes ?>&barcode=' + barcode;
        }
    }

    document.addEventListener("keydown", function(e) {
        if(e.which == 114){
            console.log(e.which);
            e.preventDefault();
            $('#modal_cerca_articolo').modal('show');
        } else if(e.which == 13){
            e.preventDefault();
        }
    });

    $('.modal').on('shown.bs.modal', function() {
        $(this).find('[autofocus]').focus();
    });*/
    function cerca_articolo_smart(){

        testo = $('#cerca_articolo').val();
        if(testo=='')
            testo = $('#cerca_articolo2').val(); testo  = testo.trimEnd();

        if(testo != '') {

            $.ajax({
                url: "<?php echo URL::asset('ajax/cerca_articolo_smart') ?>/" + encodeURIComponent(testo)+"/"+cd_cf,
                context: document.body
            }).done(function (result) {
                if(result != '') {
                    $('#modal_cerca_articolo').modal('hide');
                    $('#modal_lista_articoli').modal('show');
                    $('#ajax_lista_articoli').html(result);
                } else
                    $('#modal_alertTrovare').modal('show');
            });

        }

    }

    /*  $(document).scannerDetection({
          timeBeforeScanTest: 200, // wait for the next character for upto 200ms
          startChar: [120], // Prefix character for the cabled scanner (OPL6845R)
          endChar: [13], // be sure the scan is complete if key 13 (enter) is detec
          // ted
          avgTimeByChar: 40, // it's not a barcode if a character takes longer than 40ms
          onComplete: function(code, qty){

              $.ajax({
                  url: "/ajax/cerca_articolo_barcode/<?php echo $Cd_Cf->Cd_CF ?>/"+code,
                context: document.body
            }).done(function(result) {

                if(result != '') {
                    $('#modal_carico').modal('show');
                    $('#ajax_modal_carico').html(result);
                    $('#modal_prezzo').focus();
                } else {
                    $('#modal_inserimento').modal('show');
                    $('#modal_inserimento_barcode').val(code);
                }
            });

        } // main callback function
    });
*/
    function cerca_articolo_codice(fornitore,codice,lotto,qta){

        $.ajax({
            url: "/ajax/cerca_articolo_codice/<?php echo $Cd_Cf->Cd_CF ?>/"+codice+"/"+lotto+"/"+qta,
            context: document.body
        }).done(function(result) {

            if(result != '') {
                $('#modal_carico').modal('show');
                $('#ajax_modal_carico').html(result);
            } else {
                $('#modal_inserimento').modal('show');
                $('#modal_inserimento_barcode').val(code);
            }
        });
    }

    if(window.innerWidth > 800) {
        $('#interactive').css('display','none');
    }

</script>
