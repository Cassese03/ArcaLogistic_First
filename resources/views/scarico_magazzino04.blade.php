<?php $magazzino_prova = DB::select('SELECT MG.*,MGUbicazione.Cd_MGUbicazione from MG LEFT JOIN MGUbicazione on MGUbicazione.Cd_MG = MG.Cd_MG');?>
<!doctype html>
<html lang="en" class="md">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, shrink-to-fit=no, viewport-fit=cover">
    <link rel="apple-touch-icon" href="img/icona_arca.png">
    <link rel="icon" href="img/icona_arca.png">
    <link rel="stylesheet" href="/vendor/bootstrap-4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="/vendor/materializeicon/material-icons.css">
    <link rel="stylesheet" href="/vendor/swiper/css/swiper.min.css">
    <link id="theme" rel="stylesheet" href="/css/style.css" type="text/css">
    <title>Arca Logistic</title>
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
    }

    .input-field label {
        flex: 0 0 auto;
        padding-right: 0.5rem;
    }

    .input-field input {
        flex: 1 1 auto;
        height: 20px;
    }

    .input-field button {
        flex: 0 0 auto;
        height: 28px;
        font-size: 20px;
        width: 40px;
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
    }
    /* line 21, ../sass/_viewport.scss */
    .controls .input-group input, .controls .input-group button {
        display: block;
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

<body class="color-theme-red push-content-right theme-light">

<div class="loader justify-content-center ">
    <div class="maxui-roller align-self-center"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
</div>
<div class="wrapper">

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
                <a style="padding-left:20px;" href="/magazzino/scarico03/<?php echo $cliente->Id_CF;echo "/";echo $documento->Cd_Do?>" ><i class="material-icons">arrow_back_ios</i></a>
            </div>
            <div class="col center">
                <a href="#" class="logo"><figure><img src="/img/logo_arca.png" alt=""></figure>Aggiungi Articoli</a>
            </div>
            <div class="right">
                <a style="padding-left:20px;" href="/" ><i class="material-icons">home</i></a>
            </div>
            <!--
            <div class="right">
                <a style="padding-left:20px;" href="/" ><i class="material-icons">assignment_return</i></a>
            </div>
            -->
        </header>

        <div class="page-content">
            <div class="content-sticky-footer">
                <input type="text" id="cerca_articolo2" onkeyup="controllo_articolo_smart();check();" onchange="controllo_articolo_smart();check();" autofocus autocomplete="off">


                <div class="background bg-125"><img src="/img/background.png" alt=""></div>
                <div class="w-100">
                    <h1 class="text-center text-white title-background"><?php echo $cliente->Descrizione ?><br><small><?php echo $documento->Cd_Do ?> N.<?php echo $documento->NumeroDoc ?> Del <?php echo date('d/m/Y',strtotime($documento->DataDoc)) ?></small></h1>
                </div>

                <button style="margin-top:35px !important;width:80%;margin:0 auto;display:block;margin-bottom:0;" class="btn btn-primary" onclick="$('#modal_cerca_articolo').modal('show');">Aggiungi Prodotto</button>

                <?php if(sizeof($documento->righe) > 0){ ?>

                <div class="row">

                    <div class="col-sm-6" style="margin-top:30px;">
                        <ul class="list-group">

                            <?php foreach($documento->righe as $r){ $totale = 0; ?>

                            <li class="list-group-item">
                                <a href="#" onclick="" class="media">
                                    <div class="media-body">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6">
                                                <h5><?php echo $r->Cd_AR.' '.$r->Descrizione.' - Magazzino: '.$r->Cd_MG_P;if($r->Cd_MGUbicazione_P != null) echo ' - '.$r->Cd_MGUbicazione_P;if($r->Cd_ARLotto != Null)echo ' - Lotto: '.$r->Cd_ARLotto?></h5>
                                                <p>Totale: <?php echo number_format($r->PrezzoUnitarioV,2,'.','') ?>&euro; X <?php echo intval($r->Qta) ?> = <?php echo number_format($r->PrezzoTotaleV,2,'.','') ?>&euro;</p>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6">
                                                <form  method="post" onsubmit="return confirm('Vuoi Eliminare Questa Riga ?')">
                                                    <input type="hidden" id="codice" value="<?php echo $r->Cd_AR ?>">
                                                    <button type="reset" name="modifica_riga" value="<?php echo $r->Cd_AR;?>" class="btn btn-danger btn-sm" onclick="$('#modal_modifica_<?php echo $r->Id_DORig ?>').modal('show');">Modifica</button>
                                                    <input type="hidden" name="Id_DORig" value="<?php echo $r->Id_DORig ?>">
                                                    <button type="submit" name="elimina_riga" value="Elimina" class="btn btn-danger btn-sm" >Elimina</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <?php } ?>
                        </ul>
                    </div>

                    <div class="col-sm-6">
                        <h3 style="text-align: center;margin-top: 25px">Riepilogo Documento</h3>
                        <h3 style="float: left;text-align: left;padding-left: 20px">Imponibile</h3>
                        <h3 style="float: right;text-align: right;padding-right: 20px">&nbsp;<?php echo number_format($documento->imponibile,2,',','.') ?>&nbsp;&euro;&nbsp;</h3><br><br>
                        <h3 style="float: left;text-align: left;padding-left: 20px">Imposta&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>
                        <h3 style="float: right;text-align: right;padding-right: 20px">&nbsp;<?php echo number_format($documento->imposta,2,',','.') ?>&nbsp;&euro;&nbsp;</h3><br><br>
                        <h3 style="float: left;text-align: left;padding-left: 20px">Totale&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>
                        <h3 style="float: right;text-align: right;padding-right: 20px">&nbsp;&nbsp;<?php echo number_format($documento->totale,2,',','.') ?>&nbsp;&euro;&nbsp;</h3><br><br>
                    </div>


                </div>


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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body" id="ajax_lista_articoli"></div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    <button type="button" class="btn btn-primary" onclick="cerca_articolo_smart();">Carica Articolo</button>
                </div>
            </div>
        </form>
    </div>
</div>



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
                    <input class="form-control" type="number" id="modal_quantita" value="" required placeholder="Inserisci una Quantità" autocomplete="off";>
                    <label>Prezzo (&euro;)</label>
                    <input class="form-control" type="number" id="modal_prezzo" value="" required placeholder="Inserisci un Prezzo" autocomplete="off";>
                    <label>Magazzino</label>
                    <select class="form-control" type="number" id="modal_magazzino" value="" required placeholder="Inserisci un Magazzino" autocomplete="off";>
                        <?php foreach($magazzino_prova as $mp){?>
                        <option><?php echo $mp->Cd_MG.' - '.$mp->Descrizione;if($mp->Cd_MGUbicazione !=  null) {echo ' - '.$mp->Cd_MGUbicazione;}else{echo ' - ND';}?></option>
                        <?php }?>
                    </select>
                    <label>Lotto</label>
                    <select class="form-control" type="number" id="modal_lotto" value="" required placeholder="Inserisci un Lotto" autocomplete="off";>

                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload()">Chiudi</button>
                    <button type="button" class="btn btn-primary" onclick="scarica_articolo();">Inserisci Articolo</button>
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
                    <input class="form-control" type="text" id="modal_inserimento_barcode" value="" autocomplete="off";>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    <button type="button" class="btn btn-primary" onclick="crea_articolo();">Crea Articolo</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php foreach($documento->righe as $r ) { ?>
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
                    <input class="form-control" type="number" name="Qta" value="<?php echo intval($r->Qta) ?>" required placeholder="Inserisci una Quantità" autocomplete="off";>

                    <label>Quantita Evadibile</label>
                    <input class="form-control" type="number" name="QtaEvadibile" value="<?php echo intval($r->QtaEvadibile) ?>" required placeholder="Inserisci una Quantità" autocomplete="off";>

                    <label>Prezzo (&euro;)</label>
                    <input class="form-control" type="number" name="PrezzoUnitarioV" value="<?php echo intval($r->PrezzoUnitarioV) ?>" required placeholder="Inserisci un Prezzo" autocomplete="off";>

                    <label>Magazzino</label>
                    <select class="form-control" type="number" name="magazzino"  required placeholder="Inserisci un Magazzino" autocomplete="off";>
                        <?php  foreach($magazzino_prova as $mp){?>
                        <option><?php echo $mp->Cd_MG.' - '.$mp->Descrizione;if($mp->Cd_MGUbicazione !=  null) {echo ' - '.$mp->Cd_MGUbicazione;}else{echo ' - ND';}?></option>
                        <?php } ?>
                    </select>

                    <label>Lotto</label>
                    <select class="form-control" type="number" name="Cd_ARLotto"  required placeholder="Inserisci un Lotto" autocomplete="off";>
                        <option>Nessun Lotto</option>
                        <?php foreach($r->lotti as $l) { ?>
                        <option><?php echo $l->Cd_ARLotto ?></option>
                        <?php } ?>
                    </select>

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

    cd_cf =  '<?php echo $cliente->Cd_CF ?>';
    function invia(){
        testo = 'Il documento (documento) è stato salvato.<br> Le righe del documento sono:';
        <?php foreach($documento->righe as $r){ ?>
            articolo = $('#modal_Cd_AR_c_<?php echo $r->Id_DORig?>').val();
        quantita = $('#modal_Qta_c_<?php echo $r->Id_DORig?>').val();
        lotto    = $('#modal_Cd_ARLotto_c_<?php echo $r->Id_DORig?>').val();
        quantita_evasa = $('#modal_QtaEvasa_c_<?php echo $r->Id_DORig?>').val();
        prezzo = $('#modal_Prezzo_c_<?php echo $r->Id_DORig?>').val();
        testo = testo +'<br> Articolo '+ articolo +' quantita\' '+ quantita +' prezzo '+ prezzo + '<br>';
        <?php } ?>
        $.ajax({
            url: "<?php echo URL::asset('ajax/invia_mail') ?>/<?php echo $id_dotes ?>/" + 3 + "/" + testo
        }).done(function (result) {

        });
    }
    function scarica_articolo(){

        codice    =      $('#modal_Cd_AR').val();
        quantita  =      $('#modal_quantita').val();
        prezzo    =      $('#modal_prezzo').val();
        magazzino =      $('#modal_magazzino').val();
        lotto     =      $('#modal_lotto').val();
        if (lotto == "Nessun Lotto" ) {
            lotto = "0";
        }

        if(quantita != ''){
            $.ajax({
                url: "<?php echo URL::asset('ajax/scarica_articolo_ordine') ?>/<?php echo $id_dotes ?>/"+codice+"/"+quantita+"/"+prezzo+"/"+magazzino.substring(0,5)+"/"+magazzino.split(' ').pop().split(' ')+"/"+lotto
            }).done(function(result) {
                $('#modal_carico').modal('hide');
                $('#modal_Cd_AR').val('');
                $('#modal_quantita').val('');
                magazzino = $('#modal_magazzino').val();
                location.reload();

            });

        } else alert('Inserire Una Quantità');
    }


    function crea_articolo(){

        barcode = $('#modal_inserimento_barcode').val();
        if(barcode != '') {
            top.location.href = '/nuovo_articolo?redirect=/magazzino/scarico4/<?php echo $cliente->Id_CF ?>/<?php echo $id_dotes ?>&barcode=' + barcode;
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

    function controllo_articolo_smart(){

        testo = $('#cerca_articolo2').val();
        testo  = testo.trimEnd();
        id_dotes ='<?php echo $id_dotes?>';

        if(testo != '') {

            $.ajax({
                url: "<?php echo URL::asset('ajax/controllo_articolo_smart') ?>/" + encodeURIComponent(testo)+"/"+id_dotes,
                context: document.body
            }).done(function (result) {
                if(result != '') {
                    $('#modal_cerca_articolo').modal('hide');
                    $('#modal_lista_articoli_daevadere').modal('show');
                    $('#ajax_lista_articoli').html(result);
                } else alert('nessun prodotto trovato');
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
    $('.modal').on('shown.bs.modal', function() {
        $(this).find('[autofocus]').focus();
    });
    function cerca_articolo_smart(){

        testo = $('#cerca_articolo').val();
        if(testo=='')
            testo = $('#cerca_articolo2').val();testo  = testo.trimEnd();

        if(testo=='')
        { testo = $('#modal_Cd_AR_m').val(); }
        if(testo != '') {

            $.ajax({
                url: "<?php echo URL::asset('ajax/cerca_articolo_smart') ?>/" + encodeURIComponent(testo)+"/"+cd_cf,
                context: document.body
            }).done(function (result) {
                if(result != '') {
                    $('#modal_cerca_articolo').modal('hide');
                    $('#modal_lista_articoli').modal('show');
                    $('#ajax_lista_articoli').html(result);
                } else alert('nessun prodotto trovato');
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
                url: "/ajax/cerca_articolo_barcode/<?php echo $cliente->Cd_CF ?>/"+code,
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

        } // main callback function
    });*/

    function cerca_articolo_codice(fornitore,codice,lotto){



        $.ajax({
            url: "/ajax/cerca_articolo_codice/<?php echo $cliente->Cd_CF ?>/"+codice+"/"+lotto,
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
    function cerca_articolo_inizio(codice){

    codice = $('#modal_Cd_AR_m').val();

        $.ajax({
            url: "/ajax/cerca_articolo_inizio/<?php echo $cliente->Cd_CF ?>/"+codice,
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


    /*$(document).scannerDetection({
        timeBeforeScanTest: 200, // wait for the next character for upto 200ms
        startChar: [120], // Prefix character for the cabled scanner (OPL6845R)
        endChar: [13], // be sure the scan is complete if key 13 (enter) is detec
        // ted
        avgTimeByChar: 40, // it's not a barcode if a character takes longer than 40ms
        onComplete: function(code, qty){

            $.ajax({
                url: "/ajax/cerca_articolo_barcode/<?php echo $cliente->Cd_CF ?>/"+code,
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

        } // main callback function
    });

    if(window.innerWidth > 800) {
        $('#interactive').css('display','none');
    }*/

</script>
