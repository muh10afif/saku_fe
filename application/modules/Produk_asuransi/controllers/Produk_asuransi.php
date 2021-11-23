<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_asuransi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_produk_asuransi');
        if($this->session->userdata('username') == "") {
        redirect(base_url(), 'refresh');
        }

        $this->aksi_crud        = get_role($this->session->userdata('id_level_otorisasi'));
        $this->id_lvl_otorisasi = $this->session->userdata('id_level_otorisasi');
        $this->sesi_id          = $this->session->userdata('sesi_id');

        $url = $this->db->get('m_setting')->row_array();

        $this->url_up   = $url['url_uploads'];
        $this->url_img  = $url['url_images'];

    }

    public function index()
    {
        $data 	= [ 'title'             => 'Produk Asuransi',
                    'asuransi'          => $this->M_produk_asuransi->get_data_order('m_asuransi', 'nama_asuransi', 'asc')->result_array(),
                    'lob'               => $this->M_produk_asuransi->get_data_order('m_lob', 'lob', 'asc')->result_array(),
                    'role'              => $this->aksi_crud,
                    'id_lvl_otorisasi'  => $this->id_lvl_otorisasi,
                    'id_user'           => $this->sesi_id,
                    'url_img'            => $this->url_img
                ];

        $this->template->load('template/index','lihat', $data);
    }

    // 24-08-2021
    public function tampil_data_produk_asuransi()
    {
        $read               = $this->input->post('read');
        $create             = $this->input->post('create');
        $update             = $this->input->post('update');
        $delete             = $this->input->post('delete');
        $id_user            = $this->input->post('id_user');
        $id_lvl_otorisasi   = $this->input->post('id_lvl_otorisasi');

        if ($read == 'true' || $id_lvl_otorisasi == 0) {
            $list = $this->M_produk_asuransi->get_data_produk_asuransi();
        } else {
            $list = [];
        } 

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            if ($id_lvl_otorisasi == 0) {
                $a1 = "<span style='cursor:pointer' class='mr-2 text-primary ttip edit' data-toggle='tooltip' data-placement='top' title='Ubah' data-id='".$o['id_tr_produk_asuransi']."' id_asuransi='".$o['id_asuransi']."' id_lob='".$o['id_lob']."' premi='".$o['premi']."' logo_premi='".$o['logo_premi']."'><i class='fas fa-pencil-alt fa-lg'></i></span>";
                $a2 = "<span style='cursor:pointer' class='text-danger ttip hapus' data-toggle='tooltip' data-placement='top' title='Hapus' data-id='".$o['id_tr_produk_asuransi']."' logo_premi='".$o['logo_premi']."'><i class='far fa-trash-alt fa-lg'></i></span>";
            } else {
                if ($update == 'true') {
      
                    if ($delete == 'true') {
                        $mrd = "mr-2";
                    } else {
                        $mrd = "";
                    }
      
                    $a1 = "<span style='cursor:pointer' class='$mrd text-primary ttip edit' data-toggle='tooltip' data-placement='top' title='Ubah' data-id='".$o['id_tr_produk_asuransi']."' id_asuransi='".$o['id_asuransi']."' id_lob='".$o['id_lob']."' premi='".$o['premi']."' logo_premi='".$o['logo_premi']."'><i class='fas fa-pencil-alt fa-lg'></i></span>";

                } else {
                    $a1 = "";
                }
      
                if ($delete == 'true') {
                    $a2 = "<span style='cursor:pointer' class='text-danger ttip hapus' data-toggle='tooltip' data-placement='top' title='Hapus' data-id='".$o['id_tr_produk_asuransi']."' logo_premi='".$o['logo_premi']."'><i class='far fa-trash-alt fa-lg'></i></span>";
                } else {
                    $a2 = "";
                } 
            }

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['nama_asuransi'];
            $tbody[]    = wordwrap($o['lob'],25,"<br>\n");
            $tbody[]    = "<div class='text-right'>".number_format($o['premi'],0,'.','.')."</div>";
            $tbody[]    = $o['kode_produk_asuransi'];
            $tbody[]    = "<div align='center'><a class='' href='".$this->url_img.'produk/'.$o['logo_premi']."' title='".$o['logo_premi']."'><img src='".$this->url_img.'produk/'.$o['logo_premi']."' width='150px'></a><br>".character_limiter($o['logo_premi'],100)."</div>";
            $tbody[]    = $a1.$a2;
            $data[]     = $tbody;
        }

        if ($read == 'true' || $id_lvl_otorisasi == 0) {
            $recordsTotal       = $this->M_produk_asuransi->jumlah_semua_produk_asuransi();
            $recordsFiltered    = $this->M_produk_asuransi->jumlah_filter_produk_asuransi();
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
    public function simpan_produk_asuransi()
    {
        $config['upload_path'] = $this->url_up.'produk';
        $config['allowed_types'] = 'png|jpeg|jpg';          

        $this->load->library('upload', $config);

        $id_produk_asuransi = $this->input->post('id_produk_asuransi');        
        $aksi               = $this->input->post('aksi');        
        $asuransi           = $this->input->post('asuransi');        
        $lob                = $this->input->post('lob');        
        $premi              = $this->input->post('premi');   
        $image              = $this->input->post('nama_image'); 

        $sing = $this->M_produk_asuransi->cari_data('m_asuransi', ['id_asuransi' => $asuransi])->row_array(); 

        if ($aksi == 'Tambah') {

            $inputan = ['id_asuransi'   => $asuransi,
                        'id_lob'        => $lob,
                        'premi'         => $premi
                        ];
            
            $cek = cek_duplicate_banyak('tr_produk_asuransi', '', '', $inputan);

            if ($cek == 0) {

                if ( ! $this->upload->do_upload('image')) {

                    $sts_respon     = "error";
                    $msg            = $this->upload->display_errors();
        
                } else {
    
                    $dataupload = $this->upload->data();
                    $sts_respon = "sukses";
                    $msg        = $dataupload['file_name']." berhasil diupload";     
    
                    $data = ['id_asuransi'  => $asuransi,
                            'id_lob'        => $lob,
                            'premi'         => $premi,
                            'logo_premi'    => $dataupload['file_name'],
                            'add_time'      => date("Y-m-d H:i:s", now('Asia/Jakarta')),
                            'add_by'        => $this->sesi_id
                            ];
    
                    $this->M_produk_asuransi->input_data('tr_produk_asuransi', $data); 
                    $id_tr = $this->db->insert_id();
    
                    $kode = $sing['singkatan'].$lob.$id_tr;
    
                    $this->M_produk_asuransi->ubah_data('tr_produk_asuransi', ['kode_produk_asuransi' => $kode], ['id_tr_produk_asuransi' => $id_tr]);
                     
                }
                
            } else {

                echo json_encode(['status' => 'gagal']);
                exit();

            }
            

        } elseif ($aksi == 'Hapus') {

            $path = $this->url_up."produk/".$image;
            unlink($path); 

            $this->M_produk_asuransi->hapus_data('tr_produk_asuransi', ['id_tr_produk_asuransi' => $id_produk_asuransi]);

            $sts_respon = 'success';

        } elseif ($aksi == 'Ubah') {

            $file = $_FILES['image']['tmp_name'];

            $inputan = ['id_asuransi'   => $asuransi,
                        'id_lob'        => $lob,
                        'premi'         => $premi
                        ];
            
            $cek = cek_duplicate_banyak('tr_produk_asuransi', 'id_tr_produk_asuransi', $id_produk_asuransi, $inputan);

            if ($file) {

                if ($cek == 0) {

                    if ( ! $this->upload->do_upload('image')) {

                        $sts_respon = "error";
                        $msg        = $this->upload->display_errors();
            
                    } else {

                        $path = $this->url_up."produk/".$image;
                        unlink($path); 

                        $dataupload = $this->upload->data();
                        $sts_respon = "sukses";
                        $msg    = $dataupload['file_name']." berhasil diupload";     

                        $data = ['id_asuransi'      => $asuransi,
                                'id_lob'           => $lob,
                                'premi'            => $premi,
                                'logo_premi'       => $dataupload['file_name'],
                                'updated_time'     => date("Y-m-d H:i:s", now('Asia/Jakarta')),
                                'updated_by'       => $this->sesi_id
                                ];

                        $this->M_produk_asuransi->ubah_data('tr_produk_asuransi', $data, ['id_tr_produk_asuransi' => $id_produk_asuransi]);

                    }

                } else {

                    echo json_encode(['status' => 'gagal']);
                    exit();

                }

            } else {

                if ($cek == 0) {

                    $data = ['id_asuransi'      => $asuransi,
                             'id_lob'           => $lob,
                             'premi'            => $premi,
                             'updated_time'     => date("Y-m-d H:i:s", now('Asia/Jakarta')),
                             'updated_by'       => $this->sesi_id
                            ];

                    $this->M_produk_asuransi->ubah_data('tr_produk_asuransi', $data, ['id_tr_produk_asuransi' => $id_produk_asuransi]);

                    $sts_respon = "sukses";
                    
                } else {

                    echo json_encode(['status' => 'gagal']);
                    exit();

                }
                
            }
            
        }

        echo json_encode(['status' => $sts_respon]);
    }

}

/* End of file Produk_asuransi.php */
