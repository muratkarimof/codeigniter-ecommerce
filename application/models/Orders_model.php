<?php

class Orders_model extends CI_Model
{

    protected $table = 'orders';

    public function insert($data)
    {

        $this->db->insert($this->table, $data);

        return $this->db->insert_id();
    }

    public function select_all()
    {
        $this->db->select('o.id, o.total_amount AS amount, o.created_at, O.updated_at, u.name, p.title AS payment, d.title AS delivery, os.title orderstatus');
        $this->db->from('orders o');
        $this->db->join('users u', 'o.user_id=u.id', 'left');
        $this->db->join('payment_methods p', 'o.payment_method=p.id', 'left');
        $this->db->join('delivery_methods d', 'o.delivery_method=d.id', 'left');
        $this->db->join('order_status os', 'o.delivery_method=os.id', 'left');
        $this->db->order_by('o.id', 'DESC');
        $query = $this->db->get();

        return $query->result();
    }

    public function selectDataById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);

        return $query->row();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);

        return $this->db->affected_rows();
    }

    public function delete($id){
        $this->db->where('id', $id);
        $this->db->delete($this->table);

        return $this->db->affected_rows();
    }
}