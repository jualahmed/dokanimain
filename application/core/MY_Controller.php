<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
    }

    public function __renderview($viewname=FALSE,$data=FALSE)
    {
        $this->load->view('layouts/header', $data);
        $this->load->view($viewname, $data);
        $this->load->view('layouts/footer', $data);
    }

    public function __renderviewprint($viewname=FALSE,$data=FALSE)
    {
        $this->load->view('layouts/printheader', $data);
        $this->load->view($viewname, $data);
        $this->load->view('layouts/printfooter', $data);
    }
}



