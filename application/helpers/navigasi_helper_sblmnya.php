<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

  function menu_nav() {
    $CI =& get_instance();
		$menunav = '';

    $user_id = $CI->session->userdata('id_level_otorisasi');
	if ($CI->uri->segment(1) == 'ajk') {
		$wh = "ajk";
	} else {
		$wh = "home";
	}
    $CI->db->select('ref_menu.*');
    if ($user_id == 0) {
      $CI->db->where('ref_menu.parrent',0);
      $CI->db->where('ref_menu.sistem', $wh);
    } else {
      $CI->db->join('privilage', 'privilage.id_menu = ref_menu.id', 'LEFT');
      $CI->db->where(['privilage.id_level_otorisasi' => $user_id, 'ref_menu.parrent' => 0]);
    }
    $CI->db->order_by('urutan', 'ASC');
		$query = $CI->db->get('ref_menu');
    $i=0;
		foreach($query->result_array() as $row) {

			if ($row['link'] == '') {
				$lnk = "javascript:void(0)";
			} else {
				$lnk = site_url($row['link']);
			}

			if(toogle($row['id'],$user_id) > 0){
				$menunav .= "<li class='has-submenu dd'>";
				$menunav .= '<a href="'.$lnk.'"><i class="'.$row['icon'].'"></i>'.$row['nama_menu'].'<i class="mdi mdi-chevron-down mdi-drop"></i></a>';
				$menunav .=	formatTree($row['id'],$user_id);
				$menunav .= "</li>";
			} else {
				$menunav .= "<li class='has-submenu da'>";
				$menunav .= '<a href="'.$lnk.'"><span class="ml-3"> <i class="'.$row['icon'].' mr-2"></i>'.$row['nama_menu'].'</span></a>';
				$menunav .= "</li>";
			}
			$i++;
		}
    echo $menunav;
  }

  function formatTree($id_parent,$user_id) {
		$CI =& get_instance();
	if ($CI->uri->segment(1) == 'ajk') {
		$wh = "ajk";
	} else {
		$wh = "home";
	}
	$CI->db->select('ref_menu.*');
	if ($user_id == 0) {
		$CI->db->where('ref_menu.parrent', $id_parent);
		$CI->db->where('ref_menu.sistem', $wh);
    } else {
      $CI->db->join('privilage', 'privilage.id_menu = ref_menu.id', 'LEFT');
      $CI->db->where(['privilage.id_level_otorisasi' => $user_id, 'ref_menu.parrent' => $id_parent]);
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
			if(toogle($item['id'],$user_id) > 0){
				$menunav .= "<li class='has-submenu'>";
				$menunav .= '<a href="'.site_url($item['link']).'">'.$item['nama_menu'].'</a>';
				$menunav .= formatTree($item['id'],$user_id);
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

  function toogle($id_parent,$user_id){
		$CI =& get_instance();
	if ($CI->uri->segment(1) == 'ajk') {
		$wh = "ajk";
	} else {
		$wh = "home";
	}
	$CI->db->select('ref_menu.*');
	if ($user_id == 0) {
		$CI->db->where('ref_menu.parrent',$id_parent);
		$CI->db->where('ref_menu.sistem', $wh);
    } else {
      $CI->db->join('privilage', 'privilage.id_menu = ref_menu.id', 'LEFT');
      $CI->db->where(['privilage.id_level_otorisasi' => $user_id, 'ref_menu.parrent' => $id_parent]);
    }
    $CI->db->order_by('urutan', 'ASC');
		$query = $CI->db->get('ref_menu');
		return $query->num_rows();
  }

	// function toogle2($id_parent){
	// 	$CI =& get_instance();
	// 	$sql = "SELECT * FROM ref_menu WHERE parrent = '".$id_parent."' ORDER BY urutan asc";
	// 	$query = $CI->db->query($sql);
	// 	return $query->num_rows();
  // }

?>
