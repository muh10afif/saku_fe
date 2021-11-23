<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_manfaat extends CI_Model {

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
    // Menampilkan list manfaat
    public function get_data_manfaat()
    {
        $this->_get_datatables_query_manfaat();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_manfaat = [null, 'LOWER(t.nama_asuransi)', 'LOWER(l.lob)', 'CAST(r.premi as VARCHAR)', 'LOWER(s.manfaat)', 'CAST(s.nilai as VARCHAR)', 'LOWER(s.keterangan)'];
    var $kolom_cari_manfaat  = ['LOWER(t.nama_asuransi)', 'LOWER(l.lob)', 'CAST(r.premi as VARCHAR)', 'LOWER(s.manfaat)', 'CAST(s.nilai as VARCHAR)', 'LOWER(s.keterangan)'];
    var $order_manfaat       = ['s.id' => 'desc'];

    public function _get_datatables_query_manfaat()
    {
        $this->db->select('s.*, s.id as id_manfaat, t.nama_asuransi, l.lob, r.id_asuransi, r.id_lob, r.id_tr_produk_asuransi, r.premi');
        $this->db->from('m_manfaat as s');
        $this->db->join('tr_produk_asuransi as r', 'r.id_tr_produk_asuransi = s.id_produk_asuransi', 'inner');
        $this->db->join('m_asuransi as t', 't.id_asuransi = r.id_asuransi', 'inner');
        $this->db->join('m_lob as l', 'l.id_lob = r.id_lob', 'inner');

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_manfaat;

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

            $kolom_order = $this->kolom_order_manfaat;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_manfaat)) {
            
            $order = $this->order_manfaat;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_manfaat()
    {
        $this->db->select('s.*, s.id as id_manfaat, t.nama_asuransi, l.lob, r.id_asuransi, r.id_lob, r.id_tr_produk_asuransi, r.premi');
        $this->db->from('m_manfaat as s');
        $this->db->join('tr_produk_asuransi as r', 'r.id_tr_produk_asuransi = s.id_produk_asuransi', 'inner');
        $this->db->join('m_asuransi as t', 't.id_asuransi = r.id_asuransi', 'inner');
        $this->db->join('m_lob as l', 'l.id_lob = r.id_lob', 'inner');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_manfaat()
    {
        $this->_get_datatables_query_manfaat();

        return $this->db->get()->num_rows();
        
    }

}

/* End of file M_manfaat.php */
