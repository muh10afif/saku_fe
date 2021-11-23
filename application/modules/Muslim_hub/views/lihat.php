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
<style>
     .btn-toggle {
        margin: 0 4rem;
        padding: 0;
        position: relative;
        border: none;
        height: 1.5rem;
        width: 3rem;
        border-radius: 1.5rem;
        color: #354558;
        background: #006c45;
    }
    .btn-toggle:focus, .btn-toggle:focus.active, .btn-toggle.focus, .btn-toggle.focus.active {
        outline: none;
        
    }
    .btn-toggle:before, .btn-toggle:after {
        line-height: 1.5rem;
        width: 6rem;
        text-align: center;
        font-weight: 600;
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        position: absolute;
        bottom: 0;
        transition: opacity .25s;
    }
    .btn-toggle:before {
        content: 'Aktif';
        left: -5rem;
    }
    .btn-toggle:after {
        content: 'Tidak Aktif';
        right: -7rem;
        opacity: .5;
    }
    .btn-toggle > .handle {
        position: absolute;
        top: 0.1875rem;
        left: 0.1875rem;
        width: 1.125rem;
        height: 1.125rem;
        border-radius: 1.125rem;
        background: #fff;
        transition: left .25s;
    }
    .btn-toggle.active {
        transition: background-color .25s;
    }
    .btn-toggle.active {
        background-color: #fc5454;
    }
    .btn-toggle.active > .handle {
        left: 1.6875rem;
        transition: left .25s;
    }
    .btn-toggle.active:before {
        opacity: .5;
    }
    .btn-toggle.active:after {
        opacity: 1;
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

    <div class="col-md-7">
        <div class="card shadow ">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="tabel_muslim_hub" width="100%" cellspacing="0">
                    <thead class="thead-light text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama</th>
                            <th width="20%">Link</th>
                            <th width="20%">Image</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="zoom-gallery">
                            
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0 judul">Tambah Data</h5>
            </div>
            <form id="form_muslim_hub" autocomplete="off">
                <input type="hidden" name="id_muslim_hub" id="id_muslim_hub">
                <input type="hidden" name="aksi" id="aksi" value="Tambah">
                <div class="card-body d-flex justify-content-center">
                    <div class="col-md-12">
                        
                        <div class="form-group">
                            <label for="muslim_hub" class="col-form-label text-left">Nama<span class="text-danger">*</span></label>
                            <div class="">
                                <input type="text" class="form-control" id="muslim_hub" name="muslim_hub" placeholder="Masukkan Deskripsi" required data-parsley-required-message="Deskripsi harus terisi.">
                            </div>
                        </div>  

                        <div class="form-group">
                            <label for="link" class="col-form-label text-left">Link<span class="text-danger">*</span></label>
                            <div class="">
                                <input type="text" class="form-control" id="link" name="link" placeholder="Masukkan Link" required data-parsley-required-message="Link harus terisi.">
                            </div>
                        </div> 

                        <div class="form-group card-img-sblm" style="display: none;">
                            <label for="asuransi" class="col-form-label text-left">Image Sebelumnya</label>
                            <div class="card mb-0">
                                <img class="card-img-top img-fluid" id="img_sblm" src="" height="200px">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="image" class="col-form-label text-left judul_img">Image<span class="text-danger">*</span></label>
                            <div class="">
                                <input type="file" name="image" id="image" class="form-control" accept="image/png, image/jpeg" required data-parsley-required-message="Logo harus diisi.">
                            </div>
                        </div>  
                        <p class="text-danger txt_image" style="display: none;">Pilih image bila ingin mengubah dengan yang baru!</p>

                        <div class="form-group card-img" style="display: none;">
                            <div class="card mb-0">
                                <img class="card-img-top img-fluid" id="ImgPreview" src="" class="preview1" height="200px">
                                <div class="card-body">
                                    <button class="btn-block btn-danger btn-rmv1" id="removeImage1">Hapus</button>
                                </div>
                            </div>
                        </div>
                        <p class="font-italic text-danger mt-3">(*) Data harus terisi.</p>
                        <hr>
                        <div class="form-group text-center mt-1 mb-0">
                            <?php if ($role['create'] == 'true' || $id_lvl_otorisasi == 0) : ?>
                                <button type="submit" class="btn btn-primary mt-1 mr-3"><i class="fas fa-check mr-1"></i> Simpan</button>
                            <?php endif; ?>

                            <button type="button" class="btn btn-danger mt-1 batal_muslim_hub" id="batal_muslim_hub"><i class="fas fa-times mr-1"></i> Batal</button>
                        </div>   
                        
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {

        // menampilkan list muslim_hub
        var tabel_list_muslim_hub = $('#tabel_muslim_hub').DataTable({
            "processing"        : true,
            "serverSide"        : true,
            "order"             : [],
            "ajax"              : {
                "url"   : "<?= base_url() ?>Muslim_hub/tampil_data_muslim_hub",
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
                "targets"   : [0,4],
                "orderable" : false
            }, {
                'targets'   : [0,3,4],
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

        // 30-08-2021
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

        
        // 06-09-2021
        $('#form_muslim_hub').parsley({
            errorsContainer: function(el) {
                return el.$element.closest('.form2');
            }
        });

        $('#batal_muslim_hub').on('click', function () {
            reset_form();
        })

        function reset_form() {
            $('#aksi').val('Tambah');
            $('#form_muslim_hub').trigger("reset");
            $('#form_muslim_hub').parsley().reset();

            $('#link').val('');
            $('#muslim_hub').val('');
            $('#image').val('');
            $("#ImgPreview").attr("src", "");
            $('.btn-rmv1').removeClass('rmv');
            $('.card-img').slideUp();
            $('.card-img-sblm').fadeOut();
            $('.judul_img').html('Image <span class="text-danger">*</span>');
            $('#image').attr('required', true);
            $('.txt_image').fadeOut();

            $('.judul').text('Tambah Data');

            animasi_keatas();
        }

        function animasi_keatas() {
            $('html, body').animate({
                scrollTop: $('body').offset().top
            }, 800);
        }

        $('#form_muslim_hub').on('submit', function () {

            var form_muslim_hub = new FormData(this);

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
                        url     : "<?= base_url() ?>Muslim_hub/simpan_muslim_hub",
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
                        data            : form_muslim_hub,
                        contentType     : false,
                        cache           : false,
                        processData     : false,
                        dataType: "JSON",
                        success : function (data) {

                            if (data.status == 'tipe_salah') {

                                swal({
                                    title               : "Peringatan",
                                    text                : 'Harap upload tipe image jpg atau png!',
                                    buttonsStyling      : false,
                                    confirmButtonClass  : "btn btn-primary",
                                    type                : 'warning',
                                    showConfirmButton   : true,
                                    allowOutsideClick   : false
                                });
                                
                                return false;
                            }

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

                            $('.kode_muslim_hub').val(data.kode_muslim_hub);

                            tabel_list_muslim_hub.ajax.reload(null,false);        
                            reset_form();
                            
                        }
                    })
            
                    return false;

                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal.close();
                }
            })

            return false;
            
        })

        $('#tabel_muslim_hub').on('click', '.edit', function () {

            var id_muslim_hub   = $(this).data('id');
            var link            = $(this).attr('link');       
            var muslim_hub      = $(this).attr('nama');       
            var image           = $(this).attr('image');

            $('#aksi').val('Ubah');
            $('.judul').text('Ubah Data');
            $('#id_muslim_hub').val(id_muslim_hub);
            $('#link').val(link);

            var mh = muslim_hub.replace("999", "'");

            $('#muslim_hub').val(mh);

            if (image != '') {
                $('.card-img-sblm').fadeIn();
                $('#img_sblm').attr('src', "<?= $url_img.'logo/' ?>"+image);
                $('.judul_img').html('Image Baru<span class="text-danger">*</span>');

                $('#image').removeAttr('required');
                $('.txt_image').fadeIn();
            } else {

                $('#image').val('');
                $("#ImgPreview").attr("src", "");
                $('.btn-rmv1').removeClass('rmv');
                $('.card-img').slideUp();
                $('.card-img-sblm').fadeOut();
                $('.judul_img').html('Image<span class="text-danger">*</span>');
                $('#image').attr('required', true);
                $('.txt_image').fadeOut();
                
            }

            animasi_keatas();
            
        })

        $('#tabel_muslim_hub').on('click', '.hapus', function () {

            var id_muslim_hub = $(this).data('id');

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
                            url         : "<?= base_url() ?>Muslim_hub/simpan_muslim_hub",
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
                            data        : {aksi:'Hapus', id_muslim_hub:id_muslim_hub},
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

                                $('.kode_muslim_hub').val(data.kode_muslim_hub);
                
                                tabel_list_muslim_hub.ajax.reload(null,false);
                                
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