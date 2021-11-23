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
    
    <div class="container pt-5">
        <div class="row mb-4">
            <div class="col text-uppercase">
                <p class="text-mute mb-0">Perlindungan</p>
                <h4 class="mb-0">Syariah</h4>
            </div>
            <div class="col-auto align-self-end">
                <!--<a href="#">View all</a>-->
            </div>
        </div>
        <div class="row">

            <!-- <div class="card shadow" style="width: 18rem;">
                <img class="card-img-top" src="<?= base_url('assets/template_fe/') ?>images/logo.png" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div> -->

            <?php foreach ($lob as $l): ?>

                <div class="col-md-3 mb-4 text-center">
                    <!-- <div class="mb-3 h-100px rounded overflow-hidden position-relative"> -->

                    <a href="<?= base_url('detail_produk/').$l['id_lob'] ?>" style="text-decoration:none;">
                    <div class="card shadow card_lob" style="height: 35rem;">
                        <img class="card-img-top" src="<?= $url_img.'produk/'.$l['image'] ?>" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title text-center"><?= $l['lob'] ?></h5>
                            <p class="card-text"><?= $l['deskripsi'] ?></p>
                        </div>
                    </div>
                    </a>
                        
                        <!-- <div class="background">
                            <img src="<?= base_url('uploads/logo/').$l['image'] ?>" alt="latestnews.html">
                        </div>
                        <div> -->
                            <!--<button class="btn btn-rounded-34 btn-info button-fab-right-bottom">
                                <i class="material-icons md-16">share</i>
                            </button>-->
                        <!-- </div>
                    </div>
                    <h6 class="font-weight-normal mb-1"><?= $l['lob'] ?></h6>
                    <p><span class="dot-notification mr-1"></span> <span class="text-mute"><?= $l['deskripsi'] ?></span></p> -->
                </div>

            <?php endforeach; ?>
        </div>
    </div>
    
    
    <div class="container my-5">
        <div class="row mb-4">
            <div class="col text-uppercase">
                <p class="text-mute mb-0">Rekanan</p>
                <h4 class="mb-0">Asuransi</h4>
            </div>
            <div class="col-auto align-self-end">
                <!--<a href="#">View all</a>-->
            </div>
        </div>

        <div class="row">

            <?php foreach ($rekanan_kami as $r): ?>

                <div class="col-md-3 text-center">

                    <img src="<?= $url_img.'rekanan/'.$r['logo_asuransi'] ?>" width="150px" alt="" class="mt-5">
                
                </div>
            <?php endforeach; ?>
                     
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