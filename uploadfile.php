<?php
/* 
$ftp_server="";
$ftp_user="";
$ftp_pass="";

$con_id= ftp_connect($ftp_server);
$lr= ftp_login($con_id,$ftp_user,$ftp_pass);

if ((!$con_id) || (!$lr)) {
    echo "No se pudo realizar la conexion";
    exit;
}else{
    echo "Conectado correctamente";
    $temp=explode(".",$_FILES["archivo"]["name"]);
    $source_file=$_FILES["archivo"]["tmp_name"]
}
*/
if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Subir') {
    if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
        // get details of the uploaded file
        $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
        $fileName = $_FILES['uploadedFile']['name'];
        $fileSize = $_FILES['uploadedFile']['size'];
        $fileType = $_FILES['uploadedFile']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $newFileName = md5(time() . $fileName) . '.' . $fileExtension
    
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc');
        if (in_array($fileExtension, $allowedfileExtensions)) {
        // directory in which the uploaded file will be moved
            $uploadFileDir = './files/';
            $dest_path = $uploadFileDir . $newFileName;
            
            if(move_uploaded_file($fileTmpPath, $dest_path))
            {
            $message ='File is successfully uploaded.';
            }
            else
            {
            $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
            }
        }
    
    }
}