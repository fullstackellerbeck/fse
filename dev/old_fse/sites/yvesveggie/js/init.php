<?	ini_set( "include_path", "../" );
		include( "inc/init.php" );	?>

		function jumpMenu(targ,selObj,restore){
		  eval( targ + ".location='" + selObj.options[ selObj.selectedIndex ].value + "'" );
		  
		  if( restore ) {
		  	selObj.selectedIndex = 0;
		  }
		}
		
		function init( thisScript, passedPageId, subNavId ) {
			var imId = ( isNav4 ? document.images : document.getElementById( 'navImg' ) );
			var imagePos = getRealXY( imId, 'navLocation' );	   
		  var width = 215;
		  var height = 20;
		  
		  var floaters = new Array();
		  
		  var x = ( isNav4 ? document.images[ 'navImg' ].x + 10 : imagePos.x + 10 );
		  var y = ( isNav4 ? document.images[ 'navImg' ].y + 8 : imagePos.y + 8 );
		 
		  var passedPageId;
		
			if( window.top.location.search != 0 ) {
				passedPageId = getParameter( window.top.location.search, 'page' );
			}
		
			list = new List( true, width, height, thisScript );

	<?	$floaterId = 0;
			$navResult = $db->query( "select pages_nav.page_id, pages_nav.name, pages_nav.type, pages_nav.base_image, pages.file_name ".
	                             "  from pages_nav, pages ".
	                             " where pages_nav.page_id     = pages.page_id ".
	                             "   and pages_nav.country_id  = '$sess_country_id' ".
	                             "   and pages_nav.language_id = '$sess_language_id' ".
	                             "   and pages.parent_page_id  = '0' ".
	                             "   and pages.live            = 'Y' ".
	                             " order by pages_nav.position asc" );
	                             
	    if( $db->numRows( $navResult ) ) {
	    	while( list( $pageId, $textName, $navType, $baseImage, $fileName ) = $db->fetchRow( $navResult ) ) {
	    		if( $navType == "basic" ) {
	    			
	    			$childResult = $db->query( "select pages_nav.name, pages.file_name, pages.target, pages_nav.type ".
	    			                           "  from pages, pages_nav ".
	    			                           " where pages.parent_page_id  = '$pageId' ".
	    			                           "   and pages.page_id         = pages_nav.page_id " .
	    			                           "   and pages_nav.country_id  = '$sess_country_id' ".
	    			                           "   and pages_nav.language_id = '$sess_language_id' ".
	    			                           " order by position asc" );
	    			
	    			if( $db->numRows( $childResult ) ) {
	    				list( $childName, $childFileName, $childTarget, $childType ) = $db->fetchRow( $childResult );
	    				if( $childType != "sitemap" ) {	?>
   				
	   						floaters[ <?= $floaterId; ?> ] = new List( true, width, height, '<?= $childFileName; ?>' );
		    		
		    		<?	do {	?>
									floaters[ <?= $floaterId; ?> ].addItem( '<?= $childName; ?>', '', '<?= $childFileName; ?>', true, '<?= $childTarget ? $childTarget : "_self"; ?>' );
						<?	}	while( list( $childName, $childFileName, $childTarget, $childType ) = $db->fetchRow( $childResult ) ); ?>
											
				  			list.addFloater( floaters[ <?= $floaterId++; ?> ], '<?= $textName; ?>', '<?= $baseImage; ?>', '<?= $fileName; ?>' );						
				<?		} else {	?>
								list.addItem( '<?= $textName; ?>', '<?= $baseImage; ?>', '<?= $fileName; ?>' );
				<?		}
						} else {	?>
		  				list.addItem( '<?= $textName; ?>', '<?= $baseImage; ?>', '<?= $fileName; ?>' );
		  	<?	}
					} elseif( $navType == "products" ) {	?>	
						prods = new List( false, width, height );
				
				<?	$arrayIndex = 0;
				
						$familyResult = $db->query( "select family_id, name from products_family where country_id='$sess_country_id' and language_id='$sess_language_id' and live='Y' order by priority" );
						if( $db->numRows( $familyResult ) ) {
							while( list( $familyId, $familyName ) = $db->fetchRow( $familyResult ) ) {
								$familyName = preg_replace( "/(\015\012)|(\015)|(\012)/", "", $familyName ); 
								$prodsResult = $db->query( "select product_id, name from products where family_id='$familyId' order by priority" );
								
								if( $db->numRows( $prodsResult ) ) {	?>
									prodFloat_<?= $arrayIndex; ?> = new List( true, width, height );
									
							<?	while( list( $productId, $productName ) = $db->fetchRow( $prodsResult ) ) {
										$productName = preg_replace( "/(\015\012)|(\015)|(\012)/", "", $productName ); 	?>
										prodFloat_<?= $arrayIndex; ?>.addItem( '<?= addslashes( $productName ); ?>', '', 'products_details.php?product_id=<?= $productId; ?>', true );
							<?	}	?>
								
									prods.addFloater( prodFloat_<?= $arrayIndex; ?> , '<?= addslashes( $familyName ); ?>', '', 'products_family.php?family_id=<?= $familyId; ?>'  );
					<?		} else {	?>
									prods.addItem( '<?= addslashes( $familyName ); ?>', '', 'products_family.php?family_id=<?= $familyId; ?>' );
					<?		}
							
								$arrayIndex++;	
							}
						}		?>
						
					  list.addList( prods, '<?= $textName; ?>', '<?= $baseImage; ?>', '<?= $fileName; ?>' );
			<?	}
				}
			}
			
			$searchNavResult = $db->query( "select base_image ".
			                               "  from pages_nav ".
			                               " where type        = 'search' ".
			                               "   and country_id  = '$sess_country_id' ".
			                               "   and language_id = '$sess_language_id'" );
			
			if( $db->numRows( $searchNavResult ) ) {
				list( $searchBaseImage ) = $db->fetchRow( $searchNavResult );
				
				$searchFileName = "images/nav/" . $searchBaseImage . ".gif";
				if( $searchFileName && file_exists( realpath( "../" . $searchFileName ) ) ) {
					list( $width, $height, $type, $htmlWh ) = getimagesize( realpath( "../" . $searchFileName ) );
				}
				
				$butFileName = $buttonArr[ "go" ][ 0 ];
				if( $butFileName && file_exists( realpath( "../" . $butFileName ) ) ) {
					list( $bwidth, $bheight, $btype, $bhtmlWh ) = getimagesize( realpath( "../" . $butFileName ) );
				}
					?>
			
				list.addHTML( '<table border="0" cellspacing="0" cellpadding="0"><tr><td style="padding-top: 20px;"><form action="search_results.php" name="searchNav" method="get"><img src="<?= $searchFileName; ?>" width="<?= $width; ?>" height="<?= $height; ?>"><input type="text" name="searchStr" ' + (isNav4 ? 'size="7"' : 'style="width: <?= 116 - $bwidth; ?>px;"') + '>&nbsp;<a href="javascript:document.searchNav.submit();"><img src="<?= $buttonArr[ "go" ][ 0 ]; ?>" width="<?= $bwidth; ?>" height="<?= $bheight; ?>" border="0" align="absmiddle" /></a></form></td></tr></table>', '58', '215' );
	<?	}	?>
		
		 	list.build( x, y );
			list.setActiveItem( passedPageId );
		
			if( !isNav4 ) {
				document.body.onresize = function( e ) {
					var imId = document.getElementById( 'navImg' );
					var imagePos = getRealXY( imId, 'navImg' );	   
			
			  	var x = ( imagePos.x + 10 );
				  var y = ( imagePos.y + 8 );
			
					list.build( x, y );
				}
			}
		}

		function getParameter ( queryString, parameterName ) {
			var parameterName = parameterName + '=';
		
			if ( queryString.length > 0 ) {
				begin = queryString.indexOf ( parameterName );
		
				if ( begin != -1 ) {
					begin += parameterName.length;
		
					end = queryString.indexOf ( '&' , begin );
		
					if ( end == -1 ) {
						end = queryString.length
					}
		
					return( unescape( queryString.substring ( begin, end ) ) );
				}
		
				return( null );
			}
		}
