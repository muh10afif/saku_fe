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
                <li class="breadcrumb-item">Master Data</li>
                <li class="breadcrumb-item active"><?= $title ?></li>
            </ol>
        </div>
    </div>
</div>
<input type="hidden" id="status_toggle">

<div class="row">

    <div class="col-md-12">
        <div class="card shadow">
            <?php if ($id_lvl_otorisasi == 0 || ($role['create'] == 'true')): ?>
                <div class="card-header">
                    <button class="btn btn-primary float-right" id="tambah_news"><i class="fas fa-plus mr-2"></i>Tambah Data</button>
                </div>
            <?php endif; ?>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="tabel_news" width="100%" cellspacing="0">
                    <thead class="thead-light text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Title</th>
                            <th width="20%">News</th>
                            <th width="20%">Images</th>
                            <th width="20%">Sumber</th>
                            <th width="20%">Editor</th>
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

</div>

<!-- Modal -->
<div class="modal fade" id="modal_news" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title mt-0" id="judul_modal">Tambah Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
        <form id="form_news" autocomplete="off">
            <input type="hidden" name="id_news" id="id_news">
            <input type="hidden" name="aksi" id="aksi" value="Tambah">
            <input type="hidden" name="nama_image" id="nama_image">
            <div class="modal-body row">
                <div class="col-md-12">

                    <div class="form-group">
                        <label for="title" class="col-form-label text-left">Title<span class="text-danger">*</span></label>
                        <div class="">
                            <input name="title" id="title" class="form-control" placeholder="Masukkan Title" required data-parsley-required-message="Title harus diisi.">
                        </div>
                    </div> 

                    <div class="form-group">
                        <label for="news" class="col-form-label text-left">News<span class="text-danger">*</span></label>
                        <div class="">
                            <textarea name="news" id="news" rows="5" class="summernote" placeholder="Masukkan News" required data-parsley-required-message="News harus diisi."></textarea>
                        </div>
                    </div> 
                    
                    <div class="form-group card-img-sblm" style="display: none;">
                        <label for="asuransi" class="col-form-label text-left">Image Sebelumnya</label>
                        <div class="card mb-0">
                            <img class="" id="img_sblm" src="" width="50%">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="asuransi" class="col-form-label text-left judul_img">Image<span class="text-danger">*</span></label>
                        <div class="">
                            <input type="file" name="image" id="image" class="form-control" accept="image/png, image/jpeg" required data-parsley-required-message="Image harus diisi.">
                        </div>
                    </div>  
                    <p class="text-danger txt_image" style="display: none;">Pilih image bila ingin mengubah dengan yang baru!</p>

                    <div class="form-group card-img row" style="display: none;">
                        <!-- <img id="ImgPreview" src="" class="preview1" height="200px"/>
                        <input type="button" id="removeImage1" value="Hapus" class="btn-rmv1"/> -->

                        <div class="card mb-0 col-md-6 offset-md-3">
                            <img class="card-img-top img-fluid" id="ImgPreview" src="" class="preview1">
                            <div class="card-body">
                                <button class="btn-block btn-danger btn-rmv1" id="removeImage1">Hapus</button>
                            </div>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label for="sumber" class="col-form-label text-left">Sumber<span class="text-danger">*</span></label>
                        <div class="">
                            <input name="sumber" id="sumber" class="form-control" placeholder="Masukkan Sumber" required data-parsley-required-message="Sumber harus diisi.">
                        </div>
                    </div> 

                    <div class="form-group">
                        <label for="editor" class="col-form-label text-left">Editor<span class="text-danger">*</span></label>
                        <div class="">
                            <input name="editor" id="editor" class="form-control" placeholder="Masukkan Editor" required data-parsley-required-message="Editor harus diisi.">
                        </div>
                    </div> 
                    <div class="form-group">

                        <button type="button" class="btn btn-toggle st_aktif mt-3" data-toggle="button" aria-pressed="false" autocomplete="off" value="1">
                        <div class="handle"></div>
                        </button>

                    </div>

                    <input type="hidden" id="val_aktif" name="status" value="1">
                </div>

                <div class="col-md-12">
                    <p class="font-italic text-danger">(*) Data harus terisi.</p>  
                </div>

            </div>

            <div class="modal-footer">
                <?php if ($role['create'] == 'true' || $id_lvl_otorisasi == 0) : ?>
                    <button type="submit" class="btn btn-primary mt-1 mr-3"><i class="fas fa-check mr-1"></i> Simpan</button>
                <?php endif; ?>

                <button type="button" class="btn btn-danger mt-1" id="batal_news" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Batal</button>
            </div>
        </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_detail" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title mt-0" id="judul_modal">Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
        <div class="modal-body isi_modal">
            
        </div>
    </div>
  </div>
