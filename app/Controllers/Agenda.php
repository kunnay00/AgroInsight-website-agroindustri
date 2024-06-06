<?php

namespace App\Controllers;

use App\Models\PostsModel;

class Agenda extends BaseController
{
    function __construct()
    {
        $this->m_posts = new PostsModel();
        helper("global_fungsi_helper");
    }
    public function index($seo_title = null)
    {
        $data = [];

        $post_type = 'artikel';
        $post_category = 'Agenda Pertanian';
        $jumlahBaris = 5;
        $katakunci = '';
        $group_dataset = 'ft';

        //dapatkan page_id dari konfigurasi untuk halaman depan

        $konfigurasi_name = "set_halaman_agenda";
        $konfigurasi = konfigurasi_get($konfigurasi_name);


        if ($konfigurasi !== null && isset($konfigurasi['konfigurasi_value'])) {
            $page_id = $konfigurasi['konfigurasi_value'];
            

            // dapatkan data dari model post untuk idpage_id
            $dataHalaman = $this->m_posts->getPost($page_id);
            if ($dataHalaman !== null && isset($dataHalaman['post_type'])) {
                $data['type'] = $dataHalaman['post_type'];
                $data['judul'] = $dataHalaman['post_title'];
                $data['deskripsi'] = $dataHalaman['post_description'];
                $data['thumbnail'] = $dataHalaman['post_thumbnail'];
            }

        } else {

        }

        // $data['konten'] = $dataHalaman['post_content'];
        // $data['penulis'] = $dataHalaman['username'];
        // $data['tanggal'] = $dataHalaman['post_time'];
        

        $hasil = $this->m_posts->listPost($post_type, $jumlahBaris, $katakunci, $group_dataset);
        $data['record'] = $hasil['record'];
        $data['pager'] = $hasil['pager'];

        

        echo view("depan/v_template_header", $data);
        echo view("depan/v_agenda", $data);
        echo view("depan/v_template_footer", $data);
    }
}
