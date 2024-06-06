<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Admin extends Seeder
{
    public function run()
    {
        //
        $data = [
            'username'=>'admin',
            'password'=>password_hash('123',PASSWORD_DEFAULT),
            'email'=> 'adminagroinsight@gmail.com'
        ];
        $this->db->table('admin')->insert($data);
    }
}
