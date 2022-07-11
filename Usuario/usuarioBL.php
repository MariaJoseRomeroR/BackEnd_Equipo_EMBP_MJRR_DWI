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
    }
?>