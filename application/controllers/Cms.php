<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_cms');

        $url = $this->db->get('m_setting')->row_array();

        $this->url_up   = $url['url_uploads'];
        $this->url_img  = $url['url_images'];
    }

    public function index()
    {
        $data = ['title'        => 'home',
                 'cob'          => $this->M_cms->get_data_order('m_cob', 'kode_cob', 'asc')->result_array(),
                 'lob'          => $this->M_cms->get_data_order('m_lob', 'kode_lob', 'asc')->result_array(),
                 'banner'       => $this->M_cms->get_data_order('m_banner', 'id_banner', 'asc')->result_array(),
                 'home_2'       => $this->M_cms->get_news(0,2)->result_array(),
                 'home_1'       => $this->M_cms->get_news(2,2)->result_array(),
                 'muslim_hub'   => $this->M_cms->get_data_order('m_muslim_hub', 'id', 'asc')->result_array(),
                 'temukan_kami' => $this->M_cms->get_data_order('m_temukan_kami', 'id', 'asc')->result_array(),
                 'url_img'      => $this->url_img
                ];

        $this->template->load('template_fe/index', 'V_home', $data);
    }

    public function produk()
    {
        $data = ['title'        => 'produk',
                 'lob'          => $this->M_cms->get_data_order('m_lob', 'kode_lob', 'asc')->result_array(),
                 'temukan_kami' => $this->M_cms->get_data_order('m_temukan_kami', 'id', 'asc')->result_array(),
                 'rekanan_kami' => $this->M_cms->cari_data_order('m_asuransi', ['logo_asuransi !=' => null], 'id_asuransi', 'asc')->result_array(),
                 'url_img'      => $this->url_img
                ];

        $this->template->load('template_fe/index', 'V_produk', $data);
    }

    public function detail_produk($id_lob)
    {
        $data = ['title'        => 'produk',
                 'lob'          => $this->M_cms->cari_data('m_lob', ['id_lob' => $id_lob])->row_array(),
                 'pro_as'       => $this->M_cms->cari_pro_asuransi($id_lob)->result_array(),
                 'temukan_kami' => $this->M_cms->get_data_order('m_temukan_kami', 'id', 'asc')->result_array(),
                 'id_lob'       => $id_lob,
                 'url_img'      => $this->url_img
                ];

        $this->template->load('template_fe/index', 'V_detail_produk', $data);
    }

    public function detail_premi()
    {
        $id_tr_pro = $this->input->post('id_tr_pro');

        $data = ['manfaat'      => $this->M_cms->cari_data_order('m_manfaat', ['id_produk_asuransi' => $id_tr_pro], 'id', 'asc')->result_array(),
                 'syarat'       => $this->M_cms->cari_data_order('m_syarat', ['id_produk_asuransi' => $id_tr_pro], 'id', 'asc')->result_array(),
                 'kecuali_k'    => $this->db->get('m_pengecualian', 3, 0)->result_array(),
                 'kecuali'      => $this->M_cms->cari_data_order('m_pengecualian', ['id_produk_asuransi' => $id_tr_pro], 'id', 'asc')->result_array(),
                 'url_img'      => $this->url_img
                ];
        
        $this->load->view('V_detail_premi', $data);
        
    }

    // 09-09-2021
    public function tentang_kami()
    {
        $data = ['title'        => 'tentang_kami',
                 'tentang'      => $this->M_cms->get_data('m_tentang_kami')->row_array(),
                 'temukan_kami' => $this->M_cms->get_data_order('m_temukan_kami', 'id', 'asc')->result_array(),
                 'url_img'      => $this->url_img
                ];

        $this->template->load('template_fe/index', 'V_tentang_kami', $data);
    }
    
    // 09-09-2021
    public function berita()
    {
        $data = ['title'        => 'home',
                 'news'         => $this->M_cms->get_data_order('m_news', 'id', 'desc')->result_array(),
                 'temukan_kami' => $this->M_cms->get_data_order('m_temukan_kami', 'id', 'asc')->result_array(),
                 'url_img'      => $this->url_img
                ];

        $this->template->load('template_fe/index', 'V_berita', $data);
    }

    // 09-09-2021
    public function detail_berita($id_news)
    {
        $data = ['title'        => 'home',
                 'news'         => $this->M_cms->cari_data('m_news', ['id' => $id_news])->row_array(),
                 'temukan_kami' => $this->M_cms->get_data_order('m_temukan_kami', 'id', 'asc')->result_array(),
                 'url_img'      => $this->url_img
                ];

        $this->template->load('template_fe/index', 'V_detail_berita', $data);
    }

}

/* End of file Home.php */
