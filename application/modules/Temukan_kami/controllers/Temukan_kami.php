<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Temukan_kami extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_temukan_kami');
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
        $data 	= [ 'title'             => 'Temukan Kami',
                    'role'              => $this->aksi_crud,
                    'id_lvl_otorisasi'  => $this->id_lvl_otorisasi,
                    'id_user'           => $this->sesi_id,
                    'url_img'            => $this->url_img
                ];

        $this->template->load('template/index','lihat', $data);
    }

    // 06-09-2021
    public function tampil_data_temukan_kami()
    {
        $read               = $this->input->post('read');
        $create             = $this->input->post('create');
        $update             = $this->input->post('update');
        $delete             = $this->input->post('delete');
        $id_user            = $this->input->post('id_user');
        $id_lvl_otorisasi   = $this->input->post('id_lvl_otorisasi');

        if ($read == 'true' || $id_lvl_otorisasi == 0) {
            $list = $this->M_temukan_kami->get_data_temukan_kami();
        } else {
            $list = [];
        } 

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            if ($id_lvl_otorisasi == 0) {
                $a1 = "<span style='cursor:pointer' class='mr-2 text-primary ttip edit' data-toggle='tooltip' data-placement='top' title='Ubah' data-id='".$o['id']."' nama='".$o['nama']."' sosmed='".$o['sosmed']."' isi='".$o['isi']."' image='".$o['image']."'><i class='fas fa-pencil-alt fa-lg'></i></span>";
                $a2 = "<span style='cursor:pointer' class='text-danger ttip hapus' data-toggle='tooltip' data-placement='top' title='Hapus' data-id='".$o['id']."' ><i class='far fa-trash-alt fa-lg'></i></span>";
            } else {
                if ($update == 'true') {
      
                    if ($delete == 'true') {
                        $mrd = "mr-2";
                    } else {
                        $mrd = "";
                    }
      
                    $a1 = "<span style='cursor:pointer' class='$mrd text-primary ttip edit' data-toggle='tooltip' data-placement='top' title='Ubah' data-id='".$o['id']."' nama='".$o['nama']."' sosmed='".$o['sosmed']."' isi='".$o['isi']."' image='".$o['image']."'><i class='fas fa-pencil-alt fa-lg'></i></span>";

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
                $image = "<div align='center'><a class='' href='".$this->url_img.'logo/'.$o['image']."' title='".$o['image']."'><img src='".$this->url_img.'logo/'.$o['image']."' width='150px'></a><br>".$o['image']."</div>";
            }

            if ($o['sosmed'] == 1) {
                $sosmed = "<span class='badge badge-pill badge-primary'>Ya</span>";
            } else {
                $sosmed = "<span class=''>-</span>";
            }

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['nama'];
            $tbody[]    = $o['isi'];
            $tbody[]    = $image;
            $tbody[]    = $sosmed;
            $tbody[]    = $a1.$a2;
            $data[]     = $tbody;
        }

        if ($read == 'true' || $id_lvl_otorisasi == 0) {
            $recordsTotal       = $this->M_temukan_kami->jumlah_semua_temukan_kami();
            $recordsFiltered    = $this->M_temukan_kami->jumlah_filter_temukan_kami();
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
    public function simpan_temukan_kami()
    {
        $id_temukan_kami    = $this->input->post('id_temukan_kami');        
        $aksi               = $this->input->post('aksi');        
        $nama               = $this->input->post('nama');          
        $isi                = $this->input->post('isi');          
        $sosmed             = $this->input->post('sosmed');          
        
        $config['upload_path']      = $this->url_up.'logo';
        $config['allowed_types']    = 'PNG|png|jpeg|jpg'; 

        $this->load->library('upload', $config);

        if ($aksi == 'Tambah') {

            $inputan = ['LOWER(nama)'   => $nama];
            
            $cek = cek_duplicate_banyak('m_temukan_kami', '', '', $inputan);

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
        
                    $data = ['nama'     => $nama,
                             'isi'      => $isi,
                             'sosmed'   => $sosmed,
                             'image'    => $dataupload['file_name'],
                             'add_time' => date("Y-m-d H:i:s", now('Asia/Jakarta')),
                             'add_by'   => $this->sesi_id
                            ];

                    $this->M_temukan_kami->input_data('m_temukan_kami', $data); 
                    
                }

            } else {

                echo json_encode(['status' => 'gagal']);
                exit();

            }

        } elseif ($aksi == 'Hapus') {

            $cari = $this->M_temukan_kami->cari_data('m_temukan_kami', ['id' => $id_temukan_kami])->row_array();

            $path = $this->url_up."logo/".$cari['image'];
            unlink($path); 

            $this->M_temukan_kami->hapus_data('m_temukan_kami', ['id' => $id_temukan_kami]);

        } elseif ($aksi == 'Ubah') {

            $inputan = ['LOWER(nama)'   => $nama];
            
            $cek = cek_duplicate_banyak('m_temukan_kami', 'id', $id_temukan_kami, $inputan);

            if ($cek == 0) {

                $file = $_FILES['image']['tmp_name'];

                if ($file) {

                    if ( ! $this->upload->do_upload('image')) {

                        $status     = "error";
                        $msg        = $this->upload->display_errors();

                        echo json_encode(['status' => 'tipe_salah']);
                        exit();
            
                    } else {

                        $cari = $this->M_temukan_kami->cari_data('m_temukan_kami', ['id' => $id_temukan_kami])->row_array();

                        $path = $this->url_up."logo/".$cari['image'];
                        unlink($path);
                        
                        $dataupload = $this->upload->data();
    
                        $status = "success";
                        $msg    = $dataupload['file_name']." berhasil diupload";     
            
                        $data = ['nama'         => $nama,
                                 'isi'          => $isi,
                                 'sosmed'       => $sosmed,
                                 'image'        => $dataupload['file_name'],
                                 'updated_time' => date("Y-m-d H:i:s", now('Asia/Jakarta')),
                                 'updated_by'   => $this->sesi_id
                                ];
    
                        $this->M_temukan_kami->ubah_data('m_temukan_kami', $data, ['id' => $id_temukan_kami]); 
                        
                    }
                                        
                } else {

                    $data = ['nama'         => $nama,
                             'isi'          => $isi,
                             'sosmed'       => $sosmed,
                             'updated_time' => date("Y-m-d H:i:s", now('Asia/Jakarta')),
                             'updated_by'   => $this->sesi_id
                        ];

                    $this->M_temukan_kami->ubah_data('m_temukan_kami', $data, ['id' => $id_temukan_kami]); 
                    
                }

            } else {

                echo json_encode(['status' => 'gagal']);
                exit();

            }
            
        }

        echo json_encode(['status' => 'sukses']);
    }

}

/* End of file Payment Method.php */
