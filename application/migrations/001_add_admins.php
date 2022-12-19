<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_admins extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => FALSE,
                                'auto_increment' => TRUE
                        ),
                        'fullname' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                        'email' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '55',
                                'unique'     => TRUE,
                        ),
                        'password' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '255',
                        ),
                        'status' => array(
                                'type' => 'INT',
                                'constraint' => '3',
                        )
                ));
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('admins');
        }

        public function down()
        {
                $this->dbforge->drop_table('admins');
        }
}