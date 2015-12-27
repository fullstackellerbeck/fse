<?	include( "inc/init.php" );

		if( !session_is_registered( "sess_country_id" ) || !session_is_registered( "sess_language_id" ) ) {
			header( "Location: splash.php?referer=$scriptName" );
		}	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie Cuisine - Compare</title>

		<link rel="stylesheet" href="css/popups.css" type="text/css">
	</head>
	
	<body bgcolor="#CC3333" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td align="center">
		      <table width="380" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
		        <tr><td background="images/universal/wheat.gif" colspan="3"><img src="images/universal/spacer.gif" width="1" height="9" alt="" /></td></tr>
		        <tr> 
		          <td rowspan="2"><img src="images/universal/spacer.gif" width="10" height="1" alt="" /></td>
		          <td><img src="images/universal/spacer.gif" width="360" height="1" alt="" /></td>
		          <td rowspan="2"><img src="images/universal/spacer.gif" width="10" height="1" alt="" /></td>
		        </tr>
		        <tr> 
		          <td valign="top" align="left"> 
	              <br />
	              <h3><?= prepStr( $copyArr[ "compare_title" ] ); ?></h3>
		              
		            <table width="100%" border="0" cellspacing="0" cellpadding="3">
		              <tr bgcolor="#FEECC8"> 
		                <td width="40%">&nbsp;</td>
		                <td align="center" valign="bottom" width="4%">&nbsp;</td>
		                <td align="left" valign="bottom" width="28%"><p class="subhead"><?= prepStr( $copyArr[ "compare_yves" ] ); ?></p></td>
		                <td align="left" valign="bottom" width="28%"><p class="subhead"><?= prepStr( $copyArr[ "compare_meat" ] ); ?></p></td>
		              </tr>
				
							<?	$productResult = $db->query( "select products.name, products_compare.other_name, products_compare.compare_id ".
							                                 "  from products, products_compare ".
							                                 " where products_compare.product_id  = '$product_id' ".
							                                 "   and products.product_id          = products_compare.product_id ".
							                                 "   and products_compare.live        = 'Y' ".
							                                 "   and products.live                = 'Y'" );
							    if( $db->numRows( $productResult ) ) {
							    	list( $productName, $otherProductName, $compareId ) = $db->fetchRow( $productResult );	?>							    	
	              
			              <tr> 
			                <td class="small" width="40%">&nbsp;</td>
			                <td align="left" class="small" valign="bottom" width="4%">&nbsp;</td>
			                <td align="left" class="small" valign="bottom" width="28%"><strong><?= prepStr( $productName ); ?></strong></td>
			                <td align="left" class="small" valign="bottom" width="28%"><strong><?= prepStr( $otherProductName ); ?></strong></td>
			              </tr>
			              
			          <?	$query = "select nutritional_compare_attribs.attribute_id, nutritional_compare_attribs.name, nutritional_compare_attribs.units, products_compare_attribs.yves_value, products_compare_attribs.other_value ".
                             "  from products_compare_attribs, nutritional_compare_attribs ".
                             " where products_compare_attribs.compare_id   = '$compareId' ".
                             "   and products_compare_attribs.attribute_id = nutritional_compare_attribs.attribute_id".
                             "   and nutritional_compare_attribs.p_attribute_id = '0' " .
                             " order by nutritional_compare_attribs.priority asc";
			              
			          		$attribsResult = $db->query( $query );
			              $bgColor = false;
			              
			              if( $db->numRows( $attribsResult ) ) {
			              	while( list( $attribId, $attribName, $attribUnit, $yvesValue, $otherValue ) = $db->fetchRow( $attribsResult ) ) {	?>
					              <tr bgcolor="<?= $bgColor ? "#FEECC8" : "#FFFFFF"; ?>"> 
					                <td valign="top" class="small" width="40%"><strong><?= prepStr( $attribName ); ?><?= $attribUnit ? " ($attribUnit)" : ""; ?><br></strong></td>
					                <td align="left" valign="top" class="small" width="4%">&nbsp;</td>
					                <td align="left" valign="top" class="small" width="28%"><?= $yvesValue; ?><br></td>
					                <td align="left" valign="top" class="small" width="28%"><?= $otherValue; ?></td>
					              </tr>

					          <?	$childQuery = "select nutritional_compare_attribs.name, nutritional_compare_attribs.units, products_compare_attribs.yves_value, products_compare_attribs.other_value ".
		                           			  "  from products_compare_attribs, nutritional_compare_attribs ".
		                      			      " where products_compare_attribs.compare_id   = '$compareId' ".
		                            			"   and products_compare_attribs.attribute_id = nutritional_compare_attribs.attribute_id".
		                            			"   and nutritional_compare_attribs.p_attribute_id = '$attribId' " .
		                            			" order by nutritional_compare_attribs.priority asc";
					              
					          		$attribsChildResult = $db->query( $childQuery );
					              
					              if( $db->numRows( $attribsChildResult ) ) {
					              	while( list( $attribChildName, $attribChildUnit, $yvesChildValue, $otherChildValue ) = $db->fetchRow( $attribsChildResult ) ) {	?>
							              <tr bgcolor="<?= $bgColor ? "#FEECC8" : "#FFFFFF"; ?>"> 
							                <td valign="top" class="small" style="font-size: 10px;" width="40%">&nbsp&nbsp&nbsp;<strong><span style="font-size: 10px;"><?= prepStr( $attribChildName ); ?><?= $attribChildUnit ? " ($attribChildUnit)" : ""; ?></span><br></strong></td>
							                <td align="left" valign="top" class="small" width="4%">&nbsp;</td>
							                <td align="left" valign="top" class="small" width="28%"><?= $yvesValue; ?><br></td>
							                <td align="left" valign="top" class="small" width="28%"><?= $otherValue; ?></td>
							              </tr>
											<?	}
												}

												$bgColor = !$bgColor;
											}
										}
									}	?>
		            </table>
		            
		            <p class="small">&nbsp;</p>  
		            <p class="small" align="right"> <a href="javascript:window.close();"><img src="<?= $buttonArr[ "close_window" ][ 0 ]; ?>" width="<?= $buttonArr[ "close_window" ][ 1 ]; ?>" height="<?= $buttonArr[ "close_window" ][ 2 ]; ?>" border="0" /></a> </p>
		          </td>
		        </tr>
		        <tr><td valign="top" background="images/universal/gradient.gif" colspan="3"><img src="images/universal/spacer.gif" width="1" height="36" alt="" /></td></tr>
		        <tr><td background="images/universal/wheat.gif" colspan="3"><img src="images/universal/spacer.gif" width="1" height="9" alt="" /></td></tr>
		      </table>  
		      <table width="380" border="0" cellspacing="0" cellpadding="0">
		        <tr> 
		          <td align="left"><div class="footer"><a href="http://www.hain-celestial.com">A Division of Hain Celestial Group, Inc. </a></div></td>
		          <td align="right"><div class="footer"><a href="terms.php">Privacy / Legal</a></div></td>
		        </tr>
		      	<tr><td colspan="2" align="center"><div class="smallfooter" style="padding-bottom: 10px;">Design by <a href="http://www.raisedeyebrow.com/" target="_blank">Raised Eyebrow Web Studio</a>, development by <a href="http://www.igivegoodweb.com/" target="_blank">I Give Good Web</a>.</div></td></tr>
		      </table>
		    </td>
		  </tr>
		</table>
	</body>
</html>
