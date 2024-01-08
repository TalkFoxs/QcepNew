<?php

class FrontController extends Controlador
{
    const DEFAULT_ACTION = "show";
    const DEFAULT_CONTROLLER = "HomeController";

    public function dispatch()
    {
        $params = NULL;
        if (isset($_GET['code'])) {
            // 如果存在 'code' 参数，将请求路由到 Google 授权回调处理器
            $controller_name = "usercontroller";
            $action = "userGoogle";

            // 在这里可以将其他参数添加到 $params 数组中，以传递给回调处理器
            $params = ['code' => $_GET['code']];
            foreach ($_GET as $key => $value) {
                // 排除 'code' 参数，因为它已经单独添加
                if ($key !== 'code') {
                    $params[$key] = $value;
                }
            }
            // 后续代码保持不变，调用指定的控制器和操作
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



