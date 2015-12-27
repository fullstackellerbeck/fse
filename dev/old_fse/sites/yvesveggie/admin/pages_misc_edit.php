<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
		 	header( "Location: login.php" );
		}
		
		if( $continue || $new ) {
			if( $new ) {
				unset( $copy_id );
			}
			
			$pageQuery = $db->createInsert( array( "country_id"  => "'$country_id'",
	                                           "language_id" => "'$language_id'",
	                                           "attrib"      => "'$attrib'",
	                                           "value"       => "'$pass_value'" ),
																						 array( "copy_id", $copy_id ),
																						 "pages_misc_copy" );
	
			$pageResult = $db->query( $pageQuery );
			
			header( "Location: pages_misc_display.php" );
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
<?	if( $copy_id ) {
			$displayResult = $db->query( "select country_id, language_id, attrib, value from pages_misc_copy where copy_id = '$copy_id'" );
			if( $db->numRows( $displayResult ) ) {
				list( $dbCountryId, $dbLanguageId, $attrib, $dbValue ) = $db->fetchRow( $displayResult );
			}
		}	?>
		<form name="bunny" action="pages_misc_edit.php" method="post">
			<input type="hidden" name="copy_id" value="<?= $copy_id; ?>">
			<div class="title"><div class="left"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div><div class="right"><a href="<?= basename( $_SERVER[ "PHP_SELF" ] ) . "?logoff=true"; ?>">Log-off</a></div></div>
			<div style="margin: 5px 5px 5px 5px;">
				<div class="menu" style="margin-right: 5px;">
					<? include( "admin_menu.php" ); ?>
				</div>
				<div class="contentbox">
					<span class="title"><?= $copy_id ? "Edit" : "Add"; ?> miscellaneous copy</span><br>
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
	
							<div class="left" style="width: 22%;">Attribute</div>
							<div class="left" style="width: 60%;"><input type="text" name="attrib" class="admintext" value="<?= $attrib; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Value</div>
							<div class="left" style="width: 60%;"><input type="text" name="pass_value" class="admintext" value="<?= $dbValue; ?>"></div>
							<div class="spacer"></div>
						</div>
						
						<div class="left" style="width: 20%;">
							<input type="submit" name="continue" value="Continue" class="adminsubmit"><br>
							<input type="submit" name="new" value="Insert as new" class="adminsubmit"><br>
							<input type="button" name="cancel" value="Cancel" class="adminbutton" onclick="confirmCancel('pages_misc_display.php');">
						</div>
						<div class="spacer"></div>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
