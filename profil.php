<?php
session_start();
ob_start();
if(!isset($_SESSION['id_user'])) {
    header('location: https://smarthomesurveillance-web.ngrok.app/SHS_web/login.php');
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
                <?php
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }
                ?>
        <div class="container">
            <form method="post" enctype="multipart/form-data">
                <div class="row justify-content-center">
                    <div class="col-9 text-center">
                        <?php
                            include "koneksi.php";
                            $query_foto = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='".$_SESSION['id_user']."'");
                            $row_foto = mysqli_fetch_array($query_foto);
                            $foto = $row_foto['foto'];
                        ?>

                        <?php
                            if ($foto) {
                                echo "<span><img src='assets/img/$foto' style='width: 100px;' class='img-fluid rounded-circle pb-2'></span>";
                            } else {
                                echo "<span class='text-light' style='font-size: 100px;'><i class='fas fa-user-circle'></i></span>";
                            }
                        ?>
                        <?php
                            include "koneksi.php";
                            // Fungsi untuk mengenkripsi nama file
                            function encryptFileName($filename) {
                                $hash = md5(uniqid(rand(), true)); // Menggunakan md5 dan uniqid untuk membuat hash acak
                                $ext = pathinfo($filename, PATHINFO_EXTENSION); // Mendapatkan ekstensi file
                                return $hash . '.' . $ext; // Mengembalikan nama file yang dienkripsi dengan ekstensi yang sama
                            }

                            if (isset($_POST['upload']) && isset($_FILES['foto'])) {
                                $targetDir = "assets/img/";
                                $originalFileName = basename($_FILES["foto"]["name"]);
                                $encryptedFileName = encryptFileName($originalFileName);
                                $targetFilePath = $targetDir . $encryptedFileName;
                                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                            
                                // Cek apakah file yang diupload adalah gambar
                                $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                                if (in_array($fileType, $allowTypes)) {
                                    // Hapus file lama jika ada
                                    $query_foto = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='".$_SESSION['id_user']."'");
                                    $row_foto = mysqli_fetch_array($query_foto);
                                    $foto = $row_foto['foto'];
                                    $oldFilePath = "assets/img/$foto"; // Ganti dengan path lengkap file lama
                                    if (file_exists($oldFilePath)) {
                                        unlink($oldFilePath); // Hapus file lama
                                    }
                            
                                    // Simpan file di direktori target
                                    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFilePath)) {
                                        mysqli_query($koneksi, "UPDATE user SET foto='$encryptedFileName' WHERE id_user='".$_SESSION['id_user']."'");
                                        $_SESSION['message'] = "<div class='toast-container position-fixed top-0 end-0 p-3'>
                                        <div id='myToast' class='toast align-items-center text-white bg-success border-0' role='alert' aria-live='assertive' aria-atomic='true'>
                                        <div class='d-flex'>
                                            <div class='toast-body text-white'>
                                                <strong>Foto</strong> Berhasil Diunggah
                                            </div>
                                        <button type='button' class='btn-close btn-close-dark me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
                                        </div>
                                        </div>
                                        </div>";
                                        header("location: profil.php");
                                    } else {
                                        echo "Maaf, terjadi kesalahan saat mengupload file.";
                                    }
                                } else {
                                    $_SESSION['message'] = "<div class='toast-container position-fixed top-0 end-0 p-3'>
                                    <div id='myToast' class='toast align-items-center text-white bg-warning border-0' role='alert' aria-live='assertive' aria-atomic='true'>
                                    <div class='d-flex'>
                                        <div class='toast-body text-dark'>
                                            Maaf, hanya file JPG, JPEG, PNG, dan GIF yang diizinkan untuk diupload.
                                        </div>
                                    <button type='button' class='btn-close btn-close-dark me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
                                    </div>
                                    </div>
                                    </div>";
                                    header("location: profil.php");
                                }
                            }
                        ?>
                        <input class="form-control form-control-sm" type="file" name="foto" accept="image/*" required="">
                        <button class="btn btn-dark btn-sm mt-2" name="upload" type="submit"><i class="fas fa-upload"></i>&nbsp;Unggah</button>
                    </div>
                </div>
            </form>
                        <?php
                            include "koneksi.php";
                            $query_username = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='".$_SESSION['id_user']."'");
                            $row_username = mysqli_fetch_array($query_username);
                            $username = $row_username['nama_pengguna'];
                            $password = $row_username['kata_sandi'];
                        ?>
            <?php
                include "koneksi.php";

                if (isset($_POST['perbarui_user'])) {
                    $nama_pengguna = $_POST['nama_pengguna'];
                    $katasandi_lama = md5($_POST['katasandi_lama']);
                    $katasandi_baru = md5($_POST['katasandi_baru']);
                    $konfirmasi_katasandi = md5($_POST['konfirmasi_katasandi']);

                    if (empty($katasandi_lama) && empty($katasandi_baru) && empty($konfirmasi_katasandi)) {
                        if ($nama_pengguna !== $username) {
                            mysqli_query($koneksi, "UPDATE user SET nama_pengguna='$nama_pengguna' WHERE id_user='".$_SESSION['id_user']."'");
                            $query_simpan = mysqli_query($koneksi, "INSERT INTO kamera_rtsp(kameraRTSP) VALUES ('$kameraRTSP')");
                            $_SESSION['message'] = "<div class='toast-container position-fixed top-0 end-0 p-3'>
                            <div id='myToast' class='toast align-items-center text-white bg-success border-0' role='alert' aria-live='assertive' aria-atomic='true'>
                            <div class='d-flex'>
                                <div class='toast-body text-white'>
                                    <strong>Nama Pengguna</strong> Berhasil Diperbarui
                                </div>
                            <button type='button' class='btn-close btn-close-dark me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
                            </div>
                            </div>
                            </div>";
                            header("location: profil.php");
                        }
                    } else {
                        if (!empty($katasandi_lama) && !empty($katasandi_baru) && !empty($konfirmasi_katasandi)) {
                            if ($katasandi_lama === $password) {
                                if ($katasandi_baru === $konfirmasi_katasandi) {
                                    mysqli_query($koneksi, "UPDATE user SET kata_sandi='$katasandi_baru' WHERE id_user='".$_SESSION['id_user']."'");
                                    $_SESSION['message'] = "<div class='toast-container position-fixed top-0 end-0 p-3'>
                                    <div id='myToast' class='toast align-items-center text-white bg-success border-0' role='alert' aria-live='assertive' aria-atomic='true'>
                                    <div class='d-flex'>
                                        <div class='toast-body text-white'>
                                            <strong>Kata Sandi</strong> Berhasil Diperbarui
                                        </div>
                                    <button type='button' class='btn-close btn-close-dark me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
                                    </div>
                                    </div>
                                    </div>";

                                    if ($nama_pengguna !== $username) {
                                        mysqli_query($koneksi, "UPDATE user SET nama_pengguna='$nama_pengguna' WHERE id_user='".$_SESSION['id_user']."'");
                                        $_SESSION['message'] = "<div class='toast-container position-fixed top-0 end-0 p-3'>
                                        <div id='myToast' class='toast align-items-center text-white bg-success border-0' role='alert' aria-live='assertive' aria-atomic='true'>
                                        <div class='d-flex'>
                                            <div class='toast-body text-white'>
                                                <strong>Nama Pengguna & Kata Sandi</strong> Berhasil Diperbarui
                                            </div>
                                        <button type='button' class='btn-close btn-close-dark me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
                                        </div>
                                        </div>
                                        </div>";
                                        header("location: profil.php");
                                    } else {
                                        header("location: profil.php");
                                    }
                                } else {
                                    $_SESSION['message'] = "<div class='toast-container position-fixed top-0 end-0 p-3'>
                                    <div id='myToast' class='toast align-items-center text-white bg-danger border-0' role='alert' aria-live='assertive' aria-atomic='true'>
                                    <div class='d-flex'>
                                        <div class='toast-body text-white'>
                                            <strong>Konfirmasi Kata Sandi</strong> Tidak Sama
                                        </div>
                                    <button type='button' class='btn-close btn-close-dark me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
                                    </div>
                                    </div>
                                    </div>";
                                    header("location: profil.php");
                                }
                            } else {
                                $_SESSION['message'] = "<div class='toast-container position-fixed top-0 end-0 p-3'>
                                <div id='myToast' class='toast align-items-center text-white bg-danger border-0' role='alert' aria-live='assertive' aria-atomic='true'>
                                <div class='d-flex'>
                                    <div class='toast-body text-white'>
                                        <strong>Kata Sandi Lama</strong> Anda Salah!
                                    </div>
                                <button type='button' class='btn-close btn-close-dark me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
                                </div>
                                </div>
                                </div>";
                                header("location: profil.php");
                            }
                        } else {
                            $_SESSION['message'] = "<div class='toast-container position-fixed top-0 end-0 p-3'>
                            <div id='myToast' class='toast align-items-center text-white bg-danger border-0' role='alert' aria-live='assertive' aria-atomic='true'>
                            <div class='d-flex'>
                                <div class='toast-body text-white'>
                                    <strong>Data Wajib Diisi Semua</strong> Untuk Memperbarui Nama Pengguna dan Kata Sandi.
                                </div>
                            <button type='button' class='btn-close btn-close-dark me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
                            </div>
                            </div>
                            </div>";
                            header("location: profil.php");
                        }
                    }
                }
            ?>
            <form class="pt-4" method="post">
                <div class="row justify-content-center">
                    <div class="col-9">
                        <label class="form-label text-white">Nama Pengguna :</label>
                        <input class="form-control form-control-sm" type="text" name="nama_pengguna" value="<?php echo $username; ?>" placeholder="Nama Pengguna">
                        
                        <label class="form-label text-white pt-2">Kata Sandi Lama :</label>
                        <input class="form-control form-control-sm" type="password" placeholder="Kata Sandi Lama" name="katasandi_lama" minlength="8">
                        
                        <label class="form-label text-white pt-2">Kata Sandi Baru :</label>
                        <input class="form-control form-control-sm" type="password" placeholder="Kata Sandi Baru" name="katasandi_baru" minlength="8">
                        
                        <label class="form-label text-white pt-2">Konfirmasi Kata Sandi :</label>
                        <input class="form-control form-control-sm" type="password" placeholder="Konfirmasi Kata Sandi" name="konfirmasi_katasandi" minlength="8">

                        <p class="text-center pt-3">
                            <button class="btn btn-light btn-sm" type="reset"><i class="fa fa-refresh"></i>&nbsp;Reset</button>&nbsp;&nbsp;
                            <button class="btn btn-dark btn-sm" name="perbarui_user" type="submit"><i class="fa fa-save"></i>&nbsp;Perbarui</button>
                        </p>
                    </div>
                </div>
            </form>
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
                        <li class="nav-item pb-0 me-3"><a class="nav-link text-center" href="buzzer.php"><i class="fas fa-volume-up" style="font-size: 20px;"></i>
                                <p style="font-size: 11px;">Buzzer</p>
                            </a></li>
                        <li class="nav-item pb-0"><a class="nav-link active text-center" href="profil.php"><i class="fas fa-user" style="font-size: 20px;"></i>
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
                            header("location: profil.php");
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
                            header("location: profil.php");
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