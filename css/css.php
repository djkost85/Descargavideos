<?php
$cssNombreReset		= 'reset.min.css';

$cssNombreAll		= 'all.min.css';
$cssNombreFuentes	= 'font/fuentes.min.css';

$cssTimeAll			= filemtime($cssNombreAll);
$cssTiempoFuentes	= filemtime($cssNombreFuentes);


$etag = '"'.$cssTimeAll.$cssTiempoFuentes.'"';

//print_r($_SERVER);


$if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ? $_SERVER['HTTP_IF_NONE_MATCH'] : false;

header('Content-Type: text/css; charset=UTF-8');

if($if_none_match && $if_none_match === $etag){
	header('HTTP/1.1 304 Not Modified');
	exit;
}
else{
	header('ETag: '.$etag);
	header('Cache-Control: public, max-age=2592000'); //30 días
	
	$encoding = $_SERVER['HTTP_ACCEPT_ENCODING'];
	
	if(strpos($encoding, 'gzip') >= 0){
	
		header('Content-Encoding: gzip');
		
		$aComprimir = file_get_contents($cssNombreReset);
		$aComprimir .= file_get_contents($cssNombreAll);
		$aComprimir .= file_get_contents($cssNombreFuentes);
		
		echo gzencode($aComprimir, 9);
		
	}
	else{
		include $cssNombreReset;
		include $cssNombreAll;
		include $cssNombreFuentes;
	}
}
?>