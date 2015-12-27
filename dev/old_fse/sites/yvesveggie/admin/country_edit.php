<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
			header( "Location: login.php" );
		}
		
		if( $continue ) {
			$pageQuery = $db->createInsert( array( "name" => "'$name'",
	                                           "live" => "'$live'" ),
																						 array( "country_id", $country_id ),
																						 "countries" );
	
			$pageResult = $db->query( $pageQuery );
			
			header( "Location: " . ( $referer != "country_edit.php" ? $referer : "country_language_display.php" ) );
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
<?	if( $country_id ) {
			$displayResult = $db->query( "select name, live from countries where country_id='$country_id'" );
			if( $db->numRows( $displayResult ) ) {
				list( $name, $live ) = $db->fetchRow( $displayResult );
			}
		}	?>
		<form name="bunny" action="country_edit.php" method="post">
			<input type="hidden" name="country_id" value="<?= $country_id; ?>">
			<input type="hidden" name="referer" value="<?= basename( $_SERVER[ "HTTP_REFERER" ] ); ?>">
			<div class="title"><div class="left"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div><div class="right"><a href="<?= basename( $_SERVER[ "PHP_SELF" ] ) . "?logoff=true"; ?>">Log-off</a></div></div>
			<div style="margin: 5px 5px 5px 5px;">
				<div class="menu" style="margin-right: 5px;">
					<? include( "admin_menu.php" ); ?>
				</div>
				<div class="contentbox">
					<span class="title"><?= $language_id ? "Edit" : "Add"; ?> a country</span><br>
					<div class="innercontent">
						<div class="left" style="width: 80%;">
							<div class="left" style="width: 22%;">Country name</div>
							<div class="left" style="width: 60%;"><input type="text" name="name" class="admintext" value="<?= $name; ?>"></div>
							<div class="spacer"></div>
							
							<div class="left" style="width: 22%;">Live</div>
							<div class="left" style="width: 60%;">
								<input type="radio" name="live" value="Y"<?= !$live || $live == "Y" ? " checked" : ""; ?> id="yesId"> <label for="yesId">Yes</label> &nbsp&nbsp;
								<input type="radio" name="live" value="N"<?= $live == "N" ? " checked" : ""; ?> id="noId"> <label for="noId">No</label>
							</div>
							<div class="spacer"></div>
						</div>
						
						<div class="left" style="width: 20%;">
							<input type="submit" name="continue" value="Continue" class="adminsubmit"><br>
							<input type="button" name="cancel" value="Cancel" class="adminbutton" onclick="confirmCancel('country_language_display.php');">
						</div>
						<div class="spacer"></div>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
