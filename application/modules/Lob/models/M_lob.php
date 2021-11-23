<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_lob extends CI_Model {

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
    // Menampilkan list lob
    public function get_data_lob()
    {
        $this->_get_datatables_query_lob();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_lob = [null, 'LOWER(s.kode_lob)', 'LOWER(s.lob)', 'LOWER(s.image)', 'LOWER(s.deskripsi)'];
    var $kolom_cari_lob  = ['LOWER(s.kode_lob)', 'LOWER(s.lob)','LOWER(s.image)', 'LOWER(s.deskripsi)'];
    var $order_lob       = ['s.id_lob' => 'desc'];

    public function _get_datatables_query_lob()
    {
        $this->db->select('s.*, s.id_lob as id');
        $this->db->from('m_lob as s');

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_lob;

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

            $kolom_order = $this->kolom_order_lob;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_lob)) {
            
            $order = $this->order_lob;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_lob()
    {
        $this->db->select('s.*, s.id_lob as id');
        $this->db->from('m_lob as s');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_lob()
    {
        $this->_get_datatables_query_lob();

        return $this->db->get()->num_rows();
        
    }

}

/* End of file M_lob.php */
