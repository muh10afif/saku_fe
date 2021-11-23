<style>
    .sel2 .parsley-errors-list.filled {
    margin-top: 42px;
    margin-bottom: -60px;
    }

    .sel2 .parsley-errors-list:not(.filled) {
    display: none;
    }

    .sel2 .parsley-errors-list.filled + span.select2 {
    margin-bottom: 30px;
    }

    .sel2 .parsley-errors-list.filled + span.select2 span.select2-selection--single {
        background: #FAEDEC !important;
        border: 1px solid #E85445;
    }
    .table-responsive {
        display: table;
    }
</style>
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h4><?= $title ?></h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">All COB</a></li>
                <li class="breadcrumb-item">Master Data</li>
                <li class="breadcrumb-item active"><?= $title ?></li>
            </ol>
        </div>
    </div>
</div>
<input type="hidden" id="status_toggle">

<div class="row">

    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="tabel_pengecualian" width="100%" cellspacing="0">
                    <thead class="thead-light text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Asuransi</th>
                            <th width="20%">Produk</th>
                            <th width="20%">Premi</th>
                            <th width="20%">Pengecualian</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                            
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0 judul">Tambah Data</h5>
            </div>
            <form id="form_pengecualian" autocomplete="off">
                <input type="hidden" name="id_pengecualian" id="id_pengecualian">
                <input type="hidden" name="aksi" id="aksi" value="Tambah">
                <input type="hidden" name="id_tr_produk_asuransi" id="id_tr_produk_asuransi">
                <div class="card-body d-flex justify-content-center">
                    <div class="col-md-12">
                        
                        <div class="form-group sel2">
                            <label for="asuransi" class="col-form-label text-left">Asuransi<span class="text-danger">*</span></label>
                            <div class="">
                                <select name="asuransi" id="asuransi" class="select2" required data-parsley-required-message="Asuransi harus terisi.">
                                    <option value="">Pilih Asuransi</option>
                                    <?php foreach ($asuransi as $s): ?>
                                        <option value="<?= $s['id_asuransi'] ?>"><?= $s['nama_asuransi'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>  
                           
                        <div class="form-group sel2">
                            <label for="lob" class="col-form-label text-left">Produk<span class="text-danger">*</span></label>
                            <div class="">
                                <select name="lob" id="lob" class="select2" required data-parsley-required-message="Produk harus terisi.">
                                    <option value="">Pilih Produk</option>
                                    <?php foreach ($lob as $l): ?>
                                        <option value="<?= $l['id_lob'] ?>"><?= $l['lob'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>   
                        <div class="form-group sel2 sel_premi" style="display: none;">
                            <label for="premi" class="col-form-label text-left">Premi<span class="text-danger">*</span></label>
                            <div class="">
                                <select name="premi" id="premi" class="select2" required data-parsley-required-message="Premi harus terisi.">
                                    <option value="">Pilih Premi</option>
                                    
                                </select>
                            </div>
                        </div>  
                        <div class="form-group form2 in_premi" style="display: none;">
                            <label for="nilai" class="col-form-label text-left">Premi<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">Rp.</span>
                                </div>
                                <input type="text" class="form-control text-right numeric number_separator" id="input_premi" name="input_premi" placeholder="Masukkan Premi" required data-parsley-required-message="Premi harus terisi.">
                            </div>
                        </div>  
                        <div class="form-group">
                            <label for="lob" class="col-form-label text-left">Pengecualian<span class="text-danger">*</span></label>
                            <div class="">
                                <textarea name="pengecualian" id="pengecualian" rows="5" class="form-control" placeholder="Masukkan Pengecualian" required data-parsley-required-message="Pengecualian harus terisi."></textarea>
                            </div>
                        </div> 
                        <p class="font-italic text-danger">(*) Data harus terisi.</p>
                        <hr>
                        <div class="form-group text-center mt-1 mb-0">
                            <?php if ($role['create'] == 'true' || $id_lvl_otorisasi == 0) : ?>
                                <button type="submit" class="btn btn-primary mt-1 mr-3"><i class="fas fa-check mr-1"></i> Simpan</button>
                            <?php endif; ?>

                            <button type="button" class="btn btn-danger mt-1 batal_pengecualian" id="batal_pengecualian"><i class="fas fa-times mr-1"></i> Batal</button>
                        </div>   
                        
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {

        // menampilkan list pengecualian
        var tabel_list_pengecualian = $('#tabel_pengecualian').DataTable({
            "processing"        : true,
            "serverSide"        : true,
            "order"             : [],
            "ajax"              : {
                "url"   : "<?= base_url() ?>Pengecualian/tampil_data_pengecualian",
                "type"  : "POST",
                "data"  : function (data) {
                    data.read               = "<?= $role['read'] ?>";
                    data.create             = "<?= $role['create'] ?>";
                    data.update             = "<?= $role['update'] ?>";
                    data.delete             = "<?= $role['delete'] ?>";
                    data.id_user            = "<?= $id_user ?>";
                    data.id_lvl_otorisasi   = "<?= $id_lvl_otorisasi ?>";
                }
            },
            "columnDefs"        : [{
                "targets"   : [0,5],
                "orderable" : false
            }, {
                'targets'   : [0,5],
                'className' : 'text-center',
            }]
        })

        // 30-08-2021
        $('#asuransi').on('change', function () {

            tampil_premi();
            
        });

        $('#lob').on('change', function () {

            tampil_premi();
            
        });

        function tampil_premi() {
            var id_asuransi = $('#asuransi').val();
            var id_lob      = $('#lob').val();

            if (id_asuransi == '') {

                if (id_lob == '') {

                    $('.sel_premi').fadeOut('fast');
                    $('#premi').val('').trigger('change');
                    $('#premi').removeAttr('required');

                    $('.in_premi').fadeOut('fast');
                    $('#input_premi').val('').trigger('change');
                    $('#input_premi').removeAttr('required');

                    return false
                } else {
                    $('.sel_premi').fadeOut('fast');
                    
                    swal({
                        title               : "Peringatan",
                        text                : 'Pilih Asuransi dahulu',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-primary",
                        type                : 'warning',
                        showConfirmButton   : true,
                        allowOutsideClick   : false
                    }); 

                    return false 
                }
                
            }

            if (id_lob == '') {

                $('.sel_premi').fadeOut('fast');
                $('#premi').val('').trigger('change');
                $('#premi').removeAttr('required');

                $('.in_premi').fadeOut('fast');
                $('#input_premi').val('').trigger('change');
                $('#input_premi').removeAttr('required');

                return false;
            }

            $.ajax({
                url         : "<?= base_url() ?>Pengecualian/tampil_premi",
                method      : "POST",
                data        : {id_asuransi:id_asuransi, id_lob:id_lob},
                dataType    : "JSON",
                success     : function (data) {

                    if (data.jumlah == 0) {
                        $('.sel_premi').fadeOut('fast');
                        $('#premi').val('').trigger('change');
                        $('#premi').removeAttr('required');

                        $('.in_premi').fadeIn('fast');
                        $('#input_premi').val('');
                        $('#input_premi').attr('required', true);

                    } else {
                        $('#premi').html(data.option);
                        $('.sel_premi').fadeIn('fast');
                        $('#premi').attr('required', true);

                        var id_produk_asuransi  = $('#id_tr_produk_asuransi').val();
                        var aksi                = $('#aksi').val();
                        if (aksi == 'Ubah') {
                            $('#premi').val(id_produk_asuransi).trigger('change');
                        }
                    }
                    
                },
                error       : function(xhr, status, error) {

                    swal({
                        title               : 'Gagal',
                        text                : 'Gagal menampilkan premi',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-success",
                        type                : 'error',
                        showConfirmButton   : false,
                        timer               : 3000
                    }); 
                    
                    return false;
                }

            })

            return false;
        }
        
        // 25-08-2021
        $('#form_pengecualian').parsley({
            errorsContainer: function(el) {
                return el.$element.closest('.form2');
            }
        });

        $("#asuransi").change(function() {
            $(this).trigger('input')
        });
        $("#lob").change(function() {
            $(this).trigger('input')
        });
        $("#premi").change(function() {
            $(this).trigger('input')
        });

        $('#batal_pengecualian').on('click', function () {
            reset_form();
        })

        function reset_form() {
            $('#aksi').val('Tambah');
            $('#lob').val('').trigger('change');
            $('#asuransi').val('').trigger('change');
            $('#premi').val('').trigger('change');
            $('#input_premi').val('');
            $('#form_pengecualian').trigger("reset");
            $('#form_pengecualian').parsley().reset();
            $('.judul').text('Tambah Data');
            $('.sel_premi').fadeOut('fast');
            $('#premi').removeAttr('required');

            animasi_keatas();
        }

        function animasi_keatas() {
            $('html, body').animate({
                scrollTop: $('body').offset().top
            }, 800);
        }

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

        $('#form_pengecualian').on('submit', function () {

            var form_pengecualian = $('#form_pengecualian').serialize();

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
                    reverseButtons      : true,

                    allowOutsideClick   : false
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url     : "<?= base_url() ?>Pengecualian/simpan_pengecualian",
                            type    : "POST",
                            beforeSend  : function () {
                                swal({
                                    title   : 'Menunggu',
                                    html    : 'Memproses Data',
                                    onOpen  : () => {
                                        swal.showLoading();
                                    },
                                    allowOutsideClick   : false
                                })
                            },
                            data    : form_pengecualian,
                            dataType: "JSON",
                            success : function (data) {

                                if (data.status == 'gagal') {

                                    swal({
                                        title               : "Peringatan",
                                        text                : 'Data yang diinput sudah ada, harap ganti!',
                                        buttonsStyling      : false,
                                        confirmButtonClass  : "btn btn-primary",
                                        type                : 'warning',
                                        showConfirmButton   : true,
                                        allowOutsideClick   : false
                                    });
                                    
                                    return false;
                                }
                                
                                swal({
                                    title               : "Berhasil",
                                    text                : 'Data berhasil disimpan',
                                    buttonsStyling      : false,
                                    confirmButtonClass  : "btn btn-success",
                                    type                : 'success',
                                    showConfirmButton   : false,
                                    timer               : 3000,
                                    allowOutsideClick   : false
                                });    

                                reset_form();
                
                                tabel_list_pengecualian.ajax.reload(null,false);        
                                
                            }
                        })
                
                        return false;

                    } else if (result.dismiss === swal.DismissReason.cancel) {
                        swal.close();
                    }
                })

                return false;
            
        })

        $('#tabel_pengecualian').on('click', '.edit', function () {

            var id_pengecualian          = $(this).data('id');
            var id_asuransi         = $(this).attr('id_asuransi');       
            var id_lob              = $(this).attr('id_lob');       
            var pengecualian             = $(this).attr('pengecualian');
            var nilai               = $(this).attr('nilai');
            var keterangan          = $(this).attr('keterangan');
            var id_produk_asuransi  = $(this).attr('id_produk_asuransi');
            var premi               = $(this).attr('premi');

            $('#aksi').val('Ubah');
            $('.judul').text('Ubah Data');
            $('#id_pengecualian').val(id_pengecualian);
            $('#id_tr_produk_asuransi').val(id_produk_asuransi);
            $('#asuransi').val(id_asuransi).trigger('change');       
            $('#lob').val(id_lob).trigger('change');
            $('#pengecualian').val(pengecualian);
            $('#nilai').val(number_format(nilai,0,',','.'));
            $('#keterangan').val(keterangan);           

            animasi_keatas();
            
        })

        $('#tabel_pengecualian').on('click', '.hapus', function () {

            var id_pengecualian = $(this).data('id');

            swal({
                    title       : 'Konfirmasi',
                    text        : 'Yakin akan hapus data?',
                    type        : 'warning',

                    buttonsStyling      : false,
                    confirmButtonClass  : "btn btn-danger",
                    cancelButtonClass   : "btn btn-primary mr-3",

                    showCancelButton    : true,
                    confirmButtonText   : 'Hapus',
                    confirmButtonColor  : '#d33',
                    cancelButtonColor   : '#3085d6',
                    cancelButtonText    : 'Batal',
                    reverseButtons      : true,

                    allowOutsideClick   : false
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url         : "<?= base_url() ?>Pengecualian/simpan_pengecualian",
                            method      : "POST",
                            beforeSend  : function () {
                                swal({
                                    title   : 'Menunggu',
                                    html    : 'Memproses Data',
                                    onOpen  : () => {
                                        swal.showLoading();
                                    },
                                    allowOutsideClick   : false
                                })
                            },
                            data        : {aksi:'Hapus', id_pengecualian:id_pengecualian},
                            dataType    : "JSON",
                            success     : function (data) {

                                swal({
                                    title               : "Berhasil",
                                    text                : 'Data berhasil dihapus',
                                    buttonsStyling      : false,
                                    confirmButtonClass  : "btn btn-success",
                                    type                : 'success',
                                    showConfirmButton   : false,
                                    timer               : 3000,
                                    allowOutsideClick   : false
                                });    

                                reset_form();
                
                                tabel_list_pengecualian.ajax.reload(null,false);
                                
                            },
                            error       : function(xhr, status, error) {

                                swal({
                                    title               : 'Gagal',
                                    text                : 'Hapus data tidak berhasil',
                                    buttonsStyling      : false,
                                    confirmButtonClass  : "btn btn-success",
                                    type                : 'error',
                                    showConfirmButton   : false,
                                    timer               : 3000
                                }); 
                                
                                return false;
                            }

                        })

                        return false;
                    } else if (result.dismiss === swal.DismissReason.cancel) {

                        swal.close();
                    }
                })
            
        })

    })
    
</script>