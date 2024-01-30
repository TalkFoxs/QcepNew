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
    public function addShow()
    {
        $queIdioma = $this->queIdioma();
        if ($_SESSION["admin"] === 1) {
            $protadaVista = new PortadaVista();
            $html = $this->addHtml();
            $protadaVista->show($queIdioma, $html, '', '');
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

    public function add()
    {
        $queIdioma = $this->queIdioma();
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['nom']) && isset($_POST['nom']) && isset($_POST['descripcio']) && isset($_POST['enllac'])) {
            $id = (int)$this->sanitize($_POST["id"]);
            $nom = $this->sanitize($_POST["nom"]);
            $icono = $this->sanitize($_FILES["icono"]["name"]);
            $descripcio = $this->sanitize($_POST["descripcio"]);
            $enllac = $this->sanitize($_POST["enllac"]);
            if ($_FILES['icono']['error'] === 0) {
                $fileInputName = 'icono';
                $uploadDirectory = './img/portada/';
                $icono = $this->saveUploadedFile($fileInputName, $uploadDirectory);
            }
            $portada = new Portada($id, $nom, $icono, $descripcio, $enllac);
            $protadaVista = new PortadaVista();
            $protadaModel = new PortadaModel();
            $result = $protadaModel->create($portada);
            header("Location: https://www.qceproba.com/?portada/show");
        } else {
            $errorVista = new ErrorVista();
            $texto = new Exception('No existe la portada que quieres modificar');
            $errorVista->show($texto);
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

    public function delete()
    {
        $queIdioma = $this->queIdioma();
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['uid'])) {
            $id = $_GET["uid"];
            $protadaVista = new PortadaVista();
            $protadaModel = new PortadaModel();
            $result = $protadaModel->delete($id);
            if ($result == null) {
                $errorVista = new ErrorVista();
                $texto = new Exception('No existe la portada que quieres modificar');
                $errorVista->show($texto);
            } else {
                $result = $protadaModel->read();
                $html = $this->readHtml($result);
                $protadaVista->show($queIdioma, $html, '', '');
            }
        }
    }

    public function addHtml()
    {
        $html = "<form action='?portada/add' method='post' enctype='multipart/form-data'>";

        if ($_SESSION["admin"] === 1) {
            $protadaModel = new PortadaModel();
            $maxId = $protadaModel->maxId() + 1;

            $html .= "<label>El ID que añades es: {$maxId}</label><br>";
            $html .= "<input type='hidden' id='id' name='id' value='{$maxId}'><br>";

            $html .= "<label>Pon el Nombre que quieres: </label><br>";
            $html .= "<input id='nom' name='nom'><br>";

            $html .= "<label for='icono'>Sube el imagen que quieres:</label>";
            $html .= "<input type='file' name='icono' id='icono' accept='.png, .jpg'><br>";

            $html .= "<label>Pon el descripcion: </label><br>";
            $html .= "<input id='descripcio' name='descripcio'><br>";

            $html .= "<label>Pon el enlace: </label><br>";
            $html .= "<input id='enllac' name='enllac'><br>";

            $html .= "<input type='submit' value='MODIFICAR'>";
            $html = $html . " <a href='https://www.qceproba.com/?portada/show'>Volver</a>";
        }

        $html .= "</form>";

        return $html;
    }


    public function readHtml($obj)
    {
        $html = "<button><a href='?portada/addShow'>ADD</a></button>";

        foreach ($obj as $value) {
            $html .= "<table>";

            foreach ($value as $k => $var) {
                if ($k == "icono") {
                    $html .= "<tr>";
                    $html .= "<th>{$k}</th>";
                    $html .= "<td><img class='iconoImg' src='{$var}'/></td>";
                    $html .= "</tr>";
                } else if ($k !== "id") {
                    $html .= "<tr>";
                    $html .= "<th>{$k}</th>";
                    $html .= "<td>{$var}</td>";
                    $html .= "</tr>";
                }
            }

            $html .= "<tr>";
            $html .= "<td colspan='2' class='deletModi'><button type='button'><a href='?portada/showupdate&uid={$value["id"]}' method='GET'>Cambiar</a></button><button type='button'><a href='?portada/delete&uid={$value["id"]}' method='GET'>DELETE</a></button></td>";
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
        $html = $html . " <a href='https://www.qceproba.com/?portada/show'>Volver</a>";
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
