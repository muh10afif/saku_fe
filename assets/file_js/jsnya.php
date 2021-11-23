
<script type="text/javascript">

    function preview() {  
      $('#exceltable').html('');  
      var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xlsx|.xls)$/;  
      /*Checks whether the file is a valid excel file*/  
      if (regex.test($("#excelfile").val().toLowerCase())) {  
          var xlsxflag = false; /*Flag for checking whether excel is .xls format or .xlsx format*/  
          if ($("#excelfile").val().toLowerCase().indexOf(".xlsx") > 0) {  
              xlsxflag = true;  
          }  
          /*Checks whether the browser supports HTML5*/  
          if (typeof (FileReader) != "undefined") {  
              var reader = new FileReader();  
              reader.onload = function (e) {  
                  var data = e.target.result;  
                  /*Converts the excel data in to object*/  
                  if (xlsxflag) {  
                      var workbook = XLSX.read(data, { type: 'binary' });  
                  }  
                  else {  
                      var workbook = XLS.read(data, { type: 'binary' });  
                  }  
                  /*Gets all the sheetnames of excel in to a variable*/  
                  var sheet_name_list = workbook.SheetNames;  
    
                  var cnt = 0; /*This is used for restricting the script to consider only first sheet of excel*/  
                  sheet_name_list.forEach(function (y) { /*Iterate through all sheets*/  
                      /*Convert the cell value to Json*/  
                      if (xlsxflag) {  
                          var exceljson = XLSX.utils.sheet_to_json(workbook.Sheets[y]);  
                      }  
                      else {  
                          var exceljson = XLS.utils.sheet_to_row_object_array(workbook.Sheets[y]);  
                      }  
                      if (exceljson.length > 0 && cnt == 0) {  
                          BindTable(exceljson, '#exceltable');  
                          cnt++;  
                      }  
                  });  
                  
                  $('#exceltable').show();  
                  $('#modal_preview').modal('show');
              }  
              if (xlsxflag) {/*If excel file is .xlsx extension than creates a Array Buffer from excel*/  
                  reader.readAsArrayBuffer($("#excelfile")[0].files[0]);  
              }  
              else {  
                  reader.readAsBinaryString($("#excelfile")[0].files[0]);  
              }  
          }  
          else {  

              swal({
                  title               : "Peringatan",
                  text                : 'Browser, tidak support HTML5',
                  type                : 'warning',
                  showConfirmButton   : false,
                  timer               : 1000
              }); 

              return false;
          }  
      }  
      else {  

          swal({
              title               : "Peringatan",
              text                : 'Harap Upload file terlebih dahulu!',
              type                : 'warning',
              showConfirmButton   : false,
              timer               : 1000
          }); 

          return false;
      }  
    }  

    function BindTable(jsondata, tableid) {/*Function used to convert the JSON array to Html Table*/  
        var columns = BindTableHeader(jsondata, tableid); /*Gets all the column headings of Excel*/  
        for (var i = 0; i < jsondata.length; i++) {  
            var row$ = $('<tr/>');  
            for (var colIndex = 0; colIndex < columns.length; colIndex++) {  
                var cellValue = jsondata[i][columns[colIndex]];  
                if (cellValue == null)  
                    cellValue = "";  
                row$.append($('<td/>').html(cellValue));  
            }  
            $(tableid).append(row$);  
        }  
    }  

    function BindTableHeader(jsondata, tableid) {/*Function used to get all column names from JSON and bind the html table header*/  
        var columnSet = [];  
        var headerTr$ = $('<tr/>');  
        for (var i = 0; i < jsondata.length; i++) {  
            var rowHash = jsondata[i];  
            for (var key in rowHash) {  
                if (rowHash.hasOwnProperty(key)) {  
                    if ($.inArray(key, columnSet) == -1) {/*Adding each unique column names to a variable array*/  
                        columnSet.push(key);  
                        headerTr$.append($('<th/>').html(key));  
                    }  
                }  
            }  
        }  
        $(tableid).append(headerTr$);  
        return columnSet;  
    } 
    
