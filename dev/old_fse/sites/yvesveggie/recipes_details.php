<?	include( "inc/init.php" );

		if( !session_is_registered( "sess_country_id" ) || !session_is_registered( "sess_language_id" ) ) {
			header( "Location: splash.php?referer=$scriptName" );
		}
				
		$pageResult = $db->query( "select pages.name, pages.shot_id ".
		                          "  from pages ".
		                          " where pages.file_name = '$scriptName' " );
		
		if( $db->numRows( $pageResult ) ) {
			list( $pageName, $pageShotId ) = $db->fetchRow( $pageResult );
			
			if( $titleImage && file_exists( realpath( $titleImage ) ) ) {
				list( $width, $height, $type, $htmlWh ) = getimagesize( realpath( $titleImage ) );
			}
			
			$shotResult = $db->query( !$pageShotId ? "select name, file_name from beauty_shots order by rand() limit 1" : "select name, file_name from beauty_shots where shot_id = '$pageShotId'" );

			if( $db->numRows( $shotResult ) ) {
				list( $shotName, $shotFileName ) = $db->fetchRow( $shotResult );
			}
		}
		
		$recipeResult = $db->query( "select name, directions, servings from recipes where recipe_id = '$recipe_id'" );

		if( $db->numRows( $recipeResult ) ) {
			list( $recipeName, $recipeDirections, $recipeServings ) = $db->fetchRow( $recipeResult );
		}	?>
		
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie Cuisine - <?= prepStr( $recipeName ); ?></title>

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
		          <td valign="top"><div name="navLocation" id="navLocation"></div><img src="images/universal/spacer.gif" width="245" height="469" name="navImg" id="navImg" alt="" /></td>
		          <td valign="top" align="left">
		            <h3 style="margin: 0px; padding: 0px;"><?= $recipeName; ?></h3>
		            <span class="small"><?= $recipeServings; ?></span>
		            <p><?= $recipeDescription; ?></p>
		            <table width="100%" border="0" cellspacing="0" cellpadding="2">
		              <tr> 
		                <td valign="top" align="left"> 
					            <p class="subhead" style="padding: 0px 0px 5px 0px; margin: 0px 0px 0px 0px;"><?= prepStr( $copyArr[ "ingredients" ] ); ?></p>
					            <table width="330" border="0" cellspacing="0" cellpadding="0">
					              <tr valign="middle" bgcolor="#FEECC8"> 
					                <td><img src="images/universal/spacer.gif" width="10" height="1" border="0"></td>
					                <td><img src="images/universal/spacer.gif" width="63" height="1" border="0"></td>
					                <td><img src="images/universal/spacer.gif" width="20" height="1" border="0"></td>
					                <td><img src="images/universal/spacer.gif" width="237" height="1" border="0"></td>
					              </tr>
			
										<?	$bgColor = true;
										
												$ingredientsResult = $db->query( "select name, product_id, quantity from recipes_ingredients where recipe_id = '$recipe_id'" );
												if( $db->numRows( $ingredientsResult ) ) {
													while( list( $ingName, $ingProductId, $ingQty ) = $db->fetchRow( $ingredientsResult ) ) {
														
														if( $ingProductId != 0 ) {
															$productResult = $db->query( "select name from products where product_id = '$ingProductId'" );
															
															if( $db->numRows( $productResult ) ) {
																list( $productName ) = $db->fetchRow( $productResult );
															}
														}	?>
			
							              <tr valign="middle" width="330" bgcolor="<?= $bgColor ? "#FEECC8" : "#FFFFFF"; ?>"> 
							                <td><img src="images/universal/spacer.gif" width="10" height="1" border="0"></td>
							                <td valign="top" width="63"><span class="small"><?= prepStr( $ingQty ); ?></span></td>
							                <td valign="top" width="20"><img src="images/universal/spacer.gif" width="20" height="1" border="0"></td>
							                <td valign="top" width="227"><span class="small"><?= $ingProductId ? "<a href=\"products_details.php?product_id=$ingProductId\"><strong>" . stripslashes( $productName ) ."</strong></a>" : stripslashes( $ingName ); ?></span></td>
							              </tr>
											<?		$bgColor = !$bgColor;
													}
												}	?>
												
					            </table>
		                </td>
		                <td valign="top" align="right"><p class="small"><a href="javascript:void(window.open('recipes_details_print.php?recipe_id=<?= $recipe_id; ?>','print_recipe','width=440,height=500,scrollbars=yes,menubar=no,statusbar=no,toolbar=yes'));"><?= prepStr( $copyArr[ "print_recipe" ] ); ?></a></p></td>
		                <td valign="top" align="right" width="23"><p class="small"><img src="images/universal/i_print.gif" width="23" height="18" /></p></td>
		              </tr>
		            </table>
		            
		            <br />
		            <table border="0" cellspacing="0" cellpadding="0" width="400">
		            	<tr><td><p><?= nl2br( prepStr( $recipeDirections ) ); ?></p></td></tr>
		            </table>

								<p>&nbsp;</p>

								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td valign="top">
											<span class="small"><b><?= prepStr( $copyArr[ "nutri_info_serving" ] ); ?></b></span>
			                <p class="small">
										<?	$nutriResult = $db->query( "select name, value from recipes_nutritional where recipe_id = '$recipe_id' order by nutritional_id asc" );
											
												if( $db->numRows( $nutriResult ) ) {
													while( list( $nutriName, $nutriValue ) = $db->fetchRow( $nutriResult ) ) {	?>
														<?= strtr( $nutriName, $trans ); ?>: <?= strtr( $nutriValue, $trans ); ?><br />
											<?	}
												}	?>
											</p>
										</td>
										<td><img src="images/universal/spacer.gif" width="30" height="1" border="0"></td>
                 		<td valign="top">
                 			<span class="small"><b><?= prepStr( $copyArr[ "calories_from" ] ); ?></b></span>
                 			<p class="small">                 	
			               <?	$calorieResult = $db->query( "select name, value from recipes_nutritional_calories where recipe_id = '$recipe_id' order by calorie_id asc" );
			               
			               		if( $db->numRows( $calorieResult ) ) {
			               			while( list( $calName, $calValue ) = $db->fetchRow( $calorieResult ) ) {	?>
			               				<?= strtr( $calName, $trans ); ?>: <?= strtr( $calValue, $trans ); ?><br />
			               	<?	}
			               		}	?>
			              	</p>
										</td>
									</tr>
								</table>
		        
		            <p>&nbsp;</p>
		            </td>
		        </tr>
		        <tr> <td valign="top" background="images/universal/gradient.gif" colspan="4"><img src="images/universal/spacer.gif" width="1" height="36" alt="" /></td></tr>
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
