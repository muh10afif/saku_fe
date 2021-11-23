<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Syarat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_syarat');
        if($this->session->userdata('username') == "") {
        redirect(base_url(), 'refresh');
        }

        $this->aksi_crud        = get_role($this->session->userdata('id_level_otorisasi'));
        $this->id_lvl_otorisasi = $this->session->userdata('id_level_otorisasi');
        $this->sesi_id          = $this->session->userdata('sesi_id');
    }

    public function index()
    {
        $data 	= [ 'title'             => 'Syarat',
                    'asuransi'          => $this->M_syarat->get_data_order('m_asuransi', 'nama_asuransi', 'asc')->result_array(),
                    'lob'               => $this->M_syarat->get_data_order('m_lob', 'lob', 'asc')->result_array(),
                    'role'              => $this->aksi_crud,
                    'id_lvl_otorisasi'  => $this->id_lvl_otorisasi,
                    'id_user'           => $this->sesi_id
                ];

        $this->template->load('template/index','lihat', $data);
    }

    // 24-08-2021
    public function tampil_data_syarat()
    {
        $read               = $this->input->post('read');
        $create             = $this->input->post('create');
        $update             = $this->input->post('update');
        $delete             = $this->input->post('delete');
        $id_user            = $this->input->post('id_user');
        $id_lvl_otorisasi   = $this->input->post('id_lvl_otorisasi');

        if ($read == 'true' || $id_lvl_otorisasi == 0) {
            $list = $this->M_syarat->get_data_syarat();
        } else {
            $list = [];
        } 

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            if ($id_lvl_otorisasi == 0) {
                $a1 = "<span style='cursor:pointer' class='mr-2 text-primary ttip edit' data-toggle='tooltip' data-placement='top' title='Ubah' data-id='".$o['id']."' id_asuransi='".$o['id_asuransi']."' id_lob='".$o['id_lob']."' syarat='".$o['syarat']."'  id_produk_asuransi='".$o['id_tr_produk_asuransi']."' premi='".$o['premi']."'><i class='fas fa-pencil-alt fa-lg'></i></span>";
                $a2 = "<span style='cursor:pointer' class='text-danger ttip hapus' data-toggle='tooltip' data-placement='top' title='Hapus' data-id='".$o['id']."' ><i class='far fa-trash-alt fa-lg'></i></span>";
            } else {
                if ($update == 'true') {
      
                    if ($delete == 'true') {
                        $mrd = "mr-2";
                    } else {
                        $mrd = "";
                    }
      
                    $a1 = "<span style='cursor:pointer' class='$mrd text-primary ttip edit' data-toggle='tooltip' data-placement='top' title='Ubah' data-id='".$o['id']."' id_asuransi='".$o['id_asuransi']."' id_lob='".$o['id_lob']."' syarat='".$o['syarat']."'  id_produk_asuransi='".$o['id_tr_produk_asuransi']."' premi='".$o['premi']."'><i class='fas fa-pencil-alt fa-lg'></i></span>";

                } else {
                    $a1 = "";
                }
      
                if ($delete == 'true') {
                    $a2 = "<span style='cursor:pointer' class='text-danger ttip hapus' data-toggle='tooltip' data-placement='top' title='Hapus' data-id='".$o['id']."' ><i class='far fa-trash-alt fa-lg'></i></span>";
                } else {
                    $a2 = "";
                } 
            }

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['nama_asuransi'];
            $tbody[]    = wordwrap($o['lob'],25,"<br>\n");
            $tbody[]    = "<div class='text-right'>".number_format($o['premi'],0,'.','.')."</div>";
            $tbody[]    = wordwrap($o['syarat'],25,"<br>\n");
            $tbody[]    = $a1.$a2;
            $data[]     = $tbody;
        }

        if ($read == 'true' || $id_lvl_otorisasi == 0) {
            $recordsTotal       = $this->M_syarat->jumlah_semua_syarat();
            $recordsFiltered    = $this->M_syarat->jumlah_filter_syarat();
        } else {
            $recordsTotal       = 0;
            $recordsFiltered    = 0;
        }
    
        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $recordsTotal,
                    "recordsFiltered"  => $recordsFiltered,   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // 25-08-2021
    public function simpan_syarat()
    {
        $id_syarat              = $this->input->post('id_syarat');        
        $aksi                   = $this->input->post('aksi');        
        $id_tr_produk_asuransi  = $this->input->post('id_tr_produk_asuransi');        
        $asuransi               = $this->input->post('asuransi');        
        $lob                    = $this->input->post('lob');   
        $id_produk_as_premi     = $this->input->post('premi');   
        $syarat                 = $this->input->post('syarat');   
         
        $input_premi            = $this->input->post('input_premi');   
        
        $sing = $this->M_syarat->cari_data('m_asuransi', ['id_asuransi' => $asuransi])->row_array();      

        if ($aksi == 'Tambah') {

            if ($id_produk_as_premi == "") {

                $data = ['id_asuransi'          => $asuransi,
                         'id_lob'               => $lob,
                         'premi'                => $input_premi,
                         'aktif_premi'          => 1,
                         'add_time'             => date("Y-m-d H:i:s", now('Asia/Jakarta')),
                         'add_by'               => $this->sesi_id
                        ];

                $this->M_syarat->input_data('tr_produk_asuransi', $data); 
                $id_produk_as_premi = $this->db->insert_id();

                $kode = $sing['singkatan'].$lob.$id_produk_as_premi;

                $this->M_syarat->ubah_data('tr_produk_asuransi', ['kode_produk_asuransi' => $kode], ['id_tr_produk_asuransi' => $id_produk_as_premi]);
                
            }

            $inputan = ['id_produk_asuransi'=> $id_produk_as_premi,
                        'syarat'           => $syarat,
                        
                        ];
            
            $cek = cek_duplicate_banyak('m_syarat', '', '', $inputan);

            if ($cek == 0) {

                $data = ['id_produk_asuransi'   => $id_produk_as_premi,
                         'syarat'               => $syarat,
                         'add_time'             => date("Y-m-d H:i:s", now('Asia/Jakarta')),
                         'add_by'               => $this->sesi_id
                        ];

                $this->M_syarat->input_data('m_syarat', $data); 

            } else {

                echo json_encode(['status' => 'gagal']);
                exit();

            }

        } elseif ($aksi == 'Hapus') {

            $this->M_syarat->hapus_data('m_syarat', ['id' => $id_syarat]);

        } elseif ($aksi == 'Ubah') {

            if ($id_produk_as_premi == "") {

                $data = ['id_asuransi'          => $asuransi,
                         'id_lob'               => $lob,
                         'premi'                => $input_premi,
                         'aktif_premi'          => 1,
                         'add_time'             => date("Y-m-d H:i:s", now('Asia/Jakarta')),
                         'add_by'               => $this->sesi_id
                        ];

                $this->M_syarat->input_data('tr_produk_asuransi', $data); 
                $id_produk_as_premi = $this->db->insert_id();

                $kode = $sing['singkatan'].$lob.$id_produk_as_premi;

                $this->M_syarat->ubah_data('tr_produk_asuransi', ['kode_produk_asuransi' => $kode], ['id_tr_produk_asuransi' => $id_produk_as_premi]);
                
            }

            $inputan = ['id_produk_asuransi'=> $id_produk_as_premi,
                        'syarat'            => $syarat,
                        
                        ];
            
            $cek = cek_duplicate_banyak('m_syarat', 'id', $id_syarat, $inputan);

            if ($cek == 0) {

                $data = ['id_produk_asuransi'   => $id_produk_as_premi,
                         'syarat'               => $syarat,
                         'updated_time'         => date("Y-m-d H:i:s", now('Asia/Jakarta')),
                         'updated_by'           => $this->sesi_id
                       ];

                $this->M_syarat->ubah_data('m_syarat', $data, ['id' => $id_syarat]);

            } else {

                echo json_encode(['status' => 'gagal']);
                exit();

            }
            
        }

        echo json_encode(['status' => 'sukses']);
    }

    // 30-08-2021
    public function tampil_premi()
    {
        $id_asuransi    = $this->input->post('id_asuransi');
        $id_lob         = $this->input->post('id_lob');

        $cari = $this->M_syarat->cari_data('tr_produk_asuransi', ['id_asuransi' => $id_asuransi, 'id_lob' => $id_lob])->result_array();

        $option = "<option value=''>Pilih Premi</option>";

        if (!empty($cari)) {
            
            foreach ($cari as $c) {
                $option .= "<option value='".$c['id_tr_produk_asuransi']."'>".number_format($c['premi'],0,'.','.')."</option>";
            }
        } 

        echo json_encode(['jumlah' => count($cari), 'option' => $option]);
        
    }

}

/* End of file Syarat.php */
