<!doctype html>
<html lang="en" class="color-theme-green">


<!-- Mirrored from maxartkiller.com/website/Lemux/lemux-HTML/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 02 Apr 2021 06:21:56 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="Maxartkiller">
    <link rel="shortcut icon" href="<?= base_url() ?>assets/img/legowoICO.ico">
    <title>SAKU</title>

    <?php $this->load->view('template_fe/css') ?>

    <script src="<?= base_url('assets/template_fe/') ?>js/jquery-3.3.1.min.js"></script>

    
</head>

<body>
    <!-- Loader -->
    <div class="row no-gutters vh-100 loader-screen">
        <div class="bg-template background-overlay"></div>
        <div class="col align-self-center text-white text-center">
            <img src="<?= base_url('assets/template_fe/') ?>images/saku_logo.png" alt="SAKU">
            <h1 class="mb-0 mt-3">Syariah</h1>
            <p class="text-mute subtitle"> Asuransiku</p>
            <div class="loader-ractangls">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <!-- Loader ends -->

    <!-- sidebar -->
    <?php $this->load->view('template_fe/sidebar'); ?>
    <!-- sidebar ends -->

    <!-- wrapper starts -->
    <?= $konten ?>
    <!-- wrapper ends -->

    <?php $this->load->view('template_fe/js'); ?>

</body>


<!-- Mirrored from maxartkiller.com/website/Lemux/lemux-HTML/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 02 Apr 2021 06:22:25 GMT -->
</html>
