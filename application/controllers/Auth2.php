<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct() {
    parent::__construct();
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

	public function cek() {
		$array = array(); $stat = ''; $pesan = '';
		$username	= $this->input->post('username');
		$password	= $this->input->post('password');

		$iskarywn = $this->auth->cek_kry(['username' => $username]);
		if ($iskarywn[0]->id_karyawan != null) {
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
						'id_level_otorisasi' => 0
					);
					$stat = 1;
					$pesan = 'Berhasil';
				} else {
					$stat = 0;
					$pesan = 'Password Salah';
				}
			} else {
				$stat = 0;
				$pesan = 'Username Tidak di Temukan';
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
			} else {
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
						$stat = 1;
						$pesan = 'Berhasil';
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
		$this->session->set_userdata($array);
		echo json_encode(['status' => $stat, 'pesan' => $pesan]);
	}

	public function out() {
		$this->session->sess_destroy();
		redirect('Auth');
	}

	public function out_js() {
		$this->session->sess_destroy();
		echo json_encode(['status' => TRUE]);
	}

	// if ($username == 'admin') {
	// 	$array = array(
	// 		'username' => 'masuk',
	// 		'sesi_id' => 1
	// 	);
	// } else {
	// 	$array = array(
	// 		'username' => 'yes',
	// 		'sesi_id' => 2
	// 	);
	// }

}
?>
