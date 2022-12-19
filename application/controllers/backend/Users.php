<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Users_model', 'user_md');

    }

    public function index()
    {
        $data['title'] = 'Users List';

        $data['lists'] = $this->user_md->select_all();

        $this->load->admin('users/index', $data);
    }


    public function active($id)
    {
        $id = $this->security->xss_clean($id);

        $affected_rows = $this->user_md->active($id);

        if ($affected_rows > 0) {
            $this->session->set_flashdata('success_message', 'Məlumat uğurla dəyişdirildi');
        } else {
            $this->session->set_flashdata('error_message', 'Dəyişdirmə uğursuz oldu');
        }

        redirect('backend/users');
    }

    public function passive($id)
    {
        $id = $this->security->xss_clean($id);

        $affected_rows = $this->user_md->passive($id);

        if ($affected_rows > 0) {
            $this->session->set_flashdata('success_message', 'Məlumat uğurla dəyişdirildi');
        } else {
            $this->session->set_flashdata('error_message', 'Dəyişdirmə uğursuz oldu');
        }

        redirect('backend/users');
    }


    public function delete($id)
    {
        $id = $this->security->xss_clean($id);
        $item = $this->user_md->delete($id);

        if ($item > 0) {
            $this->session->set_flashdata('success_message', 'Uğurlu şəkildə silindi');
        } else {
            $this->session->set_flashdata('error_message', 'Silinmə zamanı xəta baş verdi');
        }

        redirect('backend/users');
    }

}