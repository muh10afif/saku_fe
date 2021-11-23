<style>
    .hn-114 {
        height: 114px;
        height: calc(env(safe-area-inset-top) + 60px);
    }
    img {
        display: inline-block;
        height: auto;
        max-width: 100%;
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

    <div class="container-fluid bg-template">
        <div class="row hn-114 position-relative">
            <div class="container align-self-end">
               
            </div>
        </div>
    </div>
    
    <div class="container pt-5">
        <div class="row mb-4">
            <div class="col text-uppercase">
                <p class="text-mute mb-0">Tentang Kami</p>
                <h4 class="mb-0">Pelayanan Terbaik adalah Prioritas Kami</h4>
            </div>
            <div class="col-auto align-self-end mt-3">
                <?= $tentang['judul'] ?>
            </div>
        </div>
        <div class="row">

            
        </div>
    </div>

    <div class="container pt-5">
        <div class="row mb-4">
            <div class="col text-uppercase">
                <p class="text-mute mb-0">SAKU</p>
                <h4 class="mb-0">Syariah Asuransiku</h4>
            </div>
            <div class="col-auto align-self-end mt-3">
                <?= $tentang['isi'] ?>
            </div>
        </div>
        <div class="row">

            
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