<?	include( "inc/init.php" );
		
		if( $continue ) {
			if( !$recipe_id && !$_SESSION[ "new_recipe_id" ] ) {
				$recipeInsertResult = $db->query( "insert into recipes ( name ) values ( '' )" );
				$recipe_id = $db->lastID();
				
				$_SESSION[ "new_recipe_id" ] = $recipe_id;				
			}

			$recipe_id = ( $_SESSION[ "new_recipe_id" ] ? $_SESSION[ "new_recipe_id" ] : $recipe_id );

			$pageQuery = $db->createInsert( array( "recipe_id"   => "'$recipe_id'",
																						 "name"        => "'$name'",
																						 "product_id"  => "'$productId'",
																						 "quantity"    => "'$quantity'",
																						 "priority"    => "'$priority'" ),
																						 array( "ingredient_id", $ingredient_id ),
																						 "recipes_ingredients" );
	
			$pageResult = $db->query( stripslashes( $pageQuery ) );

			header( "Location: recipes_ingredients_iframe.php?country_id=$country_id&language_id=$language_id&recipe_id=$recipe_id" );
		}	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie &#8212; Site Administration</title>

		<script language="javascript" src="js/functions.js"></script>
		<link rel="stylesheet" type="text/css" href="css/common.css">
	</head>
	
	<body style="width: 448px; background-color: #fcfcfc; margin-top: 5px;">
<?	if( $ingredient_id ) {
			$displayResult = $db->query( "select recipe_id, name, product_id, quantity, priority from recipes_ingredients where ingredient_id = '$ingredient_id'" );
			if( $db->numRows( $displayResult ) ) {
				list( $recipeId, $name, $dbProductId, $quantity, $priority ) = $db->fetchRow( $displayResult );			
			}
		}
		
		if( $recipe_id || $recipeId ) {
			$maxPri = $db->query( "select max( priority ) from recipes_ingredients where recipe_id = '" . ($recipe_id ? $recipe_id : $recipeId) . "'" );
			if( $maxPri && $db->numRows( $maxPri ) ) {

				list( $maximumPriority ) = $db->fetchRow( $maxPri );
				$maximumPriority += 10;
			}
			
			if( !$maximumPriority ) {
				$maximumPriority = 10;
			}
		}	?>		
		<form name="bunny" action="recipes_ingredients_edit_iframe.php" method="post">
			<input type="hidden" name="recipe_id" value="<?= $recipe_id; ?>">
			<input type="hidden" name="ingredient_id" value="<?= $ingredient_id; ?>">
			<input type="hidden" name="country_id" value="<?= $country_id; ?>">
			<input type="hidden" name="language_id" value="<?= $language_id; ?>">
		
			<div style="width: 445px; margin: 0px 0px 0px 10px; background-color: transparent;">
				<div class="left">
					<div class="left" style="width: 75%;">
						<div class="left" style="width: 25%;">Item</div>
						<div class="left" style="width: 60%;"><input type="text" name="name" class="admintext" value="<?= $name; ?>" style="width: 245px;" onchange="document.bunny.productId.selectedIndex = 0;"></div>
						<div class="spacer"></div>
					</div>

					<div class="left" style="width: 75%;">
						<div class="left" style="width: 25%;">Product</div>
						<div class="left" style="width: 60%;">
							<select name="productId" class="adminselect" style="width: 250px; font-size: 11px;" onchange="document.bunny.name.value='';">
								<option value="0"></option>
						<?	$productResult = $db->query( "select products.product_id, products.name ".
						                              "  from products, products_family ".
						                              " where products_family.country_id  = '$country_id' ".
						                              "   and products_family.language_id = '$language_id' ".
						                              "   and products.family_id = products_family.family_id " .
						                              " order by products.name" );
								if( $db->numRows( $productResult ) ) {
									while( list( $productId, $productName ) = $db->fetchRow( $productResult ) ) {	?>
									 <option value="<?= $productId; ?>"<?= ($productId == $dbProductId ? " selected" : ""); ?>><?= $productName; ?></option>
							<?	}
								}	?>
							</select>
						</div>
						<div class="spacer"></div>
					</div>

					<div class="left" style="width: 75%;">
						<div class="left" style="width: 25%;">Quantity</div>
						<div class="left" style="width: 60%;"><input type="text" name="quantity" class="admintext" value="<?= $quantity; ?>" style="width: 245px;"></div>
						<div class="spacer"></div>
					</div>
					<div class="left" style="width: 75%;">
						<div class="left" style="width: 25%;">Priority</div>
						<div class="left" style="width: 60%;"><input type="text" name="priority" class="admintext" value="<?= $priority ? $priority : $maximumPriority; ?>" style="width: 245px;"></div>
						<div class="spacer"></div>
					</div>
				</div>				
				<div class="right" style="width: 18%;">
					<input type="submit" name="continue" value="Continue" class="adminsubmit"><br>
					<input type="button" name="cancel" value="Cancel" class="adminbutton" onclick="location.href='recipes_ingredients_iframe.php?recipe_id=<?= $recipe_id; ?>&country_id=<?= $country_id; ?>&language_id=<?= $language_id; ?>&ingredient_id=<?= $ingredientId; ?>';">
				</div>
				<div class="spacer"></div>
			</div>
		</form>							
	</body>
</html>
