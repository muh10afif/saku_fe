<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_news extends CI_Model {

    public function cari_data($tabel, $where)
    {
        return $this->db->get_where($tabel, $where);
    }

    public function cari_data_order($tabel, $where, $field, $order)
    {
        $this->db->order_by($field, $order);

        return $this->db->get_where($tabel, $where);
    }

    public function get_data_order($tabel, $field, $order)
    {
        $this->db->order_by($field, $order);
        
        return $this->db->get($tabel);
    }

    public function get_data($tabel)
    {
        return $this->db->get($tabel);
    }

    public function input_data($tabel, $data)
    {
        $this->db->insert($tabel, $data);
    }

    public function ubah_data($tabel, $data, $where)
    {
        return $this->db->update($tabel, $data, $where);
    }

    public function hapus_data($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    // 24-08-2021
    // Menampilkan list news
    public function get_data_news()
    {
        $this->_get_datatables_query_news();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_news = [null, 'LOWER(title)', 'LOWER(news)', 'LOWER(images)', 'LOWER(sumber)', 'LOWER(editor)', 'CAST(active as VARCHAR)'];
    var $kolom_cari_news  = ['LOWER(title)', 'LOWER(news)', 'LOWER(images)', 'LOWER(sumber)', 'LOWER(editor)', 'CAST(active as VARCHAR)'];
    var $order_news       = ['id' => 'desc'];

    public function _get_datatables_query_news()
    {
        $this->db->from('m_news');
    
        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_news;

        foreach ($kolom_cari as $cari) {
            if ($input_cari) {
                if ($b === 0) {
                    $this->db->group_start();
                    $this->db->like($cari, $input_cari);
                } else {
                    $this->db->or_like($cari, $input_cari);
                }

                if ((count($kolom_cari) - 1) == $b ) {
                    $this->db->group_end();
                }
            }

            $b++;
        }

        if (isset($_POST['order'])) {

            $kolom_order = $this->kolom_order_news;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_news)) {
            
            $order = $this->order_news;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_news()
    {
        $this->db->from('m_news');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_news()
    {
        $this->_get_datatables_query_news();

        return $this->db->get()->num_rows();
        
    }

}

/* End of file M_news.php */
