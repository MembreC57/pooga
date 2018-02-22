<?php namespace Gc7Ga;

require 'Gc7.php';

class Admin extends Gc7 {

	protected $folders, $new;
	private static      $_adminInstance;

	public static function getInstance () {
		if ( ! self::$_adminInstance ) {
			self::$_adminInstance = new Admin();
			//var_dump( 'iniInstance', self::$_adminInstance );
		}

		//var_dump( 'instance', self::$_adminInstance );
		//echo $_SERVER['REQUEST_URI'];
		return self::$_adminInstance;
	}


	public function __construct () {
		parent::__construct();
		//$this->gc7 = parent::getInstance();


		//$this->folders = $this->getFolders();
		//$this->oApps = $this->getJson( self::GC7_JSON )->apps;
		//$this->apps = $this->getApps();

		//var_dump( 'Constr', $this );
	}

	public function __destruct () {

		var_dump( 'Destr', $this );
	}

	public function aff () {
		//var_dump( get_call_class());
		//$app = json_decode( file_get_contents( '' . Gc7::GC7_JSON ) );
		$app = json_decode( file_get_contents( Gc7::GC7_JSON ) );
		//var_dump( $app );

		$this->folders = $this->getFolders();

		$this->oApps = $this->getJson( self::GC7_JSON )->apps;

		$this->apps = $this->getAppsName();

		//var_dump( $this->getNew() );

		//var_dump( self::arrayDiff( $this->folders, $this->apps ) );
	}

	protected static function arrayDiff ( $A, $B ) {
		$intersect = array_intersect( $A, $B );

		return array_merge( array_diff( $A, $intersect ), array_diff( $B, $intersect ) );
	}

	/**
	 * Fonction callback pour nettoyer liste des dossiers
	 * (Avec array_filter ci-après)
	 *
	 * @param $v
	 *
	 * @return string || void
	 */
	private function nett ( $v ) {
		$protectedFolders = [ 'Gc7Ga', 'vendor' ];

		return ( $v[ 0 ] !== '.' && is_dir( $this->pathUp . $v ) && ! in_array( $v, $protectedFolders ) );
	}

	public function getFolders ( $dir = null ) {
		$this->pathUp = $this->getPathUp();
		$res          = array_filter( scandir( dirname( __FILE__, 2 ) ), [ $this, 'nett' ] );

//var_dump($res, is_dir('./blog/'), is_dir('./divers/'));
		return $res;
	}

	public function Html () {

		// Code HTML
		$html = "\n";
		foreach ( $this->folders as $d ) {
			$html .= ' | <a href="/?p=' . $d . '">' . ucfirst( $d ) . '</a>' . "\n";
		}
		//$this->autoMenu = $html;
		//var_dump( $html );
	}

	protected function getNew () {
		//$arr = $this->folders;
		$reservedApps = [ 'blog', 'divers' ];

		$arrs = [ 'apps', 'folders' ];

		foreach ( $arrs as $arr ) {
			var_dump( [ $arr, $this->$arr ] );
			$this->new{$arr} = array_diff( $this->$arr, $reservedApps );
		}

		var_dump( array_diff( $arrs, $reservedApps ) );

		return array_diff( $arrs, $reservedApps );
		//return $this->new;
	}


	public function getScesActuels () {

		$sces = $this->getAppsName();
		array_shift( $sces );

		//var_dump( $sces );


		foreach ( $sces as $s ) {
			$sce[] = $this->getAnySce( $s );
		}

		return $sce;
	}
	
	
	public function newService ($newSce) {


		// Création du dossier
		include 'assets/helpers/functions/recursiveCopy.php';
		//recursiveCopy(__DIR__ . '/assets/helpers/folderTemplate', __DIR__ . '/../NN');


		// Ajout dans le Json
		?>

		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			Votre nouveau service <strong><?= ucfirst($newSce) ?></strong> a été <strong>ajouté</strong> avec succès.
		</div>

		<?php
		return 'Process nouveau service';
	}

	/**
	 * Fonction callback pour nettoyer liste des dossiers
	 * (Avec array_filter ci-après)
	 *
	 * @param $v
	 *
	 * @return string || void
	 */
	private function nettAnySce ( $v ) {
		return ( $v[ 0 ] !== '.' && is_dir( $this->chemin . $v ) );
	}

	public function getAnySce ( $dir = null ) {
		$sce      = new \stdClass();
		$sce->nom = $dir;

		$dir          = '/' . $dir . '/';
		$this->chemin = dirname( __FILE__, 2 ) . $dir;

		$sce->menu = array_filter( scandir( dirname( __FILE__, 2 ) . $dir ), [ $this, 'nettAnySce' ] );

		$sce->nb = count( $sce->menu );

		return $sce;
	}

}
