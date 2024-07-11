<?php
session_start();
ob_start();
if(!isset($_SESSION['id_user'])) {
    header('location: https://smarthomesurveillance-web.ngrok.app/SAS_flask/login.php');
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
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/Scrollspy.css">
</head>

<body style="background: rgb(13,110,253);">
    <section id="Header">
        <nav class="navbar navbar-expand fixed-top bg-primary pt-3 ps-1">
            <div class="container-fluid"><a class="navbar-brand" href="#"><img class="img-fluid" src="assets/img/logo.png" width="45px">&nbsp;<span class="text-white" style="font-size: 15px;font-family: 'ADLaM Display', serif;">Smart Home Surveillance</span></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link text-white" data-bs-toggle="modal" data-bs-target="#KeluarModal" href="#"><i class="fas fa-sign-out-alt"></i>&nbsp;Keluar</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="modal fade" role="dialog" tabindex="-1" id="KeluarModal">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><strong>Konfirmasi</strong></h5><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <h1 style="font-size: 45px;"><i class="fas fa-exclamation-triangle"></i></h1>
                        <p>Apakah anda ingin keluar ?</p>
                    </div>
                    <div class="modal-footer"><button class="btn btn-light btn-sm border rounded" type="button" data-bs-dismiss="modal"><i class="fas fa-times"></i>&nbsp;Tidak</button><a class="btn btn-dark btn-sm" href="logout.php" role="button"><i class="fas fa-check"></i>&nbsp;Ya, saya ingin keluar</a></div>
                </div>
            </div>
        </div>
    </section>
    <section id="Main" style="margin-top: 50%;">
                <?php
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }
                ?>
        <div class="container">
            <?php
                include "koneksi.php";
                $query_buzzer = mysqli_query($koneksi, "SELECT * FROM buzzer WHERE id_buzzer='1'");
                $row_buzzer = mysqli_fetch_assoc($query_buzzer);
                $status = $row_buzzer['status'];
            ?>
            <div class="row justify-content-center">
                <?php
                    if ($status == "Hidup") {
                        echo "
                            <div class='col-1 text-center'><span style='color: rgb(0,255,133);'><i class='fas fa-dot-circle'></i></span></div>
                            <div class='col-4 text-center'><span class='text-white'>Buzzer Hidup</span></div>
                            ";
                    } else {
                        echo "
                        <div class='col-1 text-center'><span style='color: rgb(255, 0, 0);'><i class='fas fa-dot-circle'></i></span></div>
                        <div class='col-4 text-center'><span class='text-white'>Buzzer Mati</span></div>
                        ";
                    }
                ?>
            </div>
            <div class="row pt-4">
                <div class="col text-center">
                    <?php
                        if ($status == "Hidup") {
                            echo "<form method='post'><button class='btn btn-light btn-lg border rounded-circle' type='submit' name='tombol_buzzer' style='width: 180px;height: 180px;'><i class='fas fa-power-off' style='font-size: 50px;'></i></button></form>";
                        } else {
                            echo "<form method='post'><button class='btn btn-light btn-lg border rounded-circle' type='button' style='width: 180px;height: 180px;' disabled><i class='fas fa-power-off' style='font-size: 50px;'></i></button></form>";
                        }
                    ?>
                    <?php
                        include "koneksi.php";
                        if (isset($_POST['tombol_buzzer'])) {
                            $query_mati = mysqli_query($koneksi, "UPDATE buzzer SET status='Mati' WHERE id_buzzer='1'");
                            header("location: buzzer.php");
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <section id="Navbar">
        <nav class="navbar navbar-expand fixed-bottom bg-black mt-0 mb-0 pt-0" data-bs-theme="dark" style="background: rgb(0,27,47);border-color: rgb(0,27,47);color: rgb(0,27,47);">
            <div class="container-fluid"><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-2"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-2">
                    <ul class="navbar-nav mx-auto mt-0 pt-1">
                        <li class="nav-item pb-0 me-3"><a class="nav-link text-center" href="https://smarthomesurveillance-flask.ngrok.app"><i class="fas fa-home" style="font-size: 20px;"></i>
                                <p style="font-size: 11px;">Beranda</p>
                            </a></li>
                        <li class="nav-item pb-0 me-3"><a class="nav-link text-center" href="#" data-bs-toggle="modal" data-bs-target="#CameraModal"><i class="fas fa-video" style="font-size: 20px;"></i>
                                <p class="text-truncate" style="font-size: 11px;">Kamera RTSP</p>
                            </a></li>
                        <li class="nav-item pb-0 me-3"><a class="nav-link text-center" href="video.php"><i class="fas fa-film" style="font-size: 20px;"></i>
                                <p style="font-size: 11px;">Video</p>
                            </a></li>
                        <li class="nav-item pb-0 me-3"><a class="nav-link active text-center" href="buzzer.php"><i class="fas fa-volume-up" style="font-size: 20px;"></i>
                                <p style="font-size: 11px;">Buzzer</p>
                            </a></li>
                        <li class="nav-item pb-0"><a class="nav-link text-center" href="profil.php"><i class="fas fa-user" style="font-size: 20px;"></i>
                                <p style="font-size: 11px;">Profil</p>
                            </a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="modal fade" role="dialog" tabindex="-1" id="CameraModal">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><strong>Kamera RTSP</strong></h5><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                    </div>
                    <?php
                    include "koneksi.php";
                    if (isset($_POST['simpan_kamera'])) {
                        $kameraRTSP = $_POST['kameraRTSP'];

                        if (empty($kameraRTSP)) {
                            $_SESSION['message'] = "<div class='toast-container position-fixed top-0 end-0 p-3'>
                            <div id='myToast' class='toast align-items-center text-white bg-danger border-0' role='alert' aria-live='assertive' aria-atomic='true'>
                            <div class='d-flex'>
                                <div class='toast-body text-white'>
                                    <strong>URL RTSP</strong> Tidak Boleh Kosong!
                                </div>
                            <button type='button' class='btn-close btn-close-dark me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
                            </div>
                            </div>
                            </div>";
                            header("location: buzzer.php");
                        } else {
                            $query_simpan = mysqli_query($koneksi, "INSERT INTO kamera_rtsp(kameraRTSP) VALUES ('$kameraRTSP')");
                            $_SESSION['message'] = "<div class='toast-container position-fixed top-0 end-0 p-3'>
                            <div id='myToast' class='toast align-items-center text-white bg-success border-0' role='alert' aria-live='assertive' aria-atomic='true'>
                            <div class='d-flex'>
                                <div class='toast-body text-white'>
                                    <strong>Kamera RTSP</strong> Berhasil Ditambahkan
                                </div>
                            <button type='button' class='btn-close btn-close-dark me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
                            </div>
                            </div>
                            </div>";
                            header("location: buzzer.php");
                        }
                    }
                    ?>
                    <form method="post">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col"><label class="form-label">URL RTSP :</label><input class="form-control form-control-sm" type="text" name="kameraRTSP" placeholder="rtsp://username:password@IpAddress:Port"></div>
                            </div>
                            <div class="row">
                                <div class="col text-center">
                                    <hr><a class="btn btn-outline-dark btn-sm" href="kamera_rtsp.php" role="button"><i class="fa fa-eye"></i>&nbsp;Kamera RTSP</a>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer"><button class="btn btn-light btn-sm border rounded" type="reset"><i class="fa fa-refresh"></i>&nbsp;Reset</button><button class="btn btn-dark btn-sm" type="submit" name="simpan_kamera" role="button"><i class="fas fa-save"></i>&nbsp;Simpan</button></div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var myToast = document.getElementById('myToast');
        var toast = new bootstrap.Toast(myToast);
        toast.show();
    });
    </script>
</body>
</html>