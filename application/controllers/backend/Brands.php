<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Brands extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Brands_model', 'brands_md');

    }

    public function index()
    {
        $data['title'] = 'Brands List';

        $data['lists'] = $this->brands_md->select_all();

        $this->load->admin('brands/index', $data);
    }

    public function create()
    {

        if ($this->input->post()) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('title', 'Title', 'required');

            $this->form_validation->set_message('required', 'Boş keçilə bilməz');

            if ($this->form_validation->run()) {

                $path = 'uploads/brand_icon/';

                if (!file_exists("uploads")) {
                    mkdir("uploads");
                }
                if (!file_exists($path)) {
                    mkdir($path);
                }

                $config['upload_path'] = $path;
                $config['allowed_types'] = 'gif|jpg|png';
                $config['overwrite'] = 'false';

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('logo')) {

                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('error_message', $error);

                } else {

                    $file_data = $this->upload->data();
                    $request_data = [
                        'title' => $this->security->xss_clean($this->input->post('title')),
                        'status' => ($this->input->post('status') == 1) ? 1 : 0,
                        'logo' => $path . $file_data['file_name']
                    ];

                    $insert_id = $this->brands_md->insert($request_data);

                    if ($insert_id > 0) {
                        $this->session->set_flashdata('success_message', 'Məlumat uğurla əlavə edildi');
                    } else {
                        if (file_exists($request_data['logo'])) {
                            unlink($request_data['logo']);
                        }
                        $this->session->set_flashdata('error_message', 'Yükləmə işləmi baş tutmadı');
                    }
                }
            }
        }

        $data['title'] = 'Create Brand';

        $this->load->admin('brands/create', $data);

    }

    public function edit($id)
    {

        $unlink = 0;

        if ($this->input->post()) {
            $id = $this->security->xss_clean($id);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('title', 'Title', 'required');

            $this->form_validation->set_message('required', 'Boş keçilə bilməz');

            if ($this->form_validation->run()) {


                $request_data = [
                    'title' => $this->security->xss_clean($this->input->post('title')),
                    'status' => ($this->input->post('status') == 1) ? 1 : 0
                ];

                if ($_FILES["logo"]["tmp_name"]) {

                    $path = 'uploads/brand_icon/';
                    $config['upload_path'] = $path;
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['overwrite'] = 'false';


                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('logo')) {

                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('error_message', $error);

                    } else {

                        $file_data = $this->upload->data();
                        $request_data['logo'] = $path . $file_data['file_name'];
                        $unlink++;
                    }
                }


                $img = $this->input->post('img');

                $affected_rows = $this->brands_md->update($id, $request_data);

                if ($affected_rows > 0) {
                    $this->session->set_flashdata('success_message', 'Məlumat uğurla dəyişdirildi');

                    if ($unlink > 0 and file_exists($img)) {
                        unlink($img);
                    }

                    redirect('backend/brands/edit/' . $id);
                } else {
                    $this->session->set_flashdata('error_message', 'Dəyişdirmə uğursuz oldu');
                    redirect('backend/brands/edit/' . $id);
                }
            }
        }


        $item = $this->brands_md->selectDataById($id);

        if (empty($item)) {
            $this->session->set_flashdata('error_message', 'Bu məlumat tapılmadı');

            redirect('backend/brands');
        }

        $data['item'] = $item;

        $data['title'] = 'Edit Brand ';

        $this->load->admin('brands/edit', $data);

    }


    public function delete($id)
    {
        $id = $this->security->xss_clean($id);

        $select = $this->brands_md->selectDataById($id);
        $logo = $select->logo;

        $item = $this->brands_md->delete($id);

        if ($item > 0) {
            if (file_exists($logo)) {
                unlink($logo);
            }
            $this->session->set_flashdata('success_message', 'Uğurlu şəkildə silindi');
        } else {
            $this->session->set_flashdata('error_message', 'Silinmə zamanı xəta baş verdi');
        }

        redirect('backend/brands');
    }

}