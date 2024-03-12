<?php
class EmpresaDatos{



    public static function sessionDatos(){
        $oragaModel = new OraganizacioModel();
        $orgaInfo = $oragaModel->read();
        $_SESSION["Organizacion"]=$orgaInfo;
    }
}

?>