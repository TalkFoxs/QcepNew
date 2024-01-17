<?php

class FrontController extends Controlador
{
    const DEFAULT_ACTION = "show";
    const DEFAULT_CONTROLLER = "HomeController";

    public function dispatch()
    {
        $params = NULL;
        if (isset($_GET['code'])) {
            // Si existe el Code pues va en ?userGoogle
            $controller_name = "usercontroller";
            $action = "userGoogle";


            $params = ['code' => $_GET['code']];
            foreach ($_GET as $key => $value) {

                if ($key !== 'code') {
                    $params[$key] = $value;
                }
            }

        } elseif (count($_GET) == 0) {
            $action = self::DEFAULT_ACTION;
            $controller_name = self::DEFAULT_CONTROLLER;
        } else {
            $url = array_keys($_GET)[0];
            $url = $this->sanitize($url);
            $url = trim($url, "/");
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode("/", $url);
            if (isset($url[0])) {
                $controller_name = ucwords($url[0]) . "Controller";
                if (isset($url[1])) {
                    $action = $url[1];
                }
                if (count($url) > 2) {
                    for ($i = 2; $i < count($url); $i++) {
                        $params[] = strtolower($url[$i]);
                    }
                }
            }
        }
        if (file_exists("classes/controlador/" . strtolower($controller_name) . ".class.php")) {
            $controller = new $controller_name();
            if (method_exists($controller, $action)) {
                $controller->$action($params);
            } else {
                throw new Exception("No existeix l'acció definida $action de $controller_name");
            }
        } else {
            throw new Exception("No existeix el controlador demanat $controller_name");
        }
    }
}



