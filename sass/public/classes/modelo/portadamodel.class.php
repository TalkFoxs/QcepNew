<?php
class PortadaModel implements CRUDable
{
    const HOST = 'localhost';

    const USEREAD = 'usr_consulta';

    const PASSREAD = '2024@Thos';

    const USERINSERT = 'usr_generic';

    const PASSRINSERT = '2024@Thos';

    const DB = 'qcep';

    public function read($obj = null)
    {
        $mysqli = mysqli_connect(self::HOST, self::USEREAD, self::PASSREAD, self::DB);
        if ($mysqli->connect_errno) {
            die("Failed to connect to MySQL: " . $mysqli->connect_error);
        }

        if ($obj == null) {
            $portada = $mysqli->prepare("SELECT * FROM portada");
            if ($portada === false) {
                die("Error in preparing the SQL query: " . $mysqli->error);
            }

            $portada->execute();
            $result = $portada->get_result();

            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            $portada->close();
            $mysqli->close();
            return $rows;
        } else {
            $id = $obj;
            $portada = $mysqli->prepare("SELECT * FROM portada where id = ?");
            if ($portada === false) {
                die("Error in preparing the SQL query: " . $mysqli->error);
            }
            $portada->bind_param("i", $id);
            $portada->execute();
            $result = $portada->get_result();
            $portada->close();
            $mysqli->close();
            if ($result->num_rows === 0) {
                return null;
            }
            $data = $result->fetch_assoc();
            return $data;
        }
    }
    public function create($obj = null)
    {
        try {
            $id = $obj->id;
            $nom = $obj->nom;
            $icono = $obj->icono;
            $descripcio = $obj->descripcio;
            $enllac = $obj->enllac;

            $mysqli = new mysqli(self::HOST, self::USERINSERT, self::PASSRINSERT, self::DB);

            if ($mysqli->connect_errno) {
                throw new Exception("Failed to connect to MySQL: " . $mysqli->connect_error);
            }

            $portada = $mysqli->prepare("INSERT INTO portada VALUES(?,?,?,?,?)");

            if ($portada) {
                $portada->bind_param("issss", $id, $nom, $icono, $descripcio, $enllac);

                // Ejecutar
                $portada->execute();

                // Comprobar si ha ejecutado bien
                if ($portada->affected_rows > 0) {
                    $portada->close();
                    $mysqli->close();
                    return true;
                } else {
                    throw new Exception("SQL Error: " . $portada->error);
                }
            } else {
                throw new Exception("SQL Error: " . $mysqli->error);
            }
        } catch (Exception $e) {
            // Log or handle the exception as needed
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
        }
    }

    public function update($obj)
    {
        $id = $obj->id;
        $nom = $obj->nom;
        $icono = $obj->icono;
        $descripcio = $obj->descripcio;
        $enllac = $obj->enllac;

        $mysqli = mysqli_connect(self::HOST, self::USERINSERT, self::PASSRINSERT, self::DB);

        if ($mysqli->connect_errno) {
            die("Failed to connect to MySQL: " . $mysqli->connect_error);
        }

        $portada = $mysqli->prepare("UPDATE portada SET nom=?, icono=?, descripcio=?, enllac=? WHERE id = ?");

        if ($portada) {
            // Poner los paramentros
            $portada->bind_param("sssss", $nom, $icono, $descripcio, $enllac, $id);

            // Ejecutar
            $portada->execute();

            // Comprobar si ha ejecutado bien
            if ($portada->affected_rows > 0) {
                echo "Update Bien";
                $portada->close();
                $mysqli->close();
                return true;
            } else {
                echo "SQL Mal: " . mysqli_error($mysqli);
                echo "Update Mal";
                $portada->close();
                $mysqli->close();
                return false;
            }
        } else {
            echo "SQL Mal: " . mysqli_error($mysqli);
        }

        // Cerrar la conecion de la Base de Datos
        $mysqli->close();
    }
    public function delete($obj)
    {
        $id = $obj;

        $mysqli = mysqli_connect(self::HOST, self::USERINSERT, self::PASSRINSERT, self::DB);

        if ($mysqli->connect_errno) {
            die("Failed to connect to MySQL: " . $mysqli->connect_error);
        }
        $portada = $mysqli->prepare("DELETE FROM portada  WHERE id = ?");
        if ($portada) {
            // Poner los paramentros
            $portada->bind_param("i", $id);

            // Ejecutar
            $portada->execute();

            // Comprobar si ha ejecutado bien
            if ($portada->affected_rows > 0) {
                echo "Update Bien";
                $portada->close();
                $mysqli->close();
                return true;
            } else {
                echo "SQL Mal: " . mysqli_error($mysqli);
                echo "Update Mal";
                $portada->close();
                $mysqli->close();
                return false;
            }
        } else {
            echo "SQL Mal: " . mysqli_error($mysqli);
        }

        // Cerrar la conecion de la Base de Datos
        $mysqli->close();
    }
    public function maxId()
    {
        $mysqli = new mysqli(self::HOST, self::USERINSERT, self::PASSRINSERT, self::DB);

        $sql = "SELECT MAX(id) AS max_id FROM portada";

        $result = $mysqli->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            $maxId = $row['max_id'];
        } else {
            echo "Error: " . $mysqli->error . PHP_EOL;
            return null;
        }

        return $maxId;
    }
}
