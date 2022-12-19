
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_images extends CI_Migration
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
            'path' => array(
                'type' => 'VARCHAR',
                'constraint' => 250,
            ),
            'main' => array(
                'INT' => 1,
                'constraint' => 250,
            ),
            'product_id' => array(
                'type' => 'int',
                'constraint' => 5,
            ),
           'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',

        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('images');
    }

    public function down()
    {
        $this->dbforge->drop_table('images');
    }
}


