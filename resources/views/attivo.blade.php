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
                <input type="text" id="cerca" class="form-control border-0" placeholder="Cerca Fornitore..." aria-label="Username">
            </div>
        </form>
        <header class="row m-0 fixed-header">
            <div class="left">
                <a style="padding-left:20px;" href="/magazzino" ><i class="material-icons">arrow_back_ios</i></a>
            </div>
            <div class="col center">
                <a href="#" class="logo"><figure><img src="/img/logo_arca.png" alt=""></figure>Scarico Magazzino</a>
            </div>
            <div class="right">
                <a style="padding-left:20px;" href="/" ><i class="material-icons">home</i></a>
            </div>
        </header>

        <div class="page-content">
            <div class="content-sticky-footer">

                <div class="background bg-125"><img src="/img/background.png" alt=""></div>
                <div class="w-100">
                    <h1 class="text-center text-white title-background">&nbsp;&nbsp;&nbsp;Scegli Un Tipo di Documento</h1>
                </div>

                <ul class="list-group" id="ajax" style="max-height:500px;">

                    <?php  foreach($documenti as $d){ ?>

                    <li class="list-group-item">
                        <a <?php /* if($d->Cd_Do=='OAF'){echo 'href="/magazzino/carico2/'.$d->Cd_Do.'"';}
                                    else{if($d->Cd_Do=='BCV'){echo 'href="/magazzino/trasporto_fornitore/'.$d->Cd_Do.'"';}
                                    else{if($d->Cd_Do=='DTR'){echo 'href="/magazzino/carico1/'.$d->Cd_Do.'"';}
                                    else{if($d->Cd_Do=='DTG'){echo 'href="/magazzino/carico03/11256/'.$d->Cd_Do.'"';}
                                    else{echo 'href="/magazzino/carico02/'.$d->Cd_Do.'"';}}}}?>
                           <?php switch($d->Cd_Do){
                            case "BO":
                                echo 'href="/magazzino/carico02/'.$d->Cd_Do.'"';
                                break;
                            case "OC":
                                echo 'href="/magazzino/carico2/'.$d->Cd_Do.'"';
                                break;
                            case "OCM":
                                echo 'href="/magazzino/carico2/'.$d->Cd_Do.'"';
                                break;
                            default:*/
                                echo 'href="/magazzino/carico2/'.$d->Cd_Do.'"';/*
                                break;
                        }*/?>class="media">
                            <div class="media-body">
                                <h5><?php echo $d->Cd_Do ?></h5>
                                <p> <?php echo $d->Descrizione ?></p>
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
            cerca_fornitore($('#cerca').val());
            e.preventDefault();
        }
    });

    function cerca_fornitore(testo){

        $.ajax({
            url: "<?php echo URL::asset('ajax/cerca_fornitore') ?>/"+encodeURIComponent(testo),
            context: document.body
        }).done(function(result) {
            $('#ajax').html(result);
        });

    }

</script>

<!--
    <div class="page">
        <form class="searchcontrol">
            <div class="input-group">
                <div class="input-group-prepend">
                    <button type="button" class="input-group-text close-search"><i class="material-icons">keyboard_backspace</i></button>
                </div>
                <input type="email" class="form-control border-0" placeholder="Cerca Articolo..." aria-label="Username">
            </div>
        </form>
        <header class="row m-0 fixed-header">
            <div class="left">
                <a style="padding-left:20px;" href="/" ><i class="material-icons">arrow_back_ios</i></a>
            </div>
            <div class="col center">
                <a href="#" class="logo"><figure><img src="img/logo_arca.png" alt=""></figure> Magazzino</a>
            </div>
        </header>

        <div class="page-content">
            <div class="content-sticky-footer">

                <div class="background bg-170"><img src="img/background.png" alt=""></div>
                <div class="w-100">
                    <h1 class="text-center text-white title-background">Gestione Ordini</h1>
                </div>
                <ul class="list-group">
                    <?php /* foreach($ordini_C as $o){?>
                    <li class="list-group-item">
                        <a href="<?php echo URL::asset('magazzino/scarico4/'.$o->Id_CF.'/'.$o->Id_DoTes) ?>" class="media">
                            <div class="media-body">
                                <h5><?php echo $o->Cd_CF ?></h5>
                                <p><?php echo 'Ordine : ';echo $o->Id_DoTes?></p>
                            </div>
                        </a>
                    </li>
                    <?php } ?>
<?php  foreach($ordini_C as $o){?>
    <li class="list-group-item">
        <a href="<?php echo URL::asset('magazzino/carico/') ?>" class="media">
                            <div class="media-body">
                                <h5><?php echo $o->Cd_CF ?></h5>
                                <p><?php echo 'Ordine : ';echo $o->Id_DoTes ?></p>
                            </div>
                        </a>
                    </li>
                    <?php }  ?>
    </ul>
<!--
                <ul class="list-group">

                    <li class="list-group-item">
                        <a href="<?php echo URL::asset('magazzino/carico') ?>" class="media">
                            <div class="media-body">
                                <h5>Ordine</h5>
                                <p>Effettua un Ordine di Carico di Magazzino Da Fornitore</p>
                            </div>
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="<?php echo URL::asset('magazzino/carico1') ?>" class="media">
                            <div class="media-body">
                                <h5>Carico</h5>
                                <p>Effettua un Carico di Magazzino Da Fornitore</p>
                            </div>
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="<?php echo URL::asset('magazzino/scarico') ?>" class="media">
                            <div class="media-body">
                                <h5>Preventivo</h5>
                                <p>Effettua un Preventivo di Scarico di Magazzino Verso Clienti</p>
                            </div>
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a href="<?php echo URL::asset('magazzino/scarico1') ?>" class="media">
                            <div class="media-body">
                                <h5>Scarico</h5>
                                <p>Effettua un Scarico di Magazzino Verso Clienti</p>
                            </div>
                        </a>
                    </li>


                    <li class="list-group-item">
                        <a class="media" href="<?php echo URL::asset('magazzino/inventario') ?>" >
                            <div class="media-body">
                                <h5>Inventario</h5>
                                <p>Effettua Inventario Rettificando le Quantità</p>
                            </div>
                        </a>
                    </li>


                </ul>
                -->
</div>
</div>
</div>
-->
