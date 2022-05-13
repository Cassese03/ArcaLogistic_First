
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

<body class="color-theme-red push-content-right theme-light">
<div class="loader justify-content-center ">
    <div class="maxui-roller align-self-center"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
</div>
<div class="wrapper">

    <!-- page main start -->
    <div class="page">


        <header class="row m-0 fixed-header">
            <div class="left">
                <a href="javascript:void(0)" onclick="window.history.back();"><i class="material-icons">keyboard_backspace</i></a>
            </div>
            <div class="col center">
                <a href="#" class="logo" style="text-decoration: none;">Creazione Nuovo Articolo</a>
            </div>
        </header>
        <div class="page-content">
            <div class="content-sticky-footer">
                <h5 class="block-title text-center">Creazione Articolo</h5>

                <div class="row mx-0">
                    <form method="post" style="width:100%">
                        <div class="col-md-12">
                            <div class="row">

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="textinput">Codice <b style="color:red">*</b></label>
                                        <input type="text" class="form-control" name="Cd_AR" value="<?php echo $nuovo_codice ?>" required autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="textinput">Descrizione <b style="color:red">*</b></label>
                                        <input type="text" class="form-control" name="Descrizione" required maxlength="80" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="textinput">Barcode (Opzionale)</label>
                                        <input type="text" class="form-control" name="barcode" value="<?php echo isset($_GET['barcode'])?$_GET['barcode']:'' ?>" autocomplete="off">
                                    </div>
                                </div>
                                <!--
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="textinput">Pezzi X Cartone</label>
                                        <input type="text" class="form-control" name="pezzi_confezione" value="1" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="textinput">Prezzo Acquisto <b style="color:red">*</b></label>
                                        <input type="number" step="0.01" class="form-control" name="prezzo_acquisto" required autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="textinput">Prezzo Vendita <b style="color:red">*</b></label>
                                        <input type="number" class="form-control" name="prezzo_vendita" value="0" required autocomplete="off">
                                    </div>
                                </div>
-->
                            </div>

                        </div>
                        <br>
                        <button type="submit" name="nuovo_articolo" value="Crea Articolo" class="btn btn-success mb-1 btn-block" style="width:200px;float:right;margin-right:20px;">Crea Articolo</button>
                    </form>
                </div>

            </div>

        </div>
    </div>
    <!-- page main ends -->

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
</body>

</html>

<script type="text/javascript">
/*
    function calcola_margine(){
        lsc = parseFloat($('#LSC').val()).toFixed(3);
        lsf = parseFloat($('#LSF').val()).toFixed(3);
        $('#margine').val(parseFloat((lsc/lsf-1)*100).toFixed(3));
    }

    function calcola_prezzo(){
        margine = parseFloat(($('#margine').val()/100)+1).toFixed(3);
        lsf = parseFloat($('#LSF').val()).toFixed(3);
        $('#LSC').val(parseFloat(lsf*margine).toFixed(3));
    }

    calcola_margine();
*/
</script>
