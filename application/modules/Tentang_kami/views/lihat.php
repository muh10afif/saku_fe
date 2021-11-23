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
                    <button class="btn btn-primary float-right" id="tambah_tentang_kami"><i class="fas fa-plus mr-2"></i>Tambah Data</button>
                </div>
            <?php endif; ?>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="tabel_tentang_kami" width="100%" cellspacing="0">
                    <thead class="thead-light text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Judul</th>
                            <th width="20%">Isi</th>
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
<div class="modal fade" id="modal_tentang_kami" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title mt-0" id="judul_modal">Tambah Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
        <form id="form_tentang_kami" autocomplete="off">
            <input type="hidden" name="id_tentang_kami" id="id_tentang_kami">
            <input type="hidden" name="aksi" id="aksi" value="Tambah">
            <input type="hidden" name="nama_image" id="nama_image">
            <div class="modal-body row">
                <div class="col-md-12">

                    <div class="form-group">
                        <label for="judul" class="col-form-label text-left">Judul<span class="text-danger">*</span></label>
                        <div class="">
                        <textarea name="judul" id="judul" rows="5" class="summernote" required data-parsley-required-message="Judul harus diisi."></textarea>
                        </div>
                    </div> 

                    <div class="form-group">
                        <label for="isi" class="col-form-label text-left">Isi<span class="text-danger">*</span></label>
                        <div class="">
                            <textarea name="isi" id="isi" rows="5" class="summernote" required data-parsley-required-message="Isi harus diisi."></textarea>
                        </div>
                    </div> 
                    
                </div>

                <div class="col-md-12">
                    <p class="font-italic text-danger">(*) Data harus terisi.</p>  
                </div>

            </div>

            <div class="modal-footer">
                <?php if ($role['create'] == 'true' || $id_lvl_otorisasi == 0) : ?>
                    <button type="submit" class="btn btn-primary mt-1 mr-3"><i class="fas fa-check mr-1"></i> Simpan</button>
                <?php endif; ?>

                <button type="button" class="btn btn-danger mt-1" id="batal_tentang_kami" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Batal</button>
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

        // menampilkan list tentang_kami
        var tabel_list_tentang_kami = $('#tabel_tentang_kami').DataTable({
            "processing"        : true,
            "serverSide"        : true,
            "order"             : [],
            "ajax"              : {
                "url"   : "<?= base_url() ?>Tentang_kami/tampil_data_tentang_kami",
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
                "targets"   : [0,3],
                "orderable" : false
            }, {
                'targets'   : [0,3],
                'className' : 'text-center',
            },
            { 
                "width": "10%", "targets": 3
            },
            { 
                "width": "50%", "targets": 2
            }],
            "autoWidth"     : false
        })

        // 03-09-2021
        $('#tabel_tentang_kami').on('click', '.detail', function () {

            var id_tentang_kami = $(this).data('id');

            $.ajax({
                url     : "<?= base_url('Tentang_kami/detail_tentang_kami/') ?>"+id_tentang_kami,
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
        $('#tambah_tentang_kami').on('click', function () {

            $('#modal_tentang_kami').modal('show');

            reset_form();
            
        })
        
        // 02-09-2021
        $('#form_tentang_kami').parsley();

        // $('form').each(function () {
        //     if ($(this).data('validator'))
        //         $(this).data('validator').settings.ignore = ".note-editor *";
        // });

        $('#batal_tentang_kami').on('click', function () {
            reset_form();
        })

        function reset_form() {
            $('#aksi').val('Tambah');

            $("#judul").summernote("code", "");
            $("#isi").summernote("code", "");

            $('#form_tentang_kami').trigger("reset");
            $('#form_tentang_kami').parsley().reset();
            $('.judul').text('Tambah Data');
            
        }

        $('#form_tentang_kami').on('submit', function () {

            var form_tentang_kami = new FormData(this);

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
                            url     : "<?= base_url() ?>Tentang_kami/simpan_tentang_kami",
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
                            data            : form_tentang_kami,
                            contentType     : false,
                            cache           : false,
                            processData     : false,
                            dataType        : "JSON",
                            success : function (data) {

                                reset_form();

                                tabel_list_tentang_kami.ajax.reload(null,false);   

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

                                $('#modal_tentang_kami').modal('hide');
                
                                
                            }
                        })
                
                        return false;

                    } else if (result.dismiss === swal.DismissReason.cancel) {
                        swal.close();
                    }
                })

                return false;
            
        })

        $('#tabel_tentang_kami').on('click', '.edit', function () {

            var id_tentang_kami = $(this).data('id');

            $.ajax({
                url     : "<?= base_url('Tentang_kami/get_edit/') ?>"+id_tentang_kami,
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
                dataType    : "JSON",
                success     : function (data) {

                    swal.close();

                    $('#aksi').val('Ubah');
                    $('.judul').text('Ubah Data');
                    $('#id_tentang_kami').val(id_tentang_kami); 

                    $("#judul").summernote("code", data.judul);
                    $("#isi").summernote("code", data.isi);

                    $('#modal_tentang_kami').modal('show');       
                    
                },
                error       : function (xhr, status, error) {
                    swal({
                        title               : "Error",
                        text                : 'Gagal menampilkan data',
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

        $('#tabel_tentang_kami').on('click', '.hapus', function () {

            var id_tentang_kami   = $(this).data('id');

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
                            url         : "<?= base_url() ?>Tentang_kami/simpan_tentang_kami",
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
                            data        : {aksi:'Hapus', id_tentang_kami:id_tentang_kami},
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
                
                                tabel_list_tentang_kami.ajax.reload(null,false);
                                
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