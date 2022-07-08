<?php  $utente = session('utente');?>
<!doctype html>
<html lang="en" class="md">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, shrink-to-fit=no, viewport-fit=cover">
    <link rel="apple-touch-icon" href="img/icona_arca.png">
    <link rel="icon" href="img/icona_arca.png">
    <link rel="stylesheet" href="vendor/bootstrap-4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/materializeicon/material-icons.css">
    <link rel="stylesheet" href="vendor/swiper/css/swiper.min.css">
    <link id="theme" rel="stylesheet" href="css/style.css" type="text/css">
    <title>Arca Logistic</title>
</head>

<body class="color-theme-red push-content-right theme-light">
<div class="loader justify-content-center ">
    <div class="maxui-roller align-self-center"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
</div>
<div class="wrapper">

    <!-- page main start -->
    <div class="page">
        <div class="page-content">
            <div class="content-sticky-footer">

                <div class="row" style="height:750px;overflow-y: none;">
                    <div class="col-md-6">
                        <div class="background bg-250" style="height:100%;" ><img src="img/background.png" alt="" style="height:100%;" > </div>
                        <div class="w-100">
                            <h6 style="float: right;color: white">Accesso effettuato da : <?php echo $utente->Cd_Operatore ?></h6>
                            <img src="img/logo_arca.png" style="width:80%;padding:10%;margin:0 auto;display:block;">

                            <h1 class="text-center text-white title-background" style="margin-top:0">
                                <small>Arca Logistic<br></small>
                                <?php  echo $ditta->RagioneSociale ?></h1>

                        </div>
                    </div>

                    <div class="col-md-6" style="padding-left:0;">

                        <ul class="list-group" >

                            <li class="list-group-item">
                                <a href="<?php echo URL::asset('magazzino') ?>" class="media">
                                    <div class="media-body">
                                        <h5>Magazzino</h5>
                                        <p>Gestisci il Magazzino di Arca</p>
                                    </div>
                                </a>
                            </li>

                            <li class="list-group-item">
                                <a href="<?php echo URL::asset('magazzino/carico2/OVC') ?>" class="media">
                                    <div class="media-body">
                                        <h5>OVC</h5>
                                        <p>Scegli OVC da lavorare</p>
                                    </div>
                                </a>
                            </li>

                            <li class="list-group-item">
                                <a href="<?php echo URL::asset('magazzino/carico2/OVS') ?>" class="media">
                                    <div class="media-body">
                                        <h5>OVS</h5>
                                        <p>Scegli OVS da lavorare</p>
                                    </div>
                                </a>
                            </li>

                            <li class="list-group-item">
                                <a href="<?php echo URL::asset('magazzino/carico2/PKS') ?>" class="media">
                                    <div class="media-body">
                                        <h5>CLP</h5>
                                        <p>Scegli CLP da lavorare</p>
                                    </div>
                                </a>
                            </li>

                            <li class="list-group-item">
                                <a href="<?php echo URL::asset('magazzino/carico03/15700/OLI') ?>" class="media">
                                    <div class="media-body">
                                        <h5>Crea OLI</h5>
                                        <p>Crea un OLI</p>
                                    </div>
                                </a>
                            </li>

                            <li class="list-group-item">
                                <a href="<?php echo URL::asset('magazzino/carico03/15700/OLE') ?>" class="media">
                                    <div class="media-body">
                                        <h5>Crea OLE</h5>
                                        <p>Crea un OLE</p>
                                    </div>
                                </a>
                            </li>

                            <li class="list-group-item">
                                <a href="<?php echo URL::asset('magazzino/carico02/OVC') ?>" class="media">
                                    <div class="media-body">
                                        <h5>Crea OVC</h5>
                                        <p>Crea un OVC</p>
                                    </div>
                                </a>
                            </li>

                            <li class="list-group-item">
                                <a href="<?php echo URL::asset('magazzino/carico02/OVS') ?>" class="media">
                                    <div class="media-body">
                                        <h5>Crea OVS</h5>
                                        <p>Crea un OVS</p>
                                    </div>
                                </a>
                            </li>

                            <li class="list-group-item">
                                <a href="<?php echo URL::asset('magazzino/carico3/15700/OLI') ?>" class="media">
                                    <div class="media-body">
                                        <h5>OLI</h5>
                                        <p>Scegli OLI da lavorare</p>
                                    </div>
                                </a>
                            </li>

                            <li class="list-group-item">
                                <a href="<?php echo URL::asset('magazzino/carico3/15700/OLE') ?>" class="media">
                                    <div class="media-body">
                                        <h5>OLE</h5>
                                        <p>Scegli OLE da lavorare</p>
                                    </div>
                                </a>
                            </li>
                        <!--
                            <li class="list-group-item">
                                <a href="<?php echo URL::asset('magazzino/cercadoc/PKS') ?>" class="media">
                                    <div class="media-body">
                                        <h5>Cerca in PKS</h5>
                                        <p>Cerca il tuo PKS dall'articolo</p>
                                    </div>
                                </a>
                            </li>
                        -->
                            <li class="list-group-item">
                                <a href="<?php echo URL::asset('magazzino/cercadoc/ordini') ?>" class="media">
                                    <div class="media-body">
                                        <h5>Cerca in Ordini</h5>
                                        <p>Cerca i tuoi ordini dall'articolo</p>
                                    </div>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="<?php echo URL::asset('logout') ?>" class="media">
                                    <div class="media-body">
                                        <h5>Logout</h5>
                                        <p>Effettua il Logout</p>
                                    </div>
                                </a>
                            </li>
                        <!--
                         <li class="list-group-item">

                                <a href="<?php echo URL::ASSET('articoli') ?>" class="media">
                                    <div class="media-body">
                                        <h5>Articoli</h5>
                                        <p>Gestisci gli articoli di Arca</p>
                                    </div>
                                </a>

                            </li>

                            <li class="list-group-item">
                                <a href="<?php echo URL::asset('ordini') ?>" class="media">
                                    <div class="media-body">
                                        <h5>Passivo</h5>
                                        <p>Gestisci gli Ordini ancora non chiusi</p>
                                    </div>
                                </a>
                            </li>

                            <li class="list-group-item">
                                <a href="<?php echo URL::asset('attivi') ?>" class="media">
                                    <div class="media-body">
                                        <h5>Attivo</h5>
                                        <p>Gestisci gli Ordini ancora non chiusi</p>
                                    </div>
                                </a>
                            </li>
