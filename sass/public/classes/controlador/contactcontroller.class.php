<?php

class ContactController extends Controlador
{

    public function show()
    {
        if(isset($_SESSION['datos'])){
            $fitxerDeTraduccions = $this->queIdioma();
            $contactPag = new ContactaVista();
            $contactPag->show($fitxerDeTraduccions, null);
        }else{
            throw new Exception("Falta Login");
        }
       
    }

    public function info()
    {
        $errors = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["boto"])) {
            $fitxerDeTraduccions = $this->queIdioma();
            $menssage = $this->sanitize($_POST['missatge'], 3);
            if (strlen($menssage) == 0) {
                $errors["missatge"] = "Has d'escriure el comentari que vols enviar";
            }
            if (!empty($errors)){
                $contactPag = new ContactaVista();
                $contactPag->show($fitxerDeTraduccions, $errors);
            }else{
                $menssage=$this->sanitize($_POST['missatge']);
                $sData = getdate();
                $data=$sData['mday']."/".$sData['mon']."/".$sData['year'];
                $contact = new contact($_SESSION['datos']['id'], $menssage, $data);
                $mContact = new ContactModel();
                $mContact->create($contact);
                $home = new HomeController();
                $home->show();
            }
            
        }
    }
    public function read() {
        $fitxerDeTraduccions = $this->queIdioma();
        if(isset($_SESSION['datos'])){
            $cos = "";
            $mContacte = new ContactModel();
            $contactes = array_reverse($mContacte->read());
            $capcelera = "<tr><th>Missatge</th><th>ID</th><th>Data</th>\n";
            foreach ($contactes as $key => $value) {
                $cos .= "<tr><td>{$value->missatge}</td><td>{$value->id}</td><td>{$value->data}</td>";
            }
            $resultat = "<table><thead>$capcelera</thead><tbody>$cos</tbody></table>";
        }else{
            throw new Exception("Falta Login");
        }
        $vManteniment =new ContactaVista();
        $vManteniment->manteniment($fitxerDeTraduccions, $resultat);
    }
}

