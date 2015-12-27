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
		<title>Yves Veggie Cuisine - <?= prepStr( $pageTitle ); ?></title>

		<script language="javascript" src="js/browser_sniff.js"></script>
		
		<script language="Javascript" src="js/nav.php"></script>
		<script language="Javascript" src="js/init.php"></script>
		<script language="Javascript" src="js/resize.js"></script>

		<link rel="stylesheet" type="text/css" href="css/sitemap.css" />
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
		            <h1><img src="<?= $titleImage; ?>" width="<?= $width; ?>" height="<?= $height; ?>" alt="<?= $pageName; ?>" /></h1>
		            <p><?= ( $autoHTML == "Y" ? nl2br( prepStr( $content ) ) : prepStr( $content ) );	?></p>

						<?	$displayResult = $db->query( "select pages_nav.page_id, pages_nav.name, pages_nav.type, pages.file_name, pages.target ".
						                                 "  from pages_nav, pages ".
						                                 " where pages_nav.page_id     = pages.page_id ".
						                                 "   and pages.parent_page_id  = '0' ".
						                                 "   and pages_nav.language_id = '$sess_language_id' ".
						                                 "   and pages_nav.country_id  = '$sess_country_id' ".
						                                 " order by pages_nav.position asc" );
								if( $db->numRows( $displayResult ) ) {
									while( list( $pageId, $name, $type, $fileName, $target ) = $db->fetchRow( $displayResult ) ) {	?>
				            <p><strong><a href="<?= $fileName; ?>" target="<?= $target; ?>"><?= prepStr( $name ); ?></a></strong></p>
									
								<?	if( $type == "products" ) {	?>
					            <blockquote> 
										<?	$familyResult = $db->query( "select family_id, name ".
										                                "  from products_family ".
										                                " where country_id  = '$sess_country_id' ".
										                                "   and language_id = '$sess_language_id' ".
										                                "   and live        = 'Y'" );
										    if( $db->numRows( $familyResult ) ) {
										    	while( list( $familyId, $familyName ) = $db->fetchRow( $familyResult ) ) {	?>
					              		<p class="small"><a href="products_family.php?family_id=<?= $familyId; ?>"><strong><?= strtr( stripslashes( $familyName ), $trans ); ?></strong></a></p>
			
							              <blockquote> 
							                <p class="small">
														<?	$productResult = $db->query( "select product_id, name ".
														                                 "  from products ".
														                                 " where family_id = '$familyId' ".
														                                 "   and live      = 'Y'" );
														    if( $db->numRows( $productResult ) ) {
														    	while( list( $productId, $productName ) = $db->fetchRow( $productResult ) ) {	?>
							                			<a href="products_details.php?product_id=<?= $productId; ?>"><?= strtr( stripslashes( $productName ), $trans ); ?></a><br>
							                <?	}
							                	}	?>
							                </p>
							              </blockquote>
											<?	}
												}	?>
					            </blockquote>
	
								<?	}

										$bgColor = !$bgColor;
										
										$childResult = $db->query( "select pages_nav.page_id, pages_nav.name, pages.file_name, pages.target ".
										                           "  from pages_nav, pages ".
										                           " where pages_nav.page_id     = pages.page_id ".
										                           "   and pages.parent_page_id  = '$pageId' ".
										                           "   and pages_nav.language_id = '$sess_language_id' ".
						                                   "   and pages_nav.country_id  = '$sess_country_id' ".
						                                   " order by pages_nav.position asc" );
									  
									  if( $db->numRows( $childResult ) ) {	?>
									  	<blockquote>
									  		<p class="small">
									<?	while( list( $childPageId, $childName, $childFileName, $childTarget ) = $db->fetchRow( $childResult ) ) {	?>
		              			<a href="<?= $childFileName; ?>" target="<?= $childTarget; ?>" class="small"><?= prepStr( $childName ); ?></a><br>												
									<?	}	?>
												</p>
											</blockquote>
								<?	}
									}
								}	?>


		            <p>&nbsp;</p>
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
