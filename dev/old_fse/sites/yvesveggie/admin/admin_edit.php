<?	include( "inc/init.php" );
		
		if( !checkLogin( $sName ) ) {
			header( "Location: login.php" );
		}
		
		if( $continue ) {
			if( $user_id ) {
				$deleteAccessResult = $db->query( "delete from admin_page_access where user_id = '$user_id'" );
			}
						
			$pageQuery = $db->createInsert( array( "user_name" => "'$user_name'",
	                                           "pword"     => ($last_pw != $pword ? "password( '$pword' )" : "'$last_pw'"),
																						 "full_name" => "'$full_name'" ),
																						 array( "user_id", $user_id ),
																						 "admin_users" );
			
			$pageResult = $db->query( $pageQuery );
			if( !$user_id ) $user_id = $db->lastID();
			
			if( $user_id ) {
				foreach( $page as $arrVal ) {
					$insertAccessResult = $db->query( "insert into admin_page_access ( user_id, page_id ) values ( '$user_id', '$arrVal' )" );
				}
			}
			
			header( "Location: admin_display.php" );
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
<?	if( $user_id ) {
			$userResult = $db->query( "select user_name, pword, full_name from admin_users where user_id='$user_id'" );
			if( $db->numRows( $userResult ) ) {
				list( $userName, $pWord, $fullName ) = $db->fetchRow( $userResult );
			}
		}	?>
		<form name="bunny" action="admin_edit.php" method="post">
			<input type="hidden" name="user_id" value="<?= $user_id; ?>">
			<input type="hidden" name="last_pw" value="<?= $pWord; ?>">
			<div class="title"><div class="left"><span class="title">Yves Veggie Cusine &#8212; Website Administration</span></div><div class="right"><a href="<?= basename( $_SERVER[ "PHP_SELF" ] ) . "?logoff=true"; ?>">Log-off</a></div></div>
			<div style="margin: 5px 5px 5px 5px;">
				<div class="menu" style="margin-right: 5px;">
					<? include( "admin_menu.php" ); ?>
				</div>
				<div class="contentbox">
					<span class="title">Edit an administrator</span><br>
					<div class="innercontent">
						<div class="left" style="width: 80%;">
							<div class="left" style="width: 22%;">Full name</div>
							<div class="left" style="width: 60%;"><input type="text" name="full_name" class="admintext" value="<?= $fullName; ?>"></div>
							<div class="spacer"></div>

							<div class="left" style="width: 22%;">User name</div>
							<div class="left" style="width: 60%;"><input type="text" name="user_name" class="admintext" value="<?= $userName; ?>"></div>
							<div class="spacer"></div>
							
							<div class="left" style="width: 22%;">Password</div>
							<div class="left" style="width: 60%;"><input type="password" name="pword" class="admintext" value="<?= $pWord; ?>"></div>
							<div class="spacer" style="padding-bottom: 8px;"></div>
							
							<div class="left" style="width: 22%;">Page access</div>
							<div class="left" style="width: 74%; overflow-y: scroll; height: 300px; border: 1px solid #bbb; padding: 5px 7px 5px 5px; margin-top: 1px; backrground-color: #f9f9f9;">
							<div id="selectDiv" style="text-align: right; background-color: #fcfafb;"><a href="javascript:selectAll( document.bunny );" >Check all</a></div>
						<?	$first = $bgColor = true;
						
								$categoryResult = $db->query( "select category_id, name from admin_pages_category order by category_id asc" );
								if( $db->numRows( $categoryResult ) ) {
									while( list( $categoryId, $catName ) = $db->fetchRow( $categoryResult ) ) {
										$pageCountResult = $db->query( "select count( page_id ) from admin_pages where category_id = '$categoryId'" );
										list( $pageCount ) = $db->fetchRow( $pageCountResult );
										
										if( $pageCount > 0 ) {	?>
											<?= !$first ? "<br>" : ""; ?><b><?= $catName; ?></b><br>
											<div class="divider" style="margin-bottom: 5px;"></div>
										
									<?	$pageResult = $db->query( "select page_id, name from admin_pages where category_id = '$categoryId'" );
											if( $db->numRows( $pageResult ) ) {
												while( list( $pageId, $pageName ) = $db->fetchRow( $pageResult ) ) {
													$pageAccessResult = $db->query( "select page_id from admin_page_access where user_id = '$user_id' and page_id = '$pageId'" );	?>
													<div style="background-color: <?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>;" onmouseover="this.style.backgroundColor='#f0f2f2';" onmouseout="this.style.backgroundColor='<?= $bgColor ? "#fcfafb" : "#faf7f2"; ?>';">
														<input type="checkbox" name="page[]" value="<?= $pageId; ?>" id="pg_<?= $pageId; ?>"<?= $db->numRows( $pageAccessResult ) ? " checked" : ""; ?>> <label for="pg_<?= $pageId; ?>"><?= $pageName; ?></label>														
													</div>
										<?		$bgColor = !$bgColor;
												}
											}
										}
										
										$first = false;
									}
								}	?>
							</div>
							<div class="spacer"></div>
						</div>
						
						<div class="left" style="width: 20%;">
							<input type="submit" name="continue" value="Continue" class="adminsubmit"><br>
							<input type="button" name="cancel" value="Cancel" class="adminbutton" onclick="confirmCancel('admin_display.php');">
						</div>
						<div class="spacer"></div>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
