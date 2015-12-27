<?	include( "inc/init.php" );

		if( !session_is_registered( "sess_country_id" ) || !session_is_registered( "sess_language_id" ) ) {
			header( "Location: splash.php?referer=$scriptName" );
		}

		$productResult = $db->query( "select products.family_id, products.name, products.image, products.serving_size, products.per_pack, products.description, products.ingredients, products_family.shot_id ".
	                               "  from products, products_family ".
	                               " where products.product_id = '$product_id' ".
	                               "   and products.family_id  = products_family.family_id ".
	                               "   and products.live       = 'Y'" );
	   
	   if( $db->numRows( $productResult ) ) {
	   	list( $familyId, $name, $image, $servingSize, $perPack, $description, $ingredients, $shotId ) = $db->fetchRow( $productResult );

			$shotResult = $db->query( !$shotId ? "select name, file_name from beauty_shots order by rand() limit 1" : "select name, file_name from beauty_shots where shot_id = '$shotId'" );
			if( $db->numRows( $shotResult ) ) {
				list( $shotName, $shotFileName ) = $db->fetchRow( $shotResult );
			}	   	
	   }	?>										     	
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie Cuisine - <?= prepStr( $name ); ?></title>
		<script language="javascript" src="js/browser_sniff.js"></script>
		
		<script language="Javascript" src="js/nav.php"></script>
		<script language="Javascript" src="js/init.php"></script>
		<script language="Javascript" src="js/resize.js"></script>

		<link rel="stylesheet" type="text/css" href="css/nsstyles.css" />
		<style type="text/css" media="all"> @import url( css/styles.css ); </style> 
		
		<link rel="stylesheet" type="text/css" href="css/nav.php" />		
	</head>
	
	<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="init('products.php');">
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
		            <table width="100%" border="0" cellspacing="0" cellpadding="0">
		              <tr> 
		                <td align="left" valign="top" width="309">
		                    <h1><?= prepStr( $name ); ?></h1>
		                    <p><?= nl2br( prepStr( $description ) ); ?></p><br />
		                    <span class="subhead"><?= prepStr( $copyArr[ "ingredients" ] ); ?></span><br />
		                    <p class="small"><?= nl2br( prepStr( $ingredients ) ); ?></p><br>

										    <table width="264" border="0" cellspacing="0" cellpadding="0">
										      <tr>
										      	<td colspan="4" bgcolor="#ffffff"><span class="subhead"><?= prepStr( $copyArr[ "nutri_info" ] ); ?></span></td>
										      </tr>
										      <tr valign="middle"> 
										        <td bgcolor="#ffffff" class="small"><img src="images/universal/spacer.gif" width="4" height="10" /></td>
										        <td bgcolor="#ffffff" class="small"><img src="images/universal/spacer.gif" width="160" height="10" /></td>
										        <td bgcolor="#ffffff" class="small"><img src="images/universal/spacer.gif" width="55" height="10" /></td>
										        <td bgcolor="#ffffff" class="small"><img src="images/universal/spacer.gif" width="55" height="10" /></td>
										      </tr>
										      <tr valign="middle"> 
										        <td bgcolor="#FEECC8" class="small"><img src="images/universal/spacer.gif" width="4" height="1" /></td>
										        <td colspan="3" bgcolor="#FEECC8" class="small"><strong><?= strtr( stripslashes( $name ), $trans ); ?>: <?= prepStr( $copyArr[ "nutri_info" ] ); ?></strong></td>
										      </tr>
										      <tr valign="middle"> 
										        <td colspan="4" class="small"><strong>&nbsp;</strong></td>
										      </tr>
										      <tr valign="middle"> 
										        <td bgcolor="#FEECC8" class="small">&nbsp;</td>
										        <td colspan="3" bgcolor="#FEECC8" class="small"><strong><?= prepStr( $copyArr[ "serving_size" ] ); ?> <?= $servingSize; ?> </strong></td>
										      </tr>
										      <tr valign="middle"> 
										        <td class="small">&nbsp;</td>
										        <td colspan="3" class="small"><strong><?= prepStr( $copyArr[ "servings_per" ] ); ?> <?= $perPack; ?></strong></td>
										      </tr>
										      <tr valign="middle"> 
										        <td bgcolor="#FEECC8" colspan="4" class="small"><strong>&nbsp;</strong></td>
										      </tr>
										  
										  <?	$rdiCountResult = $db->query( "select count( products_nutritional_attribs.product_id ) " .
										                                    "  from products_nutritional_attribs, nutritional_attribs ".
										                                    " where products_nutritional_attribs.product_id = '$product_id' ".
										                                    "   and products_nutritional_attribs.attribute_id = nutritional_attribs.attribute_id ".
										                                    "   and nutritional_attribs.is_rdi = 'Y'" );
										      
										      if( $db->numRows( $rdiCountResult ) ) {
										      	list( $rdiCount ) = $db->fetchRow( $rdiCountResult );
										      }	?>
										      
										      <tr> 
										        <td class="small" valign="middle">&nbsp;</td>
										        <td class="small" colspan="2" valign="middle"><?= prepStr( $copyArr[ "amount_per" ] ); ?></td>
										        <td valign="middle" class="small">&nbsp;</td>
										      </tr>
										
				<?	$bgColor = true;
						$nutriCountResult = $db->query( "select count( * ) ".
						                          "  from nutritional_attribs, products_nutritional_attribs ".
				                              " where products_nutritional_attribs.product_id   = '$product_id' ".
				                              "   and products_nutritional_attribs.attribute_id = nutritional_attribs.attribute_id ".
				                              "   and nutritional_attribs.country_id            = '$sess_country_id' ".
				                              "   and nutritional_attribs.language_id           = '$sess_language_id' ".
				                              "   and nutritional_attribs.live                  = 'Y' ".
				                              "   and nutritional_attribs.is_rdi                = 'Y'" );
				    if( $db->numRows( $nutriCountResult ) ) {
				    	list( $totalRDI ) = $db->fetchRow( $nutriCountResult );
				    }                          
													
						$nutriResult = $db->query( "select nutritional_attribs.attribute_id, nutritional_attribs.name, nutritional_attribs.units, nutritional_attribs.is_rdi, products_nutritional_attribs.value ".
				                               "  from nutritional_attribs, products_nutritional_attribs ".
				                               " where products_nutritional_attribs.product_id   = '$product_id' ".
				                               "   and products_nutritional_attribs.attribute_id = nutritional_attribs.attribute_id ".
				                               "   and nutritional_attribs.country_id            = '$sess_country_id' ".
				                               "   and nutritional_attribs.language_id           = '$sess_language_id' ".
				                               "   and nutritional_attribs.live                  = 'Y' ".
				                               "   and nutritional_attribs.p_attribute_id        = '0' ".
				                               " order by nutritional_attribs.priority asc, nutritional_attribs.is_rdi desc" );
				    if( $oldTotalRows = $db->numRows( $nutriResult ) ) {
							$nutriAmmResult = $db->query( "select count( nutritional_attribs.attribute_id ) ".
					                                  "  from nutritional_attribs, products_nutritional_attribs ".
					                                  " where products_nutritional_attribs.product_id   = '$product_id' ".
					                                  "   and products_nutritional_attribs.attribute_id = nutritional_attribs.attribute_id ".
					                                  "   and nutritional_attribs.country_id            = '$sess_country_id' ".
					                                  "   and nutritional_attribs.language_id           = '$sess_language_id' ".
					                                  "   and nutritional_attribs.live                  = 'Y' " .
					                                  "   and nutritional_attribs.is_rdi                = 'N'" );
					    
					    if( $nutriAmmResult && $db->numRows( $nutriAmmResult ) ) {
					    	list( $totalRows ) = $db->fetchRow( $nutriAmmResult );
					    }
					    
				    	$totalNutri = $totalRows;
				    	$nutriCount = 1;
				    	$nutriDone = false;
				    	
				    	while( list( $attribId, $nutriName, $nutriUnits, $isRDI, $nutriValue ) = $db->fetchRow( $nutriResult ) ) {
				    		if( strstr( $nutriValue, "." ) ) {
				    			$nutriValue = number_format( $nutriValue, 1 );
				    		}	?>
			          <tr> 
			            <td bgcolor="<?= $bgColor ? "#FEECC8" : "#FFFFFF"; ?>" class="small" valign="middle" align="left">&nbsp;</td>
			            <td bgcolor="<?= $bgColor ? "#FEECC8" : "#FFFFFF"; ?>" class="small" valign="middle" align="left"><?= $nutriName; ?></td>
			            <td bgcolor="<?= $bgColor ? "#FEECC8" : "#FFFFFF"; ?>" class="small" valign="middle" align="left"><?= ($isRDI == "N" ? str_replace(".", $numSeperator, $nutriValue). " $nutriUnits" : "&nbsp;" ); ?></td>
			            <td bgcolor="<?= $bgColor ? "#FEECC8" : "#FFFFFF"; ?>" class="small" valign="middle" align="left"><?= ($isRDI == "Y" ? "$nutriValue $nutriUnits%" : "&nbsp;"); ?></td>
			          </tr>

						<?	$subNutriResult = $db->query( "select nutritional_attribs.name, nutritional_attribs.units, nutritional_attribs.is_rdi, products_nutritional_attribs.value ".
							                                "  from nutritional_attribs, products_nutritional_attribs ".
							                                " where products_nutritional_attribs.product_id   = '$product_id' ".
							                                "   and products_nutritional_attribs.attribute_id = nutritional_attribs.attribute_id ".
							                                "   and nutritional_attribs.country_id            = '$sess_country_id' ".
							                                "   and nutritional_attribs.language_id           = '$sess_language_id' ".
							                                "   and nutritional_attribs.live                  = 'Y' ".
							                                "   and nutritional_attribs.p_attribute_id        = '$attribId' ".
							                                " order by nutritional_attribs.priority asc, nutritional_attribs.is_rdi desc" );
							  if( $totalRows = $db->numRows( $subNutriResult ) ) {										   				
						    	while( list( $nutriName, $nutriUnits, $isRDI, $nutriValue ) = $db->fetchRow( $subNutriResult ) ) {	?>
					          <tr> 
					            <td bgcolor="<?= $bgColor ? "#FEECC8" : "#FFFFFF"; ?>" class="small" valign="middle" align="left">&nbsp;</td>
					            <td bgcolor="<?= $bgColor ? "#FEECC8" : "#FFFFFF"; ?>" class="small" valign="middle" align="left">&nbsp&nbsp&nbsp;<?= $nutriName; ?></td>
					            <td bgcolor="<?= $bgColor ? "#FEECC8" : "#FFFFFF"; ?>" class="small" valign="middle" align="left"><?= ($isRDI == "N" ? str_replace(".", $numSeperator, $nutriValue). " $nutriUnits" : "&nbsp;" ); ?></td>
					            <td bgcolor="<?= $bgColor ? "#FEECC8" : "#FFFFFF"; ?>" class="small" valign="middle" align="left"><?= ($isRDI == "Y" ? "$nutriValue $nutriUnits%" : "&nbsp;"); ?></td>
					          </tr>
							<?		$nutriCount++;
									}
								}
			
								if( $nutriCount == $totalNutri ) {
									$bgColor = !$bgColor;	?>
									<tr>
										<td bgcolor="<?= $bgColor ? "#FEECC8" : "#FFFFFF"; ?>" colspan="3" class="small" valign="middle" align="left">&nbsp;</td>
										<td bgcolor="<?= $bgColor ? "#FEECC8" : "#FFFFFF"; ?>" class="small" valign="middle" align="left"><?= prepStr( $copyArr[ "rdi" ] ); ?></td>
									</tr>
						<?	}
					
								$bgColor = !$bgColor;															
								$nutriCount++;
							}
						}	?>
			    </table>

						                  
		                </td>
		                <td align="center" valign="top" width="8"><img src="images/universal/spacer.gif" width="8" height="1" /></td>
		                <td align="left" valign="top" width="167"> 
	                  	<img src="<?= $image; ?>" width="163" height="163" alt="<?= $name; ?>" border="0" /><br />
	                  	
	                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
	                      <tr> 
	                        <td valign="top"><img src="images/universal/i_recipe.gif" width="23" height="18" /></td>
	                        <td valign="top"><img src="images/universal/spacer.gif" width="4" height="1" /></td>
	                        <td valign="top"><a href="recipes_results.php?product_id=<?= $product_id; ?>" class="small"><?= $copyArr[ "search_recipes" ]; ?></a></td>
	                      </tr>
	                      <tr> 
	                        <td valign="top" colspan="3"><img src="images/universal/spacer.gif" width="1" height="8" /></td>
	                      </tr>
	                      <tr> 
	                        <td valign="top"><img src="images/universal/i_print.gif" width="23" height="18" /></td>
	                        <td valign="top"><img src="images/universal/spacer.gif" width="4" height="1" /></td>
	                        <td valign="top"><a href="javascript:void(window.open('products_details_print.php?product_id=<?= $product_id; ?>','review','width=440,height=500,scrollbars=yes,menubar=no,statusbar=no,toolbar=yes'));" class="small"><?= $copyArr[ "print_friendly" ]; ?></a></td>
	                      </tr>
	                      <tr> 
	                        <td valign="top" colspan="3"><img src="images/universal/spacer.gif" width="1" height="8" /></td>
	                      </tr>
	                      <tr> 
	                        <td valign="top"><img src="images/universal/i_review.gif" width="23" height="18" /></td>
	                        <td valign="top"><img src="images/universal/spacer.gif" width="4" height="1" /></td>
	                        <td valign="top"><a href="javascript:void(window.open('products_review.php?product_id=<?= $product_id; ?>','review','width=420,height=500,scrollbars=yes,menubar=no,statusbar=no,toolbar=no'));" class="small"><?= $copyArr[ "product_review" ]; ?></a></td>
	                      </tr>
	                      <tr> 
	                        <td valign="top" colspan="3"><img src="images/universal/spacer.gif" width="1" height="8" /></td>
	                      </tr>
										<?	$compareCountResult = $db->query( "select count( product_id ) from products_compare where product_id = '$product_id'" );
												list( $compareCount ) = $db->fetchRow( $compareCountResult );
												
												if( $compareCount > 0 ) {	?>
		                      <tr> 
		                        <td valign="top"><img src="images/universal/i_compare.gif" width="23" height="18" /></td>
		                        <td valign="top"><img src="images/universal/spacer.gif" width="4" height="1" /></td>
		                        <td valign="top"><a href="javascript:void(window.open('products_compare.php?product_id=<?= $product_id; ?>','review','width=420,height=460,scrollbars=yes,menubar=no,statusbar=no,toolbar=no'));" class="small"><?= $copyArr[ "equiv" ]; ?></a></td>
		                      </tr>
		                <?	}	?>
	                    </table>
		                </td>
		              </tr>
								</table><br>
								
 
		            <p>&nbsp;</p>
						<?	$familyResult = $db->query( "select name, description from products_family where family_id = '$familyId'" );
								if( $db->numRows( $familyResult ) ) {
									list( $familyName, $familyDescription ) = $db->fetchRow( $familyResult );
									$familyName = prepStr( $familyName );
								}	?>

		            <p><span class="subhead2"><?= prepStr( $copyArr[ "more_products" ] ); ?></span></p>
		            <table width="100%" border="0" cellspacing="0" cellpadding="0">

							<?	$rowCount = 1;
									$pageResult = $db->query( "select products.product_id, products.name, products.thumb_image, products_family.name ".
									                          "  from products, products_family ".
									                          " where products.family_id   = '$familyId' ".
									                          "   and products.family_id   = products_family.family_id ".
									                          "   and products.product_id <> '$product_id' ".
									                          "   and products.live      = 'Y'" );
									if( $db->numRows( $pageResult ) ) {
										while( list( $productId, $name, $thumbImage, $familyName ) = $db->fetchRow( $pageResult ) ) {
											$pIdName = str_replace( " ", "%20", $familyName );
											$pIdName = str_replace( "&", urlencode( "&" ), $pIdName );

											echo( $rowCount == 1 ? "<tr>" : "" );	?>
			                <td align="center" valign="top" width="118"> 
			                  	<a href="products_details.php?product_id=<?= $productId; ?><?= ($page ? "&page=$page" : "") . ($pId && !$pIdName ? "&pId=$pId" : "") . ($pIdName ? "&pIdName=$pIdName" : ""); ?>"><img src="<?= $thumbImage; ?>" width="110" height="110" alt="<?= $name; ?>" border="0" /></a><br />
			                    <a href="products_details.php?product_id=<?= $productId; ?><?= ($page ? "&page=$page" : "") . ($pId && !$pIdName ? "&pId=$pId" : "") . ($pIdName ? "&pIdName=$pIdName" : ""); ?>" class="small"><?= prepStr( $name ); ?></a>
			                </td>
				         	<?	if( $rowCount == 4 ) {
				         				echo( "</tr>" );
				         				$rowCount = 1;
				         			} else {
				         				$rowCount++;
				         			}
				         		}
				         	}	?>

							<?	for( $i = $rowCount; $i <= 4; $i++ ) {	?>
			              <td align="center" valign="top" width="118">&nbsp; </td>
		          <?	}	?>	              
		            </table>
		            <p>&nbsp;</p>
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
