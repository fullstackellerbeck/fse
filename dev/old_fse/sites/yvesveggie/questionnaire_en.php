<?	include( "inc/init.php" );

		if( !session_is_registered( "sess_country_id" ) || !session_is_registered( "sess_language_id" ) ) {
			header( "Location: splash.php?referer=$scriptName" );
		}
				
		if( $continue ) {
			$errMsg = false;
			$tasteEmail  = ( $taste_panel == "yes" && !$email ? false : true );
			
			/*$errMsg = ( !$gender || !$age || !$diet_type || !$why_buy || !$prime_consumer || !$buy_frequency || !$products || !$total_qty || !$consumer_length || !$comments || !$tasteEmail ? "You must complete this form to continue.<br>" : false );
			
			if( $errMsg ) {
				unset( $continue );
			}
			
			if( !$errMsg ) { */

				if( $products ) {
					foreach( $products as $prodKey ) {
						if( $prodKey ) {
							$prodResult = $db->query( "select name from products where product_id = '$prodKey'" );
							if( $db->numRows( $prodResult ) ) {
								list( $name ) = $db->fetchRow( $prodResult );
								if( $prodNames ) {
									$prodNames .= ",$name";
								} else {
									$prodNames = $name;
								}
							}
						}
					}
				}
							
				$pageQuery = $db->createInsert( array( "gender"          => "$gender",
				                                       "age"             => "$age",
				                                       "diet_type"       => "$diet_type",
				                                       "why_buy"         => "$why_buy",
				                                       "prime_consumer"  => "$prime_consumer",
				                                       "buy_frequency"   => "$buy_frequency",
				                                       "products"        => addslashes( $prodNames ),
				                                       "total_qty"       => "$total_qty",
				                                       "consumer_length" => "$consumer_length",
				                                       "comments"        => addslashes( $comments ),
				                                       "taste_panel"     => "$taste_panel",
				                                       "email"           => "$email",
				                                       "country_id"      => "$sess_country_id",
				                                       "language_id"     => "$sess_language_id",
				                                       "date_posted"     => "now()" ),
																							 array( "quest_id", $quest_id ),
																							 "questionnaire" );
				
				$pageResult = $db->query( stripslashes( $pageQuery ) );
				//echo( $db->getlastQuery() );
				//echo( $db->errorMsg() );			
			//}
		}	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie Cuisine - <?= prepStr( $pageTitle ); ?></title>
				
		<link rel="stylesheet" type="text/css" href="css/popups.css" />
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
				<?	if( $continue ) {	?>
	            <h1><img src="images/titles/thankyou.gif" width="161" height="48" alt="Thank-you" /></h1>
							<p>Thank you for taking the time to answer our questions. We appreciate your feedback.</p>
							
							<p class="small" align="right"> <a href="#" onclick="window.close();"><img src="<?= $buttonArr[ "close_window" ][ 0 ]; ?>" width="<?= $buttonArr[ "close_window" ][ 1 ]; ?>" height="<?= $buttonArr[ "close_window" ][ 2 ]; ?>" border="0" alt="close window" /></a> </p>
				<?	}	else { 	?>
		            <form name="bunny" action="questionnaire_en.php" method="post">
		            	<input type="hidden" name="continue" value="true">
			            <h1><img src="images/titles/questionnaire.gif" width="200" height="55" alt="Questionnaire" /></h1>

							<?	if( $errMsg ) {	?>
										<p><span class="error"><?= $errMsg; ?></span></p>
							<?	}	?>

			            <p>At Yves Veggie Cuisine, we always appreciate customer feedback. Getting to know our customers - what they like, what they dislike - is the best way for us to find out how to improve our products. Let us know what you think by answering the questions below.</p>

									<table border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
									<tr><td>
									<b>What is your gender?</b>
									<blockquote>
									<input type="radio" name="gender" value="M" id="male" class="radio"><label for="male">Male</label><br />
									<input type="radio" name="gender" value="F" id="female" class="radio"><label for="female">Female</label><br />
									</blockquote>
									</td></tr>
									
									<tr><td><img src="images/universal/spacer.gif" width="1" height="15" alt="" /></td></tr>
									
									<tr><td>
									<b>How old are you?</b>
									<blockquote>
									<select name="age" style="width: 140px;">
									<option value=""></option>
									<option value="under 18">under 18</option>
									<option value="18-24">18-24</option>
									<option value="25-34">25-34</option>
									<option value="35-50">35-50</option>
									<option value="over 50">over 50</option>
									</select>
									</blockquote>
									</td></tr>
									
									<tr><td><img src="images/universal/spacer.gif" width="1" height="15" alt="" /></td></tr>										
									<tr><td>
									<b>Which of the following categories best describes your diet?</b>
									<blockquote>
									<select name="diet_type" style="width: 150px;">
									<option value=""></option>
									<option value="Vegetarian">Vegetarian</option>
									<option value="Ovo-lacto vegetarian">Ovo-lacto vegetarian</option>
									<option value="Vegan">Vegan</option>
									<option value="Non-vegetarian">Non-vegetarian</option>
									</select>
									</blockquote>
									</td></tr>
									
									<tr><td><img src="images/universal/spacer.gif" width="1" height="15" alt="" /></td></tr>										
									<tr><td>
									<b>Why do you buy Yves Veggie Cuisine products?</b>
									<blockquote>
									<select name="why_buy" style="width: 180px;">
									<option value=""></option>
									<option value="Health reasons / benefits">Health reasons / benefits</option>
									<option value="Taste">Taste</option>
									<option value="Religious beliefs">Religious beliefs</option>
									<option value="Environmental concerns">Environmental concerns</option>
									<option value="Other">Other</option>
									</select>
									</blockquote>
									</td></tr>
									
									<tr><td><img src="images/universal/spacer.gif" width="1" height="15" alt="" /></td></tr>										
									<tr><td>
									<b>Who is the primary consumer of Yves products in your household?</b>
									<blockquote>
									<select name="prime_consumer" style="width: 160px;">
									<option value=""></option>
									<option value="Female adult">Female adult</option>
									<option value="Male adult">Male adult</option>
									<option value="Children">Children</option>
									</select>
									</blockquote>
									</td></tr>
									
									<tr><td><img src="images/universal/spacer.gif" width="1" height="15" alt="" /></td></tr>										
									<tr><td>
									<b>How often do you buy Yves products?</b>
									<blockquote>
									<select name="buy_frequency">
									<option value=""></option>
									<option value="Several times a week">Several times a week</option>
									<option value="Several times a month">Several times a month</option>
									<option value="Once a week">Once a week</option>
									<option value="Once a month">Once a month</option>
									<option value="Rarely">Rarely</option>
									</select>
									</blockquote>
									</td></tr>
									
									<tr><td><img src="images/universal/spacer.gif" width="1" height="15" alt="" /></td></tr>										
									<tr><td>
									<b>Please indicate which Yves products you buy at least once a month (or more). Check off any that apply.</b><br>
									(to select more than one item press control (ctrl) and select all applicable items)
									<blockquote>
									<select name="products[]" size="10" multiple>
									<?	$productResult = $db->query( "select products.product_id, products.name ".
									                     "  from products, products_family ".
									                     " where products.family_id = products_family.family_id ".
									                     "   and products_family.country_id  = '$sess_country_id' ".
									                     "   and products_family.language_id = '$sess_language_id' " );
									
									if( $db->numRows( $productResult ) ) {
									while( list( $productId, $productName ) = $db->fetchRow( $productResult ) ) {	?>
									<option value="<?= $productId; ?>"><?= prepStr( $productName ); ?></option>
									<?	}
									}	?>
									</select>
									</blockquote>
									</td></tr>
									
									<tr><td><img src="images/universal/spacer.gif" width="1" height="15" alt="" /></td></tr>										
									<tr><td>
									<b>On average, how many packages of Yves products do you buy at one time?</b>
									<blockquote>
									<select name="total_qty">
									<option value=""></option>
									<option value="1">1</option>
									<option value="2-4">2-4</option>
									<option value="5-8">5-8</option>
									<option value="more than 8">more than 8</option>
									</select>
									</blockquote>
									</td></tr>
									
									<tr><td><img src="images/universal/spacer.gif" width="1" height="15" alt="" /></td></tr>										
									<tr><td>
									<b>How long have you been a consumer of Yves products?</b>
									<blockquote>
									<select name="consumer_length">
									<option value=""></option>
									<option value="less than 1 year">less than 1 year</option>
									<option value="1-5 years">1-5 years</option>
									<option value="more than 5 years">more than 5 years</option>
									</select>
									</blockquote>
									</td></tr>
									
									<tr><td><img src="images/universal/spacer.gif" width="1" height="25" alt="" /></td></tr>										
									<tr><td>
									<b>What do you like / dislike about Yves Veggie Cuisine products?</b>
									<blockquote><textarea name="comments" rows="6" cols="50" style="width: 280px; height: 150px;"></textarea><blockquote>
									</td></tr>
									<tr><td><img src="images/universal/spacer.gif" width="1" height="15" alt="" /></td></tr>
									
							<?	if( $sess_country_id == 1 ) {	?>
										<tr><td>
										<b>Would you be willing to participate in our taste panel 4 times per year?</b>
										<blockquote>
										<input type="radio" name="taste_panel" value="Y" id="yes"><label for="yes">Yes</label><br />
										<input type="radio" name="taste_panel" value="N" id="no"><label for="no">No</label><br />
										</blockquote>
										</td></tr>
										
										<tr><td><img src="images/universal/spacer.gif" width="1" height="15" alt="" /></td></tr>										
										<tr><td>
										<b>E-mail address</b>
										<blockquote><input type="input" name="email" class="textbox" style="width: 280px;"><blockquote>
										</td></tr>
							<?	}	?>

									<tr><td><img src="images/universal/spacer.gif" width="1" height="15" alt="" /></td></tr>
									</table>
							
									<a href="#" onclick="document.bunny.submit();"><img src="<?= $buttonArr[ "send" ][ 0 ]; ?>" width="<?= $buttonArr[ "send" ][ 1 ]; ?>" height="<?= $buttonArr[ "send" ][ 2 ]; ?>" border="0" alt="send" /></a>
		            </form>
		       <?	}	?>
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