-->
                        </ul>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- page main ends -->

</div>




<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="vendor/bootstrap-4.1.3/js/bootstrap.min.js"></script>

<!-- Cookie jquery file -->
<script src="vendor/cookie/jquery.cookie.js"></script>

<!-- sparklines chart jquery file -->
<script src="vendor/sparklines/jquery.sparkline.min.js"></script>

<!-- Circular progress gauge jquery file -->
<script src="vendor/circle-progress/circle-progress.min.js"></script>

<!-- Swiper carousel jquery file -->
<script src="vendor/swiper/js/swiper.min.js"></script>

<!-- Application main common jquery file -->
<script src="js/main.js"></script>

<!-- page specific script -->
<script>
    $(window).on('load', function() {
        /* sparklines */
        $(".dynamicsparkline").sparkline([5, 6, 7, 2, 0, 4, 2, 5, 6, 7, 2, 0, 4, 2, 4], {
            type: 'bar',
            height: '25',
            barSpacing: 2,
            barColor: '#a9d7fe',
            negBarColor: '#ef4055',
            zeroColor: '#ffffff'
        });

        /* gauge chart circular progress */
        $('.progress_profile1').circleProgress({
            fill: '#169cf1',
            lineCap: 'butt'
        });
        $('.progress_profile2').circleProgress({
            fill: '#f4465e',
            lineCap: 'butt'
        });
        $('.progress_profile4').circleProgress({
            fill: '#ffc000',
            lineCap: 'butt'
        });
        $('.progress_profile3').circleProgress({
            fill: '#00c473',
            lineCap: 'butt'
        });

        /*Swiper carousel */
        var mySwiper = new Swiper('.swiper-container', {
            slidesPerView: 2,
            spaceBetween: 0,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            }
        });
        /* tooltip */
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
    });

</script>
</body>

</html>
