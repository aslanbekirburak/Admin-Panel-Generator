<?php
$url = $_SERVER['REQUEST_URI'];
$url = parse_url($url);
$url = explode("/", $url['path']);
$url = $url[count($url)-1]; 
?>