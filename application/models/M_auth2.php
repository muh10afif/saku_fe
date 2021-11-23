<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model {

  public function cek_user($pass) {
    $this->db->select('*');
    $this->db->join('m_karyawan','m_user.id_karyawan = m_karyawan.id_karyawan');
    $this->db->join('m_jabatan','m_karyawan.id_jabatan = m_jabatan.id_jabatan');
    $this->db->join('m_bagian','m_jabatan.id_bagian = m_bagian.id_bagian');
    $this->db->join('role','m_jabatan.id_jabatan = role.id_jabatan', 'left');
    $this->db->join('level_otorisasi', 'role.id_level_otorisasi = level_otorisasi.id_level_otorisasi', 'left');
		$this->db->where($pass);
    return $this->db->get('m_user');
	}

	public function get_user() {
		return $this->db->get('m_user');
	}

  public function cek_kry($iskr) {
    $this->db->where($iskr);
    return $this->db->get('m_user')->result();
  }

  public function whennotkarywn($value) {
    $this->db->select('*');
    $this->db->join('level_otorisasi','m_user.id_level_otorisasi = level_otorisasi.id_level_otorisasi');
    $this->db->join('role','role.id_level_otorisasi = level_otorisasi.id_level_otorisasi');
    $this->db->where($value);
    return $this->db->get('m_user');
  }

}
?>
