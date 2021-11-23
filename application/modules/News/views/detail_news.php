<div class="row">
    <div class="col-md-12">
       <h5><?= $list['title'] ?></h5> 
       <div class="text-center">
        <img src="<?= $url_img.'news/'.$list['images'] ?>" class="img-fluid rounded" alt="Responsive image">
       </div>
       <br>
       Sumber: <strong><?= $list['sumber'] ?></strong> | Editor: <strong><?= $list['editor'] ?></strong>
       <br><br>
       <?= $list['news'] ?>
    </div>
</div>