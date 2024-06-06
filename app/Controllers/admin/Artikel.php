<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\PostsModel;

class artikel extends BaseController
{
    function __construct()
    {
        $this->m_posts = new PostsModel();
        $this->validation = \Config\Services::validation();
        helper('global_fungsi_helper');
        $this->halaman_controller = "artikel"; //utk konfigurasi internal
        $this->halaman_label = "Article";
    }
    
    function index()
    {
        $data = [];
        if ($this->request->getVar('aksi') == 'hapus' && $this->request->getVar('post_id')) {
            $dataPost = $this->m_posts->getPost($this->request->getVar('post_id'));
            if ($dataPost['post_id']) {
                @unlink(LOKASI_UPLOAD. "/". $dataPost['post_thumbnail']);
                $aksi = $this->m_posts->deletePost($this->request->getVar('post_id'));
                if ($aksi == true) {
                    session()->setFlashdata('success', "Data berhasil dihapus");
                } else {
                    session()->setFlashdata('warning', ['Gagal menghapus data']);
                }
            }
            return redirect()->to("admin/". $this->halaman_controller);
        }
       
        $data['templateJudul'] = "Halaman" . $this->halaman_label;

        $post_type = $this->halaman_controller;
        $jumlahBaris = 5;
        $katakunci = $this->request->getVar('katakunci');
        $group_dataset = "dt";

        $hasil = $this->m_posts->listPost($post_type, $jumlahBaris, $katakunci, $group_dataset);

        $data['record'] = $hasil['record'];
        $data['pager'] = $hasil['pager'];
        $data['katakunci'] = $katakunci;

        $currentPage = $this->request->getVar('page_dt');
        $data['nomor'] = nomor($currentPage, $jumlahBaris);

        echo view('admin/v_template_header', $data);
        echo view('admin/v_artikel', $data);
        echo view('admin/v_template_footer', $data);
    }

    function tambahartikel()
    {
        $data = [];
        if($this->request->getMethod()=='post'){
            $data = $this->request->getVar(); //setiap yg diinputkan akan dikembalikan lagi ke view
            $aturan = [
                'post_title' => [
                    'rules' => "required",
                    'errors' => [
                        'required' => 'Judul harus diisi'
                    ],
                ],
                'post_content' => [
                    'rules' => "required",
                    'errors' => [
                        'required' => 'Konten harus diisi'
                    ],
                ],
                'post_thumbnail' => [
                    'rules' => 'is_image[post_thumbnail]',
                    'errors' => [
                        'is_image' => 'Hanya diperbolehkan untuk mengupload gambar'
                    ],
                ]
            ];
            $file = $this->request->getFile('post_thumbnail');
            if(!$this->validate($aturan)) {
                session()->setFlashdata('warning', $this->validation->getErrors());
            }else{
                $post_thumbnail = '';
                if ($file->getName()) {
                    $post_thumbnail = $file->getRandomName();
                }
                $record = [
                    'username' => session()->get('akun_username'),
                    'post_title' => $this->request->getVar('post_title'),
                    'post_status' => $this->request->getVar('post_status'),
                    'post_category' => $this->request->getVar('post_category'),
                    'post_thumbnail' => $post_thumbnail,
                    'post_description' => $this->request->getVar('post_description'),
                    'post_content' => $this->request->getVar('post_content')
                ];
                $post_type = $this->halaman_controller;
                $aksi = $this->m_posts->insertPost($record, $post_type);
                if ($aksi != false) {
                    $page_id = $aksi;
                    if ($file->getName()) {
                        $lokasi_direktori = LOKASI_UPLOAD;
                        $file->move($lokasi_direktori, $post_thumbnail);
                    }
                    session()->setFlashdata ('success', 'Data berhasil ditambah');
                    return redirect()->to('admin/' .$this->halaman_controller. '/editartikel/'.$page_id);
                }else{
                    session()->setFlashdata ('warning', ['Gagal menambahkan data']);
                    return redirect()->to('admin/' .$this->halaman_controller.'/tambahartikel');
                }
            }
        }

        $data['templateJudul'] = "Halaman Tambah" . $this->halaman_label;

        echo view('admin/v_template_header', $data);
        echo view('admin/v_tambahartikel', $data);
        echo view('admin/v_template_footer', $data);
    }

    function editartikel($post_id)
    {
        $data = [];
        $dataPost = $this->m_posts->getPost($post_id);
        if(empty($dataPost)) {
            return redirect()->to('admin/'.$this->halaman_controller);
        }
        $data = $dataPost; 

        if($this->request->getMethod()=='post'){
            $data = $this->request->getVar(); //setiap yg diinputkan akan dikembalikan lagi ke view
            $aturan = [
                'post_title' => [
                    'rules' => "required",
                    'errors' => [
                        'required' => 'Judul harus diisi'
                    ],
                ],
                'post_content' => [
                    'rules' => "required",
                    'errors' => [
                        'required' => 'Konten harus diisi'
                    ],
                ],
                'post_thumbnail' => [
                    'rules' => 'is_image[post_thumbnail]',
                    'errors' => [
                        'is_image' => 'Hanya diperbolehkan untuk mengupload gambar'
                    ],
                ]
            ];
            $file = $this->request->getFile('post_thumbnail');
            if(!$this->validate($aturan)) {
                session()->setFlashdata('warning', $this->validation->getErrors());
            }else{
                $post_thumbnail = $dataPost['post_thumbnail'];
                if ($file->getName()) {
                    $post_thumbnail = $file->getRandomName();
                }
                $record = [
                    'username' => session()->get('akun_username'),
                    'post_title' => $this->request->getVar('post_title'),
                    'post_status' => $this->request->getVar('post_status'),
                    'post_category' => $this->request->getVar('post_category'),
                    'post_thumbnail' => $post_thumbnail,
                    'post_description' => $this->request->getVar('post_description'),
                    'post_content' => $this->request->getVar('post_content'),
                    'post_id' => $post_id //utk update perlu tambah post_id sbg pk
                ];
                $post_type = $this->halaman_controller;
                $aksi = $this->m_posts->insertPost($record, $post_type);
                if ($aksi != false) {
                    $page_id = $aksi;
                    if ($file->getName()) {
                        if($dataPost['post_thumbnail']){
                            @unlink(LOKASI_UPLOAD."/".$dataPost['post_thumbnail']);
                        }
                        $lokasi_direktori = LOKASI_UPLOAD;
                        $file->move($lokasi_direktori, $post_thumbnail);
                    }
                    session()->setFlashdata ('success', 'Data berhasil diperbarui');
                    return redirect()->to('admin/' .$this->halaman_controller.'/editartikel/'.$page_id);
                }else{
                    session()->setFlashdata ('warning', ['Gagal memperbarui data']);
                    return redirect()->to('admin/' .$this->halaman_controller.'/editartikel/'.$page_id);
                }
            }
        }

        $data['templateJudul'] = "Halaman Edit".$this->halaman_label;

        echo view('admin/v_template_header', $data);
        echo view('admin/v_tambahartikel', $data);
        echo view('admin/v_template_footer', $data);
    }
}

?>