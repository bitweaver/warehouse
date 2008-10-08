<?php
/**
 * @version $Header: /cvsroot/bitweaver/_bit_warehouse/list_pallets.php,v 1.2 2008/10/08 06:56:57 lsces Exp $
 * @package warehouse
 * @subpackage functions
 */

/**
 * required setup
 */
require_once( '../bit_setup_inc.php' );

$gBitSystem->verifyPackage( 'warehouse' );
if ( !$gBitUser->hasUserPermission('p_warehouse_view') ) {
	$gBitSystem->fatalError( 'You do not have prermission to view this package' );
}

require_once( WAREHOUSE_PKG_PATH.'Pallet.php');
global $gBitSystem, $gBitSmarty;

$gPallet = new Pallet();

/* Process the input parameters this page accepts */
if ( !empty($_REQUEST['pallet_id']) ) {
	$gBitSmarty->assign_by_ref('gPalletId', $_REQUEST['pallet_id']);
}

$palletList = $gPallet->getList( $_REQUEST );
// Pagination Data
$gBitSmarty->assign_by_ref( 'listInfo', $_REQUEST['listInfo'] );
$gBitSmarty->assign( 'palletList', $palletList );

// Display the template
$gDefaultCenter = "bitpackage:warehouse/list_pallets.tpl";
$gBitSmarty->assign_by_ref( 'gDefaultCenter', $gDefaultCenter );
$gBitSystem->display( 'bitpackage:kernel/dynamic.tpl', 'List Pallet Locations' , array( 'display_mode' => 'list' ));

?>
