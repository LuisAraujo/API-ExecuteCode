<?php

$token = "AAA";//$_POST["idtoken"];
$code = $_POST['code'];
//Creating folder
$uritoken= $token."/";

unlink($uritoken."code.c");	
unlink($uritoken."file.exe");	
rmdir($token);


if( !mkdir($uritoken) ){
	echo '{"status": "file-error"}';
	return;
}


$namefile =$uritoken."code.c";
$myfile = fopen($namefile, "w");

fwrite($myfile, $code);

$cmd = "gcc ".$namefile." -o ".$uritoken."file.exe 2> output";
exec($cmd, $result, $error);

if($error){
	
	echo '{"status": "error"}';
	return;
}else{
	
	echo '{"status": "noerror"}';
	return;
}



?>