<h1>Accueil <?= ucfirst( $_GET[ 'p' ] ) ?></h1>
<?php
use  Gc7\Helper\GC7Tip;


$nbLances = 1e5;

$faces = array_fill( 0, 6, 0 );

$pFace       = range( 0, 9 );
$tiragePiped = function ( $pFace ) {
	$face = array_rand( $pFace );
	$face = ( $face < 5 ) ? $face : 5;

	return $face;
};

for ( $i = 0; $i < $nbLances; $i ++ ) {
	$tiree = $tiragePiped( $pFace );
	$faces[ $tiree ] ++;
}


echo '<br><p>' . GC7Tip::nf( $i, 0 ) . ' lancés d\'un dé pipé (La face 6 est "allourdie" 5 fois)</p><br>';

echo '<table class="table table-bordered thead-dark table-striped">
<thead class="table-dark" style="text-align: center"><th>Face</th><th>Sorties</th><th>%</th></thead>';

foreach ( $faces as $k => $v ) {
	echo '<tr style="text-align: right; padding-right: 200px;"><td style="text-align: right; padding-right: 15%">
' . ( $k + 1 ) . '</td><td style="text-align: right; padding-right: 15%">' . Gc7Tip::nf( $v, 0 ) . '</td><td
style="text-align: right; padding-right: 15%">
' . Gc7Tip::nf( $v * 1e2 / $nbLances ) . '</td></tr>';
}
echo '</table>';

