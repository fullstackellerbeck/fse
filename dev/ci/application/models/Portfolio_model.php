<?php
class Portfolio_model extends CI_Model {

	public function __construct() {
	        $this->load->database();
	}

	public function get_portfolio($slug = FALSE) {
	        if ($slug === FALSE)
	        {
	                $query = $this->db->get('portfolio');
	                return $query->result_array();
	        }

	        $query = $this->db->get_where('portfolio', array('slug' => $slug));
	        return $query->row_array();
	}

	public function get_portfolio_details($slug = FALSE) {
	    if ($slug === FALSE) {
            $query = $this->db->get('portfolio_detail');
            return $query->result();
	    }

	    $query = $this->db->get_where('portfolio_detail', array('slug' => $slug));
	    return $query->result();
	}

	public function get_portfolio_images($slug = FALSE) {
	    $query = ($slug === FALSE ? $this->db->get('portfolio_image') : $this->db->get_where('portfolio_image', array('slug' => $slug) ) );
		$result = $query->result();

		return ( $result );
	}
}
