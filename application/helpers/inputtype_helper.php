<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

  // function forinput($list)
  // {
  //   $hasil = '';
  //   switch ($list['input_type']) {
  //     case 'S':
  //       $data = $list['if_input_type_select'];
  //       $sww = '<option value="">-- Pilih --</option>';
  //       for ($i=0; $i < count($data); $i++) {
  //         $sww .= '<option value="'.$data[$i]['valuen'].'">'.$data[$i]['nameny'].'</option>';
  //       }
  //       $hasil = '<select class="form-control" name="'.$list['name_id'].'" id="'.$list['name_id'].'">'.$sww.'</select>';
  //       break;
  //     case 'A':
  //       $hasil = '<textarea class="form-control" name="'.$list['name_id'].'" id="'.$list['name_id'].'" placeholder="'.$list['fieldnm'].'" rows="8" cols="80"></textarea>';
  //       break;
  //     case 'N':
  //       $hasil = '<input class="form-control" type="number" name="'.$list['name_id'].'" id="'.$list['name_id'].'" placeholder="'.$list['fieldnm'].'">';
  //       break;
  //     case 'T':
  //       $hasil = '<input class="form-control" type="text" name="'.$list['name_id'].'" id="'.$list['name_id'].'" placeholder="'.$list['fieldnm'].'">';
  //       break;
  //   }
  //   $show = '<div class="form-group row">
  //             <label for="'.$list['name_id'].'" class="col-sm-3 col-form-label">'.$list['fieldnm'].'</label>
  //             <div class="col-sm-9">
  //             '.$hasil.'
  //             </div>
  //            </div>';
  //   return $show;
  // }

  // function forinput_isi($list)
  // {
  //   $hasil = '';
  //   switch ($list['input_type']) {
  //     case 'S':
  //       $data = $list['if_input_type_select'];
  //       $sww = '<option value="">-- Pilih --</option>';
  //       for ($i=0; $i < count($data); $i++) {
  //         $sww .= '<option value="'.$data[$i]['valuen'].'">'.$data[$i]['nameny'].'</option>';
  //       }
  //       $hasil = '<select class="form-control" name="'.$list['name_id'].'" id="'.$list['name_id'].'">'.$sww.'</select>';
  //       break;
  //     case 'A':
  //       $hasil = '<textarea class="form-control" name="'.$list['name_id'].'" id="'.$list['name_id'].'" placeholder="'.$list['fieldnm'].'" rows="8" cols="80">"'.$list['isi'].'"</textarea>';
  //       break;
  //     case 'N':
  //       $hasil = '<input class="form-control" type="number" name="'.$list['name_id'].'" id="'.$list['name_id'].'" placeholder="'.$list['fieldnm'].'" value="'.$list['isi'].'">';
  //       break;
  //     case 'T':
  //       $hasil = '<input class="form-control" type="text" name="'.$list['name_id'].'" id="'.$list['name_id'].'" placeholder="'.$list['fieldnm'].'" value="'.$list['isi'].'">';
  //       break;
  //   }
  //   $show = '<div class="form-group row">
  //             <label for="'.$list['name_id'].'" class="col-sm-3 col-form-label">'.$list['fieldnm'].'</label>
  //             <div class="col-sm-9">
  //             '.$hasil.'
  //             </div>
  //            </div>';
  //   return $show;
  // }

  function forinput($list) {
    $CI =& get_instance();
    $hasil = '';
    $panjg = $list['input_length'];
    $mixl = 'max="'.$panjg['max'].'" min="'.$panjg['min'].'"';

    // $mixl = 'required data-parsley-length="['.$panjg['min'].','.$panjg['max'].']"';
    
    switch ($list['input_type']) {
      case 'S':
        $data = json_decode($list['if_input_type_select']);
        $sww = '<option value="">-- Pilih --</option>';
        if ($list['option_flag'] == 1) {
          $dta = $CI->db->get($data[0]['tbnme'])->result_array();
          $idn = 'id_'.substr($data[0]['tbnme'],2,strlen($data[0]['tbnme']));
          $nmn = substr($data[0]['tbnme'],2,strlen($data[0]['tbnme']));
          foreach ($dta as $key) {
            $sww .= '<option value="'.$key[$idn].'">'.$key[$nmn].'</option>';
          }
        } else {
          // $twx = $data[0];
          $twx = $list['if_input_type_select'];
          for ($i=0; $i < count($twx); $i++) {
            $sww .= '<option value="'.$twx[$i]['valuen'].'">'.$twx[$i]['nameny'].'</option>';
          }
        }
        $hasil = '<select class="form-control" name="'.$list['name_id'].'" id="'.$list['name_id'].'">'.$sww.'</select>';
      break;
      case 'A':
        $hasil = '<textarea class="form-control tiny" required name="'.$list['name_id'].'" id="'.$list['name_id'].'" placeholder="'.$list['fieldnm'].'" rows="8" cols="80"></textarea>';
      break;

      case 'N':
        $set_sp = $list['sparator_num'] == 'Y' ? 'number_separator numeric':'numeric';
        $hasil = '<input name="'.$list['name_id'].'" id="'.$list['name_id'].'" class="form-control min_max '.$set_sp.'" '.$mixl.' type="text" placeholder="'.$list['fieldnm'].'"> <span class="text-danger" id="span_'.$list['name_id'].'"></span>';
      break;
      
      case 'T':
        $hasil = '<input class="form-control min_max" '.$mixl.' type="text" name="'.$list['name_id'].'" id="'.$list['name_id'].'" placeholder="'.$list['fieldnm'].'"><span class="text-danger" id="span_'.$list['name_id'].'"></span>';
      break;
      case 'C':
        $hasil = '<input class="form-control datepicker" type="text" name="'.$list['name_id'].'" id="'.$list['name_id'].'" placeholder="'.$list['fieldnm'].'">';
      break;
    }
    $show = '<div class="form-group row">
              <label for="'.$list['name_id'].'" class="col-sm-4 col-form-label">'.$list['fieldnm'].'</label>
              <div class="col-sm-8">
              '.$hasil.'
              <br>
              <span class="span"></span>
              </div>
             </div>';
    return $show;
  }

  function forinput_isi($list) {
    $CI =& get_instance();
    $hasil = '';
    $panjg = $list['input_length'];
    $mixl = 'max="'.$panjg['max'].'" min="'.$panjg['min'].'"';

    switch ($list['input_type']) {
      case 'S':
        $data = json_decode($list['if_input_type_select']);
        $sww = '<option value="">-- Pilih --</option>';
        if ($list['option_flag'] == 1) {
          $dta = $CI->db->get($data[0]['tbnme'])->result_array();
          $idn = 'id_'.substr($data[0]['tbnme'],2,strlen($data[0]['tbnme']));
          $nmn = substr($data[0]['tbnme'],2,strlen($data[0]['tbnme']));
          
          foreach ($dta as $key) {

            if ($list['isi'] == $key[$idn]) {
              $sel = 'selected';
            } else {
              $sel = '';
            }

            $sww .= '<option value="'.$key[$idn].'" '.$sel.'>'.$key[$nmn].'</option>';
          }
        } else {
          // $twx = $data[0];
          $twx = $list['if_input_type_select'];
          for ($i=0; $i < count($twx); $i++) {
            if ($list['isi'] == $twx[$i]['valuen']) {
              $sel = 'selected';
            } else {
              $sel = '';
            }

            $sww .= '<option value="'.$twx[$i]['valuen'].'" '.$sel.'>'.$twx[$i]['nameny'].'</option>';
          }
        }
        $hasil = '<select class="form-control" name="'.$list['name_id'].'" id="'.$list['name_id'].'">'.$sww.'</select>';
      break;
      case 'A':
        $hasil = '<textarea class="form-control tiny" name="'.$list['name_id'].'" id="'.$list['name_id'].'" placeholder="'.$list['fieldnm'].'">'.$list['isi'].'</textarea>';
      break;

      case 'N':
        $set_sp = $list['sparator_num'] == 'Y' ? 'number_separator numeric' : 'numeric';
        $hasil = '<input class="form-control min_max '.$set_sp.'" '.$mixl.' type="text" name="'.$list['name_id'].'" id="'.$list['name_id'].'" placeholder="'.$list['fieldnm'].'" value="'.$list['isi'].'"><span class="text-danger" id="span_'.$list['name_id'].'"></span>';
      break;
      
      case 'T':
        $hasil = '<input class="form-control min_max" '.$mixl.' type="text" name="'.$list['name_id'].'" id="'.$list['name_id'].'" placeholder="'.$list['fieldnm'].'" value="'.$list['isi'].'"><span class="text-danger" id="span_'.$list['name_id'].'"></span>';
      break;
      case 'C':
        $hasil = '<input class="form-control datepicker" type="text" name="'.$list['name_id'].'" id="'.$list['name_id'].'" placeholder="'.$list['fieldnm'].'" value="'.date("d-m-Y", strtotime($list['isi'])).'">';
      break;
    }
    $show = '<div class="form-group row">
              <label for="'.$list['name_id'].'" class="col-sm-2 col-form-label">'.$list['fieldnm'].'</label>
              <div class="col-sm-10">
              '.$hasil.'
              </div>
             </div>';
    return $show;
  }

  function forinputtwo($list) {
    $CI =& get_instance();
    $hasil = '';
    $panjg = json_encode($list['input_length']);
    $mixl = 'maxlength="'.$panjg->max.'" minlength="'.$panjg->min.'"';
    switch ($list['input_type']) {
      case 'S':
        $data = $list['if_input_type_select'];
        $sww = '<option value="">-- Pilih --</option>';
        if ($list['option_flag'] == 1) {
          $dta = $CI->db->get($data['tbnme'])->result_array();
          $idn = 'id_'.substr($data['tbnme'],2,strlen($data['tbnme']));
          $nmn = substr($data['tbnme'],2,strlen($data['tbnme']));
          // var_dump($nmn); die();
          foreach ($dta as $key) {
            if (isset($key[$nmn])) {
              $sww .= '<option value="'.$key[$idn].'">'.$key[$nmn].'</option>';
            } else {
              $sww .= '<option value="'.$key[$idn].'">'.$key['nama_'.$nmn].'</option>';
            }
          }
        } else {
          for ($i=0; $i < count($data); $i++) {
            $sww .= '<option value="'.$data[$i]['valuen'].'">'.$data[$i]['nameny'].'</option>';
          }
        }
        $hasil = '<select class="form-control select2" name="'.$list['name_id'].'" id="'.$list['name_id'].'">'.$sww.'</select>';
      break;
      case 'A':
        $hasil = '<textarea class="form-control" '.$mixl.' name="'.$list['name_id'].'" id="'.$list['name_id'].'" placeholder="'.$list['fieldnm'].'" rows="8" cols="80"></textarea>';
      break;
      case 'N':
        $hasil = '<input class="form-control" '.$mixl.' type="number" name="'.$list['name_id'].'" id="'.$list['name_id'].'" placeholder="'.$list['fieldnm'].'" value="">';
      break;
      case 'T':
        $hasil = '<input class="form-control" '.$mixl.' type="text" name="'.$list['name_id'].'" id="'.$list['name_id'].'" placeholder="'.$list['fieldnm'].'" value="">';
      break;
      case 'C':
        $hasil = '<input class="form-control datepicker" type="text" name="'.$list['name_id'].'" id="'.$list['name_id'].'" placeholder="'.$list['fieldnm'].'" value="">';
      break;
    }
    $show = '<div class="form-group row">
              <label for="'.$list['name_id'].'" class="col-sm-2 col-form-label">'.$list['fieldnm'].'</label>
              <div class="col-sm-10">
              '.$hasil.'
              </div>
             </div>';
    return $show;
  }

  function getdbtable($cek)
  {
    $isinya = '';
    switch ($cek) {
      case 1:
        $isinya = 'm_asuransi';
        break;
      case 2:
        $isinya = 'm_nasabah';
        break;
      case 3:
        $isinya = 'm_agent';
        break;
      case 4:
        $isinya = 'm_direct';
        break;
      case 5:
        $isinya = 'm_business_partner';
        break;
      case 6:
        $isinya = 'm_loss_adjuster';
        break;
    }
    return $isinya;
  }


?>
