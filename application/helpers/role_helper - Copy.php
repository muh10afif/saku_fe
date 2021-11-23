<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function decode_role($string=NULL) {
  $role_return['update'] = "FALSE";
	$role_return['insert'] = "FALSE";
	$role_return['delete'] = "FALSE";
	$role_return['view'] = "FALSE";
	$role_return['print'] = "FALSE";

	$role_array = str_split($string);
	foreach ($role_array as $key => $value) {
		switch ($value) {
      case "C":
				$role_return['insert'] = "TRUE";
			break;
		  case "R":
				$role_return['read'] = "TRUE";
			break;
		  case "U":
				$role_return['update'] = "TRUE";
			break;
			case "D":
				$role_return['delete'] = "TRUE";
			break;
		    default:
				"";
		}
	}
	return $role_return;
}

function get_role($iduser, $action = null) {
	$CI =& get_instance();
	$link = $CI->uri->segment(1);
	$link2 = $CI->uri->segment(2);

	$setLink = "";
	if ($link2 == NULL && $link2 == '') {
		$setLink = $link;
	} else {
		$setLink = $link.'/'.$link2;
	}
  
	$idmenu = $CI->db->query("SELECT id from ref_menu where link = '".$setLink."'")->row();
	if (isset($idmenu->id_menu)) {
		$idmenu = $idmenu->id_menu;
		$query = $CI->db->query("SELECT role from ref_group_menu WHERE id_jabatan = '".$iduser."' AND id_menu = '".$idmenu."' ")->row();
		if ($query != NULL) {
			$data = decode_role($query->role);
			if ($action == null) {
				return $data;
			} else {
				permission_role($query->role,$action);
			}
		}
	}
}

function permission_role($role, $action) {
	switch ($action) {
		case 'create':
      $find   = 'C';
		break;
    case 'read':
      $find   = 'R';
		break;
		case 'update':
		  $find   = 'U';
		break;
		case 'delete':
		  $find   = 'D';
		break;
		default:
		  $find	 = 'ZZ';
		break;
  }
  $pos = strpos($role, $find);
  if ($pos === false) {
    echo "Oops, You dont have permissions giving action '".strtoupper($action)."' into this page. please <a href=".base_url().">back now!</a>";
    exit();
  } else {
    return TRUE;
  }
}


?>
