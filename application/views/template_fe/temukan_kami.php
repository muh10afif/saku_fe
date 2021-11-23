<div class="row">
    <div class="col-12">
        <!-- Swiper -->
        <div class="swiper-container swiper-categories">
            <div class="swiper-wrapper">

                <?php foreach ($temukan_kami as $t): ?>

                    <a class="swiper-slide" target="_blank" href="<?= $t['isi'] ?>" style="text-decoration:none;">
                        <div class="mb-3 h-100px w-100px rounded overflow-hidden position-relative">
                            <div class="background">
                                <img src="<?= $url_img.'logo/'.$t['image'] ?>" alt="">
                            </div>
                        </div>
                        <h6 class="font-weight-normal mb-1 text-center"><?= $t['nama'] ?></h6>
                    </a>

                <?php endforeach; ?>
                
            </div>
        </div>
    </div>
</div>