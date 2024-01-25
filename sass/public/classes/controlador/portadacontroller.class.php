<?php
class PortadaController extends Controlador
{
    public function show()
    {
        $queIdioma = $this->queIdioma();
        if ($_SESSION["admin"] === 1) {
            $protadaVista = new PortadaVista();
            $protadaModel = new PortadaModel();
            $result = $protadaModel->read();
            $html = $this->readHtml($result);
            $protadaVista->show($queIdioma, $html, '', '');
        } else {
            $errorVista = new ErrorVista();
            $texto = new Exception('No tienes el permiso de CONFIGURAR LA PAGINA WEB');
            $errorVista->show($texto);
        }
    }

    public function showupdate()
    {
        $queIdioma = $this->queIdioma();
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['uid'])) {
            $id = $_GET["uid"];
            $protadaVista = new PortadaVista();
            $protadaModel = new PortadaModel();
            $result = $protadaModel->read($id);
            if ($result == null) {
                $errorVista = new ErrorVista();
                $texto = new Exception('No existe la portada que quieres modificar');
                $errorVista->show($texto);
            } else {
                $html = $this->configShow($result);
                $protadaVista->show($queIdioma, $html, '', '');
            }
        }
    }

    public function update()
    {
        $queIdioma = $this->queIdioma();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
            $id = $this->sanitize($_POST["id"]);
            $nom = $this->sanitize($_POST["nom"]);
            $icono = $this->sanitize($_FILES["icono"]["name"]);
            $descripcio = $this->sanitize($_POST["descripcio"]);
            $enllac = $this->sanitize($_POST["enllac"]);

            var_dump($_FILES);
            // Ejecutar el metodo para guardar el imagen, y hacer un return la ruta de donde se guarda
            if ($_FILES['icono']['error'] === 0) {
                $fileInputName = 'icono';
                $uploadDirectory = './img/portada/';
                $icono = $this->saveUploadedFile($fileInputName, $uploadDirectory);
            }
            $portada = new Portada($id, $nom, $icono, $descripcio, $enllac);
            $protadaVista = new PortadaVista();
            $protadaModel = new PortadaModel();
            $result = $protadaModel->update($portada);
            if ($result) {
                $show = $protadaModel->read($id);
                $html = $this->configShow($show);
                $protadaVista->show($queIdioma, $html, 'Update Correcto');
            } else {
                
            }
        } else {
            $errorVista = new ErrorVista();
            $texto = new Exception('No existe la portada que quieres modificar');
            $errorVista->show($texto);
        }
    }



    public function readHtml($obj)
    {
        $html = "<button><a href='?portada/add'>ADD</a></button>";

        foreach ($obj as $value) {
            $html .= "<table>";

            foreach ($value as $k => $var) {
                if ($k !== "id") {
                    $html .= "<tr>";
                    $html .= "<th>{$k}</th>";
                    $html .= "<td>{$var}</td>";
                    $html .= "</tr>";
                }
            }

            $html .= "<tr>";
            $html .= "<td colspan='2'><button type='button'><a href='?portada/showupdate&uid={$value["id"]}' method='GET'>Cambiar</a></button></td>";
            $html .= "</tr>";

            $html .= "</table>";
        }

        return $html;
    }

    public function configShow($portada)
    {
        $html = "
        <form action='?portada/update' method='post' enctype='multipart/form-data'>
    ";
        if ($_SESSION["admin"] === 1) {
            foreach ($portada as $key => $value) {
                if ($key == "icono") {
                    $html .= "<label for='icono'>Sube el imagen que quieres:</label>";
                    $html .= "<input type='file' name='icono' id='icono' accept='.png, .jpg' ><br>";
                } else if ($key !== "id") {
                    $html .= "<label>{$key}:</label></br>
                        <input type='text' id='{$key}' name='{$key}' value='{$value}'><br>";
                } else {
                    $html .= "<input type='hidden' name='id' value='{$value}'>";
                    $html .= "<label>{$key}:{$value} <span class ='error'>El ID no se puede cambiar</span></label></br>";
                }


            }
        }
        $html = $html . " <input type='submit' value='MODIFICAR'>";
        $html = $html . "  </form>";
        return $html;
    }

    public function saveUploadedFile($fileInputName, $uploadDirectory)
    {
        // Cosegir los datos de los imagenes
        $fileName = $_FILES[$fileInputName]['name'];
        $fileTmpName = $_FILES[$fileInputName]['tmp_name'];
        $fileError = $_FILES[$fileInputName]['error'];

        // Comprobar si hemos usbido un imagen o no
        if ($fileError === 0) {
            // Cuntar la ruta y el nombre del imagen
            $savePath = $uploadDirectory . $fileName;

            // Si existe el fichero pues eliminamos el fichero de anters
            if (file_exists($savePath)) {
                unlink($savePath);
            }

            // Mover el imagen que hemos pedido
            if (move_uploaded_file($fileTmpName, $savePath)) {
                // Retorna la ruta absoluta
                return $savePath;
            } else {
                // Mover el imagen mal
                echo "File upload failed: " . $_FILES[$fileInputName]['error'];
                return false;
            }
        } else {
            // Si sale un error en subir el imagen
            return false;
        }
    }



}
?>