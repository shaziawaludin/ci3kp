<?php

class User_model extends CI_Model
{
    public function register()
    {
        $data = [
            'name' => $this->input->post('name', true),
            'email' => $this->input->post('email', true),
            'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
            'is_active' => 0,
            'date_created' => time()
        ];
        $this->db->insert('users', $data);
    }

    public function getUserByEmail($email)
    {
        return $this->db->get_where('users', ['email' => $email])->row_array();
    }

    public function createVerification($data)
    {
        $this->db->insert('verification', $data);
    }

    public function getUserToken($email)
    {
        return $this->db->get_where('verification', ['email' => $email])->row_array();
    }
    public function activate($email)
    {
        $this->db->set('is_active', 1)->update('users', ['email' => $email]);
        $this->db->delete('verification', ['email' => $email]);
    }
    public function deleteUser($email)
    {
        $this->db->delete('users', ['email' => $email]);
        $this->db->delete('verification', ['email' => $email]);
    }
}
