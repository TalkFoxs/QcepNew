<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

class DocumentController
{
    public function documents()
    {
        $data = [];
        $resultProces = [];
        $apartats = [];
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["proces"])) {
            $proces_nom = $_GET["proces"];
            $document = new Document(null, null, null, $proces_nom);
            $documentModel = new DocumentModel();
            $result = $documentModel->read($document);
            if (count($result) !== 0) {
                $data = $result;
            }

            $proces = new Proces($proces_nom, null, null, null);
            $procesM = new ProcesModel();
            $resultProces = $procesM->read($proces);
        }
    }

    public function generateHeader($org)
    {
        $html = "";
        foreach ($org as $inc) {
            $html = $html . "
            <div class=\"inc\">
                <a href=\"" . $inc->web . "\"><img class=\"logo\" src=\"" . $inc->logo . "\" alt=\"" . $inc->nom . "\"/></a>
                <h2>" . $inc->nom . "</h2>
            </div>
            <button class=\"logOut\"><a href=\"?home/show\">Log Out</a></button>";
        }
        return $html;
    }

    public function generateFooter($apartats)
    {
        $html = '';
        foreach ($apartats as $apartat) {
            $html = $html . "
            <div>
                <a href=\"" . $apartat->link . "\" target=\"_blank\"><img src=\"" . $apartat->icona . "\" alt=\"" . $apartat->nom . "\" /></a>
                <p>" . $apartat->nom . "</p>
            </div>";
        }

        return $html;
    }
}
