<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class M_asuransi extends CI_Model
{

  function __construct() {
    parent::__construct();
  }

  public function cari_data($tabel, $where)
  {
      return $this->db->get_where($tabel, $where);
  }

  var $kolom_order_user = [null,'kode_asuransi','nama_asuransi','telp'];
  var $kolom_cari_user  = ['LOWER(kode_asuransi)','LOWER(nama_asuransi)','LOWER(telp)','LOWER(pic)'];
  var $order_user       = ['id_asuransi' => 'desc'];

  public function get_data_asuransi($value='')
  {
    $this->_get_datatables_query_asuransi();
    if ($this->input->post('length') != -1) {
      $this->db->limit($this->input->post('length'), $this->input->post('start'));
      return $this->db->get()->result_array();
    }
  }

  public function _get_datatables_query_asuransi()
  {
    $this->db->from('m_asuransi');
    $this->db->join('m_kategori_as', 'id_kategori_as', 'left');
    $this->db->join('m_tipe_as', 'id_tipe_as', 'left');

    $b = 0;
    $input_cari = strtolower($_POST['search']['value']);
    $kolom_cari = $this->kolom_cari_user;

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

    if ($_POST['order']) {
      $kolom_order = $this->kolom_order_user;
      $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } elseif (isset($this->order_user)) {
      $order = $this->order_user;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }

  public function jumlah_semua_asuransi()
  {
    $this->db->from('m_asuransi');
    $this->db->join('m_kategori_as', 'id_kategori_as', 'left');
    $this->db->join('m_tipe_as', 'id_tipe_as', 'left');
    return $this->db->count_all_results();
  }

  public function allasuransi()
  {
    $this->db->select('*');
    $this->db->join('m_kategori_as', 'id_kategori_as', 'left');
    $this->db->join('m_tipe_as', 'id_tipe_as', 'left');
    return $this->db->get('m_asuransi')->result();
  }

  public function get_data_order($tabel, $field, $order)
  {
    $this->db->order_by($field, $order);
    return $this->db->get($tabel);
  }

  public function jumlah_filter_asuransi()
  {
    $this->_get_datatables_query_asuransi();
    return $this->db->get()->num_rows();
  }
}

?>
