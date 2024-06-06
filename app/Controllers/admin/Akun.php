<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class Akun extends BaseController
{
    function __construct()
    {
        $this->m_admin = new AdminModel();
        $this->validation = \Config\Services::validation();
        helper('global_fungsi_helper');
        $this->halaman_controller = "akun"; //utk konfigurasi internal
        $this->halaman_label = "Akun";
    }
    
    function index()
    {
        $data = [];
        if($this->request->getMethod() == 'post') {
            $data = $this->request->getVar();

            $username = $this->request->getVar('username');
            $password_lama  = $this->request->getVar('password_lama');
            $password_baru  = $this->request->getVar('password_baru');
            $password_baru_konfir  = $this->request->getVar('password_baru_konfir');
            return redirect()->to('admin/'.$this->halaman_controller);
        }

        $username = session()->get('akun_username');
        $data = $this->m_admin->getData($username);

        $data['templateJudul'] = "Halaman ".$this->halaman_label;

        echo view('admin/v_template_header', $data);
        echo view('admin/v_akun', $data);
        echo view('admin/v_template_footer', $data);
    }
}

?>