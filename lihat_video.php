<?php
session_start();
ob_start();
if(!isset($_SESSION['id_user'])) {
    header('location: https://smarthomesurveillance-web.ngrok.app/SAS_web/login.php');
}
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, maximum-scale=1, user-scalable=no">
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
    <section id="Main" style="margin-top: 25%;">
                <?php
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }
                ?>
        <?php
        include "koneksi.php";
        $query_video = mysqli_query($koneksi, "select * from video where id_video='".$_GET['id_video']."'");
        $row_video = mysqli_fetch_assoc($query_video);
        $id_video = $row_video['id_video'];
        $video = $row_video['video'];
        if ($video) {
            $date_part = substr($video, 10, 8); // Mengambil "20240711"
            $date_formatted = DateTime::createFromFormat('Ymd', $date_part);
            if ($date_formatted !== false) {
                $date_formatted = $date_formatted->format('d-m-Y');
            } else {
                // Handle jika format tanggal tidak sesuai
                $date_formatted = "Tanggal tidak valid";
            }
        
            $time_part = substr($video, 19, 6); // Mengambil "073132"
            $time_formatted = substr($time_part, 0, 2) . ":" . substr($time_part, 2, 2) . ":" . substr($time_part, 4, 2);
        
            $datetime_info = $date_formatted . " " . $time_formatted; 
        } else {
            // Handle jika $video tidak memiliki nilai yang valid
            $datetime_info = "Video tidak ditemukan";
        }
        ?>
        <div class="container">
            <div class="row">
                <div class="col"><video width="100%" height="100%" controls autoplay><source src="video/<?php echo $video; ?>" type="video/mp4"></video></div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h5 class="text-white pt-2"><?php echo $video; ?></h5><span class="text-white" style="font-size: 12px;"><strong>Dibuat pada:</strong> <?php echo $datetime_info ?></span>
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-12 text-end"><button id="downloadBtn" class="btn btn-dark btn-sm me-1" type="button"><i class="fas fa-download"></i>&nbsp;Unduh</button><button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#HapusModal"><i class="fas fa-trash"></i>&nbsp;Hapus</button>
                    <div class="modal fade" role="dialog" tabindex="-1" id="HapusModal">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><strong>Konfirmasi</strong></h5><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <h1 style="font-size: 45px;"><i class="fas fa-trash"></i></h1>
                                    <p>Apakah anda ingin menghapusnya ?</p>
                                </div>
                                <?php
                                include "koneksi.php";
                                if (isset($_POST['hapus_video'])) {
                                    $id_video = $_POST['id_video'];
                                    $video = $_POST['video'];
                                    $query_hapus = mysqli_query($koneksi, "DELETE FROM video WHERE id_video='$id_video'");
                                    $_SESSION['message'] = "<div class='toast-container position-fixed top-0 end-0 p-3'>
                                    <div id='myToast' class='toast align-items-center text-white bg-warning border-0' role='alert' aria-live='assertive' aria-atomic='true'>
                                    <div class='d-flex'>
                                        <div class='toast-body text-dark'>
                                            <strong>$video</strong> Berhasil Dihapus
                                        </div>
                                    <button type='button' class='btn-close btn-close-dark me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
                                    </div>
                                    </div>
                                    </div>";
                                    header("location: video.php");
                                }
                                ?>
                                <form method="post"><div class="modal-footer"><input type="text" name="video" value="<?php echo $video; ?>" hidden><input type="text" name="id_video" value="<?php echo $id_video; ?>" hidden><button class="btn btn-light btn-sm border rounded" type="button" data-bs-dismiss="modal"><i class="fas fa-times"></i>&nbsp;Tidak</button><button class="btn btn-dark btn-sm" type="submit" name="hapus_video" role="button"><i class="fas fa-check"></i>&nbsp;Ya, hapus</button></div></form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 pt-2">
                <div class="progress" id="divProgress" style="display: none;">
                    <div id="progressBar" class="progress-bar progress-bar-striped bg-warning text-dark" role="progressbar" style="width: 0%;font-weight:bold;display:none;" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
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
                        <li class="nav-item pb-0 me-3"><a class="nav-link active text-center" href="video.php"><i class="fas fa-film" style="font-size: 20px;"></i>
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
                            header("location: lihat_video.php?id_video=$id_video");
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
                            header("location: lihat_video.php?id_video=$id_video");
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
    <script>
        $(document).ready(function() {
            $('#downloadBtn').click(function() {
                // Tampilkan progress bar setelah tombol download diklik
                $('#divProgress').show();
                $('#progressBar').show();

                const url = 'download.php?file=<?php echo $video?>'; // Update this with your file name
                
                // Start the download
                const xhr = new XMLHttpRequest();
                xhr.open('GET', url, true);
                xhr.responseType = 'blob';

                xhr.onprogress = function(event) {
                    if (event.lengthComputable) {
                        const percentComplete = (event.loaded / event.total) * 100;
                        $('#progressBar').css('width', percentComplete + '%').attr('aria-valuenow', percentComplete).text(Math.round(percentComplete) + '%');
                    }
                };

                xhr.onloadstart = function(event) {
                    $('#progressBar').css('width', '0%').attr('aria-valuenow', 0).text('0%');
                };

                xhr.onloadend = function(event) {
                    $('#progressBar').css('width', '100%').attr('aria-valuenow', 100).text('100%');
                };

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const blob = xhr.response;
                        const link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = '<?php echo $video?>'; // Update this with your file name
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    } else {
                        alert('Download failed.');
                    }
                };

                xhr.send();
            });
        });
    </script>
</body>
</html>