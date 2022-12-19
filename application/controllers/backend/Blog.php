<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Blog extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Blog_model', 'blog_md');

    }

    public function index()
    {
        $data['title'] = 'Blog List';

        $data['lists'] = $this->blog_md->select_all();

        $this->load->admin('blog/index', $data);
    }

    public function create()
    {

        if ($this->input->post()) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');

            $this->form_validation->set_message('required', 'Boş keçilə bilməz');

            if ($this->form_validation->run()) {

                $path = 'uploads/blog_image/';

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

                if (!$this->upload->do_upload('image')) {

                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('error_message', $error);

                } else {

                    $file_data = $this->upload->data();
                    $request_data = [
                        'title' => $this->security->xss_clean($this->input->post('title')),
                        'description' => $this->security->xss_clean($this->input->post('description')),
                        'status' => ($this->input->post('status') == 1) ? 1 : 0,
                        'image' => $path . $file_data['file_name']
                    ];

                    $insert_id = $this->blog_md->insert($request_data);

                    if ($insert_id > 0) {
                        $this->session->set_flashdata('success_message', 'Məlumat uğurla əlavə edildi');
                    } else {
                        if (file_exists($request_data['image'])) {
                            unlink($request_data['image']);
                        }
                        $this->session->set_flashdata('error_message', 'Yükləmə işləmi baş tutmadı');
                    }
                }
            }
        }

        $data['title'] = 'Creat blog';

        $this->load->admin('blog/create', $data);

    }

    public function edit($id)
    {

        $unlink = 0;

        if ($this->input->post()) {
            $id = $this->security->xss_clean($id);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');

            $this->form_validation->set_message('required', 'Boş keçilə bilməz');

            if ($this->form_validation->run()) {


                $request_data = [
                    'title' => $this->security->xss_clean($this->input->post('title')),
                    'description' => $this->security->xss_clean($this->input->post('description')),
                    'status' => ($this->input->post('status') == 1) ? 1 : 0
                ];

                if ($_FILES["image"]["tmp_name"]) {

                    $path = 'uploads/blog_image/';
                    $config['upload_path'] = $path;
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['overwrite'] = 'false';


                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('image')) {

                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('error_message', $error);

                    } else {

                        $file_data = $this->upload->data();
                        $request_data['image'] = $path . $file_data['file_name'];
                        $unlink++;
                    }
                }


                $img = $this->input->post('img');

                $affected_rows = $this->blog_md->update($id, $request_data);

                if ($affected_rows > 0) {
                    $this->session->set_flashdata('success_message', 'Məlumat uğurla dəyişdirildi');

                    if ($unlink > 0 and file_exists($img)) {
                        unlink($img);
                    }

                    redirect('backend/blog/edit/' . $id);
                } else {
                    $this->session->set_flashdata('error_message', 'Dəyişdirmə uğursuz oldu');
                    redirect('backend/blog/edit/' . $id);
                }
            }
        }


        $item = $this->blog_md->selectDataById($id);

        if (empty($item)) {
            $this->session->set_flashdata('error_message', 'Bu məlumat tapılmadı');

            redirect('backend/blog');
        }

        $data['item'] = $item;

        $data['title'] = 'Edit Blog ';

        $this->load->admin('blog/edit', $data);

    }


    public function delete($id)
    {
        $id = $this->security->xss_clean($id);

        $select = $this->blog_md->selectDataById($id);
        $image = $select->image;

        $item = $this->blog_md->delete($id);

        if ($item > 0) {
            if (file_exists($image)) {
                unlink($image);
            }
            $this->session->set_flashdata('success_message', 'Uğurlu şəkildə silindi');
        } else {
            $this->session->set_flashdata('error_message', 'Silinmə zamanı xəta baş verdi');
        }

        redirect('backend/blog');
    }

}