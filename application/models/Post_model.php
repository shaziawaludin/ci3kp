<?php

class Post_model extends CI_Model
{
    public function tambahPost()
    {
        $data = array(
            'judul' => $this->input->post('judul'),
            'isi' => $this->input->post('isi')
        );
        $this->db->insert('posts', $data);
    }
}
