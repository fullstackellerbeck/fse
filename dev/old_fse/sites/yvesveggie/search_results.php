<?	include( "inc/init.php" );

		if( !session_is_registered( "sess_country_id" ) || !session_is_registered( "sess_language_id" ) ) {
			header( "Location: splash.php?referer=$scriptName" );
		}
				
		$pageResult = $db->query( "select pages.name, pages.shot_id, pages_content.page_title, pages_content.title_image, pages_content.content, pages_content.extra_content, pages_content.auto_html ".
		                          "  from pages, pages_content ".
		                          " where pages.file_name = '$scriptName' ".
		                          "   and pages.page_id   = pages_content.page_id ".
		                          "   and pages_content.country_id  = '$sess_country_id' ".
		                          "   and pages_content.language_id = '$sess_language_id' " );
		
		if( $db->numRows( $pageResult ) ) {
			list( $pageName, $pageShotId, $pageTitle, $titleImage, $content, $extraContent, $autoHTML ) = $db->fetchRow( $pageResult );
			
			if( $titleImage && file_exists( realpath( $titleImage ) ) ) {
				list( $width, $height, $type, $htmlWh ) = getimagesize( realpath( $titleImage ) );
			}
			
			$shotResult = $db->query( !$pageShotId ? "select name, file_name from beauty_shots order by rand() limit 1" : "select name, file_name from beauty_shots where shot_id = '$pageShotId'" );
			if( $db->numRows( $shotResult ) ) {
				list( $shotName, $shotFileName ) = $db->fetchRow( $shotResult );
			}
		}	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie Cuisine<?= prepStr( " - $pageTitle" ); ?></title>

		<script language="javascript" src="js/browser_sniff.js"></script>
		
		<script language="Javascript" src="js/nav.php"></script>
		<script language="Javascript" src="js/init.php"></script>
		<script language="Javascript" src="js/resize.js"></script>

		<link rel="stylesheet" type="text/css" href="css/styles.css" />
		<link rel="stylesheet" type="text/css" href="css/nav.php" />		
	</head>
	
	<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="init('<?= $scriptName; ?>');">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td align="center">
		      <table width="737" border="0" cellspacing="0" cellpadding="0">
		        <tr> 
		          <td colspan="2"><img src="images/universal/logo.gif" width="248" height="147" alt="Yves Veggie Cuisine" /></td>
		          <td colspan="4"><img src="<?= $shotFileName; ?>" width="495" height="110" alt="<?= $shotName; ?>" /><br /><img src="images/universal/h_bot.gif" width="495" height="37" alt="" /></td>
		        </tr>
		        <tr> 
		          <td bgcolor="#FFCC00" rowspan="3"><img src="images/universal/spacer.gif" width="3" height="1" alt="" /></td>
		          <td><img src="images/universal/spacer.gif" width="245" height="1" alt="" /></td>
		          <td rowspan="2"><img src="images/universal/spacer.gif" width="13" height="1" alt="" /></td>
		          <td><img src="images/universal/spacer.gif" width="473" height="1" alt="" /></td>
		          <td rowspan="2"><img src="images/universal/spacer.gif" width="6" height="1" alt="" /></td>
		          <td bgcolor="#FFCC00" rowspan="3"><img src="images/universal/spacer.gif" width="3" height="1" alt="" /></td>
		        </tr>
		        <tr> 
		          <td valign="top"><div name="navLocation" id="navLocation"></div><img src="images/universal/spacer.gif" width="245" height="469" name="navImg" id="navImg" /></td>
		          <td valign="top" align="left"> 

						<?	$spage = (!$spage ? 1 : $spage);
								
								if( $searchStr ) {
									$searchArr = explode( " ", $searchStr );
									
									$noiseResult = $db->query( "select word from search_noise_words" );
									if( $db->numRows( $noiseResult ) ) {
										while( list( $noiseWord ) = $db->fetchRow( $noiseResult ) ) {
											$noiseWords[] = $noiseWord;
										}
									
										foreach( $searchArr as $srchWord ) {
											if( !in_array( $srchWord, $noiseWords ) ) {
												$newSearchArr[] = $srchWord;
											}
										}
									}
												
									$searchStr = implode( " ", $newSearchArr );
									
									// search page content
									$contentColumnArr = array( "pages_content.content", "pages_content.page_title", "pages_content.extra_content", "pages_content.right_content" );								
									$srchQuery = makeSearch( $searchStr, $contentColumnArr );
									
									$contentResult = $db->query( "select pages.file_name, pages_content.page_title, pages_content.content ".
							                                 "  from pages, pages_content " .
							                                 " where ( $srchQuery ) ".
							                                 "   and pages.page_id              = pages_content.page_id ".
							                                 "   and pages_content.language_id  = '$sess_language_id' ".
							                                 "   and pages_content.country_id   = '$sess_country_id'" );
	
	
			        		if( $db->numRows( $contentResult ) ) {
				        		while( list( $fileName, $pageTitle, $content ) = $db->fetchRow( $contentResult ) ) {
				        			$resultsArr[] = array( $fileName, $pageTitle, $content );
				        		}
			  					}
			  					      		
			        		// search products
									$productsColumnArr = array( "products.name", "products.description" );								
									$srchQuery = makeSearch( $searchStr, $productsColumnArr );
									
									$productResult = $db->query( "select products.product_id, products.name, products.description, products_family.name ".
							                                 "  from products, products_family " .
							                                 " where ( $srchQuery ) ".
							                                 "   and products.family_id          = products_family.family_id ".
							                                 "   and products_family.language_id = '$sess_language_id' ".
							                                 "   and products_family.country_id   = '$sess_country_id'" );
	
			        		if( $db->numRows( $productResult ) ) {
				        		while( list( $productId, $productName, $productDescription, $familyName ) = $db->fetchRow( $productResult ) ) {
	        						$noSpace = str_replace( " ", "%20", $familyName );
											$noSpace = str_replace( "&", urlencode( "&" ), $noSpace );

				        			$resultsArr[] = array( "products_details.php?product_id=$productId&page=1&pIdName=$noSpace", $productName, $productDescription );
				        		}
									}
									
			        		// search recipes
									/* $recipeColumnArr = array( "recipes.name", "recipes.directions", "recipes_ingredients.name" );								
									$srchQuery = makeSearch( $searchStr, $recipeColumnArr );
									
									$recipeResult = $db->query( "select recipes.recipe_id, recipes.name, recipes.directions ".
							                                 "  from recipes, recipes_ingredients " .
							                                 " where ( $srchQuery ) ".
							                                 "   and recipes.recipe_id   = recipes_ingredients.recipe_id ".
							                                 "   and recipes.language_id = '$sess_language_id' ".
							                                 "   and recipes.country_id  = '$sess_country_id'" );
	
			        		if( $db->numRows( $recipeResult ) ) {
				        		while( list( $recipeId, $recipeName, $recipeDirections ) = $db->fetchRow( $recipeResult ) ) {
				        			$resultsArr[] = array( "recipes_details.php?recipe_id=$recipeId", $recipeName, $recipeDirections );
				        		}
									}	*/
									
			        		// search media releases
									$releaseColumnArr = array( "title", "content" );								
									$srchQuery = makeSearch( $searchStr, $releaseColumnArr );
									
									$releaseResult = $db->query( "select release_id, title, content ".
							                               "  from media_releases " .
							                               " where ( $srchQuery ) ".
							                               "   and language_id = '$sess_language_id' ".
							                               "   and country_id  = '$sess_country_id'" );
	
			        		if( $db->numRows( $releaseResult ) ) {
				        		while( list( $releaseId, $releaseTitle, $releaseContent ) = $db->fetchRow( $releaseResult ) ) {
				        			$resultsArr[] = array( "about_media_display.php?release_id=$releaseId", $releaseTitle, $releaseContent );
				        		}
									}
	
							    $totalPages = ceil(sizeof( $resultsArr ) / 4);
									$limit = ( $spage - 1 ) * 4;
								}	?>						
								
		            <h1><img src="<?= $titleImage; ?>" width="<?= $width; ?>" height="<?= $height; ?>" alt="<?= $pageName; ?>" /></h1>
		            
				<?			if( sizeof( $resultsArr ) > 0 ) {

									$foundStr = prepStr( $copyArr[ "site_search_found" ] );
									$foundStr = str_replace( "%contentCount%", $contentCount, $foundStr );
									$foundStr = str_replace( "%page%", $spage, $foundStr );
									$foundStr = str_replace( "%totalPages%", $totalPages, $foundStr );
									echo( "<p>$foundStr</p>\n" );	
	
			        		for( $i = $limit; $i < ($limit + 4); $i++ ) {
			        			$searchArr = explode( " ", $searchStr );
			        			$contentArr = explode( " ", strip_tags( $resultsArr[ $i ][ 2 ] ) );
			        			
			        			foreach( $searchArr as $searchWord ) {
			        				for( $acnt = 0; $acnt < sizeof( $contentArr ); $acnt++ ) {
			        					if( eregi( $searchWord, $contentArr[ $acnt ] ) ) {
			        						$contentArr[ $acnt ] = eregi_replace( $searchWord, '<span class="hilite">' . $searchWord . '</span>', $contentArr[ $acnt ] );
			        						$foundPos[] = $acnt;
			        					}
			        				}
			        			}
			        			
			        			$resultContent = implode( " ", array_slice( $contentArr, $foundPos[ 0 ] ) ); ?>
				            <span class="subhead"><a href="<?= $resultsArr[ $i ][ 0 ]; ?>"><?= prepStr( strip_tags( truncWords( $resultsArr[ $i ][ 1 ], 15 ) ) ); ?></a></span>
				            <blockquote>
				            	<p>
				            		<?= truncWords( prepStr( $resultContent ), 30 ); ?><br>
				            	</p>
				            </blockquote>
				            
							<?		unset( $contentArr );
										unset( $foundPos );
									}	?>		            
			            
			            
			            <p>&nbsp;</p>
			        <?	if( $totalPages > 1 ) {
			        			for( $ct = 1; $ct <= $totalPages; $ct++ ) {	?>
			        				<?= $ct > 1 ? "  &middot; " : ""; ?><a href="<?= "$scriptName?spage=$ct" . "&searchStr=" . urlencode( $searchStr ); ?>"><?= $spage == $ct ? "<b>$ct</b>" : $ct; ?></a>
			        <?		}
			        		}
			        	} else {	?>
			        		<p><?= prepStr( $copyArr[ "site_search_not_found" ] ); ?></p>			        	
			       <?	}	?>
		          </td>
		        </tr>
		        <tr><td valign="top" background="images/universal/gradient.gif" colspan="4"><img src="images/universal/spacer.gif" width="1" height="36" alt="" /></td></tr>
		        <tr><td background="images/universal/wheat.gif" colspan="6"><img src="images/universal/spacer.gif" width="1" height="9" alt="" /></td></tr>
		      </table>  
		      <table width="737" border="0" cellspacing="0" cellpadding="0">
		        <tr> 
		          <td align="left"><div class="footer"><a href="http://www.hain-celestial.com">A Division of Hain Celestial Group, Inc. </a></div></td>
		          <td align="right"><div class="footer"><a href="terms.php">Privacy / Legal</a></div></td>
		        </tr>
		      	<tr><td colspan="2" align="center"><div class="smallfooter" style="padding-bottom: 10px;">Design by <a href="http://www.raisedeyebrow.com/" target="_blank">Raised Eyebrow Web Studio</a>, development by <a href="http://www.igivegoodweb.com/" target="_blank">I Give Good Web</a>.</div></td></tr>
		      </table>
		    </td>
		  </tr>
		</table>
<?	include( "nav_layers.php" );	?>
	</body>
</html>
