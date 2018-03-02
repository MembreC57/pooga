<?php namespace Gc7\Divers\Personnage;

spl_autoload_register(function ($class) {
    $arr = explode('\\', $class);
    include end($arr) . '.php';
});

//var_dump( Gc7\Math::withZero( 5 ) );

$merlin  = new Personnage( 'Merlin' );
$harry   = new Personnage( 'Harry' );
$legolas = new Archer( 'Legolas', 70 );
$legolas->attaque( $harry );
var_dump( $merlin, $harry, $legolas );

echo '<hr>';

$merlin = new Personnage( 'Merlin' );
$merlin->regenerer();
$harry = new Personnage( 'Harry' );
var_dump( $merlin, $harry, $legolas );

