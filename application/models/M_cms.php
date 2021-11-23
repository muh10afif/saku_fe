<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_cms extends CI_Model {

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

    // 06-09-2021
    public function get_news($offset, $limit)
    {
        return $this->db->get('m_news', $limit, $offset);
    }

    // 09-09-2021
    public function cari_pro_asuransi($id_lob)
    {
        $this->db->select('ma.nama_asuransi, ma.id_asuransi');
        $this->db->from('tr_produk_asuransi tpa');
        $this->db->join('m_asuransi ma', 'ma.id_asuransi = tpa.id_asuransi', 'inner');
        $this->db->where('tpa.id_lob', $id_lob);
        $this->db->group_by('ma.nama_asuransi');
        $this->db->group_by('ma.id_asuransi');
        
        return $this->db->get();
    }

    public function cari_isi_pro_as($id_asuransi, $id_lob)
    {
        $this->db->select('tpa.*, ml.lob, ma.nama_asuransi');
        $this->db->from('tr_produk_asuransi tpa');
        $this->db->join('m_asuransi ma', 'ma.id_asuransi = tpa.id_asuransi', 'inner');
        $this->db->join('m_lob ml', 'ml.id_lob = tpa.id_lob ', 'inner');
        $this->db->where('tpa.id_lob', $id_lob);
        $this->db->where('ma.id_asuransi', $id_asuransi);
        
        return $this->db->get();
    }

}

/* End of file M_home.php */
