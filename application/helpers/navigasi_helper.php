<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

  function menu_nav() {
    $CI =& get_instance();
		$menunav = '';

    $user_id = $CI->session->userdata('id_level_otorisasi');
    $wh = $CI->uri->segment(1) == 'ajk'?'ajk':'home';
    // $wh = ($CI->uri->segment(1) == 'ajk' || $CI->uri->segment(1) == 'saku')? $CI->uri->segment(1) :'home';
    $CI->db->select('ref_menu.*');
    if ($user_id == 0) {
      $CI->db->where(['ref_menu.parrent' => 0, 'ref_menu.class_active' => 1, 'ref_menu.sistem' => $wh]);
    } else {
      $CI->db->join('privilage', 'privilage.id_menu = ref_menu.id', 'LEFT');
      $CI->db->where(['privilage.id_level_otorisasi' => $user_id, 'ref_menu.parrent' => 0, 'ref_menu.class_active' => 1, 'ref_menu.sistem' => $wh]);
    }
    $CI->db->order_by('urutan', 'ASC');
		$query = $CI->db->get('ref_menu');
    $i=0;
		foreach($query->result_array() as $row) {
			if(toogle($row['id'],$user_id,$wh) > 0){
				$menunav .= "<li class='has-submenu dd'>";
				$menunav .= '<a href="'.site_url($row['link']).'"><i class="'.$row['icon'].'"></i>'.$row['nama_menu'].'<i class="mdi mdi-chevron-down mdi-drop"></i></a>';
				$menunav .=	formatTree($row['id'],$user_id,$wh);
				$menunav .= "</li>";
			} else {
				$menunav .= "<li class='has-submenu da'>";
				$menunav .= '<a href="'.site_url($row['link']).'"><span class="ml-3"> <i class="'.$row['icon'].' mr-2"></i>'.$row['nama_menu'].'</span></a>';
				$menunav .= "</li>";
			}
			$i++;
		}
    echo $menunav;
  }

  function formatTree($id_parent,$user_id,$wh) {
		$CI =& get_instance();
    $CI->db->select('ref_menu.*');
    if ($user_id == 0) {
      $CI->db->where(['ref_menu.parrent' => $id_parent, 'ref_menu.class_active' => 1, 'ref_menu.sistem' => $wh]);
    } else {
      $CI->db->join('privilage', 'privilage.id_menu = ref_menu.id', 'LEFT');
      $CI->db->where(['privilage.id_level_otorisasi' => $user_id, 'ref_menu.parrent' => $id_parent, 'ref_menu.class_active' => 1, 'ref_menu.sistem' => $wh]);
    }
    $CI->db->order_by('urutan', 'ASC');
		$query = $CI->db->get('ref_menu');
		if ($id_parent == 60) {
			$a = "asa";
		} else {
			$a = "";
		}
		$menunav = "<ul class='submenu $a'>";
    foreach($query->result_array() as $item) {
			if(toogle($item['id'],$user_id,$wh) > 0){
				$menunav .= "<li class='has-submenu'>";
				$menunav .= '<a href="'.site_url($item['link']).'">'.$item['nama_menu'].'</a>';
				$menunav .= formatTree($item['id'],$user_id,$wh);
				$menunav .= "</li>";
			}else{
				$menunav .= "<li>";
				$menunav .= '<a href="'.site_url($item['link']).'">'.$item['nama_menu'].'</a>';
				$menunav .= "</li>";
			}
    }
    $menunav.= "</ul>";
	  return $menunav;
  }

  function toogle($id_parent,$user_id,$wh){
		$CI =& get_instance();
    $CI->db->select('ref_menu.*');
    if ($user_id == 0) {
      $CI->db->where(['ref_menu.parrent' => $id_parent, 'ref_menu.class_active' => 1, 'ref_menu.sistem' => $wh]);
    } else {
      $CI->db->join('privilage', 'privilage.id_menu = ref_menu.id', 'LEFT');
      $CI->db->where(['privilage.id_level_otorisasi' => $user_id, 'ref_menu.parrent' => $id_parent, 'ref_menu.class_active' => 1, 'ref_menu.sistem' => $wh]);
    }
    $CI->db->order_by('urutan', 'ASC');
		$query = $CI->db->get('ref_menu');
		return $query->num_rows();
  }

	function bredcumx() {
    $CI =& get_instance();
    $che = $CI->uri->segment_array();
    $xyz = end($che);

    $lkn = ($xyz == 'admin') ? $che[(count($che)-1)] : $xyz;
    $lst = (preg_match('/\b'.$lkn.'\b/', 'user')) ? $lkn.'/'.$xyz : $lkn;

    if ($che[1] == 'user') {
      $CI->db->where('link', '/'.$lst);
    } else {
      $CI->db->like('link', $lst);
    }
    $sw = $CI->db->get('ref_menu')->result_array();

    $alll = categoryParentChildTree($sw[0]['id']);
    $bred = '<ol class="breadcrumb float-right">';
    // if ($che[1] == 'ajk') {
    //   $bred .= '<li class="breadcrumb-item"><a href="'.base_url().'ajk">AJK</a></li>';
    // } else {
    // }
    $bred .= '<li class="breadcrumb-item"><a href="'.base_url().'">All COB</a></li>';
    for ($i=count($alll); $i >= 0; $i--) {
      if ($alll[$i]['nama_menu'] != "") {
        $bred .= '<li class="breadcrumb-item">'.$alll[$i]['nama_menu'].'</li>';
      }
    }
    $bred .= '</ol>';
    return $bred;
  }

  function categoryParentChildTree($parent, $category_tree_array = '') {
    $CI =& get_instance();
    if (!is_array($category_tree_array)) {
      $category_tree_array = array();
    }
    $CI->db->where('id',$parent);
    $CI->db->order_by('urutan','ASC');
    $query2 = $CI->db->get('ref_menu');
    if ($query2->num_rows() > 0) {
      foreach ($query2->result() as $row) {
        $category_tree_array[] = array("link_mnu" => $row->link,"parrent" => $row->parrent, "nama_menu" => $row->nama_menu);
        $category_tree_array = categoryParentChildTree($row->parrent, $category_tree_array);
      }
    }
    return $category_tree_array;
  }

  function codegenerate($dbdb, $param, $key, $last)
  {
    $CI =& get_instance();
    $CI->db->order_by('id_'.$key, 'desc');
    $cari = $CI->db->get($dbdb)->row_array();
    if (!empty($cari)) {
      $a = strpos($cari['kode_'.$key],$last);
      $b = strlen($cari['kode_'.$key]);
      $c = substr($cari['kode_'.$key], $a + 2, $b);
      $w = (int) $c + 1;
      $kd = str_pad($w, 6, "0", STR_PAD_LEFT);
    } else {
      $kd = str_pad(1, 6, "0", STR_PAD_LEFT);
    }
    return $param.$kd;
  }

?>
