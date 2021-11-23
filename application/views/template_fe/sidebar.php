<div class="sidebar">
    <div class="row no-gutters">
        <div class="col-auto align-self-center">
            <figure class="avatar avatar-">
                <!--<img src="images/man-930397_640%402x.png" alt="">-->
            </figure>
        </div>
        <div class="col pl-3 align-self-center">
            <!--<p class="my-0">Maxartkiller</p>
            <p class="text-mute my-0 small">United States</p>-->
        </div>
        <div class="col-auto align-self-center">
            <!--<a href="login.html" class="btn btn-link text-white p-2"><i class="material-icons">power_settings_new</i></a>-->
        </div>
    </div>
    <div class="list-group main-menu my-5">
        <a href="<?= base_url('home') ?>" class="list-group-item list-group-item-action <?= ($title == 'home') ? 'active' : '' ?>"><i class="material-icons">home</i>Home</a>
        <a href="<?= base_url('produk') ?>" class="list-group-item list-group-item-action <?= ($title == 'produk') ? 'active' : '' ?>"><i class="material-icons">beenhere</i>Produk</a>
        <a href="https://play.google.com/store/apps/details?id=com.legowo.saku" class="list-group-item list-group-item-action"><i class="material-icons">file_download</i>Download Aplikasi</a>
        <a href="<?= base_url('tentang') ?>" class="list-group-item list-group-item-action <?= ($title == 'tentang_kami') ? 'active' : '' ?>"><i class="material-icons">info</i>Tentang Kami</a>
        <a href="https://api.whatsapp.com/send/?phone=%2B628112094777&text&app_absent=0" class="list-group-item list-group-item-action"><i class="material-icons">send</i>Hubungi Kami</a>

    </div>
</div>