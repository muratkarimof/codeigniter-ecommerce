<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_pages extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => FALSE,
                'auto_increment' => TRUE
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
            ),
            'description' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'content' => array(
                'type' => 'TEXT',
            ),
            'status' => array(
                'type' => 'INT',
                'constraint' => 3,
            ),
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('pages');
    }

    public function down()
    {
        $this->dbforge->drop_table('pages');
    }
}
