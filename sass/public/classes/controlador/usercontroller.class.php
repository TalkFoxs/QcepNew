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

    // public function login()
    // {
    //     if (isset($_SESSION["user_info"]["email"])) {
    //         $userModel = new UsuariModel();
    //         $result = $userModel->read();
    //         var_dump($result);
    //         $esta = false;

    //         if ($esta === true) {
    //             $email = $this->sanitize($_SESSION["user_info"]["email"]);
    //             $name = $this->sanitize($_SESSION["user_info"]["name"]);
    //             $usuari = new Usuari($email, $name, NULL);
    //             $conectar = new UsuariModel();
    //             $status = $conectar->read($usuari);
    //             if ($status != false) {
    //                 $home = new HomeController();
    //                 $home->show();
    //             } else {
    //                 echo "No existe tu usuario";
    //             }

    //         }else{
    //             echo"Sorry";
    //         }
    //     }

    // }




    public function loginOut()
    {
        unset($_SESSION['user_info']);
        unset($_SESSION['access_token']);
        session_destroy();
        $home = new HomeController();
        $home->show();
    }

    public function regist()
    {
        $fitxerDeTraduccions = $this->queIdioma();
        $registrar = new LoginVista();
        $registrar->registrar($fitxerDeTraduccions, null, null);
    }

    public function loginGoogle()
    {
        $clientID = '241965399440-59ek83pl2u1scemevj8pbf868ctlgm2v.apps.googleusercontent.com';
        $clientSecret = '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';
        $redirectUrl = 'https://www.qceproba.com/';

        $client = new Google_Client();
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUrl);
        $client->addScope('profile');
        $client->addScope('email');
        $client->addScope('https://www.googleapis.com/auth/drive');
        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token);

            $gauth = new Google_Service_Oauth2($client);
            $google_info = $gauth->userinfo->get();
            $email = $google_info->email;
            $name = $google_info->name;
            $picture = $google_info->picture;


        } else {
            $loginUrl = $client->createAuthUrl();
            header('Location: ' . $loginUrl);
            exit();
        }
    }

    public function proba()
    {
        $email = "2002duguxiu@gmail.com";


        $userModel = new UsuariModel();
        $result = $userModel->read();
        var_dump($result);
    }
    public function userGoogle($params)
    {
        try {
            //Coprobacio sobre el URL, si no hay CODE pues retorna NULL
            $code = isset($params['code']) ? $params['code'] : null;
            //Si no equentra el CODE pues sale un exception
            if (!$code) {
                throw new Exception("Authorization code not found.");
            }
            //Sobre el tocken y URL
            $clientID = '241965399440-59ek83pl2u1scemevj8pbf868ctlgm2v.apps.googleusercontent.com';
            $clientSecret = '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';
            $redirectUrl = 'https://www.qceproba.com/';

            $tokenEndpoint = 'https://oauth2.googleapis.com/token';
            $tokenParams = [
                'code' => $code,
                'client_id' => $clientID,
                'client_secret' => $clientSecret,
                'redirect_uri' => $redirectUrl,
                'grant_type' => 'authorization_code',
            ];

            $ch = curl_init($tokenEndpoint);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $tokenParams);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);

            if ($response === false) {
                throw new Exception("Failed to retrieve access token. cURL error: " . curl_error($ch));
            }

            $tokenData = json_decode($response, true);
            if (!isset($tokenData['access_token'])) {
                throw new Exception("Access token not found in response.");
            }

            $accessToken = $tokenData['access_token'];

            $userInfo = $this->getUserInfo($accessToken);

            $userModel = new UsuariModel();
            $result = $userModel->read();
            $esta = false;
            for ($i = 0; $i < count($result); $i++) {
                if ($result[$i]["email"] === $userInfo["email"]) {
                    $esta = true;
                    $_SESSION['admin']=$result[$i]['es_administrador'];
                }
            }

            if ($esta == true) {
                //Guardar los datos de usuario en una session
                $_SESSION['user_info'] = $userInfo;
                //Guardar el token de usuario en la session
                $_SESSION['access_token'] = $accessToken;

                /****************************************************
                // // Prova：Retornar los datos de usuario -->Consegido tener los datos de usuario y permiso de Google Drive√
                // if($userInfo == null){
                //     echo "1";
                // }
                // echo "<pre>";
                // var_dump($userInfo);
                // echo "</pre>";
                ******************************************************/
                header("Location: https://www.qceproba.com/");
                // return $userInfo;
            } else {

                echo "<script>alert('No esta unido en la WEP, pide el administrador que añade tu usuario'); window.location.href = 'https://www.qceproba.com/';</script>";
            }




        } catch (Exception $e) {
            // Exception
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
    public function getUserInfo($accessToken)
    {
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
}


