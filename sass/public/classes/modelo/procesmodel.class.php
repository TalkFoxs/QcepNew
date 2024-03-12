<?php
include './classes/config/UsuarioDB.php';

class ProcesModel implements CRUDable
{
    private $pdo;

    public function __construct()
    {
        $dsn = "mysql:host=" . HOST . ";dbname=" . DB;
        $this->pdo = new PDO($dsn, ROOT, PASSRINSERT);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function read($obj = null)
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM proces");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = [];
            foreach ($rows as $row) {
                $proces = new Proces($row['nom'], $row['tipus'], $row['objectiu'], $row['usuari_email']);
                $result[] = $proces;
            }
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function create($obj = null)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Organitzacio (id, nom, icono, descripcio, enllac) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$obj->id, $obj->nom, $obj->icono, $obj->descripcio, $obj->enllac]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function update($obj)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE Organitzacio SET Nom=?, email=?, web=?, logo=? WHERE id = ?");
            $stmt->execute([$obj->nom, $obj->email, $obj->web, $obj->logo, $obj->id]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function delete($obj)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM portada WHERE id = ?");
            $stmt->execute([$obj]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function maxId()
    {
        try {
            $stmt = $this->pdo->query("SELECT MAX(id) AS max_id FROM portada");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['max_id'];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}
