<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_produk_asuransi extends CI_Model {

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
    // Menampilkan list produk_asuransi
    public function get_data_produk_asuransi()
    {
        $this->_get_datatables_query_produk_asuransi();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_produk_asuransi = [null, 'LOWER(t.nama_asuransi)', 'LOWER(l.lob)', 'CAST(s.premi as VARCHAR)', 'LOWER(s.kode_produk_asuransi)', 'LOWER(s.logo_premi)'];
    var $kolom_cari_produk_asuransi  = ['LOWER(t.nama_asuransi)', 'LOWER(l.lob)', 'CAST(s.premi as VARCHAR)', 'LOWER(s.kode_produk_asuransi)',  'LOWER(s.logo_premi)'];
    var $order_produk_asuransi       = ['s.id_tr_produk_asuransi' => 'desc'];

    public function _get_datatables_query_produk_asuransi()
    {
        $this->db->select('s.id_tr_produk_asuransi, s.id_asuransi, s.id_lob, t.nama_asuransi, l.lob, s.premi, s.kode_produk_asuransi, s.logo_premi');
        $this->db->from('tr_produk_asuransi as s');
        $this->db->join('m_asuransi as t', 't.id_asuransi = s.id_asuransi', 'inner');
        $this->db->join('m_lob as l', 'l.id_lob = s.id_lob', 'inner');
    
        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_produk_asuransi;

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

            $kolom_order = $this->kolom_order_produk_asuransi;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_produk_asuransi)) {
            
            $order = $this->order_produk_asuransi;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_produk_asuransi()
    {
        $this->db->select('s.id_tr_produk_asuransi, s.id_asuransi, s.id_lob, t.nama_asuransi, l.lob, s.premi, s.kode_produk_asuransi, s.logo_premi');
        $this->db->from('tr_produk_asuransi as s');
        $this->db->join('m_asuransi as t', 't.id_asuransi = s.id_asuransi', 'inner');
        $this->db->join('m_lob as l', 'l.id_lob = s.id_lob', 'inner');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_produk_asuransi()
    {
        $this->_get_datatables_query_produk_asuransi();

        return $this->db->get()->num_rows();
        
    }

}

/* End of file M_produk_asuransi.php */
