<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                // 'null' => TRUE,
            ],
            'avatar' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                // 'null' => TRUE,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                // 'null' => TRUE,
            ],
            'created_at' => [
                'type' => 'timestamp',
                'DEFAULT' => 'CURRENT_TIMESTAMP',
                // 'null' => TRUE,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        //
        $this->forge->dropTable('users');
    }
}
