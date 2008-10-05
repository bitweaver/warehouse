<?php

$tables = array(

'warehouse_batch' => "
	partno C(10) PRIMARY,
	batch C(10) PRIMARY,
	client C(4),
	indate T,
	qty I4,
	hold C1,
	qtyin I4,
	notes X,
	bopen C1
",

'warehouse_client' => "
	client C(4) PRIMARY,
	name C(32) NOTNULL,
	contact C(32) NOTNULL,
	part I,
	fullp I
",

'warehouse_customer' => "
	custno C(10) PRIMARY,
	type1 C1 DEFAULT 0,
	del_ad_no C(3),
	custname C(32) NOTNULL,
	address1 C(32),
	address2 C(32),
	posttown C(20),
	county C(20),
	country C(15),
	postcode C(8),
	jrneyno C(16),
	lastdate D,
	pricezone C(6),
	defcarrier C(10),
	defservice C(6),
	custins C(30),
	custins2 C(30),
	salesband C(2),
	custcon C(10),
	notes X
",

'warehouse_pallet' => "
	pallet C(6) PRIMARY,
	client C(4),
	height C(4),
	size1 C(4),
	product I4,
	notes X,
	loc C(2) DEFAULT '--'
",

'warehouse_partlist' => "
	partno C(10) PRIMARY,
	client C(4),
	descript C(40),
	quantity I4,
	unit C(10),
	weight C(8),
	perpal I4,
	package C(12),
	picture I8,
	notes X
",

'warehouse_releases' => "
	release_no C(10) PRIMARY,
	lineno I4 PRIMARY,
	rdate T,
	client C(4),
	custno C(10),
	partno C(10),
	batch C(10),
	qty I4,
	ropen C1,
	hold C1,
	palletno I8,
	notes X
",

'warehouse_stock' => "
	pallet C(6) PRIMARY,
	partno C(10) PRIMARY,
	batch C(10) PRIMARY,
	qty I4,
	subp C1,
	hold C1,
	sopen C1,
	palletno I8,
	notes X
",

'warehouse_stockmove' => "
	audit I8 PRIMARY,
	partno C(10),
	batch C(10),
	fromp C(6),
	fromsubp C1,
	top C(6),
	tosubp C1,
	cof C(3),
	qty I4,
	palletno I8,
	release_no C(10)
",

'warehouse_list' => "
	warehouse C(2) PRIMARY,
	name C(32),
	location C(32),
	client C(4),
	pallet_cnt I4
",

);

global $gBitInstaller;

foreach( array_keys( $tables ) AS $tableName ) {
	$gBitInstaller->registerSchemaTable( WAREHOUSE_PKG_NAME, $tableName, $tables[$tableName] );
}

$indices = array (
	'fisheye_gallery_id_idx' => array( 'table' => 'fisheye_gallery', 'cols' => 'gallery_id', 'opts' => NULL ),
	'fisheye_gallery_content_idx' => array( 'table' => 'fisheye_gallery', 'cols' => 'content_id', 'opts' => array( 'UNIQUE' ) ),
	'fisheye_image_id_idx' => array( 'table' => 'fisheye_image', 'cols' => 'image_id', 'opts' => NULL ),
	'fisheye_image_content_idx' => array( 'table' => 'fisheye_image', 'cols' => 'content_id', 'opts' => array( 'UNIQUE' ) ),
);
$gBitInstaller->registerSchemaIndexes( FISHEYE_PKG_NAME, $indices );

$gBitInstaller->registerPackageInfo( FISHEYE_PKG_NAME, array(
	'description' => "Warehouse provides a management tool for palletised storage",
	'license' => '<a href="http://www.gnu.org/licenses/licenses.html#LGPL">LGPL</a>'
) );

// ### Sequences
$sequences = array (
	'warehouse_id_seq' => array( 'start' => 1 ),
	'pallet_id_seq' => array( 'start' => 1 )
);
$gBitInstaller->registerSchemaSequences( WAREHOUSE_PKG_NAME, $sequences );

// ### Default Preferences
$gBitInstaller->registerPreferences( WAREHOUSE_PKG_NAME, array(
	array( WAREHOUSE_PKG_NAME, 'warehouse_list_title','y'),
	array( WAREHOUSE_PKG_NAME, 'warehouse_list_created','y'),
	array( WAREHOUSE_PKG_NAME, 'warehouse_list_user','y'),
	array( WAREHOUSE_PKG_NAME, 'warehouse_list_hits','y'),
	array( WAREHOUSE_PKG_NAME, 'warehouse_list_thumbnail','y'),
	array( WAREHOUSE_PKG_NAME, 'warehouse_list_thumbnail_size','small'),
	array( WAREHOUSE_PKG_NAME, 'warehouse_pallet_list_title','y'),
	array( WAREHOUSE_PKG_NAME, 'warehouse_pallet_list_description','y'),
	array( WAREHOUSE_PKG_NAME, 'warehouse_pallet_list_image_titles','y'),
	array( WAREHOUSE_PKG_NAME, 'warehouse_pallet_default_rows_per_page','5'),
	array( WAREHOUSE_PKG_NAME, 'warehouse_pallet_default_cols_per_page','3'),
	array( WAREHOUSE_PKG_NAME, 'warehouse_pallet_default_thumbnail_size','small'),
) );

// ### Default User Permissions
$gBitInstaller->registerUserPermissions( WAREHOUSE_PKG_NAME, array(
	array('p_warehouse_view', 'Can view warehouse information', 'basic', WAREHOUSE_PKG_NAME),
	array('p_warehouse_create', 'Can create a pallet location', 'registered', WAREHOUSE_PKG_NAME),
	array('p_warehouse_edit', 'Can edit a pallet location', 'registered', WAREHOUSE_PKG_NAME),
	array('p_warehouse_upload', 'Can upload pallets to a warehouse', 'registered', WAREHOUSE_PKG_NAME),
	array('p_warehouse_admin', 'Can admin pallet movements', 'editors', WAREHOUSE_PKG_NAME),
) );

if( defined( 'RSS_PKG_NAME' )) {
	$gBitInstaller->registerPreferences( WAREHOUSE_PKG_NAME, array(
		array( RSS_PKG_NAME, WAREHOUSE_PKG_NAME.'_rss', 'y'),
	));
}

// ### Register content types
$gBitInstaller->registerContentObjects( WAREHOUSE_PKG_NAME, array( 
	'Warehouse'=>WAREHOUSE_PKG_PATH.'Warehouse.php',
	'WarehousePallet'=>WAREHOUSE_PKG_PATH.'WarehousePallet.php',
));
?>
