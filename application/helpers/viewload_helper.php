<?php

function __viewrender($viewname='',$data='')
{
	$this->load->view('include/header');
	$this->load->view($viewname,$data);
	$this->load->view('include/footer');
}