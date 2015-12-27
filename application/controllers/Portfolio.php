<?php
class Portfolio extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('portfolio_model');
                $this->load->helper('url_helper');
        }

        public function index()
        {
                $data['portfolio'] = $this->portfolio_model->get_portfolio();
                $data['title'] = 'Portfolio';

                $this->load->view('templates/header', $data);
                $this->load->view('portfolio/index', $data);
                $this->load->view('templates/footer');
        }

        public function view($slug = NULL)
        {
                $data['portfolio_item'] = $this->portfolio_model->get_portfolio($slug);
                $data['portfolio_detail'] = $this->portfolio_model->get_portfolio_details($slug);
                $data['portfolio_image'] = $this->portfolio_model->get_portfolio_images($slug);

                if (empty($data['portfolio_item']))
                {
                        show_404();
                }

                $data['name'] = $data['portfolio_item']['slug'];

                $this->load->view('templates/header', $data);
                $this->load->view('portfolio/view', $data);
                $this->load->view('templates/footer');
        }
}
