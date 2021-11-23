<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title> CMS | SAKU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="<?= base_url() ?>assets/img/legowoICO.ico">

    <link href="<?= base_url() ?>assets/swa/sweetalert2.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/template_login/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/template_login/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/template_login/assets/css/app.css" id="app-style" rel="stylesheet" type="text/css" />

    <style type="text/css">
      .field-icon {
        float: right;
        margin-left: -25px;
        margin-right: 10px;
        margin-top: -26px;
        position: relative;
        z-index: 2;
      }
      .btn-primary {
        color: #fff;
        background-color: #006c45 ;
        border-color: #006c45 ;
      }
      .btn-primary:hover {
        color: #fff;
        background-color: #e2961b;
        border-color: #e2961b;
      }
      .btn-primary:not(:disabled):not(.disabled).active, .btn-primary:not(:disabled):not(.disabled):active, .show>.btn-primary.dropdown-toggle {
        color: #fff;
        background-color: #e2961b;
        border-color: #e2961b;
      }
      .btn-primary.focus, .btn-primary:focus {
        color: #fff;
        background-color: #e2961b;
        border-color: #e2961b;
      }
    </style>
  </head>

  <body>
    <div class="account-pages my-5 pt-sm-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card overflow-hidden shadow">
              <div class="bg-login text-center">
                <div class="bg-login-overlay"></div>
                <div class="position-relative">
                  <h2 class="text-white mt-0 mb-0"><img src="<?= base_url() ?>assets/img/logo.png" alt="" height="90"></h2>
                </div>
              </div>
              <div class="card-body pt-4">
                <div class="p-2">
                  <form class="form-horizontal" method="POST" id="form-login" autocomplete="off">
                    <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                      <label for="userpassword">Password</label>
                      <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                      <i toggle="#password" class="fa fa-meh-rolling-eyes fa-lg field-icon toggle-password"></i>
                    </div><hr>
                    <div class="mt-3">
                      <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Login</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="mt-5 text-center"><p>Powered By Legowo © 2021</p></div>
          </div>
        </div>
      </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="<?= base_url() ?>assets/template_login/assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/template_login/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/template_login/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>assets/template_login/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url() ?>assets/template_login/assets/libs/node-waves/waves.min.js"></script>

    <script src="<?= base_url() ?>assets/swa/sweetalert2.all.min.js"></script>
    <script src="<?= base_url() ?>assets/template_login/assets/js/app.js"></script>

    <script type="text/javascript">
      $(document).ready(function () {
        $('#form-login').on('submit', function () {
          var username    = $('#username').val();
          var password    = $('#password').val();
          if ((username == "") && (password == "")) {
            $('#username').focus();
            swal({
              title             : "Peringatan",
              text              : 'Semua data harus terisi dahulu!',
              type              : 'warning',
              showConfirmButton : false,
              timer             : 1000
            });
            return false;
          } else if (username == "") {
            $('#username').focus();
            swal({
              title             : "Peringatan",
              text              : 'Username harus terisi dahulu!',
              type              : 'warning',
              showConfirmButton : false,
              timer             : 700
            });
            return false;
          } else if (password == "") {
            $('#password').focus();
            swal({
              title             : "Peringatan",
              text              : 'Password harus terisi dahulu!',
              type              : 'warning',
              showConfirmButton : false,
              timer             : 700
            });
            return false;
          } else {
            $.ajax({
              type : "post",
              url  : "auth/cek",
              beforeSend : function () {
                swal({
                  title  : 'Menunggu',
                  html   : 'Memproses Data',
                  onOpen : () => {
                    swal.showLoading();
                  },
                  allowOutsideClick   : false
                })
              },
              data     : {username:username, password:password},
              dataType : 'JSON',
              success  : function (data) {
                if (data.status == 1) {
                  var url = "<?= base_url('Banner') ?>";
                  window.location.href = url;
                } else if (data.status == 0) {
                  $('#username').val('');
                  swal({
                    title             : "Peringatan",
                    text              :  (data.pesan).toLowerCase().replace(/(?<= )[^\s]|^./g, a=>a.toUpperCase()),
                    type              : 'warning',
                    showConfirmButton : false,
                    timer             : 1000
                  });
                  $('#username').focus();
                  return false;
                } else if (data.status == 2) {
                  $('#password').val('');
                  swal({
                    title               : "Peringatan",
                    text                : (data.pesan).toLowerCase().replace(/(?<= )[^\s]|^./g, a=>a.toUpperCase()),
                    type                : 'warning',
                    showConfirmButton   : false,
                    timer               : 1000
                  });
                  $('#password').focus();
                  return false;
                }
              },
              error: function (jqXHR, textStatus, errorThrown) {
                swal({
                  title             : "Peringatan",
                  text              : "Koneksi Tidak Terhubung",
                  type              : 'warning',
                  showConfirmButton : false,
                  timer             : 1000
                });
                return false;
              }
            })
            return false;
          }
        })

        $(".toggle-password").click(function() {
          $(this).toggleClass("fa-meh-rolling-eyes fa-smile-beam");
          var input = $($(this).attr("toggle"));
          if (input.attr("type") == "password") {
            input.attr("type", "text");
          } else {
            input.attr("type", "password");
          }
        });
      })
    </script>
  </body>
</html>
