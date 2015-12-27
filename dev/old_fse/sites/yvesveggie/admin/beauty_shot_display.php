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

		<script language="javascript" src="js/functions.js"></script>
	</head>
	
	<body>
		<form name="login" action="login.php" method="post">
			<div class="title"><div class="left"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div><div class="right"><a href="<?= basename( $_SERVER[ "PHP_SELF" ] ) . "?logoff=true"; ?>">Log-off</a></div></div>
			<div style="margin: 5px 5px 5px 5px;">
				<div class="menu" style="margin-right: 5px;">
					<? include( "admin_menu.php" ); ?>
				</div>
				<div class="contentbox">
					<span class="title">Display all beauty shots</span>	
					<div class="innercontent" style="width: 578px;">
						<div class="left" style="width: 30%;"><b>Name</b></div>
						<div class="left" style="width: 40%;"><b>File name</b></div>
						<div class="spacer"></div>
						<div class="divider"></div>
					
				<?	$bgColor = false;
				
						$displayResult = $db->query( "select shot_id, name, file_name from beauty_shots order by name" );
						if( $db->numRows( $displayResult ) ) {
							while( list( $shotId, $name, $fileName ) = $db->fetchRow( $displayResult ) ) {	?>
								<div style="padding-top: 4px; padding-bottom: 4px; background-color: <?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>;" onmouseover="this.style.backgroundColor='#eeeeff';" onmouseout="this.style.backgroundColor='<?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>';">
									<div class="left" style="width: 30%;"><?= $name; ?></div>
									<div class="left" style="width: 40%;"><?= $fileName; ?></div>
									<div class="right" style="width: 15%; text-align: right;"><a href="beauty_shot_edit.php?shot_id=<?= $shotId; ?>">edit</a> &middot; <a href="javascript:void(delItem('beauty_shot_display.php','<?= $shotId; ?>','beauty_shots','shot_id'));">delete</a></div>
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
