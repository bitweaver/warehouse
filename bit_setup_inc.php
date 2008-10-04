<?php
global $gBitSystem, $gBitUser, $gBitSmarty, $gBitThemes;

$registerHash = array(
	'package_name' => 'warehouse',
	'package_path' => dirname( __FILE__ ).'/',
	'homeable' => TRUE,
);
$gBitSystem->registerPackage( $registerHash );

if( $gBitSystem->isPackageActive( 'warehouse' ) && $gBitUser->hasPermission( 'p_warehouse_view' )) {

	$menuHash = array(
		'package_name'  => WAREHOUSE_PKG_NAME,
		'index_url'     => WAREHOUSE_PKG_URL.'index.php',
		'menu_template' => 'bitpackage:warehouse/menu_warehouse.tpl',
	);
	$gBitSystem->registerAppMenu( $menuHash );

//	include_once( WAREHOUSE_PKG_PATH.'Warehouse.php' );
}
?>
