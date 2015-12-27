<?	function checkLogin( $pageId ) {
			global $db, $md5Token, $userId;
			
			$loggedIn = false;
			
			if( (session_is_registered( "md5Token" )) && (session_is_registered( "userId" )) ){
				$result = $db->query( "select last_login from admin_users where user_id='$userId' and last_unique_id='$md5Token'" );
	
				if( $db->numRows( $result ) ) { 
					
					$accessResult = $db->query( "select admin_pages.name ".
					                            "  from admin_pages, admin_page_access ".
					                            " where admin_page_access.page_id   = admin_pages.page_id ".
					                            "   and admin_page_access.user_id   = '$userId'".
					                            "   and admin_pages.page_identifier = '$pageId'" );
	
					
					if( $db->numRows( $accessResult ) ) {
						$loggedIn = true;
					}
				}
			}
			
			return( $loggedIn );			
		}

		function makeSearch( $searchStr, $columnArr ) {
			$searchArr = explode( " ", $searchStr );

			foreach( $searchArr as $searchKey ) {
				foreach( $columnArr as $colKey ) {
					if( $srchQuery ) $srchQuery .= " or ";									
					$srchQuery .= "( ucase( $colKey ) like '%" . strtoupper( addslashes( $searchKey ) ) . "%' )";
				}
			}
			
			return( $srchQuery );
		}
		
		function details_callback( $s ) {
			global $db;
			
			$noProd = str_replace( "?product_id=", "", $s[ 1 ] );
			
			$familyResult = $db->query( "select products_family.name ".
			                            "  from products, products_family ".
			                            " where products.product_id = '$noProd' ".
			                            "   and products.family_id  = products_family.family_id" );
			if( $db->numRows( $familyResult ) ) {
				list( $familyName ) = $db->fetchRow( $familyResult );
			}
			
			$noSpace = str_replace( " ", "%20", $familyName );
			$noSpace = str_replace( "&", urlencode( "&" ), $noSpace );
			
			return( "<a href=\"products_details.php" . $s[ 1 ] . "&page=1&pIdName=$noSpace\">" . $s[ 2 ] . "</a>" );
		}    		

		function family_callback( $s ) {
			global $db;
			
			$noFam = str_replace( "?family_id=", "", $s[ 1 ] );
			
			$familyResult = $db->query( "select name ".
			                            "  from products_family ".
			                            " where family_id  = '$noFam'" );
			if( $db->numRows( $familyResult ) ) {
				list( $familyName ) = $db->fetchRow( $familyResult );
			}
			
			$noSpace = str_replace( " ", "%20", $familyName );
			return( "<a href=\"products_family.php" . $s[ 1 ] . "&page=1&pIdName=$noSpace\">" . $s[ 2 ] . "</a>" );
		}    		

		function prepStr( $text ) {
			global $trans;

			$newText = preg_replace_callback( '/<a href="products_details.php([^"]*)">([^<]*)<\/a>/i', 'details_callback', $text );
			$newText = preg_replace_callback( '/<a href="products_family.php([^"]*)">([^<]*)<\/a>/i', 'family_callback', $newText );

			return( strtr( stripslashes( trim( $newText ) ), $trans ) );
		}

		function truncWords( $text, $words ) {
			$splitWords = explode( " ", $text, $words );
			
			if( sizeof( $splitWords ) < $words ) {
				$result = implode( " ", $splitWords );
			} else {
				$remaining = array_pop( $splitWords );
				$result = implode( " ", $splitWords ) . "...";
			}
			
			return( $result );
		}
?>