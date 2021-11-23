<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct() {
    parent::__construct();
		$this->load->helper('inputtype_helper');
    $this->load->model('M_auth', 'auth');
  }

	public function index() {
		if($this->session->userdata('username') != null) {
			redirect('Dashboard');
		} else {
			$data = [
				'title'	=> 'Log In'
			];
			$this->load->view('V_login', $data);
		}
	}

	public function cekprivilagedata($id)
	{
		$this->db->where('id_level_otorisasi', $id);
		return $this->db->get('privilage')->num_rows();
	}

	public function cek() {
		$array = array(); $stat = ''; $pesan = '';
		$username	= $this->input->post('username');
		$password	= $this->input->post('password');

		$iskarywn = $this->auth->cek_kry(['username' => $username]);
		if ($iskarywn[0]->id_karyawan != null) {
			if ($iskarywn[0]->flag_table != null) { // di broker admin123
				$cektr = $this->auth->cektrt(['usern'=>$username,'flg'=>getdbtable($iskarywn[0]->flag_table)]);
				if ($cektr->num_rows() > 0) {
					$datab = $cektr->result();
					if (password_verify($password, $datab[0]->password)) {
						$array = array(
							'sesi_id' => $datab[0]->id_user,
							'username' => $datab[0]->username,
							'nm_karyawan' => $datab[0]->nama,
							'id_jabatan' => 0,
							'id_bagian' => 0,
							'id_level_otorisasi' => $datab[0]->id_level_otorisasi
						);
						$prv = $this->cekprivilagedata($datab[0]->id_level_otorisasi);
						if ($prv > 0) {
							$stat = 1;
							$pesan = 'Berhasil';
						} else {
							$stat = 0;
							$pesan = 'Privilege sistem belum dikelola, hubungi administrator untuk tindak lanjut';
						}
					} else {
						$stat = 0;
						$pesan = 'Password Salah';
					}
				} else {
					$stat = 0;
					$pesan = 'Username Belum Bisa dipakai';
				}
			} else {
				$ceklvus = $this->auth->ceklevel($iskarywn[0]->id_level_user);
				if ($ceklvus[0]->level_user == 'Broker') { // ketika broker
					$hasil = $this->auth->cek_user(['m_user.username' => $username]);
					if ($hasil->num_rows() > 0) {
						$datay = $hasil->result();
						if (password_verify($password, $datay[0]->password)) {
							$array = array(
								'sesi_id' => $datay[0]->id_user,
								'username' => $datay[0]->username,
								'nm_karyawan' => $datay[0]->nama_karyawan,
								'id_jabatan' => $datay[0]->id_jabatan,
								'id_bagian' => $datay[0]->id_bagian,
								'id_level_otorisasi' => $datay[0]->id_level_otorisasi
							);
							$prv = $this->cekprivilagedata($datay[0]->id_level_otorisasi);
							if ($prv > 0) {
								$stat = 1;
								$pesan = 'Berhasil';
							} else {
								$stat = 0;
								$pesan = 'Privilege sistem belum dikelola, hubungi administrator untuk tindak lanjut';
							}
						} else {
							$stat = 0;
							$pesan = 'Password Salah';
						}
					} else {
						$stat = 0;
						$pesan = 'Privilege sistem belum dikelola, hubungi administrator untuk tindak lanjut';
					}
				} else if ($ceklvus[0]->level_user == 'Asuransi') { // pas asuransi
					$notka = $this->auth->whennotkarywn(['m_user.username' => $username]);
					if ($notka->num_rows() > 0) {
						$dataz = $notka->result();
						if (password_verify($password, $dataz[0]->password)) {
							$array = array(
								'sesi_id' => $dataz[0]->id_user,
								'username' => $dataz[0]->username,
								'nm_karyawan' => $dataz[0]->username,
								'id_jabatan' => 0,
								'id_bagian' => 0,
								'id_level_otorisasi' => $dataz[0]->id_level_otorisasi
							);
							$prv = $this->cekprivilagedata($dataz[0]->id_level_otorisasi);
							if ($prv > 0) {
								$stat = 1;
								$pesan = 'Berhasil';
							} else {
								$stat = 0;
								$pesan = 'Privilege sistem belum dikelola, hubungi administrator untuk tindak lanjut';
							}
						} else {
							$stat = 0;
							$pesan = 'Password Salah';
						}
					} else {
						$stat = 0;
						$pesan = 'Level Otirisasi Belum di Setting';
					}
				}
			}
		} else {
			if ($iskarywn[0]->id_level_otorisasi == 0) {
				if (password_verify($password, $iskarywn[0]->password)) {
					$array = array(
						'sesi_id' => $iskarywn[0]->id_user,
						'username' => $iskarywn[0]->username,
						'nm_karyawan' => $iskarywn[0]->username,
						'id_jabatan' => 0,
						'id_bagian' => 0,
						'id_level_otorisasi' => 0
					);
					$stat = 1;
					$pesan = 'Berhasil';
				} else {
					$stat = 0;
					$pesan = 'Password Salah';
				}
			}
		}
		$this->session->set_userdata($array);
		echo json_encode(['status' => $stat, 'pesan' => $pesan]);
	}

	public function out() {
		$this->session->sess_destroy();
		redirect('Auth');
	}
}
?>
