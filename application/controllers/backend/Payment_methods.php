<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment_methods extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Payment_methods_model', 'payment_md');

    }

    public function index()
    {
        $data['title'] = 'Payment methods list';

        $data['lists'] = $this->payment_md->select_all();

        $this->load->admin('payment_methods/index', $data);
    }

    public function create()
    {

        if ($this->input->post()) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('order', 'Order', 'required|numeric');

            $this->form_validation->set_message('required', 'Boş buraxıla bilməz');
            $this->form_validation->set_message('numeric', 'Yalnızca rəqəm girilə bilər');

            if ($this->form_validation->run()) {

                $request_data = [
                    'title' => $this->security->xss_clean($this->input->post('title')),
                    'order' => floor(abs($this->security->xss_clean($this->input->post('order')))),
                    'status' => ($this->input->post('status') == 1) ? 1 : 0
                ];

                $insert_id = $this->payment_md->insert($request_data);

                if ($insert_id > 0) {
                    $this->session->set_flashdata('success_message', 'Məlumat uğurla əlavə edildi');
                } else {
                    $this->session->set_flashdata('error_message', 'Yükləmə işləmi baş tutmadı');
                }
            }
        }

        $data['title'] = 'Create payment method';

        $this->load->admin('payment_methods/create', $data);

    }

    public function edit($id)
    {

        if ($this->input->post()) {
            $id = $this->security->xss_clean($id);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('order', 'Order', 'required|numeric');

            $this->form_validation->set_message('required', 'Boş buraxıla bilməz');
            $this->form_validation->set_message('numeric', 'Yalnızca rəqəm girilə bilər');

            if ($this->form_validation->run()) {

                $request_data = [
                    'title' => $this->security->xss_clean($this->input->post('title')),
                    'order' => floor(abs($this->security->xss_clean($this->input->post('order')))),
                    'status' => ($this->input->post('status') == 1) ? 1 : 0
                ];

                $affected_rows = $this->payment_md->update($id, $request_data);

                if ($affected_rows > 0) {
                    $this->session->set_flashdata('success_message', 'Məlumat uğurla dəyişdirildi');

                    redirect('backend/payment/edit/' . $id);
                } else {
                    $this->session->set_flashdata('error_message', 'Dəyişdirmə uğursuz oldu');
                    redirect('backend/payment/edit/' . $id);
                }
            }
        }

        $item = $this->payment_md->selectDataById($id);

        if (empty($item)) {
            $this->session->set_flashdata('error_message', 'Bu məlumat tapılmadı');

            redirect('backend/payment');
        }

        $data['item'] = $item;

        $data['title'] = 'Edit Payment Method';

        $this->load->admin('payment_methods/edit', $data);

    }


    public function delete($id)
    {
        $id = $this->security->xss_clean($id);
        $item = $this->payment_md->delete($id);

        if ($item > 0) {
            $this->session->set_flashdata('success_message', 'Uğurlu şəkildə silindi');
        } else {
            $this->session->set_flashdata('error_message', 'Silinmə zamanı xəta baş verdi');
        }

        redirect('backend/payment');
    }

}