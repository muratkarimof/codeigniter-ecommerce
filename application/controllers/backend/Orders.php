<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Orders_model', 'orders_md');

    }

    public function index()
    {
        $data['title'] = 'Orders List';

        $data['lists'] = $this->orders_md->select_all();

        $this->load->admin('orders/index', $data);
    }


    public function delete($id)
    {
        $id = $this->security->xss_clean($id);
        $item = $this->orders_md->delete($id);

        if ($item > 0) {
            $this->session->set_flashdata('success_message', 'Uğurlu şəkildə silindi');
        } else {
            $this->session->set_flashdata('error_message', 'Silinmə zamanı xəta baş verdi');
        }

        redirect('backend/orders');
    }

}