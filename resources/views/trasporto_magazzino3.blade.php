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
                <input type="text" id="cerca" class="form-control border-0" placeholder="Cerca un Magazzino..." aria-label="Username">
            </div>
        </form>
        <header class="row m-0 fixed-header">
            <div class="left">
                <a style="padding-left:20px;" href="/magazzino/trasporto2/<?php  echo $Cd_AR ?>/<?php echo $cd_do; ?>/<?php echo $Cd_Cf?>/<?php echo $Id_DoTes?>/<?php echo $Cd_ARLotto?>" ><i class="material-icons">arrow_back_ios</i></a>
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
                <?php /* $i=0;foreach($giacenza as $g){$i++;}*/?>

                <ul class="list-group" id="ajax" style="max-height:500px;">

                    <li class="list-group-item" style="position:fixed;top:50px;left:0px;width:100%;height:50px;z-index:10000;  ">

                        <a class="media">
                            <div class="media-body" style="text-align: center">
                                <h5 style="color:blue">CODICE</h5>
                            </div>
                            <div class="media-body" style="text-align: center">
                                <h5 style="color:blue">GIACENZA</h5>
                            </div>
                            <div class="media-body" style="text-align: center">
                                <h5 style="color:blue">UBICAZIONE </h5>
                            </div>

                        </a>
                    </li>


                            <?php /*
 onclick="<?php echo 'style="color:red;"'?>"

 foreach($unico as $g){?>
                            <li class="list-group-item">
                                <a href="/magazzino/trasporto4/<?php echo $Cd_AR ?>/<?php  echo $cd_do?>/<?php echo $Cd_Cf ?>/<?php  echo $Cd_MG ?>/<?php echo $Cd_MGUbicazione ?>/<?php  if($g->Cd_MGUbicazione == null){echo '0';}else{echo $g->Cd_MGUbicazione; } ?>/<?php  echo $g->Cd_Mg ?>" class="media">

                                    <div class="media-body">
                                        <h5>Codice: <?php echo $g->Cd_Mg?> <br> <?php echo $g->Descrizione ?></h5>
                                    </div>


                                    <div class="media-body">
                                        <h5><?php echo 'Giacenza = 0';?></h5>
                                    </div>

                                    <div class="media-body">
                                        <h5><?php  echo "Ubicazione = " ?><?php  if($g->Cd_MGUbicazione == null){echo 'Non Presente';}else{echo $g->Cd_MGUbicazione; };?></h5>
                                    </div>

                                </a>
                            </li>

                            <?php } */?>

                        <?php foreach($default1 as $g){?>
                        <li class="list-group-item">
                            <a href="/magazzino/trasporto4/<?php echo $Cd_AR ?>/<?php  echo $cd_do?>/<?php echo $Cd_Cf ?>/<?php  echo $Cd_MG ?>/<?php echo $Cd_MGUbicazione ?>/<?php  echo $g->Cd_Mg ?>/<?php  if($g->Cd_MGUbicazione == null){echo '0';}else{echo $g->Cd_MGUbicazione; } ?>/<?php echo $Cd_ARLotto ?>/<?php echo $Id_DoTes?>" class="media">

                                <div class="media-body">
                                    <h5 style="text-align: center"> <?php echo $g->Cd_Mg?> <br> <?php echo $g->Descrizione ?></h5>
                                </div>


                                <div class="media-body">
                                    <h5 style="text-align:center "><?php echo '0';?></h5>
                                </div>

                                <div class="media-body">
                                    <h5 style="text-align:center"><?php  if($g->Cd_MGUbicazione == null){echo 'Non Presente';}else{echo $g->Cd_MGUbicazione; };?></h5>
                                </div>



                            </a>
                        </li>
                                <?php } ?>

                                <?php foreach($default as $g){?>
                                <li class="list-group-item">
                                    <a  href="/magazzino/trasporto4/<?php echo $Cd_AR ?>/<?php  echo $cd_do?>/<?php echo $Cd_Cf ?>/<?php  echo $Cd_MG ?>/<?php echo $Cd_MGUbicazione ?>/<?php  echo $g->Cd_Mg ?>/<?php if($g->Cd_MGUbicazione == null){echo '0';}else{echo $g->Cd_MGUbicazione; } ?>/<?php echo $Cd_ARLotto ?>/<?php echo $Id_DoTes?>" class="media">

                                        <div class="media-body">
                                            <h5 style="text-align: center"> <?php echo $g->Cd_Mg?> <br> <?php echo $g->Descrizione ?></h5>
                                        </div>


                                        <div class="media-body">
                                            <h5 style="text-align:center <?php if(intval($g->Giacenza)< 0)echo';color:red'?>"><?php echo intval($g->Giacenza);?></h5>
                                        </div>

                                        <div class="media-body">
                                            <h5 style="text-align:center"><?php  if($g->Cd_MGUbicazione == null){echo 'Non Presente';}else{echo $g->Cd_MGUbicazione; };?></h5>
                                        </div>


                                    </a>
                                </li>

                                <?php } ?>


                    <?php /*foreach($magazzino as $m){
                    foreach($giacenza as $g){

                    if($g->Cd_MG == $m->Cd_MG){

                    <li class="list-group-item">
                        <a href="/magazzino/trasporto4/<?php echo $Cd_AR ?>/<?php  echo $cd_do?>/<?php echo $Cd_Cf ?>/<?php  echo $Cd_MG ?>/<?php  echo $m->Cd_MG ?>"class="media">
                            <div class="media-body">
                                <h5>Codice: <?php echo $m->Cd_MG ?> - <?php echo $m->Descrizione." - Giacenza = " ?><?php echo intval($g->Giacenza) ; ?></h5>
                            </div>
                        </a>
                    </li>

                      } } }

                     foreach($magazzino as $m){if($i!=0){if($m->Cd_MG == $giacenza[$i-1]->Cd_MG){$i--;}else{

                        <li class="list-group-item">
                            <a href="/magazzino/trasporto4/<?php echo $Cd_AR ?>/<?php  echo $cd_do?>/<?php echo $Cd_Cf ?>/<?php  echo $Cd_MG ?>/<?php  echo $m->Cd_MG ?>"class="media">
                                <div class="media-body">
                                    <h5>Codice: <?php echo $m->Cd_MG ?> - <?php echo $m->Descrizione." - Giacenza = 0" ?></h5>
                                </div>
                            </a>
                        </li>
                    } }else{
                        <li class="list-group-item">
                            <a href="/magazzino/trasporto4/<?php echo $Cd_AR ?>/<?php  echo $cd_do?>/<?php echo $Cd_Cf ?>/<?php  echo $Cd_MG ?>/<?php  echo $m->Cd_MG ?>"class="media">
                                <div class="media-body">
                                    <h5>Codice: <?php echo $m->Cd_MG ?> - <?php echo $m->Descrizione." - Giacenza = 0" ?></h5>
            </div>
            </a>
            </li>
             }  }

/*

                        foreach($magazzino as $m){
                             foreach($giacenza as $g){


                            if($i!=0)if($m->Cd_MG == $giacenza[$i-1]->Cd_MG){$i--;}{ ?>

                            <li class="list-group-item">
                                <a href="/magazzino/trasporto4/<?php echo $Cd_AR ?>/<?php  echo $cd_do?>/<?php echo $Cd_Cf ?>/<?php  echo $Cd_MG ?>/<?php  echo $m->Cd_MG ?>"class="media">
                                    <div class="media-body">
                                        <h5>Codice: <?php echo $m->Cd_MG ?> - <?php echo $m->Descrizione." - Giacenza = 0" ?></h5>
                                    </div>
                                </a>
                            </li>

                              } } }*/
                        ?>
                    <button type="button" class="btn btn-danger btn-sm" onclick="gotobolla()" >Mostra Piu' Magazzini</button>

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

        top.location.href = '<?php echo URL::asset('/magazzino/trasporto3_tot/'.$Cd_AR.'/'.$cd_do.'/'.$Cd_Cf.'/'.$Cd_MG.'/'.$Cd_MGUbicazione.'/'.$Cd_ARLotto.'/'.$Id_DoTes) ?>'

    }
</script>


