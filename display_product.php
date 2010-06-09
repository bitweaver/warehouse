<?php
/**
 * $Header$
 *
 * Copyright (c) 2006 bitweaver.org
 * All Rights Reserved. See below for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details.
 *
 * @package warehouse
 * @subpackage functions
 */

/**
 * required setup
 */
require_once( '../kernel/setup_inc.php' );

include_once( WAREHOUSE_PKG_PATH.'Product.php' );

$gBitSystem->verifyPackage( 'warehouse' );

$gBitSystem->verifyPermission( 'p_warehouse_view' );

if( !empty( $_REQUEST['product_id'] ) ) {
	$gProduct = new Product($_REQUEST['product_id'],$_REQUEST['content_id']);
	$gProduct->load();
} else {
	$gProduct = new Product();
}

$gProduct->getStockList($gProduct->mProductId);
$gProduct->getPalletMoveList($gProduct->mProductId);
$gProduct->getBatchList($gProduct->mProductId);

$gBitSmarty->assign_by_ref( 'productInfo', $gProduct->mInfo );
//if ( $gClient->isValid() ) {
	$gBitSystem->setBrowserTitle("Product Details Record");
	$gBitSystem->display( 'bitpackage:warehouse/show_product.tpl');
//} else {
//	header ("location: ".WAREHOUSE_PKG_URL."index.php");
//	die;
//}
?>
