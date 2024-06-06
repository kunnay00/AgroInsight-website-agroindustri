<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Posts extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'post_id'=>[
                'type'=>'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'username'=>[
                'type'=>'VARCHAR',
                'constraint' => 25,
            ],
            'post_title'=>[
                'type'=>'VARCHAR',
                'constraint' => 225
            ],
            //Hello-world : id 1
            //artikel/detail/id/1 -> artikel/detail/id/hello-world
            'post_title_seo'=>[
                'type'=>'VARCHAR',
                'constraint' => 225
            ],
            'post_status'=>[
                'type'=>'ENUM',
                'constraint' => ['active', 'inactive'],
                'devault' => 'active'
            ],
            'post_type'=>[
                'type'=>'ENUM',
                'constraint' => ['artikel', 'page'],
                'devault' => 'artikel'
            ],
            'post_category'=>[
                'type'=>'ENUM',
                'constraint' => ['Tren Pasar', 'Tips & Panduan Pertanian', 'Agenda Pertanian'],
                'devault' => 'Tren Pasar'
            ],
            'post_thumbnail'=>[
                'type'=>'VARCHAR',
                'constraint' => 255
            ],
            'post_description'=>[
                'type'=>'VARCHAR',
                'constraint' => 255
            ],
            'post_content'=>[
                'type'=>'LONGTEXT',
            ],
            'post_time timestamp default now()'
        ]);

        $this->forge->addForeignKey('username', 'admin', 'username');
        $this->forge->addKey('post_id', TRUE);
        $this->forge->createTable('posts');
    }

    public function down()
    {
        //
        $this->forge->dropTable('posts');
    }
}
