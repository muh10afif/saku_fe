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
        <div class="col-sm-6">
            <h4><?= $title ?></h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">All COB</a></li>
                <li class="breadcrumb-item">Master Tables</li>
                <li class="breadcrumb-item active"><?= $title ?></li>
            </ol>
        </div>
    </div>
</div>
<input type="hidden" id="status_toggle">

<div class="row">

    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header">
                <button type="button" class="btn btn-primary float-right" id="tambah_data"><i class="fas fa-plus mr-2"></i>Tambah Data</button>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="tabel_produk_asuransi" width="100%" cellspacing="0">
                    <thead class="thead-light text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Asuransi</th>
                            <th width="20%">LOB</th>
                            <th width="20%">Premi</th>
                            <th width="20%">Kode Produk</th>
                            <th width="20%">Image</th>
                            <th width="5%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody  class="zoom-gallery">
                            
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<div id="modal_pro_as" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title mt-0 judul_modal">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            <form id="form_produk_asuransi" autocomplete="off">
                <input type="hidden" name="id_produk_asuransi" id="id_produk_asuransi">
                <input type="hidden" name="aksi" id="aksi" value="Tambah">
                <input type="hidden" name="nama_image" id="nama_image">
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
                            <label for="lob" class="col-form-label text-left">LOB<span class="text-danger">*</span></label>
                            <div class="">
                                <select name="lob" id="lob" class="select2" required data-parsley-required-message="LOB harus terisi.">
                                    <option value="">Pilih LOB</option>
                                    <?php foreach ($lob as $l): ?>
                                        <option value="<?= $l['id_lob'] ?>"><?= $l['lob'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>   
                        <div class="form-group form2">
                            <label for="bobot" class="col-form-label text-left">Premi<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">Rp.</span>
                                </div>
                                <input type="text" class="form-control text-right numeric number_separator" id="premi" name="premi" placeholder="Masukkan Premi" required data-parsley-required-message="Premi harus terisi.">
                            </div>
                        </div>  
                        <!-- <div class="form-group">
                            <label for="asuransi" class="col-form-label text-left">Kode Produk Asuransi</label>
                            <div class="">
                                <input type="text" class="form-control" id="kode_produk_asuransi" name="kode_produk_asuransi" readonly>
                            </div>
                        </div> -->
                        <div class="form-group card-img-sblm" style="display: none;">
                            <label for="asuransi" class="col-form-label text-left">Image Sebelumnya</label>
                            <div class="card mb-0">
                                <img class="" id="img_sblm" src="" width="50%">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="asuransi" class="col-form-label text-left judul_img">Logo Premi<span class="text-danger">*</span></label>
                            <div class="">
                                <input type="file" name="image" id="image" class="form-control" accept="image/png, image/jpeg" required data-parsley-required-message="Image harus diisi.">
                            </div>
                        </div>  
                        <p class="text-danger txt_image" style="display: none;">Pilih image bila ingin mengubah dengan yang baru!</p>

                        <div class="form-group card-img" style="display: none;">
                            <!-- <img id="ImgPreview" src="" class="preview1" height="200px"/>
                            <input type="button" id="removeImage1" value="Hapus" class="btn-rmv1"/> -->

                            <div class="card mb-0">
                                <img class="card-img-top img-fluid" id="ImgPreview" src="" class="preview1" height="200px">
                                <div class="card-body">
                                    <button class="btn-block btn-danger btn-rmv1" id="removeImage1">Hapus</button>
                                </div>
                            </div>
                        </div>

                        <p class="font-italic text-danger">(*) Data harus terisi.</p>
                        <hr>
                        <div class="form-group text-center mt-1 mb-0">
                            <?php if ($role['create'] == 'true' || $id_lvl_otorisasi == 0) : ?>
                                <button type="submit" class="btn btn-primary mt-1 mr-3"><i class="fas fa-check mr-1"></i> Simpan</button>
                            <?php endif; ?>

                            <button type="button" class="btn btn-danger mt-1 batal_produk_asuransi" id="batal_produk_asuransi"><i class="fas fa-times mr-1"></i> Reset</button>
                            <button type="button" class="btn btn-secondary mt-1" id="batal_close" data-dismiss="modal"><i class="fas fa-times mr-2"></i>Batal</button>
                        </div>   
                        
                    </div>

                </div>
            </form>
                
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {

        // menampilkan list produk_asuransi
        var tabel_list_produk_asuransi = $('#tabel_produk_asuransi').DataTable({
            "processing"        : true,
            "serverSide"        : true,
            "order"             : [],
            "ajax"              : {
                "url"   : "<?= base_url() ?>Produk_asuransi/tampil_data_produk_asuransi",
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
                "targets"   : [0,6],
                "orderable" : false
            }, {
                'targets'   : [0,5,6],
                'className' : 'text-center',
            }],
            "fnDrawCallback": function () {
                $('.image-popup-no-margins').magnificPopup({
                    type: 'image',
                    closeOnContentClick: true,
                    closeBtnInside: false,
                    fixedContentPos: true,
                    mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
                    image: {
                        verticalFit: true
                    },
                    zoom: {
                        enabled: true,
                        duration: 300 // don't foget to change the duration also in CSS
                    }
                });

                $('.zoom-gallery').magnificPopup({
                    delegate: 'a',
                    type: 'image',
                    closeOnContentClick: false,
                    closeBtnInside: false,
                    mainClass: 'mfp-with-zoom mfp-img-mobile',
                    image: {
                        verticalFit: true,
                        titleSrc: function(item) {
                            return item.el.attr('title') + ' &middot; <a href="'+item.el.attr('data-source')+'" target="_blank">image source</a>';
                        }
                    },
                    gallery: {
                        enabled: true
                    },
                    zoom: {
                        enabled: true,
                        duration: 300, // don't foget to change the duration also in CSS
                        opener: function(element) {
                            return element.find('img');
                        }
                    }
                });
            }
        })

        $('#tambah_data').on('click', function () {

            reset_form();

            $('#modal_pro_as').modal('show');
            
        })

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

        
        // 25-08-2021
        $('#form_produk_asuransi').parsley({
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

        $('#batal_produk_asuransi').on('click', function () {
            reset_form();
        })

        function reset_form() {
            $('#aksi').val('Tambah');
            $('.judul_modal').text('Tambah Data');

            $('#batal_produk_asuransi').attr('hidden', false);
            $('#batal_close').attr('hidden', true);

            $('#asuransi').val('').trigger('change');
            $('#lob').val('').trigger('change');
            $('#premi').val('');
            $('#kode_produk_asuransi').val('');
            $('#form_produk_asuransi').parsley().reset();

            $('#image').val('');
            $("#ImgPreview").attr("src", "");
            $('.btn-rmv1').removeClass('rmv');
            $('.card-img').slideUp();
            $('.card-img-sblm').fadeOut();
            $('.judul_img').html('Image <span class="text-danger">*</span>');
            $('#image').attr('required', true);
            $('.txt_image').fadeOut();
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

        $('#form_produk_asuransi').on('submit', function () {

            var form_produk_asuransi = new FormData(this);

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
                            url     : "<?= base_url() ?>Produk_asuransi/simpan_produk_asuransi",
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
                            data            : form_produk_asuransi,
                            contentType     : false,
                            cache           : false,
                            processData     : false,
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

                                $('#modal_pro_as').modal('hide');
                                
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
                
                                tabel_list_produk_asuransi.ajax.reload(null,false);        
                                
                            }
                        })
                
                        return false;

                    } else if (result.dismiss === swal.DismissReason.cancel) {
                        swal.close();
                    }
                })

                return false;
            
        })

        $('#tabel_produk_asuransi').on('click', '.edit', function () {

            var id_tr       = $(this).data('id');
            var id_asuransi = $(this).attr('id_asuransi');       
            var id_lob      = $(this).attr('id_lob');       
            var premi       = $(this).attr('premi');
            var image       = $(this).attr('logo_premi');

            $('#aksi').val('Ubah');

            $('#batal_produk_asuransi').attr('hidden', true);
            $('#batal_close').attr('hidden', false);

            $('.judul_modal').text('Ubah Data');

            $('#id_produk_asuransi').val(id_tr);
            $('#asuransi').val(id_asuransi).trigger('change');       
            $('#lob').val(id_lob).trigger('change');
            $('#premi').val(number_format(premi,0,',','.'));   
            
            $('#nama_image').val(image);
            
            $('.card-img-sblm').fadeIn();
            $('#img_sblm').attr('src', "<?= $url_img.'produk/' ?>"+image);
            $('.judul_img').html('Image Baru <span class="text-danger">*</span>');

            $('#image').removeAttr('required');
            $('.txt_image').fadeIn();

            $('#modal_pro_as').modal('show');

            animasi_keatas();
            
        })

        $('#tabel_produk_asuransi').on('click', '.hapus', function () {

            var id_tr       = $(this).data('id');
            var nama_image  = $(this).attr('logo_premi');

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
                            url         : "<?= base_url() ?>Produk_asuransi/simpan_produk_asuransi",
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
                            data        : {aksi:'Hapus', id_produk_asuransi:id_tr, nama_image:nama_image},
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
                
                                tabel_list_produk_asuransi.ajax.reload(null,false);
                                
                            },
                            error       : function(xhr, status, error) {

                                swal({
                                    title               : 'Gagal',
                                    text                : 'Simpan data tidak berhasil',
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