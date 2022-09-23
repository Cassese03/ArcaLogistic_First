<?php
if(isset($_GET['id']) && is_numeric($_GET['id'])){

    $serverName = "DESKTOP-419ODUF\SQLEXPRESS";
    $connectionInfo = array( "Database"=>"ADB_PIERRE_DISTR", "UID"=>"test", "PWD"=>"test123");
    $conn = sqlsrv_connect( $serverName, $connectionInfo );
    $modificato = false;

    if(isset($_POST) && isset($_POST['modifica_articolo'])){

        $query = 'UPDATE AR SET Descrizione = (?),Cd_ARGruppo1 = (?),Cd_ARGruppo2 = (?),Cd_ARGruppo3 = (?) where Id_AR = '.$_GET['id'];
        $params[] = $_POST['Descrizione'];

        if(isset($_POST['gruppi'])){
            list($cd1,$cd2,$cd3) = explode(';',$_POST['gruppi']);
            array_push($params,$cd1); array_push($params,$cd2); array_push($params,$cd3);
        } else {
            array_push($params,null); array_push($params,null); array_push($params,null);
        }

        sqlsrv_query($conn, $query, $params);

        $listini = $_POST['listino'];
        print_r($listini);
        foreach($listini as $chiave => $valore){
            $stmt = sqlsrv_query($conn,'UPDATE LSArticolo set Prezzo = \''.$valore.'\' where Id_LSArticolo = \''.$chiave.'\'');
            if( $stmt === false ) {
                if( ($errors = sqlsrv_errors() ) != null) {
                    foreach( $errors as $error ) {
                        echo $error[ 'message']."<br />";
                    }
                }
            }
        }

        $barcodes = $_POST['barcode'];
        foreach($barcodes as $chiave => $valore){

            if($valore != ''){

                $sql = 'SELECT * FROM ARAlias where Riga = \''.$chiave.'\' and Cd_AR = \''.$_POST['Cd_AR'].'\'';
                $query_alias = sqlsrv_query( $conn, $sql );
                $esiste = sqlsrv_has_rows( $query_alias );

                if($esiste){
                    $stmt = sqlsrv_query($conn,'UPDATE ARAlias set Alias = \''.$valore.'\' where Riga = \''.$chiave.'\' and Cd_AR = \''.$_POST['Cd_AR'].'\'');
                    if( $stmt === false ) {
                        if( ($errors = sqlsrv_errors() ) != null) {
                            foreach( $errors as $error ) {
                                echo $error[ 'message']."<br />";
                            }
                        }
                    }

                } else {
                    sqlsrv_query( $conn,'INSERT INTO ARAlias (Alias,Riga,Cd_AR,Cd_ARMisura) VALUES (\''.$valore.'\',\''.$chiave.'\',\''.$_POST['Cd_AR'].'\',\'PZ\')');
                    if( $stmt === false ) {
                        if( ($errors = sqlsrv_errors() ) != null) {
                            foreach( $errors as $error ) {
                                echo $error[ 'message']."<br />";
                            }
                        }
                    }
                }

            } else {

                $sql = 'SELECT * FROM ARAlias where Riga = \''.$chiave.'\' and Cd_AR = \''.$_POST['Cd_AR'].'\'';
                $query_alias = sqlsrv_query( $conn, $sql );
                $esiste = sqlsrv_has_rows( $query_alias );

                if($esiste){
                    $sql = 'DELETE FROM ARAlias where Riga = \''.$chiave.'\' and Cd_AR = \''.$_POST['Cd_AR'].'\'';
                    $query_alias = sqlsrv_query( $conn, $sql );
                    if( $stmt === false ) {
                        if( ($errors = sqlsrv_errors() ) != null) {
                            foreach( $errors as $error ) {
                                echo $error[ 'message']."<br />";
                            }
                        }
                    }
                }

            }
        }
        $modificato = true;

    }



$sql = 'SELECT * FROM AR where Id_AR = '.$_GET['id'];
$query_articoli = sqlsrv_query( $conn, $sql );
if( $query_articoli === false) { die( print_r( sqlsrv_errors(), true) ); }
$articolo = sqlsrv_fetch_array( $query_articoli, SQLSRV_FETCH_ASSOC);

$sql = "SELECT ARGruppo1.Cd_ARGruppo1,ARGruppo2.Cd_ARGruppo2,ARGruppo3.Cd_ARGruppo3,CONCAT(ARGruppo1.Cd_ARGruppo1,';',ARGruppo2.Cd_ARGruppo2,';',ARGruppo3.Cd_ARGruppo3) as id,
CONCAT(ARGruppo1.Descrizione,' - ',ARGruppo2.Descrizione,' - ',ARGruppo3.Descrizione) as Descrizione from ARGruppo3
JOIN ARGruppo2 ON ARGruppo2.Cd_ARGruppo2 = ARGruppo3.Cd_ARGruppo2
JOIN ARGruppo1 ON ARGruppo1.Cd_ARGruppo1 = ARGruppo2.Cd_ARGruppo1";
$query_gruppi = sqlsrv_query( $conn, $sql );
$gruppi = sqlsrv_num_rows( $query_gruppi );
if( $query_gruppi === false) { die( print_r( sqlsrv_errors(), true) ); }


if(sizeof($articolo) > 0){ ?>

<?php

    $sql = 'SELECT * from ARAlias where Cd_AR = \''.$articolo['Cd_AR'].'\' order by Riga ASC';
    $query_alias = sqlsrv_query( $conn, $sql );
    $aliases = sqlsrv_num_rows( $query_alias );
    if( $query_alias === false) { die( print_r( sqlsrv_errors(), true) ); }


    $sql = 'SELECT LSArticolo.Id_LSArticolo,LS.Cd_LS,LS.Descrizione,LSArticolo.Prezzo from LSArticolo
        JOIN LSRevisione ON LSArticolo.id_LSRevisione = LSRevisione.Id_LSRevisione
        JOIN LS ON LS.Cd_LS = LSRevisione.Cd_LS
        where LSArticolo.CD_AR = \''.$articolo['Cd_AR'].'\'';
    $query_listini = sqlsrv_query( $conn, $sql );
    $listini = sqlsrv_has_rows( $query_listini );
    if( $query_listini === false) { die( print_r( sqlsrv_errors(), true) ); }

?>

<!doctype html>
<html lang="en" class="md">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, shrink-to-fit=no, viewport-fit=cover">
    <link rel="apple-touch-icon" href="img/f7-icon-square.png">
    <link rel="icon" href="img/f7-icon.png">
    <link rel="stylesheet" href="vendor/bootstrap-4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/materializeicon/material-icons.css">
    <link rel="stylesheet" href="vendor/swiper/css/swiper.min.css">
    <link id="theme" rel="stylesheet" href="css/style.css" type="text/css">
    <title>MobileUX</title>
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
                <a href="javascript:void(0)" onclick="window.history.back();"><i class="material-icons">keyboard_backspace</i></a>
            </div>
            <div class="col center">
                <a href="#" class="logo" style="text-decoration: none;"><?php echo $articolo['Descrizione'] ?></a>
            </div>
        </header>
        <div class="page-content">
            <?php if($modificato){ ?>
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
                    <form method="post" style="width:100%">
                        <div class="col-md-12">
                        <div class="row">

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="textinput">Codice</label>
                                    <input type="text" class="form-control" value="<?php echo $articolo['Cd_AR'] ?>" disabled>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="textinput">Descrizione</label>
                                    <input type="text" class="form-control" name="Descrizione" value="<?php echo $articolo['Descrizione'] ?>">
                                </div>
                            </div>

                            <?php if(sizeof($gruppi) > 0){ ?>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="textinput">Gruppi</label>
                                        <select class="form-control" id="exampleFormControlSelect1" name="gruppi">
                                            <?php while($gruppo = sqlsrv_fetch_array( $query_gruppi, SQLSRV_FETCH_ASSOC)){ ?>
                                                <option value="<?php echo $gruppo['id'] ?>" <?php echo ($articolo['Cd_ARGruppo3'] == $gruppo['Cd_ARGruppo3'])?'selected':'' ?>><?php echo $gruppo['Descrizione'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                            <?php } ?>

                            <?php if(sizeof($aliases) > 0){ $i = 1; ?>
                                <?php while($alias = sqlsrv_fetch_array( $query_alias, SQLSRV_FETCH_ASSOC)){ ?>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="textinput">Barcode <?php echo $i ?></label>
                                            <input type="text" class="form-control" name="barcode[<?php echo $i ?>]" value="<?php echo $alias['Alias'] ?>">
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

                            <?php if($listini){ ?>

                                <?php while($listino = sqlsrv_fetch_array( $query_listini, SQLSRV_FETCH_ASSOC)){ ?>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><?php echo $listino['Descrizione'] ?></label>
                                            <input type="text" class="form-control" id="<?php echo trim($listino['Cd_LS']) ?>" name="listino[<?php echo $listino['Id_LSArticolo'] ?>]" value="<?php echo number_format($listino['Prezzo'],3,'.','') ?>">
                                        </div>
                                    </div>

                                <?php } ?>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Margine %</label>
                                        <input type="text" id="margine" class="form-control" onkeyup="calcola_prezzo();">
                                    </div>
                                </div>


                            <?php } ?>

                            </div>
                        </div>
                        <br>
                        <input type="hidden" name="Cd_AR" value="<?php echo $articolo['Cd_AR'] ?>">
                        <button type="submit" name="modifica_articolo" value="Modifica Articolo" class="btn btn-danger mb-1 btn-block" style="width:200px;float:right;margin-right:20px;">Modifica Articolo</button>
                    </form>
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
<script src="vendor/cookie/jquery.cookie.js"></script>
<script src="vendor/sparklines/jquery.sparkline.min.js"></script>
<script src="vendor/circle-progress/circle-progress.min.js"></script>
<script src="vendor/swiper/js/swiper.min.js"></script>
<script src="js/main.js"></script>
</body>

</html>


    <script type="text/javascript">

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

    <?php } ?>

<?php } ?>
