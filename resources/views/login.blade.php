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

<body class="color-theme-red push-content-right theme-light" onload="check()">
<div class="loader justify-content-center ">
    <div class="maxui-roller align-self-center"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
</div>
<div class="wrapper">

    <!-- page main start -->
    <div class="page" >
        <div class="page-content">
            <div class="content-sticky-footer">

                <div class="row" style="height:750px;overflow-y: none;">
                    <div class="col-md-6">
                        <div class="background bg-250" style="height:50%;" ><img src="img/background.png" alt="" style="height:100%;" ></div>
                        <div class="w-100">

                            <img src="img/logo_arca.png" style="width:80%;padding:10%;margin:0 auto; display:block;">

                            <h1 class="text-center text-white title-background" style="margin-top:0">
                                <small>Arca Logistic<br></small>
                                <?php  echo $ditta->RagioneSociale ?></h1>
                        </div>
                    </div>

                    <div class="col-md-6" style="margin-top: -250px;text-align: center">
                        <form method="post">

                            <label style="font-size: medium;color: black">Username</label><br>
                            <input type="text" id="Utente" name="Utente" autocomplete="off"><br>

                            <label style="font-size: medium; color: black">Password</label><br>
                            <input type="password" id="Password" name="Password" autocomplete="off">

                            <button type="button" style="width: 30px;position: absolute;border-radius:30px 30px 30px 30px;" onclick="showPwd();" value="Mostra/nascondi password">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15"  fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 19">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                            </button>

                                <br><br>

                            <button type="submit" value="login" name="login" class="btn btn-danger btn-sm">Accedi</button>
                        </form>
                <!--

                        <p class="login-box-msg">
                            Effettua il Login
                        </p>
                        <ul class="list-group" >
                            <li class="list-group-item">


                                <a href="<?php echo URL::ASSET('articoli') ?>" class="media">
                                    <div class="media-body">
                                        <h5>Articoli</h5>
                                        <p>Gestisci gli articoli di Arca</p>
                                    </div>
                                </a>

                            </li>
                            <li class="list-group-item">
                                <a href="<?php echo URL::asset('magazzino') ?>" class="media">
                                    <div class="media-body">
                                        <h5>Magazzino</h5>
                                        <p>Gestisci il Magazzino di Arca</p>
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

                        </ul>
                -->
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
    function check() {
        check ='<?php echo $psw; ?>';

        if(check == '1')
            alert('La password non coincide. Riprova');
        if(check == '2')
            alert('Username inesistente. Riprova');
    }
    function showPwd() {
        var input = document.getElementById('Password');
        if (input.type === "password") {
            input.type = "text";
        } else {
            input.type = "password";
        }

    }

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
