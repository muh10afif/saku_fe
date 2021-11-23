<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

  function cetak($str) {
    echo htmlentities($str, ENT_QUOTES, 'UTF-8');
  }

  function cek_duplicate($tabel, $field_cari, $id_field = '', $id = '', $inputan)
  {
    $CI =& get_instance();

    if ($id != '') {
      if (is_array($id_field)) {
        $CI->db->where($id_field);
      } else {
        $CI->db->where("$id_field !=", $id);
      }
      $list = $CI->db->get("$tabel")->result_array();
    } else{
      if (is_array($id_field)) {
        $CI->db->where($id_field);
      }
      $list = $CI->db->get($tabel)->result_array();
    }

    $return = 0;
    foreach ($list as $s) {
      if (trim(strtolower($s[$field_cari])," ") == trim(strtolower($inputan)," ")) {
        $return = 1;
      }
    }

    return $return;

  }

  function cek_duplicate_banyak($tabel, $id_field = '', $id = '', $inputan)
  {
    $CI =& get_instance();

    $return = 0;
    if ($id != '') {
      $CI->db->where("$id_field !=", $id);
      $CI->db->where($inputan);
    } else{
      $CI->db->where($inputan);
    }

    $list = $CI->db->get("$tabel")->result_array();

    if (empty($list)) {
      $return = 0;
    } else {
      $return = 1;
    }

    return $return;

  }

  function duplicatecek($db, $data) {
    $CI =& get_instance();

    $CI->db->select('column_name');
    $CI->db->where('table_name',$db);
    $colm = $CI->db->get('information_schema.columns')->result();
    $xy = array();
    foreach ($colm as $key) {
      if (substr($db,0,2) == "m_") {
        if ($key->column_name != 'id_'.substr($db,2,strlen($db)) &&
            $key->column_name != 'add_time' &&
            $key->column_name != 'add_by') {
          if ($key->column_name != 'kode_'.substr($db,2,strlen($db))) {
            if (is_numeric($data[$key->column_name]) ||
                $data[$key->column_name] == '' ||
                $key->column_name == 'jenis_kelamin' ||
                $key->column_name == 'status' ||
                $key->column_name == 'tgl_lahir' ||
                $key->column_name == 'parent') {
              $xy[$key->column_name] = $data[$key->column_name];
            } else {
              $xy['LOWER('.$key->column_name.')'] = strtolower($data[$key->column_name]);
            }
          }
        }
      } else {
        if ($key->column_name != 'id_'.$db &&
            $key->column_name != 'add_time' &&
            $key->column_name != 'add_by') {
          if ($key->column_name != 'kode_'.substr($db,2,strlen($db))) {
            if (is_numeric($data[$key->column_name]) ||
                $data[$key->column_name] == '' ||
                is_bool($data[$key->column_name])) {
              $xy[$key->column_name] = $data[$key->column_name];
            } else {
              $xy['LOWER('.$key->column_name.')'] = strtolower($data[$key->column_name]);
            }
          }
        }
      }
    }
    $CI->db->where($xy);
    $cek = $CI->db->get($db)->num_rows();
    return $cek;
  }

?>
