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
    <title>Smart Logistic</title>
</head>

<body class="color-theme-blue push-content-right theme-light">
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
                <a href="#" class="logo"><figure><img src="/img/logo_arca.png" alt=""></figure>&nbsp;&nbsp;&nbsp;Scarico Magazzino</a>
            </div>
            <div class="right">
                <a href="javascript:void(0)" onclick="$('#cerca').focus();" class="searchbtn"><i class="material-icons">search</i></a>
            </div>
        </header>

        <div class="page-content">
            <div class="content-sticky-footer">

                <div class="background bg-125"><img src="/img/background.png" alt=""></div>
                <div class="w-100">
                    <h1 class="text-center text-white title-background">Scegli Un Cliente</h1>
                </div>

                <ul class="list-group" id="ajax" style="max-height:500px;">

                    <?php  foreach($clienti as $c){ ?>

                        <li class="list-group-item">
                            <a href="/magazzino/scarico02/<?php echo $c->Id_CF ?>" class="media">
                                <div class="media-body">
                                    <h5><?php echo $c->Descrizione ?></h5>
                                    <p>Codice: <?php echo $c->Cd_CF ?></p>
                                </div>
                            </a>
                        </li>

                    <?php }  ?>

                </ul>



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

    $('#cerca').on('keydown', function(e) {
        if (e.which == 13) {
            cerca_cliente($('#cerca').val());
            e.preventDefault();
        }
    });

    function cerca_cliente(testo){

        $.ajax({
            url: "<?php echo URL::asset('ajax/cerca_cliente') ?>/"+encodeURIComponent(testo),
            context: document.body
        }).done(function(result) {
            $('#ajax').html(result);
        });

    }


</script>
