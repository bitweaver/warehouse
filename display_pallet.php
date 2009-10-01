<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_warehouse/display_pallet.php,v 1.3 2009/10/01 13:45:53 wjames5 Exp $
 *
 * Copyright (c) 2006 bitweaver.org
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details.
 *
 * @package warehouse
 * @subpackage functions
 */

/**
 * required setup
 */
require_once( '../bit_setup_inc.php' );

include_once( WAREHOUSE_PKG_PATH.'Pallet.php' );

$gBitSystem->verifyPackage( 'warehouse' );

$gBitSystem->verifyPermission( 'p_warehouse_view' );

if( !empty( $_REQUEST['pallet_id'] ) ) {
	$gPallet = new Pallet($_REQUEST['pallet_id'],$_REQUEST['content_id']);
	$gPallet->load();
} else {
	$gPallet = new Pallet();
}

$gPallet->getStockList($gPallet->mPalletId);
$gPallet->getToPalletList($gPallet->mPalletId);
$gPallet->getFromPalletList($gPallet->mPalletId);

$gBitSmarty->assign_by_ref( 'palletInfo', $gPallet->mInfo );
//if ( $gClient->isValid() ) {
	$gBitSystem->setBrowserTitle("Client Activity Record");
	$gBitSystem->display( 'bitpackage:warehouse/show_pallet.tpl');
//} else {
//	header ("location: ".WAREHOUSE_PKG_URL."index.php");
//	die;
//}
?>
