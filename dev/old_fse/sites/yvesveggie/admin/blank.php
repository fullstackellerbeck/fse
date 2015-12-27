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
				<div class="contentbox" style="height: 153px;">
			<?	$result = $db->query( "select full_name from admin_users where user_id = '$userId'" );

					if( $db->numRows( $result ) ) {
						list( $fullName ) = $db->fetchRow( $result );
						$dateHour = date( "G", time() );
						$nameArr = explode( " ", $fullName );
					}	?>
					
					<span style="font-size: 18px;">Good <?= ( $dateHour >= 0 && $dateHour <= 11 ? "morning" : ( $dateHour >= 12 && $dateHour <= 4 ? "afternoon" : "evening" ) ); ?> <?= ucwords( $nameArr[ 0 ] ); ?>!</span>
				</div>
			</div>
		</form>
	</body>
</html>
