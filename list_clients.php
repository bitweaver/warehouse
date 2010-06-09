<?php
/**
 * @version $Header$
 * @package warehouse
 * @subpackage functions
 */

/**
 * required setup
 */
require_once( '../kernel/setup_inc.php' );

$gBitSystem->verifyPackage( 'warehouse' );
if ( !$gBitUser->hasUserPermission('p_warehouse_view') ) {
	$gBitSystem->fatalError( 'You do not have prermission to view this package' );
}

require_once( WAREHOUSE_PKG_PATH.'Warehouse.php');
global $gBitSystem, $gBitSmarty;

$gWarehouse = new Warehouse();

/* Get a list of galleries which matches the imput paramters (default is to list every gallery in the system) */
$_REQUEST['root_only'] = TRUE;
/* Process the input parameters this page accepts */
if ( !empty($_REQUEST['warehouse_id']) ) {
	$gBitSmarty->assign_by_ref('gWarehouseId', $_REQUEST['warehouse_id']);
	$template = 'list_warehouses.tpl';
} else {
	$template = 'list_clients.tpl';
}

$warehouseList = $gWarehouse->getList( $_REQUEST );
// Pagination Data
// $gBitSmarty->assign_by_ref( 'listInfo', $_REQUEST['listInfo'] );
$gBitSmarty->assign( 'warehouseList', $warehouseList );

$clientList = $gWarehouse->getClientList( $_REQUEST );
$gBitSmarty->assign( 'clientList', $clientList );

// Display the template
$gDefaultCenter = "bitpackage:warehouse/$template";
$gBitSmarty->assign_by_ref( 'gDefaultCenter', $gDefaultCenter );
$gBitSystem->display( 'bitpackage:kernel/dynamic.tpl', 'List Client Warehouse Space' , array( 'display_mode' => 'list' ));

?>
