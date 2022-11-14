<?php 

    class Contact {

        public $id;
        public $nombre;
        public $apellido;
        public $email;

        public function __construct($id,$nombre,$apellido,$email)
        {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->email = $email;
        }

    }