<?php

const PATH = '..';

require_once '../app/model/clientdal.php';


class Ajax extends ClientDal
{
    public $request;
    public $data;
    public $ftpData;
    public function __construct($request, $data)
    {
        $this->request = $request;
        $this->data = $data;

        $this->ftpData = parent::getAll()['FtpsToUpdate'];

        call_user_func([$this, $this->request], $this->data);

    }

    public function setStatus($data)
    {

        $proccess = $data['proccess'];
        $ftpId  = $data['ftpId'];

        foreach ($this->ftpData as &$ftpValues) {

            if ($ftpValues['id'] == $ftpId) {

                $ftpValues['Status'] = (int)$proccess;
                break;
            }

        }

        unset($ftpValues);

        $this->ftpData['FtpsToUpdate'] = $this->ftpData;
        $array['FtpsToUpdate'] =  $this->ftpData['FtpsToUpdate'];

        if (file_put_contents('../app/model/fakedatabase.json', json_encode($array)))
            echo 'Ftp Güncellendi!';
        else
            echo 'Ftp Güncellenemedi!';

    }

    public function saveChanges($data)
    {
        $newFtpData = array();

        for ($i = 0; $i < count($data['ftpId']); $i++)
        {
            $ftpId = isset($data['ftpId'][$i]) ? $data['ftpId'][$i] : null;
            $ftpName = isset($data['ftpName'][$i]) ? $data['ftpName'][$i] : null;
            $ftpUrl = isset($data['ftpUrl'][$i]) ? $data['ftpUrl'][$i] : null;
            $ftpStatu = isset($data['ftpStatu'][$i]) ? $data['ftpStatu'][$i] : null;

            $newFtpData['FtpsToUpdate'][$i] = array(
                'id' => $ftpId,
                'FtpName' => $ftpName,
                'Domain' => $ftpUrl,
                'Status' => $ftpStatu
            );
        }

        if (file_put_contents('../app/model/fakedatabase.json', json_encode($newFtpData)))
            echo "1";
        else
            echo "0";
    }
}

if (isset($_POST['request']) && isset($_POST['data']))
{

    $data = $_POST;

    new Ajax($data['request'], $data['data']);

}
else{
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    new Ajax($data['request'], $data['data']);
}
?>