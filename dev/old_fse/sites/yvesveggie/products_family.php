<?	include( "inc/init.php" );

		if( !session_is_registered( "sess_country_id" ) || !session_is_registered( "sess_language_id" ) ) {
			header( "Location: splash.php?referer=$scriptName" );
		}

		$familyResult = $db->query( "select name, description, shot_id ".
                                "  from products_family ".
                                " where family_id   = '$family_id'".
			                          "   and country_id  = '$sess_country_id' ".
			                          "   and language_id = '$sess_language_id'" );
		if( $db->numRows( $familyResult ) ) {
			list( $familyName, $familyDescription, $familyShotId ) = $db->fetchRow( $familyResult );
			
			$shotResult = $db->query( "select name, file_name ".
			                          "  from beauty_shots ".
			                          " where shot_id = '$familyShotId'" );
			if( $db->numRows( $shotResult ) ) {
				list( $shotName, $shotFileName ) = $db->fetchRow( $shotResult );
			}			
		}	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie Cuisine - <?= prepStr( $familyName ); ?></title>

		<script language="javascript" src="js/browser_sniff.js"></script>
		
		<script language="Javascript" src="js/nav.php"></script>
		<script language="Javascript" src="js/init.php"></script>
		<script language="Javascript" src="js/resize.js"></script>

		<link rel="stylesheet" type="text/css" href="css/styles.css" />
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
		          <td valign="top"><div name="navLocation" id="navLocation"></div><img src="images/universal/spacer.gif" width="245" height="469" name="navImg" id="navImg"/></td>
		          <td valign="top" align="left"><h1><?= $familyName; ?></h1>
		            <p><?= nl2br( prepStr( $familyDescription ) ); ?></p>
		            <table width="100%" border="0" cellspacing="0" cellpadding="0">

							<?	$rowCount = 1;
									$pageResult = $db->query( "select products.product_id, products.name, products.thumb_image, products_family.name ".
									                          "  from products, products_family ".
									                          " where products.family_id   = '$family_id' ".
									                          "   and products.family_id   = products_family.family_id ".
									                          "   and products.live        = 'Y'".
									                          " order by products.priority" );
									if( $db->numRows( $pageResult ) ) {
										while( list( $productId, $name, $thumbImage, $familyName ) = $db->fetchRow( $pageResult ) ) {
											$pIdName = str_replace( " ", "%20", $familyName );
											$pIdName = str_replace( "&", urlencode( "&" ), $pIdName );

											echo( $rowCount == 1 ? "<tr>" : "" );	?>
			                <td align="center" valign="top" width="118"> 
			                  	<a href="products_details.php?product_id=<?= $productId; ?><?= ($page ? "&page=$page" : "") . ($pId ? "&pId=$pId" : "") . ($pIdName ? "&pIdName=$pIdName" : ""); ?>"><img src="<?= $thumbImage; ?>" width="110" height="110" alt="<?= $name; ?>" border="0" /></a><br />
			                    <a href="products_details.php?product_id=<?= $productId; ?><?= ($page ? "&page=$page" : "") . ($pId ? "&pId=$pId" : "") . ($pIdName ? "&pIdName=$pIdName" : ""); ?>" class="small"><?= strtr( stripslashes( $name ), $trans ); ?></a>
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
		          		</tr>		              
		            </table>
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