</div>


<script>

    $(document).ready(function () {

        // menampilkan list news
        var tabel_list_news = $('#tabel_news').DataTable({
            "processing"        : true,
            "serverSide"        : true,
            "order"             : [],
            "ajax"              : {
                "url"   : "<?= base_url() ?>News/tampil_data_news",
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
                "targets"   : [0,7],
                "orderable" : false
            }, {
                'targets'   : [0,6,7],
                'className' : 'text-center',
            },
            { 
                "width": "10%", "targets": 7
            },
            { 
                "width": "20%", "targets": 2
            }],
            "autoWidth"     : false,
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

        // 03-09-2021
        $('#tabel_news').on('click', '.detail', function () {

            var id_news = $(this).data('id');

            $.ajax({
                url     : "<?= base_url('News/detail_news/') ?>"+id_news,
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
                dataType    : "HTML",
                success     : function (data) {

                    swal.close();

                    $('.isi_modal').html(data)
                    $('#modal_detail').modal('show');
                    
                },
                error       : function (xhr, status, error) {
                    swal({
                        title               : "Error",
                        text                : 'Gagal menampilkan detail',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-primary",
                        type                : 'error',
                        showConfirmButton   : true,
                        allowOutsideClick   : false
                    });

                    return false;
                }
            })

            return false;
            
        })

        // 02-09-2021
        $('#tambah_news').on('click', function () {

            $('#modal_news').modal('show');

            reset_form();
            
        })
        
        // 02-09-2021
        $('#form_news').parsley();

        // $('form').each(function () {
        //     if ($(this).data('validator'))
        //         $(this).data('validator').settings.ignore = ".note-editor *";
        // });

        $('#batal_news').on('click', function () {
            reset_form();
        })

        function reset_form() {
            $('#aksi').val('Tambah');

            $("#news").summernote("code", "");

            $('#image').val('');
            $("#ImgPreview").attr("src", "");
            $('.btn-rmv1').removeClass('rmv');
            $('.card-img').slideUp();
            $('.card-img-sblm').fadeOut();
            $('.judul_img').html('Image <span class="text-danger">*</span>');
            $('#image').attr('required', true);
            $('.txt_image').fadeOut();

            $('#form_news').trigger("reset");
            $('#form_news').parsley().reset();
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

        $('#form_news').on('submit', function () {

            tinymce.triggerSave();

            var form_news = new FormData(this);

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
                            url     : "<?= base_url() ?>News/simpan_news",
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
                            data            : form_news,
                            contentType     : false,
                            cache           : false,
                            processData     : false,
                            dataType        : "JSON",
                            success : function (data) {

                                if (data.status == 'success') {

                                    reset_form();

                                    tabel_list_news.ajax.reload(null,false);   

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

                                    $('#modal_news').modal('hide');
                                    
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

        $('#tabel_news').on('click', '.edit', function () {

            tinymce.triggerSave();

            var id_news = $(this).data('id');

            var title   = $(this).attr('judul');
            var news    = $(this).attr('news');
            var image   = $(this).attr('images');
            var sumber  = $(this).attr('sumber');
            var editor  = $(this).attr('editor');
            var aktif   = $(this).attr('active');

            $('#aksi').val('Ubah');
            $('.judul').text('Ubah Data');
            $('#id_news').val(id_news);
            $('#title').val(title);       
            $('#sumber').val(sumber);       
            $('#editor').val(editor);       
            $('#val_aktif').val(aktif);    
            $('#nama_image').val(image);

            var nw = news.replace("999", "'");

            $("#news").summernote("code", nw);

            // tinymce.get('news').setContent(news);

            if (aktif == '1') {
                $('.st_aktif').attr('aria-pressed', 'false');
                $('.st_aktif').attr('value', '1');
                $('.st_aktif').removeClass('active');
            } else {
                $('.st_aktif').attr('aria-pressed', 'true');
                $('.st_aktif').attr('value', '0');
                $('.st_aktif').addClass('active');
            }

            $('.card-img-sblm').fadeIn();
            $('#img_sblm').attr('src', "<?= $url_img.'news/' ?>"+image);
            $('.judul_img').html('Image Baru <span class="text-danger">*</span>');

            $('#image').removeAttr('required');
            $('.txt_image').fadeIn();

            $('#modal_news').modal('show');            
        })

        $('#tabel_news').on('click', '.hapus', function () {

            var id_news   = $(this).data('id');
            var image     = $(this).attr('image');

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
                            url         : "<?= base_url() ?>News/simpan_news",
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
                            data        : {aksi:'Hapus', id_news:id_news, nama_image:image},
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
                
                                tabel_list_news.ajax.reload(null,false);
                                
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