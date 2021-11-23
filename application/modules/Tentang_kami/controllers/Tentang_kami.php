<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Tentang_kami extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_tentang_kami');
        if($this->session->userdata('username') == "") {
        redirect(base_url(), 'refresh');
        }

        $this->aksi_crud        = get_role($this->session->userdata('id_level_otorisasi'));
        $this->id_lvl_otorisasi = $this->session->userdata('id_level_otorisasi');
        $this->sesi_id          = $this->session->userdata('sesi_id');
    }

    public function index()
    {
        $data 	= [ 'title'             => 'Tentang Kami',
                    'role'              => $this->aksi_crud,
                    'id_lvl_otorisasi'  => $this->id_lvl_otorisasi,
                    'id_user'           => $this->sesi_id
                ];

        $this->template->load('template/index','lihat', $data);
    }

    // 27-08-2021
    public function tampil_data_tentang_kami()
    {
        $read               = $this->input->post('read');
        $create             = $this->input->post('create');
        $update             = $this->input->post('update');
        $delete             = $this->input->post('delete');
        $id_user            = $this->input->post('id_user');
        $id_lvl_otorisasi   = $this->input->post('id_lvl_otorisasi');

        if ($read == 'true' || $id_lvl_otorisasi == 0) {
            $list = $this->M_tentang_kami->get_data_tentang_kami();
        } else {
            $list = [];
        } 

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $tentang_kami = str_replace("'","999", $o['tentang_kami']);
            
            $a0 = "<span style='cursor:pointer' class='mr-2 text-dark detail ttip' data-toggle='tooltip' data-placement='top' title='Detail' data-id='".$o['id']."'><i class='fas fa-info-circle fa-lg'></i></span>";

            if ($id_lvl_otorisasi == 0) {
                $a1 = "<span style='cursor:pointer' class='mr-2 text-primary ttip edit' data-toggle='tooltip' data-placement='top' title='Ubah' data-id='".$o['id']."' judul='".$o['title']."' tentang_kami='".$tentang_kami."' images='".$o['images']."' sumber='".$o['sumber']."' editor='".$o['editor']."' active='".$o['active']."'><i class='fas fa-pencil-alt fa-lg'></i></span>";
                $a2 = "<span style='cursor:pointer' class='text-danger ttip hapus' data-toggle='tooltip' data-placement='top' title='Hapus' data-id='".$o['id']."' image='".$o['images']."'><i class='far fa-trash-alt fa-lg'></i></span>";
            } else {
                if ($update == 'true') {
      
                    if ($delete == 'true') {
                        $mrd = "mr-2";
                    } else {
                        $mrd = "";
                    }
      
                    $a1 = "<span style='cursor:pointer' class='$mrd text-primary ttip edit' data-toggle='tooltip' data-placement='top' title='Ubah' data-id='".$o['id']."' judul='".$o['title']."' tentang_kami='".$o['tentang_kami']."' images='".$o['images']."' sumber='".$o['sumber']."' editor='".$o['editor']."' active='".$o['active']."'><i class='fas fa-pencil-alt fa-lg'></i></span>";

                } else {
                    $a1 = "";
                }
      
                if ($delete == 'true') {
                    $a2 = "<span style='cursor:pointer' class='text-danger ttip hapus' data-toggle='tooltip' data-placement='top' title='Hapus' data-id='".$o['id']."' image='".$o['images']."'><i class='far fa-trash-alt fa-lg'></i></span>";
                } else {
                    $a2 = "";
                } 
            }

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = wordwrap(character_limiter(strip_tags($o['judul']), 500),70,"<br>\n");
            $tbody[]    = wordwrap(character_limiter(strip_tags($o['isi']), 500),70,"<br>\n");
            $tbody[]    = $a0.$a1.$a2;
            $data[]     = $tbody;
        }

        if ($read == 'true' || $id_lvl_otorisasi == 0) {
            $recordsTotal       = $this->M_tentang_kami->jumlah_semua_tentang_kami();
            $recordsFiltered    = $this->M_tentang_kami->jumlah_filter_tentang_kami();
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

    // 03-09-2021
    public function detail_tentang_kami($id_tentang_kami)
    {
        $data = ['list' => $this->M_tentang_kami->cari_data('m_tentang_kami', ['id' => $id_tentang_kami])->row_array()];

        $this->load->view('detail_tentang_kami', $data);
    }

    public function get_edit($id_tentang_kami)
    {
        $list = $this->M_tentang_kami->cari_data('m_tentang_kami', ['id' => $id_tentang_kami])->row_array();

        echo json_encode($list);
    }

    // 27-08-2021
    public function simpan_tentang_kami()
    {

        $id         = $this->input->post('id_tentang_kami');        
        $aksi       = $this->input->post('aksi');              
        $judul1     = $this->input->post('judul');        
        $isi1       = $this->input->post('isi');      

        $judul      = html_entity_decode(htmlentities($judul1, ENT_QUOTES, 'UTF-8'), ENT_QUOTES , 'ISO-8859-1');
        $isi        = html_entity_decode(htmlentities($isi1, ENT_QUOTES, 'UTF-8'), ENT_QUOTES , 'ISO-8859-1');

        if ($aksi == 'Hapus') {

            $this->M_tentang_kami->hapus_data('m_tentang_kami', ['id' => $id]);

        } elseif ($aksi == 'Tambah') {
    
            $dt_input = ['judul'        => $judul,
                            'isi'          => $isi,
                            'add_by'       => $this->sesi_id,
                            'add_time'     => date("Y-m-d H:i:s", now('Asia/Jakarta'))
                        ];
            
            $this->M_tentang_kami->input_data('m_tentang_kami', $dt_input);
                
        } elseif ($aksi == 'Ubah') {

            $dt_input = ['judul'        => $judul,
                         'isi'          => $isi,
                         'updated_by'   => $this->sesi_id,
                         'updated_time' => date("Y-m-d H:i:s", now('Asia/Jakarta'))
                    ];

            $this->M_tentang_kami->ubah_data('m_tentang_kami', $dt_input, ['id' => $id]);

            
        }

        echo json_encode(array('status'=> true));
    }
}

/* End of file Tentang Kami.php */
