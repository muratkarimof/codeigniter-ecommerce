<?php

/* It's a model class that contains methods for inserting, selecting, updating and deleting data from the admins table */
class Admins_model extends CI_Model {

    protected $table = 'admins'; // admins tablesi yaradir


    public function insert($data){
    
        $this->db->insert($this->table, $data);

        return $this->db->insert_id();
    }


    public function select_all(){
        $query = $this->db->get($this->table);

        return $query->result();
    }


    /**
     * It selects data from the table where the id is equal to the id passed to the function
     *
     * @param id The id of the row you want to select.
     *
     * @return The row with the id that matches the id passed in.
     */
    public function selectDataById($id){
        $this->db->where('id',$id);
        $query = $this->db->get($this->table);

        return $query->row();
    }

    public function update($id,$data){
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);

        return $this->db->affected_rows();
    }

    public function delete($id){
        $this->db->where('id', $id);
        $this->db->delete($this->table);

        /* It returns the number of rows affected by the last query. */
        return $this->db->affected_rows();
    }
}