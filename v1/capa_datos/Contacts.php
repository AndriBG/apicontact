<?php

    include_once '../database/ConnectionDB.php';

    class ContactDB {

        private $context;

        public function __construct()
        {
            $directory = '../database';
            $this->context = new ConnectionDB($directory);
        }

        public function insert($contact)
        {
            $stmt = $this->context->db->prepare("insert into contacts (nombre,apellido,email) values(?,?,?)");
            $stmt->bind_param("sss", $contact->nombre,$contact->apellido,$contact->email);
            $stmt->execute();
            $id = $stmt->insert_id;
            $stmt->close();
            return $id;
        }

        public function list()
        {
            $list = array();

            $stmt = $this->context->db->prepare("select * from contacts order by contacts.ID DESC");
            $stmt->execute();

            $result = $stmt->get_result();
    
            if ($result->num_rows === 0) {
                return array();
            } else {
                while ($row = $result->fetch_object()) {
                    // row: es el objeto que representa cada fila de la tabla en la bd
                    $contact = new Contact($row->ID,$row->nombre,$row->apellido,$row->email);
                    array_push($list, $contact);
                }
            }
            return $list;
        }
    
        public function update($contact) : int
        {
            $stmt = $this->context->db->prepare("update table contacts (nombre,apellido,email) values(?,?,?) where ID = (?)");
            $stmt->bind_param("sssi", $contact->nombre,$contact->apellido,$contact->email,$contact->id);
            $stmt->execute();
            $stmt->close();
            return 3;
        }

        public function delete($id)
        {
            $stmt = $this->context->db->prepare("delete from contacts where ID = ?");
            $stmt->bind_param("i", $id);
            $status = $stmt->execute();
            $stmt->close();
            return $status;
        }

        // public function getById($id)
        // {
        //     $Contact = null;
    
        //     $stmt = $this->context->db->prepare("select * from contact where ID = ?");
        //     $stmt->bind_param("i", $id);
        //     $stmt->execute();
    
        //     $result = $stmt->get_result();
    
        //     if ($result->num_rows === 0) {
        //         return null;
        //     } else {
        //       $row = $result->fetch_object();
        //       $Contact = new Contact($row->ID,$row->nombre,$row->apellido,$row->email);
        //     }
    
        //     return $Contact;
        // }

    }

?>