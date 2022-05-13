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
        <form class="searchcontrol">
            <div class="input-group">
                <div class="input-group-prepend">
                    <button type="button" class="input-group-text close-search"><i class="material-icons">keyboard_backspace</i></button>
                </div>
                <input type="text" id="cerca" class="form-control border-0"   placeholder="Cerca Articolo..." aria-label="Username">
                <input type="hidden" id="dest" value="<?php echo $Id_DoTes; ?>">
                <input type="hidden" id="forn" value="<?php echo $Cd_Cf; ?>">
            </div>
        </form>
        <header class="row m-0 fixed-header">
            <div class="left">
                <a style="padding-left:20px;" href="/magazzino/trasporto_documento/<?php  echo  $documenti?>/<?php echo $Cd_Cf?>" ><i class="material-icons">arrow_back_ios</i></a>
            </div>
            <div class="col center">
                <a href="#" class="logo"><figure><img src="/img/logo_arca.png" alt=""></figure>Scelta Articolo</a>
            </div>
            <div class="right">
                <a href="javascript:void(0)" class="searchbtn"><i class="material-icons">search</i></a>
            </div>
        </header>

        <div class="page-content">
            <div class="content-sticky-footer">

                <div class="background bg-170"><img src="/img/background.png" alt=""></div>
                <div class="w-100">
                    <h1 class="text-center text-white title-background">&nbsp;&nbsp;&nbsp;Scegli Un Articolo<br><small><?php  echo  $documenti?></small></h1>
                </div>
                <ul class="list-group" id="ajax" style="max-height:500px;" >

                    <?php  foreach($articoli as $a){ ?>

                    <li class="list-group-item">
                        <a href="/magazzino/trasporto2/<?php echo $a->Cd_AR ?>/<?php  echo $documenti ?>/<?php echo $Cd_Cf ?>/<?php echo $Id_DoTes?>/<?php if($a->Cd_ARLotto!='')echo $a->Cd_ARLotto;else echo '0'; ?>" class="media">
                            <div class="media-body">
                                <h5><?php echo $a->Descrizione;if($a->Cd_ARLotto != '')echo '  Lotto: '.$a->Cd_ARLotto?></h5>
                                <p>Codice: <?php echo $a->Cd_AR;?></p>
                            </div>

                        </a>
                    </li>

                    <?php }  ?>

                </ul>
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



    $('#cerca').on('keydown', function(e) {
        if (e.which == 13) {
            cerca_articolo_new($('#cerca').val());
            e.preventDefault();
            check();
        }
    });

    function check(){
        check = document.getElementById('cerca').value;
        lunghezza = check.length;
        if(check.substring(0,3)==']C1'){
            document.getElementById('cerca').value=check.substring(3,lunghezza);
            check = document.getElementById('cerca').value;
            alert('GS1 Code aggiustato riprovare a cercare');
        }
        else {
            cerca_articolo_new(check);
        }

    }
    function cerca_articolo_new(testo){

        dest = document.getElementById('dest').value;
        forn = document.getElementById('forn').value;

        $.ajax({
            url: "<?php echo URL::asset('ajax/cerca_articolo_new') ?>/"+encodeURIComponent(testo)+"/"+dest+"/"+forn,
            context: document.body
        }).done(function(result) {
            $('#ajax').html(result);
        });

    }


</script>
