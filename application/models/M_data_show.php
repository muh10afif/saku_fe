<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class M_data_show extends CI_Model
{

  function __construct() {
    parent::__construct();
  }

  public function introduction()
  {
    return $this->db->get('m_introduction')->result();
  }

  public function visi()
  {
    return $this->db->get('m_visi')->result();
  }

  public function misi()
  {
    return $this->db->get('m_misi')->result();
  }

  public function value()
  {
    return $this->db->get('m_value')->result();
  }

  public function management()
  {
    $fs_dt = $this->db->get('m_title_management')->result();
    $has = array();
    foreach ($fs_dt as $key) {
      $list = array();
      $list['title'] = $key->title_management;
      $subb = $this->management_subtitle($key->id_title_management);
      $sublis = array();
      foreach ($subb as $kex) {
        $hii = array();
        $nme = $this->management_name($kex->id_subtitle_management);
        $hii['subtitle'] = $kex->subtitle_management;
        $hii['namenya'] = $nme[0]->name_management;
        $sublis[] = $hii;
      }
      $list['sub'] = $sublis;
      $has[] = $list;
    }
    return $has;
  }

  public function management_subtitle($id)
  {
    $this->db->where('id_title_management', $id);
    return $this->db->get('m_subtitle_management')->result();
  }

  public function management_name($id)
  {
    $this->db->where('id_subtitle_management', $id);
    return $this->db->get('m_name_management')->result();
  }
}

?>
