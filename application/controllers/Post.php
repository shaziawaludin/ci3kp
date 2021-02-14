<?php

class Post extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Post_model');
        // model bisa saja case sensitive, 
        // jadi perhatikan huruf besar kecilnya
        $this->load->library('form_validation');
    }

    //halaman ini akan dijalankan pada:
    //http://localhost/ci3kp/post
    // atau:
    // http://localhost/ci3kp/post/index
    public function index()
    {
        // PAGINATION
        $this->load->library('pagination');

        //CONFIG
        $config['base_url'] = 'http://localhost/ci3kp/post/index';
        // ^ untuk base url paginationnya

        if (isset($_POST['submit'])) {
            $data['keyword'] = $_POST['keyword'];
            $this->session->set_userdata('keyword', $data['keyword']);
        } else {
            $data['keyword'] = $_SESSION['keyword'];
        }

        $config['total_rows'] = $this
            ->Post_model
            ->countPosts($data['keyword']);
        // ^ untuk set total rowsnya, 
        // fungsi countnya nanti kita buat di model

        $config['per_page'] = 9;
        // ^ untuk set mau nampilin 
        // berapa data di setiap halaman

        // STYLING PAGINATION
        //pembuka containernya
        $config['full_tag_open'] = '<nav>
        <ul class="justify-content-center pagination">';
        //penutup containernya
        $config['full_tag_close'] = '</ul></nav>';

        //pembuka untuk first page
        $config['first_tag_open'] = '<li class="page-item">';
        //penutup untuk first page
        $config['first_tag_close'] = '</li>';

        //pembuka untuk last page
        $config['last_tag_open'] = '<li class="page-item">';
        //penutup untuk last page
        $config['last_tag_close'] = '</li>';

        //kata/hal yang ditampilin untuk 
        //next link
        $config['next_link'] = '&raquo';
        //pembuka untuk next-link
        $config['next_tag_open'] = '<li class="page-item">';
        //penutup untuk next-link
        $config['next_tag_close'] = '</li>';

        //kata/hal yang ditampilin untuk 
        //previous link
        $config['prev_link'] = '&laquo';
        //pembuka untuk previos-link
        $config['prev_tag_open'] = '<li class="page-item">';
        //penutup untuk previos-link
        $config['prev_tag_close'] = '</li>';

        //pembuka untuk halaman saat ini
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        //penutup untuk halaman saat ini
        $config['cur_tag_close'] = '</a></li>';

        //pembuka untuk nomor2nya
        $config['num_tag_open'] = '<li class="page-item">';
        //penutup untuk nomor2nya
        $config['num_tag_close'] = '</li>';

        // atribut tambahan untuk setiap anchornya.
        $config['attributes'] = ['class' => 'page-link'];


        // INISIALISASI PAGINATION
        $this->pagination->initialize($config);

        // ambil id dari data pertama 
        // yang mau ditampilin
        $data['start'] = $this->uri->segment(3);

        $data['judul'] = 'Halaman Post';

        $data['posts'] = $this->Post_model
            ->getPosts(
                $config['per_page'],
                $data['start'],
                $data['keyword']
            );

        $this->load->view('templates/header', $data);
        $this->load->view('post/index', $data);
        // yang berfungsi untuk load halaman index
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['judul'] = 'Tambah Post';

        $this->form_validation->set_rules('judul', 'Judul Post', 'required');
        $this->form_validation->set_rules('isi', 'Isi Post', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('post/tambah');
            $this->load->view('templates/footer');
        } else {
            $this->Post_model->tambahPost();
            $this->session->set_flashdata('notif', 'ditambahkan');
            $this->session->set_flashdata('alert', 'success');
            $this->session->set_flashdata('tipe', 'berhasil');
            redirect(base_url('post'));
        }
    }

    // public function prosesTambah()
    // {
    //     $this->Post_model->tambahPost();
    //     echo "sukses menambahkan";
    // }

    public function update($id)
    {
        $data['judul'] = 'Update Post';
        $data['post'] = $this->Post_model->getPostById($id);

        $this->form_validation->set_rules('judul', 'Judul Post', 'required');
        $this->form_validation->set_rules('isi', 'Isi Post', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('post/update', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Post_model->updatePost($id);
            $this->session->set_flashdata('notif', 'diupdate');
            $this->session->set_flashdata('alert', 'success');
            $this->session->set_flashdata('tipe', 'berhasil');
            redirect(base_url() . "post");
        }
    }
    // public function prosesUpdate($id)
    // {
    //     $this->Post_model->updatePost($id);
    //     redirect(base_url() . "post");
    // }
    public function hapus($id)
    {
        $this->Post_model->hapusPost($id);
        $this->session->set_flashdata('notif', 'dihapus');
        $this->session->set_flashdata('alert', 'success');
        $this->session->set_flashdata('tipe', 'berhasil');
        redirect(base_url() . "post");
    }
}
