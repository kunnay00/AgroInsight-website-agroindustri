<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class Admin extends BaseController
{
    function __construct()
    {
        $this->m_admin = new AdminModel();
        $this->validation = \Config\Services::validation();
        helper("cookie");
        helper("global_fungsi_helper");
    }
    public function login()
    {
        $data = [];
        
        if(get_cookie('cookie_username') && get_cookie ('cookie_password')) {
            $username = get_cookie('cookie_username');
            $password = get_cookie('cookie_password');

            $dataAkun = $this->m_admin->getData($username);
            if ($password != $dataAkun['password']) {
                $err[] = "Akun yang anda masukkan tidak sesuai";
                session()->setFlashdata('username', $username);
                session()->setFlashdata('warning', $err);

                delete_cookie('cookie_username');
                delete_cookie('cookie_password');
                return redirect()->to("admin/login");
            }
            $akun = [
                'akun_username'=>$username,
                'akun_email'=>$dataAkun['email']
            ];
            session()->set($akun);
            return redirect()->to('admin/sukses');
        }
        $data = [];
        if($this->request->getMethod() == 'post') {
            $rules = [
                'username'=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'The username field is required'
                    ]
                ],
                'password'=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'The password field is required'
                    ]
                ]
            ];
            if(!$this->validate($rules)){
                session()->setFlashdata("warning",$this->validation->getErrors());
                return redirect()->to("admin/login");
            // }else{
            //     session()->setFlashdata("success", "Login Sukses");
            //     return redirect()->to("admin/login");
            }

            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
            $remember_me = $this->request->getVar('remember_me');

            $dataAkun = $this->m_admin->getData($username);
            if(!password_verify($password, $dataAkun['password'])) {
                $err[] = "Akun yang Anda masukkan tidak sesuai."; 
                session()->setFlashdata('username', $username);
                session()->setFlashdata('warning', $err);
                return redirect()->to("admin/login");
            }

            if($remember_me == '1') {
                set_cookie("cookie_username", $username, 3600*24*30);
                set_cookie("cookie_password", $dataAkun['password'], 3600*24*30);
            }

            $akun = [
                'akun_username'=>$dataAkun['username'],
                'akun_email'=>$dataAkun['email']
            ];
            session()->set($akun);
            return redirect()->to("admin/sukses")->withCookies();
        }
        echo view("admin/v_login", $data);
    }

    function sukses()
    {
        return redirect()->to('admin/artikel');
        // print_r(session()->get());
        // echo "isian cookie username" .get_cookie("cookie_username"). "dan password" .get_cookie("cookie_password");
    }

    function logout()
    {
        delete_cookie("cookie_username");
        delete_cookie("cookie_password");
        session()->destroy();
        if(session()->get('akun_username') != '') {
            session()->setFlashdata("success", "Anda telah berhasil logout");
        }
        echo view("admin/v_login");
    }

    function lupapassword()
    {
        $err = [];
        if($this->request->getMethod() == 'post') {
            $username = $this->request->getVar('username');
            if($username == '') {
                $err[] = "Silahkan masukkan username atau email yang Anda punya terlebih dahulu";
            }
            if(empty($err)){
                $data = $this->m_admin->getData($username);
                if(empty($data)){
                    $err[] = "Akun yang Anda masukkan tidak terdaftar";
                }
            }
            if(empty($err)){
                $email = $data['email'];
                $tiken = md5(date('ymdhis'));

                $link = site_url("admin/resetpassword/?email=$email&token=$token");
                $to = $email;
                $title = "Reset Password";
                $messege = "Silahkan klik link berikut ini untuk melakukan reset pada password Anda $link";

                kirim_email($to,$title,$messege);

                $dataUpdate = [
                    'email'=>$email,
                    'token'=>$token
                ];
                $this->m_admin->updateData($dataUpdate);
                session()->setFlashdata("success", "Email untuk recovery sudah berhasil kami kirimkan ke email Anda");
            }
            if($err){
                session()->setFlashdata("username",$username);
                session()->setFlashdata("warning",$err);
            }
            return redirect()->to("admin/lupapassword");
        }
        echo view("admin/v_lupapassword");
    }
    function resetpassword()
    {
        $err = [];
        $email = $this->request->getVar('email');
        $token = $this->request->getVar('token');
        if ($email != '' and $token != '') {
            $dataAkun = $this->m_admin->getData($email);
            if ($dataAkun['token'] != $token) {
                $err[] = "Token tidak valid";
            }
        } else {
            $err[] = "Parameter yang diberikan tidak valid";
        }

        if ($err) {
            session()->setFlashdata("warning", $err);
        }

        if($this->request->getMethod() == 'POST') {
            $aturan = [
                'password' =>[
                    'rules' => 'require|min_lenght[5]',  //require = harus diisi
                    'errors'=>[
                        'required' => 'Password harus diisi',
                        'min_length' => 'Minimal karakter password adalah 5 karakter'
                    ]
                ],
                'konfirm password' =>[
                    'rules' => 'require|min_lenght[5]|matches[password]',  //require = harus diisi
                    'errors'=>[
                        'required' => 'Password harus diisi',
                        'min_length' => 'Minimal karakter konfirm password adalah 5 karakter',
                        'matches' => 'Password tidak sesuai dengan yang diisikan sebelumnya'
                    ]  
                ]
            ];

            if(!$this->validate($aturan)) {
                session()->setFlashdata('warning',$this->validation->getErrors());
            } else {
                $dataUpdate = [
                    'email'=> $email,
                    'password'=> password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                    'token'=> null
                ];
                $this->m_admin->updateData($dataUpdate);
                sessioin()->setFlashdata('success', 'Reset password berhasil. Silahkan login');
                delete_cookie('cookie_username');
                delete_cookie('cookie_password'); 
                return redirect()->to('admin/login')->withCookies();
            }
        }
        echo view("admin/v_resetpassword");
    }
}
