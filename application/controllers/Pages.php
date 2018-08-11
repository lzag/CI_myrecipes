<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function index()
	{

		/* Will show a random recipe */
		$this->load->helper('array');
		$this->load->model('recipes');
		$data['recipe'] = $this->recipes->get_random();

		$data['message'] = "Hello";
		$this->load->view('header');
		$this->load->view('navigation');
		$this->load->view('message',$data);
		$this->load->view('single_recipe',$data);
		$this->load->view('footer');
	}

	public function add() {


		/* Load libraries/helpers */

		$this->load->helper(array('form','captcha','inflector'));
		$this->load->library('form_validation');
		$this->load->model('recipes');

		/* Setting validation rules */

		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('type', 'Type', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('photo', 'Photo', 'callback_check_image');
		$this->form_validation->set_rules('captcha', 'Captcha', 'callback_check_captcha','Invalid captcha');

		/* Creating a captcha */

		$vals = array(
        'img_path'      => ROOT_PATH .'captchas/',
        'img_url'       => base_url('captchas/'),
        'img_width'     => '250',
        'img_height'    => 50,
        'expiration'    => 7200,
        'word_length'   => 8,
        'font_size'     => 16,
        'img_id'        => 'Imageid',
        'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

        // White background and border, black text and red grid
        'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 40, 40)
        )
		);

		$cap = create_captcha($vals);

		$data = array(
        'captcha_time'  => $cap['time'],
        'ip_address'    => $this->input->ip_address(),
        'word'          => $cap['word']
		);

		$query = $this->db->insert_string('captcha', $data);
		$this->db->query($query);

		$data['cap_img'] = $cap['image'];

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('header');
			$this->load->view('navigation');
			$this->load->view('add_recipe',$data);
			$this->load->view('footer');
		}
		else
		{

		/* Uploading the image */

		if ( ! $this->recipes->upload_new())
		{
		$data['message'] = "There has been an error, please try again";
		$this->load->view('message',$data);
		}
		else
		{
		$this->load->view('header');
		$this->load->view('navigation');
		$data['message'] = "Your recipe has been successfully uploaded";
		$this->load->view('message',$data);
		$this->load->view('footer');
		}
		}


	}

	public function check_captcha() {

		/* Delete old CAPTCHAS */
		$expiration = time() - 7200; // Two hour limit
		$this->db->where('captcha_time < ', $expiration)
        ->delete('captcha');

		// check if the relevant CAPTCHA exists:
		$sql = 'SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?';
		$binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
		$query = $this->db->query($sql, $binds);
		$row = $query->row();

		if ($row->count == 0)
		{
			$this->form_validation->set_message('check_captcha', 'The {field} is not valid');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
		}

	public function check_image() {

		if ($_FILES['photo']['name'] === '' && $_FILES['photo']['size'] === 0)
		{
			$this->form_validation->set_message('check_image', 'You need to upload the photo');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
		}


	public function manage() {

		/* Set how the table looks like */
		$this->load->library('table');

		$template = array(
        'table_open'            => '<table class="table" border="0" cellpadding="4" cellspacing="0">',
		);

		$this->table->set_template($template);
		$this->table->set_heading('ID','Title','Description','Type','Image','View','Delete');

		$config = array();
		$config['image_library'] = 'gd';
		$config['source_image'] = '';
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width']         = 75;
		$config['height']       = 50;


		/* Get all the recipes from the database */
		$this->load->model('recipes');
		$recipes = $this->recipes->get_all();

		foreach($recipes as &$recipe) {
			$recipe['view_link'] = anchor("pages/get_recipe/{$recipe['recipe_id']}", 'See recipe');
			$recipe['delete_link'] = anchor("pages/remove_recipe/{$recipe['recipe_id']}", 'Delete recipe');

			$image_path = "C:/xampp/htdocs/CI_myrecipes/img/recipes/{$recipe['photo_path']}";



			$config = array();
			$config['image_library'] = 'gd';
			$config['source_image'] = '';
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = TRUE;
			$config['width']         = 75;
			$config['height']       = 50;
			$config['source_image'] = $image_path;

			$this->load->library('image_lib', $config);
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			$this->image_lib->clear();

			$recipe['photo_path'] = img(base_url("img/recipes/{$recipe['photo_path']}"));
			$recipe['description'] = character_limiter($recipe['description'],300);


		}

		$data['table'] = $this->table->generate($recipes);

		$this->load->view('header');
		$this->load->view('navigation');
		$this->load->view('recipe_list', $data);
		$this->load->view('footer');

	}

	public function by_type() {

		$this->load->helper('text');
		$this->load->model('recipes');
		$type = $this->uri->segment(3);
		if(empty($type)) {
           $data['recipes'] = $recipes = $this->recipes->get_all();
        } else {
		$data['recipes'] = $this->recipes->get_recipes_by_type($type);
		}
		$this->load->view('header');
		$this->load->view('navigation');
		$this->load->view('recipe',$data);
		$this->load->view('footer');

}
	public function remove_recipe($id) {

		$this->load->model('recipes');
		$remove = $this->recipes->remove_recipe($id);
		if ($remove) :
		$data['message'] = "Successfully removed the recipe";
		else :
		$data['message'] = "There has been an error removing the recipe";
		endif;

		$this->load->view('header');
		$this->load->view('navigation');
		$this->load->view('message',$data);
		$this->load->view('footer');

	}

	public function get_recipe($id) {

		$this->load->model('recipes');
		$data['recipe'] = $this->recipes->get_recipe($id);
		$this->load->view('header');
		$this->load->view('navigation');
		$this->load->view('single_recipe', $data);
		$this->load->view('footer');

	}


}
