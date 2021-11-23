<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Asuransi extends CI_controller
{
  var $validcfg;

  public function __construct() {
    parent::__construct();
    $this->load->model('M_asuransi', 'asuransi');
    $this->load->library('form_validation');
    $this->validcfg = array(
      array('field' => 'kode_asuransi', 'label' => 'Kode Asuransi', 'rules' => 'required'),
      array('field' => 'nama_asuransi', 'label' => 'Nama Asuransi', 'rules' => 'required'),
      // array('field' => 'singkatan', 'label' => 'Singkatan', 'rules' => 'required'),
      // array('field' => 'id_tipe_as', 'label' => 'Tipe Asuransi', 'rules' => 'required'),
      // array('field' => 'id_kategori_as', 'label' => 'Kategori Asuransi', 'rules' => 'required'),
      array('field' => 'telp', 'label' => 'Telepon', 'rules' => 'required'),
      // array('field' => 'fax', 'label' => 'Fax', 'rules' => 'required'),
      // array('field' => 'website', 'label' => 'Website', 'rules' => 'required'),
      array('field' => 'email', 'label' => 'Email', 'rules' => 'required|valid_email', 'errors' => array('valid_email' => 'Format Email Tidak Sesuai')),
      array('field' => 'idnega', 'label' => 'Negara', 'rules' => 'required'),
      array('field' => 'idprov', 'label' => 'Provinsi', 'rules' => 'required'),
      array('field' => 'idkab', 'label' => 'Kabupaten/kota', 'rules' => 'required'),
      array('field' => 'idkec', 'label' => 'Kecamatan', 'rules' => 'required'),
      array('field' => 'idkel', 'label' => 'Kelurahan/Desa', 'rules' => 'required'),
      array('field' => 'alamat', 'label' => 'Alamat Asuransi', 'rules' => 'required'),
      array('field' => 'pic', 'label' => 'PIC', 'rules' => 'required'),
      array('field' => 'telp_pic', 'label' => 'Telepon PIC', 'rules' => 'required'),
      array('field' => 'email_pic', 'label' => 'Email PIC', 'rules' => 'required|valid_email', 'errors' => array('valid_email' => 'Format Email Tidak Sesuai')),
      array('field' => 'alamat_pic', 'label' => 'Alamat PIC', 'rules' => 'required')
    );
    if($this->session->userdata('username') == "") {
      redirect(base_url(), 'refresh');
    }

    $url = $this->db->get('m_setting')->row_array();

    $this->url_up   = $url['url_uploads'];
    $this->url_img  = $url['url_images'];

  }

  public function index($value='')
  {
    $data = [
      'title'         => 'Asuransi',
      'sub_title'     => 'Input Data Asuransi',
      'tipe_as'       => $this->asuransi->get_data_order('m_tipe_as', 'tipe_as', 'asc')->result(),
      'kategori_as'   => $this->asuransi->get_data_order('m_kategori_as', 'kategori_as', 'asc')->result(),
      'list_negara'   => $this->asuransi->get_data_order('m_negara', 'negara', 'asc')->result(),
      'list_provinsi' => $this->asuransi->get_data_order('m_provinsi', 'provinsi', 'asc')->result(),
      'role'          => get_role($this->session->userdata('id_level_otorisasi')),
      'url_img'       => $this->url_img
    ];
    $this->template->load('template/index', 'index', $data);
  }

  public function asuransi_kode($value='')
  {
    $kode = codegenerate('m_asuransi','ASN','asuransi','N');
    echo $kode;
  }

  public function ajaxdata($action)
  {
    $permisi = explode('_',$action);
    $b1 = ''; $b2 = '';

    $no   = $this->input->post('start');
    $data = $this->asuransi->get_data_asuransi();

    $datax = array();
    foreach ($data as $o) {
      $tbody = array();

      $no++;
      $tbody[] = "<div align='center'>".$no.".</div>";
      $tbody[] = $o['kode_asuransi'];
      $tbody[] = $o['nama_asuransi'];
      $tbody[] = $o['telp'];
      $tbody[] = $o['pic'];
      // $tbody[] = $o['kategori_as'];
      // $tbody[] = $o['tipe_as'];
      if ($permisi[0] == 'true' || $action == '_') {
        $b1 = '<span style="cursor:pointer" class="mr-2 text-primary edit-asuransi '.(count($data) > 1?'ttip':'').'" data-toggle="tooltip" data-placement="top" title="Ubah" onclick="ubahubah('.$o['id_asuransi'].')">
                <i class="fas fa-pencil-alt fa-lg"></i>
               </span>';
      }
      if ($permisi[1] == 'true' || $action == '_') {
        $b2 = '<span style="cursor:pointer" class="text-danger hapus-asuransi '.(count($data) > 1?'ttip':'').'" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="deletedel('.$o['id_asuransi'].')">
                <i class="far fa-trash-alt fa-lg"></i>
               </span>';
      }
      $b3 = '<span style="cursor:pointer" class="text-dark '.(count($data) > 1?'ttip':'').'" data-toggle="tooltip" data-placement="top" title="Detail" onclick="detaild('.$o['id_asuransi'].')"><i class="fas fa-info-circle fa-lg"></i></span>&nbsp;&nbsp;';
      $tbody[] = $b3.$b1.$b2;
      $datax[] = $tbody;
    }

    $output = [
      "draw"            => $_POST['draw'],
      "recordsTotal"    => $this->asuransi->jumlah_semua_asuransi(),
      "recordsFiltered" => $this->asuransi->jumlah_filter_asuransi(),
      "data"            => $datax
    ];
    echo json_encode($output);
  }

  public function add()
  {
    $this->form_validation->set_rules($this->validcfg);
    if ($this->form_validation->run() == FALSE) {
      echo json_encode(['status' => 'Gagal', 'pesan' => 'Gagal Insert, Ada Form yg kosong', 'altr' =>'warning', 'hasil' => validation_errors()]);
    } else {

      $config['upload_path']    = $this->url_up.'rekanan';
      $config['allowed_types']  = 'png|jpeg|jpg';          

      $this->load->library('upload', $config);

      $this->db->where(['LOWER(nama_asuransi)' => strtolower($this->input->post('nama_asuransi'))]);
      $cek = $this->db->get('m_asuransi')->num_rows();
      if ($cek == 0) {

        if(!empty($_FILES['image']['name'])){

            if ( ! $this->upload->do_upload('image')) {

              $status     = "error";
              $msg        = $this->upload->display_errors();

              echo json_encode(['status' => 'Gagal', 'pesan' => 'Tipe file image harus png atau jpg', 'altr' =>'error', 'hasil' => '']);

          } else {

            $dataupload = $this->upload->data();

            $data['logo_asuransi']  = $dataupload['file_name'];
            
          }
          
        }

        $data['kode_asuransi'] = $this->input->post('kode_asuransi');
        $data['nama_asuransi'] = $this->input->post('nama_asuransi');
        $data['singkatan'] = $this->input->post('singkatan');
        if ($this->input->post('id_tipe_as') != '') {
          $data['id_tipe_as'] = $this->input->post('id_tipe_as');
        }
        if ($this->input->post('id_kategori_as') != '') {
          $data['id_kategori_as'] = $this->input->post('id_kategori_as');
        }
        $data['telp'] = $this->input->post('telp');
        $data['fax'] = $this->input->post('fax');
        $data['website'] = $this->input->post('website');
        $data['email'] = $this->input->post('email');
        $data['id_negara'] = $this->input->post('idnega');
        $data['id_provinsi'] = $this->input->post('idprov');
        $data['id_kota'] = $this->input->post('idkab');
        $data['id_kecamatan'] = $this->input->post('idkec');
        $data['id_desa'] = $this->input->post('idkel');
        $data['alamat'] = $this->input->post('alamat');
        $data['pic'] = $this->input->post('pic');
        $data['telp_pic'] = $this->input->post('telp_pic');
        $data['email_pic'] = $this->input->post('email_pic');
        $data['alamat_pic'] = $this->input->post('alamat_pic');
        $data['add_time'] = date('Y-m-d H:i:s');
        $data['add_by'] = $this->session->userdata('sesi_id');

        if (cek_duplicate('m_asuransi', 'nama_asuransi', '', '', $this->input->post('nama_asuransi')) == 0) {
          $this->db->insert('m_asuransi', $data);
          echo json_encode(['status' => 'Sukses', 'pesan' => 'Data Asuransi telah di Tambahkan', 'altr' =>'success', 'hasil' => '']);
        } else {
          echo json_encode(['status' => 'Gagal', 'pesan' => 'Data Asuransi tersebut Sudah Ada', 'altr' =>'error', 'hasil' => '']);
        }
      } else {
        echo json_encode(['status' => 'Gagal', 'pesan' => 'Nama Asuransi tersebut Sudah Ada', 'altr' =>'error', 'hasil' => '']);
      }
    }
  }

  public function show($id)
  {
    $this->db->join('m_tipe_as','m_asuransi.id_tipe_as = m_tipe_as.id_tipe_as', 'LEFT');
    $this->db->join('m_kategori_as','m_asuransi.id_kategori_as = m_kategori_as.id_kategori_as', 'LEFT');
    $this->db->where('id_asuransi',$id);
    $data = $this->db->get('m_asuransi')->result();
    echo json_encode($data);
  }

  public function detail($id)
  {
    $this->db->join('m_negara','m_negara.id_negara = m_asuransi.id_negara','LEFT');
    $this->db->join('m_provinsi ','m_provinsi.id_provinsi = m_asuransi.id_provinsi','LEFT');
    $this->db->join('m_kota','m_kota.id_kota = m_asuransi.id_kota','LEFT');
    $this->db->join('m_kecamatan','m_kecamatan.id_kecamatan = m_asuransi.id_kecamatan','LEFT');
    $this->db->join('m_desa','m_desa.id_desa = m_asuransi.id_desa','LEFT');
    $this->db->join('m_tipe_as','m_asuransi.id_tipe_as = m_tipe_as.id_tipe_as', 'LEFT');
    $this->db->join('m_kategori_as','m_asuransi.id_kategori_as = m_kategori_as.id_kategori_as', 'LEFT');
    $this->db->where('id_asuransi',$id);
    $data = $this->db->get('m_asuransi')->result();
    echo json_encode($data);
  }

  public function edit($id)
  {
    $this->form_validation->set_rules($this->validcfg);
    if ($this->form_validation->run() == FALSE) {
      echo json_encode(['status' => 'Gagal', 'pesan' => 'Gagal Update, Ada Form yg kosong', 'altr' =>'warning', 'hasil' => validation_errors()]);
    } else {

      if (cek_duplicate('m_asuransi', 'nama_asuransi', 'id_asuransi', $id, $this->input->post('nama_asuransi')) == 0) {

        if(!empty($_FILES['image']['name'])){

          // $config['upload_path'] = './uploads/rekanan';
          $config['upload_path'] =  $this->url_up.'rekanan';
          $config['allowed_types'] = 'png|jpeg|jpg';          

          $this->load->library('upload', $config);

          if ( ! $this->upload->do_upload('image')) {

              $status     = "error";
              $msg        = $this->upload->display_errors();

              echo json_encode(['status' => 'Gagal', 'pesan' => 'Tipe file image harus png atau jpg', 'altr' =>'error', 'hasil' => '']);

          } else {

            $cari = $this->asuransi->cari_data('m_asuransi', ['id_asuransi' => $id])->row_array();

            if (!empty($cari)) {
              $path = $this->url_up.'rekanan/'.$cari['logo_asuransi'];
              unlink($path); 
            }

            $dataupload = $this->upload->data();

            $data['logo_asuransi']  = $dataupload['file_name'];

            // $data['kode_asuransi'] = $this->input->post('kode_asuransi');
            // $data['nama_asuransi'] = $this->input->post('nama_asuransi');
            // $data['singkatan'] = $this->input->post('singkatan');
            // if ($this->input->post('id_tipe_as') != '') {
            //   $data['id_tipe_as'] = $this->input->post('id_tipe_as');
            // } else {
            //   $data['id_tipe_as'] = null;
            // }
            // if ($this->input->post('id_kategori_as') != '') {
            //   $data['id_kategori_as'] = $this->input->post('id_kategori_as');
            // } else {
            //   $data['id_kategori_as'] = null;
            // }

            // $data['telp'] = $this->input->post('telp');
            // $data['fax'] = $this->input->post('fax');
            // $data['website'] = $this->input->post('website');
            // $data['email'] = $this->input->post('email');
            // $data['id_negara'] = $this->input->post('idnega');
            // $data['id_provinsi'] = $this->input->post('idprov');
            // $data['id_kota'] = $this->input->post('idkab');
            // $data['id_kecamatan'] = $this->input->post('idkec');
            // $data['id_desa'] = $this->input->post('idkel');
            // $data['alamat'] = $this->input->post('alamat');
            // $data['pic'] = $this->input->post('pic');
            // $data['telp_pic'] = $this->input->post('telp_pic');
            // $data['email_pic'] = $this->input->post('email_pic');
            // $data['alamat_pic'] = $this->input->post('alamat_pic');
            // $data['add_time'] = date('Y-m-d H:i:s');
            // $data['add_by'] = $this->session->userdata('sesi_id');
            // $this->db->where('id_asuransi', $id);
            // $this->db->update('m_asuransi', $data);
            // echo json_encode(['status' => 'Sukses', 'pesan' => 'Data Asuransi telah di Update', 'altr' =>'success', 'hasil' => '']);
            
          }
          
        }
        //  else {

          $data['kode_asuransi'] = $this->input->post('kode_asuransi');
            $data['nama_asuransi'] = $this->input->post('nama_asuransi');
            $data['singkatan'] = $this->input->post('singkatan');
            if ($this->input->post('id_tipe_as') != '') {
              $data['id_tipe_as'] = $this->input->post('id_tipe_as');
            } else {
              $data['id_tipe_as'] = null;
            }
            if ($this->input->post('id_kategori_as') != '') {
              $data['id_kategori_as'] = $this->input->post('id_kategori_as');
            } else {
              $data['id_kategori_as'] = null;
            }

            $data['telp'] = $this->input->post('telp');
            $data['fax'] = $this->input->post('fax');
            $data['website'] = $this->input->post('website');
            $data['email'] = $this->input->post('email');
            $data['id_negara'] = $this->input->post('idnega');
            $data['id_provinsi'] = $this->input->post('idprov');
            $data['id_kota'] = $this->input->post('idkab');
            $data['id_kecamatan'] = $this->input->post('idkec');
            $data['id_desa'] = $this->input->post('idkel');
            $data['alamat'] = $this->input->post('alamat');
            $data['pic'] = $this->input->post('pic');
            $data['telp_pic'] = $this->input->post('telp_pic');
            $data['email_pic'] = $this->input->post('email_pic');
            $data['alamat_pic'] = $this->input->post('alamat_pic');
            $data['add_time'] = date('Y-m-d H:i:s');
            $data['add_by'] = $this->session->userdata('sesi_id');
            $this->db->where('id_asuransi', $id);
            $this->db->update('m_asuransi', $data);
            echo json_encode(['status' => 'Sukses', 'pesan' => 'Data Asuransi telah di Update', 'altr' =>'success', 'hasil' => '']);
          
        // }

        
      
      } else {

        echo json_encode(['status' => 'Gagal', 'pesan' => 'Data Asuransi tersebut Sudah Ada', 'altr' =>'error', 'hasil' => '']);
      }
    }

  }

  public function remove($id)
  {
    $this->db->where(['id_karyawan' => $id]);
    $cek_usn = $this->db->get('m_user');
    if ($cek_usn->num_rows() > 0) {
      $hsl = $cek_usn->result();
      foreach ($hsl as $key) {
        if ($key->flag_table == "") { // dari asuransi
          $this->db->where(['id_karyawan' => $id, 'id_level_user' => 2]);
          $this->db->delete('m_user');
        } else { // dari tertanggung
          $this->db->where(['id_karyawan' => $id, 'flag_table' => 1]);
          $this->db->delete('m_user');
        }
      }
    }

    $this->db->where('id_asuransi', $id);
    $this->db->delete('m_asuransi');

    echo json_encode(['status' => 'sukses']);
  }
}

?>
