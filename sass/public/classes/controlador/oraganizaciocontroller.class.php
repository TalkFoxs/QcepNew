<?php
class OraganizacioController extends Controlador
{
    public function show()
    {
        $queIdioma = $this->queIdioma();
        if ($_SESSION["admin"] === 1) {
            $organizacioVista = new OrganizacioVista();
            $organizacioaModel = new OraganizacioModel();

            $orgObj = $organizacioaModel->read();
            $html = $this->updateHtml($orgObj);

            $organizacioVista->show($queIdioma, $html, '', '');
        } else {
            $errorVista = new ErrorVista();
            $texto = new Exception('No tienes el permiso de CONFIGURAR LA PAGINA WEB');
            $errorVista->show($texto);
        }
    }



    public function updatedatos()
    {
        $queIdioma = $this->queIdioma();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Nom'])) {
            $nom = $this->sanitize($_POST["Nom"]);
            $email = $this->sanitize($_POST["email"]);
            $web = $this->sanitize($_POST["web"]);
            $logo = $this->sanitize($_POST["logo"]);

            var_dump($_FILES);
            // Ejecutar el metodo para guardar el imagen, y hacer un return la ruta de donde se guarda
            $portada = new Organizacio($nom, $email, $web, $logo);
            $protadaModel = new OraganizacioModel();
            $result = $protadaModel->update($portada);
            header("Location: https://www.qceproba.com/");
        } else {
            $errorVista = new ErrorVista();
            $texto = new Exception('ERROR');
            $errorVista->show($texto);
        }
    }


    public function updateHtml($obj)
    {
        $html = "
        <form action='?oraganizacio/updatedatos' method='post' enctype='multipart/form-data'>
    ";
        if ($_SESSION["admin"] === 1) {
            foreach ($obj as $key => $value) {
                foreach ($value as $k => $var) {
                    if ($k == "logo") {
                        $html .= "<label for='logo'>Sube el LOGO que quieres:</label>";
                        $html .= "<input type='file' name='logo' id='logo' accept='.png, .jpg' ><br>";
                    } else {
                        $html .= "<label>{$k}:</label></br>
                            <input type='text' id='{$k}' name='{$k}' value='{$var}'><br>";
                    }
                }
            }
        }
        $html = $html . " <input type='submit' value='MODIFICAR'>";
        $html = $html . " <a href='https://www.qceproba.com/?oraganizacio/show'>Volver</a>";
        $html = $html . "  </form>";
        return $html;
    }
}
