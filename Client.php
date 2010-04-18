<?php
/**
 * @version $Header: /cvsroot/bitweaver/_bit_warehouse/Client.php,v 1.13 2010/04/18 02:27:24 wjames5 Exp $
 *
 * Copyright ( c ) 2006 bitweaver.org
 * All Rights Reserved. See below for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details
 *
 * @package warehouse
 */

/**
 * required setup
 */
require_once( LIBERTY_PKG_PATH.'LibertyContent.php' );		// Citizen base class

define('CLIENT_CONTENT_TYPE_GUID', 'client' );

/**
 * @package warehouse
 */
class Client extends LibertyContent {
	var $mClientId;
	var $mParentId;

	/**
	 * Constructor 
	 * 
	 * Build a Client object based on LibertyContent
	 * @param integer Client Id identifer
	 * @param integer Base content_id identifier 
	 */
	function Client( $pClientId = NULL, $pContentId = NULL ) {
		LibertyContent::LibertyContent();
		$this->registerContentType( CLIENT_CONTENT_TYPE_GUID, array(
				'content_type_guid' => CLIENT_CONTENT_TYPE_GUID,
				'content_name' => 'Client Entry',
				'handler_class' => 'Client',
				'handler_package' => 'warehouse',
				'handler_file' => 'Client.php',
				'maintainer_url' => 'http://lsces.co.uk'
			) );
		$this->mClientId = $pClientId;
		$this->mContentTypeGuid = CLIENT_CONTENT_TYPE_GUID;
				// Permission setup
		$this->mViewContentPerm  = 'p_warehouse_view';
		$this->mUpdateContentPerm  = 'p_warehouse_edit';
		$this->mAdminContentPerm = 'p_warehouse_admin';
		
	}

	/**
	 * Load a Client content Item
	 *
	 * (Describe Client object here )
	 */
	function load($pContentId = NULL) {
		if ( $pContentId ) $this->mContentId = (int)$pContentId;
/*		if( $this->verifyId( $this->mContentId ) ) {
			$query = "select con.*, lc.*,
				uue.`login` AS modifier_user, uue.`real_name` AS modifier_real_name,
				uuc.`login` AS creator_user, uuc.`real_name` AS creator_real_name
				FROM `".BIT_DB_PREFIX."warehouse_client` ci
				INNER JOIN `".BIT_DB_PREFIX."liberty_content` lc ON ( lc.`content_id` = ci.`content_id` )
				LEFT JOIN `".BIT_DB_PREFIX."users_users` uue ON (uue.`user_id` = lc.`modifier_user_id`)
				LEFT JOIN `".BIT_DB_PREFIX."users_users` uuc ON (uuc.`user_id` = lc.`user_id`)
				WHERE lc.`content_id`=?";
			$result = $this->mDb->query( $query, array( $this->mContentId ) );

			if ( $result && $result->numRows() ) {
				$this->mInfo = $result->fields;
				$this->mContentId = (int)$result->fields['content_id'];
				$this->mClientId = (int)$result->fields['client_id'];
				$this->mParentId = (int)$result->fields['contact_id'];
				$this->mClientName = $result->fields['title'];
				$this->mInfo['creator'] = (isset( $result->fields['creator_real_name'] ) ? $result->fields['creator_real_name'] : $result->fields['creator_user'] );
				$this->mInfo['editor'] = (isset( $result->fields['modifier_real_name'] ) ? $result->fields['modifier_real_name'] : $result->fields['modifier_user'] );
				$this->mInfo['display_url'] = $this->getDisplayUrl();
			}
		}
		LibertyAttachable::load();
*/
			$query = "select cl.*, cu.*
				FROM `".BIT_DB_PREFIX."warehouse_client` cl
				LEFT JOIN `".BIT_DB_PREFIX."warehouse_customer` cu ON (cl.`client` = cu.`client`)
				WHERE cl.`client`=?";
			$result = $this->mDb->query( $query, array( $this->mClientId ) );

			if ( $result && $result->numRows() ) {
				$this->mInfo = $result->fields;
				$this->mContentId = 0;
				$this->mClientName = $result->fields['name'];
				$this->mInfo['display_url'] = WAREHOUSE_PKG_URL.'display_client.php?client_id='.trim($this->mClientId);
		}
		return;
	}

