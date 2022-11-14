<?php 

include_once '../capa_datos/Contacts.php';
include_once '../FileHandler/IFileHandler.php';

    class ContactBussiness {

        private $contactDB;
        
        public function __construct()
        {
            $this->contactDB = new ContactDB();
        }

        public function list()
        {
            return $this->contactDB->list();
        }

        public function insert($contact)
        {
            return $this->contactDB->insert($contact);
        }

        public function delete($contact_id)
        {
            return $this->contactDB->delete($contact_id);
        }

    }