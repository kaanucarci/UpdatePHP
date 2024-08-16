<?php

class Update
{
    private $Codes;
    private $Files;
    public function __construct($codes, $files)
    {
        $this->Codes = $codes;
        $this->Files = $files;

        $this->backupAndUpdateCodes($this->Codes, $this->Files);
    }




    private function backupAndUpdateCodes($response, $fileNames)
    {
        $count = 0;
        $backupDir = PATH.'\Yedek';
        $log = [];

        $fileNames = explode(",", $fileNames);


        if (!is_dir($backupDir))
        {
            if(!mkdir($backupDir, 0755, true))
            {
                $log['error'][$count]  = [
                    'fileName' => 'Backup directory',
                    'message' => 'Backup directory could not be created!'
                ];
            }
        }

        foreach ($fileNames as $fileName)
        {
            $backupFile = $backupDir . '/yedek-' . $fileName;

            if (!file_exists($backupFile))
            {
                if (!copy($fileName, $backupFile))
                {
                    $log['error'][$count] = [
                        'fileName' => $fileName,
                        'message' => 'Backup file could not be copied!'
                    ];
                    continue;
                }
                else{
                    $log['success'][$count] = [
                       'fileName' => $fileName,
                       'message' => 'Backup file created!'
                    ];
                    if (!file_put_contents(PATH.'/'.$fileName, $response[$fileName]))
                    {
                        $log['error'][$count] = [
                           'fileName' => $fileName,
                           'message' => 'File could not be updated!'
                        ];
                    }
                    else{
                        $log['success'][$count] = [
                           'fileName' => $fileName,
                           'message' => 'File updated!'
                        ];
                    }
                }


            }
            else
            {
                if (!file_put_contents($backupFile, file_get_contents($fileName)))
                {
                    $log['error'][$count] = [
                        'fileName' => $fileName,
                        'message' => 'Backup file could not be updated!'
                    ];
                    continue;
                }
                else{
                    $log['success'][$count]= [
                        'fileName' => $fileName,
                        'message' => 'Backup file updated!'
                    ];
                    if (!file_put_contents(PATH.'/'.$fileName, $response[$fileName]))
                    {
                        $log['error'][$count] = [
                            'fileName' => $fileName,
                            'message' => 'File could not be updated!'
                        ];
                    }
                    else{
                        $log['success'][$count]= [
                            'fileName' => $fileName,
                            'message' => 'File updated!'
                        ];
                    }
                }
            }
            $count++;
        }

        echo  json_encode($log);
    }
}

?>