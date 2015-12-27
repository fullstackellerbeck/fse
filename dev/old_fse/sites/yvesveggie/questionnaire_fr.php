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
<?	if( $closeWin ) {	?>
			<script language="javascript">
				this.window.close();
			</script>
<?	}	?>
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
		            <form name="bunny" action="questionnaire_fr.php" method="post">
				<?	if( $continue ) {	?>
	            <h1><img src="images/titres/thankyou.gif" width="161" height="48" alt="Merci" /></h1>
							<p>Merci d'avoir pris le temps de répondre à nos questions. Nous apprécions vos commentaires.</p>
							
							<p class="small" align="right"> <a href="#" onclick="window.close();"><img src="<?= $buttonArr[ "close_window" ][ 0 ]; ?>" width="<?= $buttonArr[ "close_window" ][ 1 ]; ?>" height="<?= $buttonArr[ "close_window" ][ 2 ]; ?>" border="0" alt="close window" /></a> </p>
				<?	}	else { 	?>
		            <form name="bunny" action="questionnaire_en.php" method="post">
		            	<input type="hidden" name="continue" value="true">
			            <h1><img src="images/titres/questionnaire.gif" width="200" height="55" alt="Questionnaire" /></h1>

							<?	if( $errMsg ) {	?>
										<p><span class="error"><?= $errMsg; ?></span></p>
							<?	}	?>
			            <p>Chez Yves Veggie Cuisine, nous avons toujours apprécié l’opinion de nos clients. Apprendre à les connaître – ce qu'ils aiment et n'aiment pas – est pour nous le meilleur moyen de découvrir comment améliorer nos produits. Dites-nous ce que vous pensez en répondant aux questions suivantes.</p>

									<table border="0" cellspacing="0" cellpadding="0">
									<tr><td>
									<b>De quel sexe êtes-vous?</b>
									<blockquote>
									<input type="radio" name="gender" value="M" id="male"><label for="male">Masculin</label><br />
									<input type="radio" name="gender" value="F" id="female"><label for="female">Féminin</label><br />
									</blockquote>
									</td></tr>
									
									<tr><td><img src="images/universal/spacer.gif" width="1" height="15" alt="" /></td></tr>
									
									<tr><td>
									<b>Quel âge avez-vous?</b>
									<blockquote>
									<select name="age" style="width: 140px;">
									<option value=""></option>
									<option value="under 18">moins de 18 ans</option>
									<option value="18-24">18-24 ans</option>
									<option value="25-34">25-34 ans</option>
									<option value="35-50">35-50 ans</option>
									<option value="over 50">plus de 50 ans</option>
									</select>
									</blockquote>
									</td></tr>
									
									<tr><td><img src="images/universal/spacer.gif" width="1" height="15" alt="" /></td></tr>										
									<tr><td>
									<b>Laquelle des catégories suivantes définit le mieux votre régime?</b>
									<blockquote>
									<select name="diet_type" style="width: 150px;">
									<option value=""></option>
									<option value="Vegetarian">Végétarien</option>
									<option value="Ovo-lacto vegetarian">Ovo-lacto végétarien</option>
									<option value="Vegan">Végétalien</option>
									<option value="Non-vegetarian">Non végétarien</option>
									</select>
									</blockquote>
									</td></tr>
									
									<tr><td><img src="images/universal/spacer.gif" width="1" height="15" alt="" /></td></tr>										
									<tr><td>
									<b>Pourquoi achetez-vous les produits Yves Veggie Cuisine?</b>
									<blockquote>
									<select name="why_buy" style="width: 180px;">
									<option value=""></option>
									<option value="Health reasons / benefits">Problèmes de santé / Bienfaits pour la santé</option>
									<option value="Taste">Goût</option>
									<option value="Religious beliefs">Croyances religieuses</option>
									<option value="Environmental concerns">Préoccupations écologiques</option>
									<option value="Other">Autre</option>
									</select>
									</blockquote>
									</td></tr>
									
									<tr><td><img src="images/universal/spacer.gif" width="1" height="15" alt="" /></td></tr>										
									<tr><td>
									<b>Quel membre de votre famille est le principal consommateur de produits Yves Veggie Cuisine?</b>
									<blockquote>
									<select name="prime_consumer" style="width: 160px;">
									<option value=""></option>
									<option value="Female adult">Femme adulte</option>
									<option value="Male adult">Homme adulte</option>
									<option value="Children">Enfants</option>
									</select>
									</blockquote>
									</td></tr>
									
									<tr><td><img src="images/universal/spacer.gif" width="1" height="15" alt="" /></td></tr>										
									<tr><td>
									<b>A quelle fréquence achetez-vous les produits d'Yves?</b>
									<blockquote>
									<select name="buy_frequency">
									<option value=""></option>
									<option value="Several times a week">Plusieurs fois par semaine</option>
									<option value="Several times a month">Plusieurs fois par mois</option>
									<option value="Once a week">Une fois par semaine</option>
									<option value="Once a month">Une fois par mois</option>
									<option value="Rarely">Rarement</option>
									</select>
									</blockquote>
									</td></tr>
									
									<tr><td><img src="images/universal/spacer.gif" width="1" height="15" alt="" /></td></tr>										
									<tr><td>
									<b>Veuillez indiquer les produits d'Yves que vous achetez au moins une fois par mois (ou plus). Cochez tout produit qui s'applique.</b>
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
									<b>En moyenne, combien de paquets de produits d'Yves achetez-vous à la fois?</b>
									<blockquote>
									<select name="total_qty">
									<option value=""></option>
									<option value="1">1</option>
									<option value="2-4">2-4</option>
									<option value="5-8">5-8</option>
									<option value="more than 8">Plus de 8</option>
									</select>
									</blockquote>
									</td></tr>
									
									<tr><td><img src="images/universal/spacer.gif" width="1" height="15" alt="" /></td></tr>										
									<tr><td>
									<b>Depuis quand achetez-vous les produits d'Yves?</b>
									<blockquote>
									<select name="consumer_length">
									<option value=""></option>
									<option value="less than 1 year">Moins d'un an</option>
									<option value="1-5 years">1-5 ans</option>
									<option value="more than 5 years">Plus de 5 ans</option>
									</select>
									</blockquote>
									</td></tr>
									
									<tr><td><img src="images/universal/spacer.gif" width="1" height="25" alt="" /></td></tr>										
									<tr><td>
									<b>En quoi les produits d'Yves vous plaisent / déplaisent-ils?</b>
									<blockquote><textarea name="comments" rows="6" cols="50" style="width: 280px; height: 150px;"></textarea><blockquote>
									</td></tr>
									<tr><td><img src="images/universal/spacer.gif" width="1" height="15" alt="" /></td></tr>
									
									<tr><td>
									<b>Accepteriez-vous de participer à un jury de dégustation 4 fois par année?</b>
									<blockquote>
									<input type="radio" name="taste_panel" value="Y" id="yes"><label for="yes">Yes</label><br />
									<input type="radio" name="taste_panel" value="N" id="no"><label for="no">No</label><br />
									</blockquote>
									</td></tr>
									
									<tr><td><img src="images/universal/spacer.gif" width="1" height="15" alt="" /></td></tr>										
									<tr><td>
									<b>Adresse électronique</b>
									<blockquote><input type="input" name="email" class="textbox" style="width: 280px;"><blockquote>
									</td></tr>
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
