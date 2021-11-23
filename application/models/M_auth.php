<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model {

  // broker
  public function cek_user($pass) {
    $this->db->select('m_user.id_user,m_user.password,m_user.username,m_karyawan.*,m_jabatan.*,m_bagian.id_bagian,level_otorisasi.id_level_otorisasi');
    $this->db->join('m_karyawan','m_user.id_karyawan = m_karyawan.id_karyawan');
    $this->db->join('m_jabatan','m_karyawan.id_jabatan = m_jabatan.id_jabatan');
    $this->db->join('m_bagian','m_jabatan.id_bagian = m_bagian.id_bagian');
    $this->db->join('role','m_jabatan.id_jabatan = role.id_jabatan');
    $this->db->join('level_otorisasi', 'role.id_level_otorisasi = level_otorisasi.id_level_otorisasi');
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

  public function ceklevel($id)
  {
    $this->db->where('id_level_user', $id);
    return $this->db->get('level_user')->result();
  }

  // berarti asuransi
  public function whennotkarywn($value) {
    $this->db->select('m_user.id_user,m_user.username,m_user.password,m_user.id_level_otorisasi');
    $this->db->join('level_otorisasi','m_user.id_level_otorisasi = level_otorisasi.id_level_otorisasi');
    $this->db->where($value);
    return $this->db->get('m_user');
  }

  // untuk tertanggung
  public function cektrt($lisn)
  {
    $inid = 'id_'.substr($lisn['flg'],2,strlen($lisn['flg']));
    $this->db->where('table_name', $lisn['flg']);
    $data = $this->db->get('information_schema.columns')->result();
    $fnme = array();
    foreach ($data as $key => $value) {
      if ($value->column_name == 'nama_'.$lisn['flg'] || $value->column_name == 'nama') {
        $dat['nmny'] = $value->column_name;
        $fnme[] = $dat;
      }
    }

    $this->db->select($lisn['flg'].'.'.$fnme[0]['nmny'].' as nama,m_user.id_user,m_user.username,m_user.password,m_user.id_level_otorisasi');
    $this->db->join($lisn['flg'],$lisn['flg'].'.'.$inid.' = m_user.id_karyawan');
    $this->db->join('level_otorisasi','m_user.id_level_otorisasi = level_otorisasi.id_level_otorisasi');
    $this->db->join('role','role.id_level_otorisasi = level_otorisasi.id_level_otorisasi');
    $this->db->where('m_user.username',$lisn['usern']);
    return $this->db->get('m_user');
  }
}
?>
