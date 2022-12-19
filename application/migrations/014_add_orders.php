
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_orders extends CI_Migration
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
            'user_id' => array(
                'type' => 'INT',
                'constraint' => '10',
            ),
            'Payment_methods' => array(
                'type' => 'INT',
                'constraint' => '7',
            ),
            'delivery_method' => array(
                'type' => 'INT',
                'constraint' => '3',
            ),
            'total_amount' => array(
                'type' => 'DOUBLE',
                'constraint' => '10,2',
                'default' => 0.00,
            ),
            'payment_json' => array(
                'type' => 'JSON',
                'null' => TRUE,
            ),
            'status_id' => array(
                'type' => 'INT',
                'constraint' => 10,
            ),
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('orders');
    }

    public function down()
    {
        $this->dbforge->drop_table('orders');
    }
}

