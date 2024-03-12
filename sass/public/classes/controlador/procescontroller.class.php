<?php
class ProcesController extends Controlador
{
    public function show()
    {
        $fitxerDeTraduct = $this->queIdioma();
        if ($_SESSION["admin"] === 1) {
            $procesVista = new ProcesVista();
            $procesModel = new ProcesModel();
            $proceData = $procesModel->read();

            $html = $this->showHtml($proceData);
            $procesVista->show($fitxerDeTraduct, $html);
        }
    }
    public function addshow()
    {
        $fitxerDeTraduct = $this->queIdioma();
        if ($_SESSION["admin"] === 1) {
            $procesVista = new ProcesVista();
            $procesModel = new ProcesModel();
            $proceData = new Proces(null, null, null, null);

            $html = $this->addHtml($proceData);
            $procesVista->show($fitxerDeTraduct, $html);
        }
    }
    public function eliminarProces()
    {
    }


    public function showHtml($obj)
    {
        $html = "<a href='?proces/addshow'><button>Añadir</button></a>";
        $html .= "<div id='sortable-list'class='cards'>";
        foreach ($obj as $value) {
            $html .= "<a href='?doc/documents&proces=" . $value->nom . "'><div data-id='{$value->nom}' class=\"card\">
                        <h2>{" . $value->nom . "}: " . $value->objectiu . "</h2>
                     </div></a>";
        }
        $html .= "</div>";
        return $html;
    }
    public function addHtml($obj)
    {
        $user = $_SESSION["user_info"]["email"];
        $html = "<form action='?proces/add' ><div>";
        $html .= "<label for='usuari'>Creador:</label> {$user}</br>";
        $html .= "<label for='name'>Nombre:</label><input type='text' name='name' id='name'></input></br>";
        $html .= "<label for='tipo'>Tipo:</label><input type='text' name='tipo' id='tipo'></input></br>";
        $html .= "<label for='objetivo'>Objetivo:</label><textarea rows='4' cols='50'></textarea></br>";
        $html .= "<input type='submit' value='Crear proceso'/><a href='https://www.qceproba.com/?proces/show'>Volver</a>";
        $html .= "</div></form>";

        echo $html;
        return $html;
    }
}
