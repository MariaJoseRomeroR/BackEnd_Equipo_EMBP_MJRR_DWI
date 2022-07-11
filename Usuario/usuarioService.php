<?php
    require_once '../headers.php';
    require "usuarioBL.php";

    class UsuarioService 
    {
        private $usuarioDTO;
        private $usuarioBL;

        public function __construct()
        {
            $this->usuarioDTO = new UsuarioDTO();
            $this->usuarioBL = new UsuarioBL();
        }

        public function create($imagen, $nombre, $a_paterno, $a_materno, $usuario, $contrasena)
        {
            $this->usuarioDTO ->imagen =$imagen;
            $this->usuarioDTO ->nombre = $nombre;
            $this->usuarioDTO ->a_paterno = $a_paterno;
            $this->usuarioDTO ->a_materno = $a_materno;
            $this->usuarioDTO ->usuario = $usuario;
            $this->usuarioDTO ->contrasena = $contrasena;
            if(($this->usuarioBL->create($this->usuarioDTO)) > 0)
                echo json_encode($this->usuarioDTO, JSON_PRETTY_PRINT);
            else 
                echo json_encode(array());

        }

        public function read($id) 
        {
            $this->usuarioDTO = $this->usuarioBL->read($id);
            echo json_encode($this->usuarioDTO, JSON_PRETTY_PRINT);
        }

        public function update($id, $imagen, $nombre, $a_paterno, $a_materno, $usuario, $contrasena)
        {
            $this->usuarioDTO ->id = $id;
            $this->usuarioDTO ->imagen =$imagen;
            $this->usuarioDTO ->nombre = $nombre;
            $this->usuarioDTO ->a_paterno = $a_paterno;
            $this->usuarioDTO ->a_materno = $a_materno;
            $this->usuarioDTO ->usuario = $usuario;
            $this->usuarioDTO ->contrasena = $contrasena;
            if($this->usuarioBL->update($this->usuarioDTO) > 0)
                echo json_encode($this->usuarioDTO, JSON_PRETTY_PRINT);
            else 
                echo json_encode(array());
        }

        public function delete($id)
        {
            $this->usuarioDTO ->id = $id;
            if($this -> usuarioBL -> delete($this -> usuarioDTO -> id) > 0)
                echo json_encode($id, JSON_PRETTY_PRINT);
            else
                echo json_encode(array());
        }                                                                  
    }


?>