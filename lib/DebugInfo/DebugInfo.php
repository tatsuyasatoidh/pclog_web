<?php
class DebugInfo{
	
	function __construct(){
		ini_set( 'display_errors', 1 );
	}
	
	function dump($str){
		$dbg=debug_backtrace();
		echo "<pre>";
		print_r($str);
		echo "</pre>";
	}
	
	
}