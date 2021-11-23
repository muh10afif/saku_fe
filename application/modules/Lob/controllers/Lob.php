<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class LOB extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_lob');
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
        $data 	= [ 'title'             => 'Line of Business',
                    'role'              => $this->aksi_crud,
                    'id_lvl_otorisasi'  => $this->id_lvl_otorisasi,
                    'id_user'           => $this->sesi_id,
                    'kode_lob'          => $this->lob_kode(),
                    'url_img'            => $this->url_img
                ];

        $this->template->load('template/index','lihat', $data);
    }

    public function lob_kode($value='')
    {
        $kode = codegenerate('m_lob','LOB','lob','B');
        return $kode;
    }

    // 06-09-2021
    public function tampil_data_lob()
    {
        $read               = $this->input->post('read');
        $create             = $this->input->post('create');
        $update             = $this->input->post('update');
        $delete             = $this->input->post('delete');
        $id_user            = $this->input->post('id_user');
        $id_lvl_otorisasi   = $this->input->post('id_lvl_otorisasi');

        if ($read == 'true' || $id_lvl_otorisasi == 0) {
            $list = $this->M_lob->get_data_lob();
        } else {
            $list = [];
        } 

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            if ($id_lvl_otorisasi == 0) {
                $a1 = "<span style='cursor:pointer' class='mr-2 text-primary ttip edit' data-toggle='tooltip' data-placement='top' title='Ubah' data-id='".$o['id']."' kode_lob='".$o['kode_lob']."' lob='".$o['lob']."' deskripsi='".$o['deskripsi']."' image='".$o['image']."'><i class='fas fa-pencil-alt fa-lg'></i></span>";
                $a2 = "<span style='cursor:pointer' class='text-danger ttip hapus' data-toggle='tooltip' data-placement='top' title='Hapus' data-id='".$o['id']."' ><i class='far fa-trash-alt fa-lg'></i></span>";
            } else {
                if ($update == 'true') {
      
                    if ($delete == 'true') {
                        $mrd = "mr-2";
                    } else {
                        $mrd = "";
                    }
      
                    $a1 = "<span style='cursor:pointer' class='$mrd text-primary ttip edit' data-toggle='tooltip' data-placement='top' title='Ubah' data-id='".$o['id']."' kode_lob='".$o['kode_lob']."' lob='".$o['lob']."' deskripsi='".$o['deskripsi']."' image='".$o['image']."'><i class='fas fa-pencil-alt fa-lg'></i></span>";

                } else {
                    $a1 = "";
                }
      
                if ($delete == 'true') {
                    $a2 = "<span style='cursor:pointer' class='text-danger ttip hapus' data-toggle='tooltip' data-placement='top' title='Hapus' data-id='".$o['id']."' ><i class='far fa-trash-alt fa-lg'></i></span>";
                } else {
                    $a2 = "";
                } 
            }

            $image = '';

            if ($o['image'] != '') {
                $image = "<div align='center'><a class='' href='".$this->url_img.'produk/'.$o['image']."' title='".$o['image']."'><img src='".$this->url_img.'produk/'.$o['image']."' width='150px'></a><br>".$o['image']."</div>";
            }

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['kode_lob'];
            $tbody[]    = $o['lob'];
            $tbody[]    = wordwrap($o['deskripsi'],50,"<br>\n");
            $tbody[]    = $image;
            $tbody[]    = $a1.$a2;
            $data[]     = $tbody;
        }

        if ($read == 'true' || $id_lvl_otorisasi == 0) {
            $recordsTotal       = $this->M_lob->jumlah_semua_lob();
            $recordsFiltered    = $this->M_lob->jumlah_filter_lob();
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
    public function simpan_lob()
    {
        $id_lob     = $this->input->post('id_lob');        
        $aksi       = $this->input->post('aksi');        
        $lob        = $this->input->post('lob');          
        $kode_lob   = $this->input->post('kode_lob');          
        $deskripsi  = $this->input->post('deskripsi');          
        
        $config['upload_path']      = $this->url_up.'produk';
        $config['allowed_types']    = 'PNG|png|jpeg|jpg'; 

        $this->load->library('upload', $config);

        if ($aksi == 'Tambah') {

            $inputan = ['LOWER(lob)'    => $lob];
            
            $cek = cek_duplicate_banyak('m_lob', '', '', $inputan);

            if ($cek == 0) {

                if ( ! $this->upload->do_upload('image')) {

                    $status     = "error";
                    $msg        = $this->upload->display_errors();

                    echo json_encode(['status' => 'tipe_salah']);
                    exit();
        
                } else {
                    
                    $dataupload = $this->upload->data();

                    $status = "success";
                    $msg    = $dataupload['file_name']." berhasil diupload";     
        
                    $data = ['kode_lob' => $kode_lob,
                             'lob'      => $lob,
                             'deskripsi'=> $deskripsi,
                             'image'    => $dataupload['file_name'],
                             'add_time' => date("Y-m-d H:i:s", now('Asia/Jakarta')),
                             'add_by'   => $this->sesi_id
                            ];

                    $this->M_lob->input_data('m_lob', $data); 
                    
                }

            } else {

                echo json_encode(['status' => 'gagal']);
                exit();

            }

        } elseif ($aksi == 'Hapus') {

            $cari = $this->M_lob->cari_data('m_lob', ['id_lob' => $id_lob])->row_array();

            $path = $this->url_up."produk/".$cari['image'];
            unlink($path); 

            $this->M_lob->hapus_data('m_lob', ['id_lob' => $id_lob]);

        } elseif ($aksi == 'Ubah') {

            $inputan = ['LOWER(lob)'   => $lob];
            
            $cek = cek_duplicate_banyak('m_lob', 'id_lob', $id_lob, $inputan);

            if ($cek == 0) {

                $file = $_FILES['image']['tmp_name'];

                if ($file) {

                    if ( ! $this->upload->do_upload('image')) {

                        $status     = "error";
                        $msg        = $this->upload->display_errors();

                        echo json_encode(['status' => 'tipe_salah']);
                        exit();
            
                    } else {

                        $cari = $this->M_lob->cari_data('m_lob', ['id_lob' => $id_lob])->row_array();

                        $path = $this->url_up."produk/".$cari['image'];
                        unlink($path);
                        
                        $dataupload = $this->upload->data();
    
                        $status = "success";
                        $msg    = $dataupload['file_name']." berhasil diupload";     
            
                        $data = ['kode_lob'     => $kode_lob,
                                 'lob'          => $lob,
                                 'deskripsi'    => $deskripsi,
                                 'image'        => $dataupload['file_name'],
                                 'updated_time' => date("Y-m-d H:i:s", now('Asia/Jakarta')),
                                 'updated_by'   => $this->sesi_id
                                ];
    
                        $this->M_lob->ubah_data('m_lob', $data, ['id_lob' => $id_lob]); 
                        
                    }
                                        
                } else {

                    $data = ['kode_lob'     => $kode_lob,
                             'lob'          => $lob,
                             'deskripsi'    => $deskripsi,
                             'updated_time' => date("Y-m-d H:i:s", now('Asia/Jakarta')),
                             'updated_by'   => $this->sesi_id
                        ];

                    $this->M_lob->ubah_data('m_lob', $data, ['id_lob' => $id_lob]); 
                    
                }

            } else {

                echo json_encode(['status' => 'gagal']);
                exit();

            }
            
        }

        echo json_encode(['status' => 'sukses', 'kode_lob' => $this->lob_kode()]);
    }

}

/* End of file Payment Method.php */
