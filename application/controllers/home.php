<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Home extends CI_Controller {
	
	// número de resultados por página
	private $limit = 10;

	function __construct()
	{
	 	parent::__construct();
	 	// cargar librerias
		$this->load->library(array('table','form_validation'));
		$this->load->model('barn_model','',TRUE);
	}

function index()
{
	if($this->session->userdata('logged_in'))
	{
		$session_data = $this->session->userdata('logged_in');
		$data['username'] = $session_data['username'];
		
		$this->load->view('m_head'); //código <head></head>, solo css, js en footer
		$this->load->view('m_header'); //logotipo, alertas, mensajes, tareas, menu administración
		$this->load->view('m_sidebar'); //barra lateral
		//---------------------------------------------------------------------
		$this->load->view('m_content_home'); //contenido central - HOME
		//---------------------------------------------------------------------
		$this->load->view('m_footer'); //pié de página y carga de js
	}
	else
	{
		//si no hay sesión, nos redirige a la página de login
		redirect('login', 'refresh');
	}
}

function barnizadora($offset=0)
{
	if($this->session->userdata('logged_in'))
	{
		$session_data = $this->session->userdata('logged_in');
		$data['username'] = $session_data['username'];
		//cargar las diferentes vistas....
		$this->load->view('m_head'); //código <head></head>, solo css, js en footer
		$this->load->view('m_header'); //logotipo, alertas, mensajes, tareas, menu administración
		$this->load->view('m_sidebar'); //barra lateral
		$this->load->view('m_content_top'); //título y breadcrumb de contenido, fuera de foreach
		// offset
		$uri_segment = 3;
		$offset = $this->uri->segment($uri_segment);
		// cargar datos
		$aplicaciones = $this->barn_model->list_all_group()->result();
		$this->load->library('table');
		$this->table->set_empty("&nbsp;");
		$i = 0 + $offset;
		$data['table'] = "";
		$j = 0;
		foreach ($aplicaciones as $aplicacion)
		{
			$this->table->set_heading('Nº','Programación', 'Pedido', 'Posición', 'Producto', 'Apli_Producto', 'Requerido en Fecha', 'Flejar', 'Observaciones');
			$data['apli_producto'] = $aplicacion->Apli_Producto;
			$barnizadoras = $this->barn_model->list_by_apli($aplicacion->Apli_Producto)->result();
			$i = 0;
			foreach ($barnizadoras as $barnizadora)
			{
				$this->table->add_row(
				++$i
				, $barnizadora->Idprogramacion
				, $barnizadora->Idpedido
				, $barnizadora->Posicion
				, $barnizadora->Producto
				, $barnizadora->Apli_Producto
				, $barnizadora->RequeridoEnFecha
				, $barnizadora->Flejar	 
				, $barnizadora->Observaciones
				, anchor('home/barnizadora_detail/'.$barnizadora->Idprogramacion,'update',array('class'=>'update'))
				);
			}
			$j++;
			$data['indexx'] = $j;
			$data['table'] = $this->table->generate();
			$this->load->view('m_content_body',$data); //donde se dibujan las tablas, dentro de foreach
		}
	$this->load->view('m_content_footer'); //cierre de content, fuera de foreach
	$this->load->view('m_footer'); //pié de página y carga de js
	}
	else
	{
		//si no hay sesión, nos redirige a la página de login
		redirect('login', 'refresh');
	}
} 
 
function barnizadora_detail($Idprogramacion)
{
	if($this->session->userdata('logged_in'))
   	{
	    $session_data = $this->session->userdata('logged_in');
		$data['username'] = $session_data['username'];
	 
		//$this->_set_fields();
		//$this->_set_rules();
		// prefill form values
		$barnizadora = $this->barn_model->get_by_id($Idprogramacion)->row();
		
		$this->form_data->Idprogramacion = $barnizadora->Idprogramacion;
		$this->form_data->apli_producto = $barnizadora->Apli_Producto;
		$this->form_data->observaciones = $barnizadora->Observaciones;
		$this->form_data->flejar = $barnizadora->Flejar;
		
		$data['action'] = site_url('home/update_barnizadora');

		$this->load->view('barnizadora_detail', $data);		
	} 

}

	function update_barnizadora()
	{
		if($this->session->userdata('logged_in'))
	   	{
		    $session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			
			// set common properties
			//$data['title'] = 'Update person';
			$data['action'] = site_url('home/update_barnizadora');
			//$data['link_back'] = anchor('person/index/','Back to list of persons',array('class'=>'back'));
			
			// set empty default form field values
			$this->_set_fields_post();
			// set validation properties
			$this->_set_rules();
			
			$id = $this->input->post('id');
			
			
			
			
			
			if ($this->form_validation->run() == FALSE)
			{
				$data['message'] = 'No chusca';
				//echo $data['message'];
			}
			else
			{
				
				// save data
				$id = $this->input->post('id');
				$barnizadora = array('apli_producto' => $this->input->post('apli_producto'),
								'observaciones' => $this->input->post('observaciones'),
								'flejar' => ($this->input->post('flejar')));
				$this->barn_model->update($id,$barnizadora);
				
				
				// set user message
				$data['message'] = '<div class="success">update person success</div>';
			}
			$this->load->view('barnizadora_detail', $data);
			
			
			/*
			 $id = $this->input->post('id');
			$person = array('name' => $this->input->post('name'),
							'gender' => $this->input->post('gender'),
							'dob' => date('Y-m-d', strtotime($this->input->post('dob'))));
			$this->Person_model->update($id,$person);
			
			// set user message
				$data['message'] = '<div class="success">update person success</div>';
			}
			
			// load view
			$this->load->view('personEdit', $data); 
			  
			 
			 * */
			
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	
	}

	function logout()
	{
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('home', 'refresh');
	}

	// set empty default form field values
	function _set_fields()
	{
		$this->form_data->Idprogramacion = '';
		$this->form_data->apli_producto = '';
		$this->form_data->observaciones = '';
		$this->form_data->flejar = '';
	}
	
	function _set_fields_post()
	{
		$this->form_data->Idprogramacion = $this->input->post('id');
		$this->form_data->apli_producto = $this->input->post('apli_producto');
		$this->form_data->observaciones = $this->input->post('observaciones');
		$this->form_data->flejar = $this->input->post('flejar');
	}
	
	// validation rules
	function _set_rules()
	{
		$this->form_validation->set_rules('apli_producto', 'Apli_producto', 'trim|required');
		/*$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('dob', 'DoB', 'trim|required|callback_valid_date');
		
		$this->form_validation->set_message('required', '* required');
		$this->form_validation->set_message('isset', '* required');
		$this->form_validation->set_message('valid_date', 'date format is not valid. dd-mm-yyyy');
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		 * 
		 */
	}
}

?>