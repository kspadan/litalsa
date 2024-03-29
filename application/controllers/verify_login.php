<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verify_Login extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('user','',TRUE);
	}
	
	function index()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div id="l_error">', '</div>');
		$this->form_validation->set_rules('username', 'usuario', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'contraseña', 'trim|required|xss_clean|callback_check_database');
		$this->form_validation->set_message('required', 'Campo obligatorio');
		$this->form_validation->set_message('check_database', 'Datos incorrectos');
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('login_view');
		}
		else
		{
			redirect('home', 'refresh');
		}
	}
	
	function check_database($password)
	{
		$username = $this->input->post('username');
		$result = $this->user->login($username, $password);
		if($result)
		{
			$sess_array = array();
			foreach($result as $row)
			{
				$sess_array = array(
				'id' => $row->id,
				'username' => $row->username
				);
				$this->session->set_userdata('logged_in', $sess_array);
			}
			return TRUE;
		}
		else
		{
			//$this->form_validation->set_message('check_database', 'Nombre de Usuario o Contraseña incorrectos.');
			return false;
		}
	}
}
?>