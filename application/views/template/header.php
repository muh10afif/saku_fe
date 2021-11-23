<style>
    .asa {
        height: 500px;
        overflow-y: auto;
    }
</style>
<header id="topnav">
  <div class="topbar-main">
    <div class="ml-4 mr-4">
       <!-- Logo-->
       <div>
          <a href="<?= base_url() ?>" class="logo">
              <span class="logo-light">
                  <img src="<?= base_url() ?>assets/img/logo.png" alt="" height="50">
              </span>
          </a>
      </div>
      <!-- End Logo-->
      <div class="menu-extras topbar-custom navbar p-0">
        <ul class="navbar-right ml-auto list-inline float-right mb-0">
          <!-- <li class="dropdown notification-list list-inline-item">
            <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
              <span class="date-part"></span>&nbsp;~&nbsp;<span class="time-part"></span>
            </a>
          </li> -->
          <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
              <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
              <span class="date-part"></span>&nbsp;~&nbsp;<span class="time-part"></span>
              </a>
          </li>
          <li class="dropdown notification-list list-inline-item">
            <div class="dropdown notification-list nav-pro-img">
              <a class="dropdown-toggle nav-link arrow-none nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="<?= base_url() ?>assets/template/assets/images/users/user-4.jpg" alt="user" class="rounded-circle">
              </a>
              <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <a class="dropdown-item" href="#"><i class="mdi mdi-account-circle"></i> <?= wordwrap($this->session->userdata('username'),20,"<br>\n") ?></a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="<?= base_url('Auth/out') ?>"><i class="mdi mdi-power text-danger"></i> Logout</a>
              </div>
            </div>
          </li>
          <li class="menu-item dropdown notification-list list-inline-item">
                <!-- Mobile menu toggle-->
                <a class="navbar-toggle nav-link">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
            </li>
        </ul>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
  <div class="navbar-custom">
    <div class="ml-4 mr-4">
      <div id="navigation">
        <ul class="navigation-menu text-center">

          <!-- <li class="has-submenu">
            <a href="index.html"><i class="icon-accelerator ml-3"></i> Dashboard</a>
          </li> -->

          <li class="has-submenu dd">
              <a href="#"><i class="icon-diamond ml-3"></i> Data Home <i class="mdi mdi-chevron-down mdi-drop"></i></a>
              <ul class="submenu megamenu">
                  <li>
                      <ul>
                          <li><a href="<?= base_url('Banner') ?>">Banner</a></li>
                          <li><a href="<?= base_url('News') ?>">News</a></li>
                      </ul>
                  </li>
                  <li>
                      <ul>
                          <li><a href="<?= base_url('Muslim_hub') ?>">Muslim Hub</a></li>
                          <li><a href="<?= base_url('Temukan_kami') ?>">Temukan Kami</a></li>
                      </ul>
                  </li>
              </ul>
          </li>

          <li class="has-submenu dd">
              <a href="#"><i class="icon-website-1 ml-2"></i> Data Produk<i class="mdi mdi-chevron-down mdi-drop"></i></a>
              <ul class="submenu megamenu">
                  <li>
                      <ul>
                          <li><a href="<?= base_url('Lob') ?>">Line of Business</a></li>
                          <li><a href="<?= base_url('Produk_asuransi') ?>">Produk</a></li>
                          <li><a href="<?= base_url('Asuransi') ?>">Rekanan Asuransi</a></li>
                      </ul>
                  </li>
                  <li>
                      <ul>
                          <li><a href="<?= base_url('Manfaat') ?>">Manfaat</a></li>
                          <li><a href="<?= base_url('Syarat') ?>">Syarat</a></li>
                          <li><a href="<?= base_url('Pengecualian') ?>">Pengecualian</a></li>
                      </ul>
                  </li>
              </ul>
          </li>

          <li class="has-submenu da">
            <a href="<?= base_url('Tentang_kami') ?>"><i class="icon-accelerator ml-2"></i> Tentang Kami</a>
          </li>

        </ul>
      </div>
    </div>
  </div>
</header>
