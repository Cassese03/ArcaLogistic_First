<!doctype html>
<html lang="en" class="md">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, shrink-to-fit=no, viewport-fit=cover">
    @include('common.header')
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
        autocomplete:off;
    }

    .input-field label {
        flex: 0 0 auto;
        padding-right: 0.5rem;
        autocomplete:off;

    }
    ::-webkit-scrollbar {
        width: 5px;
        height: 2px;
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

    .form__group {
        position: relative;
        padding: 15px 0 0;
        margin-top: 10px;
        width: 50%;
    }

    .form__field {
        font-family: inherit;
        width: 100%;
        border: 0;
        border-bottom: 2px solid #9b9b9b;
        outline: 0;
        font-size: 1.3rem;
        color: black;
        padding: 7px 0;
        background: transparent;
        transition: border-color 0.2s;

    ::placeholder {
        color: transparent;
    }

    :placeholder-shown ~ .form__label {
        font-size: 1.3rem;
        cursor: text;
        top: 20px;
    }
    }

    .form__label {
        position: absolute;
        top: 0;
        display: block;
        transition: 0.2s;
        font-size: 1rem;
        color: #9b9b9b;
    }

    .form__field:focus {
    ~ .form__label {
        position: absolute;
        top: 0;
        display: block;
        transition: 0.2s;
        font-size: 1rem;
        color: #11998e;
        font-weight:700;
    }
    padding-bottom: 6px;
    font-weight: 700;
    border-width: 3px;
    border-image: linear-gradient(to right, #11998e,#38ef7d;);
    border-image-slice: 1;
    }
    /* reset input */
    .form__field{
    :required,:invalid { box-shadow:none; }
    }
    /* demo */
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
                <a style="padding-left:20px;" href="/magazzino" ><i class="material-icons">arrow_back_ios</i></a>
            </div>
            <div class="col center">
                <a href="#" class="logo"><figure><img src="/img/logo_arca.png" alt=""></figure>Rettifica Quantit&agrave;</a>
            </div>
            <div class="right">
                <a style="padding-left:20px;" href="/" ><i class="material-icons">home</i></a>
            </div>
        </header>

        <div class="page-content">
            <div class="content-sticky-footer">
                <div class="background bg-125"><img src="/img/background.png" alt=""></div>
                <div class="w-100">
                    <h1 class="text-center text-white title-background">Rettifica Quantit&agrave;</h1>
                </div>

                <!-- <div id="interactive" class="viewport" style="position: relative;margin-top:30px;"></div> -->
                <div style="width: 80%;padding-left: 20%">
                    <input type="input" class="form__field" placeholder="Articolo" autocomplete="off" />
                    <input type="input" class="form__field" placeholder="Articolo" autofocus autocomplete="off" required id="cerca_articolo2" />
                    <button type="button" style="width: 100%;border-color: transparent;" onclick="cerca_articolo_smart2()"> Cerca </button>
                </div>

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
                    <button type="button" class="close" data-dismiss="modal" onclick="location.reload()" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">

                    <label>Cerca Articolo</label>
                    <input class="form-control" type="text" id="cerca_articolo1" placeholder="Inserisci barcode,codice o nome dell'articolo" autocomplete="off" autofocus>

                    <label>Tipo Ricerca</label>
                    <select class="form-control" type="text" id="tipo_articolo">
                        <option value="GS1">GS1</option>
                        <option value="EAN">Codice Articolo o Barcode</option>
                    </select>

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
                    <label>Articolo</label>
                    <input class="form-control" type="text" id="modal_Cd_AR" readonly>
                    <label>Magazzino</label>
                    <select class="form-control" type="text" id="modal_Cd_MG" onchange="cambioMagazzino()"></select>
                    <label>Quantita Sistema</label>
                    <input class="form-control" type="number" id="modal_quantita" readonly>
                    <label>Quantita Rilevata</label>
                    <input class="form-control" type="number" id="modal_quantita_rilevata" value="" required placeholder="Inserisci la Quantità rilevata" onkeyup="modifica_quantita()" step="0.01">
                    <label>Quantità da Rettificare (&euro;)</label>
                    <input class="form-control" type="number" readonly id="modal_quantita_da_rettificare" value="" required placeholder="Quantità da rettificare">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload()">Chiudi</button>
                    <button type="button" class="btn btn-primary" onclick="rettifica_articolo();">Rettifica Articolo</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal" id="modal_carico2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Carica Articolo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="ajax_modal_carico2"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="location.reload();">Ricarica Pagina</button>
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
                    <input class="form-control" type="text" id="modal_inserimento_barcode" value="">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    <button type="button" class="btn btn-primary" onclick="crea_articolo();">Crea Articolo</button>
                </div>
            </div>
        </form>
    </div>
</div>





<!-- Optional JavaScript -->
<!-- jQuery first, Popper.js, then Bootstrap JS -->
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

    $('.modal').on('shown.bs.modal', function() {
        $(this).find('[autofocus]').focus();
    });

    function check(){
        check = document.getElementById('cerca_articolo').value;
        lunghezza = check.length;
        if(check.substring(0,3)==']C1'){
            document.getElementById('cerca_articolo').value=check.substring(3,lunghezza);
            check = document.getElementById('cerca_articolo').value;
            alert('GS1 Code aggiustato riprovare a cercare');
        }


    }
    function modifica_quantita(){

        quantita = $('#modal_quantita').val();
        quantita_rilevata = $('#modal_quantita_rilevata').val();
        $('#modal_quantita_da_rettificare').val(parseFloat(quantita_rilevata)-parseFloat(quantita));
    }

    function cambioMagazzino(){

        quantita = $('#modal_Cd_MG option:selected').attr('quantita');
        $('#modal_quantita').val(quantita);

    }

    function cerca_articolo_smart(){

        testo = $('#cerca_articolo1').val();

        tipo  = $('#tipo_articolo').val();
        if(testo != '') {

            $.ajax({
                url: "<?php echo URL::asset('/ajax/cerca_articolo_smart_inventario') ?>/" + encodeURIComponent(testo)+"/"+encodeURIComponent(tipo),
                context: document.body
            }).done(function (result) {
                if(result != '') {
                    $('#modal_cerca_articolo').modal('hide');
                    $('#modal_lista_articoli').modal('show');
                    $('#ajax_lista_articoli').html(result);
                }
                else {
                    alert('nessun prodotto trovato');
                    location.reload();
                }
            });

        }
    }

    function cerca_articolo_smart2(){

        testo = $('#cerca_articolo2').val();
        pos = testo.search('/');
        if(pos !=(-1)){ testo = testo.substr(0,pos)+'slash'+testo.substr(pos+1)}
        if(testo != '') {

            $.ajax({
                url: "<?php echo URL::asset('/ajax/cerca_articolo_inventario') ?>/" + testo,
                context: document.body
            }).done(function (result) {
                if(result != '') {
                    $('#modal_cerca_articolo').modal('hide');
                    $('#modal_carico').modal('show');
                    $('#ajax_lista_articoli').html(result);
                } else {
                    alert('nessun prodotto trovato');
                    location.reload();
                }
            });

        }

    }

    function rettifica_articolo(){

        quantita_da_rettificare = $('#modal_quantita_da_rettificare').val();
        codice = $('#modal_Cd_AR').val();
        pos = codice.search('/');
        if(pos !=(-1)){ codice = codice.substr(0,pos)+'slash'+codice.substr(pos+1)}
        lotto = '0';
        magazzino = $('#modal_Cd_MG').val();


        if(quantita_da_rettificare != ''){
            $.ajax({
                url: "<?php echo URL::asset('/ajax/rettifica_articolo') ?>/"+codice+"/"+quantita_da_rettificare+"/"+lotto+"/"+magazzino
            }).done(function(result) {
                alert(result);
                location.reload();
            });

        } else
            alert('Inserire Una Quantità');
    }

    function crea_articolo(){

        barcode = $('#modal_inserimento_barcode').val();
        if(barcode != '') {
            top.location.href = '/magazzino/nuovo_articolo?redirect=/magazzino/inventario&barcode=' + barcode;
        }
    }

    function cerca_articolo_inventario_codice(code,lotto){
        $.ajax({
            url: "/ajax/cerca_articolo_inventario_codice/"+code+"/"+lotto,
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


    /*
    $(document).scannerDetection({
        timeBeforeScanTest: 200, // wait for the next character for upto 200ms
        startChar: [], // Prefix character for the cabled scanner (OPL6845R)
        endChar: [], // be sure the scan is complete if key 13 (enter) is detec
        avgTimeByChar: 40, // it's not a barcode if a character takes longer than 40ms
        onComplete: function(code, qty){

            alert('ciao');
            $.ajax({
                url: "/ajax/cerca_articolo_inventario/"+code,
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
    });*/


    /* $(document).scannerDetection({

         //https://github.com/kabachello/jQuery-Scanner-Detection

         timeBeforeScanTest: 200, // wait for the next character for upto 200ms
         avgTimeByChar: 40, // it's not a barcode if a character takes longer than 100ms
         preventDefault: true,

         endChar: [13],
         onComplete: function(barcode, qty){
             validScan = true;

             alert(barcode);

         } // main callback function ,
         ,
         onError: function(string, qty) {

             alert(string);


         }


     });*/
</script>
