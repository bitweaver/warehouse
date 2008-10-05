<?php
/**
 * @version $Header: /cvsroot/bitweaver/_bit_warehouse/list_warehouses.php,v 1.1 2008/10/05 09:06:47 lsces Exp $
 * @package warehouse
 * @subpackage functions
 */

/**
 * required setup
 */
require_once( '../bit_setup_inc.php' );

require_once( WAREHOUSE_PKG_PATH.'Warehouse.php');
global $gBitSystem, $gBitSmarty;

$gWarehouse = new Warehouse();

/* Process the input parameters this page accepts */
if ( !empty($_REQUEST['warehouse_id']) ) {
	$gBitSmarty->assign_by_ref('gWarehouseId', $_REQUEST['warehouse_id']);
}

$warehouseList = $gWarehouse->getList( $_REQUEST );
// Pagination Data
// $gBitSmarty->assign_by_ref( 'listInfo', $_REQUEST['listInfo'] );
$gBitSmarty->assign( 'warehouseList', $warehouseList );

// Display the template
$gDefaultCenter = "bitpackage:warehouse/list_warehouses.tpl";
$gBitSmarty->assign_by_ref( 'gDefaultCenter', $gDefaultCenter );
$gBitSystem->display( 'bitpackage:kernel/dynamic.tpl', 'List Warehouse Sites' , array( 'display_mode' => 'list' ));

?>
