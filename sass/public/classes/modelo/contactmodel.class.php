<?php
class ContactModel implements CRUDable{
    const FILE = "docs/missatgesDeContacte.xml";
    public function __construct(){
        $this->file = file_get_contents(self::FILE);
    }
    public function read($obj=null)
    {
        $contactes = [];
        if (!($fitxer = simplexml_load_file(self::FILE))) {
            throw new Exception("No s'ha pogut obrie el fitxer ".self::FILE);
        }
        
        foreach ($fitxer->children() as $child) {
            $data = $child->DATA->__toString();
            $id = $child->ID->__toString();
            $comentari = $child->COMENTARI->__toString();
            $contactes[] = new Contact($id,$comentari, $data);
        }
        return $contactes;
    }

    public function create($obj)
    {
        $sLlibre = $this->file;
        $sLlibre = substr($sLlibre,0,-13);
        $sLlibre .= "\n<REGISTRE>\n<DATA>{$obj->data}</DATA>\n";
        $sLlibre .="        <ID>{$obj->id}</ID>\n  ";
        $sLlibre .= "        <COMENTARI>{$obj->missatge}</COMENTARI>\n    </REGISTRE> \n";
        $sLlibre .= "</REGISTRES>";
        if ($file = fopen(self::FILE, "w")) {
            if (!fputs($file,$sLlibre)) {
                throw new Exception("El fitxer no deixa escriure");
            }
            fclose($file);
        } else {
            throw new Exception ("No s'ha pogut obrir el fitxer per emmagatzemar informació");
        }
    }

    public function update($obj)
    {}

    public function delete($obj)
    {}

    
}

