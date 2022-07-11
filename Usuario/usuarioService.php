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

    $usuarioService = new UsuarioService();
    $usuarioDTO = new UsuarioDTO();

    $data = json_decode(file_get_contents("php://input"), true); 

    switch($_SERVER['REQUEST_METHOD']){
        case 'POST':
            { 
                if(empty($data)) {
                    $usuarioDTO -> response = array('CODE' => 'Error', 'MESSAGE' => 'Faltan valores');
                    echo json_encode($usuarioDTO->response, JSON_PRETTY_PRINT);
                } else {
                    $usuarioService -> create($data['imagen'], $data['nombre'], $data['a_paterno'], $data['a_materno'], $data['usuario'], $data['contrasena']);
                }
            break;
            }
        case 'GET':
            {
                if(empty($_GET['param'])) {
                    $usuarioService -> read(0);
                } else if(is_numeric($_GET['param'])){
                    $usuarioService -> read($_GET['param']);
                } else {
                    $usuarioDTO -> response = array('CODE' => 'Error', 'MESSAGE' => 'El parametro incorrecto');
                    echo json_encode($usuarioDTO->response, JSON_PRETTY_PRINT);
                }
            break;
            }
        case 'PUT':
            {
                if(empty($_GET['param'])) {
                    $usuarioDTO -> response = array('CODE' => 'Error', 'MESSAGE' => 'Faltan valores');
                    echo json_encode($usuarioDTO->response, JSON_PRETTY_PRINT);
                } else {
                    $usuarioService ->update($_GET['param'], $data['imagen'], $data['nombre'], $data['a_paterno'], $data['a_materno'], $data['usuario'], $data['contrasena']);
                }
            break;
            }
        case 'DELETE':
            {
                if(empty($_GET['param'])) {
                    $usuarioDTO -> response = array('CODE' => 'Error', 'MESSAGE' => 'Falta el Id');
                    echo json_encode($usuarioDTO->response, JSON_PRETTY_PRINT);
                } else {
                    $usuarioService -> delete($_GET['param']);
                }
            break;
            }
        default:
                $usuarioDTO -> response = array('CODE' => 'Error', 'TEXT' => 'Petición incorrecta');
                echo json_encode($usuarioDTO->response, JSON_PRETTY_PRINT);
            break;
    }
?>