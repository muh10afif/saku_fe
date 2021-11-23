<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function decode_role($string=NULL) {
  $role_return['update'] = 'false';
	$role_return['create'] = 'false';
	$role_return['delete'] = 'false';
	$role_return['view'] = 'false';
	$role_return['approve'] = 'false';

	$role_array = str_split($string);
	foreach ($role_array as $key => $value) {
		switch ($value) {
      case "C":
				$role_return['create'] = 'true';
			break;
		  case "R":
				$role_return['read'] = 'true';
			break;
		  case "U":
				$role_return['update'] = 'true';
			break;
			case "D":
				$role_return['delete'] = 'true';
			break;
      case "A":
				$role_return['approve'] = 'true';
			break;
		    default:
				"";
		}
	}
	return $role_return;
}

function get_role($iduser, $action = null) {
	$CI =& get_instance();

  $ling = $CI->uri->segment_array();
  $set = "";
  for ($i=0; $i < count($ling); $i++) {
    $set .= $ling[$i+1].'/';
  }
  $setLink = substr($set,0,strlen($set)-1);
  // var_dump('/'.$setLink); die();
  $CI->db->like('link',$setLink);
  $idmenu = $CI->db->get('ref_menu')->row();

	if (isset($idmenu->id)) {
    $CI->db->select('action');
    $CI->db->where(['id_level_otorisasi' => $iduser, 'id_menu' => $idmenu->id]);
    $query = $CI->db->get('privilage')->row();
    if ($query != NULL) {
			$data = decode_role($query->action);
			if ($action == null) {
				return $data;
			} else {
				permission_role($query->action,$action);
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
    case 'approve':
		  $find   = 'A';
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
