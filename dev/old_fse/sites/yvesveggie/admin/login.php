<?	include( "inc/init.php" );
		
		if( $continue ) {
			$result = $db->query( "select user_id from admin_users where user_name = '$userName' and pword = password( '$passWord' )" );

			if( $db->numRows( $result ) ) {
				list( $userId ) = $db->fetchRow( $result );
				
				if( !session_is_registered( "md5Token" ) ) {
					$md5Token = md5( uniqid( rand(), 1 ) ); 
					
					$updateResult = $db->query( "update admin_users set last_login = now(), last_unique_id='$md5Token' where user_id = '$userId'" );
					session_register( "md5Token" );
				} 
												
				session_register( "userId" );
				header( "Location: blank.php" );
			} else {
				$errMsg = true;
			}
		}	?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie &#8212; Site Administration</title>
		<link rel="stylesheet" type="text/css" href="css/common.css">
	</head>
	
	<body onload="document.bunny.userName.focus();">
		<form name="bunny" action="login.php" method="post">
			<div class="title"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div>
			<div style="margin: 5px 5px 5px 5px;">
				<div class="menu" style="margin-right: 5px;">
					<? include( "admin_menu.php" ); ?>
				</div>
				<div class="contentbox" style=" height: 153px;">
			<?	if( !$errMsg ) { 	?>
						<p><b>This site is for authorized users only.</b><br>Please enter your login name and password below.</p>
			<?	} else {	?>
						<p><span style="color: #c33;"><b>Login failure</b></span><br>Please re-enter your user name and password below.</p>
			<?	}	?>
					
						User name<br>
						<input type="text" maxlength="100" name="userName" class="admintextfull"><br><br>

						Password<br>
						<input type="password" maxlength="25" name="passWord" class="admintextfull"><br><br>
						<center><input type="submit" name="continue" value="continue" class="adminsubmitfull"></center>
				</div>
			</div>
		</form>
	</body>
</html>
