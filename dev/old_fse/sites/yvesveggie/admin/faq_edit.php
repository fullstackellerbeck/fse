<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
		 	header( "Location: login.php" );
		}
		
		if( $continue ) {
			$pageQuery = $db->createInsert( array( "country_id"  => "'$country_id'",
	                                           "language_id" => "'$language_id'",
	                                           "question"    => "'$question'",
	                                           "answer"      => "'$answer'",
	                                           "priority"    => "'$priority'",
	                                           "live"        => "'$live'" ),
																						 array( "faq_id", $faq_id ),
																						 "faq" );
	
			$pageResult = $db->query( $pageQuery );
			
			header( "Location: faq_display.php" );
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
<?	if( $faq_id ) {
			$displayResult = $db->query( "select country_id, language_id, question, answer, live, priority from faq where faq_id = '$faq_id'" );
			if( $db->numRows( $displayResult ) ) {
				list( $dbCountryId, $dbLanguageId, $question, $answer, $live, $priority ) = $db->fetchRow( $displayResult );
			}
		}	?>
		<form name="bunny" action="faq_edit.php" method="post">
			<input type="hidden" name="faq_id" value="<?= $faq_id; ?>">
			<div class="title"><div class="left"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div><div class="right"><a href="<?= basename( $_SERVER[ "PHP_SELF" ] ) . "?logoff=true"; ?>">Log-off</a></div></div>
			<div style="margin: 5px 5px 5px 5px;">
				<div class="menu" style="margin-right: 5px;">
					<? include( "admin_menu.php" ); ?>
				</div>
				<div class="contentbox">
					<span class="title"><?= $faq_id ? "Edit" : "Add"; ?> a FAQ</span><br>
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

							<div class="left" style="width: 22%;">Live</div>
							<div class="left" style="width: 60%;">
								<input type="radio" name="live" id="yes" value="Y"<?= !$live || $live == "Y" || !$live ? " checked" : ""; ?>><label for="yes">Yes</label> &nbsp&nbsp;
								<input type="radio" name="live" id="no" value="N"<?= $live == "N" ? " checked" : ""; ?>><label for="no">No</label>
							</div>
							<div class="spacer" style="padding-bottom: 5px;"></div>
	
							<div class="left" style="width: 22%;">Priority</div>
							<div class="left" style="width: 60%;"><input type="text" name="priority" class="admintext" value="<?= $priority; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Question</div>
							<div class="left" style="width: 60%;"><textarea name="question" class="admintextarea" style="height: 50px;"><?= $question; ?></textarea></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">Answer</div>
							<div class="left" style="width: 60%;"><textarea name="answer" class="admintextarea"><?= $answer; ?></textarea></div>
							<div class="spacer"></div>
						</div>
						
						<div class="left" style="width: 20%;">
							<input type="submit" name="continue" value="Continue" class="adminsubmit"><br>
							<input type="button" name="cancel" value="Cancel" class="adminbutton" onclick="confirmCancel('faq_display.php');">
						</div>
						<div class="spacer"></div>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
