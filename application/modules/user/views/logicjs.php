<script type="text/javascript">
  var table_user = '';
  $(document).ready(function () {
    var act = "<?=$role['update'].'_'.$role['delete']?>";
    table_user = $('#datatable').DataTable({
      "processing" : true,
      "serverSide" : true,
      "order" : [],
      "ajax" : {
        "url" : "<?php echo base_url(); ?>user/ajaxdata/"+act,
        "type" : "POST"
      },
      "columnDefs" : [{
        "targets" : [0,3,6],
        "orderable" : false
      },{
        'targets' : [0,6],
        'className' : 'text-center',
      }]
    });

    $('#sikaryawan').hide();
    $('#otorisa').hide();
    $('#tertanggungdata').hide();
    $('[name="pilihn"]').on('change', function () {
      $('#sikaryawan').show();
      $("#pilkarya").empty();
      $('#lvloto').empty();
      var cnd = '';
      if ($(this).val() == 'Tertanggung') { // tertanggung
        cnd = 2;
        $('#otorisa').show();
        $('#tertanggungdata').show();
        $('#jdclient').val(null).trigger('change');
      } else if ($(this).val() == 'Asuransi') { // asuransi
        cnd = 1;
        $('#otorisa').show();
        $('#tertanggungdata').hide();
        $('#jdclient').val(null).trigger('change');
      } else if ($(this).val() == 'Pengguna Tertanggung') { // pengguna tertanggung
        cnd = 3;
        $('#otorisa').show();
        $('#tertanggungdata').hide();
        $('#jdclient').val(null).trigger('change');
      } else { // broker
        cnd = 0;
        $('#otorisa').show();
        $('#tertanggungdata').hide();
        $('#jdclient').val(null).trigger('change');
      }

      if (cnd == 1 || cnd == 0 || cnd == 3) {
        $.ajax({
          type:"GET",
          url:"<?php echo base_url(); ?>user/getlistnya/"+cnd,
          success  : function (data) {
            $("#pilkarya").empty();
            var hss = JSON.parse(data);
            var newOption = "<option value=''>-- Pilih --</option>";
            for (var i = 0; i < hss.length; i++) {
              if (cnd == 0) {
                newOption = newOption+"<option value='"+hss[i].id_karyawan+"'>"+hss[i].nama_karyawan+"</option>";
              } else if (cnd == 1) {
                newOption = newOption+"<option value='"+hss[i].id_asuransi+"'>"+hss[i].nama_asuransi+"</option>";
              } else {
                newOption = newOption+"<option value='"+hss[i].id_pengguna_tertanggung+"'>"+hss[i].nama+"</option>";
              }
            }
            $('#pilkarya').append(newOption).trigger('change');
          }
        });
        $('#pilkarya').val(null).trigger('change');
      }
    });

    $('#pilkarya').on('change', function (e) {
      e.preventDefault();
      var idpeng = $(this).val();
      var has = "";
      var penggn = $('[name="pilihn"]');
      for (var i = 0; i < penggn.length; i++) {
        if (penggn[i].checked) {
          has = penggn[i].value;
          break;
        }
      }
      if (idpeng != "") {
        $('#lvloto').empty();
        $.ajax({
          type:"POST",
          url:"<?php echo base_url(); ?>user/getlistoto",
          data:{idp:idpeng, lvl:has},
          dataType:"JSON",
          success:function (data) {
            var id_lvl_oto = $('#id_lvl_oto').val();
            
            var otto = '<option value="">-- Level Otorisasi --</option>';
            for (var i = 0; i < data.length; i++) {
              if (id_lvl_oto != '') {
                if (id_lvl_oto == data[i].id_level_otorisasi) {
                  $sel = 'selected';
                } else {
                  $sel = '';
                }
              } else {
                $sel = '';
              }
              
              otto = otto+'<option value='+data[i].id_level_otorisasi+' '+$sel+'>'+data[i].level_otorisasi+'</option>';
            }
            $('#lvloto').html(otto);
          }
        });
      }
    });

    $(".toggle-password").click(function() {
      $(this).toggleClass("fa-smile-beam fa-meh-rolling-eyes");
      var input = $($(this).attr("toggle"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });
    $(".toggle-password-con").click(function() {
      $(this).toggleClass("fa-smile-beam fa-meh-rolling-eyes");
      var input = $($(this).attr("toggle"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });

    $('#senddata').on('click', function () {
      if ($('#usname').val() != "" && $('#usname').val() != " ") {
        if ($('#password').val() == $('#con_pass').val()) {
          var idus = $('#idusr').val();
          var lvsr = $('[name="pilihn"]');
          var fcek = '';
          for (var i = 0; i < lvsr.length; i++) {
            if (lvsr[i].checked) {
              fcek = lvsr[i].value;
              break;
            }
          }
          if (idus == "") {
            $.ajax({
              type:"POST",
              url:"<?php echo base_url(); ?>user/add",
              beforeSend : function () {
                swal({
                  title  : 'Menunggu',
                  html   : 'Memproses Data',
                  onOpen : () => {
                    swal.showLoading();
                  }
                })
              },
              data: {
                idkywn:$('#pilkarya').val(),
                usernm:$('#usname').val(),
                passwd:$('#password').val(),
                lvotor:$('#lvloto').val(),
                fltabl:$('#jdclient').val(),
                lvlusr:fcek
              },
              dataType : "JSON",
              success  : function (data) {
                swal({
                  title             : data['judul'],
                  text              : data['status'],
                  type              : data['tipe'],
                  showConfirmButton : false,
                  timer             : 3000
                });
                table_user.ajax.reload();
                if (data['tipe'] == 'success') {
                  $('#clearall').trigger('click');
                }
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
              url:"<?php echo base_url(); ?>user/edit/"+idus,
              beforeSend : function () {
                swal({
                  title  : 'Menunggu',
                  html   : 'Memproses Data',
                  onOpen : () => {
                    swal.showLoading();
                  }
                })
              },
              data: {
                idkywn:$('#pilkarya').val(),
                usernm:$('#usname').val(),
                passwd:$('#password').val(),
                lvotor:$('#lvloto').val(),
                fltabl:$('#jdclient').val(),
                lvlusr:fcek
              },
              dataType : "JSON",
              success  : function (data) {
                swal({
                  title             : data['judul'],
                  text              : data['status'],
                  type              : data['tipe'],
                  showConfirmButton : false,
                  timer             : 3000
                });
                table_user.ajax.reload();
                if (data['tipe'] == 'success') {
                  $('#clearall').trigger('click');
                }
                lvsr.attr("disabled",false);
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
        } else {
          swal({
            title             : "Peringatan",
            text              : "Password Tidak Sama",
            type              : 'warning',
            showConfirmButton : false,
            timer             : 3000
          });
          return false;
        }
      } else {
        swal({
          title             : "Peringatan",
          text              : "Username tidak Boleh Kosong atau Spasi",
          type              : 'warning',
          showConfirmButton : false,
          timer             : 3000
        });
      }
    });

    $('#clearall').on('click', function () {
      $('#idusr').val('');
      $('#pilkarya').val(null).trigger('change');
      $('#usname').val('');
      $('#password').val('');
      $('#con_pass').val('');
      $('#lvloto').val(null).trigger('change');
      // $('[name="pilihn"]').attr('checked', false);
      $('#sikaryawan').hide();
      $('#otorisa').hide();
      $('#lvloto').empty();
      $('#tertanggungdata').hide();
      $('#jdclient').val(null).trigger('change');
      var lvsr = $('[name="pilihn"]');
      for (var i = 0; i < lvsr.length; i++) {
        if (lvsr[i].checked) {
          lvsr[i].checked = false;
        }
      }
      lvsr.attr("disabled",false);
    });
  });

  function ubahubah(id) {
    window.scrollTo(0,0);
    $('input[name=pilihn]').attr('checked', false);
    $.ajax({
      type:"GET",
      url:"<?php echo base_url(); ?>user/show/"+id,
      dataType:"JSON",
      success  : function (hss) {
        $('#pilkarya').empty();
        $('#idusr').val(hss[0].id_user);
        $('#usname').val(hss[0].username);
        $('#password').val(hss[0].password);
        $('#con_pass').val(hss[0].password);
        var lvsr = $('[name="pilihn"]');
        for (var i = 0; i < lvsr.length; i++) {
          if (lvsr[i].value == hss[0].level_user) {
            lvsr[i].checked = true;
          }
        }
        lvsr.attr("disabled",true);

        var id_lvl_oto = hss[0].id_level_otorisasi;

        $('#id_lvl_oto').val(id_lvl_oto);

        seeoto(hss[0].id_karyawan, hss[0].level_user, hss[0].id_level_otorisasi);
        switch (hss[0].level_user) {
          case 'Broker':
            $('#otorisa').show();
            $('#tertanggungdata').hide();
            $('#jdclient').val('').trigger('change');
            setuptertb(hss[0].id_karyawan);
            break;
          case 'Asuransi':
            $('#otorisa').show();
            $('#tertanggungdata').hide();
            $('#jdclient').val('').trigger('change');
            setupterta(hss[0].id_karyawan);
            break;
          case 'Tertanggung':
            $('#otorisa').show();
            $('#tertanggungdata').show();
            $('#jdclient').val(hss[0].flag_table).trigger('change');
            setupclient({value:hss[0].flag_table}, hss[0].id_karyawan);
            break;
          case 'Pengguna Tertanggung':
            $('#otorisa').show();
            $('#tertanggungdata').hide();
            $('#jdclient').val('').trigger('change');
            setuptertc(hss[0].id_karyawan);
            break;
        }
        $('#sikaryawan').show();
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

  //otorisasi
  function seeoto(idp, lv, oto) {
    $('#lvloto').empty();
    $.ajax({
      type:"POST",
      url:"<?php echo base_url(); ?>user/getlistoto",
      data:{idp:idp, lvl:lv},
      dataType:"JSON",
      success:function (data) {
        var id_lvl_oto  = $('#id_lvl_oto').val();
        var otto        = '<option value="">-- Level Otorisasi --</option>';
        
        for (var i = 0; i < data.length; i++) {
          if (oto == data[i].id_level_otorisasi) {
            otto = otto+'<option value='+data[i].id_level_otorisasi+' selected>'+data[i].level_otorisasi+'</option>';
          } else {
            otto = otto+'<option value='+data[i].id_level_otorisasi+'>'+data[i].level_otorisasi+'</option>';
          }
        }
        $('#lvloto').html(otto);
      }
    });
  }

  // broker
  function setuptertb(idk) {
    $('#pilkarya').empty();
    $.ajax({
      type:"GET",
      url:"<?php echo base_url(); ?>user/getlistnya/"+0,
      success  : function (data) {
        var hsx = JSON.parse(data); var newOption = "<option value=''>-- Pilih --</option>";
        for (var i = 0; i < hsx.length; i++) {
          if (idk == hsx[i].id_karyawan) {
            newOption = newOption+"<option value='"+hsx[i].id_karyawan+"' selected>"+hsx[i].nama_karyawan+"</option>";
          } else {
            newOption = newOption+"<option value='"+hsx[i].id_karyawan+"'>"+hsx[i].nama_karyawan+"</option>";
          }
        }
        $('#pilkarya').append(newOption);
      }
    });
  }

  // asuransi
  function setupterta(idnya) {
    $('#pilkarya').empty();
    $.ajax({
      type:"GET",
      url:"<?php echo base_url(); ?>user/getlistnya/"+1,
      success  : function (data) {
        var hss = JSON.parse(data); var newOption = "<option value=''>-- Pilih --</option>";
        for (var i = 0; i < hss.length; i++) {
          if (hss[i].id_asuransi == idnya) {
            newOption = newOption+"<option value='"+hss[i].id_asuransi+"' selected>"+hss[i].nama_asuransi+"</option>";
          } else {
            newOption = newOption+"<option value='"+hss[i].id_asuransi+"'>"+hss[i].nama_asuransi+"</option>";
          }
        }
        $('#pilkarya').append(newOption);
      }
    });
  }

  // peng tertanggung
  function setuptertc(idnya) {
    $('#pilkarya').empty();
    $.ajax({
      type:"GET",
      url:"<?php echo base_url(); ?>user/getlistnya/"+3,
      success  : function (data) {
        var hss = JSON.parse(data); var newOption = "<option value=''>-- Pilih --</option>";
        for (var i = 0; i < hss.length; i++) {
          if (hss[i].id_asuransi == idnya) {
            newOption = newOption+"<option value='"+hss[i].id_pengguna_tertanggung+"' selected>"+hss[i].nama+"</option>";
          } else {
            newOption = newOption+"<option value='"+hss[i].id_pengguna_tertanggung+"'>"+hss[i].nama+"</option>";
          }
        }
        $('#pilkarya').append(newOption);
      }
    });
  }

  //jika Tertanggung
  function setupclient(isinya, idk) {
    $('#pilkarya').empty();
    if (isinya.value != '') {
      $.ajax({
        type:"GET",
        url:"<?php echo base_url(); ?>user/getfromdb/"+isinya.value,
        success  : function (data) {
          $('#pilkarya').empty();
          var hss = JSON.parse(data); var newOption = '<option value="">-- Pilih --</option>';
          for (var i = 0; i < hss.length; i++) {
            if (hss[i].id == idk) {
              newOption = newOption+"<option value='"+hss[i].id+"' selected>"+hss[i].nama+"</option>";
            } else {
              newOption = newOption+"<option value='"+hss[i].id+"'>"+hss[i].nama+"</option>";
            }
          }
          $('#pilkarya').html(newOption);
        }
      });
    } else {
      $('#pilkarya').append("<option value=''>-- Pilih --</option>").trigger('change');
    }
  }

  function deletedel(id) {
    swal({
      title       : 'Konfirmasi',
      text        : 'Yakin akan Menghapus User',
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
          url:"<?php echo base_url(); ?>user/remove/"+id,
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
              text              : "Karyawan telah di Hapus",
              type              : 'success',
              showConfirmButton : false,
              timer             : 3000
            });
            table_user.ajax.reload();
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
          text                : 'Anda membatalkan Hapus karyawan',
          buttonsStyling      : false,
          confirmButtonClass  : "btn btn-primary",
          type                : 'error',
          showConfirmButton   : false,
          timer               : 3000
        });
      }
    });
  }
</script>
