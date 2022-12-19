<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_products extends CI_Migration
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
            'description' => array(
                'type' => 'VARCHAR',
                'constraint' => 250,
            ),
            'quantity' => array(
                'type' => 'INT',
                'constraint' => 9,
            ),
            'price' => array(
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ),
            'sales_prices' => array(
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ),
            'brand_id' => array(
                'type' => 'INT',
                'constraint' => 3,
            ),
            'status' => array(
                'type' => 'INT',
                'constraint' => 5,
            ),
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('products');
    }

    public function down()
    {
        $this->dbforge->drop_table('products');
    }
}
