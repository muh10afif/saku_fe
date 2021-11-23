<style>
    .hn-114 {
        height: 114px;
        height: calc(env(safe-area-inset-top) + 60px);
    }
</style>
<div class="wrapper">
    <!-- header -->
    <div class="header">
        <div class="row no-gutters">
            <div class="col-auto">
                <button class="btn btn-link menu-btn"><i class="material-icons menu">menu</i><i class="material-icons closeicon">close</i><span class="new-notification"></span></button>
            </div>
            <div class="col text-left">
                <div class="header-logo">
                    <a href="<?= base_url() ?>">
                        <img src="<?= base_url('assets/template_fe/') ?>images/logo.png" alt="" class="header-logo">
                    </a>
                    <!--<h4>Syariah<br><small class="text-mute"> Asuransiku</small></h4>-->
                </div>
            </div>
            <div class="col-auto">
                <!--<a href="notification.html" class="btn btn-link"><i class="material-icons">notifications_none</i><span class="counts">9+</span></a>-->
            </div>
        </div>
    </div>
    <!-- header ends -->

    <div class="container-fluid bg-template mb-4">
        <div class="row hn-114 position-relative">
            <div class="container align-self-end">
                <!-- <input type="text" class="form-control form-control-lg search bottom-25 position-relative border-0" placeholder="Search"> -->
            </div>
        </div>
    </div>
    
    <div class="container pt-2">

        <div class="row">
            <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('berita') ?>">Berita</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
            </div>
        </div>
        
        <div class="row mb-4">
            <div class="col text-uppercase">
                <p class="text-mute mb-0">Berita</p>
                <h4 class="mb-0">Syariah</h4>
            </div>
            <div class="col-auto align-self-end">
                <!--<a href="#">View all</a>-->
            </div>
        </div>
        <div class="row">

            <div class="col-md-12 mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title"><?= $news['title'] ?></h5>
                        <div class="text-center mt-3 mb-3">
                            <img src="<?= $url_img.'news/'.$news['images'] ?>" class="img-fluid rounded" alt="Responsive image">
                        </div>
                        <br>
                        Sumber: <strong><?= $news['sumber'] ?></strong> | Editor: <strong><?= $news['editor'] ?></strong>
                        <br><br>
                        <?= $news['news'] ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
<br> 
    <div class="container my-5">
        <div class="row mb-4">
            <div class="col text-left">
                <p class="text-mute mb-0">Temukan Kami di</p>
                <h4 class="mb-0"></h4>
            </div>
            <div class="col-auto align-self-end">
                <a href="#"></a>
            </div>
        </div>

        <?php $this->load->view('template_fe/temukan_kami'); ?>
    </div>
    <!-- page content ends -->


    <!-- footer -->
    <?php $this->load->view('template_fe/footer') ?>
    <!-- footer ends -->
</div>

<script>
    $(document).ready(function () {

        
        
    })
</script>