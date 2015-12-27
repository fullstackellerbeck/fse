<?	include( "inc/init.php" );

		if( !$recipe_id && $continue &&  !$_SESSION[ "new_recipe_id" ] ) {
			$recipeInsertResult = $db->query( "insert into recipes (name) values ('')" );
			
			$recipe_id = $db->lastID();
			$justAdded = true;
			$_SESSION[ "new_recipe_id" ] = $recipe_id;
		}
		
		if( ($recipe_id || $_SESSION[ "new_recipe_id" ] ) && $continue ) {
			$recipe_id = ( $_SESSION[ "new_recipe_id" ] ? $_SESSION[ "new_recipe_id" ] : $recipe_id );

			$nutRemoveResult = $db->query( "delete from recipes_nutritional where recipe_id='$recipe_id'" );
			
			for( $i = 0; $i < sizeof( $name ); $i++ ) {
				if( $name[ $i ] != "" ) {
					$nutInsertResult = $db->query( "insert into recipes_nutritional ".
					                               "          ( recipe_id, name, value ) ".
					                               "   values ( '$recipe_id', '" . $name[ $i ] . "', '" . $vvalue[ $i ] . "' )" );
				                               
				}
			}
		}	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie &#8212; Site Administration</title>
		<link rel="stylesheet" type="text/css" href="css/common.css">

<?	if( $justAdded ) {	?>
			<script language="javascript">
				top.document.bunny.recipe_id.value = '<?= $recipe_id; ?>';
			</script>
<?	}	?>
	</head>
	
	<body style="width: 448px; background-color: #f2efe3; margin-top: 0px;">
		<div style="height: 15px; border: 1px solid #ccc; margin-bottom: 1px; padding: 5px 0px 3px 0px; border-top: 0px; border-left: 0px; border-right: 0px; font-size: 9px;"><center><b>Please remember this information must be submitted seperately.</b></center></div>
		<form name="bunny" action="recipes_nutritional_iframe.php" method="post">
			<input type="hidden" name="continue" value="true">
			<input type="hidden" name="recipe_id" value="<?= $recipe_id; ?>">
			
	<?	$bgColor = false;
	
			$nutResult = $db->query( "select nutritional_id, name, value from recipes_nutritional where recipe_id = '$recipe_id' order by nutritional_id asc" );
			if( $db->numRows( $nutResult ) ) {
				while( list( $nutritionalId, $name, $value ) = $db->fetchRow( $nutResult ) ) {	?>
					<div style="background-color: <?= $bgColor ? "#faf7f2" : "#f2efe3"; ?>; padding: 1px 10px 1px 10px;" onmouseover="this.style.backgroundColor='#dddddd';" onmouseout="this.style.backgroundColor='<?= $bgColor ? "#faf7f2" : "#f2efe3"; ?>';">
						<div class="left" style="width: 270px;"><input type="text" name="name[]" class="admintext" style="width: 270px; background-color: #ffffff;" value="<?= $name; ?>"></div>
						<div class="left" style="width: 130px;" style="padding-left: 5px;"><input type="text" name="vvalue[]" class="admintext" style="width: 130px; background-color: #ffffff;" value="<?= $value; ?>"></div>
						<div class="spacer"></div>
					</div>
					<div class="spacer"></div>
		<?		$bgColor = !$bgColor;
				}
			}
			
			for( $ct = 0; $ct < 2; $ct++ ) {	?>
				<div style="background-color: <?= $bgColor ? "#faf7f2" : "#f2efe3"; ?>; padding: 1px 10px 1px 10px;" onmouseover="this.style.backgroundColor='#dddddd';" onmouseout="this.style.backgroundColor='<?= $bgColor ? "#faf7f2" : "#f2efe3"; ?>';">
					<div class="left" style="width: 270px;"><input type="text" name="name[]" class="admintext" style="width: 270px; background-color: #ffffff;"></div>
					<div class="left" style="width: 130px;" style="padding-left: 5px;"><input type="text" name="vvalue[]" class="admintext" style="width: 130px; background-color: #ffffff;"></div>
					<div class="spacer"></div>
				</div>
				<div class="spacer"></div>
	<?		$bgColor = !$bgColor;
			}	?>

			<div class="divider" style="margin-bottom: 0px; margin-top: 0px;"></div>
			<div style="padding: 6px 10px 4px 10px;">
				<div class="left" style="width: 157px;">&nbsp;</div>
				<div style="width: 118px;"><input type="submit" name="continue" value="Continue" class="adminbutton"></div>
				<div class="spacer"></div>
			</div>
		</form>
	</body>
</html>
