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

    public function getAllPost()
    {
        return $this->db
            ->select("id_post,judul,SUBSTRING(isi,1,150) as isi")
            ->get('posts')
            ->result_array();
    }

    public function getPosts($limit, $start, $keyword = null)
    {
        $keyword = $keyword;
        return $this->db
            ->select("id_post,judul,SUBSTRING(isi,1,150) as isi")
            ->like('judul', $keyword)
            ->order_by('id_post', 'asc')
            ->get('posts', $limit, $start)
            ->result_array();
    }

    public function getPostById($id)
    {
        return $this->db
            ->where('id_post', $id)
            ->get('posts')
            ->row_array();
    }

    public function countPosts($keyword = null)
    {
        return $this->db->like('judul', $keyword)
            ->from('posts')
            ->count_all_results();
    }

    public function updatePost($id)
    {
        $data = array(
            'judul' => $this->input->post('judul', true),
            'isi' => $this->input->post('isi', true)
        );
        $this->db
            ->where('id_post', $id)
            ->update('posts', $data);
    }
    public function hapusPost($id)
    {
        $this->db
            ->where('id_post', $id)
            ->delete('posts');
    }
}
