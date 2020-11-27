<?php

function generateRandomString($length = 10) { 
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
	
	$charactersLength = strlen($characters); 

	$randomString = '';

	for ($i = 0; $i < $length; $i++) { 
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	} 

	return $randomString;
}

do{
	$token = "files_exec/".generateRandomString();

}while( is_dir($token) );


//$_POST["idtoken"];
$code = $_POST['code'];
$lang = isset($_POST['lang'])?$_POST['lang']:"c";

//Creating folder
$uritoken= $token."/";



if( !mkdir($uritoken) ){
	echo '{"status": "file-error"}';
	return;
}

if($lang == "c"){
	
	$namefile =$uritoken."code.c";
	$myfile = fopen($namefile, "w");
	fwrite($myfile, $code);
	fclose($myfile);
	$cmd = "gcc ".$namefile." -o ".$uritoken."file.exe 2> ".$uritoken."output";

}else if($lang == "py"){
	
	$namefile =$uritoken."code.py";
	$myfile = fopen($namefile, "w");
	fwrite($myfile, $code);
	fclose($myfile);
	$cmd = "python ".$namefile;
}

exec($cmd, $result, $error);

if($error){
	
	echo '{"status": "error"}';
	//return;
}else{
	
	echo '{"status": "noerror"}';
	//return;
}

sleep(1);

if( file_exists($uritoken."output") )
	unlink($uritoken."output");

if( file_exists($uritoken."code.c") )
	unlink($uritoken."code.c");

if( file_exists($uritoken."code.py"))
	unlink($uritoken."code.py");

if( file_exists($uritoken."file.exe"))	
	unlink($uritoken."file.exe");
if(is_dir($token))
	rmdir($token);


?>