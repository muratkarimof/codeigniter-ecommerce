<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_status extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Order_status_model', 'order_status_md');

    }

    public function index()
    {
        $data['title'] = 'Order Status List';

        $data['lists'] = $this->order_status_md->select_all();

        $this->load->admin('order_status/index', $data);
    }

    public function create()
    {

        if ($this->input->post()) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('title', 'Title', 'required');

            $this->form_validation->set_message('required', 'Boş buraxıla bilməz');

            if ($this->form_validation->run()) {

                $request_data = [
                    'title' => $this->security->xss_clean($this->input->post('title')),
                    'status' => ($this->input->post('status') == 1) ? 1 : 0
                ];

                $insert_id = $this->order_status_md->insert($request_data);

                if ($insert_id > 0) {
                    $this->session->set_flashdata('success_message', 'Məlumat uğurla əlavə edildi');
                } else {
                    $this->session->set_flashdata('error_message', 'Yükləmə işləmi baş tutmadı');
                }
            }
        }

        $data['title'] = 'Create Order Status';

        $this->load->admin('order_status/create', $data);

    }

    public function edit($id)
    {

        if ($this->input->post()) {
            $id = $this->security->xss_clean($id);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('title', 'Title', 'required');

            $this->form_validation->set_message('required', 'Boş buraxıla bilməz');

            if ($this->form_validation->run()) {

                $request_data = [
                    'title' => $this->security->xss_clean($this->input->post('title')),
                    'status' => ($this->input->post('status') == 1) ? 1 : 0
                ];

                $affected_rows = $this->order_status_md->update($id, $request_data);

                if ($affected_rows > 0) {
                    $this->session->set_flashdata('success_message', 'Məlumat uğurla dəyişdirildi');

                    redirect('backend/order_status/edit/' . $id);
                } else {
                    $this->session->set_flashdata('error_message', 'Dəyişdirmə uğursuz oldu');
                    redirect('backend/order_status/edit/' . $id);
                }
            }
        }

        $item = $this->order_status_md->selectDataById($id);

        if (empty($item)) {
            $this->session->set_flashdata('error_message', 'Bu məlumat tapılmadı');

            redirect('backend/order_status_md');
        }

        $data['item'] = $item;

        $data['title'] = 'Edit Order Status';

        $this->load->admin('order_status/edit', $data);

    }


    public function delete($id)
    {
        $id = $this->security->xss_clean($id);
        $item = $this->order_status_md->delete($id);

        if ($item > 0) {
            $this->session->set_flashdata('success_message', 'Uğurlu şəkildə silindi');
        } else {
            $this->session->set_flashdata('error_message', 'Silinmə zamanı xəta baş verdi');
        }

        redirect('backend/order_status');
    }

}