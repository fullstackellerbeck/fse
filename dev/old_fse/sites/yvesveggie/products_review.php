<?	include( "inc/init.php" );

		if( !session_is_registered( "sess_country_id" ) || !session_is_registered( "sess_language_id" ) ) {
			header( "Location: splash.php?referer=$scriptName" );
		}
				
		$pageResult = $db->query( "select pages.name, pages_content.page_title, pages_content.title_image, pages_content.content, pages_content.extra_content, pages_content.auto_html ".
		                          "  from pages, pages_content ".
		                          " where pages.file_name = '$scriptName' ".
		                          "   and pages.page_id   = pages_content.page_id ".
		                          "   and pages_content.country_id  = '$sess_country_id' ".
		                          "   and pages_content.language_id = '$sess_language_id' " );
		
		if( $db->numRows( $pageResult ) ) {
			list( $pageName, $pageTitle, $titleImage, $content, $extraContent, $autoHTML ) = $db->fetchRow( $pageResult );
			
			if( $titleImage && file_exists( realpath( $titleImage ) ) ) {
				list( $width, $height, $type, $htmlWh ) = getimagesize( realpath( $titleImage ) );
			}
		}

		$errMsg = false;

		if( $continue ) {
			$errMsg .= ( !$product_id ? prepStr( $copyArr[ "review_err_prod" ] ) . "<br>" : "" );
			$errMsg .= ( !$review ? prepStr( $copyArr[ "review_err_review" ] ) . "<br>" : "" );
			$errMsg .= ( !$first_name || !$last_name ? prepStr( $copyArr[ "review_err_flname" ] ) . "<br>" : "" );
			
			if( !$errMsg ) {
				$pageQuery = $db->createInsert( array( "product_id"    => "'$product_id'",
		                                           "first_name"    => "'$first_name'",
																							 "last_name"     => "'$last_name'",
																							 "email"         => "'$email'",
																							 "review"        => "'$review'",
																							 "date_modified" => "now()" ),
																							 array( "review_id", $review_id ),
																							 "products_review" );
		
				$pageResult = $db->query( $pageQuery );
				$closeWin = true;
			}
		}		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie Cuisine - <?= prepStr( $pageTitle ); ?></title>
				
		<link rel="stylesheet" type="text/css" href="css/navpopups.css" />		
		<style type="text/css" media="all">@import url( css/iepopups.css );</style> 
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
		            <form name="bunny" action="products_review.php" method="post">
		            	<input type="hidden" name="continue" value="true">
		              <br />
		              <h3><?= prepStr( $pageTitle ); ?></h3>
							<?	if( $closeWin ) {	?>
									<p><?= prepStr( $copyArr[ "contact_success" ] ); ?></p>
			            <p class="small" align="right"> <a href="#" onclick="window.close();"><img src="<?= $buttonArr[ "close_window" ][ 0 ]; ?>" width="<?= $buttonArr[ "close_window" ][ 1 ]; ?>" height="<?= $buttonArr[ "close_window" ][ 2 ]; ?>" border="0" /></a> </p>
							<?	} else {	?>
		              <table width="100%" border="0" cellspacing="0" cellpadding="0">
		                <tr> 
		                  <td align="left" valign="top"> 
										
										<?	if( !$errMsg ) {	?>
			                    <p><?= ( $autoHTML == "Y" ? nl2br( prepStr( $content ) ) : prepStr( $content ) );	?></p>
		                <?	} elseif( $errMsg ) {	?>
		                			<p><span class="error"><?= $errMsg; ?></span></p>
		                <?	}	?>
		                
		                    <p><span class="small"><?= prepStr( $copyArr[ "review_product" ] ); ?></span><br />

					                <select name="product_id" style="width: 297px;">
				                    <option value=""><?= prepStr( $copyArr[ "review_prod_list" ] ); ?></option>
			
												<?	$productResult = $db->query( "select products.product_id, products.name ".
												                                 "  from products, products_family ".
												                                 " where products_family.country_id  = '$sess_country_id' ".
												                                 "   and products_family.language_id = '$sess_language_id' ".
												                                 "   and products.family_id          = products_family.family_id" );
										    					    
												    if( $db->numRows( $productResult ) ) {
										    			while( list( $productId, $productName ) = $db->fetchRow( $productResult ) ) {	?>							
							                  <option value="<?= $productId; ?>"<?= $productId == $product_id ? " selected" : ""; ?>><?= strtr( stripslashes( $productName ), $trans ); ?></option>
							             <?	}
							            	}	?>
					                </select>

		                      <br />
		                      <br />
		                      <span class="small"><?= prepStr( $copyArr[ "review_review" ] ); ?></span><br />
		                      <textarea name="review" rows="10" cols="30" style="width: 290px;" class="textbox"><?= $review; ?></textarea>
		                    </p>
		                    <h4><?= prepStr( $copyArr[ "review_reviewer" ] ); ?></h4>
		                    <p><span class="small"><?= prepStr( $copyArr[ "first_name" ] ); ?></span><br>
		                      <input type="text" name="first_name" size="35" style="width: 290px;" value="<?= $first_name; ?>" class="textbox" />
		                      <br />
		                      <br />
		                      <span class="small"><?= prepStr( $copyArr[ "last_name" ] ); ?></span><br>
		                      <input type="text" name="last_name" style="width: 290px;" value="<?= $last_name; ?>" class="textbox" size="35" />
		                      <br />
		                      <span class="small"><br />
		                      <?= prepStr( $copyArr[ "email" ] ); ?></span><br />
		                      <input type="text" name="email" style="width: 290px;" value="<?= $email; ?>" class="textbox" size="35" />
		                    </p>
		                    <p class="small"><?= ( $autoHTML == "Y" ? nl2br( prepStr( $extraContent ) ) : prepStr( $extraContent ) );	?></p>
		                    <p><a href="javascript:document.bunny.submit();"><img src="<?= $buttonArr[ "send" ][ 0 ]; ?>" width="<?= $buttonArr[ "send" ][ 1 ]; ?>" height="<?= $buttonArr[ "send" ][ 2 ]; ?>" alt="send" border="0" /></a></p>
		                  </td>
		                </tr>
		              </table>
							<?	}	?>
		              <p>&nbsp;</p>
		            </form>
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
