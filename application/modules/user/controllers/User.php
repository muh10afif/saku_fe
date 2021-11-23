<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class User extends CI_controller
{
  var $validcfg;

  public function __construct() {
    parent::__construct();
    $this->load->model('M_user','user');
    $this->load->model('karyawan/M_karyawan', 'karyawan');
    $this->load->model('level_user/M_level_user', 'level_user');
    $this->load->model('level_otorisasi/M_level_otorisasi', 'level_otorisasi');
    $this->load->helper('inputtype_helper');
    $this->load->library('form_validation');
    $this->validcfg = array(
      array('field' => 'lvotor', 'label' => 'Level Otorisasi', 'rules' => 'required'),
      array('field' => 'usernm', 'label' => 'Username', 'rules' => 'required'),
      array('field' => 'passwd', 'label' => 'Password', 'rules' => 'required')
    );
    if($this->session->userdata('username') == "") {
      redirect(base_url(), 'refresh');
    }
  }

  public function admin($value='')
  {
    // var_dump(bredcumx());
    $data = [
      'title'           => 'User Data',
      'list_karyawan'   => $this->karyawan->allkaryawan(),
      'level_user'      => $this->level_user->alllvlusr(),
      'level_otorisasi' => $this->level_otorisasi->alllvloto(),
      'role' => get_role($this->session->userdata('id_level_otorisasi'))
    ];
    $this->template->load('template/index', 'index', $data);
  }

  public function ajaxdata($action)
  {
    $permisi = explode('_',$action);
    $b1 = ''; $b2 = '';

    $no   = $this->input->post('start');
    $data = $this->user->get_data_alluser();

    $datax = array();
    foreach ($data as $key) {
      $tbody = array();

      $no++;
      $tbody[] = "<div align='center'>".$no.".</div>";
      $tbody[] = $key['level_user'];
      $tbody[] = $key['level_otorisasi'];
      $tbody[] = $this->penamaan($key['idkr'], $key['lvus'], $key['flag_table']);
      $tbody[] = $key['username'];
      $tbody[] = $key['level_user'] == "Broker"?$key['jabatan']:'-';
      if ($permisi[0] == 'true' || $action == '_') {
        $b1 = '<span style="cursor:pointer" class="mr-2 text-primary '.(count($data) > 1?'ttip':'').'" data-toggle="tooltip" data-placement="top" title="Ubah" onclick="ubahubah('.$key['id_user'].')"><i class="fas fa-pencil-alt fa-lg"></i></span>';
      }
      if ($permisi[1] == 'true' || $action == '_') {
        $b2 = '<span style="cursor:pointer" class="text-danger '.(count($data) > 1?'ttip':'').'" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="deletedel('.$key['id_user'].')"><i class="far fa-trash-alt fa-lg"></i></span>';
      }
      $tbody[] = $b1.$b2;
      $datax[] = $tbody;
    }

    $output = [
      "draw"            => $_POST['draw'],
      "recordsTotal"    => $this->user->countalluser(),
      "recordsFiltered" => $this->user->countfilteruser(),
      "data"            => $datax
    ];
    echo json_encode($output);
  }

  public function otorisasibroker($idj)
  {
    $this->db->join('level_otorisasi', 'level_otorisasi.id_level_otorisasi = role.id_level_otorisasi');
    $this->db->where('role.id_jabatan', $idj);
    $data = $this->db->get('role')->result();
    return $data[0]->level_otorisasi;
  }

  public function penamaan($idn, $lvl, $flg)
  {
    $hsl = '';
    if ($flg != null && $flg != '') {
      $has = getdbtable($flg);
      $inid = 'id_'.substr($has,2,strlen($has));
      $this->db->where('table_name', $has);
      $data = $this->db->get('information_schema.columns')->result();
      $fnme = array();
      foreach ($data as $key => $value) {
        if ($value->column_name == 'nama_'.substr($has,2,strlen($has)) || $value->column_name == 'nama') {
          $dat['nmny'] = $value->column_name;
          $fnme[] = $dat;
        }
      }
      $this->db->select($fnme[0]['nmny'].' as nama');
      $this->db->where($inid, $idn);
      $dat = $this->db->get($has)->result_array();
      $hsl = $dat[0]['nama'];
    } else {
      if ($idn != null) {
        $this->db->where('id_level_user', $lvl);
        $dtlv = $this->db->get('level_user')->result_array();
        switch ($dtlv[0]['level_user']) {
          case 'Broker':
            $this->db->where('id_karyawan', $idn);
            $dat = $this->db->get('m_karyawan')->result_array();
            $hsl = $dat[0]['nama_karyawan'];
          break;
          case 'Asuransi':
            $this->db->where('id_asuransi', $idn);
            $dat = $this->db->get('m_asuransi')->result_array();
            $hsl = $dat[0]['nama_asuransi'];
          break;
          case 'Pengguna Tertanggung':
            $this->db->where('id_pengguna_tertanggung', $idn);
            $dat = $this->db->get('pengguna_tertanggung')->result_array();
            $hsl = $dat[0]['nama'];
          break;
        }
      }
    }
    return $hsl;
  }

  public function getfromdb($dbdb)
  {
    $has = getdbtable($dbdb);
    $inid = 'id_'.substr($has,2,strlen($has));
    $this->db->where('table_name', $has);
    $data = $this->db->get('information_schema.columns')->result();
    $fnme = array();
    foreach ($data as $key => $value) {
      if ($value->column_name == 'nama_'.substr($has,2,strlen($has)) || $value->column_name == 'nama') {
        $dat['nmny'] = $value->column_name;
        $fnme[] = $dat;
      }
    }
    $this->db->select($inid.' as id, '.$fnme[0]['nmny'].' as nama');
    $this->db->order_by($fnme[0]['nmny'], 'asc');
    $data = $this->db->get($has)->result();
    echo json_encode($data);
  }

  public function add()
  {
    $this->form_validation->set_rules($this->validcfg);
    if ($this->form_validation->run() == FALSE) {
      echo json_encode([
        'judul' => 'Gagal',
        'status' => 'Data User Gagal di Tambahkan, Ada Form yang kosong',
        'tipe' => 'warning'
      ]);
    } else {
      $uscek = $this->user->cekusername($this->input->post('usernm'));
      if ($uscek == 0) {
        $id_level = $this->user->llus($this->input->post('lvlusr'));
        if ($this->input->post('fltabl') == "") {
          $this->db->where(['id_karyawan' => $this->input->post('idkywn'), 'id_level_user' => $id_level, 'id_level_otorisasi' => $this->input->post('lvotor')]);
        } else {
          $this->db->where(['id_karyawan' => $this->input->post('idkywn'), 'flag_table' => $this->input->post('fltabl'), 'id_level_otorisasi' => $this->input->post('lvotor')]);
        }
        $cekk = $this->db->get('m_user')->num_rows();
        if ($cekk == 0) {
          $data['kode_user']            = codegenerate('m_user','USR', 'user', 'R');
          $data['id_karyawan']          = $this->input->post('idkywn');
          $data['id_level_user']        = $id_level;
          if ($this->input->post('fltabl') != "") {
            $data['flag_table']         = $this->input->post('fltabl');
          }
          $data['username']             = $this->input->post('usernm');
          $data['password']             = password_hash($this->input->post('passwd'), PASSWORD_DEFAULT);
          $data['id_level_otorisasi']   = $this->input->post('lvotor');
          $data['add_time']             = date('Y-m-d');
          $data['add_by']               = $this->session->userdata('sesi_id');
          if (duplicatecek('m_user', $data) == 0) {
            $this->db->insert('m_user', $data);
            echo json_encode([
              'judul' => 'Berhasil',
              'status' => 'Data User Berhasil di Tambahkan',
              'tipe' => 'success'
            ]);
          } else {
            echo json_encode([
              'judul' => 'Gagal',
              'status' => 'Data User Tersebut Sudah Ada',
              'tipe' => 'error'
            ]);
          }
        } else {
          echo json_encode([
            'judul' => 'Gagal',
            'status' => 'Data User Gagal di Tambahkan, dikarenakan pengguna tersebut sudah Memiliki data User',
            'tipe' => 'warning'
          ]);
        }
      } else {
        echo json_encode([
          'judul' => 'Gagal',
          'status' => 'Username telah Tersedia',
          'tipe' => 'warning'
        ]);
      }
    }
  }

  public function show($id)
  {
    $this->db->join('level_user','level_user.id_level_user = m_user.id_level_user');
    $this->db->where('id_user', $id);
    $data = $this->db->get('m_user')->result();
    echo json_encode($data);
  }

  public function getlistnya($dbdb)
  {
    $ddb = ''; $order = '';
    switch ($dbdb) {
      case 0:
        $order = 'nama_karyawan';
        $ddb = 'm_karyawan';
        break;
      case 1:
        $order = 'nama_asuransi';
        $ddb = 'm_asuransi';
        break;
      case 3:
        $order = 'nama';
        $ddb = 'pengguna_tertanggung';
        break;
    }

    if ($dbdb == 3) {
      $this->db->order_by($order, 'asc');

      $this->db->join('m_nasabah as t', "t.id_nasabah = $ddb.id_insured", 'inner');
      $this->db->where("$ddb.nama !=", "dsds");

      $data = $this->db->get($ddb)->result();
      echo json_encode($data);
    } else {
      $this->db->order_by($order, 'asc');
      $data = $this->db->get($ddb)->result();
      echo json_encode($data);
    }
    
  }

  public function getlistoto()
  {
    $dbb = "";
    if ($this->input->post('lvl') == 'Broker') {
      $this->db->select('level_otorisasi.*');
      $this->db->join('m_jabatan','m_karyawan.id_jabatan = m_jabatan.id_jabatan');
      $this->db->join('role','m_jabatan.id_jabatan = role.id_jabatan');
      $this->db->join('level_otorisasi','role.id_level_otorisasi = level_otorisasi.id_level_otorisasi');
      $this->db->where('m_karyawan.id_karyawan', $this->input->post('idp'));
      $this->db->order_by("level_otorisasi.level_otorisasi", "asc");
      $ckz = $this->db->get('m_karyawan')->result();

      // $dbb = $ckz;
      if (count($ckz) != 0) {
        $dbb = $ckz;
      } else {
        $this->db->select('level_otorisasi.*');
        $this->db->join('level_user','level_otorisasi.id_level_user = level_user.id_level_user');
        $this->db->where('level_user.level_user',$this->input->post('lvl'));
        $this->db->order_by("level_otorisasi.level_otorisasi", "asc");
        $dbb = $this->db->get('level_otorisasi')->result();
      }
    } else {
      $this->db->select('level_otorisasi.*');
      $this->db->join('level_user','level_otorisasi.id_level_user = level_user.id_level_user');
      $this->db->where('level_user.level_user',$this->input->post('lvl'));
      $this->db->order_by("level_otorisasi.level_otorisasi", "asc");
      $dbb = $this->db->get('level_otorisasi')->result();
    }
    echo json_encode($dbb);
  }

  public function edit($id)
  {
    $list_edit = $this->db->get_where('m_user', ['id_user' => $id])->row_array();
    
    $this->form_validation->set_rules($this->validcfg);
    if ($this->form_validation->run() == FALSE) {
      echo json_encode([
        'judul' => 'Gagal',
        'status' => 'Ada Form yang Kosong',
        'tipe' => 'warning'
      ]);

      exit();
    } else {
    }
    
    $uscek = $this->user->cekusername_edit($list_edit['username'],$this->input->post('usernm'));

    if ($uscek == 'sama') {

      echo json_encode([
        'judul' => 'Gagal',
        'status' => 'Username telah Tersedia',
        'tipe' => 'warning'
      ]);

      exit();

    } else {
      
    }

    if ($this->input->post('passwd') != "") {
      if ($this->input->post('fltabl') != "") {
        $data['flag_table']   = $this->input->post('fltabl');
      }
      $data['id_karyawan']    = $this->input->post('idkywn');
      // $data['id_level_user']  = $this->user->llus($this->input->post('lvlusr'));
      $data['username']       = $this->input->post('usernm');
      $this->db->where('id_user', $id);
      $get_pas = $this->db->get('m_user')->result();
      if ($this->input->post('passwd') == $get_pas[0]->password) {
        $data['password']     = $this->input->post('passwd');
      } else {
        $data['password']     = password_hash($this->input->post('passwd'), PASSWORD_DEFAULT);
      }
      $data['id_level_otorisasi'] = $this->input->post('lvotor');
      $data['add_time']       = date('Y-m-d');
      $data['add_by']         = $this->session->userdata('sesi_id');
      $this->db->where('id_user', $id);
      $this->db->update('m_user', $data);
      echo json_encode([
        'judul' => 'Berhasil',
        'status' => 'Data berhasil Diubah',
        'tipe' => 'success'
      ]);
    } else {
      echo json_encode([
        'judul' => 'Gagal',
        'status' => 'Password Harus diisi',
        'tipe' => 'warning'
      ]);
    }
  }

  public function remove($id)
  {
    $this->db->where('id_user', $id);
    $this->db->delete('m_user');

    echo json_encode(['status' => 'sukses']);
  }
}

?>
