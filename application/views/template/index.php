<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title><?= $title ?> | SAKU</title>
    <meta content="Responsive admin theme build on top of Bootstrap 4" name="description" />
    <meta content="Themesdesign" name="author" />
    <link rel="shortcut icon" href="<?= base_url() ?>assets/img/legowoICO.ico">

    <?php $this->load->view('template/css'); ?>
    <script src="<?= base_url() ?>assets/template/assets/js/jquery.min.js"></script>

    <style>
      #topnav .navigation-menu > li > a:hover {
        color: #006c45;
        background-color: #c2f1f0;
        border-radius: 0px 0px 0px 0px;
      }
      #topnav .navigation-menu > li .dd .active {
        color: #006c45;
        background-color: #c2f1f0;
        border-radius: 0px 0px 0px 0px;
      }
      #topnav .navigation-menu > li .submenu li a:hover {
        color: #006c45;
        background-color: #c2f1f0;
        border-radius: 0px 0px 0px 0px;
      }
      .dd.active {
        color: #006c45 !important;
        background-color: #c2f1f0;
        border-radius: 0px 0px 0px 0px;
      }
    </style>
</head>

<body>
  <div class="header-bg">
    <?php $this->load->view('template/header');?>
  </div>
  <div class="wrapper">
    <div class="ml-4 mr-4">
      <?= $konten ?>
    </div>
  </div>
  <footer class="footer">
  © 2021 Legowo <span class="d-none d-sm-inline-block"> - Powered By SKDigital</span>.
  </footer>
  <?php $this->load->view('template/js'); ?>
</body>

</html>
