<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_news');
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
        $data 	= [ 'title'             => 'News',
                    'role'              => $this->aksi_crud,
                    'id_lvl_otorisasi'  => $this->id_lvl_otorisasi,
                    'id_user'           => $this->sesi_id,
                    'url_img'           => $this->url_img
                ];

        $this->template->load('template/index','lihat', $data);
    }

    // 27-08-2021
    public function tampil_data_news()
    {
        $read               = $this->input->post('read');
        $create             = $this->input->post('create');
        $update             = $this->input->post('update');
        $delete             = $this->input->post('delete');
        $id_user            = $this->input->post('id_user');
        $id_lvl_otorisasi   = $this->input->post('id_lvl_otorisasi');

        if ($read == 'true' || $id_lvl_otorisasi == 0) {
            $list = $this->M_news->get_data_news();
        } else {
            $list = [];
        } 

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $news = str_replace("'","999", $o['news']);
            
            $a0 = "<span style='cursor:pointer' class='mr-2 text-dark detail ttip' data-toggle='tooltip' data-placement='top' title='Detail' data-id='".$o['id']."'><i class='fas fa-info-circle fa-lg'></i></span>";

            if ($id_lvl_otorisasi == 0) {
                $a1 = "<span style='cursor:pointer' class='mr-2 text-primary ttip edit' data-toggle='tooltip' data-placement='top' title='Ubah' data-id='".$o['id']."' judul='".$o['title']."' news='".$news."' images='".$o['images']."' sumber='".$o['sumber']."' editor='".$o['editor']."' active='".$o['active']."'><i class='fas fa-pencil-alt fa-lg'></i></span>";
                $a2 = "<span style='cursor:pointer' class='text-danger ttip hapus' data-toggle='tooltip' data-placement='top' title='Hapus' data-id='".$o['id']."' image='".$o['images']."'><i class='far fa-trash-alt fa-lg'></i></span>";
            } else {
                if ($update == 'true') {
      
                    if ($delete == 'true') {
                        $mrd = "mr-2";
                    } else {
                        $mrd = "";
                    }
      
                    $a1 = "<span style='cursor:pointer' class='$mrd text-primary ttip edit' data-toggle='tooltip' data-placement='top' title='Ubah' data-id='".$o['id']."' judul='".$o['title']."' news='".$o['news']."' images='".$o['images']."' sumber='".$o['sumber']."' editor='".$o['editor']."' active='".$o['active']."'><i class='fas fa-pencil-alt fa-lg'></i></span>";

                } else {
                    $a1 = "";
                }
      
                if ($delete == 'true') {
                    $a2 = "<span style='cursor:pointer' class='text-danger ttip hapus' data-toggle='tooltip' data-placement='top' title='Hapus' data-id='".$o['id']."' image='".$o['images']."'><i class='far fa-trash-alt fa-lg'></i></span>";
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
            $tbody[]    = wordwrap($o['title'],25,"<br>\n");
            // $tbody[]    = wordwrap(character_limiter($o['news'], 500),70,"<br>\n");
            $tbody[]    = wordwrap(character_limiter(strip_tags($o['news']), 500),70,"<br>\n");
            $tbody[]    = "<div align='center'><a class='' href='".$this->url_img.'news/'.$o['images']."' title='".$o['images']."'><img src='".$this->url_img.'news/'.$o['images']."' width='250px'></a><br>".character_limiter($o['images'],100)."</div>";
            $tbody[]    = wordwrap($o['sumber'],50,"<br>\n");
            $tbody[]    = word_wrap($o['editor'],50,"<br>\n");
            $tbody[]    = $aktif;
            $tbody[]    = $a0.$a1.$a2;
            $data[]     = $tbody;
        }

        if ($read == 'true' || $id_lvl_otorisasi == 0) {
            $recordsTotal       = $this->M_news->jumlah_semua_news();
            $recordsFiltered    = $this->M_news->jumlah_filter_news();
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
    public function detail_news($id_news)
    {
        $data = ['list'     => $this->M_news->cari_data('m_news', ['id' => $id_news])->row_array(),
                 'url_img'  => $this->url_img
                ];

        $this->load->view('detail_news', $data);
    }

    // 27-08-2021
    public function simpan_news()
    {
        $config['upload_path']      = $this->url_up.'news';
        $config['allowed_types']    = 'png|jpeg|jpg';          

        $this->load->library('upload', $config);

        
        $id         = $this->input->post('id_news');        
        $aksi       = $this->input->post('aksi');        
        $image      = $this->input->post('nama_image');        
        $title      = $this->input->post('title');        
        $news1      = $this->input->post('news');        
        $sumber     = $this->input->post('sumber');        
        $editor     = $this->input->post('editor');   
        
        $news       = html_entity_decode(htmlentities($news1, ENT_QUOTES, 'UTF-8'), ENT_QUOTES , 'ISO-8859-1');

        $st_aktif   = $this->input->post('status'); 

        if ($aksi == 'Hapus') {

            $path = $this->url_up."news/".$image;
            unlink($path); 

            $this->M_news->hapus_data('m_news', ['id' => $id]);
            
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
    
                $dt_input = ['title'        => $title,
                             'news'         => $news,
                             'sumber'       => $sumber,
                             'editor'       => $editor,
                             'images'       => $dataupload['file_name'],
                             'active'       => $st_aktif,
                             'add_by'       => $this->sesi_id,
                             'add_time'     => date("Y-m-d H:i:s", now('Asia/Jakarta'))
                            ];
                
                $this->M_news->input_data('m_news', $dt_input);
                
            }
        } elseif ($aksi == 'Ubah') {

            $file = $_FILES['image']['tmp_name'];

            if ($file) {

                if ( ! $this->upload->do_upload('image')) {

                    $status     = "error";
                    $msg        = $this->upload->display_errors();
        
                } else {

                    $path = $this->url_up."news/".$image;
                    unlink($path); 
                    
                    $dataupload = $this->upload->data();
                    $status     = "success";
                    $msg        = $dataupload['file_name']." berhasil diupload";    
        
                    $dt_input = ['title'        => $title,
                                 'news'         => $news,
                                 'sumber'       => $sumber,
                                 'editor'       => $editor,
                                 'images'       => $dataupload['file_name'],
                                 'active'       => $st_aktif,
                                 'updated_by'   => $this->sesi_id,
                                 'updated_time' => date("Y-m-d H:i:s", now('Asia/Jakarta'))
                                ];
                    
                    $this->M_news->ubah_data('m_news', $dt_input, ['id' => $id]);
                    
                }
                
            } else {

                $status     = "success";
                $msg        = "";    

                $dt_input = ['title'        => $title,
                             'news'         => $news,
                             'sumber'       => $sumber,
                             'editor'       => $editor,
                             'active'       => $st_aktif,
                             'updated_by'   => $this->sesi_id,
                             'updated_time' => date("Y-m-d H:i:s", now('Asia/Jakarta'))
                            ];
                
                $this->M_news->ubah_data('m_news', $dt_input, ['id' => $id]);
                
            }
            
        }

        echo json_encode(array('status'=>$status,'msg'=>$msg));
    }
}

/* End of file News.php */
