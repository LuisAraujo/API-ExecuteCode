<?php

include "geraterandompath.php";

//get a valid path
do{
	$token = "files_exec/".generateRandomString();

}while( is_dir($token) );

//code sended
$code = $_POST['code'];
//lang of code
$lang = isset($_POST['lang'])?$_POST['lang']:"c";

//creating folders
$uritoken= $token."/";

//has dir?
if( !mkdir($uritoken) ){
	echo '{"status": "file-error"}';
	return;
}

/*Language supported: c and python*/
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

//executing code
exec($cmd, $result, $error);

//has a error?
if($error){	
	echo '{"status": "error"}';
}else{
	echo '{"status": "noerror"}';
}

//delete all file gerate

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