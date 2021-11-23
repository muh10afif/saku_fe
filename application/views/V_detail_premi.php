<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-pills mb-3 d-flex justify-content-center" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-tab-manfaat" data-toggle="pill" href="#pills-manfaat" role="tab" aria-controls="pills-manfaat" aria-selected="true">Manfaat</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-tab-syarat" data-toggle="pill" href="#pills-syarat" role="tab" aria-controls="pills-syarat" aria-selected="false">Syarat & Ketentuan</a>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">

            <div class="tab-pane p-2 fade show active" id="pills-manfaat" role="tabpanel" aria-labelledby="pills-tab-manfaat">

                <ul type="square">
                    <?php foreach ($manfaat as $m): ?>
                        <li class="mt-2"><?= $m['manfaat'] ?> <br>
                            <span class="text-mute">Sebesar Rp. <?= number_format($m['nilai'],0,'.','.') ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="card bg-danger text-white">
                    <div class="card-header">
                        <span style="cursor: pointer;" class="tampilkan float-right" status="hide">Tampilkan Semua</span>
                        <h5 class="card-title mb-0">Pengecualian :</h5>

                    </div>
                    <div class="card-body" id="tampil_kecuali_1">
                        
                        <p class="card-text">
                            <ol type="number">
                                <?php foreach ($kecuali_k as $kk): ?>
                                    <li class="mt-2"><?= $kk['pengecualian'] ?></li>
                                <?php endforeach; ?>
                            </ol>
                            
                        </p>
                        
                    </div>

                    <div class="card-body" id="tampil_kecuali_2" style="display: none;">
                        <p class="card-text" >
                            <ol type="number">
                                <?php foreach ($kecuali as $k): ?>
                                    <li class="mt-2"><?= $k['pengecualian'] ?></li>
                                <?php endforeach; ?>
                            </ol>
                            
                        </p>
                    </div>
                </div>

            </div>
            <div class="tab-pane p-2 fade" id="pills-syarat" role="tabpanel" aria-labelledby="pills-tab-syarat">

                <ol type="number">
                    <?php foreach ($syarat as $s): ?>
                        <li class="mt-2"><?= $s['syarat'] ?></li>
                    <?php endforeach; ?>
                </ol>

            </div>
        
        </div>
        
    </div>
</div>

<script>
    $(document).ready(function () {

        $('.tampilkan').on('click', function () {

            var status = $(this).attr('status');

            if (status == 'hide') {
                $(this).attr('status', 'tampil');
                $('#tampil_kecuali_1').slideUp('fast');
                $('#tampil_kecuali_2').slideDown();
                $('.tampilkan').text('Sembunyikan');
            } else {
                $(this).attr('status', 'hide');
                $('#tampil_kecuali_2').slideUp('fast');
                $('#tampil_kecuali_1').slideDown();
                $('.tampilkan').text('Tampilkan Semua');
            }
            
        })
        
    })
</script>