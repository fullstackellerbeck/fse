<?	include( "inc/init.php" );		?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie &#8212; Site Administration</title>

		<script language="javascript" src="js/functions.js"></script>
		<link rel="stylesheet" type="text/css" href="css/common.css">

		<script language="javascript">
			languageId = getParameter( window.location.search, 'language_id' );
			countryId = getParameter( window.location.search, 'country_id' );
			recipeId = getParameter( window.location.search, 'recipe_id' );
			
	<?	if( !$country_id && !$language_id ) { 	?>
				if( !languageId && !countryId ) {
					languageId = top.document.bunny.country_id.options[ top.document.bunny.country_id.selectedIndex ].value;
					countryId = top.document.bunny.language_id.options[ top.document.bunny.language_id.selectedIndex ].value;
					recipeId = top.document.bunny.recipe_id.value;
					
					location.href = 'recipes_ingredients_iframe.php?language_id=' + languageId + '&country_id=' + countryId + (recipeId ? '&recipe_id=' + recipeId : '');
				}
	<?	}	?>
		</script>
	</head>
	
	<body style="width: 448px; background-color: #f9f9f9; margin-top: 0px;">
		<div style="background-color: #ffffff; padding: 5px 10px 5px 10px; border: 1px solid #ccc; border-top: 0px; border-left: 0px; border-right: 0px;">							
			<a href="recipes_ingredients_edit_iframe.php?country_id=<?= $country_id; ?>&language_id=<?= $language_id; ?><?= $recipe_id ? "&recipe_id=$recipe_id" : "";?>" style="font-weight: bold;">Add a new ingredient</a>
		</div>
		
<?	if( $recipe_id ) {
			$bgColor = false;
			
			$ingredResult = $db->query( "select recipes_ingredients.ingredient_id, recipes_ingredients.name, recipes_ingredients.product_id, recipes_ingredients.quantity, recipes_ingredients.priority from recipes_ingredients, recipes where recipes_ingredients.recipe_id = '$recipe_id' and recipes_ingredients.recipe_id = recipes.recipe_id order by recipes_ingredients.priority asc" );
			echo( $db->errorMsg() );
			if( $db->numRows( $ingredResult ) ) {
				while( list( $ingredientId, $name, $dbProductId, $quantity, $priority ) = $db->fetchRow( $ingredResult ) ) {	?>
					<div style="background-color: <?= $bgColor ? "#faf7f2" : "#f2efe3"; ?>; padding: 2px 10px 2px 10px;" onmouseover="this.style.backgroundColor='#dddddd';" onmouseout="this.style.backgroundColor='<?= $bgColor ? "#faf7f2" : "#f2efe3"; ?>';">
						<div class="left" style="width: 58%;">
					<?	if( $dbProductId ) {
								$productResult = $db->query( "select products.product_id, products.name ".
							                               "  from products, products_family ".
							                               " where products.product_id = '$dbProductId' ".
							                               "   and products.family_id = products_family.family_id ".
							                               "   and products_family.language_id = '$language_id' ".
							                               "   and products_family.country_id  = '$country_id'" );
								if( $db->numRows( $productResult ) ) {
									list( $productId, $productName ) = $db->fetchRow( $productResult );							
									echo( "<i>$productName</i> (" . ($priority ? $priority : "0") . ")" );
								} else {
									echo( "<i>no product for this country / language</i>" );
								}
							} elseif( $name ) {
								echo( $name . " (" . ($priority ? $priority : "0") . ")" );
							}	?>
						</div>
						<div class="left" style="width: 20%;"><?= $quantity; ?></div>
						<div class="right" style="width: 20%; text-align: right;">
							<a href="recipes_ingredients_edit_iframe.php?recipe_id=<?= $recipe_id; ?>&country_id=<?= $country_id; ?>&language_id=<?= $language_id; ?>&ingredient_id=<?= $ingredientId; ?>">edit</a> &middot; 
							<a href="recipes_ingredients_delete_iframe.php?ingredient_id=<?= $ingredientId; ?>&country_id=<?= $country_id; ?>&language_id=<?= $language_id; ?>">delete</a></div> <!--  onclick="delItem('recipes_ingredients_iframe.php','<?= $ingredientId; ?>', 'recipes_ingredients','ingredient_id','&recipe_id=<?= $recipe_id; ?>&country_id=<?= $country_id; ?>&language_id=<?= $language_id; ?>&<?= SID; ?>');" -->
						<div class="spacer" style=" background-color: transparent;"></div>
					</div>
		<?		$bgColor = !$bgColor;
				}
			}
		}	?>		

		<script language="javascript">
			top.document.bunny.recipe_id.value = '<?= $recipe_id; ?>';
		</script>		
	</body>
</html>
