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

        public function get_recipes_by_type($type)
        {

		$query = $this->db->get_where('recipes', array('type' => $type));
		return $query->result_array();
}

        public function remove_recipe($id)
        {
			$this->db->delete('recipes', array('recipe_id' => $id));
			if ($this->db->error()['code'] == 0) {

			return TRUE;
			}
			else {

			return FALSE;
			}

        }

	 	public function get_recipe($id)
        {
			$query = $this->db->get_where('recipes', array('recipe_id' => $id));

			return $query->result_array()[0];


        }

		public function get_all() {
			$query = $this->db->query("SELECT * FROM recipes");
			return $query->result_array();
		}

		public function get_random() {
			$query = $this->db->query("SELECT * FROM recipes");
			return random_element($query->result_array());
		}

        }
?>
