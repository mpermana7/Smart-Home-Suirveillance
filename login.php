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
    <section style="margin-top: 24%;">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h1 class="fw-bold text-white border-primary rubberBand animated" style="font-family: 'ADLaM Display', serif;">Smart Home Surveillance</h1>
                </div>
            </div>
            <div class="row pt-4">
                <div class="col">
                    <p class="text-center"><img class="img-fluid" src="assets/img/logo.png" width="40%"></p>
                </div>
            </div>
            <form method="post" class="pt-3">
                <div class="row justify-content-center">
                    <div class="col-9">
                    <?php
                    include "koneksi.php";

                    if (isset($_POST['tombol_masuk'])) {
                        $nama_pengguna = $_POST['nama_pengguna'];
                        $kata_sandi = md5($_POST['kata_sandi']);

                        if (!empty($nama_pengguna) && !empty($kata_sandi)) {
                            $query_user = mysqli_query($koneksi, "select id_user, nama_pengguna, kata_sandi FROM user WHERE nama_pengguna = '$nama_pengguna'");
                            $result_user = mysqli_num_rows($query_user);

                            if ($result_user == 1) {
                                $row = mysqli_fetch_assoc($query_user);
                                if ($row['kata_sandi'] == $kata_sandi) {
                                    $_SESSION['loggedin'] = true;
                                    $_SESSION['id_user'] = $row['id_user'];
                                    header("location: https://smarthomesurveillance-flask.ngrok.app");
                                    exit;
                                } else {
                    ?>
                                    <div class="toast-container position-fixed top-0 end-0 p-3">
                                    <div id="myToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                                    <div class="d-flex">
                                        <div class="toast-body text-dark">
                                            <strong>Nama Pengguna atau Kata Sandi</strong> Anda Salah, Silahkan Coba Lagi!
                                        </div>
                                    <button type="button" class="btn-close btn-close-dark me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                    </div>
                                    </div>
                    <?php
                                }
                            } else {
                    ?>
                                    <div class="toast-container position-fixed top-0 end-0 p-3">
                                    <div id="myToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                                    <div class="d-flex">
                                        <div class="toast-body text-dark">
                                            <strong>Nama Pengguna atau Kata Sandi</strong> Anda Salah, Silahkan Coba Lagi!
                                        </div>
                                    <button type="button" class="btn-close btn-close-dark me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                    </div>
                                    </div>
                    <?php
                            }
                        } else {
                    ?>
                                    <div class="toast-container position-fixed top-0 end-0 p-3">
                                    <div id="myToast" class="toast align-items-center text-white bg-warning border-0" role="alert" aria-live="assertive" aria-atomic="true">
                                    <div class="d-flex">
                                        <div class="toast-body text-dark">
                                            <strong>Nama Pengguna dan Kata Sandi</strong> Tidak Boleh Kosong!
                                        </div>
                                    <button type="button" class="btn-close btn-close-dark me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                    </div>
                                    </div>
                    <?php
                        }
                    }
                    ?>
                        <label class="form-label fw-semibold text-white">Nama Pengguna :</label>
                        <input class="form-control form-control-sm" type="text" placeholder="Nama Pengguna" name="nama_pengguna">
                        
                        <label class="form-label fw-semibold text-white pt-3">Kata Sandi :</label>
                        <input class="form-control form-control-sm" type="password" placeholder="Kata Sandi" name="kata_sandi" minlength="8">

                        <div class="d-grid gap-1 col-7 mx-auto pt-3">
                            <button class="btn btn-sm" type="submit" name="tombol_masuk" style="background: #001b2f;color: rgb(255,255,255);"><i class="fas fa-sign-in-alt"></i>&nbsp;Masuk</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row pt-3">
                <div class="col text-center"><span class="text-white" style="font-size: 10px;"><i class="far fa-copyright"></i>&nbsp;Smart Home Surveillance 2024</span></div>
            </div>
        </div>
    </section>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/aos.min.js"></script>
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