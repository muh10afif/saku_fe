<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

  public function __construct() {
		parent::__construct();
    $this->load->model('M_data_show', 'data_show');
    $this->load->model('cob_lob/M_cob', 'cob');
		if($this->session->userdata('username') == "") {
      redirect(base_url(), 'refresh');
    }
	}

  public function index() {
    $vmv = [
      'visi'  => $this->data_show->visi(),
      'misi'  => $this->data_show->misi(),
      'value' => $this->data_show->value()
    ];
    $data 	= [
      'title'    => 'Dashboard',
      'introduc' => $this->data_show->introduction(),
      'vvm'      => $vmv,
      'mngmt'    => $this->data_show->management(),
      'prodct'   => $this->cob->list_cob()
    ];
    $this->template->load('template/index','dashboard', $data);
  }

}
?>
