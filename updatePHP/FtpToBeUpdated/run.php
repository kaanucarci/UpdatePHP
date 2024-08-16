<?php
define("PATH", realpath("."));

require_once PATH . '\app\class\update.php';

if (isset($_POST) && !empty($_POST))
{
   $data = $_POST;
   $update = new Update($data["response"], $data["fileNames"]);
}
?>