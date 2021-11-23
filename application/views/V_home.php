<style>
    .hn-114 {
        height: 114px;
        height: calc(env(safe-area-inset-top) + 60px);
    }
    /* .carousel-item {
        height: 300px;
    }

    .carousel-item img {
        position: absolute;
        object-fit:scale-down;
        top: 0;
        left: 0;
        min-height: 300px;
    } */

    .carousel .carousel-item img {
        height: 200px;
        object-fit: cover;
    }

    @media (min-width: 768px) {
        .carousel .carousel-item img {
            height: 350px;
            object-fit: cover;
        }
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


    <!-- page content here -->
    <div class="container-fluid bg-template mb-4">
        <div class="row hn-114 position-relative">
            
            <!-- <div class="background opac heightset">
                <?php foreach ($banner as $b): ?>
                    <img src="<?= base_url('uploads/banner/').$b['images'] ?>" alt="">
                <?php endforeach; ?>
            </div> -->
            
        </div>
    </div>

    <div class="container">
        <div class="col-12">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner text-center">

                    <?php $i=0; foreach ($banner as $b): ?>
                        <div class="carousel-item <?= ($i == 0) ? 'active' : '' ?>">
                            <img class="d-block rounded w-100" src="<?= $url_img.'banner/'.$b['images'] ?>" >
                        </div>
                    <?php $i++; endforeach; ?>
                    
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>


    <div class="container py-5">
        <div class="row mb-4">
            <div class="col text-uppercase">
                <p class="text-mute mb-0">Asuransi</p>
                <h4 class="mb-0">Syariah</h4>
            </div>
            <div class="col-auto align-self-end"></div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- Swiper -->
                <div class="swiper-container swiper-prices mt-3">
                    <div class="swiper-wrapper">

                        <?php foreach ($lob as $c): ?>

                            <div class="swiper-slide pb-3">

                                <a href="<?= base_url('detail_produk/').$c['id_lob'] ?>" class="col-auto px-2" data-toggle="tooltip" data-placement="top" title="<?= $c['lob'] ?>">
                                    <figure class="avatar avatar-70 rounded-circle figure">
                                        <img src="<?= $url_img.'produk/'.$c['image'] ?>" alt="">
                                    </figure>
                                    
                                </a>
                            </div>
                            
                        <?php endforeach; ?>

                        <div class="swiper-slide pb-3">
                            <a href="<?= base_url('produk/') ?>" class="col-auto px-2" data-toggle="tooltip" data-placement="top" title="Semua Produk">
                                <figure class="avatar avatar-70 rounded-circle ">
                                    <img src="<?= base_url('assets/template_fe/') ?>images/weightless-60632_640%402x.png" alt="">
                                </figure>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row mb-4">
            <div class="col text-uppercase">
                <p class="text-mute mb-0">Literasi Keuangan</p>
                <h4 class="mb-0"> & Asuransi Syariah <small class="text-mute vm"></small></h4>
            </div>
            <div class="col-auto align-self-end">
                <a href="<?= base_url('berita') ?>">Tampilkan Semua</a>
            </div>
        </div>
        <div class="row">

            <?php foreach ($home_1 as $h1): ?>

                <div class="col-12 col-md-6">
                    <div class="card mb-4 overflow-hidden bg-template">
                        <div class="overlay"></div>
                        <div class="background">
                            <img src="<?= $url_img.'news/'.$h1['images'] ?>" alt="">
                        </div>
                        <div class="card-body">
                            <div class="row mb-5">
                                <div class="col">
                                    <span class="tag text-dark"><?= date("d F Y", strtotime($h1['add_time'])) ?></span>
                                </div>
                                <!-- <div class="col-auto">
                                    <button class="btn btn-info btn-rounded-34"><i class="material-icons md-16">bookmark</i></button>
                                    <button class="btn btn-info btn-rounded-34 ml-2"><i class="material-icons md-16">share</i></button>
                                </div> -->
                            </div>
                            <br>
                            <a href="<?= base_url('detail_berita/').$h1['id'] ?>" class="h4 mb-2 font-weight-normal"><?= $h1['title'] ?></a>
                            <p class="mb-2"><?= character_limiter(strip_tags($h1['news']), 500) ?></p>
                            <div class="small mb-0">
                                <?= $h1['sumber'] ?> | <?= $h1['editor'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            
            <?php endforeach; ?>

        </div>
        <div class="row">

        <?php foreach ($home_2 as $h2): ?>

            <div class="col-12 col-md-6 mb-4">
                <div class="row">
                    <div class="col-4">
                        <figure class="m-0 h-150 w-100 rounded overflow-hidden">
                            <div class="background">
                                <img src="<?= $url_img.'news/'.$h2['images'] ?>" alt="">
                            </div>
                        </figure>
                    </div>
                    <div class="col">
                        <a href="#" class="h4 mb-3 font-weight-normal"><?= $h2['title'] ?></a>
                        <p class="small text-mute"><?= character_limiter(strip_tags($h2['news']), 200) ?></p>
                        <a href="<?= base_url('detail_berita/').$h2['id'] ?>" class="text-dark">Selengkapnya <i class="material-icons vm md-16">arrow_forward</i></a>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
            
        </div>
        <!-- <div class="row">
            <div class="col-12 text-center">
                <button class="btn btn-light">Load more</button>
            </div>
        </div> -->
    </div>
    <div class="container my-5">
        <div class="row mb-4">
            <div class="col text-uppercase">
                <p class="text-mute mb-0">Muslim</p>
                <h4 class="mb-0">Hub</h4>
            </div>
            <div class="col-auto align-self-end"></div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- Swiper -->
                <div class="swiper-container swiper-categories">
                    <div class="swiper-wrapper">

                        <?php foreach ($muslim_hub as $m): ?>

                            
                                <div class="swiper-slide">
                                    <a href="<?= $m['link'] ?>" class="h6 mb-3 font-weight-normal" style="text-decoration:none;">
                                        <div class="mb-3 h-100px w-100px rounded overflow-hidden position-relative">
                                            <div class="background">
                                                <img src="<?= $url_img.'logo/'.$m['image'] ?>">
                                            </div>
                                            <div>
                                                <!-- <button class="btn btn-rounded-34 btn-info button-fab-right-bottom">
                                                    <i class="material-icons md-16">share</i>
                                                </button> -->
                                            </div>
                                        </div>
                                        
                                        <h6 class="font-weight-normal mb-1 text-center"><?= $m['nama'] ?></h6>
                                        
                                    </a>
                                </div>
                        <?php endforeach; ?>

                    </div>
                </div>

            </div>
        </div>
    </div>
    
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

        <?php $this->load->view('template_fe/temukan_kami');?>

    </div>
    <!-- page content ends -->


    <!-- footer -->
    <?php $this->load->view('template_fe/footer') ?>
    <!-- footer ends -->
</div>