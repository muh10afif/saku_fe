<div class="col-md-12 f_tambah" style="display:none;">
  <div class="card shadow">
    <div class="card-header">
      <div class="row align-items-center">
        <div class="col-sm-6">
          <h5 id="changetitlenm"></h5>
        </div>
        <div class="col-sm-6">
          <button class="btn btn-light float-right batal_entry"><i class="mdi mdi-close mdi-18px"></i></button>
        </div>
      </div>
    </div>
    <div class="card-body">
      <form id="colectasu" method="post">
        <input type="hidden" name="idasu" id="idasu" value="">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label for="kode_asuransi" class="col-sm-3 col-form-label">Kode Asuransi</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="kode_asuransi" name="kode_asuransi" value="" readonly>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label for="nama_asuransi" class="col-sm-3 col-form-label">Nama<b style="color:red;">*</b></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="nama_asuransi" id="nama_asuransi" placeholder="Masukkan Nama Asuransi">
              </div>
            </div>
            <div class="form-group row">
              <label for="singkatan" class="col-sm-3 col-form-label">Singkatan</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="singkatan" id="singkatan" placeholder="Masukkan Singkatan">
              </div>
            </div>
            <div class="form-group row">
              <!-- <b style="color:red;">*</b> -->
              <label for="id_tipe_as" class="col-md-3 col-form-label text-left">Tipe Asuransi</label>
              <div class="col-md-9">
                <select name="id_tipe_as" id="id_tipe_as" class="select2" style="height: 80%;">
                  <option value="">Pilih Tipe Asuransi</option>
                  <?php foreach ($tipe_as as $ta): ?>
                      <option value="<?= $ta->id_tipe_as ?>"><?= $ta->tipe_as ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <!-- <b style="color:red;">*</b> -->
              <label for="id_kategori_as" class="col-md-3 col-form-label text-left">Kategori Asuransi</label>
              <div class="col-md-9">
                <select name="id_kategori_as" id="id_kategori_as" class="select2">
                  <option value="">Pilih Kategori Asuransi</option>
                  <?php foreach ($kategori_as as $ka): ?>
                      <option value="<?= $ka->id_kategori_as ?>"><?= $ka->kategori_as ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="form-group card-img-sblm" style="display: none;">
                <label for="asuransi" class="col-form-label text-left">Image Sebelumnya</label>
                <div class="card mb-0">
                    <img class="" id="img_sblm" src="" width="50%">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="asuransi" class="col-md-3 col-form-label text-left judul_img">Logo</label>
                <div class="col-md-9">
                    <input type="file" name="image" id="image" class="form-control" accept="image/png, image/jpeg">
                </div>
            </div>  
            <p class="text-danger txt_image" style="display: none;">Pilih logo bila ingin mengubah dengan yang baru!</p>

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

          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label for="telp" class="col-md-3 col-form-label text-left">Telepon<b style="color:red;">*</b></label>
              <div class="col-md-9">
                <input type="text" id="telp" name="telp" class="form-control numeric" placeholder="Masukkan Telepon">
              </div>
            </div>
            <div class="form-group row">
              <label for="fax" class="col-md-3 col-form-label text-left">Fax</label>
              <div class="col-md-9">
                <input type="text" id="fax" name="fax" class="form-control numeric" placeholder="Masukkan Fax">
              </div>
            </div>
            <div class="form-group row">
              <!-- <b style="color:red;">*</b> -->
              <label for="website" class="col-md-3 col-form-label text-left">Website</label>
              <div class="col-md-9">
                <input type="text" id="website" name="website" class="form-control" placeholder="Masukkan Website">
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-md-3 col-form-label text-left">Email<b style="color:red;">*</b></label>
              <div class="col-md-9">
                <input type="text" id="email" name="email" class="form-control" placeholder="Masukkan Email">
              </div>
            </div>

          </div>
        </div>
        <br>
        <label for=""><u><b>Alamat Asuransi</b></u></label>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label for="idnega" class="col-sm-3 col-form-label">Negara<b style="color:red;">*</b></label>
              <div class="col-sm-9">
                <select class="form-control select2" name="idnega" id="idnega" placeholder="-- Pilih Negara --">
                  <?php foreach ($list_negara as $key => $value): ?>
                    <option value="<?= $value->id_negara ?>" <?php echo $value->id_negara == 2 ?'selected':''; ?>><?= $value->negara ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="idprov" class="col-sm-3 col-form-label">Provinsi<b style="color:red;">*</b></label>
              <div class="col-sm-9">
                <select class="form-control select2" name="idprov" id="idprov" placeholder="-- Pilih Provinsi --">
                  <option value="">-- Pilih Provinsi --</option>
                  <?php foreach ($list_provinsi as $key => $value): ?>
                    <option value="<?php echo $value->id_provinsi ?>"><?php echo $value->provinsi ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="idkab" class="col-sm-3 col-form-label">Kota<b style="color:red;">*</b></label>
              <div class="col-sm-9">
                <select class="form-control select2" name="idkab" id="idkab"></select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label for="idkec" class="col-sm-3 col-form-label">Kecamatan<b style="color:red;">*</b></label>
              <div class="col-sm-9">
                <select class="form-control select2" name="idkec" id="idkec"></select>
              </div>
            </div>
            <div class="form-group row">
              <label for="idkel" class="col-sm-3 col-form-label">Kelurahan<b style="color:red;">*</b></label>
              <div class="col-sm-9">
                <select class="form-control select2" name="idkel" id="idkel"></select>
              </div>
            </div>
            <div class="form-group row">
              <label for="alamat" class="col-md-3 col-form-label text-left">Alamat<b style="color:red;">*</b></label>
              <div class="col-md-9">
                <textarea cols="5" type="text" id="alamat" name="alamat" class="form-control" placeholder="Masukkan Alamat"></textarea>
              </div>
            </div>
          </div>
        </div>
        <br>
        <label for=""><u><b>Data PIC</b></u></label>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label for="pic" class="col-md-3 col-md-3 col-form-label text-left">PIC<b style="color:red;">*</b></label>
              <div class="col-md-9">
                <input type="text" id="pic" name="pic" class="form-control" placeholder="Masukkan PIC">
              </div>
            </div>
            <div class="form-group row">
              <label for="telp_pic" class="col-md-3 col-form-label text-left">Telepon PIC<b style="color:red;">*</b></label>
              <div class="col-md-9">
                <input type="text" id="telp_pic" name="telp_pic" class="form-control numeric" placeholder="Masukkan Telepon PIC">
              </div>
            </div>
            <div class="form-group row">
              <label for="email_pic" class="col-md-3 col-form-label text-left">Email PIC<b style="color:red;">*</b></label>
              <div class="col-md-9">
                <input type="text" id="email_pic" name="email_pic" class="form-control" placeholder="Masukkan Email PIC">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label for="alamat_pic" class="col-md-3 col-form-label text-left">Alamat PIC<b style="color:red;">*</b></label>
              <div class="col-md-9">
                <textarea cols="5" id="alamat_pic" name="alamat_pic" type="text" class="form-control" placeholder="Masukkan Alamat PIC"></textarea>
              </div>
            </div>
          </div>
        </div>
        <br><i style="color:red;">('*') Menandakan Form Harus di Isi</i>
        <div class="form-group text-right">
          <button class="btn btn-primary waves-effect waves-light mr-2" id="senddata">Submit</button>
          <button class="btn btn-secondary waves-effect batal_entry">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
