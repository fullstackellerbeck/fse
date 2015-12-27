<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
			header( "Location: login.php" );
		}
		
		if( $continue ) {
			$pageQuery = $db->createInsert( array( "name"      => "'$name'",
	                                           "file_name" => "'$file_name'" ),
																						 array( "shot_id", $shot_id ),
																						 "beauty_shots" );
	
			$pageResult = $db->query( $pageQuery );
			
			header( "Location: beauty_shot_display.php" );
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
<?	if( $shot_id ) {
			$displayResult = $db->query( "select name, file_name from beauty_shots where shot_id='$shot_id'" );
			if( $db->numRows( $displayResult ) ) {
				list( $name, $fileName ) = $db->fetchRow( $displayResult );
			}
		}	?>
		<form name="bunny" action="beauty_shot_edit.php" method="post">
			<input type="hidden" name="shot_id" value="<?= $shot_id; ?>">
			<div class="title"><div class="left"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div><div class="right"><a href="<?= basename( $_SERVER[ "PHP_SELF" ] ) . "?logoff=true"; ?>">Log-off</a></div></div>
			<div style="margin: 5px 5px 5px 5px;">
				<div class="menu" style="margin-right: 5px;">
					<? include( "admin_menu.php" ); ?>
				</div>
				<div class="contentbox">
					<span class="title"><?= $shot_id ? "Edit" : "Add"; ?> a beauty shot</span><br>
					<div class="innercontent">
						<div class="left" style="width: 80%;">
							<div class="left" style="width: 22%;">Name</div>
							<div class="left" style="width: 60%;"><input type="text" name="name" class="admintext" value="<?= $name; ?>"></div>
							<div class="spacer"></div>
							
							<div class="left" style="width: 22%;">File name</div>
							<div class="left" style="width: 60%;"><input type="text" name="file_name" class="admintext" value="<?= $fileName; ?>"></div>
							<div class="spacer"></div>
						</div>
						
						<div class="left" style="width: 20%;">
							<input type="submit" name="continue" value="Continue" class="adminsubmit"><br>
							<input type="button" name="cancel" value="Cancel" class="adminbutton" onclick="confirmCancel('beauty_shot_display.php');">
						</div>
						<div class="spacer"></div>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
