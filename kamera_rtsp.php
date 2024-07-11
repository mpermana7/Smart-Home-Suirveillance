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
    <section id="Main" style="margin-top: 25%;margin-bottom: 25%;">
        <div class="container">
            <div class="row mb-4">
                <div class="col text-center">
                    <h1 class="text-truncate text-white" style="font-family: 'ADLaM Display', serif;">Kamera RTSP</h1>
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }
                    ?>
                </div>
            </div>
            <?php
            include "koneksi.php";
            $query_kamera = mysqli_query($koneksi, "SELECT * FROM kamera_rtsp");
            while($row_kamera = mysqli_fetch_assoc($query_kamera)){
                $id_kamera = $row_kamera['id_rtsp'];
                $kameraRTSP = $row_kamera['kameraRTSP'];
            ?>
            <?php
            if(isset($_POST['perbarui_kamera'.$row_kamera['id_rtsp']])) {
                $id_rtsp = $_POST['id_rtsp'];
                $kameraRTSP = $_POST['kameraRTSP'];
                

                if(empty($kameraRTSP)) {
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
                    header("location: kamera_rtsp.php");
                } else {
                    $query_perbarui = mysqli_query($koneksi, "UPDATE kamera_rtsp SET kameraRTSP='$kameraRTSP' WHERE id_rtsp='$id_rtsp'");
                    $_SESSION['message'] = "<div class='toast-container position-fixed top-0 end-0 p-3'>
                    <div id='myToast' class='toast align-items-center text-white bg-success border-0' role='alert' aria-live='assertive' aria-atomic='true'>
                    <div class='d-flex'>
                        <div class='toast-body text-white'>
                            <strong>Kamera RTSP</strong> Berhasil Diperbarui
                        </div>
                    <button type='button' class='btn-close btn-close-dark me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
                    </div>
                    </div>
                    </div>";
                    header("location: kamera_rtsp.php");
                }
            }
            ?>
            <?php
            if (isset($_POST['hapus_kamera'.$row_kamera['id_rtsp']])) {
                $id_rtsp = $_POST['id_rtsp'];
                $query_hapus = mysqli_query($koneksi, "DELETE FROM kamera_rtsp WHERE id_rtsp='$id_rtsp'");
                $_SESSION['message'] = "<div class='toast-container position-fixed top-0 end-0 p-3'>
                <div id='myToast' class='toast align-items-center text-white bg-warning border-0' role='alert' aria-live='assertive' aria-atomic='true'>
                <div class='d-flex'>
                    <div class='toast-body text-dark'>
                        <strong>Kamera RTSP</strong> Berhasil Dihapus
                    </div>
                <button type='button' class='btn-close btn-close-dark me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
                </div>
                </div>
                </div>";
                header("location: kamera_rtsp.php");
            }
            ?>
            <div class="row">
                <div class="col-9 align-self-center"><label class="col-form-label text-truncate text-white d-inline-block" style="width: 270px;"><?php echo $kameraRTSP ?></label></div>
                <div class="col-3 text-end align-self-center"><button class="btn btn-warning btn-sm me-1" type="button" data-bs-toggle="modal" data-bs-target="#EditModal<?php echo $id_kamera ?>"><i class="fa fa-edit"></i></button><button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#HapusModal<?php echo $id_kamera ?>"><i class="fa fa-trash"></i></button>
                    <form id="EditKameraRTSP" method="post">
                        <div class="modal fade" role="dialog" tabindex="-1" id="EditModal<?php echo $id_kamera ?>">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" style="font-family: 'ADLaM Display', serif;">Edit Kamera RTSP</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-start"><label class="form-label">URL RTSP :</label><input class="form-control form-control-sm" type="text" name="kameraRTSP" placeholder="rtsp://username:admin@ipaddress:port" value="<?php echo $kameraRTSP ?>" required=""><input type="text" name="id_rtsp" value="<?php echo $id_kamera?>" hidden></div>
                                    <div class="modal-footer"><button class="btn btn-light btn-sm border rounded border-secondary-subtle" type="reset"><i class="fa fa-refresh"></i>&nbsp;Reset</button><button class="btn btn-dark btn-sm" type="button" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#KonfirmasiEdit<?php echo $id_kamera ?>"><i class="fa fa-save"></i>&nbsp;Perbarui</button></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" role="dialog" tabindex="-1" id="KonfirmasiEdit<?php echo $id_kamera ?>">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" style="font-family: 'ADLaM Display', serif;">Konfirmasi</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <h1 class="display-1"><i class="fa fa-exclamation-triangle text-secondary"></i></h1>
                                        <p>Apakah Anda Ingin Mengubahnya?</p>
                                    </div>
                                    <div class="modal-footer"><button class="btn btn-light btn-sm border rounded" type="button" data-bs-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Tidak</button><button class="btn btn-dark btn-sm" name="perbarui_kamera<?php echo $id_kamera ?>" type="submit"><i class="fa fa-check"></i>&nbsp;Ya, Perbarui</button></div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form id="HapusKameraRTSP" method="post">
                        <div class="modal fade" role="dialog" tabindex="-1" id="HapusModal<?php echo $id_kamera ?>">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" style="font-family: 'ADLaM Display', serif;">Hapus Kamera RTSP</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <h1 class="display-1"><i class="fas fa-trash text-secondary"></i></h1>
                                        <p>Apakah Anda Ingin Menghapusnya ?</p>
                                        <input type="text" name="id_rtsp" value="<?php echo $id_kamera ?>" hidden>
                                    </div>
                                    <div class="modal-footer"><button class="btn btn-light btn-sm border rounded" type="button" data-bs-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Tidak</button><button class="btn btn-dark btn-sm" name="hapus_kamera<?php echo $id_kamera ?>" type="submit"><i class="fa fa-check"></i>&nbsp;Ya, Hapus</button></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col text-white">
                    <hr>
                </div>
            </div>
            <?php
            }
            ?>
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
                        <li class="nav-item pb-0 me-3"><a class="nav-link active text-center" href="#" data-bs-toggle="modal" data-bs-target="#CameraModal"><i class="fas fa-video" style="font-size: 20px;"></i>
                                <p class="text-truncate" style="font-size: 11px;">Kamera RTSP</p>
                            </a></li>
                        <li class="nav-item pb-0 me-3"><a class="nav-link text-center" href="video.php"><i class="fas fa-film" style="font-size: 20px;"></i>
                                <p style="font-size: 11px;">Video</p>
                            </a></li>
                        <li class="nav-item pb-0 me-3"><a class="nav-link text-center" href="buzzer.php"><i class="fas fa-volume-up" style="font-size: 20px;"></i>
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
                            header("location: kamera_rtsp.php");
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
                            header("location: kamera_rtsp.php");
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
                        <div class="modal-footer"><button class="btn btn-light btn-sm border rounded" type="reset"><i class="fa fa-refresh"></i>&nbsp;Reset</button><button class="btn btn-dark btn-sm" role="button" name="simpan_kamera" type="submit"><i class="fas fa-save"></i>&nbsp;Simpan</button></div>
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