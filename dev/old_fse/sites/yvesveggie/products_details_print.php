<?	include( "inc/init.php" );

		$productResult = $db->query( "select family_id, name, image, serving_size, per_pack, description, ingredients ".
	                               "  from products ".
	                               " where product_id = '$product_id' ".
	                               "   and live       = 'Y'" );
	   
	   if( $db->numRows( $productResult ) ) {
	   	list( $familyId, $name, $image, $servingSize, $perPack, $description, $ingredients ) = $db->fetchRow( $productResult );
	   }	?>										     	
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie Cuisine - <?= prepStr( $name ); ?></title>

		<link rel="stylesheet" type="text/css" href="css/print.css" />
	</head>
	
	<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="window.print();">
		<table border="0" cellspacing="0" cellpadding="0">
			<tr><td colspan="3"><img src="images/universal/spacer.gif" width="1" height="16" /></td></tr>
			<tr>
				<td><img src="images/universal/spacer.gif" width="8" height="1" /></td>
				<td>
			    <table width="100%" border="0" cellspacing="0" cellpadding="0">
			      <tr> 
			        <td align="left" valign="top" width="409">
		                    <h1><?= prepStr( $name ); ?></h1>
		                    <p><img src="<?= $image; ?>" width="163" height="163" alt="<?= $name; ?>" border="0" align="right" /><?= nl2br( prepStr( $description ) ); ?></p>
		                    <p><span class="subhead"><?= prepStr( $copyArr[ "ingredients" ] ); ?></span><br />
		                    <span class="small"><?= nl2br( prepStr( $ingredients ) ); ?></span></p><br>
			          
			        </td>
			      </tr>
			    </table>
			    
			    
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr><td align="center">
			    <table width="304" border="0" cellspacing="0" cellpadding="0">
			    	<tr><td colspan="4" align="left"><span class="subhead"><?= prepStr( $copyArr[ "nutri_info" ] ); ?></span><br /></td></tr>
			      <tr valign="middle"> 
			        <td bgcolor="#FEECC8" class="small"><img src="images/universal/spacer.gif" width="4" height="1" /></td>
			        <td bgcolor="#FEECC8" class="small"><img src="images/universal/spacer.gif" width="160" height="1" /></td>
			        <td bgcolor="#FEECC8" class="small"><img src="images/universal/spacer.gif" width="60" height="1" /></td>
			        <td bgcolor="#FEECC8" class="small"><img src="images/universal/spacer.gif" width="60" height="1" /></td>
			      </tr>
			      <tr valign="middle"> 
			        <td bgcolor="#FEECC8" class="small" align="left"><img src="images/universal/spacer.gif" width="4" height="1" /></td>
			        <td colspan="3" bgcolor="#FEECC8" class="small" align="left"><strong><?= strtr( stripslashes( $name ), $trans ); ?>: <?= prepStr( $copyArr[ "nutri_info" ] ); ?></strong></td>
			      </tr>
			      <tr valign="middle"><td colspan="4" class="small"><strong>&nbsp;</strong></td></tr>
			      <tr valign="middle"> 
			        <td bgcolor="#FEECC8" class="small">&nbsp;</td>
			        <td colspan="3" bgcolor="#FEECC8" class="small" align="left"><strong><?= prepStr( $copyArr[ "serving_size" ] ); ?> <?= $servingSize; ?> </strong></td>
			      </tr>
			      <tr valign="middle"> 
			        <td class="small">&nbsp;</td>
			        <td colspan="3" class="small" align="left"><strong><?= prepStr( $copyArr[ "servings_per" ] ); ?> <?= $perPack; ?></strong></td>
			      </tr>
			      <tr valign="middle"><td bgcolor="#FEECC8" colspan="4" class="small"><strong>&nbsp;</strong></td></tr>
			      <tr> 
			        <td class="small" valign="middle">&nbsp;</td>
			        <td class="small" colspan="2" valign="middle" align="left"><?= prepStr( $copyArr[ "amount_per" ] ); ?></td>
			        <td valign="middle" class="small" align="left">&nbsp;</td>
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
			    </td></tr>
			    </table>
				</td>
				<td><img src="images/universal/spacer.gif" width="8" height="1" /></td>
			</tr>
			<tr><td colspan="3"><img src="images/universal/spacer.gif" width="1" height="16" /></td></tr>
		</table>
	</body>
</html>
