<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
		 	header( "Location: login.php" );
		}

		if( $continue ) {
			$pageQuery = $db->createInsert( array( "name"        => "'$name'",
	                                           "country_id"  => "'$country_id'",
	                                           "language_id" => "'$language_id'",
	                                           "shot_id"     => "'$shot_id'",
	                                           "live"        => "'$live'",
	                                           "description" => "'$description'",
	                                           "priority"    => "'$priority'" ),
																						 array( "family_id", $family_id ),
																						 "products_family" );
	
			$pageResult = $db->query( $pageQuery );
			
			header( "Location: ". ($referer != "product_family_edit.php" ? $referer : "product_family_display.php") );
		}	?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie &#8212; Site Administration</title>
		<link rel="stylesheet" type="text/css" href="css/common.css">
		<script language="javascript" src="js/functions.js"></script>
	</head>
	
	<body onload="document.bunny.name.focus();">
<?	if( $family_id ) {
			$displayResult = $db->query( "select name, country_id, language_id, shot_id, live, description, priority from products_family where family_id='$family_id'" );
			if( $db->numRows( $displayResult ) ) {
				list( $name, $dbCountryId, $dbLanguageId, $dbShotId, $live, $description, $priority ) = $db->fetchRow( $displayResult );
			}
		}	?>
		<form name="bunny" action="product_family_edit.php" method="post">
			<input type="hidden" name="family_id" value="<?= $family_id; ?>">
			<input type="hidden" name="referer" value="<?= basename( $_SERVER[ "HTTP_REFERER" ] ); ?>">
			<div class="title"><div class="left"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div><div class="right"><a href="<?= basename( $_SERVER[ "PHP_SELF" ] ) . "?logoff=true"; ?>">Log-off</a></div></div>
			<div style="margin: 5px 5px 5px 5px;">
				<div class="menu" style="margin-right: 5px;">
					<? include( "admin_menu.php" ); ?>
				</div>
				<div class="contentbox">
					<span class="title"><?= $family_id ? "Edit" : "Add"; ?> a product family</span><br>
					<div class="innercontent">
						<div class="left" style="width: 80%;">
							<div class="left" style="width: 22%;">Family name</div>
							<div class="left" style="width: 60%;"><input type="text" name="name" class="admintext" value="<?= $name; ?>"></div>
							<div class="spacer"></div>
							
							<div class="left" style="width: 22%;">Country</div>
							<div class="left" style="width: 60%;">
								<select name="country_id" class="adminselect">
							<?	$countryResult = $db->query( "select country_id, name from countries" );
									if( $db->numRows( $countryResult ) ) {
										while( list( $countryId, $countryName ) = $db->fetchRow( $countryResult ) ) {	?>
										 <option value="<?= $countryId; ?>"<?= ($countryId == $dbCountryId ? " selected" : ""); ?>><?= $countryName; ?></option>
								<?	}
									}	?>
								</select>
							</div>
							<div class="spacer"></div>
							
							<div class="left" style="width: 22%;">Language</div>
							<div class="left" style="width: 60%;">
								<select name="language_id" class="adminselect">
							<?	$languageResult = $db->query( "select language_id, name from language" );
									if( $db->numRows( $languageResult ) ) {
										while( list( $languageId, $languageName ) = $db->fetchRow( $languageResult ) ) {	?>
										 <option value="<?= $languageId; ?>"<?= ($languageId == $dbLanguageId ? " selected" : ""); ?>><?= $languageName; ?></option>
								<?	}
									}	?>
								</select>
							</div>
							<div class="spacer" style="padding-bottom: 8px;"></div>							

							<div class="left" style="width: 22%;">Beauty shot</div>
							<div class="left" style="width: 60%;">
								<select name="shot_id" class="adminselect">
							<?	$shotResult = $db->query( "select shot_id, name from beauty_shots" );
									if( $db->numRows( $shotResult ) ) {
										while( list( $shotId, $shotName ) = $db->fetchRow( $shotResult ) ) {	?>
										 <option value="<?= $shotId; ?>"<?= ($shotId == $dbShotId ? " selected" : ""); ?>><?= $shotName; ?></option>
								<?	}
									}	?>
								</select>
							</div>
							<div class="spacer" style="padding-bottom: 8px;"></div>							

							<div class="left" style="width: 22%;">Priority</div>
							<div class="left" style="width: 60%;"><input type="text" name="priority" class="admintext" value="<?= $priority; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Live</div>
							<div class="left" style="width: 60%;">
								<input type="radio" name="live" id="yes" value="Y"<?= !$live || $live == "Y" || !$live ? " checked" : ""; ?>><label for="yes">Yes</label> &nbsp&nbsp;
								<input type="radio" name="live" id="no" value="N"<?= $live == "N" ? " checked" : ""; ?>><label for="no">No</label>
							</div>
							<div class="spacer"></div>
						</div>
						
						<div class="left" style="width: 20%;">
							<input type="submit" name="continue" value="Continue" class="adminsubmit"><br>
							<input type="button" name="cancel" value="Cancel" class="adminbutton" onclick="confirmCancel('product_display.php');">
						</div>
						<div class="spacer"></div>
					</div>

					<div class="innercontent">
							<div class="left" style="width: 17%; padding-right: 3px;">Description</div>
							<div class="left" style="width: 70%;"><textarea name="description" class="admintextarea" style="height: 150px; width: 465px;"><?= $description; ?></textarea></div>
							<div class="spacer"></div>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
