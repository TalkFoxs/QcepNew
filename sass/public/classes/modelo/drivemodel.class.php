<?php
class DriveModel implements CRUDable
{

    public function crearCarpeta($nom)
    {
        try {
            //Segurar que el usuario esta en login y que obtiene el acceso de token
            if (!isset($_SESSION['access_token'])) {
                // Si el usuario no esta en login pues un ERROR
                echo "User not logged in.";
                return;
            }

            $accessToken = $_SESSION['access_token'];

            // Configurar el Cliente Google API
            $client = new Google_Client();
            $client->setAccessToken($accessToken);
            $driveService = new Google_Service_Drive($client);

            // El nombre del la carpeta
            $folderName = "$nom";

            // Comprobar si existe la carpeta o no
            $folderExists = false;
            $optParams = [
                'q' => "mimeType='application/vnd.google-apps.folder' and name='$folderName'",
            ];
            $files = $driveService->files->listFiles($optParams);

            foreach ($files->getFiles() as $file) {
                $folderExists = true;
                break;
            }

            //Si no existe pues crea la carpeta
            if (!$folderExists) {
                $fileMetadata = new Google_Service_Drive_DriveFile([
                    'name' => $folderName,
                    'mimeType' => 'application/vnd.google-apps.folder',
                ]);
                $folder = $driveService->files->create($fileMetadata, [
                    'fields' => 'id',
                ]);

                echo "Folder '$folderName' created with ID: " . $folder->id;
            } else {
                echo "Folder '$folderName' already exists.";
            }

        } catch (Exception $e) {
            // 处理异常
            echo "Error: " . $e->getMessage();
        }
    }



    public function read($obj = null)
    {

    }
    public function create($obj = null)
    {

    }
    public function update($obj = null)
    {

    }
    public function delete($obj = null)
    {

    }

}

?>