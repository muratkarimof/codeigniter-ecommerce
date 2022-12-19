<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categories extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Category_model', 'categories_md');

    }

    public function index()
    {
        $data['title'] = 'Categories List';

        $data['lists'] = $this->categories_md->select_all();

        $this->load->admin('categories/index', $data);
    }

    public function create()
    {

        if ($this->input->post()) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('title', 'Title', 'required');

            $this->form_validation->set_message('required', 'Boş buraxıla bilməz');

            if ($this->form_validation->run()) {

                $parentcategory = $this->security->xss_clean($this->input->post('parentcategory'));

                $item = $this->categories_md->selectActiveDataById($parentcategory);

                if (empty($item)){
                    $parentcategory = null;
                }

                $request_data = [
                    'title' => $this->security->xss_clean($this->input->post('title')),
                    'parent_id' => $parentcategory,
                    'status' => ($this->input->post('status') == 1) ? 1 : 0
                ];

                $insert_id  = $this->categories_md->insert($request_data);

                if ($insert_id > 0) {
                    $this->session->set_flashdata('success_message', 'Məlumat uğurla əlavə edildi');
                    redirect('backend/categories/create');
                } else {
                    $this->session->set_flashdata('error_message', 'Yükləmə işləmi baş tutmadı');
                }
            }
        }

        $data['title'] = 'Categories List';
        $data['lists'] = $this->categories_md->select_all_active();

        $this->load->admin('categories/create', $data);
    }

    public function edit($id)
    {

        if ($this->input->post()) {
            $id = $this->security->xss_clean($id);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('title', 'Title', 'required');

            $this->form_validation->set_message('required', 'Boş buraxıla bilməz');

            if ($this->form_validation->run()) {

                $parentcategory = $this->security->xss_clean($this->input->post('parentcategory'));

                $item = $this->categories_md->selectActiveDataById($parentcategory);

                if (empty($item)){
                    $parentcategory = null;
                }

                $request_data = [
                    'title' => $this->security->xss_clean($this->input->post('title')),
                    'parent_id' => $parentcategory,
                    'status' => ($this->input->post('status') == 1) ? 1 : 0
                ];


                $affected_rows = $this->categories_md->update($id, $request_data);

                if ($affected_rows > 0) {
                    $this->session->set_flashdata('success_message', 'Məlumat uğurla dəyişdirildi');

                    redirect('backend/categories/edit/' . $id);
                } else {
                    $this->session->set_flashdata('error_message', 'Dəyişdirmə uğursuz oldu');
                    redirect('backend/categories/edit/' . $id);
                }
            }
        }

        $item = $this->categories_md->selectDataById($id);

        if (empty($item)) {
            $this->session->set_flashdata('error_message', 'Bu məlumat tapılmadı');

            redirect('backend/categories');
        }

        $data['item'] = $item;

        $data['title'] = 'Categories Edit';
        $data['lists'] = $this->categories_md->selectActive_isNotId($id);

        $this->load->admin('categories/edit', $data);
    }


    public function delete($id)
    {
        $id = $this->security->xss_clean($id);
        $item = $this->categories_md->delete($id);

        if ($item > 0) {
            $this->session->set_flashdata('success_message', 'Uğurlu şəkildə silindi');
        } else {
            $this->session->set_flashdata('error_message', 'Silinmə zamanı xəta baş verdi');
        }

        redirect('backend/categories');
    }

}
