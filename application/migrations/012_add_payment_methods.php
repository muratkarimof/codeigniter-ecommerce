<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_payment_methods extends CI_Migration
{

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
                'constraint' => 250,
            ),
            'order' => array(
                'type' => 'INT',
                'constraint' => 255,
            ),
            'status' => array(
                'type' => 'INT',
                'constraint' => 5,
            ),
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('payment_methods');
    }

    public function down()
    {
        $this->dbforge->drop_table('payment_methods');
    }
}

