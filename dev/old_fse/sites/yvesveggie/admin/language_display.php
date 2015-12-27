<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
		 	header( "Location: login.php" );
		}	?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie &#8212; Site Administration</title>
		<link rel="stylesheet" type="text/css" href="css/common.css">
	</head>
	
	<body>
		<form name="login" action="login.php" method="post">
			<div class="title"><div class="left"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div><div class="right"><a href="<?= basename( $_SERVER[ "PHP_SELF" ] ) . "?logoff=true"; ?>">Log-off</a></div></div>
			<div style="margin: 5px 5px 5px 5px;">
				<div class="menu" style="margin-right: 5px;">
					<? include( "admin_menu.php" ); ?>
				</div>
				<div class="contentbox">
					<span class="title">Display all languages</span>	
					<div class="innercontent">
						<div class="left" style="width: 50%;"><b>Language name</b></div>
						<div class="left" style="width: 20%;"><b>Live</b></div>
						<div class="spacer"></div>
						<div class="divider"></div>
					
				<?	$bgColor = false;
				
						$displayResult = $db->query( "select language_id, name, live from language" );
						if( $db->numRows( $displayResult ) ) {
							while( list( $languageId, $name, $live ) = $db->fetchRow( $displayResult ) ) {	?>
								<div style="padding-top: 4px; padding-bottom: 4px; background-color: <?= $bgColor ? "#ffffff" : "#f4f2e8"; ?>;" onmouseover="this.style.backgroundColor='#eeeeff';" onmouseout="this.style.backgroundColor='<?= $bgColor ? "#ffffff" : "#f4f2e8"; ?>';">
									<div class="left" style="width: 50%;"><?= $name; ?></div>
									<div class="left" style="width: 20%;"><?= ($live == "Y" ? "Yes" : "No"); ?></div>
									<div class="right" style="width: 15%; text-align: right;"><a href="language_edit.php?language_id=<?= $languageId; ?>">edit</a> &middot; <a href="#">delete</a></div>
									<div class="spacer"></div>
								</div>
					<?		$bgColor = !$bgColor;
							}
						}	?>
						
						<div class="spacer"></div>
					</div>
					
				</div>
			</div>
		</form>
	</body>
</html>