	/**
	* verify, clean up and prepare data to be stored
	* @param $pParamHash all information that is being stored. will update $pParamHash by reference with fixed array of itmes
	* @return bool TRUE on success, FALSE if store could not occur. If FALSE, $this->mErrors will have reason why
	* @access private
	**/
	function verify( &$pParamHash ) {
		// make sure we're all loaded up if everything is valid
		if( $this->isValid() && empty( $this->mInfo ) ) {
			$this->load( TRUE );
		}

		// It is possible a derived class set this to something different
		if( empty( $pParamHash['content_type_guid'] ) ) {
			$pParamHash['content_type_guid'] = $this->mContentTypeGuid;
		}

		if( !empty( $this->mContentId ) ) {
			$pParamHash['content_id'] = $this->mContentId;
		} else {
			unset( $pParamHash['content_id'] );
		}

		if ( empty( $pParamHash['parent_id'] ) )
			$pParamHash['parent_id'] = $this->mContentId;
			
		// content store
		// check for name issues, first truncate length if too long
		if( empty( $pParamHash['surname'] ) || empty( $pParamHash['forename'] ) )  {
			$this->mErrors['names'] = 'You must enter a forename and surname for this citizen.';
		} else {
			$pParamHash['title'] = substr( $pParamHash['prefix'].' '.$pParamHash['forename'].' '.$pParamHash['surname'].' '.$pParamHash['suffix'], 0, 160 );
			$pParamHash['content_store']['title'] = $pParamHash['title'];
		}	

		// Secondary store entries
		$pParamHash['client_store']['prefix'] = $pParamHash['prefix'];
		$pParamHash['client_store']['forename'] = $pParamHash['forename'];
		$pParamHash['client_store']['surname'] = $pParamHash['surname'];
		$pParamHash['client_store']['suffix'] = $pParamHash['suffix'];
		$pParamHash['client_store']['organisation'] = $pParamHash['organisation'];

		if ( !empty( $pParamHash['nino'] ) ) $pParamHash['client_store']['nino'] = $pParamHash['nino'];
		if ( !empty( $pParamHash['dob'] ) ) $pParamHash['client_store']['dob'] = $pParamHash['dob'];
		if ( !empty( $pParamHash['eighteenth'] ) ) $pParamHash['client_store']['eighteenth'] = $pParamHash['eighteenth'];
		if ( !empty( $pParamHash['dod'] ) ) $pParamHash['client_store']['dod'] = $pParamHash['dod'];

		return( count( $this->mErrors ) == 0 );
	}

	/**
	* Store client data
	* @param $pParamHash contains all data to store the contact
	* @param $pParamHash[title] title of the new contact
	* @param $pParamHash[edit] description of the contact
	* @return bool TRUE on success, FALSE if store could not occur. If FALSE, $this->mErrors will have reason why
	**/
	function store( &$pParamHash ) {
		if( $this->verify( $pParamHash ) ) {
			// Start a transaction wrapping the whole insert into liberty 

			$this->mDb->StartTrans();
			if ( LibertyAttachable::store( $pParamHash ) ) {
				$table = BIT_DB_PREFIX."warehouse_client";

				// mContentId will not be set until the secondary data has commited 
				if( $this->verifyId( $this->mClientId ) ) {
					if( !empty( $pParamHash['client_store'] ) ) {
						$result = $this->mDb->associateUpdate( $table, $pParamHash['client_store'], array( "content_id" => $this->mContentId ) );
					}
				} else {
					$pParamHash['client_store']['content_id'] = $pParamHash['content_id'];
					$pParamHash['client_store']['contact_id'] = $pParamHash['content_id'];
					if( isset( $pParamHash['contact_id'] ) && is_numeric( $pParamHash['contact_id'] ) ) {
						$pParamHash['client_store']['contact_id'] = $pParamHash['contact_id'];
					} else {
						$pParamHash['client_store']['contact_id'] = $this->mDb->GenID( 'contact_id_seq');
					}	

					$pParamHash['client_store']['parent_id'] = $pParamHash['client_store']['content_id'];
					$this->mClientId = $pParamHash['client_store']['content_id'];
					$this->mParentId = $pParamHash['client_store']['parent_id'];
					$this->mContentId = $pParamHash['content_id'];
					$result = $this->mDb->associateInsert( $table, $pParamHash['client_store'] );
				}
				// load before completing transaction as firebird isolates results
				$this->load();
				$this->mDb->CompleteTrans();
			} else {
				$this->mDb->RollbackTrans();
				$this->mErrors['store'] = 'Failed to store this contact.';
			}
		}
		return( count( $this->mErrors ) == 0 );
	}

