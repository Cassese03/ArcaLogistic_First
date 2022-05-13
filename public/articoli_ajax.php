<?php
$serverName = "DESKTOP-419ODUF\SQLEXPRESS";
$connectionInfo = array( "Database"=>"ADB_PIERRE_DISTR", "UID"=>"test", "PWD"=>"test123");
$conn = sqlsrv_connect( $serverName, $connectionInfo );
if( $conn === false ) {
    die( print_r( sqlsrv_errors(), true));
}

$sql = 'SELECT [Id_AR],[Cd_AR],[Descrizione] FROM AR where Cd_AR Like \'%'.$_GET['testo'].'%\' or  Descrizione Like \'%'.$_GET['testo'].'%\'  Order By Id_AR DESC';
echo $sql;
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
?>

    <?php while( $articolo = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) { ?>

        <li class="list-group-item">
            <a href="/articolo.php?id=<?php echo $articolo['Id_AR'] ?>" class="media">
                <div class="media-body">
                    <h5><?php echo $articolo['Descrizione'] ?></h5>
                    <p>Codice: <?php echo $articolo['Cd_AR'] ?></p>
                </div>
            </a>
        </li>

    <?php } ?>

