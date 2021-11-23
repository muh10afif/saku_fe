<style>

    .nav-pills .nav-link.active, .nav-pills .show > .nav-link {
        color: #fff;
        background-color: #02a4af;
    }

    a {
        color: #02a4af;
    }

    .custom-control-input:checked ~ .custom-control-label::before {
        color: #fff;
        border-color: #006c45;
        background-color: #006c45;
    }

    .nav-tabs .nav-item .nav-link.active {
        color: white;
    }
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        color: #495057;
        background-color: #006c45;
        border-color: #006c45 #006c45 #006c45;
    }
    .nav-tabs .nav-link:focus, .nav-tabs .nav-link:hover {
        border-color: #006c45 #006c45 #006c45;
    }
    .tab-bordered .tab-pane {
        padding: 15px;
        border: 5px solid #006c45;
        margin-top: -1px;
        border-radius: 5px;
    }
    .nav-tabs .nav-item .nav-link {
        color: #006c45;
    }
    .nav-tabs {
        border-bottom: 3px solid #006c45;
    }
    .tab-pane.active {
        animation: slide-down 0.4s ease-out;
    }
    @keyframes slide-down {
        0% { opacity: 0; transform: translateY(100%); }
        100% { opacity: 1; transform: translateY(0); }
    }

</style>
<div class="page-title-box">
  <div class="row align-items-center">
    <div class="col-sm-6"><h4><?= $title ?></h4></div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-right">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>">All COB</a></li>
        <li class="breadcrumb-item active"><?= $title ?></li>
      </ol>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <ul class="nav nav-tabs shadow" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#copro" role="tab">
          <span class="d-none d-md-block">Company Profile</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#usguide" role="tab">
          <span class="d-none d-md-block">User Guide</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#fak" role="tab">
          <span class="d-none d-md-block">F A Q</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#conper" role="tab">
          <span class="d-none d-md-block">Contact Person</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
        </a>
      </li>
    </ul>

    <div class="card">
      <div class="tab-content">
        <div class="tab-pane active p-3" id="copro" role="tabpanel">
          <div class="card-body">
            <h3 style="margin-top: -15px;">PT. LEGOWO</h3><p>
              <h6 style="margin-top: -15px;" class="mt-1">INSURANCE BROKERS & CONSULTANTS</h6><br>
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#introo" role="tab">
                  <span class="d-none d-md-block">Introduction</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#mvv" role="tab">
                  <span class="d-none d-md-block">Mission, Vision and Values</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#mngmt" role="tab">
                  <span class="d-none d-md-block">Managements</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#prodc" role="tab">
                  <span class="d-none d-md-block">Products</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#insrr" role="tab">
                  <span class="d-none d-md-block">Insurer</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                </a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active p-3" id="introo" role="tabpanel">
                <h6><i>Introduction</i></h6><hr>
                <div class="row">
                  <div class="col-md-6">
                    <p><?php echo $introduc[0]->introduction; ?>
                  </div>
                </div>
              </div>
              <div class="tab-pane p-3" id="mvv" role="tabpanel">
                <ul>
                  <li>
                    <h6>Mission :</h6><p>
                    <?php foreach ($vvm['misi'] as $key) { ?>
                      <?php echo $key->misi; ?>
                    <?php } ?>
                  </li>
                  <li>
                    <h6>Vision :</h6><p>
                    <?php foreach ($vvm['visi'] as $key) { ?>
                      <?php echo $key->visi; ?>
                    <?php } ?>
                  </li>
                  <li>
                    <h6>Values :</h6><p>
                    <?php foreach ($vvm['value'] as $key) { ?>
                      <?php echo $key->value; ?>
                    <?php } ?>
                  </li>
                </ul>
              </div>
              <div class="tab-pane p-3" id="mngmt" role="tabpanel">
                <?php foreach ($mngmt as $key) { ?>
                  <table>
                    <tr><td colspan="3"><b><?php echo $key['title']; ?></b></td></tr>
                    <?php foreach ($key['sub'] as $kex) { ?>
                      <tr><td style="width: 500px"><?php echo $kex['subtitle']; ?></td><td>:</td><td><?php echo $kex['namenya']; ?></td></tr>
                    <?php } ?>
                  </table><hr>
                <?php } ?>
              </div>
              <div class="tab-pane p-3" id="prodc" role="tabpanel">
                <h6><i>Products :</i></h4><p>
                <ul style="margin-top: -10px;">
                  <?php foreach ($prodct as $key) { ?>
                    <li><h6><?php echo $key->cob; ?></h6></li>
                  <?php } ?>
                </ul>
              </div>
              <div class="tab-pane p-3" id="insrr" role="tabpanel">
                <h6><i>Local & Joint Venture / Asuransi Lokal dan Asing :</i></h6><p>
                <ul>
                  <li>PT. Jasa Raharja Putra</li>
                  <li>PT. Asuransi ASPAN</li>
                  <li>PT. Asuransi Askrindo</li>
                  <li>PT. Asuransi Ekspor Indonesia (ASEI)</li>
                  <li>PT. Alianz Utama Indonesia</li>
                  <li>PT. Zurich Insurance Indoensia</li>
                  <li>Reputable Insurance companies both local & venture <p>
                    <i>dan Asuransi yang mempunyai reputasi baik lokal maupun joint Venture</i></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane p-3" id="usguide" role="tabpanel">
          <div class="card-body">
            Content Here
          </div>
        </div>
        <div class="tab-pane p-3" id="fak" role="tabpanel">
          <div class="card-body">
            Content Here
          </div>
        </div>
        <div class="tab-pane p-3" id="conper" role="tabpanel">
          <div class="card-body">
            Content Here
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