	/**
	 * Delete content object and all related records
	 */
	function expunge()
	{
		$ret = FALSE;
		if ($this->isValid() ) {
			$this->mDb->StartTrans();
			$query = "DELETE FROM `".BIT_DB_PREFIX."warehouse_client` WHERE `content_id` = ?";
			$result = $this->mDb->query($query, array($this->mContentId ) );
			if (LibertyAttachable::expunge() ) {
			$ret = TRUE;
				$this->mDb->CompleteTrans();
			} else {
				$this->mDb->RollbackTrans();
			}
		}
		return $ret;
	}
    
	/**
	 * Returns Request_URI to a Client content object
	 *
	 * @param string name of
	 * @param array different possibilities depending on derived class
	 * @return string the link to display the page.
	 */
	function getDisplayUrl( $pContentId=NULL ) {
		global $gBitSystem;
		if( empty( $pContentId ) ) {
			$pContentId = $this->mContentId;
		}

		return WAREHOUSE_PKG_URL.'index.php?content_id='.$pContentId;
	}

	/**
	 * Returns HTML link to display a Client object
	 * 
	 * @param string Not used ( generated locally )
	 * @param array mInfo style array of content information
	 * @return the link to display the page.
	 */
	function getDisplayLink( $pText, $aux ) {
		if ( $this->mContentId != $aux['content_id'] ) $this->load($aux['content_id']);

		if (empty($this->mInfo['content_id']) ) {
			$ret = '<a href="'.$this->getDisplayUrl($aux['content_id']).'">'.$aux['title'].'</a>';
		} else {
			$ret = '<a href="'.$this->getDisplayUrl($aux['content_id']).'">'."Client - ".$this->mInfo['title'].'</a>';
		}
		return $ret;
	}

	/**
	 * Returns title of an Client object
	 *
	 * @param array mInfo style array of content information
	 * @return string Text for the title description
	 */
	function getTitle( $pHash = NULL ) {
		$ret = NULL;
		if( empty( $pHash ) ) {
			$pHash = &$this->mInfo;
		} else {
			if ( $this->mContentId != $pHash['content_id'] ) {
				$this->load($pHash['content_id']);
				$pHash = &$this->mInfo;
			}
		}

		if( !empty( $pHash['title'] ) ) {
			$ret = "Client - ".$this->mInfo['title'];
		} elseif( !empty( $pHash['content_name'] ) ) {
			$ret = $pHash['content_name'];
		}
		return $ret;
	}

	/**
	 * Returns list of contract entries
	 *
	 * @param integer 
	 * @param integer 
	 * @param integer 
	 * @return string Text for the title description
	 */
	function getList( &$pListHash ) {
		LibertyContent::prepGetList( $pListHash );
		
		$whereSql = $joinSql = $selectSql = '';
		$bindVars = array();
		array_push( $bindVars, $this->mContentTypeGuid );
		$this->getServicesSql( 'content_list_sql_function', $selectSql, $joinSql, $whereSql, $bindVars );

		if ( isset($pListHash['find']) ) {
			$findesc = '%' . strtoupper( $pListHash['find'] ) . '%';
			$whereSql .= " AND (UPPER(con.`SURNAME`) like ? or UPPER(con.`FORENAME`) like ?) ";
			array_push( $bindVars, $findesc );
		}

		if ( isset($pListHash['add_sql']) ) {
			$whereSql .= " AND $add_sql ";
		}

		$query = "SELECT con.*, lc.*, 
				uue.`login` AS modifier_user, uue.`real_name` AS modifier_real_name,
				uuc.`login` AS creator_user, uuc.`real_name` AS creator_real_name $selectSql
				FROM `".BIT_DB_PREFIX."warehouse_client` ci 
				INNER JOIN `".BIT_DB_PREFIX."liberty_content` lc ON ( lc.`content_id` = ci.`content_id` )
				LEFT JOIN `".BIT_DB_PREFIX."users_users` uue ON (uue.`user_id` = lc.`modifier_user_id`)
				LEFT JOIN `".BIT_DB_PREFIX."users_users` uuc ON (uuc.`user_id` = lc.`user_id`)
				$joinSql
				WHERE lc.`content_type_guid`=? $whereSql  
				order by ".$this->mDb->convertSortmode( $pListHash['sort_mode'] );
		$query_cant = "SELECT COUNT(lc.`content_id`) FROM `".BIT_DB_PREFIX."warehouse_client` ci
				INNER JOIN `".BIT_DB_PREFIX."liberty_content` lc ON ( lc.`content_id` = ci.`content_id` )
				$joinSql
				WHERE lc.`content_type_guid`=? $whereSql";

		$ret = array();
		$this->mDb->StartTrans();
		$result = $this->mDb->query( $query, $bindVars, $pListHash['max_records'], $pListHash['offset'] );
		$cant = $this->mDb->getOne( $query_cant, $bindVars );
		$this->mDb->CompleteTrans();

		while ($res = $result->fetchRow()) {
			$res['client_url'] = $this->getDisplayUrl( $res['content_id'] );
			$ret[] = $res;
		}

		$pListHash['cant'] = $cant;
		LibertyContent::postGetList( $pListHash );
		return $ret;
	}

