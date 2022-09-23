
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


        <header class="row m-0 fixed-header">
            <div class="left">
                <a href="<?php echo URL::asset('articoli') ?>" ><i class="material-icons">keyboard_backspace</i></a>
            </div>
            <div class="col center">
                <a href="#" class="logo" style="text-decoration: none;"><?php echo $articolo->Descrizione ?></a>
            </div>
            <div class="right">
                <a style="padding-left:20px;" href="/" ><i class="material-icons">home</i></a>
            </div>
        </header>
        <div class="page-content">
            <?php if(isset($modificato)){ ?>
            <div class="alert alert-danger" role="alert">
                Modifica Effettuata con successo
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <?php } ?>
            <div class="content-sticky-footer">
                <h5 class="block-title text-center">Modifica Dati</h5>

                <div class="row mx-0">

                    <div class="col-12">
                        <form method="post" onsubmit="return confirm('Vuoi Eliminare questo articolo ?')" style="width:100%">
                            <input type="hidden" name="Cd_AR" value="<?php echo $articolo->Cd_AR ?>">
                            <input style="width:100%" type="submit" name="elimina_articolo" class="btn btn-danger btn-sm" value="Elimina Articolo">
                        </form>
                    </div>

                    <form method="post" style="width:100%;margin-top:20px;">
                        <div class="col-md-12">
                            <div class="row">

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="textinput">Codice</label>
                                        <input type="text" class="form-control" value="<?php echo $articolo->Cd_AR ?>" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="textinput">Descrizione</label>
                                        <input type="text" class="form-control" name="Descrizione" value="<?php echo $articolo->Descrizione ?>">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="textinput">Gruppi</label>
                                        <select class="form-control" id="exampleFormControlSelect1" name="gruppi">
                                                <option value=";;;">Nessun Gruppo</option>
                                            <?php if($gruppoAR != null){?>
                                            <option value="<?php echo $gruppoAR->id ?>" selected><?php echo $gruppoAR->Descrizione ?></option>
                                            <?php } foreach($gruppi as $gruppo){ ?>
                                                <option value="<?php echo $gruppo->id ?>"><?php echo $gruppo->Descrizione ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <?php /* if(sizeof($misure) > 0){ ?>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="textinput">Pezzi X Collo</label>
                                            <input type="text" class="form-control" name="pezzi" value="<?php echo $misure[0]->UMFatt ?>">
                                        </div>
                                    </div>
                                <?php } */?>

                                <?php $i = 1; ?>
                                <?php if(sizeof($aliases) > 0){ ?>
                                    <?php foreach($aliases as $alias){ ?>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="textinput">Barcode <?php echo $i ?></label>
                                                <input type="text" class="form-control" name="barcode[<?php echo $i ?>]" value="<?php echo $alias->Alias ?>">
                                            </div>
                                        </div>
                                    <?php $i++;} ?>
                                <?php } ?>

                                <?php while($i <= 10){ ?>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="textinput">Barcode <?php echo $i ?></label>
                                        <input type="text" class="form-control" name="barcode[<?php echo $i ?>]" value="">
                                    </div>
                                </div>

                                <?php $i++;} ?>

                                <div class="clearif"></div>

                                <?php /*if(sizeof($listini) > 0){ ?>

                                    <?php foreach($listini as $listino){ ?>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $listino->Descrizione ?></label>
                                                <input type="text" class="form-control" id="<?php echo trim($listino->Cd_LS) ?>" name="listino[<?php echo $listino->Id_LSArticolo ?>]" value="<?php echo number_format($listino->Prezzo,3,'.','') ?>">
                                            </div>
                                        </div>

                                    <?php } ?>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Margine %</label>
                                            <input type="text" id="margine" class="form-control" onkeyup="calcola_prezzo();">
                                        </div>
                                    </div>


                                <?php }*/ ?>

                            </div>

                        </div>
                        <br>
                        <input type="hidden" name="Cd_AR" value="<?php echo $articolo->Cd_AR ?>">
                            <button type="submit" name="modifica_articolo" value="Modifica Articolo" class="btn btn-success mb-1 btn-block"  >Salva Modifiche Articolo</button>
                            <button type="button" name="visualizza_lotto" class="btn btn-success mb-1 btn-block" onclick="visualizza_lotti()" >Visualizza Giacenza</button>

                    </form>
                </div>

            </div>

        </div>
    </div>
    <!-- page main ends -->

</div>

<div class="modal" id="modal_crea_lotto" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Inserire Dettagli Lotto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="Cd_AR" id="modal_Cd_AR">
                    <label>Codice Identificativo</label>
                    <input class="form-control" type="text" id="modal_lotto" value="" required placeholder="Inserisci un Codice Identificativo" autocomplete="off">
                    <label>Descrizione</label>
                    <input class="form-control" type="text" id="modal_descrizione" value="" required placeholder="Inserisci una Descrizione" autocomplete="off">
                    <label>Fornitore</label><small> (Facoltativo)</small>
                    <input class="form-control" type="text" id="modal_fornitore" value="" required placeholder="Inserisci un Fornitore" autocomplete="off">
                    <label>Fornitore Pallet</label><small> (Facoltativo)</small>
                    <input class="form-control" type="text" id="modal_fornitorePallet" value="" required placeholder="Inserisci un Fornitore" autocomplete="off">
                    <label>Pallet</label><small> (Facoltativo)</small>
                    <input class="form-control" type="text" id="modal_Pallet" value="" required placeholder="Inserisci un Fornitore" autocomplete="off">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    <button type="button" class="btn btn-primary" onclick="crea_lotto();">Inserisci Lotto</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal" id="modal_lotti" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group" id="ajax" >

                    </ul>
                </div>
            </div>
        </form>
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
</body>

</html>


<script type="text/javascript">
    function visualizza_lotti(){

        articolo = '<?php echo $articolo->Cd_AR?>';
        $.ajax({
            url: "<?php echo URL::asset('ajax/visualizza_lotti')?>/"+articolo,


        }).done(function(result) {
            $('#modal_lotti').modal('show');
            $('#ajax').html(result);
        });

    }
    function storialotto(articolo,lotto){

        $.ajax({
            url: "<?php echo URL::asset('ajax/storialotto')?>/"+articolo+"/"+lotto,
        }).done(function(result) {
            $('#modal_lotti').modal('show');
            $('#ajax').html(result);
        });

    }

    function crea_lotto(){
            lotto       = document.getElementById('modal_lotto').value;
            articolo    = '<?php echo $articolo->Cd_AR ?>';
            fornitore   = document.getElementById('modal_fornitore').value;
            descrizione = document.getElementById('modal_descrizione').value;
            fornitorePallet = document.getElementById('modal_fornitorePallet').value;
            pallet      = document.getElementById('modal_Pallet').value;


        if(fornitorePallet == ''){
            fornitorePallet = '0';
        }
        if(pallet == ''){
            pallet = '0';
        }
        if(fornitore == ''){
            fornitore = '0';
        }
        if(lotto == ''){
            alert('Lotto Obbligatorio');
        }
        if(descrizione == ''){
            alert('Descrizione Obbligatoria');
        }

        $.ajax({
            url: "<?php echo URL::asset('ajax/inserisci_lotto')?>/"+lotto+"/"+articolo+"/"+fornitore.trimEnd()+"/"+descrizione+"/"+fornitorePallet+"/"+pallet

        }).done(function(result) {

            alert(result);
            location.reload();

        });

    }
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

</script>