</script>
<script type="text/javascript">
  $(document).ready(function () {

    // 03-06-2021
    $('#clear').on('click', function () {

      $('#exceltable').html('');  
      $('#excelfile').val('');
      
    })

    $('.select2').select2({
        theme       : 'bootstrap4',
        width       : 'style',
        placeholder : $(this).attr('placeholder'),
        allowClear  : false
    });
    
    // 15-05-2021
    var tabel_entry = $('#tabel_entry').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "<?= base_url() ?>entry_sppa/tampil_data_entry",
            "type"  : "POST"
        },
        "columnDefs"        : [{
            "targets"   : [0,4],
            "orderable" : false
        }, {
            'targets'   : [0,4],
            'className' : 'text-center',
        }],
        "bDestroy" : true
    })

    $('#tambah_entry').on('click', function () {

      //   tambah_entry();
      $('#judul').text('Tambah SPPA');
      // $('.link_entry').addClass('disabled');

      var sts  = $('#status_toggle').val();

      $('html, body').animate({
          scrollTop: $('body').offset().top
      }, 800);

      if (sts == 0) {
          $('.f_tambah').slideToggle('fast', function() {
              if ($(this).is(':visible')) {
                  $('#status_toggle').val(1);          
              } else {  
                  $('#status_toggle').val(0);            
              }        
          });  
      }

      tampil_awal();

      // $.ajax({
      //   url     : "<?= base_url('entry_sppa/tampil_input') ?>",
      //   method  : "POST",
      //   success : function (data) {

      //     $('.t_input').html('');
      //     $('.t_input').html(data);

      //     var sts         = $('#status_toggle').val();

      //       $('html, body').animate({
      //           scrollTop: $('body').offset().top
      //       }, 800);

      //       if (sts == 0) {
      //           $('.f_tambah').slideToggle('fast', function() {
      //               if ($(this).is(':visible')) {
      //                   $('#status_toggle').val(1);          
      //               } else {  
      //                   $('#status_toggle').val(0);            
      //               }        
      //           });  
      //       }
          
      //   },
      //   error: function (jqXHR, textStatus, errorThrown)
      //   {
      //       swal({
      //           title               : "Gagal",
      //           text                : 'Gagal proses data',
      //           type                : 'error',
      //           showConfirmButton   : false,
      //           timer               : 1000
      //       }); 

      //       return false;
      //   }
      // })

      $.ajax({
        url     : "<?= base_url('entry_sppa/get_kode') ?>",
        method  : "POST",
        dataType: "JSON",
        success : function (data) {

          $('#sppa_number').text(data.sppa_number);
          
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            swal({
                title               : "Gagal",
                text                : 'Gagal proses data',
                type                : 'error',
                showConfirmButton   : false,
                timer               : 1000
            }); 

            return false;
        }
      })

      $('.select2').select2({
          theme       : 'bootstrap4',
          width       : 'style',
          placeholder : $(this).attr('placeholder'),
          allowClear  : false
      });
      
    })

    // semula
    function tampil_awal() {
      $('.non_mop').slideDown();
      $('.f_tab').slideDown();
      $('.f_tab_detail').slideUp();
      $('.f_tab_edit').slideUp();
      $('.footer_input').slideUp();

      // $('.link_entry').addClass('disabled');
      activaTab('t_client_data'); 
      // $('.link_entry').addClass('disabled');
      activaTab('t_client_data1'); 

      $('#sobb').val('pilih').trigger('change');
      $('#cobb').val('pilih').trigger('change');

      $('#acc_deklarasi').prop("checked", false);
      $('#acc_mop').prop("checked", false);
      $('.check_deklarasi').slideUp(30);
      $('.sel_deklarasi').slideUp(30);
      $('.sel_mop').slideUp(30);
      $('.check_mop').removeClass('col-md-2').addClass('col-md-4');

      $('.id_mop').val('');

      $('#exceltable').html('');  
      $('#excelfile').val('');

      $('#id_detail_sob').val('');

      $('#simpan_client').attr('disabled', true);
      $('.lanjutkan').attr('disabled', true);
      $('.simpan_semua').attr('disabled', true);

      $('#tsi').val('');
      $('#diskon').val('');
      $('#show_premi').html('');
      $('#show_additional').html('');
      $('#payment_method').val('');

      $('#sobb').attr('disabled', false);
      $('#cobb').attr('disabled', false);

      $('.lanjutkan_client').attr('aksi', 't_detail1');
      $('.link_t_detail1').attr('hidden', false);

      total2();
    }

    $('.batal_entry').on('click', function () {
      $('#form_entry').trigger("reset");
      $('#aksi').val('Tambah');
      $('.hapus-entry').removeAttr('hidden');
      $('.f_tambah').slideToggle('fast', function() {
        if ($(this).is(':visible')) {
          $('#status_toggle').val(1);
        } else {
          $('#status_toggle').val(0);
        }
      });
      $('#tambah_entry').attr('hidden', false);
    })

    $('#sobb').change(function () {
      var id            = $(this).val();
      var txt           = $(this).find(':selected').text();
      var id_detail_sob = $('#id_detail_sob').val();

      var no_reff_mop   = $('#no_reff_mop').val();

      var deklarasi     = $('#acc_deklarasi').prop("checked");

      $('.nama_sob').val(txt);

      if (id == 'pilih') {

        $('.d2_sob').slideUp(100);
        $('#tocc').attr('disabled', true);
        $('#tocc').val('pilih').trigger('change');
        $('#lbln').text('Detail SOB');
        
      } else {

        $.ajax({
          type      :"GET",
          url       :"<?php echo base_url(); ?>entry_sppa/settoc/"+id,
          success   : function (data) {
            
            var hss = JSON.parse(data);

            if (hss[0].length <= 0) {

              swal({
                title             : "Peringatan",
                html              : "List data "+txt+" kosong",
                type              : 'warning',
                showConfirmButton : false,
                timer             : 1000
              });
              
              $('#lbln').html("SOB "+hss[1]);
              $('.d2_sob').slideUp();
              $('#tocc').attr('disabled', true);
              $('#tocc').val('pilih').trigger('change');

            } else {

              var opt = '<option value="pilih">Pilih</option>';
              for (var i = 0; i < hss[0].length; i++) {

                var sel;

                if (hss[0][i].id == id_detail_sob) {
                  sel = 'selected';
                } else {
                  sel = '';
                }

                opt = opt+'<option value='+hss[0][i].id+' '+sel+'>'+hss[0][i].nama+'</option>';

                if (id_detail_sob != '') {
                  sel_tampil_detail(id, id_detail_sob);
                }
                
              }

              $('#tocc').attr('disabled', false);
              $('#lbln').html("SOB "+hss[1]);
              $('#tocc').html(opt);
              $('.set-here').html('');

              // if (no_reff_mop != '') {
              //   $('#tocc').attr('disabled', true);
              // } else {
              //   $('#tocc').attr('disabled', false);
              // }
              
            }

            $('.d2_sob').slideUp();

          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              swal({
                  title               : "Gagal",
                  text                : 'Gagal menampilkan data',
                  type                : 'error',
                  showConfirmButton   : false,
                  timer               : 1000
              }); 

              return false;
          }
        }); 

      }

      disabled_client_data();
      
    });

    // 02-06-2021
    function sel_tampil_detail(id_sob, id_detail_sob) {
      $.ajax({
        type      :"POST",
        url       :"<?php echo base_url(); ?>entry_sppa/showdetailn",
        data      : { isob:id_sob, ityp:id_detail_sob },
        dataType  : "JSON",
        success   : function (data) {

          if (data[0][0].nama) {
            $('#d2_nama').text(": "+data[0][0].nama);
            $('#d2_alamat').text(": "+data[0][0].alamat);
            $('.d2_sob').slideDown(); 
          } else {
            $('.d2_sob').slideUp(); 
          }

          
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            swal({
                title               : "Gagal",
                text                : 'Gagal menampilkan data',
                type                : 'error',
                showConfirmButton   : false,
                timer               : 1000
            }); 

            return false;
        }
      });
    }

    $('#tocc').change(function () {
      var id = $(this).val();
      var sb = $('#sobb').val();

      if (sb != 'pilih') {
        $.ajax({
          type      :"POST",
          url       :"<?php echo base_url(); ?>entry_sppa/showdetailn",
          data      : { isob:sb, ityp:id },
          dataType  : "JSON",
          success   : function (data) {

            if (data[0][0].nama) {
              $('#d2_telp').text(": "+data[0][0].telp);
              $('#d2_alamat').text(": "+data[0][0].alamat);
              $('.d2_sob').slideDown(); 
            } else {
              $('.d2_sob').slideUp(); 
            }

            
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              swal({
                  title               : "Gagal",
                  text                : 'Gagal menampilkan data',
                  type                : 'error',
                  showConfirmButton   : false,
                  timer               : 1000
              }); 

              return false;
          }
        });
      }

      disabled_client_data();
    });

    $('#cobb').change(function () {
      var id          = $(this).val();
      var id_lobb     = $('#id_lobb').val();

      var no_reff_mop = $('#no_reff_mop').val();

      if (id == 'pilih') {

        var opt = '<option value="pilih" id_relasi="pilih">Pilih</option>';
        $('#lobb').html(opt);
        $('#lobb').attr('disabled', true);
        $('#lobb').val('pilih').trigger('change');

        // $('.c_lob').fadeOut(100);

      } else {

        $.ajax({
          type:"GET",
          url:"<?php echo base_url(); ?>entry_sppa/showboth/"+id,
          success  : function (data) {
            $('#lobb').attr('disabled', false);
            var hss = JSON.parse(data); 
            var opt = '<option value="pilih" id_relasi="pilih">Pilih</option>';
            for (var i = 0; i < hss.length; i++) {
              opt = opt+'<option value='+hss[i].id_lob+' id_relasi='+hss[i].id_relasi_cob_lob+'>'+hss[i].lob+'</option>';
            }
            $('#lobb').html(opt);

            if (id_lobb != '') {
              $('#lobb').val(id_lobb).trigger('change');
            }

            // if (no_reff_mop != '') {
            //     $('#lobb').attr('disabled', true);
            //   } else {
            //     $('#lobb').attr('disabled', false);
            //   }

            // $('.c_lob').fadeIn();
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              swal({
                  title               : "Gagal",
                  text                : 'Gagal menampilkan data',
                  type                : 'error',
                  showConfirmButton   : false,
                  timer               : 1000
              }); 

              return false;
          }
        });

      }

      if (id_lobb != '') {
        $('#simpan_client').attr('disabled', false);
      } else  {
        disabled_client_data();
      }
      
    });

    $('#lobb').change(function () {
      var id        = $(this).val();
      var id_relasi = $(this).find(':selected').attr('id_relasi');
      var id_lobb   = $('#id_lobb').val();

      $('.id_relasi').val(id_relasi);
      $('.id_lob').val(id);

      if (id_relasi == 'pilih') {
        return false;
      }

      $('#here').html('');

      $.ajax({
        type      :"GET",
        url       :"<?php echo base_url(); ?>entry_sppa/shwfild/"+id_relasi,
        success   : function (data) {

          var hss   = JSON.parse(data); 
          var show  = '';

          // console.log(hss[0]['html']);
          var txta = '';
          for (var i = 0; i < hss.length; i++) {
            show = show+hss[i]['html'];
            
            if (hss[i]['txta'] != '') {
              txta = hss[i]['txta'];
            } else {
              txta = '';
            }
            
          }

          $('#here').html(show);

          $('.datepicker').datepicker({
              autoclose: true,
              todayHighlight: false,
              format: "dd-mm-yyyy",
              clearBtn: true,
              orientation: 'bottom'
          });

          tinymce.init({
                selector: "#nama",
                theme: "modern",
                height:300,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                style_formats: [
                    {title: 'Bold text', inline: 'b'},
                    {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                    {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                    {title: 'Example 1', inline: 'span', classes: 'example1'},
                    {title: 'Example 2', inline: 'span', classes: 'example2'},
                    {title: 'Table styles'},
                    {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                ]
            });

          $('.numeric').numericOnly();

          $('.number_separator').divide({
              delimiter:'.',
              divideThousand: true, // 1,000..9,999
              delimiterRegExp: /[\.\,\s]/g
          });

          if (id != 'pilih') {
            $.ajax({
                type      : "GET",
                url       : "<?php echo base_url(); ?>entry_sppa/show_premi/"+id,
                dataType  : "JSON",
                success   : function (data) {
                  
                  $('#show_premi').html(data.htmlnya);
                  $('.lob_lain').html(data.option_lob);
                  $('#total_persen_premi').val(data.total_rate);
                  $('#tambah_additional').attr('id_lob', id);
                  $('#kondisi_diskon').val(data.kondisi_diskon);

                  $('.label_tipe_diskon').text("Discount terhadap "+data.kondisi_diskon);

                  $('.persen').keyup(function(){
                      var val = $(this).val();
                      if(isNaN(val)){
                          val = val.replace(/[^0-9\.]/g,'');
                          if(val.split('.').length>2) 
                              val =val.replace(/\.+$/,"");
                      }
                      $(this).val(val); 
                  });

                  // $('.total_premi').prop('readonly', true);

                  var value         = $('#tsi').val().split('.').join('');

                  $('.total_premi').each(function () {
                            
                      var aksi      = $(this).attr('label');
                      var persen    = $(this).val();

                      var total     = value * (persen / 100);


                      $('.p_total_'+aksi).val(number_format(total,0,',','.'));
                      $('.p_total_asli_'+aksi).val(number_format(total,0,',','.'));
                      

                  })

                  if (data.htmlnya != '') {
                    total2();
                  }

                  if (hss.length == 0 && data.htmlnya == '') {

                    swal({
                        title               : "Peringatan",
                        text                : 'Field SPPA dan Coverage Belum Ada!',
                        buttonsStyling      : false,
                        type                : 'warning',
                        confirmButtonClass  : "btn btn-lg btn-primary",
                        confirmButtonText   : ' O K '
                    }); 

                    $('.link_entry').addClass('disabled');
                    $('.lanjutkan').attr('disabled', true);
                    
                  } else if (hss.length == 0) {
                    swal({
                        title               : "Peringatan",
                        text                : 'Field SPPA Belum Ada!',
                        buttonsStyling      : false,
                        type                : 'warning',
                        confirmButtonClass  : "btn btn-primary",
                        confirmButtonText   : ' O K '
                    }); 

                    $('.link_entry').addClass('disabled');
                    $('.lanjutkan').attr('disabled', true);
                  } else if (data.htmlnya == '') {
                    swal({
                        title               : "Peringatan",
                        text                : 'Coverage Belum Ada!',
                        buttonsStyling      : false,
                        type                : 'warning',
                        confirmButtonClass  : "btn btn-primary",
                        confirmButtonText   : ' O K '
                    }); 

                    $('.link_entry').removeClass('disabled');
                    $('.lanjutkan').attr('disabled', true);
                  } else {
                    $('.link_entry').removeClass('disabled');
                    $('.lanjutkan').attr('disabled', false);
                  }
                  
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    swal({
                        title               : "Gagal",
                        text                : 'Gagal menampilkan data',
                        type                : 'error',
                        showConfirmButton   : false,
                        timer               : 1000
                    }); 

                    return false;
                }
            });

          } else {

            $('#show_premi').html('');
            $('.lob_lain').html('');
            total2();
            
          }

          if (id_lobb != '') {
            $('#simpan_client').attr('disabled', false);
          } else  {
            disabled_client_data();
          }

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            swal({
                title               : "Gagal",
                text                : 'Gagal menampilkan data',
                type                : 'error',
                showConfirmButton   : false,
                timer               : 1000
            }); 

            return false;
        }
      });
    });

    // fungsi disabled button client data
    function disabled_client_data() {
      var tocc  = $('#tocc').val();
      var lobb  = $('#lobb').val();
      var value = $('#no_reff_mop').val();

      if (value != '') {
        $('#simpan_client').attr('disabled', false);
        $('.lanjutkan').attr('disabled', false);
        $('.simpan_semua').attr('disabled', false);

        return false;
      }

      if (tocc == 'pilih' || lobb == 'pilih') {
        $('#simpan_client').attr('disabled', true);
        $('.lanjutkan').attr('disabled', true);
        $('.simpan_semua').attr('disabled', true);
        
      } else {
        $('#simpan_client').attr('disabled', false);
        $('.lanjutkan').attr('disabled', false);
        $('.simpan_semua').attr('disabled', false);
      }
    }

    // AFIF

    var i = 1;

    $('#tambah_dok').on('click', function () {

        list = 
            `
            <div class="d-flex justify-content-center list_d" id="list_dok`+i+`">
                <div class="col-md-3 text-right mt-1">
                    <label class="col-form-label">Dokumen</label>
                </div>
                <div class="col-md-4">
                    <div class="form-group row p-0">
                        
                        <div class="col-sm-12">
                            <input type="file" class="form-control dok" id="dokumen`+i+`" name="dokumen[]" judul="dokumen" accept="application/msword, application/pdf">
                            <span class="text-danger" id="dokumen`+i+`_error"></span>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="form-group row p-0">
                        <div class="col-sm-12">
                            <button type="button" data-toggle="tooltip" data-placement="top" title="Hapus" class="btn btn-danger remove ttip" data-id="`+i+`"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    
                </div>
            </div>
            `;    

        $('.list_baru_dok').append(list);
        $('#list_dok'+i).hide().slideDown();

        i++;

    })

    $('.list_baru_dok').on('click', '.remove', function() {

        var id = $(this).data('id');

        $('#list_dok'+id).slideUp(function(){ $(this).remove();});

    });

    function total2() {

      var isi     = $('#diskon').val().split('.').join('');
      var kondisi = $('#kondisi_diskon').val();

      var total_krg = 0;

      if (kondisi == 'premi standar') {

        if ($('.premi_asli_standar').val() == '') {
          var isi_premi = 0;
        } else {
          var isi_premi = $('.premi_asli_standar').val().split('.').join('');
        }

        var total   = 0;
        var ttl_tt  = 0;

        if (isi == '' || isi == 0) {
          total   =  isi_premi;
          ttl_tt  = 0;
        } else {
          ttl_tt   = parseInt(isi_premi) * (isi / 100);
          total = parseInt(isi_premi) - parseInt(ttl_tt);
        }
        
        // $('.premi_standar').val(number_format(total,0,',','.'));   
        
      } else {

        var isi_premi_tt = $('#total_akhir_premi_asli').val().split('.').join('');

        var total_tt    = 0;
        var ttl_tt      = 0;

        if (isi == '' || isi == 0) {
          total_tt  =  isi_premi_tt;
          total_krg = 0
        } else {
          ttl_tt    = (parseInt(isi_premi_tt) / 100) * isi;
          total_tt  = parseInt(isi_premi_tt) - parseInt(ttl_tt);
          total_krg = ttl_tt;
        }
        
        $('#total_akhir_premi').val(number_format(total_tt,0,',','.'));

      }

      var total_persen        = 0;
      var total_persen_lain   = 0;
      var total_nilai         = 0;
      var total_nilai_lain    = 0;
      $('.total_premi').each(function () {
                
          var persen    = $(this).val();
          
          total_persen  += parseFloat(persen);

      })

      $('.premi_lain').each(function () {
                
          var persen1    = $(this).val();
          
          total_persen_lain  += parseFloat(persen1);

      })

      $('.total_premi_rp').each(function () {
                
          var nilai    = $(this).val().split('.').join('');
          
          total_nilai  += parseInt(nilai);

      })

      $('.premi_rp_lain').each(function () {
                
        var nilai1    = $(this).val().split('.').join('');
          
        total_nilai_lain  += parseInt(nilai1);

      })

      var tt_persen = total_persen + total_persen_lain;

      var tap = (parseInt(total_nilai) + parseInt(total_nilai_lain) - (parseInt(total_krg))) - parseInt(ttl_tt);

      $('#total_persen_premi').val(parseFloat(tt_persen));
      $('#total_akhir_premi').val(number_format(tap,0,',','.'));
      $('#total_akhir_premi_asli').val(number_format(parseInt(total_nilai) + parseInt(total_nilai_lain),0,',','.'));
      $('#gross_premi').val(number_format(parseInt(total_nilai) + parseInt(total_nilai_lain),0,',','.'));
      $('#total_diskon').val(number_format(ttl_tt,0,',','.'));

        // jika ada dikson pada total premi
        // var isi_premi_tt = $('#total_akhir_premi_asli').val().split('.').join('');

        // var total_tt    = 0;
        // var ttl_tt      = 0;
        // var isi         = $('#diskon').val().split('.').join('');

        // if (isi == '' || isi == 0) {
        //   total_tt =  isi_premi_tt;
        // } else {
        //   ttl_tt   = (parseInt(isi_premi_tt) / 100) * isi;
        //   total_tt = parseInt(isi_premi_tt) - parseInt(ttl_tt);
        // }
        
        // $('#total_akhir_premi').val(number_format(total_tt,0,',','.'));

      var biaya_admin = $('#biaya_admin').val().split('.').join('');
      var total_premi = $('#total_akhir_premi').val().split('.').join('');

      var tt_tagihan  = parseInt(biaya_admin) + parseInt(total_premi);

      if (biaya_admin == '') {
        tt_tagihan = total_premi;
      }

      $('#total_tagihan').val(number_format(tt_tagihan,0,',','.'));

      return true;

    }

    var a = 1;
    // 11-05-2021
    $('#tambah_additional').on('click', function () {

      var id = $(this).attr('id_lob');

      list = 
            `
            <div class="row" id="list_add`+a+`">
              <div class="col-md-12">
                  <div class="form-group row p-0">
                      <div class="col-sm-12">
                          <button type="button" data-toggle="tooltip" data-placement="top" title="Hapus" class="btn btn-danger remove" data-id="`+a+`"><i class="fa fa-times"></i></button>
                      </div>
                  </div>
                  
              </div>
              <div class="col-md-6">
                  <div class="form-group row">
                      <label for="no_klaim" class="col-sm-4 col-form-label">Pilih LOB Lainnya</label>
                      <div class='col-sm-8'>
                        <select name="lob_lain" class="select2 lob_lain lob_adt">
                          <option value=""></option>
                        </select>
                      </div>
                  </div>    
                  <div class="form-group row">
                      <label for="no_klaim" class="col-sm-4 col-form-label">Kalkulasi Sum Insurance</label>
                      <div class='col-sm-8'>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                          </div>
                          <input type="text" class="text-right form-control kalkulasi_tsi_adt" id="kalkulasi`+a+`" placeholder="0" readonly>
                        </div>
                      </div>
                  </div>    
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                      <label for="no_klaim" class="col-sm-4 col-form-label">Persentase Pengali TSI</label>
                      <div class='col-sm-8'>
                        <div class='input-group'>
                          <input type='text' class='form-control text-right persen pengali pengali_tsi_adt' data-id="`+a+`" placeholder="0">
                          <div class='input-group-append'>
                              <span class='input-group-text' id='basic-addon2'>%</span>
                          </div>
                        </div>
                      </div>
                  </div>  
                  <div class="form-group row">
                      <label for="no_klaim" class="col-sm-4 col-form-label">Premi</label>
                      <div class='col-sm-4'>
                        <div class='input-group'>
                          <input type='text' class='form-control text-right persen premi_lain rate_adt rate_`+a+`' data-id="`+a+`" placeholder="0">
                          <div class='input-group-append'>
                              <span class='input-group-text' id='basic-addon2'>%</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-4">
                          <input type="text" class="form-control text-right premi_rp_lain nominal_adt"  id="t_premi_lain`+a+`" value="0" readonly>
                      </div>
                  </div> 
              </div>
            </div>
            `;    

        $('#show_additional').append(list);
        $('#list_add'+a).hide().slideDown();

        $('.select2').select2({
            theme       : 'bootstrap4',
            width       : 'style',
            placeholder : $(this).attr('placeholder'),
            allowClear  : false
        });

        $('.persen').keyup(function(){
            var val = $(this).val();
            if(isNaN(val)){
                val = val.replace(/[^0-9\.]/g,'');
                if(val.split('.').length>2) 
                    val =val.replace(/\.+$/,"");
            }
            $(this).val(val); 
        });

        $.ajax({
            type:"GET",
            url:"<?php echo base_url(); ?>entry_sppa/show_premi/"+id,
            dataType : "JSON",
            success  : function (data) {
              
              $('.lob_lain').html(data.option_lob);

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal({
                    title               : "Gagal",
                    text                : 'Gagal menampilkan data',
                    type                : 'error',
                    showConfirmButton   : false,
                    timer               : 1000
                }); 

                return false;
            }
        });

        a++;
      
    })

    $('#show_additional').on('click', '.remove', function() {

      var id = $(this).data('id');

      $('#list_add'+id).slideUp(function(){ 
        $(this).remove();

        total2();
      
      });

    });

    $('#show_additional').on('keyup', '.pengali', function () {

      var id    = $(this).data('id');
      var value = $(this).val();
      var tsi   = $('#tsi').val().split('.').join('');

      var total = tsi * (value / 100);

      $('#kalkulasi'+id).val(number_format(total,0,',','.'));

      var rate_lain = $('.rate_'+id).val();
      var kalkulasi = $('#kalkulasi'+id).val().split('.').join('');

      var totall = kalkulasi * (rate_lain / 100);

      $('#t_premi_lain'+id).val(number_format(totall,0,',','.'));

      total2();
      
    })

    $('#show_additional').on('keyup', '.premi_lain', function () {

      var id    = $(this).data('id');
      var value = $(this).val();
      var si    = $('#kalkulasi'+id).val().split('.').join('');

      var total = si * (value / 100);

      $('#t_premi_lain'+id).val(number_format(total,0,',','.'));

      total2();
      
    })

    // 10-05-2021
    $('#simpan_dok').on('click', function () {

        var form_data = new FormData($('#form_dokumen')[0]);

        $.ajax({
            url: '<?= base_url("entry_sppa/simpan_dokumen") ?>',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(data){
              tabel_dok.ajax.reload(null, false);

              $('#doc').val('');
              $('#desc').val('');
              
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal({
                    title               : "Gagal",
                    text                : 'Gagal simpan data',
                    type                : 'error',
                    showConfirmButton   : false,
                    timer               : 1000
                }); 

                return false;
            }
        });

    })

    // menampilkan tabel dok
    var tabel_dok = $('#tabel_dok').DataTable({
        "processing"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "<?= base_url() ?>entry_sppa/tampil_data_dokumen",
            "type"  : "POST",
            "data"  : function (data) {
                data.sppa_number    = $('.sppa_number').val();
            },
        },
        "columnDefs"        : [{
            "targets"   : [0,5],
            "orderable" : false
        }, {
            'targets'   : [0,4,5],
            'className' : 'text-center',
        }],
        "bDestroy" : true
    })

    $('#tabel_dok').on('click', '.edit', function () {

      var id_dokumen  = $(this).data('id');
      var desc        = $(this).attr('desc');
      var filename    = $(this).attr('filename');

      $('#id_dokumen').val(id_dokumen);
      $('#nama_dokumen').val(filename);
      $('#desc').val(desc);

      $('#aksi').val('Ubah');

    })

      // hapus dokumen
    $('#tabel_dok').on('click', '.hapus', function () {
          
        var id_dokumen  = $(this).data('id');
        var filename    = $(this).attr('filename');

        swal({
            title       : 'Konfirmasi',
            text        : 'Yakin akan hapus dokumen ?',
            type        : 'warning',

            buttonsStyling      : false,
            confirmButtonClass  : "btn btn-danger",
            cancelButtonClass   : "btn btn-primary mr-3",

            showCancelButton    : true,
            confirmButtonText   : 'Hapus',
            confirmButtonColor  : '#d33',
            cancelButtonColor   : '#3085d6',
            cancelButtonText    : 'Batal',
            reverseButtons      : true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url         : "<?= base_url() ?>entry_sppa/simpan_dokumen",
                    method      : "POST",
                    beforeSend  : function () {
                        swal({
                            title   : 'Menunggu',
                            html    : 'Memproses Data',
                            onOpen  : () => {
                                swal.showLoading();
                            }
                        })
                    },
                    data        : {aksi:'Hapus', id_dokumen:id_dokumen, nama_dokumen:filename},
                    dataType    : "JSON",
                    success     : function (data) {

                          tabel_dok.ajax.reload(null,false);   

                            swal({
                                title               : 'Hapus dokumen',
                                text                : 'Data Berhasil Dihapus',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                            }); 
                            
                            $('#form_dokumen').trigger("reset");

                            $('#aksi').val('Tambah');
                        
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        swal({
                            title               : "Gagal",
                            text                : 'Gagal proses data',
                            type                : 'error',
                            showConfirmButton   : false,
                            timer               : 1000
                        }); 

                        return false;
                    }

                })

                return false;
            } else if (result.dismiss === swal.DismissReason.cancel) {

                swal({
                        title               : 'Batal',
                        text                : 'Anda membatalkan hapus dokumen',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-primary",
                        type                : 'error',
                        showConfirmButton   : false,
                        timer               : 1000
                    }); 
            }
        })

    })

    $('.persen').keyup(function(){
        var val = $(this).val();
        if(isNaN(val)){
            val = val.replace(/[^0-9\.]/g,'');
            if(val.split('.').length>2) 
                val =val.replace(/\.+$/,"");
        }
        $(this).val(val); 
    });

    // 07-05-2021
    $('#diskon').on('keyup', function () {

      var value  = $(this).val().split('.').join('');

      $('#diskon').val(Math.max(Math.min(value, 100), -100)); 

      total2();
      
      // var isi     = $('#diskon').val().split('.').join('');
      // var kondisi = $('#kondisi_diskon').val();

      // if (kondisi == 'premi standar') {

      //   var isi_premi = $('.premi_asli_standar').val().split('.').join('');

      //   var total   = 0;
      //   var ttl     = 0;

      //   if (isi == '' || isi == 0) {
      //     total =  isi_premi;
      //   } else {
      //     ttl   = parseInt(isi_premi) * (isi / 100);
      //     total = parseInt(isi_premi) - parseInt(ttl);
      //   }
        
      //   $('.premi_standar').val(number_format(total,0,',','.'));  

      //   total2();
        
      // } else {

      //   var isi_premi_tt = $('#total_akhir_premi_asli').val().split('.').join('');

      //   var total_tt    = 0;
      //   var ttl_tt      = 0;

      //   if (isi == '' || isi == 0) {
      //     total_tt =  isi_premi_tt;
      //   } else {
      //     ttl_tt   = (parseInt(isi_premi_tt) / 100) * isi;
      //     total_tt = parseInt(isi_premi_tt) - parseInt(ttl_tt);
      //   }
        
      //   $('#total_akhir_premi').val(number_format(total_tt,0,',','.'));

      //   total2();

      // }

    })

    function number_format (number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');

        var n = !isFinite(+number) ? 0 : +number,
        prec  = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep   = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec   = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);

    }

    $('#tsi').on('keyup', function () {

      var value         = $(this).val().split('.').join('');

      $('.total_premi').each(function () {
                
          var aksi      = $(this).attr('label');
          var persen    = $(this).val();

          var total     = value * (persen / 100);


          $('.p_total_'+aksi).val(number_format(total,0,',','.'));
          $('.p_total_asli_'+aksi).val(number_format(total,0,',','.'));
          

      })

      total2();
      
    })

    $('#show_premi').on('keyup', '.total_premi', function () {
      
      var aksi      = $(this).attr('label');
      var persen    = $(this).val();
      var value     = $('#tsi').val().split('.').join('');

      var total     = value * (persen / 100);

      $('.p_total_'+aksi).val(number_format(total,0,',','.'));

      total2();

    })

    $('#biaya_admin').on('keyup', function () {

      var biaya_admin = $('#biaya_admin').val().split('.').join('');
      var total_premi = $('#total_akhir_premi').val().split('.').join('');

      var tt_tagihan  = parseInt(biaya_admin) + parseInt(total_premi);

      if (biaya_admin == '') {
        tt_tagihan = total_premi;
      }

      $('#total_tagihan').val(number_format(tt_tagihan,0,',','.'));
      
    })
    
    $('#payment_method').on('change', function () {

      var value = $(this).val();

      if (value == '') {
        $('.f_pay').fadeOut();
      } else {
        $('.f_pay').fadeIn();
      }
      
    })

    // 11-05-2021
    var tabel_termin = $('#tabel_termin').DataTable({
        "processing"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "<?= base_url() ?>entry_sppa/tampil_data_termin",
            "type"  : "POST",
            "data"  : function (data) {
                data.sppa_number    = $('.sppa_number').val();
            },
        },
        "columnDefs"        : [{
            "targets"   : [0,6],
            "orderable" : false
        }, {
            'targets'   : [0,6],
            'className' : 'text-center',
        }],
        "bPaginate"     : false,
        "bLengthChange" : false,
        "bFilter"       : true,
        "bInfo"         : false,
        "bDestroy"      : true
    })

    $('#tambah_pembayaran').on('click', function () {

      $('#modal_termin').modal('show');

      $('#form_termin_m').trigger("reset");

      $('#aksi_termin').val('Tambah');
      
    })

    $('#form_termin_m').parsley({
        triggerAfterFailure: 'input change'
    });

    // 24-06-2021
    $('#show_termin').on('click', '.remove', function() {

      var id = $(this).data('id');

      $('#list_add_en'+id).fadeOut(function(){ 

          $(this).remove();

          var label_dok = [];
          $('.label_dok_en').each(function() { 
              label_dok.push($(this).val()); 
          });

          if (label_dok.length == 0) {

              $('#tabel_termin_en').slideUp(30);
          }

          ubah_label_termin();
      });


    });

    // ubah label
    function ubah_label_termin() {

      var label_dok  = [];
      $('.label_dok_en').each(function() { 
          label_dok.push($(this).data('id')); 
      });

      let i = 1;
      for (let h = 0; h < label_dok.length; h++) {
          const element = label_dok[h];
          
          $('#label_dok_en'+element).text(i+".");

          i++;
      }

      }

    // 24-06-2021
    $('#tabel_termin_en').on('click', '.edit', function () {

      var id          = $(this).data('id');
      var no_dokumen  = $(this).attr('no_dokumen');
      var tgl_bayar   = $(this).attr('tgl_bayar');
      var jumlah      = $(this).attr('jumlah');
      var cara_bayar  = $(this).attr('cara_bayar');
      var tgl_terima  = $(this).attr('tgl_terima');

      // $('#list_add_en'+id).remove();

      $('#id_ubah').val(id);

      $('#no_dokumen').val(no_dokumen);
      $('#tgl_bayar').val(tgl_bayar);
      $('#jumlah').val(jumlah);
      $('#cara_bayar').val(cara_bayar);
      $('#tgl_terima').val(tgl_terima);

      $('#aksi_termin').val('ubah');
      $('#modal_termin').modal('show');

    })

    // aksi simpan data termin
    $('#form_termin_m').on('submit', function () {

      var aksi = $("#simpan_termin").attr('aksi');

      if (aksi == "baru") {

        var aksi_termin   = $('#aksi_termin').val();
        var id_ubah       = $('#id_ubah').val();

        var m             = $('#number_termin').val();
        var no_dokumen    = $('#no_dokumen').val();
        var tgl_bayar     = $('#tgl_bayar').val();
        var jumlah        = $('#jumlah').val();
        var cara_bayar    = $('#cara_bayar').val();
        var tgl_terima    = $('#tgl_terima').val();

        $('#tabel_termin_en').slideDown();
        $('#modal_termin').modal('hide');

        if (aksi_termin == 'ubah') {

          $('#no_dokumen_'+id_ubah).text(no_dokumen);
          $('#tgl_bayar_'+id_ubah).text(tgl_bayar);
          $('#jumlah_'+id_ubah).text(number_format(jumlah,0,',','.'));
          $('#cara_bayar_'+id_ubah).text(cara_bayar);
          $('#tgl_terima_'+id_ubah).text(tgl_terima);

          return false;
          
        }

        list = 
            `
            <tr id="list_add_en`+m+`">
                <td class="label_dok_en text-center" id="label_dok_en`+m+`" data-id="`+m+`">`+a+`.</td>
                <td><span class="no_dokumen_t" id="no_dokumen_`+m+`">`+no_dokumen+`</span></td>
                <td><span class="tgl_bayar_t" id="tgl_bayar_`+m+`">`+tgl_bayar+`</span></td>
                <td><span class="jumlah_t" id="jumlah_`+m+`">`+number_format(jumlah,0,',','.')+`</span></td>
                <td><span class="cara_bayar_t" id="cara_bayar_`+m+`">`+cara_bayar+`</span></td>
                <td><span class="tgl_terima_t" id="tgl_terima_`+m+`">`+tgl_terima+`</span></td>
                <td align="center">
                  <span style="cursor:pointer;" data-toggle="tooltip" data-placement="top" title="Edit" class="edit text-primary mr-2" data-id="`+m+`" no_dokumen="`+no_dokumen+`" tgl_bayar="`+tgl_bayar+`" jumlah="`+jumlah+`" cara_bayar="`+cara_bayar+`" tgl_terima="`+tgl_terima+`"><i class="mdi mdi-pencil-outline mdi-24px"></i></span>
                  <span style="cursor:pointer;" data-toggle="tooltip" data-placement="top" title="Hapus" class="remove text-danger" data-id="`+m+`"><i class="mdi mdi-trash-can-outline mdi-24px"></i></span>
                </td>
            </tr>
            `;    

        $('#show_termin').append(list);
        $('#list_add_en'+m).hide().slideDown();

        ubah_label_termin();

        m++;

        $('#number_termin').val(m);

        return false;
        
      }

      var form_termin = $('#form_termin_m').serialize();
      var nama_termin = $('#no_dokumen').val();

      if (nama_termin == '') {
          swal({
              title               : "Peringatan",
              text                : 'termin harus terisi !',
              buttonsStyling      : false,
              type                : 'warning',
              showConfirmButton   : false,
              timer               : 1000
          }); 

          return false;
      } else {

          swal({
              title       : 'Konfirmasi',
              text        : 'Yakin akan kirim data',
              type        : 'warning',

              buttonsStyling      : false,
              confirmButtonClass  : "btn btn-primary",
              cancelButtonClass   : "btn btn-danger mr-3",

              showCancelButton    : true,
              confirmButtonText   : 'Ya',
              confirmButtonColor  : '#3085d6',
              cancelButtonColor   : '#d33',
              cancelButtonText    : 'Batal',
              reverseButtons      : true
          }).then((result) => {
              if (result.value) {
                  $.ajax({
                      url     : "<?= base_url() ?>entry_sppa/simpan_data_termin",
                      type    : "POST",
                      beforeSend  : function () {
                          swal({
                              title   : 'Menunggu',
                              html    : 'Memproses Data',
                              onOpen  : () => {
                                  swal.showLoading();
                              }
                          })
                      },
                      data    : form_termin,
                      dataType: "JSON",
                      success : function (data) {

                          $('#modal_termin').modal('hide');
                          
                          swal({
                              title               : "Berhasil",
                              text                : 'Data berhasil disimpan',
                              buttonsStyling      : false,
                              confirmButtonClass  : "btn btn-success",
                              type                : 'success',
                              showConfirmButton   : false,
                              timer               : 1000
                          });    
          
                          tabel_termin.ajax.reload(null,false);        
                          
                          $('#form_termin').trigger("reset");
          
                          $('#aksi_termin').val('Tambah');
                      },
                      error: function (jqXHR, textStatus, errorThrown)
                      {
                          swal({
                              title               : "Gagal",
                              text                : 'Gagal menampilkan data',
                              type                : 'error',
                              showConfirmButton   : false,
                              timer               : 1000
                          }); 

                          return false;
                      }
                  })
          
                  return false;

              } else if (result.dismiss === swal.DismissReason.cancel) {

                  swal({
                      title               : "Batal",
                      text                : 'Anda membatalkan simpan data',
                      buttonsStyling      : false,
                      confirmButtonClass  : "btn btn-primary",
                      type                : 'error',
                      showConfirmButton   : false,
                      timer               : 1000
                  }); 
              }
          })

          return false;

      }

    })

    // edit data termin
    $('#tabel_termin').on('click', '.edit', function () {

      var id_termin  = $(this).data('id');

      $.ajax({
          url         : "<?= base_url() ?>entry_sppa/ambil_data_termin/"+id_termin,
          type        : "GET",
          beforeSend  : function () {
              swal({
                  title   : 'Menunggu',
                  html    : 'Memproses Data',
                  onOpen  : () => {
                      swal.showLoading();
                  }
              })
          },
          dataType    : "JSON",
          success     : function(data)
          {
              swal.close();

              $('#modal_termin').modal('show');
              
              $('#id_termin').val(data.id_termin_pembayaran);

              // $("#tgl_bayar").datepicker("setDate", data.tgl_bayar);
              // $("#tgl_terima").datepicker("setDate", data.tgl_terima);

              
              var myDateVal = moment(data.tgl_bayar).format('DD-MM-YYYY');
              $('#tgl_bayar').datepicker('setDate', myDateVal);    
              var myDateVal2 = moment(data.tgl_terima).format('DD-MM-YYYY');
              $('#tgl_terima').datepicker('setDate', myDateVal2);    
                                  
              $('#no_dokumen').val(data.no_dokumen);
              $('#cara_bayar').val(data.cara_bayar);
              $('#jumlah').val(data.jumlah);

              $('#aksi_termin').val('Ubah');

              return false;

          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              swal({
                  title               : "Gagal",
                  text                : 'Gagal menampilkan data',
                  type                : 'error',
                  showConfirmButton   : false,
                  timer               : 1000
              }); 

              return false;
          }
      })

      return false;

    })

    // hapus termin
    $('#tabel_termin').on('click', '.hapus', function () {
        
        var id_termin   = $(this).data('id');
        swal({
            title       : 'Konfirmasi',
            text        : 'Yakin akan hapus termin ?',
            type        : 'warning',

            buttonsStyling      : false,
            confirmButtonClass  : "btn btn-danger",
            cancelButtonClass   : "btn btn-primary mr-3",

            showCancelButton    : true,
            confirmButtonText   : 'Hapus',
            confirmButtonColor  : '#d33',
            cancelButtonColor   : '#3085d6',
            cancelButtonText    : 'Batal',
            reverseButtons      : true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url         : "<?= base_url() ?>entry_sppa/simpan_data_termin",
                    method      : "POST",
                    beforeSend  : function () {
                        swal({
                            title   : 'Menunggu',
                            html    : 'Memproses Data',
                            onOpen  : () => {
                                swal.showLoading();
                            }
                        })
                    },
                    data        : {aksi:'Hapus', id_termin:id_termin},
                    dataType    : "JSON",
                    success     : function (data) {

                            tabel_termin.ajax.reload(null,false);   

                            swal({
                                title               : 'Hapus termin',
                                text                : 'Data Berhasil Dihapus',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                            }); 

                                
                            
                            $('#form_termin').trigger("reset");

                            $('#aksi_termin').val('Tambah');
                        
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        swal({
                            title               : "Gagal",
                            text                : 'Gagal menampilkan data',
                            type                : 'error',
                            showConfirmButton   : false,
                            timer               : 1000
                        }); 

                        return false;
                    }

                })

                return false;
            } else if (result.dismiss === swal.DismissReason.cancel) {

                swal({
                        title               : 'Batal',
                        text                : 'Anda membatalkan hapus termin',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-primary",
                        type                : 'error',
                        showConfirmButton   : false,
                        timer               : 1000
                    }); 
            }
        })

    })

    // simpan data tiap tab

    $('#simpan_client').on('click', function () {

      var form_client = $('#form_client').serialize();

      swal({
          title       : 'Konfirmasi',
          text        : 'Yakin akan kirim data',
          type        : 'warning',

          buttonsStyling      : false,
          confirmButtonClass  : "btn btn-primary",
          cancelButtonClass   : "btn btn-danger mr-3",

          showCancelButton    : true,
          confirmButtonText   : 'Ya',
          confirmButtonColor  : '#3085d6',
          cancelButtonColor   : '#d33',
          cancelButtonText    : 'Batal',
          reverseButtons      : true
      }).then((result) => {
          if (result.value) {
              $.ajax({
                  url     : "<?= base_url() ?>entry_sppa/simpan_data_client",
                  type    : "POST",
                  beforeSend  : function () {
                      swal({
                          title   : 'Menunggu',
                          html    : 'Memproses Data',
                          onOpen  : () => {
                              swal.showLoading();
                          }
                      })
                  },
                  data    : form_client,
                  dataType: "JSON",
                  success : function (data) {

                    swal.close();

                    $('html, body').animate({
                        scrollTop: $('body').offset().top
                    }, 800);

                    $('.link_detail').removeClass('disabled');
                    activaTab('t_detail');  
    
                    tabel_termin.ajax.reload(null,false);  
                    tabel_dok.ajax.reload(null,false);  
                    
                    $('.id_sppa').val(data.id_sppa);
                    $('.id_entry_sppa').val(data.id_sppa);
                      
                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                      swal({
                          title               : "Gagal",
                          text                : 'Gagal proses data',
                          type                : 'error',
                          showConfirmButton   : false,
                          timer               : 1000
                      }); 

                      return false;
                  }
              })
      
              return false;

          } else if (result.dismiss === swal.DismissReason.cancel) {

              swal({
                  title               : "Batal",
                  text                : 'Anda membatalkan simpan data',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-primary",
                  type                : 'error',
                  showConfirmButton   : false,
                  timer               : 1000
              }); 
          }
      })

      return false;

    })

    function activaTab(tab){
      $('.nav-tabs a[href="#' + tab + '"]').tab('show');
    };

    // 15-05-2021
    $('#acc_mop').on('change', function () {
      var value = $(this).prop("checked");

      if (value) {
        $('.sel_mop').slideDown();
        // $('.check_deklarasi').slideDown(30);
        // $('.check_mop').removeClass('col-md-4').addClass('col-md-2');

        $('.non_mop').slideUp();
        // $('.link_entry').attr('hidden', true);

      } else {

        $('#id_insured').val('').trigger('change');
        $('.sel_mop').slideUp();
        // $('.check_deklarasi').slideUp(30);
        // $('.check_mop').removeClass('col-md-2').addClass('col-md-4');

        $('.non_mop').slideDown();
        $('.link_entry').attr('hidden', false);

        $('#acc_deklarasi').prop("checked", false);
        $('.check_deklarasi').slideUp(30);
        $('.sel_deklarasi').slideUp(30);
        $('.check_mop').removeClass('col-md-2').addClass('col-md-4');

        $('.id_mop').val('');

        $('#exceltable').html('');  
        $('#excelfile').val('');

        $('#id_detail_sob').val('');

        $('#sobb').val('pilih').trigger('change');
        $('#cobb').val('pilih').trigger('change');

        $('#simpan_client').attr('disabled', true);
        $('.lanjutkan').attr('disabled', true);
        $('.simpan_semua').attr('disabled', true);

        tampil_awal();
        
      }

      $('.cc').select2({
          theme       : 'bootstrap4',
          width       : 'style',
          placeholder : $(this).attr('placeholder'),
          allowClear  : false
      });
      
    })

    // 02-06-2021
    $('#id_insured').on('change', function () {

      var id_insured = $(this).val();

      if (id_insured == '') {
        // $('#sobb').attr('disabled', false);

        // $('.check_deklarasi').slideUp(30);
        // $('.sel_deklarasi').slideUp(30);
        // $('#acc_deklarasi').prop("checked", false);
        // $('.check_mop').removeClass('col-md-2').addClass('col-md-4');

        // $('.non_mop').slideUp();

        // $('#simpan_client').attr('disabled', true);
        // $('.lanjutkan').attr('disabled', true);
        // $('.simpan_semua').attr('disabled', true);

        $('#no_reff_mop').attr('disabled', true);

        $('#excelfile').attr('disabled', true)
        $('#download').attr('disabled', true)
        $('#preview').attr('disabled', true)
        $('#clear').attr('disabled', true)

      }

      $.ajax({
        url     : "<?= base_url('entry_sppa/list_reff_mop') ?>",
        method  : "POST",
        data    : {id_insured:id_insured},
        dataType: "JSON",
        success : function (data) {
          if (id_insured == '') {
            $('#no_reff_mop').attr('disabled', true);
          } else {
            $('#no_reff_mop').attr('disabled', false);
          }
          
          $('#no_reff_mop').html(data.option);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            swal({
                title               : "Gagal",
                text                : 'Gagal Menampilkan No Reff MOP',
                type                : 'error',
                showConfirmButton   : false,
                timer               : 1000
            }); 

            return false;
        }
      })
      
    })

    // 15-05-2021
    $('#simpan_detail').on('click', function () {

      var form_detail = $('#form_detail').serialize();

      swal({
          title       : 'Konfirmasi',
          text        : 'Yakin akan kirim data',
          type        : 'warning',

          buttonsStyling      : false,
          confirmButtonClass  : "btn btn-primary",
          cancelButtonClass   : "btn btn-danger mr-3",

          showCancelButton    : true,
          confirmButtonText   : 'Ya',
          confirmButtonColor  : '#3085d6',
          cancelButtonColor   : '#d33',
          cancelButtonText    : 'Batal',
          reverseButtons      : true
      }).then((result) => {
          if (result.value) {
              $.ajax({
                  url     : "<?= base_url() ?>entry_sppa/simpan_data_detail",
                  type    : "POST",
                  beforeSend  : function () {
                      swal({
                          title   : 'Menunggu',
                          html    : 'Memproses Data',
                          onOpen  : () => {
                              swal.showLoading();
                          }
                      })
                  },
                  data    : form_detail,
                  dataType: "JSON",
                  success : function (data) {

                    swal.close();

                    $('html, body').animate({
                        scrollTop: $('body').offset().top
                    }, 800);

                    $('.link_dok').removeClass('disabled');
                    activaTab('t_dok');  
    
                    tabel_termin.ajax.reload(null,false);  
                    tabel_dok.ajax.reload(null,false);  
                      
                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                      swal({
                          title               : "Gagal",
                          text                : 'Gagal proses data',
                          type                : 'error',
                          showConfirmButton   : false,
                          timer               : 1000
                      }); 

                      return false;
                  }
              })
      
              return false;

          } else if (result.dismiss === swal.DismissReason.cancel) {

              swal({
                  title               : "Batal",
                  text                : 'Anda membatalkan simpan data',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-primary",
                  type                : 'error',
                  showConfirmButton   : false,
                  timer               : 1000
              }); 
          }
      })

      return false;
      
    })

    // 15-05-2021
    $('#simpan_tab_dok').on('click', function () {
      
      $('html, body').animate({
          scrollTop: $('body').offset().top
      }, 800);

      $('.link_premi').removeClass('disabled');
      activaTab('t_premi');  

      tabel_termin.ajax.reload(null,false); 
      
    })

    // 16-05-2021
    $('#simpan_premi').on('click', function () {

      var lob_adt           = [];
      var kalkulasi_tsi_adt = [];
      var pengali_tsi_adt   = [];
      var rate_adt          = [];
      var nominal_adt       = [];
      var rate_all_premi    = [];
      var nominal_all_premi = [];
      var id_coverage       = [];
      var premi_standar     = [];
      var premi_perluasan   = [];

      $('.lob_adt').each(function() { 
        lob_adt.push($(this).val()); 
      });
      $('.kalkulasi_tsi_adt').each(function() { 
        kalkulasi_tsi_adt.push($(this).val()); 
      });
      $('.pengali_tsi_adt').each(function() { 
        pengali_tsi_adt.push($(this).val()); 
      });
      $('.rate_adt').each(function() { 
        rate_adt.push($(this).val()); 
      });
      $('.nominal_adt').each(function() { 
        nominal_adt.push($(this).val()); 
      });
      $('.rate_all_premi').each(function() { 
        rate_all_premi.push($(this).val()); 
      });
      $('.nominal_all_premi').each(function() { 
        nominal_all_premi.push($(this).val()); 
        id_coverage.push($(this).attr('id_coverage')); 
      });
      $('.premi_standar').each(function() { 
        premi_standar.push($(this).val()); 
      });
      $('.premi_perluasan').each(function() { 
        premi_perluasan.push($(this).val()); 
      });

      var id_sppa_premi       = $('#id_sppa_premi').val();
      var tsi                 = $('#tsi').val();
      var diskon              = $('#diskon').val();
      var total_persen_premi  = $('#total_persen_premi').val();
      var total_akhir_premi   = $('#total_akhir_premi').val();
      var biaya_admin         = $('#biaya_admin').val();
      var total_tagihan       = $('#total_tagihan').val();
      var payment_method      = $('#payment_method').val();
      var tahun_pay           = $('#tahun_pay').val();
      var jumlah_cicilan      = $('#jumlah_cicilan').val();

      swal({
          title       : 'Konfirmasi',
          text        : 'Yakin akan kirim data',
          type        : 'warning',

          buttonsStyling      : false,
          confirmButtonClass  : "btn btn-primary",
          cancelButtonClass   : "btn btn-danger mr-3",

          showCancelButton    : true,
          confirmButtonText   : 'Ya',
          confirmButtonColor  : '#3085d6',
          cancelButtonColor   : '#d33',
          cancelButtonText    : 'Batal',
          reverseButtons      : true
      }).then((result) => {
          if (result.value) {
              $.ajax({
                  url     : "<?= base_url() ?>entry_sppa/simpan_data_premi",
                  type    : "POST",
                  beforeSend  : function () {
                      swal({
                          title   : 'Menunggu',
                          html    : 'Memproses Data',
                          onOpen  : () => {
                              swal.showLoading();
                          }
                      })
                  },
                  data    : {
                    id_sppa_premi       : id_sppa_premi,
                    tsi                 : tsi,
                    diskon              : diskon,
                    total_persen_premi  : total_persen_premi,
                    total_akhir_premi   : total_akhir_premi,
                    biaya_admin         : biaya_admin,
                    total_tagihan       : total_tagihan, 
                    payment_method      : payment_method,
                    tahun_pay           : tahun_pay,
                    jumlah_cicilan      : jumlah_cicilan,
                    lob_adt             : lob_adt, 
                    kalkulasi_tsi_adt   : kalkulasi_tsi_adt,
                    pengali_tsi_adt     : pengali_tsi_adt,
                    rate_adt            : rate_adt,
                    nominal_adt         : nominal_adt, 
                    rate_all_premi      : rate_all_premi,
                    nominal_all_premi   : nominal_all_premi,
                    id_coverage         : id_coverage,
                    premi_standar       : premi_standar,
                    premi_perluasan     : premi_perluasan
                  },
                  dataType: "JSON",
                  success : function (data) {

                    swal.close();

                    $('html, body').animate({
                        scrollTop: $('body').offset().top
                    }, 800);

                    $('.link_released').removeClass('disabled');
                    activaTab('t_released');  
                      
                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                      swal({
                          title               : "Gagal",
                          text                : 'Gagal proses data',
                          type                : 'error',
                          showConfirmButton   : false,
                          timer               : 1000
                      }); 

                      return false;
                  }
              })
      
              return false;

          } else if (result.dismiss === swal.DismissReason.cancel) {

              swal({
                  title               : "Batal",
                  text                : 'Anda membatalkan simpan data',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-primary",
                  type                : 'error',
                  showConfirmButton   : false,
                  timer               : 1000
              }); 
          }
      })

      return false;

      
    })

    // 18-05-2021
    $('#no_reff_mop').on('change', function () {
      
      var id_mop = $(this).val();
      var st_mop = $('#acc_mop').prop("checked");

      $('.id_mop').val(id_mop);

      if (id_mop == '') {
        // $('#sobb').attr('disabled', false);

        // // $('.d_sob').slideUp();
        // // $('.d2_sob').slideUp();

        // $('.check_deklarasi').slideUp(30);
        // $('.sel_deklarasi').slideUp(30);
        // $('#acc_deklarasi').prop("checked", false);
        // $('.check_mop').removeClass('col-md-2').addClass('col-md-4');

        // $('.non_mop').slideUp();

        // $('#simpan_client').attr('disabled', true);
        // $('.lanjutkan').attr('disabled', true);
        // $('.simpan_semua').attr('disabled', true);

        // $('#sobb').attr('disabled', false);
        // $('#tocc').attr('disabled', false);
        // $('#cobb').attr('disabled', false);
        // $('#id_lobb').attr('disabled', false);

        $('#excelfile').attr('disabled', true)
        $('#download').attr('disabled', true)
        $('#preview').attr('disabled', true)
        $('#clear').attr('disabled', true)

        return false;
      }

      $.ajax({
          url     : "<?= base_url() ?>entry_sppa/get_mop",
          type    : "POST",
          data    : {id_mop:id_mop},
          dataType: "JSON",
          success : function (data) {

            $('#excelfile').attr('disabled', false)
            $('#download').attr('disabled', false)
            $('#preview').attr('disabled', false)
            $('#clear').attr('disabled', false)

            // $('.check_deklarasi').slideDown(30);
            // $('.check_mop').removeClass('col-md-4').addClass('col-md-2');

            // $('.non_mop').slideDown();
            // $('#sobb').attr('disabled', true);
            $('#id_detail_sob').val(data.mop[0].id_detail_sob);
            $('#sobb').val((data.mop[0].id_sob == null) ? 'pilih' : data.mop[0].id_sob).trigger('change');
            $('#cobb').val(data.mop[0].id_cob).trigger('change');
            $('#id_lobb').val(data.mop[0].id_lob);

            // sel_detail_sob(data.mop[0].id_sob, data.mop[0].id_detail_sob);

            $.ajax({
              type:"GET",
              url:"<?php echo base_url(); ?>entry_sppa/showboth/"+data.mop[0].id_cob,
              success  : function (data2) {
                var hss = JSON.parse(data2); 
                var opt = '<option value="pilih">-- Pilih --</option>';
                for (var i = 0; i < hss.length; i++) {
                  opt = opt+'<option value='+hss[i].id_lob+' id_relasi='+hss[i].id_relasi_cob_lob+'>'+hss[i].lob+'</option>';
                }
                $('#lobb').html(opt);

                $('#lobb').val(data.mop[0].id_lob).trigger('change');
                $('#tsi').val(data.mop[0].nilai_pertanggungan);

                var id_relasi = $('#lobb').find(':selected').attr('id_relasi');
                $('#url_format').attr('href', "<?= base_url() ?>entry_sppa/format_excel/"+id_relasi);

                // $('.c_lob').fadeIn();

              }
            });

          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              swal({
                  title               : "Gagal",
                  text                : 'Gagal menampilkan data',
                  type                : 'error',
                  showConfirmButton   : false,
                  timer               : 1000
              }); 

              return false;
          }
      })

      // $('#sobb').attr('readonly', true);
      // $('#tocc').attr('disabled', true);
      // $('#cobb').attr('disabled', true);
      // $('#id_lobb').attr('disabled', true);

      return false;
      
    })

    // 19-05-2021
    $('#tabel_entry').on('click', '.detail', function () {

      var id_sppa     = $(this).data('id');
      var sppa_number = $(this).attr('sppa_number');

      $('.f_tab').slideUp();

      $.ajax({
          url     : "<?= base_url('entry_sppa/tampil_detail_sppa') ?>",
          method  : "POST",
          data    : {id_sppa:id_sppa, jenis:'entry'},
          success : function (data) {

              var sts         = $('#status_toggle').val();

              $('html, body').animate({
                  scrollTop: $('body').offset().top
              }, 800);

              if (sts == 0) {
                  $('.f_tambah').slideToggle('fast', function() {
                      if ($(this).is(':visible')) {
                          $('#status_toggle').val(1);          
                      } else {  
                          $('#status_toggle').val(0);            
                      }        
                  });  
              }
              
              $('.f_tab').slideUp();

              $('.f_tab_detail').html(data);
              $('.f_tab_detail').slideDown();
              $('.f_tab_edit').slideUp();

              $('#sppa_number').text(sppa_number);

              $('#judul').text('Detail SPPA');

              $('.footer_input').slideUp();

          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              swal({
                  title               : "Gagal",
                  text                : 'Gagal Menampilkan Data',
                  type                : 'error',
                  showConfirmButton   : false,
                  timer               : 1000
              }); 

              return false;
          }
      })
      
    })

    // 19-05-2021
    $('#tabel_entry').on('click', '.edit', function () {

      var id_sppa     = $(this).data('id');
      var sppa_number = $(this).attr('sppa_number');

      $('#simpan_dok').text('Simpan');

      $('.f_tab').slideUp();

      $.ajax({
          url     : "<?= base_url('entry_sppa/tampil_edit_sppa') ?>",
          method  : "POST",
          data    : {id_sppa:id_sppa},
          success : function (data) {

            var sts         = $('#status_toggle').val();

            $('html, body').animate({
                scrollTop: $('body').offset().top
            }, 800);

            if (sts == 0) {
                $('.f_tambah').slideToggle('fast', function() {
                    if ($(this).is(':visible')) {
                        $('#status_toggle').val(1);          
                    } else {  
                        $('#status_toggle').val(0);            
                    }        
                });  
            }

            $('.f_tab').slideUp();

            $('.f_tab_detail').slideUp();
            $('.f_tab_edit').html(data);
            $('.f_tab_edit').slideDown();

            $('#sppa_number').text(sppa_number);

            $('.footer_input').slideDown();

            $('#judul').text('Edit SPPA');

          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              swal({
                  title               : "Gagal",
                  text                : 'Gagal Menampilkan Data',
                  type                : 'error',
                  showConfirmButton   : false,
                  timer               : 1000
              }); 

              return false;
          }
      })

    })

    // 19-05-2021
    $('#tabel_entry').on('click', '.hapus', function () {

      var id_sppa = $(this).data('id');

      swal({
          title       : 'Konfirmasi',
          text        : 'Yakin akan hapus data?',
          type        : 'warning',

          buttonsStyling      : false,
          confirmButtonClass  : "btn btn-danger",
          cancelButtonClass   : "btn btn-primary mr-3",

          showCancelButton    : true,
          confirmButtonText   : 'Ya, hapus',
          confirmButtonColor  : '#3085d6',
          cancelButtonColor   : '#d33',
          cancelButtonText    : 'Batal',
          reverseButtons      : true
      }).then((result) => {
          if (result.value) {
              $.ajax({
                  url     : "<?= base_url() ?>entry_sppa/hapus_entry",
                  type    : "POST",
                  beforeSend  : function () {
                      swal({
                          title   : 'Menunggu',
                          html    : 'Memproses Data',
                          onOpen  : () => {
                              swal.showLoading();
                          }
                      })
                  },
                  data    : {id_sppa:id_sppa},
                  dataType: "JSON",
                  success : function (data) {

                    swal({
                      title               : "Berhasil",
                      text                : 'Data Berhasil dihapus',
                      type                : 'success',
                      showConfirmButton   : false,
                      timer               : 1000
                    }); 

                    tabel_entry.ajax.reload(null,false);  

                    var sts         = $('#status_toggle').val();

                    $('html, body').animate({
                        scrollTop: $('body').offset().top
                    }, 800);

                    if (sts == 1) {
                        $('.f_tambah').slideToggle('fast', function() {
                            if ($(this).is(':visible')) {
                                $('#status_toggle').val(1);          
                            } else {  
                                $('#status_toggle').val(0);            
                            }        
                        });  
                    }
                      
                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                      swal({
                          title               : "Gagal",
                          text                : 'Gagal Proses Data',
                          type                : 'error',
                          showConfirmButton   : false,
                          timer               : 1000
                      }); 

                      return false;
                  }
              })

              return false;

          } else if (result.dismiss === swal.DismissReason.cancel) {

              swal({
                  title               : "Batal",
                  text                : 'Anda membatalkan hapus data',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-primary",
                  type                : 'error',
                  showConfirmButton   : false,
                  timer               : 1000
              }); 
          }
      })

      return false;

    })

    // 25-05-2021
    $('.lanjutkan').on('click', function () {

      var aksi_next = $(this).attr('aksi');

      $('html, body').animate({
          scrollTop: $('body').offset().top
      }, 800);

      $('.link_'+aksi_next).removeClass('disabled');
      activaTab(aksi_next);  

    })

    function activaTab(tab){
      $('.nav-tabs a[href="#' + tab + '"]').tab('show');
    };

    function tambah_entry() {
      
      var sts         = $('#status_toggle').val();

      $('html, body').animate({
          scrollTop: $('body').offset().top
      }, 800);

      if (sts == 0) {
        $('.f_tambah').slideToggle('fast', function() {
            if ($(this).is(':visible')) {
                $('#status_toggle').val(1);          
            } else {  
                $('#status_toggle').val(0);            
            }        
        });  
      } 

      $('#judul').text('Tambah SPPA');
      // $('.link_entry').addClass('disabled');

      $.ajax({
        url     : "<?= base_url('entry_sppa/tampil_input') ?>",
        method  : "POST",
        success : function (data) {

          $('.f_tab').html(data);
          
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            swal({
                title               : "Gagal",
                text                : 'Gagal menampilkan data',
                type                : 'error',
                showConfirmButton   : false,
                timer               : 1000
            }); 

            return false;
        }
      })

      $.ajax({
        url     : "<?= base_url('entry_sppa/get_kode') ?>",
        method  : "POST",
        dataType: "JSON",
        success : function (data) {

          $('#sppa_number').text(data.sppa_number);
          
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            swal({
                title               : "Gagal",
                text                : 'Gagal proses data',
                type                : 'error',
                showConfirmButton   : false,
                timer               : 1000
            }); 

            return false;
        }
      })
    }

    function stringify(obj) {
        const replacer = [];
        for (const key in obj) {
            replacer.push(key);
        }
        return JSON.stringify(obj, replacer);
    }

    // $('#form_entry').parsley();

    $("#sobb").change(function() {
        $(this).trigger('input')
    });

    $('#here input').on()

    $("#here").on("keydown keyup", '.min_max', function(){
        var value       = $(this).val();
        var name        = $(this).attr('id');
        var minLength   = parseInt($(this).attr('min'));
        var maxLength   = parseInt($(this).attr('max'));

        if (value != '') {

          if (value.length < minLength) {
              $("#span_"+name).text("Minimal "+minLength+" Karakter");
              $('.simpan_semua').attr('disabled', true);
          } else if (value.length > maxLength) {
              $("#span_"+name).text("Maximal "+maxLength+" Karakter");
              $('.simpan_semua').attr('disabled', true);
          } else {
              $("#span_"+name).text("");
              $('.simpan_semua').attr('disabled', false);
          }

        } else {
          $("#span_"+name).text("");
          $('.simpan_semua').attr('disabled', false);
        }

        
    });

    $('.simpan_semua').on('click', function () {

      tinymce.triggerSave();

      var aksi_next = $(this).attr('aksi');

      var form_client     = $('#form_client').serialize();
      var form_detail     = $('#form_detail').serialize();

      console.log(form_client);

      // var im_form = document.querySelector("#form_client");

      // var form_client = new FormData(im_form);

      var lob_adt           = [];
      var kalkulasi_tsi_adt = [];
      var pengali_tsi_adt   = [];
      var rate_adt          = [];
      var nominal_adt       = [];
      var rate_all_premi    = [];
      var nominal_all_premi = [];
      var id_coverage       = [];
      var premi_standar     = [];
      var premi_perluasan   = [];

      var no_dokumen_t      = [];
      var tgl_bayar_t       = [];
      var jumlah_t          = [];
      var cara_bayar_t      = [];
      var tgl_terima_t      = [];

      $('.lob_adt').each(function() { 
          lob_adt.push($(this).val()); 
      });
      $('.kalkulasi_tsi_adt').each(function() { 
          kalkulasi_tsi_adt.push($(this).val()); 
      });
      $('.pengali_tsi_adt').each(function() { 
          pengali_tsi_adt.push($(this).val()); 
      });
      $('.rate_adt').each(function() { 
          rate_adt.push($(this).val()); 
      });
      $('.nominal_adt').each(function() { 
          nominal_adt.push($(this).val()); 
      });
      $('.rate_all_premi').each(function() { 
          rate_all_premi.push($(this).val()); 
      });
      $('.nominal_all_premi').each(function() { 
          nominal_all_premi.push($(this).val()); 
          id_coverage.push($(this).attr('id_coverage')); 
      });
      $('.premi_standar').each(function() { 
          premi_standar.push($(this).val().split('.').join('')); 
      });
      $('.premi_perluasan').each(function() { 
          premi_perluasan.push($(this).val().split('.').join('')); 
      });

      $('.no_dokumen_t').each(function() { 
        no_dokumen_t.push($(this).text()); 
      });

      $('.tgl_bayar_t').each(function() { 
        tgl_bayar_t.push($(this).text()); 
      });

      $('.jumlah_t').each(function() { 
        jumlah_t.push($(this).text()); 
      });

      $('.cara_bayar_t').each(function() { 
        cara_bayar_t.push($(this).text()); 
      });

      $('.tgl_terima_t').each(function() { 
        tgl_terima_t.push($(this).text()); 
      });

      var label_dok  = [];
      $('.label_dok').each(function() { 
          label_dok.push($(this).text()); 
      });

      var i_dok       = [];
      $('.dokumen_entry').each(function() { 
          i_dok.push($(this).data('id')); 
      });

      var id_sppa_premi       = $('#id_sppa_premi').val();
      var tsi                 = $('#tsi').val();
      var diskon              = $('#diskon').val();
      var gross_premi         = $('#gross_premi').val();
      var total_diskon        = $('#total_diskon').val();
      var total_persen_premi  = $('#total_persen_premi').val();
      var total_akhir_premi   = $('#total_akhir_premi').val();
      var biaya_admin         = $('#biaya_admin').val();
      var total_tagihan       = $('#total_tagihan').val();
      var payment_method      = $('#payment_method').val();
      var tahun_pay           = $('#tahun_pay').val();
      var jumlah_cicilan      = $('#jumlah_cicilan').val();

      let formData  = new FormData()
      var excelfile = document.getElementById('excelfile').files[0];

      var dokumen         = [];
      var nama_dok        = [];
      var desc_mop        = [];
      var desc_val        = [];
      for (let index = 0; index < i_dok.length; index++) {
          const element = i_dok[index];
          
          nama_dok[index] = "dokumen_"+index;
          desc_mop[index] = "desc_"+index;

          dokumen[index]  = document.getElementById('dokumen_'+element).files[0];

          desc_val[index] = $('#desc_'+element).val();
      }

      for (let i = 0; i < dokumen.length; i++) {

          formData.append(nama_dok[i], dokumen[i]);
          formData.append(desc_mop[i], desc_val[i]);
          
      }

      formData.append('jumlah', label_dok.length);
      formData.append('id_sppa_premi', id_sppa_premi);
      formData.append('tsi', tsi);
      formData.append('diskon', diskon);
      formData.append('gross_premi', gross_premi);
      formData.append('total_diskon', total_diskon);
      formData.append('total_persen_premi', total_persen_premi);
      formData.append('total_akhir_premi', total_akhir_premi);
      formData.append('biaya_admin', biaya_admin);
      formData.append('total_tagihan', total_tagihan);
      formData.append('payment_method', payment_method);
      formData.append('tahun_pay', tahun_pay);
      formData.append('jumlah_cicilan', jumlah_cicilan);
      formData.append('lob_adt', JSON.stringify(lob_adt));
      formData.append('kalkulasi_tsi_adt', JSON.stringify(kalkulasi_tsi_adt));
      formData.append('pengali_tsi_adt', JSON.stringify(pengali_tsi_adt));
      formData.append('rate_adt', JSON.stringify(rate_adt));
      formData.append('nominal_adt', JSON.stringify(nominal_adt));
      formData.append('rate_all_premi', JSON.stringify(rate_all_premi));
      formData.append('nominal_all_premi', JSON.stringify(nominal_all_premi));
      formData.append('id_coverage', JSON.stringify(id_coverage));
      formData.append('premi_standar', JSON.stringify(premi_standar));
      formData.append('premi_perluasan', JSON.stringify(premi_perluasan));
      formData.append('no_dokumen_t', JSON.stringify(no_dokumen_t));
      formData.append('tgl_bayar_t', JSON.stringify(tgl_bayar_t));
      formData.append('jumlah_t', JSON.stringify(jumlah_t));
      formData.append('cara_bayar_t', JSON.stringify(cara_bayar_t));
      formData.append('tgl_terima_t', JSON.stringify(tgl_terima_t));
      formData.append('form_client', form_client);
      formData.append('form_detail', form_detail);
      formData.append('upload_excel', excelfile);

      var url;
      if (aksi_next == 'deklarasi') {
        url = "<?= base_url() ?>entry_sppa/simpan_semua_deklarasi";
      } else {
        url = "<?= base_url() ?>entry_sppa/simpan_semua";
      }

      // url = "<?= base_url() ?>entry_sppa/simpan_semua";

      swal({
          title       : 'Konfirmasi',
          text        : 'Yakin akan simpan data',
          type        : 'warning',

          buttonsStyling      : false,
          confirmButtonClass  : "btn btn-primary",
          cancelButtonClass   : "btn btn-danger mr-3",

          showCancelButton    : true,
          confirmButtonText   : 'Ya',
          confirmButtonColor  : '#3085d6',
          cancelButtonColor   : '#d33',
          cancelButtonText    : 'Batal',
          reverseButtons      : true
      }).then((result) => {
          if (result.value) {
              $.ajax({
                  url     : url,
                  type    : "POST",
                  beforeSend  : function () {
                      swal({
                          title   : 'Menunggu',
                          html    : 'Memproses Data',
                          onOpen  : () => {
                              swal.showLoading();
                          }
                      })
                  },
                  // data    : {

                  //     id_sppa_premi       : id_sppa_premi,
                  //     tsi                 : tsi,
                  //     diskon              : diskon,
                  //     total_persen_premi  : total_persen_premi,
                  //     total_akhir_premi   : total_akhir_premi,
                  //     biaya_admin         : biaya_admin,
                  //     total_tagihan       : total_tagihan, 
                  //     payment_method      : payment_method,
                  //     tahun_pay           : tahun_pay,
                  //     jumlah_cicilan      : jumlah_cicilan,
                  //     lob_adt             : lob_adt, 
                  //     kalkulasi_tsi_adt   : kalkulasi_tsi_adt,
                  //     pengali_tsi_adt     : pengali_tsi_adt,
                  //     rate_adt            : rate_adt,
                  //     nominal_adt         : nominal_adt, 
                  //     rate_all_premi      : rate_all_premi,
                  //     nominal_all_premi   : nominal_all_premi,
                  //     id_coverage         : id_coverage,
                  //     premi_standar       : premi_standar,
                  //     premi_perluasan     : premi_perluasan,
                  //     form_client         : form_client,
                  //     form_detail         : form_detail

                  // },
                  data            : formData,
                  contentType     : false,
                  cache           : false,
                  processData     : false,
                  dataType        : "JSON",
                  success : function (data) {

                      swal({
                          title               : "Berhasil",
                          text                : 'Data berhasil di simpan',
                          type                : 'success',
                          showConfirmButton   : false,
                          timer               : 1000
                      });

                      if (aksi_next == 'deklarasi') {

                        // $('.id_mop').val(data.id_mop);

                        // $('.check_deklarasi').slideUp();

                        // $('.card_list_dek').slideDown();
                        // tabel_list_dek.ajax.reload(null, false);

                        location.href = "<?= base_url() ?>entry_sppa/list_dek/"+data.id_mop;
                        
                      } else {

                        location.href = "<?= base_url() ?>entry_sppa";

                      }

                      // $('#sppa_number').text(data.sppa_number);

                      // if (aksi_next != '') {

                      //   $('html, body').animate({
                      //       scrollTop: $('body').offset().top
                      //   }, 800);

                      //   $('#id_sppa_invoice').val(data.id_sppa);
                      //   $('.id_sppa').val(data.id_sppa);
                      //   $('.link_'+aksi_next).removeClass('disabled');
                      //   activaTab(aksi_next);  

                      // } else {

                      //   $('html, body').animate({
                      //     scrollTop: $('body').offset().top
                      //   }, 800);

                      //   tampil_awal();

                      // }

                      // tabel_entry.ajax.reload(null, false)
                      
                  }
              })

              return false;

          } else if (result.dismiss === swal.DismissReason.cancel) {

              swal({
                  title               : "Batal",
                  text                : 'Anda membatalkan simpan data',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-primary",
                  type                : 'error',
                  showConfirmButton   : false,
                  timer               : 1000
              }); 
          }
      })

      return false;

    })

    // 25-06-2021
    var tabel_list_dek = $('#tabel_list_dek').DataTable({
        "processing"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "<?= base_url() ?>entry_sppa/tampil_list_dek",
            "type"  : "POST",
            "data"  : function (data) {
                data.id_mop  = $('.id_mop').val();
            },
        },
        "columnDefs"        : [{
            "targets"   : [0,3],
            "orderable" : false
        }, {
            'targets'   : [0,3],
            'className' : 'text-center',
        }]
    })

    // 31-05-2021
    $('#acc_deklarasi').on('change', function () {
      var value = $(this).prop("checked");

      if (value) {

        // $('.lanjutkan_client').attr('aksi', 't_dok1');
        // $('.link_t_detail1').attr('hidden', true);

        // // $('.sel_mop').slideUp();
        // $('.sel_deklarasi').slideDown();

        $('#id_insured').val('').trigger('change');

        $('.card_non_deklarasi').slideUp();
        $('.card_deklarasi').slideDown();

      } else {

        // $('.lanjutkan_client').attr('aksi', 't_detail1');
        // $('.link_t_detail1').attr('hidden', false);

        // // $('.link_entry').addClass('disabled');

        // // $('.sel_mop').slideUp();
        // $('.sel_deklarasi').slideUp();

        $('#exceltable').html('');  
        $('#excelfile').val('');
        
        $('.card_deklarasi').slideUp();
        $('.card_non_deklarasi').slideDown();
      }

    })

    // 31-05-2021
    // aksi untuk menampilkan preview upload
    $('#upload_excel').on('change', function () {
        
        var im_form = document.querySelector("#import_form");

        var form    = new FormData(im_form);

        $.ajax({
            url             : "<?= base_url('entry_sppa/nasabah/1') ?>",
            method          : "POST",
            beforeSend  : function () {
                swal({
                    title   : 'Menunggu',
                    html    : 'Memproses data',
                    onOpen  : () => {
                        swal.showLoading();
                    }
                })
            },
            data            : new FormData(im_form),
            contentType     : false,
            cache           : false,
            processData     : false,
            success         : function (data) {
                swal.close();

                $('.tabel_preview').show();
                $('.b-upload').removeAttr('hidden');
                
                $('.tabel_preview').html(data);
                
            }

        })

        return false;

    })

    // 14-06-2021
    var a = 111;
    $('#tambah_dokumen').on('click', function () {

        $('#tabel_dok_entry').slideDown();

        list = 
            `
            <tr id="list_add`+a+`">
                <td class="label_dok text-center" id="label_dok_`+a+`" data-id="`+a+`">`+a+`.</td>
                <td>
                    <input type="file" id="dokumen_`+a+`" name="dokumen_`+a+`" class="form-control dokumen_entry" data-id="`+a+`">
                    <input type="hidden" class="file_edit" id="file_edit_`+a+`" name="file_edit_`+a+`" data-id="`+a+`" value="baru">
                </td>
                <td><textarea id="desc_`+a+`" name="desc_`+a+`" class="form-control desc_mop" data-id="`+a+`" placeholder="Deskripsi"></textarea></td>
                <td align="center"><span style="cursor:pointer;" data-toggle="tooltip" data-placement="top" title="Hapus" class="remove text-danger ttip" data-id="`+a+`"><i class="mdi mdi-trash-can-outline mdi-24px"></i></span></td>
            </tr>
            `;    

        $('#show_dokumen').append(list);
        $('#list_add'+a).hide().slideDown();

        ubah_label();

        a++;
    
    })

    // 11-06-2021
    $('#show_dokumen').on('click', '.remove', function() {

        var id = $(this).data('id');

        $('#list_add'+id).fadeOut(function(){ 

            $(this).remove();

            var label_dok = [];
            $('.label_dok').each(function() { 
                label_dok.push($(this).val()); 
            });

            if (label_dok.length == 0) {

                $('#tabel_dok_entry').slideUp(30);
            }

            ubah_label();
        });


    });

    // ubah label
    function ubah_label() {

        var label_dok  = [];
        $('.label_dok').each(function() { 
            label_dok.push($(this).data('id')); 
        });

        let i = 1;
        for (let h = 0; h < label_dok.length; h++) {
            const element = label_dok[h];
            
            $('#label_dok_'+element).text(i+".");
        
            i++;
        }
        
    }

    // - AFIF
  })
</script>
