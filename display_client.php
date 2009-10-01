<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_warehouse/display_client.php,v 1.7 2009/10/01 14:17:07 wjames5 Exp $
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
require_once( '../bit_setup_inc.php' );

include_once( WAREHOUSE_PKG_PATH.'Client.php' );

$gBitSystem->verifyPackage( 'warehouse' );

$gBitSystem->verifyPermission( 'p_warehouse_view' );

if( !empty( $_REQUEST['client_id'] ) ) {
	$gClient = new Client($_REQUEST['client_id'],$_REQUEST['content_id']);
	$gClient->load();
} else {
	$gClient = new Client();
}

$gClient->getStockList($gClient->mClientId);
$gClient->getProductList($gClient->mClientId);
$gClient->getBatchList($gClient->mClientId);
$gClient->getReleaseList($gClient->mClientId);

$gBitSmarty->assign_by_ref( 'clientInfo', $gClient->mInfo );
//if ( $gClient->isValid() ) {
	$gBitSystem->setBrowserTitle("Client Activity Record");
	$gBitSystem->display( 'bitpackage:warehouse/show_client.tpl');
//} else {
//	header ("location: ".WAREHOUSE_PKG_URL."index.php");
//	die;
//}
?>