	/**
	 * getClientList( &$pParamHash );
	 * Get list of client records 
	 */
	function getClientList( &$pParamHash ) {
		global $gBitSystem, $gBitUser;
		
		if ( empty( $pParamHash['sort_mode'] ) ) {
			if ( empty( $_REQUEST["sort_mode"] ) ) {
				$pParamHash['sort_mode'] = 'surname_asc';
			} else {
			$pParamHash['sort_mode'] = $_REQUEST['sort_mode'];
			}
		}
		
		LibertyContent::prepGetList( $pParamHash );

		$findSql = '';
		$selectSql = '';
		$joinSql = '';
		$whereSql = '';
		$bindVars = array();
		$type = 'surname';
		
		// this will set $find, $sort_mode, $max_records and $offset
		extract( $pParamHash );

		if( isset( $find_org ) and is_string( $find_org ) and $find_org <> '' ) {
			$whereSql .= " AND UPPER( c.`organisation` ) like ? ";
			$bindVars[] = '%' . strtoupper( $find_org ). '%';
			$type = 'organisation';
			$pParamHash["listInfo"]["ihash"]["find_org"] = $find_org;
		}
		if( isset( $find_name ) and is_string( $find_name ) and $find_name <> '' ) {
		    $split = preg_split('|[,. ]|', $find_name, 2);
			$whereSql .= " AND UPPER( c.`surname` ) STARTING ? ";
			$bindVars[] = strtoupper( $split[0] );
		    if ( array_key_exists( 1, $split ) ) {
				$split[1] = trim( $split[1] );
				$whereSql .= " AND UPPER( c.`forename` ) STARTING ? ";
				$bindVars[] = strtoupper( $split[1] );
			}
			$pParamHash["listInfo"]["ihash"]["find_name"] = $find_name;
		}
		if( isset( $find_street ) and is_string( $find_street ) and $find_street <> '' ) {
			$whereSql .= " AND UPPER( a.`street` ) like ? ";
			$bindVars[] = '%' . strtoupper( $find_street ). '%';
			$pParamHash["listInfo"]["ihash"]["find_street"] = $find_street;
		}
		if( isset( $find_org ) and is_string( $find_postcode ) and $find_postcode <> '' ) {
			$whereSql .= " AND UPPER( `a.postcode` ) LIKE ? ";
			$bindVars[] = '%' . strtoupper( $find_postcode ). '%';
			$pParamHash["listInfo"]["ihash"]["find_postcode"] = $find_postcode;
		}
/* Pull from Warehose for present
		$query = "SELECT c.*, a.UPRN, a.POSTCODE, a.SAO, a.PAO, a.NUMBER, a.STREET, a.LOCALITY, a.TOWN, a.COUNTY, c.parent_id as uprn,
			(SELECT COUNT(*) FROM `".BIT_DB_PREFIX."citizen_xref` x WHERE x.content_id = c.content_id ) AS links, 
			(SELECT COUNT(*) FROM `".BIT_DB_PREFIX."task_ticket` e WHERE e.usn = c.usn ) AS enquiries $selectSql 
			FROM `".BIT_DB_PREFIX."citizen` ci 
			LEFT JOIN `".BIT_DB_PREFIX."address_book` a ON a.content_id = ci.content_id $findSql
			$joinSql 
			WHERE c.`".$type."` <> '' $whereSql ORDER BY ".$this->mDb->convertSortmode( $sort_mode );

		$query_cant = "SELECT COUNT( * )
			FROM `".BIT_DB_PREFIX."citizen` ci
			LEFT JOIN `".BIT_DB_PREFIX."address_book` a ON a.content_id = ci.content_id $findSql
			$joinSql WHERE c.`".$type."` <> '' $whereSql ";
//			INNER JOIN `".BIT_DB_PREFIX."address_book` a ON a.content_id = c.content_id 
 */
		$result = $this->mDb->query( $query, $bindVars, $max_records, $offset );
		$ret = array();
		while( $res = $result->fetchRow() ) {
			if (!empty($parse_split)) {
				$res = array_merge($this->parseSplit($res), $res);
			}
			$ret[] = $res;
		}
		$pParamHash["cant"] = $this->mDb->getOne( $query_cant, $bindVars );

		LibertyContent::postGetList( $pParamHash );
		return $ret;
	}

