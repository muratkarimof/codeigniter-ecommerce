<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 
class MY_Loader extends CI_Loader
{
    public function admin($template_name, $vars = array(), $return = FALSE)
    {
        $sidebar = $this->view('backend/template/header',  $vars, $return); // default sidebar
        $header  = $this->view('backend/template/sidebar',   $vars, $return); // default header
        $content = $this->view('backend/' . $template_name, $vars, $return); // view as controller
        $footer  = $this->view('backend/template/footer',   $vars, $return); // default footer

        if ($return)
        {
            return $sidebar; // default sidebar
            return $header;  // default header
            return $content; // view as controller
            return $footer;  // default footer
        }
    }

    public function front($template_name, $vars = array(), $return = FALSE)
    {
   		// $this->model('Users_model','settings');
        // $user_id = $_SESSION['id'];
        // $img = $CI->users_model->getUserByID($user_id);
        // $data['user'] = ['image' => $img];

        $header  = $this->view('front/template/header',   $vars, $return); // default header
        $content = $this->view('front/' . $template_name, $vars, $return); // view as controller
        $footer  = $this->view('front/template/footer',   $vars, $return); // default footer

        if ($return)
        {
            return $header;  // default header
            return $content; // view as controller
            return $footer;  // default footer
        }
    }

    public function main($template = array(), $vars = array(), $return = FALSE)
    {
        $header = $this->view('front/template/header', $vars, $return); // default header

        foreach ($template as $value)
        {
            $this->view('front/' . $value, $vars, $return);
        }

        // $content  = $this->view('front/' . $template_name, $vars, $return); // view as controller
        $footer   = $this->view('front/template/footer',   $vars, $return); // default footer

        if ($return)
        {
            return $header;  // default header
            return $content; // view as controller
            return $footer;  // default footer
        }
    }
}