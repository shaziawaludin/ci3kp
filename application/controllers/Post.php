<?php

class Post extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Post_model');
        // model bisa saja case sensitive, 
        // jadi perhatikan huruf besar kecilnya
    }

    public function tambah()
    {
        $data['judul'] = 'Tambah Post';

        $this->load->view('templates/header', $data);
        $this->load->view('post/tambah');
        $this->load->view('templates/footer');
    }

    public function prosesTambah()
    {
        $this->Post_model->tambahPost();
        echo "sukses menambahkan";
    }
}
