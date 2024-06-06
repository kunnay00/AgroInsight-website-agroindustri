<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\PostsModel;

class Socials extends BaseController
{
    function __construct()
    {
        $this->m_posts = new PostsModel();
        $this->validation = \Config\Services::validation();
        helper('global_fungsi_helper');
        $this->halaman_controller = "socials"; //utk konfigurasi internal
        $this->halaman_label = "Sosial Media";
    }
    
    function index()
    {
        $data = [];
        // if($this->request->getMethod() == 'post') {
        //     $konfigurasi_name = 'set_socials_x';
        //     $dataSimpan = [
        //         'konfigurasi_value' => $this->request->getVar('set_socials_x')
        //     ];
        //     konfigurasi_set($konfigurasi_name, $dataSimpan);

        //     $konfigurasi_name = 'set_socials_fb';
        //     $dataSimpan = [
        //         'konfigurasi_value' => $this->request->getVar('set_socials_fb')
        //     ];
        //     konfigurasi_set($konfigurasi_name, $dataSimpan);

        //     $konfigurasi_name = 'set_socials_wa';
        //     $dataSimpan = [
        //         'konfigurasi_value' => $this->request->getVar('set_socials_wa')
        //     ];
        //     konfigurasi_set($konfigurasi_name, $dataSimpan);

        //     session()->setFlashdata('success', 'Data berhasil disimpan');
        //     return redirect()->to('admin/'.$this->halaman_controller);
        // }
        // $konfigurasi_name = 'set_socials_x';
        // $data['set_socials_x'] = konfigurasi_get($konfigurasi_name)['konfigurasi_value'];

        // $konfigurasi_name = 'set_socials_fb';
        // $data['set_socials_fb'] = konfigurasi_get($konfigurasi_name)['konfigurasi_value'];
        
        // $konfigurasi_name = 'set_socials_wa';
        // $data['set_socials_wa'] = konfigurasi_get($konfigurasi_name)['konfigurasi_value'];

        $data['templateJudul'] = "Halaman ".$this->halaman_label;

        echo view('admin/v_template_header', $data);
        echo view('admin/v_socials', $data);
        echo view('admin/v_template_footer', $data);
    }
}

?>