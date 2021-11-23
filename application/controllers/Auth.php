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

	public function cek2() {
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

	public function cek()
	{
		$array = array(); $stat = ''; $pesan = '';
		$username	= $this->input->post('username');
		$password	= $this->input->post('password');	

		if ($username == 'cms_saku') {

			$data = $this->db->get_where('m_user', ['username' => $username])->row_array();
			
			if (password_verify($password, $data['password'])) {
				$array = array(
					'sesi_id'	=> $data['id_user'],
					'username' 	=> $data['username']
				);
				
				$this->session->set_userdata($array);

				$stat = 1;
				$pesan = 'Berhasil';
					
			} else {
				$stat = 2;
				$pesan = 'Password Salah';
			}
		} else {

			$stat 	= 0;
			$pesan 	= 'User tidak terdaftar!';
			
		}

		echo json_encode(['status' => $stat, 'pesan' => $pesan]);
	}

	public function out() {
		$this->session->sess_destroy();
		redirect('Auth');
	}

	public function generate_pass()
	{
		$plaintext = "Mahameru7";
		$password = 'jkbsdklUIG/98xhk()nklkjghjl_21';

		// CBC has an IV and thus needs randomness every time a message is encrypted
		$method = 'aes-256-cbc';

		// Must be exact 32 chars (256 bit)
		// You must store this secret random key in a safe place of your system.
		$key = substr(hash('sha256', $password, true), 0, 32);
		// echo "Password:" . $password . "\n";

		// Most secure key
		//$key = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));

		// IV must be exact 16 chars (128 bit)
		$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

		// Most secure iv
		// Never ever use iv=0 in real life. Better use this iv:
		// $ivlen = openssl_cipher_iv_length($method);
		// $iv = openssl_random_pseudo_bytes($ivlen);

		// av3DYGLkwBsErphcyYp+imUW4QKs19hUnFyyYcXwURU=
		$encrypted = base64_encode(openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv));

		$a = "DA78FsMHkjnC809AfmxjKw==";

		// My secret message 1234
		$decrypted = openssl_decrypt(base64_decode($a), $method, $key, OPENSSL_RAW_DATA, $iv);

		// echo 'plaintext=' . $plaintext . "\n";
		// echo 'cipher=' . $method . "\n";
		// echo 'encrypted to: ' . $encrypted . "\n";
		//echo 'decrypted to: ' . $decrypted . "\n\n";

		echo json_encode(['hasil' => $encrypted]);
	}

	public function aes()
	{
		$encrypter = new Illuminate\Encryption\Encrypter('yQTAFGpD2MAaOfhg2InXZm601SRYCl13', 'AES-256-CBC');

      $psw      = "tes";
      $enc     = $encrypter->encrypt($psw);
      //$pass     = "eyJpdiI6IkgvYXRnRU95bXhheDRaRzZmUjlWZmc9PSIsInZhbHVlIjoiQ1VDR1lKUzdyREhBSW5mVVl4bG5HZz09IiwibWFjIjoiY2MxZWZlZGEwYWM3NzdjNGFiMTQwZDU2NDgwYmY3NjVkMzM4YzBiZTcwNGYxYWYzOTc1MzZhYmU2MGI5ZGJkYyJ9";
      //$pass     = "eyJpdiI6ImV0ZU9NZFgzbXJTWnFJWG03T1BkMEE9PSIsInZhbHVlIjoidXlTejNuVEhjMXpzOHdNd0Y2TUEvdXkybU5oblMrNXhmSXIvUngzeGI5bz0iLCJtYWMiOiI1MWY5ZGU0Mjg5NDAwZTQ0ZDc5MDE2OGExMDc2NmU2MWU1ZWZkMmI3MmI4Yjk1NDc1NjFlZmU4OGM2ZGEyMGMwIn0=";

      // $des = $encrypter->decryptString($pass);

      echo $encrypter->encrypt($psw);
	}

	public function tes_enc()
	{
		$this->encryption->initialize(
				array(
						'cipher' => 'aes-256',
						'mode' => 'cbc',
						'key' => 'yQTAFGpD2MAaOfhg2InXZm601SRYCl13'
				)
		);

		$plain_text = 'tes';
		$ciphertext = $this->encryption->encrypt($plain_text);

		// Outputs: This is a plain-text message!
		$desc = $this->encryption->decrypt($ciphertext);

		echo $desc;
	}
}
?>
