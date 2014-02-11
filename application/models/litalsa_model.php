<?php
	class Catalog_products extends CI_Model {

    function Show_all_products()
    {

        $q = $this->db->get('tbl_barnizadoras');

        foreach ($q->result() as $row)
            {
                $data = array();
                $data['id'] = $row->id;
                $data['name'] = $row->name; 
            }   

        return $data;

    }

}
?>