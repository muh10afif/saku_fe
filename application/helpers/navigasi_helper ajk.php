<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

  function menu_nav() {
    $CI =& get_instance();
		$menunav = '';
		if ($CI->uri->segment(1) == 'ajk') {
			$wh = "ajk";
		} else {
			$wh = "home";
		}
		$sql = "SELECT * FROM ref_menu WHERE parrent = 0 AND class_active = 1 AND sistem = '$wh' ORDER BY id asc";
		$query = $CI->db->query($sql);
		$i=0;
		foreach($query->result_array() as $row) {
			if(toogle($row['id']) > 0){
				$menunav .= "<li class='has-submenu dd'>";
				$menunav .= '<a href="'.site_url($row['link']).'"><span class="ml-1"><i class="'.$row['icon'].' mr-2"></i>'.$row['nama_menu'].'<i class="mdi mdi-chevron-down mdi-drop"></i></span></a>';
				$menunav .=	formatTree($row['id'], $CI->uri->segment(1));
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

  function formatTree($id_parent, $wh) {
		$CI =& get_instance();
		if ($CI->uri->segment(1) == 'ajk') {
			$wh = "ajk";
		} else {
			$wh = "home";
		}
		$sql = "SELECT * FROM ref_menu WHERE parrent = '".$id_parent."' AND class_active = 1 AND sistem = '$wh' ORDER BY urutan asc";
		$query = $CI->db->query($sql);
		if ($id_parent == 60) {
			$a = "asa";
		} else {
			$a = "";
		}
		$menunav = "<ul class='submenu $a'>";
    foreach($query->result_array() as $item) {
			if(toogle($item['id']) > 0){
				$menunav .= "<li class='has-submenu'>";
				$menunav .= '<a href="'.site_url($item['link']).'">'.$item['nama_menu'].'</a>';
				$menunav .= formatTree($item['id'], $CI->uri->segment(1));
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

  function toogle($id_parent){
		$CI =& get_instance();
		$sql = "SELECT * FROM ref_menu WHERE parrent = '".$id_parent."' AND class_active = 1 ORDER BY urutan asc";
		$query = $CI->db->query($sql);
		return $query->num_rows();
  }

	// function toogle2($id_parent){
	// 	$CI =& get_instance();
	// 	$sql = "SELECT * FROM ref_menu WHERE parrent = '".$id_parent."' ORDER BY urutan asc";
	// 	$query = $CI->db->query($sql);
	// 	return $query->num_rows();
  // }

?>
