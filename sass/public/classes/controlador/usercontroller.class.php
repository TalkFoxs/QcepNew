<?php

class UserController extends Controlador
{

    private $usuari;

    private $passwd;

    public function show()
    {
        $fitxerDeTraduccions = $this->queIdioma();
        if (!isset($_SESSION['id'])) {
            $loginVista = new LoginVista();
            $loginVista->show($fitxerDeTraduccions, false);
        } else {
        }
    }

    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["username"] && $_POST["password"]) {
            $username = $this->sanitize($_POST["username"]);
            $password = $this->sanitize($_POST["password"]);
            $usuari = new Usuari($username, $password, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
            $conectar = new UsuariModel();
            $status = $conectar->read($usuari);
            if ($status != false && $status['status'] != 0) {
                $_SESSION['datos'] = $status;
                $home = new HomeController();
                $home->show();
            } else {
                $fitxerDeTraduccions = $this->queIdioma();
                $loginVista = new LoginVista();
                $loginVista->show($fitxerDeTraduccions, true);
            }
        }
    }

    public function loginOut()
    {
        unset($_SESSION['datos']);
        $home = new HomeController();
        $home->show();
    }

    public function regist()
    {
        $fitxerDeTraduccions = $this->queIdioma();
        $registrar = new LoginVista();
        $registrar->registrar($fitxerDeTraduccions, null, null);
    }

    public function registrar()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['boto'])) {
            $user = $this->sanitize($_POST['username']);
            $pass = $this->sanitize($_POST['password']);
            $nom = $this->sanitize($_POST['nom']);
            $cog = $this->sanitize($_POST['cognom']);
            $naci = $this->sanitize($_POST['naci']);
            $sexe = $this->sanitize($_POST['sexe']);
            $ident = $this->sanitize($_POST['ident']);
            $codi = $this->sanitize($_POST['codi']);
            $pobla = $this->sanitize($_POST['poblacio']);
            $provin = $this->sanitize($_POST['provincia']);
            $tele = $this->sanitize($_POST['telefon']);
            $numIdent = $this->sanitize($_POST["numIdent"]);
            $adreca = $this->sanitize($_POST["adreca"]);

            $navegador = $this->browse_info();
            $plataforma = $this->get_os();

            if (!filter_var($user, FILTER_VALIDATE_EMAIL)) {
                $errors["username"] = "L'adreça de correu no és vàlida";
            } else {
                $bien["user"] = $user;
            }
            $conectar = new UsuariModel();
            if ($conectar->existCorreo($user)) {
                $errors["existe"] = "Existe el usuario";
            }
            if (strlen($pass) == 0) {
                $errors["pass"] = "Has d'informar una contraseyna";
            } else {
                $bien["pass"] = $pass;
            }
            if (strlen($nom) == 0) {
                $errors["nom"] = "Has d'informar un nom";
            } else {
                $bien["nom"] = $nom;
            }
            if (strlen($cog) == 0) {
                $errors["cog"] = "Has d'informar un cognom";
            } else {
                $bien["cog"] = $cog;
            }
            if (strlen($naci) == 0) {
                $errors["naci"] = "Has d'informar un naxiament";
            } else {
                $bien["naci"] = $naci;
            }
            if (
                !in_array($ident, [
                    "DNI",
                    "NIE",
                    "Passport"
                ])
            ) {
                $errors["ident"] = "Que has cambiado ?!?!?!?!";
            }
            //Comprobacion de NIE y DNI
            if ($ident == "DNI") {
                if ($this->is_valid_dni($numIdent)) {
                    $bien["numIdent"] = $numIdent;
                } else {
                    $errors["numIdent"] = "DNI no VALIDO";
                }
            } elseif ($ident == "NIE") {
                if ($this->validateNIE($numIdent)) {
                    $bien["numIdent"] = $numIdent;
                } else {
                    $errors["numIdent"] = "NIE no VALIDO";
                }
            }
            //Guardar Direcion

            if (!empty($codi)) {
                if (preg_match('/^[0-9]{5}$/', $codi)) {
                    $bien["codi"] = $codi;
                } else {
                    $errors["codi"] = "Codigo postal no válido";
                }
            }
            //Guardar la adreca 
            $bien["adreca"] = $adreca;
            //Guardar la poblacio
            $bien["poblacio"] = $pobla;
            //Guardar la provincia
            $bien["provinica"] = $provin;
            //Guardar telefon
            $bien["telefon"] = $tele;
            //Guardar sexe
            $bien["sexe"] = $sexe;
            //Comprobacion de IMAGEN
            if (!isset($_FILES["Imagen"]) || $_FILES["Imagen"]["error"] != 0) {
                $errors["img"] = "Debe subir una imagen.";
            } else {
                $img = $_FILES["Imagen"];

                $fileExtension = pathinfo($img["name"], PATHINFO_EXTENSION);
                $allowedExtensions = ["jpg", "jpeg", "png"];

                if (!in_array($fileExtension, $allowedExtensions)) {
                    $errors["img"] = "El tipo de fichero no es válido. Solo se admiten archivos JPG, PNG y JPEG.";
                } elseif ($img["size"] > (2 * 1024 * 1024)) {
                    $errors["img"] = "El tamaño del archivo supera el límite de 2MB.";
                } else {
                    $targetDirectory = "./img/userIMG/";
                    $targetFileName = uniqid() . "." . $fileExtension;
                    $targetFile = $targetDirectory . $targetFileName;

                    // Comprueba si existe un archivo con el mismo nombre y, de ser así, agrega números hasta encontrar un nombre de archivo utilizable.
                    $counter = 1;
                    while (file_exists($targetFile)) {
                        $targetFileName = uniqid() . "_" . $counter . "." . $fileExtension;
                        $targetFile = $targetDirectory . $targetFileName;
                        $counter++;
                    }

                    // Mover archivos cargados al directorio de destino
                    if (!move_uploaded_file($img["tmp_name"], $targetFile)) {
                        $errors["img"] = "Error al mover el archivo al directorio de destino.";
                    }
                }
            }
            $fitxerDeTraduccions = $this->queIdioma();
            if (!empty($errors)) {
                $registrar = new LoginVista();
                $registrar->registrar($fitxerDeTraduccions, $errors, $bien);
            } else {
                $usuari = new Usuari($user, $pass, $ident, $numIdent, $nom, $cog, $sexe, $naci, $adreca, $codi, $pobla, $provin, $tele, $targetFile, $navegador, $plataforma);
                $conectar->create($usuari);
                $userDato = $conectar->read($usuari);
                $activarPagina = new ActivarVista();
                $activarPagina->show($fitxerDeTraduccions, $userDato['id']);
            }
        }
    }

    public function loginGoogle()
    {
        $clientID = '241965399440-59ek83pl2u1scemevj8pbf868ctlgm2v.apps.googleusercontent.com';
        $clientSecret = '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';
        $redirectUrl = 'http://localhost/qcep/QcepNew/sass/public/index.php';

        $client = new Google_Client();
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUrl);
        $client->addScope('profile');
        $client->addScope('email');
        echo "Login";
        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token);

            $gauth = new Google_Service_Oauth2($client);
            $google_info = $gauth->userinfo->get();
            $email = $google_info->email;
            $name = $google_info->name;
            $picture = $google_info->picture;


        } else {
            // 生成登录 URL 并重定向或输出链接
            $loginUrl = $client->createAuthUrl();
            header('Location: ' . $loginUrl);
            exit();
        }
    }
    // public function getUserInfo($accessToken) {
    //     $userInfoEndpoint = 'https://www.googleapis.com/oauth2/v3/userinfo';
    
    //     $ch = curl_init($userInfoEndpoint);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $accessToken]);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $userInfoResponse = curl_exec($ch);
    
    //     if ($userInfoResponse === false) {
    //         throw new Exception("Failed to retrieve user info. cURL error: " . curl_error($ch));
    //     }
    
    //     return json_decode($userInfoResponse, true);
    // }
    
    public function userGoogle($params) {
        try {
            $code = isset($params['code']) ? $params['code'] : null;
    
            if (!$code) {
                throw new Exception("Authorization code not found.");
            }
    
            $clientID = '241965399440-59ek83pl2u1scemevj8pbf868ctlgm2v.apps.googleusercontent.com';
            $clientSecret = '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';
            $redirectUrl = 'http://localhost/qcep/QcepNew/sass/public/index.php';
    
            $tokenEndpoint = 'https://oauth2.googleapis.com/token';
            $tokenParams = [
                'code' => $code,
                'client_id' => $clientID,
                'client_secret' => $clientSecret,
                'redirect_uri' => $redirectUrl,
                'grant_type' => 'authorization_code',
            ];
    
            $ch = curl_init($tokenEndpoint);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $tokenParams);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
    
            if ($response === false) {
                throw new Exception("Failed to retrieve access token. cURL error: " . curl_error($ch));
            }
    
            $tokenData = json_decode($response, true);
            echo "<pre>";
            var_dump($tokenData);
            echo "</pre>";
            if (!isset($tokenData['access_token'])) {
                throw new Exception("Access token not found in response.");
            }
    
            $accessToken = $tokenData['access_token'];
    
            $userInfo = $this->getUserInfo($accessToken);

            // 返回用户信息
            if($userInfo == null){
                echo "1";
            }
            echo "<pre>";
            var_dump($userInfo);
            echo "</pre>";
            // return $userInfo;
    
        } catch (Exception $e) {
            // 处理异常
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
    public function getUserInfo($accessToken) {
        $userInfoEndpoint = 'https://www.googleapis.com/oauth2/v2/userinfo';
    
        $ch = curl_init($userInfoEndpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $accessToken]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $userInfoResponse = curl_exec($ch);
        if ($userInfoResponse === false) {
            throw new Exception("Failed to retrieve user info. cURL error: " . curl_error($ch));
        }
    
        return json_decode($userInfoResponse, true);
    }
    
    

    private function is_valid_dni($dni)
    {
        $letter = substr($dni, -1);
        $numbers = substr($dni, 0, -1);

        if (substr("TRWAGMYFPDXBNJZSQVHLCKE", intval($numbers) % 23, 1) == $letter && strlen($letter) == 1 && strlen($numbers) == 8) {
            return true;
        }
        return false;
    }
    function validateNIE($nie)
    {
        $nie = strtoupper($nie);

        if (preg_match('/^[XYZ][0-9]{7}[A-Z]$/', $nie)) {
            $map = ['X' => '0', 'Y' => '1', 'Z' => '2'];
            $nie = str_replace(array_keys($map), array_values($map), $nie);

            $letter = substr($nie, -1);
            $numbers = substr($nie, 0, -1);
            $validLetter = 'TRWAGMYFPDXBNJZSQVHLCKE';
            $calculatedLetter = $validLetter[((int) $numbers) % 23];

            return $letter === $calculatedLetter;
        }

        return false;
    }
    private function get_os()
    {
        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            $os = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('/win/i', $os)) {
                $os = 'Windows';
            } else if (preg_match('/mac/i', $os)) {
                $os = 'MAC';
            } else if (preg_match('/linux/i', $os)) {
                $os = 'Linux';
            } else if (preg_match('/unix/i', $os)) {
                $os = 'Unix';
            } else if (preg_match('/bsd/i', $os)) {
                $os = 'BSD';
            } else {
                $os = 'Other';
            }
            return $os;
        } else {
            return 'unknow';
        }
    }
    private function browse_info()
    {
        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            $br = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('/MSIE/i', $br)) {
                $br = 'MSIE';
            } else if (preg_match('/Firefox/i', $br)) {
                $br = 'Firefox';
            } else if (preg_match('/Chrome/i', $br)) {
                $br = 'Chrome';
            } else if (preg_match('/Safari/i', $br)) {
                $br = 'Safari';
            } else if (preg_match('/Opera/i', $br)) {
                $br = 'Opera';
            } else {
                $br = 'Other';
            }
            return $br;
        } else {
            return 'unknow';
        }
    }
}


