<?	function checkLogin( $pageId ) {
			global $db, $md5Token, $userId;
			
			$loggedIn = false;
			
			if( (session_is_registered( "md5Token" )) && (session_is_registered( "userId" )) ){
				$result = $db->query( "select last_login from admin_users where user_id='$userId' and last_unique_id='$md5Token'" );
	
				if( $db->numRows( $result ) ) { 
					
					$accessResult = $db->query( "select count( admin_page_access.user_id ) ".
					                            "  from admin_pages, admin_page_access ".
					                            " where admin_pages.page_id         = admin_page_access.page_id ".
					                            "   and admin_page_access.user_id   = '$userId'".
					                            "   and admin_pages.page_identifier = '$pageId'" );
	
					
					list( $accessCount ) = $db->fetchRow( $accessResult );
					
					if( $accessCount > 0 ) {
						$loggedIn = true;
					}
				}
			}
			
			return( $loggedIn );			
		}
		
		function prepStr( $text ) {
			global $trans;
			return( strtr( stripslashes( $text ), $trans ) );
		}

		function truncWords( $text, $words ) {
			$splitWords = explode( " ", $text, $words );
			
			if( sizeof( $splitWords ) < $words ) {
				$result = implode( " ", $splitWords );
			} else {
				$remaining = array_pop( $splitWords );
				$result = implode( " ", $splitWords ) . "&#8230;";
			}
			
			return( $result );
		}

		function truncChars( $text, $chars ){
			if( strlen( $text ) > $chars )
				$text = substr( $text, 0, $chars ) . "&#8230;";
			
			return $text;
		}

		function printCSV( $array, $deliminator = "," ) { 		
			$line = ""; 
			
			foreach( $array as $val ) { 
				$val = str_replace( "\r\n", "\n", $val ); 
				
		//		if( ereg( "[$deliminator\"\n\r]", $val ) ) { 
					$val = '"' . str_replace( '"', '""', $val ) . '"'; 
			//	}
				
				$line .= $val . $deliminator; 
				
			}
			
			$line = substr( $line, 0, (strlen( $deliminator ) * -1) ); 
			$line .= "\n"; 
			
			return( $line );
		}
?>