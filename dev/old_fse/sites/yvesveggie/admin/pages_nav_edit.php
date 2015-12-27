<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
		 	header( "Location: login.php" );
		}
		
		if( $continue || $new ) {
			if( $new ) {
				unset( $nav_id );
			}
			
			$pageQuery = $db->createInsert( array( "name"        => "'$name'",
																						 "country_id"  => "'$country_id'",
	                                           "language_id" => "'$language_id'",
	                                           "type"        => "'$type'",
	                                           "page_id"     => "'$page_id'",
	                                           "base_image"  => "'$base_image'",
	                                           "position"    => "'$position'" ),
																						 array( "nav_id", $nav_id ),
																						 "pages_nav" );
	
			$pageResult = $db->query( $pageQuery );
			
			header( "Location: pages_nav_display.php" );
		}
		
		$navTypeArr = $db->fieldEnumTypes( "pages_nav", "type" );	?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie &#8212; Site Administration</title>
		<link rel="stylesheet" type="text/css" href="css/common.css">

		<script language="javascript" src="js/functions.js"></script>
	</head>
	
	<body>
<?	if( $nav_id ) {
			$displayResult = $db->query( "select name, country_id, language_id, type, page_id, base_image, position from pages_nav where nav_id = '$nav_id'" );
			if( $db->numRows( $displayResult ) ) {
				list( $name, $dbCountryId, $dbLanguageId, $type, $dbPageId, $baseImage, $position ) = $db->fetchRow( $displayResult );
			}
		}	?>
		<form name="bunny" action="pages_nav_edit.php" method="post">
			<input type="hidden" name="nav_id" value="<?= $nav_id; ?>">
			<div class="title"><div class="left"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div><div class="right"><a href="<?= basename( $_SERVER[ "PHP_SELF" ] ) . "?logoff=true"; ?>">Log-off</a></div></div>
			<div style="margin: 5px 5px 5px 5px;">
				<div class="menu" style="margin-right: 5px;">
					<? include( "admin_menu.php" ); ?>
				</div>
				<div class="contentbox">
					<span class="title"><?= $nav_id ? "Edit" : "Add"; ?> a nav item</span><br>
					<div class="innercontent">
						<div class="left" style="width: 80%;">
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
							<div class="spacer" style="padding-bottom: 5px;"></div>							

							<div class="left" style="width: 22%;">Page</div>
							<div class="left" style="width: 60%;">
								<select name="page_id" class="adminselect">
							<?	$pageResult = $db->query( "select page_id, name from pages" );
									if( $db->numRows( $pageResult ) ) {
										while( list( $pageId, $pageName ) = $db->fetchRow( $pageResult ) ) {	?>
										 <option value="<?= $pageId; ?>"<?= ($pageId == $dbPageId ? " selected" : ""); ?>><?= $pageName; ?></option>
								<?	}
									}	?>
								</select>
							</div>
							<div class="spacer" style="padding-bottom: 5px;"></div>							

							<div class="left" style="width: 22%;">Name</div>
							<div class="left" style="width: 60%;"><input type="text" name="name" class="admintext" value="<?= $name; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Nav type</div>
							<div class="left" style="width: 60%;">
								<select name="type" class="adminselect">
							<?	while( list( $typeIndex, $typeName ) = each( $navTypeArr ) ) {	?>
										<option value="<?= $typeName; ?>"<?= ($type == $typeName ? " selected" : ""); ?>> <?= ucfirst( $typeName ); ?></option>
							<?	}	?>
								</select>
							</div>
							<div class="spacer"></div>							

							<div class="left" style="width: 22%;">Base image file</div>
							<div class="left" style="width: 60%;"><input type="text" name="pass_value" class="admintext" value="<?= $baseImage; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Priority</div>
							<div class="left" style="width: 60%;"><input type="text" name="position" class="admintext" value="<?= $position; ?>"></div>
							<div class="spacer"></div>
						</div>
						
						<div class="left" style="width: 20%;">
							<input type="submit" name="continue" value="Continue" class="adminsubmit"><br>
							<input type="submit" name="new" value="Insert as new" class="adminsubmit"><br>
							<input type="button" name="cancel" value="Cancel" class="adminbutton" onclick="confirmCancel('pages_nav_display.php');">
						</div>
						<div class="spacer"></div>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
