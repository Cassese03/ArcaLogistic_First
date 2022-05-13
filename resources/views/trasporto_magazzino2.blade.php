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
                <input type="text" id="cerca" class="form-control border-0" placeholder="Cerca un Magazzino..." aria-label="Username">
            </div>
        </form>
        <header class="row m-0 fixed-header">
            <div class="left">
                <a style="padding-left:20px;" href="/magazzino/trasporto/<?php echo $cd_do; ?>/<?php echo $Cd_Cf?>/<?php echo $Id_DoTes?>" ><i class="material-icons">arrow_back_ios</i></a>
            </div>
            <div class="col center">
                <a href="#" class="logo"><figure><img src="/img/logo_arca.png" alt=""></figure></a>
            </div>
            <div class="right">
                <a style="padding-left:20px;" href="/" ><i class="material-icons">home</i></a>
            </div>
        </header>

        <div class="page-content">
            <div class="content-sticky-footer" style="padding-top: 50px;">

                <div class="background bg-125" style="height:200px"><img src="/img/background.png" alt=""></div>
                <div class="w-100">
                    <h1 class="text-center text-white title-background">Lista Magazzini (<?php echo $cd_do ?>)<br><small><?php echo $Cd_AR ?></small></h1>
                </div>

                    <ul class="list-group" id="ajax" style="max-height:500px;">
                        <li class="list-group-item" style="position:fixed;top:50px;left:0px;width:100%;height:50px; ">
                            <a class="media">
                                <div class="media-body" >
                                    <h5 style="color:blue;text-align: center">CODICE</h5>
                                </div>
                                <div class="media-body">
                                    <h5 style="color:blue;text-align: center">GIACENZA</h5>
                                </div>
                                <div class="media-body">
                                    <h5 style="color:blue;text-align: center">UBICAZIONE </h5>
                                </div>
                                <div class="media-body">
                                    <h5 style="color:blue;text-align: center">LOTTO</h5>
                                </div>
                            </a>
                        </li>

                        <?php foreach($default as $g){?>
                        <li class="list-group-item">
                            <a href="/magazzino/trasporto3/<?php echo $Cd_AR ?>/<?php  echo $cd_do?>/<?php echo $Cd_Cf ?>/<?php  echo $g->Cd_Mg ?>/<?php if($g->Cd_MGUbicazione == null){echo '0';}else{echo $g->Cd_MGUbicazione; }?>/<?php if($g->Cd_ARLotto == null){echo '0';}else{echo $g->Cd_ARLotto; }?>/<?php echo $Id_DoTes?>" class="media">

                                <div class="media-body">
                                    <h5 style="text-align: center"> <?php echo $g->Cd_Mg?> <br> <?php echo $g->Descrizione ?></h5>
                                </div>


                                <div class="media-body">
                                    <h5 style="text-align:center <?php if(intval($g->Giacenza)< 0)echo';color:red'?>"><?php echo intval($g->Giacenza);?></h5>
                                </div>

                                <div class="media-body">
                                    <h5 style="text-align:center"><?php  if($g->Cd_MGUbicazione == null){echo 'Non Presente';}else{echo $g->Cd_MGUbicazione; };?></h5>
                                </div>

                                <div class="media-body">
                                    <h5 style="text-align:center "><?php  if($g->Cd_ARLotto == null){echo 'Non Presente';}else{echo $g->Cd_ARLotto; };?></h5>
                                </div>

                            </a>
                        </li>

                        <?php }; ?>
                        <button type="button" class="btn btn-danger btn-sm" onclick="gotobolla()" >Mostra Piu' Magazzini</button>
                        <?php /*
                            foreach($giacenza as $g){ ?>
                        <li class="list-group-item">
                            <a href="/magazzino/trasporto3/<?php echo $Cd_AR ?>/<?php  echo $cd_do?>/<?php echo $Cd_Cf ?>/<?php  echo $g->Cd_Mg ?>/<?php if($g->Cd_MGUbicazione == null){echo '0';}else{echo $g->Cd_MGUbicazione; }?>/<?php if($g->Cd_ARLotto == null){echo '0';}else{echo $g->Cd_ARLotto; }?>" class="media">

                                <div class="media-body">
                                    <h5 style="text-align: center"> <?php echo $g->Cd_Mg?> <br> <?php echo $g->Descrizione ?></h5>
                                </div>

                                <div class="media-body">
                                    <h5 style="text-align:center <?php if(intval($g->Giacenza)< 0)echo';color:red'?>"><?php echo intval($g->Giacenza);?></h5>
                                </div>

                                <div class="media-body">
                                    <h5 style="text-align:center"><?php  if($g->Cd_MGUbicazione == null){echo 'Non Presente';}else{echo $g->Cd_MGUbicazione; };?></h5>
                                </div>

                                <div class="media-body">
                                    <h5 style="text-align:center "><?php  if($g->Cd_ARLotto == null){echo 'Non Presente';}else{echo $g->Cd_ARLotto; };?></h5>
                                </div>

                            </a>
                        </li>

                        <?php } */ ?>
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
<script>
    function gotobolla(){

        top.location.href = '<?php echo URL::asset('/magazzino/trasporto2_tot/'.$Cd_AR.'/'.$cd_do.'/'.$Cd_Cf.'/'.$Id_DoTes.'/'.$lotto) ?>'
    }
</script>


