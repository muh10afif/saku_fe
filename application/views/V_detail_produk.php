<style>
    .hn-114 {
        height: 114px;
        height: calc(env(safe-area-inset-top) + 60px);
    }
</style>
<div class="wrapper">
    <!-- header -->
    <div class="header">
        <div class="row no-gutters">
            <div class="col-auto">
                <button class="btn btn-link menu-btn"><i class="material-icons menu">menu</i><i class="material-icons closeicon">close</i><span class="new-notification"></span></button>
            </div>
            <div class="col text-left">
                <div class="header-logo">
                    <a href="<?= base_url() ?>">
                        <img src="<?= base_url('assets/template_fe/') ?>images/logo.png" alt="" class="header-logo">
                    </a>
                    <!--<h4>Syariah<br><small class="text-mute"> Asuransiku</small></h4>-->
                </div>
            </div>
            <div class="col-auto">
                <!--<a href="notification.html" class="btn btn-link"><i class="material-icons">notifications_none</i><span class="counts">9+</span></a>-->
            </div>
        </div>
    </div>
    <!-- header ends -->

    <div class="container-fluid bg-template mb-4">
        <div class="row hn-114 position-relative">
            <div class="container align-self-end">
                <!-- <input type="text" class="form-control form-control-lg search bottom-25 position-relative border-0" placeholder="Search"> -->
            </div>
        </div>
    </div>
    
    <div class="container pt-2">
        <div class="row">
            <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('produk') ?>">Produk</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col text-uppercase">
                <p class="text-mute mb-0">Produk</p>
                <h4 class="mb-0"><?= $lob['lob'] ?></h4>
            </div>
            <div class="col-auto align-self-end">
                <!--<a href="#">View all</a>-->
            </div>
        </div>
        <div class="row">

            <div class="col-md-12">

                <div class="card shadow">
                    <div class="card-body">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                        <?php $i=0; foreach ($pro_as as $p): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= ($i == 0) ? 'active' : '' ?>" id="pills-tab<?= $p['id_asuransi'] ?>" data-toggle="pill" href="#pills<?= $p['id_asuransi'] ?>" role="tab" aria-controls="pills<?= $p['id_asuransi'] ?>" aria-selected="true"><?= $p['nama_asuransi'] ?></a>
                            </li>
                        <?php $i++; endforeach; ?>
                            
                        </ul>
                        <div class="tab-content" id="pills-tabContent">

                        <?php $j=0; foreach ($pro_as as $s):
                            
                            $list = $this->M_cms->cari_isi_pro_as($p['id_asuransi'], $id_lob)->result_array();    
                        ?>

                            <div class="tab-pane p-3 fade show <?= ($j == 0) ? 'active' : '' ?>" id="pills<?= $p['id_asuransi'] ?>" role="tabpanel" aria-labelledby="pills-tab<?= $p['id_asuransi'] ?>">

                                <?php foreach ($list as $l): 
                                    
                                    $manfaat = $this->M_cms->cari_data('m_manfaat', ['id_produk_asuransi' => $l['id_tr_produk_asuransi']])->result_array(); 
                                ?>

                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <figure class="m-0 h-150 w-100 rounded overflow-hidden">
                                                    <div class="background">
                                                        <img src="<?= $url_img.'produk/'.$l['logo_premi'] ?>" class="rounded">
                                                    </div>
                                                </figure>
                                            </div>
                                            <div class="col">
                                                <h5 class="h4 mb-3 font-weight-normal">Premi Rp. <?= number_format($l['premi'],0,'.','.') ?></h5>
                                                <p class="small text-mute mb-0">Manfaat</p>
                                                
                                                <ul class="list-group list-group-flush">
                                                    <?php foreach ($manfaat as $m): ?>

                                                    <li class="list-group-item">- <?= $m['manfaat'] ?></li>
                                                    
                                                    <?php endforeach; ?>
                                                </ul> <br>
                                                <span class="text-success detail" id_tr_pro="<?= $l['id_tr_produk_asuransi'] ?>"; asuransi="<?= $s['nama_asuransi'] ?>" premi="<?= number_format($l['premi'],0,'.','.') ?>"; style="cursor: pointer;">Selengkapnya <i class="material-icons vm md-16">arrow_forward</i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php endforeach; ?>

                            </div>

                        <?php $j++; endforeach; ?>
                            
                        </div> 
                    </div>
                </div>

            </div>
            
        </div>
    </div>
    

    <br>

    <div class="container my-5">
        <div class="row mb-4">
            <div class="col text-left">
                <p class="text-mute mb-0">Temukan Kami di</p>
                <h4 class="mb-0"></h4>
            </div>
            <div class="col-auto align-self-end">
                <a href="#"></a>
            </div>
        </div>

        <?php $this->load->view('template_fe/temukan_kami'); ?>
    </div>
    <!-- page content ends -->


    <!-- footer -->
    <?php $this->load->view('template_fe/footer') ?>
    <!-- footer ends -->
</div>

<!-- Modal -->
<div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="judul_modal"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body isi_modal">
            
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function () {

        $('.detail').on('click', function () {

            var asuransi    = $(this).attr('asuransi');
            var premi       = $(this).attr('premi');
            var id_tr_pro   = $(this).attr('id_tr_pro');
 
            $.ajax({

                url     : "<?= base_url('Cms/detail_premi') ?>",
                method  : "POST",
                data    : {id_tr_pro:id_tr_pro},
                dataType: "HTML",
                success : function (data) {

                    $('.isi_modal').html(data);
                    $('#judul_modal').text(asuransi+' | Premi Rp. '+premi);
                    $('#modal_detail').modal('show');
                    
                }
                
            })

            return false;
            
        })
        
    })
</script>