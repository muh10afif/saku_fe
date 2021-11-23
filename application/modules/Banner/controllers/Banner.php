<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_banner');
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
        $data 	= [ 'title'             => 'Banner',
                    'role'              => $this->aksi_crud,
                    'id_lvl_otorisasi'  => $this->id_lvl_otorisasi,
                    'id_user'           => $this->sesi_id,
                    'url_up'            => $this->url_img
                ];

        $this->template->load('template/index','lihat', $data);
    }

    // 27-08-2021
    public function tampil_data_banner()
    {
        $read               = $this->input->post('read');
        $create             = $this->input->post('create');
        $update             = $this->input->post('update');
        $delete             = $this->input->post('delete');
        $id_user            = $this->input->post('id_user');
        $id_lvl_otorisasi   = $this->input->post('id_lvl_otorisasi');

        if ($read == 'true' || $id_lvl_otorisasi == 0) {
            $list = $this->M_banner->get_data_banner();
        } else {
            $list = [];
        } 

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            if ($id_lvl_otorisasi == 0) {
                $a1 = "<span style='cursor:pointer' class='mr-2 text-primary ttip edit' data-toggle='tooltip' data-placement='top' title='Ubah' data-id='".$o['id_banner']."' image='".$o['images']."' detail='".$o['detail']."' aktif='".$o['active']."'><i class='fas fa-pencil-alt fa-lg'></i></span>";
                $a2 = "<span style='cursor:pointer' class='text-danger ttip hapus' data-toggle='tooltip' data-placement='top' title='Hapus' data-id='".$o['id_banner']."' image='".$o['images']."'><i class='far fa-trash-alt fa-lg'></i></span>";
            } else {
                if ($update == 'true') {
      
                    if ($delete == 'true') {
                        $mrd = "mr-2";
                    } else {
                        $mrd = "";
                    }
      
                    $a1 = "<span style='cursor:pointer' class='$mrd text-primary ttip edit' data-toggle='tooltip' data-placement='top' title='Ubah' data-id='".$o['id_banner']."' image='".$o['images']."' detail='".$o['detail']."' aktif='".$o['active']."'><i class='fas fa-pencil-alt fa-lg'></i></span>";

                } else {
                    $a1 = "";
                }
      
                if ($delete == 'true') {
                    $a2 = "<span style='cursor:pointer' class='text-danger ttip hapus' data-toggle='tooltip' data-placement='top' title='Hapus' data-id='".$o['id_banner']."' image='".$o['images']."'><i class='far fa-trash-alt fa-lg'></i></span>";
                } else {
                    $a2 = "";
                } 
            }

            if ($o['active'] == 1) {
                $aktif = "<span class='badge badge-pill badge-primary'>Aktif</span>";
            } else {
                $aktif = "<span class='badge badge-pill badge-danger'>Tidak Aktif</span>";
            }

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = "<div align='center'><a class='' href='".$this->url_img.'banner/'.$o['images']."' title='".$o['images']."'><img src='".$this->url_img.'banner/'.$o['images']."' width='250px'></a><br>".$o['images']."</div>";
            $tbody[]    = wordwrap($o['detail'],50,"<br>\n");
            $tbody[]    = $aktif;
            $tbody[]    = $a1.$a2;
            $data[]     = $tbody;
        }

        if ($read == 'true' || $id_lvl_otorisasi == 0) {
            $recordsTotal       = $this->M_banner->jumlah_semua_banner();
            $recordsFiltered    = $this->M_banner->jumlah_filter_banner();
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

    public function tes()
    {
        // $u = $_SERVER['DOCUMENT_ROOT'];
        $u = $this->url_up;

        echo $u;
    }

    // 27-08-2021
    public function simpan_banner()
    {
        $config['upload_path']   = $this->url_up.'banner';
        $config['allowed_types'] = 'png|jpeg|jpg';   
        $config['quality']       = '60%';        

        $this->load->library('upload', $config);

        $aksi       = $this->input->post('aksi');  
        $id_banner  = $this->input->post('id_banner');  
        $image      = $this->input->post('nama_image'); 
        $detail     = $this->input->post('detail');            
        $st_aktif   = $this->input->post('status'); 

        if ($aksi == 'Hapus') {

            $path = $this->url_up."banner/".$image;
            unlink($path); 

            $this->M_banner->hapus_data('m_banner', ['id_banner' => $id_banner]);
            
            $status = 'success';
            $msg    = '';

        } elseif ($aksi == 'Tambah') {
            if ( ! $this->upload->do_upload('image')) {

                $status     = "error";
                $msg        = $this->upload->display_errors();
    
            } else {

                $dataupload = $this->upload->data();
                $status = "success";
                $msg    = $dataupload['file_name']." berhasil diupload";     

                //Compress Image
                // $config['image_library']    ='gd2';
                // $config['source_image']     = $this->url_up.'banner/'.$dataupload['file_name'];
                // $config['create_thumb']     = FALSE;
                // $config['maintain_ratio']   = FALSE;
                // $config['quality']          = '50%';

                // $config['width']            = 600;
                // $config['height']           = 400;

                // $config['new_image']        = $this->url_up.'banner/'.$dataupload['file_name'];
                // $this->load->library('image_lib', $config);
                // $this->image_lib->resize();
    
                $dt_input = ['images'       => $dataupload['file_name'],
                             'detail'       => $detail,
                             'active'       => $st_aktif,
                             'add_by'       => $this->sesi_id,
                             'add_time'     => date("Y-m-d H:i:s", now('Asia/Jakarta'))
                            ];
                
                $this->M_banner->input_data('m_banner', $dt_input);
                
            }
        } elseif ($aksi == 'Ubah') {

            $file = $_FILES['image']['tmp_name'];

            if ($file) {

                if ( ! $this->upload->do_upload('image')) {

                    $status     = "error";
                    $msg        = $this->upload->display_errors();
        
                } else {

                    $path = $this->url_up."banner/".$image;
                    unlink($path); 
                    
                    $dataupload = $this->upload->data();
                    $status     = "success";
                    $msg        = $dataupload['file_name']." berhasil diupload";    

                    // $config['image_library']    ='gd2';
                    // $config['source_image']     = $this->url_up.'banner/'.$dataupload['file_name'];
                    // $config['create_thumb']     = FALSE;
                    // $config['maintain_ratio']   = FALSE;
                    // $config['quality']          = '50%';

                    // $config['width']            = 600;
                    // $config['height']           = 400;

                    // $config['new_image']        = $this->url_up.'banner/'.$dataupload['file_name'];
                    // $this->load->library('image_lib', $config);
                    // $this->image_lib->resize();
        
                    $dt_input = ['images'           => $dataupload['file_name'],
                                 'detail'           => $detail,
                                 'active'           => $st_aktif,
                                 'updated_by'       => $this->sesi_id,
                                 'updated_time'     => date("Y-m-d H:i:s", now('Asia/Jakarta'))
                                ];
                    
                    $this->M_banner->ubah_data('m_banner', $dt_input, ['id_banner' => $id_banner]);
                    
                }
                
            } else {

                $status     = "success";
                $msg        = "";    

                $dt_input = ['detail'           => $detail,
                             'active'           => $st_aktif,
                             'updated_by'       => $this->sesi_id,
                             'updated_time'     => date("Y-m-d H:i:s", now('Asia/Jakarta'))
                            ];
                
                $this->M_banner->ubah_data('m_banner', $dt_input, ['id_banner' => $id_banner]);
                
            }
            
        }

        echo json_encode(array('status'=>$status,'msg'=>$msg));
    }
}

/* End of file Banner.php */
