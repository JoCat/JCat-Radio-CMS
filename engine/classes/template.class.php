<?php

class jle_tpl
{
	private $vars = array();
	var $template;
	function set( $name, $value ) 
	{
		$this -> vars[ $name ] = $value;
    }
	function showmodule( $tmp ) 
	{
		$tpl = $this -> template ."/". $tmp;
		if ( !file_exists( $tpl ) ) die( "Template module ". $tpl ." not found!" );
		$tpl = file_get_contents( $tpl );
		if ( count( $this -> vars ) > 0 ) 
			foreach ( $this -> vars as $name => $value )
				$tpl = str_replace( $name, $value, $tpl );
		return $tpl;
    }
	function showtemplate( ) 
	{
		$tpl = $this -> template ."/main.tpl";
		if ( !file_exists( $tpl ) ) die( "Template ". $tpl ." not found!" );
		$tpl = file_get_contents( $tpl );
		if ( count( $this -> vars ) > 0 ) 
			foreach ( $this -> vars as $name => $value )
				$tpl = str_replace( $name, $value, $tpl );
		echo $tpl;
    }
}
$tpl = new jle_tpl;
?>