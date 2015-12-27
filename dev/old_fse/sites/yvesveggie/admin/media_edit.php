<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
		 	header( "Location: login.php" );
		}
		
		if( $continue || $new ) {
			if( $new ) {
				unset( $release_id );
			}
			
			$pageQuery = $db->createInsert( array( "country_id"   => "'$country_id'",
	                                           "language_id"  => "'$language_id'",
	                                           "release_date" => "'$release_date'",
	                                           "title"        => "'$title'",
	                                           "live"         => "'$live'",
	                                           "location"     => "'$location'",
	                                           "content"      => "'$content'",
	                                           "auto_html"    => "'$auto_html'" ),
																						 array( "release_id", $release_id ),
																						 "media_releases" );
	
			$pageResult = $db->query( $pageQuery );
			
			header( "Location: media_display.php" );
		}	?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie &#8212; Site Administration</title>
		<link rel="stylesheet" type="text/css" href="css/common.css">

		<script language="javascript" src="js/functions.js"></script>
	</head>
	
	<body>
<?	if( $release_id ) {
			$displayResult = $db->query( "select country_id, language_id, release_date, title, live, location, content, auto_html from media_releases where release_id = '$release_id'" );
			if( $db->numRows( $displayResult ) ) {
				list( $dbCountryId, $dbLanguageId, $releaseDate, $title, $live, $location, $content, $autoHTML ) = $db->fetchRow( $displayResult );
			}
		}	?>
		<form name="bunny" action="media_edit.php" method="post">
			<input type="hidden" name="release_id" value="<?= $release_id; ?>">
			<div class="title"><div class="left"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div><div class="right"><a href="<?= basename( $_SERVER[ "PHP_SELF" ] ) . "?logoff=true"; ?>">Log-off</a></div></div>
			<div style="margin: 5px 5px 5px 5px;">
				<div class="menu" style="margin-right: 5px;">
					<? include( "admin_menu.php" ); ?>
				</div>
				<div class="contentbox">
					<span class="title"><?= $faq_id ? "Edit" : "Add"; ?> a release</span><br>
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
							<div class="spacer"></div>							

							<div class="left" style="width: 22%;">Release date</div>
							<div class="left" style="width: 60%;"><input type="text" name="release_date" class="admintext" value="<?= $releaseDate; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Title</div>
							<div class="left" style="width: 60%;"><input type="text" name="title" class="admintext" value="<?= $title; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Location</div>
							<div class="left" style="width: 60%;"><input type="text" name="location" class="admintext" value="<?= $location; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Auto-HTML</div>
							<div class="left" style="width: 60%;">
								<input type="radio" name="auto_html" id="yes" value="Y"<?= !$autoHTML|| $autoHTML == "Y" || !$autoHTML ? " checked" : ""; ?>><label for="yes">Yes</label> &nbsp&nbsp;
								<input type="radio" name="auto_html" id="no" value="N"<?= $autoHTML == "N" ? " checked" : ""; ?>><label for="no">No</label>
							</div>
							<div class="spacer"></div>							

							<div class="left" style="width: 22%;">Live</div>
							<div class="left" style="width: 60%;">
								<input type="radio" name="live" id="yes" value="Y"<?= !$live || $live == "Y" || !$live ? " checked" : ""; ?>><label for="yes">Yes</label> &nbsp&nbsp;
								<input type="radio" name="live" id="no" value="N"<?= $live == "N" ? " checked" : ""; ?>><label for="no">No</label>
							</div>
							<div class="spacer" style="padding-bottom: 5px;"></div>
						</div>
						
						<div class="left" style="width: 20%;">
							<input type="submit" name="continue" value="Continue" class="adminsubmit"><br>
							<input type="submit" name="new" value="Insert as New" class="adminsubmit"><br>
							<input type="button" name="cancel" value="Cancel" class="adminbutton" onclick="confirmCancel('media_display.php');">
						</div>
						<div class="spacer"></div>
					</div>

					<div class="innercontent">
						<div class="left" style="width: 17%; padding-right: 3px;">Content</div>
						<div class="left" style="width: 70%;"><textarea name="content" class="admintextarea" style="height: 400px; width: 465px;"><?= $content; ?></textarea></div>
						<div class="spacer"></div>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
