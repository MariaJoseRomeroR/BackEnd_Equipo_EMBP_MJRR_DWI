<?php
    require "../conexion.php";
    require "../dto/usuarioDTO.php";

    class UsuarioBL
    {
        private $conexion;

        public function __construct()
        {
            $this -> conexion = new Conexion();
        }

        public function create($usuarioDTO) 
        {
            $this -> conexion -> OpenConnection();
            $Connsql = $this -> conexion -> GetConnection();
            $lastInsertId = 0;
            try{
                if($Connsql){
                    $Connsql -> beginTransaction();
                    $sqlStatment = $Connsql -> prepare(
                        "INSERT INTO usuario 
                        VALUES (default,
                                :imagen,
                                :nombre,
                                :a_paterno,
                                :a_materno,
                                :usuario, 
                                :contrasena)"
                    );

                    $sqlStatment -> bindParam(':imagen', $usuarioDTO->imagen);
                    $sqlStatment -> bindParam(':nombre', $usuarioDTO->nombre);
                    $sqlStatment -> bindParam(':a_paterno', $usuarioDTO->a_paterno);
                    $sqlStatment -> bindParam(':a_materno', $usuarioDTO->a_materno);
                    $sqlStatment -> bindParam(':usuario', $usuarioDTO->usuario);
                    $sqlStatment -> bindParam(':contrasena', $usuarioDTO->contrasena);
                    $sqlStatment -> execute();

                    $lastInsertId = $Connsql -> lastInsertId();
                    $Connsql -> commit();
                }
            }catch(PDOException $e){
                $Connsql -> rollback();
                $lastInsertId = 0;
            }
            return $lastInsertId;
        }

        public function read($id)
        {
            $this -> conexion -> OpenConnection();
            $Connsql = $this -> conexion -> GetConnection();
            $arrayUsuario = new ArrayObject();
            $SQLQuery = "SELECT * FROM usuario";

            if($id > 0)
                $SQLQuery = "SELECT * FROM usuario WHERE id = {$id}";
                try{
                    if($Connsql)
                        foreach($Connsql->query($SQLQuery) as $row){
                            $usuarioDTO = new UsuarioDTO();
                            $usuarioDTO -> id = $row['id'];
                            $usuarioDTO -> imagen = $row['imagen'];
                            $usuarioDTO -> nombre = $row['nombre'];
                            $usuarioDTO -> a_paterno = $row['a_paterno'];
                            $usuarioDTO -> a_materno = $row['a_materno'];
                            $usuarioDTO -> usuario = $row['usuario'];
                            $usuarioDTO -> contrasena = $row['contrasena'];
                            $arrayUsuario->append($usuarioDTO);
                        }

                } catch(PDOException $e){

                }
                return $arrayUsuario;
        }

        public function update($usuarioDTO)
        {
            $this -> conexion -> OpenConnection();
            $Connsql = $this -> conexion -> GetConnection();

            try{
                if($Connsql){
                    $Connsql -> beginTransaction();
                    $sqlStatment = $Connsql -> prepare(
                        "UPDATE usuario SET
                            imagen = :imagen,
                            nombre = :nombre,
                            a_paterno = :a_paterno,
                            a_materno = :a_materno,
                            usuario = :usuario,
                            contrasena = :contrasena 
                            WHERE id = :id"
                    );

                    $sqlStatment -> bindParam(':id', $usuarioDTO->id);
                    $sqlStatment -> bindParam(':imagen', $usuarioDTO->imagen);
                    $sqlStatment -> bindParam(':nombre', $usuarioDTO->nombre);
                    $sqlStatment -> bindParam(':a_paterno', $usuarioDTO->a_paterno);
                    $sqlStatment -> bindParam(':a_materno', $usuarioDTO->a_materno);
                    $sqlStatment -> bindParam(':usuario', $usuarioDTO->usuario);
                    $sqlStatment -> bindParam(':contrasena', $usuarioDTO->contrasena);
                    $sqlStatment -> execute();

                    $Connsql -> commit();
                    return true;
                }
            }catch(PDOException $e){
                $Connsql -> rollback();
                return false;
            }
        }
    }
?>