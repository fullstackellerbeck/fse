<?	include( "inc/init.php" );
		
		if( $continue ) {
			$result = $db->query( "delete from recipes_ingredients where ingredient_id = '$ingredient_id'" );
		
			header( "Location: recipes_ingredients_iframe.php?recipe_id=$recipe_id" );
		}		
		// location.href = scriptName + '?delTable=' + tableName + '&idColumn=' + idName + '&idNum=' + itemId + (additional ? additional : '');
?>
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
			$displayResult = $db->query( "select recipe_id, name, product_id, quantity from recipes_ingredients where ingredient_id = '$ingredient_id'" );
			if( $db->numRows( $displayResult ) ) {
				list( $recipeId, $name, $dbProductId, $quantity ) = $db->fetchRow( $displayResult );
			}
		}	?>
		
		<form name="bunny" action="recipes_ingredients_delete_iframe.php" method="post">
			<input type="hidden" name="recipe_id" value="<?= $recipe_id; ?>">
			<input type="hidden" name="ingredient_id" value="<?= $ingredient_id; ?>">
			<input type="hidden" name="country_id" value="<?= $country_id; ?>">
			<input type="hidden" name="language_id" value="<?= $language_id; ?>">
		
			<div style="width: 445px; margin: 0px 0px 0px 10px; background-color: transparent;">
				<div style="text-align: center;">
				<p style="margin: 0px; padding:  0px 0px 10px 0px;"><span class="title">Are you sure you want to delete this item?</span></p>
				
				<input type="button" name="cancel" value="Cancel" onclick="location.href='recipes_ingredients_iframe.php?recipe_id=<?= $recipeId; ?>';">&nbsp&nbsp;
				<input type="submit" name="continue" value="Continue">
				</div>
			</div>
		</form>							
	</body>
</html>