	/**
	* Returns clients using space in a Warehouse
	* if no warehouse is specified, then a list of all clients is returned
	*
	* @param string filter to provide a subset of projects
	* @return array List of client records filtered by warehouse
	*/
	function getStockList( $client = NULL ) {
		$query = "SELECT stk.* FROM `warehouse_stock` stk
				  JOIN `warehouse_partlist` pro ON stk.`partno` = pro.`partno`
				  WHERE pro.`client` = ? ORDER BY stk.`partno`";
		$result = $this->mDb->query($query, array( $client ));
		$ret = array();

		while ($res = $result->fetchRow()) {
			$res['pallet_url'] = WAREHOUSE_PKG_URL.'display_pallet.php?pallet_id='.trim($res['pallet']);
			$res['product_url'] = WAREHOUSE_PKG_URL.'display_product.php?product_id='.trim($res['partno']);
			$res['batch_url'] = WAREHOUSE_PKG_URL.'display_batch.php?product_id='.trim($res['partno']).'&product_id='.trim($res['partno']);
			$res['subp'] = trim($res['subp']);
			$ret[] = $res;
		}

		$this->mInfo['stock'] = $ret;
		return $ret;
	}
	function getProductList( $client = NULL ) {
		$query = "SELECT pro.* FROM `warehouse_partlist` pro
				  WHERE pro.`client` = ? AND pro.`quantity` > 0 ORDER BY pro.`partno`";
		$result = $this->mDb->query($query, array( $client ));
		$ret = array();

		while ($res = $result->fetchRow()) {
			$res['product_url'] = WAREHOUSE_PKG_URL.'display_product.php?product_id='.trim($res['partno']);
			$ret[] = $res;
		}

		$this->mInfo['product'] = $ret;
		return $ret;
	}
	function getBatchList( $client = NULL ) {
		$query = "SELECT ba.* FROM `warehouse_batch` ba
				  WHERE ba.`client` = ? AND ba.`qty` > 0 ORDER BY ba.`partno`, ba.`indate`";
		$result = $this->mDb->query($query, array( $client ));
		$ret = array();

		while ($res = $result->fetchRow()) {
			$res['product_url'] = WAREHOUSE_PKG_URL.'display_product.php?product_id='.trim($res['partno']);
			$res['batch_url'] = WAREHOUSE_PKG_URL.'display_batch.php?batch_id='.trim($res['batch']).'&product_id='.trim($res['partno']);
			$ret[] = $res;
		}

		$this->mInfo['batch'] = $ret;
		return $ret;
	}
	function getReleaseList( $client = NULL ) {
		$query = "SELECT FIRST 50 DISTINCT a.`release_no`
				, ( SELECT FIRST 1 RDATE FROM WAREHOUSE_RELEASES b WHERE b.RELEASE_NO = a.RELEASE_NO ) AS RDATE
				, ( SELECT COUNT(c.LINENO) FROM WAREHOUSE_RELEASES c WHERE c.RELEASE_NO = a.RELEASE_NO ) AS LINES
				FROM WAREHOUSE_RELEASES a
				WHERE CLIENT = ?
				ORDER BY 2 DESC";
		$result = $this->mDb->query($query, array( $client ));
		$ret = array();

		while ($res = $result->fetchRow()) {
			$res['release_url'] = WAREHOUSE_PKG_URL.'display_release.php?release_id='.trim($res['release_no']);
			$ret[] = $res;
		}

		$this->mInfo['release'] = $ret;
		return $ret;
	}
	function getRelease( $release = NULL ) {
		$query = "SELECT rel.*
				FROM WAREHOUSE_RELEASES rel
				WHERE `release_no` = ?
				ORDER BY rel.`lineno`";
		$result = $this->mDb->query($query, array( $release ));
		$ret = array();

		while ($res = $result->fetchRow()) {
			$res['product_url'] = WAREHOUSE_PKG_URL.'display_product.php?product_id='.trim($res['partno']);
			$res['batch_url'] = WAREHOUSE_PKG_URL.'display_batch.php?batch_id='.trim($res['batch']).'&product_id='.trim($res['partno']);
			$ret[] = $res;
		}

		if ( $ret[0]['client'] <> $this->mClientId ) $this->mClientId = $ret[0]['client'];
		$this->mInfo['release_no'] = $release;
		$this->mInfo['release_date'] = $ret[0]['rdate'];
		$this->mInfo['releaseno'] = $ret;
		return $ret;
	}

}
?>
