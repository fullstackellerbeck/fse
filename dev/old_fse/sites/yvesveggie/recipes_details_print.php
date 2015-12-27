<?	include( "inc/init.php" );

		$productResult = $db->query( "select family_id, name, image, serving_size, per_pack, description, ingredients ".
	                               "  from products ".
	                               " where product_id = '$product_id' ".
	                               "   and live       = 'Y'" );
	   
	   if( $db->numRows( $productResult ) ) {
	   	list( $familyId, $name, $image, $servingSize, $perPack, $description, $ingredients ) = $db->fetchRow( $productResult );
	   }
	   
	 	$recipeResult = $db->query( "select name, directions, servings from recipes where recipe_id = '$recipe_id'" );

		if( $db->numRows( $recipeResult ) ) {
			list( $recipeName, $recipeDirections, $recipeServings ) = $db->fetchRow( $recipeResult );
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
		            <h3 style="margin: 0px; padding: 0px;"><?= $recipeName; ?></h3>
		            <span class="small"><?= $recipeServings; ?></span>
		            <p><?= $recipeDescription; ?></p>
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
		            
		            <br />
		            <table border="0" cellspacing="0" cellpadding="0">
		            	<tr><td><p style="padding: 5px 5px 5px 0px;"><?= nl2br( prepStr( $recipeDirections ) ); ?></p></td></tr>
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
										<td><img src="images/universal/spacer.gif" width="40" height="1" border="0"></td>
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
			    </td></tr>
			    </table>
				</td>
				<td><img src="images/universal/spacer.gif" width="8" height="1" /></td>
			</tr>
			<tr><td colspan="3"><img src="images/universal/spacer.gif" width="1" height="16" /></td></tr>
		</table>
	</body>
</html>
