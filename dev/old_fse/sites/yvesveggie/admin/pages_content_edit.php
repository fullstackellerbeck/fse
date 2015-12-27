<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
		 	header( "Location: login.php" );
		}
		
		if( $continue || $new) {
			if( $new ) {
				unset( $content_id );
			}
			
			$pageQuery = $db->createInsert( array( "page_id"       => "'$page_id'",
																						 "country_id"    => "'$country_id'",
																						 "language_id"   => "'$language_id'",
																						 "page_title"    => "'$page_title'",
																						 "title_image"   => "'$title_image'",
																						 "auto_html"     => "'$auto_html'",
																						 "content"       => "'$content'",
																						 "extra_content" => "'$extra_content'",
																						 "right_content" => "'$right_content'" ),
																						 array( "content_id", $content_id ),
																						 "pages_content" );
	
			$pageResult = $db->query( $pageQuery );
			
			header( "Location: pages_content_display.php" );
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
<?	if( $content_id ) {
			$displayResult = $db->query( "select page_id, country_id, language_id, page_title, title_image, content, extra_content, right_content, auto_html from pages_content where content_id='$content_id'" );
			if( $db->numRows( $displayResult ) ) {
				list( $dbPageId, $dbCountryId, $dbLanguageId, $pageTitle, $titleImage, $content, $extraContent, $rightContent, $autoHTML ) = $db->fetchRow( $displayResult );
			}
		}	?>
		<form name="bunny" action="pages_content_edit.php" method="post">
			<input type="hidden" name="content_id" value="<?= $content_id; ?>">
			<div class="title"><div class="left"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div><div class="right"><a href="<?= basename( $_SERVER[ "PHP_SELF" ] ) . "?logoff=true"; ?>">Log-off</a></div></div>
			<div style="margin: 5px 5px 5px 5px;">
				<div class="menu" style="margin-right: 5px;">
					<? include( "admin_menu.php" ); ?>
				</div>
				<div class="contentbox">
					<span class="title"><?= $content_id ? "Edit" : "Add"; ?> a site page content</span><br>
					<div class="innercontent">
						<div class="left" style="width: 80%;">
							<div class="left" style="width: 22%;">Page</div>
							<div class="left" style="width: 60%;">
								<select name="page_id" class="adminselect">
							<?	$pageResult = $db->query( "select page_id, name, file_name from pages" );
									if( $db->numRows( $pageResult ) ) {
										while( list( $pageId, $pageName, $pageFileName ) = $db->fetchRow( $pageResult ) ) {	?>
										 <option value="<?= $pageId; ?>"<?= ($pageId == $dbPageId ? " selected" : ""); ?>><?= $pageName; ?> (<?= $pageFileName; ?>)</option>
								<?	}
									}	?>
								</select>
							</div>
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
							<div class="spacer" style="padding-bottom: 10px;"></div>

							<div class="left" style="width: 22%;">Page title</div>
							<div class="left" style="width: 60%;"><input type="text" name="page_title" class="admintext" value="<?= $pageTitle; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Title image</div>
							<div class="left" style="width: 60%;"><input type="text" name="title_image" class="admintext" value="<?= $titleImage; ?>"></div>
							<div class="spacer"></div>
														
							<div class="left" style="width: 22%;">Auto-HTML</div>
							<div class="left" style="width: 60%;">
								<input type="radio" name="auto_html" id="yes" value="Y"<?= !$autoHTML|| $autoHTML == "Y" || !$autoHTML ? " checked" : ""; ?>><label for="yes">Yes</label> &nbsp&nbsp;
								<input type="radio" name="auto_html" id="no" value="N"<?= $autoHTML == "N" ? " checked" : ""; ?>><label for="no">No</label>
							</div>
							<div class="spacer"></div>							
	
						</div>
						
						<div class="left" style="width: 20%;">
							<input type="submit" name="continue" value="Continue" class="adminsubmit"><br>
							<input type="submit" name="new" value="Insert as new" class="adminsubmit"><br>
							<input type="button" name="cancel" value="Cancel" class="adminbutton" onclick="confirmCancel('pages_display.php');">
						</div>
						<div class="spacer"></div>
					</div>

					<div class="innercontent">
						<div class="left" style="width: 17%; padding-right: 3px;">Content</div>
						<div class="left" style="width: 70%;"><textarea name="content" class="admintextarea" style="height: 200px; width: 465px;"><?= stripslashes( $content ); ?></textarea></div>
						<div class="spacer"></div>
					</div>

					<div class="innercontent">
						<div class="left" style="width: 17%; padding-right: 3px;">Extra content</div>
						<div class="left" style="width: 70%;"><textarea name="extra_content" class="admintextarea" style="height: 100px; width: 465px;"><?= stripslashes( $extraContent ); ?></textarea></div>
						<div class="spacer"></div>
					</div>

					<div class="innercontent">
						<div class="left" style="width: 17%; padding-right: 3px;">Right content</div>
						<div class="left" style="width: 70%;"><textarea name="right_content" class="admintextarea" style="height: 100px; width: 465px;"><?= stripslashes( $rightContent ); ?></textarea></div>
						<div class="spacer"></div>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
