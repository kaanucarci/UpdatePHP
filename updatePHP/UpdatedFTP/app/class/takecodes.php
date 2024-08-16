<?php
define("PATH" , realpath("../../"));

if(isset($_POST) && !empty($_POST["fileNames"]))
{
    getUpdatedCodes($_POST["fileNames"]);
} else {
    echo "Dosya açma hatası!";
    exit;
}


function getUpdatedCodes($fileNames)
{
    $fileNames = explode("," , $_POST["fileNames"]);

    foreach ($fileNames as $fileName)
    {

        $contentArray = file(PATH.'/'.$fileName);
        $content = implode('', $contentArray);

        $updatedCodes[$fileName] = $content;
    }

    echo json_encode($updatedCodes);
}

?>