<?php

namespace App\Services;

use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;

class SynDriveService  // Update service name
{
    protected function getClient($accessToken)
    {
        $accessToken = session('google_token');
        if (is_string($accessToken)) {
            $accessToken = json_decode($accessToken, true);
        }
    
        if (!is_array($accessToken) || !isset($accessToken['access_token'])) {
            throw new \InvalidArgumentException('Invalid access token format');
        }
    
        $client = new Google_Client();
        $client->setAccessToken($accessToken);
        $client->addScope(Google_Service_Drive::DRIVE);
    
        return $client;
    }
    
    public function uploadFile($file, $accessToken)
    {
        $client = $this->getClient($accessToken);
        $service = new Google_Service_Drive($client);

        $driveFile = new Google_Service_Drive_DriveFile();
        $driveFile->setName($file->getClientOriginalName());

        $result = $service->files->create($driveFile, [
            'data' => file_get_contents($file->getRealPath()),
            'mimeType' => $file->getMimeType(),
            'uploadType' => 'multipart',
            'fields' => 'id, name, webViewLink',
        ]);

        return $result;
    }

    public function listFiles($accessToken)
    {
        $client = $this->getClient($accessToken);
        $service = new Google_Service_Drive($client);

        $files = $service->files->listFiles([
            'pageSize' => 10,
            'fields' => 'files(id, name, webViewLink)',
        ]);

        return $files->getFiles();
    }
}
