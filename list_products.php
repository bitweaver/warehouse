<?php
/**
 * @version $Header: /cvsroot/bitweaver/_bit_warehouse/list_products.php,v 1.3 2010/02/08 21:27:27 wjames5 Exp $
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

require_once( WAREHOUSE_PKG_PATH.'Product.php');
global $gBitSystem, $gBitSmarty;

$gProduct = new Product();

/* Process the input parameters this page accepts */
if ( !empty($_REQUEST['product_id']) ) {
	$gBitSmarty->assign_by_ref('gProductId', $_REQUEST['product_id']);
}
if ( !empty($_REQUEST['client_id']) ) {
	$gBitSmarty->assign_by_ref('gClientId', $_REQUEST['client_id']);
}

$productList = $gProduct->getList( $_REQUEST );
// Pagination Data
$gBitSmarty->assign_by_ref( 'listInfo', $_REQUEST['listInfo'] );
$gBitSmarty->assign( 'productList', $productList );

// Display the template
$gDefaultCenter = "bitpackage:warehouse/list_products.tpl";
$gBitSmarty->assign_by_ref( 'gDefaultCenter', $gDefaultCenter );
$gBitSystem->display( 'bitpackage:kernel/dynamic.tpl', 'List Product Descriptions' , array( 'display_mode' => 'list' ));

?>
