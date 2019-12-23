<?php

class Upload extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper(array('form', 'url'));
                 $this->load->model('vocabulary_model');
        }

        public function index()
        {
                $this->load->view('upload_form', array('error' => ' ' ));
        }

        public function do_upload()
        {
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 100;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                       

                        $this->load->view('upload_form', $error);
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());

                        $this->load->view('upload_success', $data);
                }
        }

        public function  addVocabs():bool{

       
        
            $czech = $this->input->post("czech");

            $english = $this->input->post("english");
            $source = $this->input->post("source");
            $wordArray = array('czech' => $czech, 'english' => $english, 'source' => $source );

            $this->vocabulary_model->addVocab($wordArray);
             return true;

            
    }


    }


?>