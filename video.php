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
    <section id="Main" style="margin-top: 30%; margin-bottom: 25%;">
        <div class="container">
            <div class="row pb-4">
                <div class="col text-center">
                    <h1 class="text-white" style="font-family: 'ADLaM Display', serif;">Video</h1>
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }
                    ?>
                </div>
            </div>
            <?php
            require_once 'assets/getID3-master/getid3/getid3.php';
                    function getVideoDuration($filepath) {
                        $getID3 = new getID3;
                        $fileInfo = $getID3->analyze($filepath);
                    
                        if (isset($fileInfo['playtime_seconds'])) {
                            $duration = $fileInfo['playtime_seconds'];
                            $hours = floor($duration / 3600);
                            $minutes = floor(($duration / 60) % 60);
                            $seconds = $duration % 60;
                            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                        } else {
                            return false; // Jika durasi tidak ditemukan
                        }
                    }
            ?>
            <?php
            include "koneksi.php";
            $query_video = mysqli_query($koneksi, "SELECT * FROM video");
            while($row_video = mysqli_fetch_assoc($query_video)) {
                $id_video = $row_video['id_video'];
                $video = $row_video['video'];
                $filepath = "video/$video";
                $duration = getVideoDuration($filepath);
            ?>
            <div class="row align-items-center">
                <div class="col align-self-center"><video width="100%" height="100%"><source src="video/<?php echo $video; ?>" type="video/mp4"></video></div>
                <div class="col align-self-center">
                    <h6 class="text-white text-truncate" style="width: 110px;"><?php echo $video; ?></h6>
                    <p class="text-white"><?php echo $duration; ?></p>
                </div>
                <div class="col align-self-center">
                    <p class="text-center"><a class="btn btn-warning btn-sm" href="lihat_video.php?id_video=<?php echo $id_video ?>">&nbsp;<span class="text-truncate"><i class="fas fa-eye"></i>&nbsp;Lihat</span></a></p>
                    <p class="text-center"><button class="btn btn-dark btn-sm" id="downloadBtn<?php echo $id_video; ?>" name="download_video" type="button">&nbsp;<span class="text-truncate"><i class="fas fa-download"></i>&nbsp;Unduh</span></button></p>
                </div>
                <div class="col-12 text-white">
                <div class="progress" id="divProgress<?php echo $id_video; ?>" style="display: none;">
                    <div id="progressBar<?php echo $id_video; ?>" class="progress-bar progress-bar-striped bg-warning text-dark" role="progressbar" style="width: 0%;font-weight:bold;display:none;" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
                <script src="assets/js/jquery.min.js"></script>
                <script src="assets/bootstrap/js/bootstrap.min.js"></script>
                <script>
        $(document).ready(function() {
            $('#downloadBtn<?php echo $id_video; ?>').click(function() {
                // Tampilkan progress bar setelah tombol download diklik
                $('#divProgress<?php echo $id_video; ?>').show();
                $('#progressBar<?php echo $id_video; ?>').show();

                const url = 'download.php?file=<?php echo $video?>'; // Update this with your file name
                
                // Start the download
                const xhr = new XMLHttpRequest();
                xhr.open('GET', url, true);
                xhr.responseType = 'blob';

                xhr.onprogress = function(event) {
                    if (event.lengthComputable) {
                        const percentComplete = (event.loaded / event.total) * 100;
                        $('#progressBar<?php echo $id_video; ?>').css('width', percentComplete + '%').attr('aria-valuenow', percentComplete).text(Math.round(percentComplete) + '%');
                    }
                };

                xhr.onloadstart = function(event) {
                    $('#progressBar<?php echo $id_video; ?>').css('width', '0%').attr('aria-valuenow', 0).text('0%');
                };

                xhr.onloadend = function(event) {
                    $('#progressBar<?php echo $id_video; ?>').css('width', '100%').attr('aria-valuenow', 100).text('100%');
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
                            header("location: video.php");
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
                            header("location: video.php");
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