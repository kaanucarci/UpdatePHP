<?php
require PATH.'/app/model/clientdal.php';

class Index
{

    const UPDATED_FTP = '/UpdatedPHPTest/app/class/takecodes.php';
    const FTPS_TO_UPDATE = 'UpdatedPHPTest/run.php';
public function visitUpdatedFtp($fileNames, $updatedClient)
{

    $url = 'http://'.$updatedClient. self::UPDATED_FTP;

    $data = [
        'fileNames' => $fileNames,
        'updatedClient' => $updatedClient
    ];


    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);

    $response = curl_exec($ch);
    $response = json_decode($response, true);
    if ($response === false)
    {
        throw new Exception('cURL Error: ' . curl_error($ch));
    }
    else
    {
       $responseFromFtp = $this->visitFtpsToUpdate($response, $data['fileNames']);

       return $responseFromFtp;
    }

    curl_close($ch);
}

private function visitFtpsToUpdate($response, $fileNames)
{
    $clientDal = new ClientDal();
    $clients = $clientDal->getAll();
    $clients = $clients["FtpsToUpdate"];

    $responses = [];

    foreach ($clients as $client)
    {
        if ($client["Status"] == 1):
            $url = $client["Domain"].self::FTPS_TO_UPDATE;

            $data = [
                'response' => $response,
                'fileNames' => $fileNames
            ];

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);

            $clientResponse = curl_exec($ch);
            $clientResponse = json_decode($clientResponse, true);
            if ($clientResponse === false)
            {
                throw new Exception('cURL Error: ' . curl_error($ch));
            } else
            {
                $responses[$client["FtpName"]] = $clientResponse;
            }

            curl_close($ch);

        endif;

    }

    return $responses;

}


}
?>