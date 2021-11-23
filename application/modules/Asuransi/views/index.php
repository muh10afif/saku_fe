<style type="text/css">
  .col-form-label { font-size: 12px; }
  .swal-wide { width:920px !important; }
</style>
<style>
    .rmv {
        cursor: pointer;
        color: #fff;
        border-radius: 10px;
        border: 1px solid #fff;
        /* display: inline-block; */
        background: rgba(255, 0, 0, 1);
        margin-top: -25px;
    }
</style>
<div class="page-title-box">
  <div class="row align-items-center">
    <div class="col-sm-6"><h4><?= $title ?></h4></div>
    <div class="col-sm-6">
      <?php echo bredcumx(); ?>
    </div>
  </div>
</div>

<?php if ($role['read'] == true || $role == null): ?>
  <input type="hidden" id="status_toggle">
  <div class="row">
    <?php $this->load->view('input'); ?>
    <div class="col-md-12">
      <div class="card shadow">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-sm-6">
              <div class="text-left">
                <h5>List <?= $title ?></h5>
              </div>
            </div>
            <div class="col-sm-6">
              <?php if ($role['create'] == true || $role == null): ?>
                <div class="text-right">
                  <button class="btn btn-primary waves-effect waves-light mr-2" id="sendasu">Tambah Asuransi</button>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="card-body table-responsive">
          <table id="datatable" class="table table-bordered table-hover dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th width="5%">No</th>
                <th width="20%">Kode</th>
                <th width="20%">Asuransi</th>
                <th width="20%">Telepon</th>
                <th width="20%">PIC</th>
                <!-- <th width="20%">Kategori</th>
                <th width="20%">Tipe</th> -->
                <th width="5%">Aksi</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<script type="text/javascript">
  var table_asuransi = '';
  $(document).ready(function () {
    var act = "<?=$role['update'].'_'.$role['delete']?>";
    table_asuransi = $('#datatable').DataTable({
      "processing" : true,
      "serverSide" : true,
      "order" : [],
      "ajax" : {
        "url" : "<?php echo base_url(); ?>Asuransi/ajaxdata/"+act,
        "type" : "POST"
      },
      "columnDefs" : [{
        "targets" : [0,5],
        "orderable" : false
      },{
        'targets' : [0,5],
        'className' : 'text-center',
      }],
      "scrollX" : true
    });

    // 02-09-2021
    function readURL(input, imgControlName) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
            $(imgControlName).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image").change(function() {
        // add your logic to decide which image control you'll use
        var imgControlName = "#ImgPreview";
        readURL(this, imgControlName);
        // $('.preview1').addClass('it');
        $('.card-img').slideDown('fast');
        $('.btn-rmv1').addClass('rmv');
    });

    $("#removeImage1").click(function(e) {
        e.preventDefault();
        $("#image").val("");
        $("#ImgPreview").attr("src", "");
        // $('.preview1').removeClass('it');
        $('.btn-rmv1').removeClass('rmv');
        $('.card-img').slideUp('fast');
    });

    $('#sendasu').on('click', function () {
      $('.f_tambah').slideToggle('fast', function() {
        $('#changetitlenm').html('Input <?= $title ?>');
        if ($(this).is(':visible')) {
          $('#status_toggle').val(1);
        } else {
          $('#status_toggle').val(0);
        }
        getkode();
      });
    });

    $('.batal_entry').on('click', function (e) {
      e.preventDefault();
      $('.f_tambah').slideToggle('fast', function() {
        if ($(this).is(':visible')) {
          $('#status_toggle').val(1);
        } else {
          $('#status_toggle').val(0);
        }
        $('.hapus-asuransi').removeAttr('hidden');
        $('#sendasu').attr('hidden', false);
        $('#nama_asuransi').val('');
        $('#singkatan').val('');
        $('#id_tipe_as').val(null).trigger('change');
        $('#id_kategori_as').val(null).trigger('change');
        $('#telp').val('');
        $('#fax').val('');
        $('#website').val('');
        $('#email').val('');
        $('#idprov').val(null).trigger('change');
        $('#idkab').empty();
        $('#idkec').empty();
        $('#idkel').empty();
        $('#alamat').val('');
        $('#pic').val('');
        $('#telp_pic').val('');
        $('#email_pic').val('');
        $('#alamat_pic').val('');
      });
    });

    $('#idnega').on('change', function () {
      $("#idprov").empty();
      if ($(this).val() != '') {
        $.ajax({
          type:"GET",
          url:"<?php echo base_url(); ?>nasabah/getprov/"+$(this).val(),
          success  : function (data) {
            var prov = JSON.parse(data); var provv = "<option value=''>-- Pilih Provinsi --</option>";
            for (var i = 0; i < prov.length; i++) {
              provv = provv+"<option value='"+prov[i].id_provinsi+"'>"+prov[i].provinsi+"</option>";
            }
            $('#idprov').append(provv);
          }
        });
      }
    });

    $('#idprov').on('change', function () {
      $("#idkab").empty();
      if ($(this).val() != '') {
        $.ajax({
          type:"GET",
          url:"<?php echo base_url(); ?>nasabah/getkab/"+$(this).val(),
          success  : function (data) {
            var kab = JSON.parse(data); var kabkab = "<option value=''>-- Pilih Kota/Kabupaten --</option>";
            for (var i = 0; i < kab.length; i++) {
              kabkab = kabkab+"<option value='"+kab[i].id_kota+"'>"+kab[i].kota+"</option>";
            }
            $('#idkab').append(kabkab);
          }
        });
      }
    });

    $('#idkab').on('change', function () {
      $("#idkec").empty();
      if ($(this).val() != '') {
        $.ajax({
          type:"GET",
          url:"<?php echo base_url(); ?>nasabah/getkec/"+$(this).val(),
          success  : function (data) {
            var kec = JSON.parse(data); var keckec = "<option value=''>-- Pilih Kecamatan --</option>";
            for (var i = 0; i < kec.length; i++) {
              keckec = keckec+"<option value='"+kec[i].id_kecamatan+"'>"+kec[i].kecamatan+"</option>";
            }
            $('#idkec').append(keckec);
          }
        });
      }
    });

    $('#idkec').on('change', function () {
      $("#idkel").empty();
      if ($(this).val() != '') {
        $.ajax({
          type:"GET",
          url:"<?php echo base_url(); ?>nasabah/getkel/"+$(this).val(),
          success  : function (data) {
            var kel = JSON.parse(data); var kelkel = "<option value=''>-- Pilih Desa/Kelurahan --</option>";
            for (var i = 0; i < kel.length; i++) {
              kelkel = kelkel+"<option value='"+kel[i].id_desa+"'>"+kel[i].desa+"</option>";
            }
            $("#idkel").append(kelkel);
          }
        });
      }
    });

    $('#senddata').on('click', function (e) {
      e.preventDefault();

      var m    = $('#colectasu')[0];
      var form = new FormData(m);

      console.log(form);
      
      swal({
        title       : 'Konfirmasi',
        text        : 'Yakin data yang di input Sudah Benar ?',
        type        : 'warning',
        buttonsStyling      : false,
        confirmButtonClass  : "btn btn-primary",
        cancelButtonClass   : "btn btn-warning mr-3",
        showCancelButton    : true,
        confirmButtonText   : 'Ya',
        confirmButtonColor  : '#3085d6',
        cancelButtonColor   : '#d33',
        cancelButtonText    : 'Batal',
        reverseButtons      : true
      }).then((result) => {
        if (result.value) {
          var idas = $('#idasu').val();
          if (idas == "") {
            $.ajax({
              type:"POST",
              url:"<?php echo base_url(); ?>Asuransi/add",
              beforeSend : function () {
                swal({
                  title  : 'Menunggu',
                  html   : 'Memproses Data',
                  onOpen : () => {
                    swal.showLoading();
                  }
                })
              },
              data            : form,
              contentType     : false,
              cache           : false,
              processData     : false,
              dataType : "JSON",
              success  : function (data) {
                var isck = '';
                $(data['hasil']).each(function () {
                  if ($(this)[0].innerHTML != undefined) {
                    isck = isck+$(this)[0].innerHTML;
                  }
                });
                if (isck == "Format Email Tidak Sesuai" || isck == "Format Email Tidak SesuaiFormat Email Tidak Sesuai") {
                  swal({
                    title             : data['status'],
                    text              : "Format Email Tidak Sesuai",
                    type              : data['altr'],
                    showConfirmButton : false,
                    timer             : 3000
                  });
                } else {
                  swal({
                    title             : data['status'],
                    text              : data['pesan'],
                    type              : data['altr'],
                    showConfirmButton : false,
                    timer             : 3000
                  });
                  if (data['altr'] == 'success') {
                    alertfun(data['altr']);
                  }
                }
                table_asuransi.ajax.reload();
                return true;
              },
              error: function (jqXHR, textStatus, errorThrown) {
                swal({
                  title             : "Peringatan",
                  text              : "Koneksi Tidak Terhubung",
                  type              : 'warning',
                  showConfirmButton : false,
                  timer             : 3000
                });
                return false;
              }
            });
          } else {
            $.ajax({
              type:"POST",
              url:"<?php echo base_url(); ?>Asuransi/edit/"+idas,
              beforeSend : function () {
                swal({
                  title  : 'Menunggu',
                  html   : 'Memproses Data',
                  onOpen : () => {
                    swal.showLoading();
                  }
                })
              },
              data            : form,
              contentType     : false,
              cache           : false,
              processData     : false,
              dataType : "JSON",
              success  : function (data) {
                var isck = '';
                $(data['hasil']).each(function () {
                  if ($(this)[0].innerHTML != undefined) {
                    isck = isck+$(this)[0].innerHTML;
                  }
                });
                if (isck == "Format Email Tidak Sesuai" || isck == "Format Email Tidak SesuaiFormat Email Tidak Sesuai") {
                  swal({
                    title             : data['status'],
                    html              : data['hasil'],
                    type              : data['altr'],
                    showConfirmButton : false,
                    timer             : 3000
                  });
                } else {
                  swal({
                    title             : data['status'],
                    text              : data['pesan'],
                    type              : data['altr'],
                    showConfirmButton : false,
                    timer             : 3000
                  });
                  if (data['altr'] == 'success') {
                    $('#idasu').val('');
                    alertfun(data['altr']);
                  }
                }
                table_asuransi.ajax.reload();
                return true;
              },
              error: function (jqXHR, textStatus, errorThrown) {
                swal({
                  title             : "Peringatan",
                  text              : "Koneksi Tidak Terhubung",
                  type              : 'warning',
                  showConfirmButton : false,
                  timer             : 3000
                });
                return false;
              }
            });
          }
        } else if (result.dismiss === swal.DismissReason.cancel) {
          swal({
            title               : "Batal",
            text                : 'Anda membatalkan Penginputan Data Asuransi',
            buttonsStyling      : false,
            confirmButtonClass  : "btn btn-primary",
            type                : 'error',
            showConfirmButton   : false,
            timer             : 3000
          });
        }
      });
    });

    function alertfun(cekk) {
      if (cekk == 'success') {
        $('.f_tambah').slideToggle('fast', function() {
          if ($(this).is(':visible')) {
            $('#status_toggle').val(1);
          } else {
            $('#status_toggle').val(0);
          }
          $('#sendasu').attr('hidden', false);
        });
        window.scrollTo(0,0);
        $('.hapus-asuransi').removeAttr('hidden');
        $('#nama_asuransi').val('');
        $('#singkatan').val('');
        $('#id_tipe_as').val(null).trigger('change');
        $('#id_kategori_as').val(null).trigger('change');
        $('#telp').val('');
        $('#fax').val('');
        $('#website').val('');
        $('#email').val('');
        $('#idprov').val(null).trigger('change');
        $('#idkab').empty();
        $('#idkec').empty();
        $('#idkel').empty();
        $('#alamat').val('');
        $('#pic').val('');
        $('#telp_pic').val('');
        $('#email_pic').val('');
        $('#alamat_pic').val('');
        getkode();

        $('#image').val('');
        $("#ImgPreview").attr("src", "");
        $('.btn-rmv1').removeClass('rmv');
        $('.card-img').slideUp();
        $('.card-img-sblm').fadeOut();
        $('.judul_img').text('Image');
        $('#image').attr('required', true);
        $('.txt_image').fadeOut();
      }
    }

    function getkode() {
      $.ajax({
        type:"GET",
        url:"<?php echo base_url(); ?>Asuransi/asuransi_kode",
        success  : function (data) {
          $('#kode_asuransi').val(data);
        }
      });
    }
  });

  function ubahubah(id) {
    $('#changetitlenm').html('Edit <?= $title ?>');
    // $('.hapus-asuransi').attr('hidden', true);
    $('html, body').animate({
      scrollTop: $('body').offset().top
    }, 800);
    $.ajax({
      type:"GET",
      url:"<?php echo base_url(); ?>Asuransi/show/"+id,
      success  : function (data) {
        var hss = JSON.parse(data);
        $('#idasu').val(hss[0].id_asuransi);
        $('#kode_asuransi').val(hss[0].kode_asuransi);
        $('#nama_asuransi').val(hss[0].nama_asuransi);
        $('#singkatan').val(hss[0].singkatan);
        $('#id_tipe_as').val(hss[0].id_tipe_as).trigger('change');
        $('#id_kategori_as').val(hss[0].id_kategori_as).trigger('change');
        $('#telp').val(hss[0].telp);
        $('#fax').val(hss[0].fax);
        $('#website').val(hss[0].website);
        $('#email').val(hss[0].email);
        $('#alamat').val(hss[0].alamat);
        $('#pic').val(hss[0].pic);
        $('#telp_pic').val(hss[0].telp_pic);
        $('#email_pic').val(hss[0].email_pic);
        $('#alamat_pic').val(hss[0].alamat_pic);
        $('#idprov').val(hss[0].id_provinsi).trigger('change');
        setkab(hss[0].id_provinsi,hss[0].id_kota);
        setkec(hss[0].id_kota,hss[0].id_kecamatan);
        setkel(hss[0].id_kecamatan,hss[0].id_desa);
        if ($('#status_toggle').val() == 0) {
          $('.f_tambah').slideToggle('fast', function() {
            if ($(this).is(':visible')) {
              $('#status_toggle').val(1);
            } else {
              $('#status_toggle').val(0);
            }
          });
        }

        if (hss[0].logo_asuransi != null) {
          $('.card-img-sblm').fadeIn();
          $('#img_sblm').attr('src', "<?= $url_img.'rekanan/' ?>"+hss[0].logo_asuransi);
          $('.judul_img').text('Image Baru');

          // $('#image').removeAttr('required');
          $('.txt_image').fadeIn();
        } else {
          $('#image').val('');
          $("#ImgPreview").attr("src", "");
          $('.btn-rmv1').removeClass('rmv');
          $('.card-img').slideUp();
          $('.card-img-sblm').fadeOut();
          $('.judul_img').text('Image');
          // $('#image').attr('required', true);
          $('.txt_image').fadeOut();
        }
        
      },
      error: function (jqXHR, textStatus, errorThrown) {
        swal({
          title             : "Peringatan",
          text              : "Koneksi Tidak Terhubung",
          type              : 'warning',
          showConfirmButton : false,
          timer             : 3000
        });
        return false;
      }
    });
  }

  function detaild(id) {
    window.scrollTo(0,0);
    $.ajax({
      type:"GET",
      url:"<?php echo base_url(); ?>Asuransi/detail/"+id,
      beforeSend : function () {
        swal({
          title  : 'Menunggu',
          html   : 'Memproses Data',
          onOpen : () => {
            swal.showLoading();
          }
        })
      },
      success  : function (data) {
        var hss = JSON.parse(data);
        var lsd = "<div class='form-group row'>"+
                    "<label for='kode_asuransi' class='col-sm-3 col-form-label'><h5>Kode Asuransi :</h5></label>"+
                    "<div class='col-sm-3'><h5 style='margin-top:17px;'>"+hss[0].kode_asuransi+"</h5></div>"+
                  "</div>"+
                  "<hr style='margin-top:-20px;'>"+
                  "<div class='row'>"+
                    "<div class='col-md-6'>"+
                      "<table style='width:100%; text-align: left;'>"+
                        "<tr>"+
                          "<td style='width:40%;'><b>Nama Asuransi</b></td><td>:</td><td>"+hss[0].nama_asuransi+"</td>"+
                        "</tr>"+
                        "<tr>"+
                          "<td style='width:40%;'><b>Singkatan</b></td><td>:</td><td>"+(hss[0].singkatan == ""?'-':hss[0].singkatan)+"</td>"+
                        "</tr>"+
                        "<tr>"+
                          "<td style='width:40%;'><b>Tipe Asuransi</b></td><td>:</td><td>"+(hss[0].tipe_as == null?'-':hss[0].tipe_as)+"</td>"+
                        "</tr>"+
                        "<tr>"+
                          "<td style='width:40%;'><b>Kategori Asuransi</b></td><td>:</td><td>"+(hss[0].kategori_as == null?'-':hss[0].kategori_as)+"</td>"+
                        "</tr>"+
                      "</table>"+
                    "</div>"+
                    "<div class='col-md-6'>"+
                      "<table style='width:100%; text-align: left;'>"+
                        "<tr>"+
                          "<td style='width:37%;'><b>Telepon</b></td><td>:</td><td>"+hss[0].telp+"</td>"+
                        "</tr>"+
                        "<tr>"+
                          "<td style='width:37%;'><b>Fax</b></td><td>:</td><td>"+(hss[0].fax == ""?'-':hss[0].fax)+"</td>"+
                        "</tr>"+
                        "<tr>"+
                          "<td style='width:37%;'><b>Website</b></td><td>:</td><td>"+(hss[0].website == ""?'-':hss[0].website)+"</td>"+
                        "</tr>"+
                        "<tr>"+
                          "<td style='width:37%;'><b>Email</b></td><td>:</td><td>"+hss[0].email+"</td>"+
                        "</tr>"+
                      "</table>"+
                    "</div>"+
                  "</div>"+
                  "<hr>"+
                  "<div class='row'>"+
                    "<div class='col-md-6'>"+
                      "<table style='width:100%; text-align: left;'>"+
                        "<tr>"+
                          "<td style='width:40%;'><b>Negara</b></td><td>:</td><td>"+(hss[0].negara == null?'-':hss[0].negara)+"</td>"+
                        "</tr>"+
                        "<tr>"+
                          "<td style='width:40%;'><b>Provinsi</b></td><td>:</td><td>"+(hss[0].provinsi == null?'-':hss[0].provinsi)+"</td>"+
                        "</tr>"+
                        "<tr>"+
                          "<td style='width:40%;'><b>kabupaten/Kota</b></td><td>:</td><td>"+(hss[0].kota == null?'-':hss[0].kota)+"</td>"+
                        "</tr>"+
                      "</table>"+
                    "</div>"+
                    "<div class='col-md-6'>"+
                      "<table style='width:100%; text-align: left;'>"+
                        "<tr>"+
                          "<td style='width:37%;'><b>Kecamatan</b></td><td>:</td><td>"+(hss[0].kecamatan == null?'-':hss[0].kecamatan)+"</td>"+
                        "</tr>"+
                        "<tr>"+
                          "<td style='width:37%;'><b>Kelurahan/Desa</b></td><td>:</td><td>"+(hss[0].desa == null?'-':hss[0].desa)+"</td>"+
                        "</tr>"+
                        "<tr>"+
                          "<td style='width:37%; vertical-align:top;'><b>Alamat Lengkap<b></td><td style='vertical-align:top;'>:</td><td>"+(hss[0].alamat == null?'-':hss[0].alamat)+"</td>"+
                        "</tr>"+
                      "</table>"+
                    "</div>"+
                  "</div>"+
                  "<hr>"+
                  "<div class='row'>"+
                    "<div class='col-md-7'>"+
                      "<table style='width:100%; text-align: left;'>"+
                        "<tr>"+
                          "<td style='width:34%;'><b>Nama PIC<b></td><td>:</td><td>"+hss[0].pic+"</td>"+
                        "</tr>"+
                        "<tr>"+
                          "<td style='width:34%;'><b>Telepon PIC<b></td><td>:</td><td>"+hss[0].telp_pic+"</td>"+
                        "</tr>"+
                        "<tr>"+
                          "<td style='width:34%;'><b>Email PIC<b></td><td>:</td><td>"+hss[0].email_pic+"</td>"+
                        "</tr>"+
                        "<tr>"+
                          "<td style='width:34%; vertical-align:top;'><b>Alamat PIC<b></td><td style='vertical-align:top;'>:</td><td>"+hss[0].alamat_pic+"</td>"+
                        "</tr>"+
                      "</table>"+
                    "</div>"+
                  "</div>";
        swal({
          title             : "Detail Asuransi",
          html              : lsd,
          customClass       : 'swal-wide',
          showConfirmButton : true,
        });
      }
    });
  }

  function setkab(idpr, idkb) {
    if (idpr != null) {
      $("#idkab").empty();
      $.ajax({
        type:"GET",
        url:"<?php echo base_url(); ?>nasabah/getkab/"+idpr,
        success  : function (data) {
          var kab = JSON.parse(data); var kabkab = "<option value=''>-- Pilih Kota/Kabupaten --</option>";
          for (var i = 0; i < kab.length; i++) {
            if (kab[i].id_kota == idkb) {
              kabkab = kabkab+"<option value='"+kab[i].id_kota+"' selected>"+kab[i].kota+"</option>";
            } else {
              kabkab = kabkab+"<option value='"+kab[i].id_kota+"'>"+kab[i].kota+"</option>";
            }
          }
          $('#idkab').append(kabkab);
        }
      });
    }
  }

  function setkec(idkb, idkc) {
    if (idkb != null) {
      $("#idkec").empty();
      $.ajax({
        type:"GET",
        url:"<?php echo base_url(); ?>nasabah/getkec/"+idkb,
        success  : function (data) {
          var kec = JSON.parse(data); var keckec = "<option value=''>-- Pilih Kecamatan --</option>";
          for (var i = 0; i < kec.length; i++) {
            if (kec[i].id_kecamatan == idkc) {
              keckec = keckec+"<option value='"+kec[i].id_kecamatan+"' selected>"+kec[i].kecamatan+"</option>";
            } else {
              keckec = keckec+"<option value='"+kec[i].id_kecamatan+"'>"+kec[i].kecamatan+"</option>";
            }
          }
          $('#idkec').append(keckec);
        }
      });
    }
  }

  function setkel(idkc, idkl) {
    if (idkc != null) {
      $("#idkel").empty();
      $.ajax({
        type:"GET",
        url:"<?php echo base_url(); ?>nasabah/getkel/"+idkc,
        success  : function (data) {
          var kel = JSON.parse(data); var kelkel = "<option value=''>-- Pilih Kelurahan --</option>";
          for (var i = 0; i < kel.length; i++) {
            if (kel[i].id_desa == idkl) {
              kelkel = kelkel+"<option value='"+kel[i].id_desa+"' selected>"+kel[i].desa+"</option>";
            } else {
              kelkel = kelkel+"<option value='"+kel[i].id_desa+"'>"+kel[i].desa+"</option>";
            }
          }
          $('#idkel').append(kelkel);
        }
      });
    }
  }

  function deletedel(id) {
    swal({
      title       : 'Konfirmasi',
      text        : 'Yakin akan Menghapus Data Asuransi',
      type        : 'warning',
      buttonsStyling      : false,
      confirmButtonClass  : "btn btn-primary",
      cancelButtonClass   : "btn btn-warning mr-3",
      showCancelButton    : true,
      confirmButtonText   : 'Ya',
      confirmButtonColor  : '#3085d6',
      cancelButtonColor   : '#d33',
      cancelButtonText    : 'Batal',
      reverseButtons      : true
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type:"GET",
          url:"<?php echo base_url(); ?>Asuransi/remove/"+id,
          beforeSend : function () {
            swal({
              title  : 'Menunggu',
              html   : 'Memproses Data',
              onOpen : () => {
                swal.showLoading();
              }
            })
          },
          success  : function (data) {
            swal({
              title             : "Berhasil",
              text              : "Data Asuransi telah di Hapus",
              type              : 'success',
              showConfirmButton : false,
              timer             : 3000
            });
            table_asuransi.ajax.reload();
            $.ajax({
              type:"GET",
              url:"<?php echo base_url(); ?>Asuransi/asuransi_kode",
              success  : function (data) {
                $('#kode_asuransi').val(data);
              }
            });
            return true;
          },
          error: function (jqXHR, textStatus, errorThrown) {
            swal({
              title             : "Peringatan",
              text              : "Koneksi Tidak Terhubung",
              type              : 'warning',
              showConfirmButton : false,
              timer             : 3000
            });
            return false;
          }
        });
      } else if (result.dismiss === swal.DismissReason.cancel) {
        swal({
          title               : "Batal",
          text                : 'Anda membatalkan Hapus Asuransi',
          buttonsStyling      : false,
          confirmButtonClass  : "btn btn-primary",
          type                : 'error',
          showConfirmButton   : false,
          timer             : 3000
        });
      }
    });
  }
</script>
