<?php

class Recipes extends CI_Model {

//        public $recipe_id;
//        public $description;
//        public $type;
//        public $photo_path;


        public function upload_new()
        {
		$this->load->helper('inflector');

		$filename = underscore($this->security->sanitize_filename($_FILES['photo']['name']));
		$file_nr = str_pad($this->db->count_all('recipes') + 1, 5, "0", STR_PAD_LEFT);

		/* Upload the photo */
		$config = array(
						'upload_path' => 'img/recipes/',
						'allowed_types' => 'gif|jpg|png',
						'file_name' => 'IMG_' . $file_nr . '_'. $filename,
						);

		$this->load->library('upload', $config);
		$this->upload->do_upload('photo');

		/* Upload the data to the db */
		$data = array(
		'title' => $this->input->post('title'),
		'type' => $this->input->post('type'),
		'description' => $this->input->post('description'),
		'photo_path' => 'IMG_' . $file_nr . '_'. $filename,
		);

		if($this->db->insert('recipes', $data)) {

			return TRUE;

		} else {

			return FALSE;

		}


        }

     /*   public function get_recipes_by_type($type)
        {
		$offset = ($this->uri->segment(4) - 1) * 3;
		$query = $this->db->get_where('recipes', array('type' => $type),3,$offset);
		return $query->result_array();
		}

		public function get_recipes_by_type_rows($type)
        {
		$query = $this->db->get_where('recipes', array('type' => $type));
		return $query->num_rows();
		}*/

        public function remove_recipe($id)
        {
		$this->db->delete('recipes', array('recipe_id' => $id));
		if ($this->db->error()['code'] == 0)
		{
		return TRUE;
		}
		else
		{
		return FALSE;
		}
        }

	 	public function get_recipe($id)
        {
		$query = $this->db->get_where('recipes', array('recipe_id' => $id));
		return $query->result_array()[0];
        }

		public function get_recipes()
		{
//		$type = $this->uri->segment(3) ? $this->uri->segment(3) : 'all';
		$limit = 3;
//		$offset = $this->uri->segment(3) ? $this-	 >uri->segment(3) : 0;
		if ($this->uri->segment(2) === 'all')
		{
		$offset = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
		$query = $this->db->query("SELECT * FROM recipes LIMIT ".$limit." OFFSET ".$offset);
		}
		elseif ($this->uri->segment(2) === 'by_type')
		{
		$offset = $this->uri->segment(4) ? $this->uri->segment(4) : 0;
		$query = $this->db->query("SELECT * FROM recipes WHERE type='" . $this->uri->segment(3) . "' LIMIT " . $limit . " OFFSET " . $offset);
		}
		elseif ($this->uri->segment(2) === 'manage')
		{
			$query = $this->db->query("SELECT * FROM recipes");
		}
		return $query->result_array();
		}

		public function get_num_rows()
		{
		if ($this->uri->segment(2) === 'all') {
			$query = $this->db->query("SELECT * FROM recipes");
		}
		elseif ($this->uri->segment(2) === 'by_type')
		{
			$query = $this->db->query("SELECT * FROM recipes WHERE type='" . $this->uri->segment(3) . "'");
		}
		return $query->num_rows();
		}

		public function get_random()
		{

		$query = $this->db->query("SELECT * FROM recipes");
		if ($query->num_rows() > 0)
		{
			return random_element($query->result_array());
		}
		}

		public function get_types()
		{
			$query = $this->db->query("SELECT DISTINCT type FROM recipes");
			return $query->result_array();
		}

        }


?>
