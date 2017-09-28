<?php
	date_default_timezone_set('Asia/Shanghai');
	session_start();
	if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
    {
		header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
		die( header( 'location:/403.html' ) );
    }
	else
	{
		if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) )
		{
			header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
			die( header( 'location:/403.html' ) );
		}
		else
		{
			$array = json_decode($_POST['elements']);
			$zipname = date("Y-m-d H:i:s").'.zip';
			$zip = new ZipArchive;
			$zip->open($zipname, ZipArchive::CREATE);
			foreach ($array as $file)
			{
		  		$zip->addFile($file);
			}
			$zip->close();
			header('Content-Type: application/zip');
			header('Content-disposition: attachment; filename='.$zipname);
			header('Content-Length: ' . filesize($zipname));
			readfile($zipname);
			unlink($zipname);
		}
	}
?>
