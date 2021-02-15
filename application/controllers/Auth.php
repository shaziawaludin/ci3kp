<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        // model bisa saja case sensitive, 
        // jadi perhatikan huruf besar kecilnya
    }


    public function index()
    {
        if (logged_in()) {
            redirect('home');
        }
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[4]');

        if ($this->form_validation->run() == false) {
            $data['judul'] = 'Login Page';
            $this->load->view('auth/templates/header', $data);
            $this->load->view('auth/login');
            $this->load->view('auth/templates/footer');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->User_model->getUserByEmail($email);

        if ($user) {
            if ($user['is_active'] == 1) {
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email']
                    ];
                    $this->session->set_userdata($data);
                    redirect('home');
                } else {
                    $this->session->set_flashdata('message2', '<small class=" text-danger">Password salah</small>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<small class="text-danger">Email belum diaktivasi</small>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<small class=" text-danger">Email belum terdaftar</small>');
            redirect('auth');
        }
    }

    public function register()
    {
        if (logged_in()) {
            redirect('home');
        }
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[4]|matches[password2]', [
            'matches' => 'Password does not match!',
            'min_length' => 'Password too short'
        ]);
        $this->form_validation->set_rules('password2', 'Confirm Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['judul'] = 'Register Page';
            $this->load->view('auth/templates/header', $data);
            $this->load->view('auth/register');
            $this->load->view('auth/templates/footer');
        } else {
            $token = base64_encode(random_bytes(32));
            $tokenh = password_hash($token, PASSWORD_DEFAULT);
            $email = $this->input->post('email');
            $user_token = [
                'email' => $email,
                'code' => $tokenh,
                'created_at' => time()
            ];
            $this->User_model->register();
            $this->User_model->createVerification($user_token);
            $this->_sendEmail($token);

            redirect('auth');
        }
    }


    private function _sendEmail($token)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'ci3kp2021@gmail.com',
            'smtp_pass' => 'azsx@ci3kp',
            'smtp_port' => '465',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n",
        ];
        $this->load->library('email', $config);
        $this->email->from('ci3kp2021@gmail.com', 'CI3KP');
        $this->email->to($this->input->post('email'));
        $this->email->subject('Verification mail');
        $this->email->message(
            'Silahkan verifikasi email Anda: <a href="' . base_url() . '/auth/verify?email=' . $this->input->post('email') . '&token=' . $token . '">Activate</a>'
        );
        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }


    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        $data = $this->User_model->getUserByEmail($email);

        if ($data) {
            $user_token = $this->User_model->getUserToken($email);
            if (password_verify($token, $user_token['code'])) {
                if (time() - $user_token['created_at'] < 60 * 4) {
                    $this->User_model->Activate($email);
                    $this->session->set_flashdata('alert', '<div class="alert alert-success" role="alert">Aktivasi Berhasil, Silahkan Login</div>');
                    redirect('auth');
                } else {
                    $this->User_model->deleteUser($email);
                    $this->session->set_flashdata('alert', '<div class="alert alert-danger" role="alert">Aktivasi gagal, Token kadaluarsa</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('alert', '<div class="alert alert-danger" role="alert">Aktivasi gagal, Token salah</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('alert', '<div class="alert alert-danger" role="alert">Aktivasi gagal, Email salah</div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        redirect('auth');
    }
}
