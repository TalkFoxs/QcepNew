<?php

class UsuariModel implements CRUDable
{

    const HOST = 'localhost';

    const USEREAD = 'usr_consulta';

    const PASSREAD = '2024@Thos';
    
    const USERINSERT = 'usr_generic';
    
    const PASSRINSERT = '2024@Thos';

    const DB = 'qcep';

    public function read($obj)
    {
        $mysqli = mysqli_connect(self::HOST, self::USEREAD, self::PASSREAD, self::DB);
        if ($mysqli->connect_errno) {
            die("Failed to connect to MySQL: " . $mysqli->connect_error);
        }
        $email = $obj->email;
        $password = $obj->pass;
        $userContra = $mysqli->prepare("SELECT email,password,username,es_administrador FROM qcep where email = ?");
        $userContra->bind_param("s", $email);
        $userContra->execute();
        $result = $userContra->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($user['email'] === $email && $user['password'] === $password) {
                $mysqli->close();
                $usuarioDato = [
                    'id' => $user['id'],
                    'imatge' => $user['imatge'],
                    'status'=>$user['status']
                ];
                return $usuarioDato;
            }
        }
        $userContra->close();
        $mysqli->close();
        return false;
    }

    public function create($obj)
    {
        /*
         * 2.- bind_param("sssssis", $valor1, $valor2, ...)
         * 
         * */
        $mysqli = mysqli_connect(self::HOST, self::USERINSERT, self::PASSRINSERT, self::DB);
        if ($mysqli->connect_errno) {
            die("Failed to connect to MySQL: " . $mysqli->connect_error);
        }
        $query = "INSERT INTO tbl_usuaris (email, password, tipusIdent, numeroIdent, nom, cognoms, sexe, naixement, adreca, codiPostal, poblacio, provincia, telefon, imatge, navegador, plataforma) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $mysqli->prepare($query);
        if (! $stmt) {
            die("Error in query preparation: " . $mysqli->error);
        }

        // Vincular parámetros y comprobar si tiene éxito
        if (! $stmt->bind_param("ssssssssssssssss", $obj->user, $obj->password, $obj->tipuIdent, $obj->dni, $obj->nom, $obj->cognom, $obj->sexe, $obj->naxiament, $obj->adreca, $obj->codiPostal, $obj->poblacio, $obj->provincia, $obj->telefon, $obj->imatge, $obj->navegador, $obj->plataforma)) {
            die("Error in binding parameters: " . $stmt->error);
        }
        $stmt->execute();
       

        // Cerrrar la conexion de BBDD
        $stmt->close();
        $mysqli->close();

        
/*
 * Utlizan .- bind_param ("s",$valor) repetit n vegades. El método bind_param vincula todos los parámetros a la vez y solo se puede llamar una vez. 
 * No se admiten múltiples llamadas para agregar nuevos parámetros vinculantes.Pero podemos utiliza el metodo call_user_func_array hacer algo como pide.Pero gastara mucho tiempo.
 * */
//         $params = [
//             'email' => $obj->user,
//             'password' => $obj->password,
//             'tipusIdent' => $obj->tipuIdent,
//             'numeroIdent' => $obj->dni,
//             'nom' => $obj->nom,
//             'cognoms' => $obj->cognom,
//             'sexe' => $obj->sexe,
//             'naixement' => $obj->naxiament,
//             'adreca' => $obj->adreca,
//             'codiPostal' => $obj->codiPostal,
//             'poblacio' => $obj->poblacio,
//             'provincia' => $obj->provincia,
//             'telefon' => $obj->telefon,
//             'imatge' => $obj->imatge,
//             'navegador' => $obj->navegador,
//             'plataforma' => $obj->plataforma
//         ];
        
//         foreach ($params as $key => $value) {
//             $query = "INSERT INTO tbl_usuaris ($key) VALUES (?)";
//             $stmt = $mysqli->prepare($query);
//             if (!$stmt) {
//                 die("Error in query preparation: " . $mysqli->error);
//             }
//         $stmt->bind_param("s", $value);
        
//         if (!$stmt->execute()) {
//             die("Error in query execution: " . $stmt->error);
//         }
            
        /*
         * Utilizan bind_param("sssssis", $array), no se puede añadir directamenta el array, necesitamos utilizar el call_user_func_array
         * 
         * */
//         $mysqli = mysqli_connect(self::HOST, self::USERINSERT, self::PASSRINSERT, self::DB);
//         if ($mysqli->connect_errno) {
//             die("Failed to connect to MySQL: " . $mysqli->connect_error);
//         }
        
//         $query = "INSERT INTO tbl_usuaris (email, password, tipusIdent, numeroIdent, nom, cognoms, sexe, naixement, adreca, codiPostal, poblacio, provincia, telefon, imatge, navegador, plataforma) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
//         $stmt = $mysqli->prepare($query);
//         if (!$stmt) {
//             die("Error in query preparation: " . $mysqli->error);
//         }
        
//         $params = [$obj->user, $obj->password, $obj->tipuIdent, $obj->dni, $obj->nom, $obj->cognom, $obj->sexe, $obj->naxiament, $obj->adreca, $obj->codiPostal, $obj->poblacio, $obj->provincia, $obj->telefon, $obj->imatge, $obj->navegador, $obj->plataforma];
        
//         array_unshift($params, str_repeat("s", count($params)));
        
//         call_user_func_array([$stmt, 'bind_param'], $params);
        
//         $stmt->execute();
        
//         $stmt->close();
//         $mysqli->close();
        
 /*
  * 5.- passant paràmetres directament a l'execute. No puede pasar parámetros directamente 
  * al método de ejecución porque el método de ejecución no tiene parámetros en mysqli. Pero podemos utilizar PDO
  * */       
//         try {
//             $pdo = new PDO("mysql:host=" . self::HOST . ";dbname=" . self::DB, self::USERINSERT, self::PASSRINSERT);
//             $query = "INSERT INTO tbl_usuaris (email, password, tipusIdent, numeroIdent, nom, cognoms, sexe, naixement, adreca, codiPostal, poblacio, provincia, telefon, imatge, navegador, plataforma) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
//             $stmt = $pdo->prepare($query);
            
         
//             $stmt->execute([$obj->user, $obj->password, $obj->tipuIdent, $obj->dni, $obj->nom, $obj->cognom, $obj->sexe, $obj->naxiament, $obj->adreca, $obj->codiPostal, $obj->poblacio, $obj->provincia, $obj->telefon, $obj->imatge, $obj->navegador, $obj->plataforma]);
//         } catch (PDOException $e) {
//             die("Failed to connect to MySQL: " . $e->getMessage());
//         }
        
        
    }

    public function update($id){
        $mysqli = mysqli_connect(self::HOST, self::USERINSERT, self::PASSRINSERT, self::DB);
        if ($mysqli->connect_errno) {
            die("Failed to connect to MySQL: " . $mysqli->connect_error);
        }
        $query = "update tbl_usuaris set status=1 where id = ?";
        $stmt = $mysqli->prepare($query);
        if (! $stmt) {
            die("Error in query preparation: " . $mysqli->error);
        }
        if (! $stmt->bind_param("s", $id)) {
            die("Error in binding parameters: " . $stmt->error);
        }
        $stmt->execute();
        $stmt->close();
        $mysqli->close();
    }
    public function existCorreo($email)
    {
        $mysqli = mysqli_connect(self::HOST, self::USEREAD, self::PASSREAD, self::DB);
        if ($mysqli->connect_errno) {
            die("Failed to connect to MySQL: " . $mysqli->connect_error);
        }
        
        $email = $mysqli->real_escape_string($email);
        $query = "SELECT COUNT(*) FROM tbl_usuaris WHERE email = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($userCount);
        $stmt->fetch();
        $stmt->close();
        $mysqli->close();
        
        return $userCount > 0;
    }
    public function delete($obj)
    {}
}

