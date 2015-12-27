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
					<span class="title">Display all admin users</span>	
					<div class="innercontent">
						<div class="left" style="width: 20%;"><b>User name</b></div>
						<div class="left" style="width: 30%;"><b>Full name</b></div>
						<div class="left" style="width: 30%;"><b>Last login</b></div>
						<div class="spacer"></div>
						<div class="divider"></div>
					
				<?	$bgColor = false;
				
						$adminResult = $db->query( "select user_id, user_name, full_name, unix_timestamp( last_login ) from admin_users" );
						if( $db->numRows( $adminResult ) ) {
							while( list( $userId, $userName, $fullName, $lastLogin ) = $db->fetchRow( $adminResult ) ) {	?>
								<div style="padding-top: 4px; padding-bottom: 4px; background-color: <?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>;" onmouseover="this.style.backgroundColor='#f0f2f2';" onmouseout="this.style.backgroundColor='<?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>';">
									<div class="left" style="width: 20%;"><?= $userName; ?></div>
									<div class="left" style="width: 30%;"><?= $fullName; ?></div>
									<div class="left" style="width: 30%;"><?= ($lastLogin != 0 ? date( "F d, Y", $lastLogin ) : "Never logged in"); ?></div>
									<div class="right" style="width: 15%; text-align: right;"><a href="admin_edit.php?user_id=<?= $userId; ?>">edit</a> &middot; <a href="javascript:void(delItem('admin_display.php','<?= $userId; ?>','admin_users','user_id'));">delete</a></div>
									<div class="spacer"></div>
								</div>
					<?	$bgColor = !$bgColor;
							}
						}	?>
						
						<div class="spacer"></div>
					</div>
					
				</div>
			</div>
		</form>
	</body>
</html>
