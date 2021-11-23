<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

  function forinput($list) {
    $CI =& get_instance();
    $hasil = '';
    $panjg = json_decode($list['input_length']);
    $mixl = 'maxlength="'.$panjg[0]['max'].'" minlength="'.$panjg[0]['min'].'"';
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
          $twx = $data[0];
          for ($i=0; $i < count($twx); $i++) {
            $sww .= '<option value="'.$twx[$i]['valuen'].'">'.$twx[$i]['nameny'].'</option>';
          }
        }
        $hasil = '<select class="form-control" name="'.$list['key_to_param'].'" id="'.$list['key_to_param'].'">'.$sww.'</select>';
      break;
      case 'A':
        $hasil = '<textarea class="form-control" '.$mixl.' name="'.$list['key_to_param'].'" id="'.$list['key_to_param'].'" placeholder="'.$list['fieldnm'].'" rows="8" cols="80"></textarea>';
      break;
      case 'N':
        $hasil = '<input class="form-control" '.$mixl.' type="number" name="'.$list['key_to_param'].'" id="'.$list['key_to_param'].'" placeholder="'.$list['fieldnm'].'">';
      break;
      case 'T':
        $hasil = '<input class="form-control" '.$mixl.' type="text" name="'.$list['key_to_param'].'" id="'.$list['key_to_param'].'" placeholder="'.$list['fieldnm'].'">';
      break;
      case 'C':
        $hasil = '<input class="form-control datepicker" type="text" name="'.$list['key_to_param'].'" id="'.$list['key_to_param'].'" placeholder="'.$list['fieldnm'].'">';
      break;
    }
    $show = '<div class="form-group row">
              <label for="'.$list['key_to_param'].'" class="col-sm-2 col-form-label">'.$list['fieldnm'].'</label>
              <div class="col-sm-10">
              '.$hasil.'
              </div>
             </div>';
    return $show;
  }

  function forinputtwo($list) {
    $CI =& get_instance();
    $data = json_decode($list['input_length']);
    return $data;
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
