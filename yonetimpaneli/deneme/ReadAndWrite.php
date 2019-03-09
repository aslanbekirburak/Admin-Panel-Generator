<?php

$source='input_text.txt';
$target='read.txt';

$lines=file( $source );
$data=array();
foreach( $lines as $line ){
    $data[]='' . trim( $line );
}
/* write the content back to another file */
file_put_contents( $target, implode( PHP_EOL, $data ) );
?>
