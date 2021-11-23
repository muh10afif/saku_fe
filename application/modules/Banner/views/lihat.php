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
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">CMS</a></li>
                <li class="breadcrumb-item">Data Home</li>
                <li class="breadcrumb-item active"><?= $title ?></li>
            </ol>
        </div>
    </div>
</div>
<input type="hidden" id="status_toggle">

<div class="row">

    <div class="col-md-7">
        <div class="card shadow">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="tabel_banner" width="100%" cellspacing="0">
                    <thead class="thead-light text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Image</th>
                            <th width="20%">Detail</th>
                            <th width="10%">Aktif</th>
                            <th width="5%">Aksi</th>
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
            <form id="form_banner" autocomplete="off">
                <input type="hidden" name="id_banner" id="id_banner">
                <input type="hidden" name="aksi" id="aksi" value="Tambah">
                <input type="hidden" name="nama_image" id="nama_image">
                <div class="card-body d-flex justify-content-center">
                    <div class="col-md-12">

                        <div class="form-group card-img-sblm" style="display: none;">
                            <label for="asuransi" class="col-form-label text-left">Image Sebelumnya</label>
                            <div class="card mb-0">
                                <img class="card-img-top img-fluid" id="img_sblm" src="" height="200px">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="asuransi" class="col-form-label text-left judul_img">Image<span class="text-danger">*</span></label>
                            <div class="">
                                <input type="file" name="image" id="image" class="form-control" accept="image/png, image/jpeg" required data-parsley-required-message="Image harus diisi.">
                            </div>
                        </div>  
                        <p class="text-danger txt_image" style="display: none;">Pilih image bila ingin mengubah dengan yang baru!</p>

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
                           
                        <div class="form-group">
                            <label for="lob" class="col-form-label text-left">Detail</label>
                            <div class="">
                                <textarea name="detail" id="detail" rows="5" class="form-control" placeholder="Masukkan Detail"></textarea>
                            </div>
                        </div> 
                        <div class="form-group mt-2">
                            <!-- <div class="custom-control custom-switch">
                                <input type="checkbox" name="aktif" class="custom-control-input" id="aktif" checked> 
                                <label class="custom-control-label" for="aktif">Aktif</label>
                            </div> -->

                            <button type="button" class="btn btn-toggle st_aktif" data-toggle="button" aria-pressed="false" autocomplete="off" value="1">
                                
                            <div class="handle"></div>
                            </button>
                        </div>

                        <input type="hidden" id="val_aktif" name="status" value="1">

                        <p class="font-italic text-danger">(*) Data harus terisi.</p>
                        <hr>
                        <div class="form-group text-center mt-1 mb-0">
                            <?php if ($role['create'] == 'true' || $id_lvl_otorisasi == 0) : ?>
                                <button type="submit" class="btn btn-primary mt-1 mr-3"><i class="fas fa-check mr-1"></i> Simpan</button>
                            <?php endif; ?>

                            <button type="button" class="btn btn-danger mt-1 batal_banner" id="batal_banner"><i class="fas fa-times mr-1"></i> Batal</button>
                        </div>   
                        
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>


<script>

    $(document).ready(function () {

        // menampilkan list banner
        var tabel_list_banner = $('#tabel_banner').DataTable({
            "processing"        : true,
            "serverSide"        : true,
            "order"             : [],
            "ajax"              : {
                "url"   : "<?= base_url() ?>Banner/tampil_data_banner",
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
                        duration: 200 // don't foget to change the duration also in CSS
                    }
                });

                $('.image-popup-vertical-fit').magnificPopup({
                    type: 'image',
                    closeOnContentClick: true,
                    mainClass: 'mfp-img-mobile',
                    image: {
                        verticalFit: true
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
        
        // 27-08-2021
        $('#form_banner').parsley();

        $('#batal_banner').on('click', function () {
            reset_form();
        })

        function reset_form() {
            $('#aksi').val('Tambah');
            $('#image').val('');
            $("#ImgPreview").attr("src", "");
            $('.btn-rmv1').removeClass('rmv');
            $('.card-img').slideUp();
            $('.card-img-sblm').fadeOut();
            $('.judul_img').text('Image');
            $('#image').attr('required', true);
            $('.txt_image').fadeOut();
            $('#form_banner').trigger("reset");
            $('#form_banner').parsley().reset();
            $('.st_aktif').attr('aria-pressed', 'false');
            $('.st_aktif').attr('value', '1');
            $('.st_aktif').removeClass('active');
            $('.judul').text('Tambah Data');
            
        }

        function animasi_keatas() {
            $('html, body').animate({
                scrollTop: $('body').offset().top
            }, 800);
        }

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

        // 29-08-2021
        $('.st_aktif').on('click', function () {

            if($(this).attr('value') == "0") {
                $(this).attr('value', "1");
                $('#val_aktif').val("1");
            } else if ($(this).attr('value') == "1") {
                $(this).attr('value', "0");
                $('#val_aktif').val("0");
            }
            
        })

        $('#form_banner').on('submit', function () {

            var form_banner = new FormData(this);

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
                            url     : "<?= base_url() ?>Banner/simpan_banner",
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
                            data            : form_banner,
                            contentType     : false,
                            cache           : false,
                            processData     : false,
                            dataType        : "JSON",
                            success : function (data) {

                                if (data.status == 'success') {

                                    reset_form();

                                    tabel_list_banner.ajax.reload(null,false);   

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
                                    
                                } else {

                                    swal({
                                        title               : "Gagal",
                                        html                : "Tipe File Harus png atau jpg",
                                        buttonsStyling      : false,
                                        confirmButtonClass  : "btn btn-danger",
                                        type                : 'error',
                                        showConfirmButton   : true,
                                        allowOutsideClick   : false
                                    }); 

                                }
                
                                
                            }
                        })
                
                        return false;

                    } else if (result.dismiss === swal.DismissReason.cancel) {
                        swal.close();
                    }
                })

                return false;
            
        })

        $('#tabel_banner').on('click', '.edit', function () {

            var id_banner   = $(this).data('id');
            var detail      = $(this).attr('detail');       
            var aktif       = $(this).attr('aktif');       
            var image       = $(this).attr('image');

            $('#aksi').val('Ubah');
            $('.judul').text('Ubah Data');
            $('#id_banner').val(id_banner);
            $('#detail').val(detail);       
            $('#val_aktif').val(aktif);    
            $('#nama_image').val(image);

            if (aktif == '1') {
                $('.st_aktif').attr('aria-pressed', 'false');
                $('.st_aktif').attr('value', '1');
                $('.st_aktif').removeClass('active');
            } else {
                $('.st_aktif').attr('aria-pressed', 'true');
                $('.st_aktif').attr('value', '0');
                $('.st_aktif').addClass('active');
            }

            if (image != '') {
                $('.card-img-sblm').fadeIn();
                $('#img_sblm').attr('src', "<?= $url_up.'banner/' ?>"+image);
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

        $('#tabel_banner').on('click', '.hapus', function () {

            var id_banner   = $(this).data('id');
            var image       = $(this).attr('image');

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
                            url         : "<?= base_url() ?>Banner/simpan_banner",
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
                            data        : {aksi:'Hapus', id_banner:id_banner, nama_image:image},
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
                
                                tabel_list_banner.ajax.reload(null,false);
                                
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