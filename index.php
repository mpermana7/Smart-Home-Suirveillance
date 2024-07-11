<?php
session_start();
if(isset($_SESSION['id_user'])) {
    header('location: https://smarthomesurveillance-flask.ngrok.app');
}
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Smart Home Surveillance</title>
    <meta name="theme-color" content="#001b2f">
    <link rel="icon" type="image/png" sizes="718x734" href="assets/img/logo.png">
    <link rel="icon" type="image/png" sizes="718x734" href="assets/img/logo.png" media="(prefers-color-scheme: dark)">
    <link rel="icon" type="image/png" sizes="718x734" href="assets/img/logo.png">
    <link rel="icon" type="image/png" sizes="718x734" href="assets/img/logo.png" media="(prefers-color-scheme: dark)">
    <link rel="icon" type="image/png" sizes="718x734" href="assets/img/logo.png">
    <link rel="icon" type="image/png" sizes="718x734" href="assets/img/logo.png">
    <link rel="icon" type="image/png" sizes="718x734" href="assets/img/logo.png">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="manifest" href="manifest.json" crossorigin="use-credentials">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=ADLaM+Display&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alfa+Slab+One&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Anton&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Rubik+Bubbles&amp;subset=cyrillic,cyrillic-ext,hebrew,latin-ext&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/aos.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/Scrollspy.css">
</head>

<body style="background: rgb(13,110,253);">
    <section>
        <div class="container">
            <div class="row" style="margin-top: 35%;">
                <div class="col text-center">
                    <h1 class="fw-bold text-white border-primary rubberBand animated" style="font-family: 'ADLaM Display', serif;">Smart Home Surveillance</h1>
                </div>
            </div>
            <div class="row pt-5">
                <div class="col">
                    <p class="text-center"><img class="img-fluid" data-aos="fade" data-aos-delay="850" src="assets/img/logo.png" style="width: 50%;"></p>
                </div>
            </div>
            <div class="row pt-5">
                <div class="col">
                    <div class="d-grid gap-1 col-7 mx-auto"><a class="btn btn-primary" href="login.php" data-aos="fade-up" data-aos-delay="1000" type="button" style="background: rgb(0,27,45);">Mulai</a></div>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col text-center"><span class="text-white" data-aos="fade" data-aos-delay="1300" style="font-size: 10px;"><i class="far fa-copyright"></i>&nbsp;Smart Home Surveillance 2024</span></div>
            </div>
        </div>
    </section>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/aos.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
</body>

</html>