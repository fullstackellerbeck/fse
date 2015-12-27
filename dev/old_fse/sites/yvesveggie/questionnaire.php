<?	include( "inc/init.php" );

		if( !session_is_registered( "sess_country_id" ) || !session_is_registered( "sess_language_id" ) ) {
			header( "Location: splash.php?referer=$scriptName" );
		}
				
		$pageResult = $db->query( "select pages.name, pages_content.page_title, pages_content.title_image, pages_content.content, pages_content.extra_content, pages_content.auto_html ".
		                          "  from pages, pages_content ".
		                          " where pages.file_name = '$scriptName' ".
		                          "   and pages.page_id   = pages_content.page_id ".
		                          "   and pages_content.country_id  = '$sess_country_id' ".
		                          "   and pages_content.language_id = '$sess_language_id' " );
		
		if( $db->numRows( $pageResult ) ) {
			list( $pageName, $pageTitle, $titleImage, $content, $extraContent, $autoHTML ) = $db->fetchRow( $pageResult );
			
			if( $titleImage && file_exists( realpath( $titleImage ) ) ) {
				list( $width, $height, $type, $htmlWh ) = getimagesize( realpath( $titleImage ) );
			}
		}	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie Cuisine - <?= prepStr( $pageTitle ); ?></title>
				
		<link rel="stylesheet" type="text/css" href="css/popups.css" />
<?	if( $closeWin ) {	?>
			<script language="javascript">
				this.window.close();
			</script>
<?	}	?>
	</head>
	
	<body bgcolor="#CC3333" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td align="center">
		      <table width="380" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
		        <tr><td background="images/universal/wheat.gif" colspan="3"><img src="images/universal/spacer.gif" width="1" height="9" alt="" /></td></tr>
		        <tr> 
		          <td rowspan="2"><img src="images/universal/spacer.gif" width="10" height="1" alt="" /></td>
		          <td><img src="images/universal/spacer.gif" width="360" height="1" alt="" /></td>
		          <td rowspan="2"><img src="images/universal/spacer.gif" width="10" height="1" alt="" /></td>
		        </tr>
		        <tr> 
		          <td valign="top" align="left"> 
		            <form name="bunny" action="questionnaire.php" method="post">
			            <h1><img src="<?= $titleImage; ?>" width="<?= $width; ?>" height="<?= $height; ?>" alt="<?= $pageName; ?>" /></h1>
			            <p><?= ( $autoHTML == "Y" ? nl2br( prepStr( $content ) ) : prepStr( $content ) );	?></p>

									<?= $extraContent; ?>
									<a href="#" onclick="document.bunny.submit();"><img src="<?= $buttonArr[ "send" ][ 0 ]; ?>" width="<?= $buttonArr[ "send" ][ 1 ]; ?>" height="<?= $buttonArr[ "send" ][ 2 ]; ?>" border="0" alt="send" /></a>
		            </form>
		          </td>
		        </tr>
		        <tr><td valign="top" background="images/universal/gradient.gif" colspan="3"><img src="images/universal/spacer.gif" width="1" height="36" alt="" /></td></tr>
		        <tr><td background="images/universal/wheat.gif" colspan="3"><img src="images/universal/spacer.gif" width="1" height="9" alt="" /></td></tr>
		      </table>  
		      <table width="380" border="0" cellspacing="0" cellpadding="0">
		        <tr> 
		          <td align="left"><div class="footer"><a href="http://www.hain-celestial.com">A Division of Hain Celestial Group, Inc. </a></div></td>
		          <td align="right"><div class="footer"><a href="terms.php">Privacy / Legal</a></div></td>
		        </tr>
		      	<tr><td colspan="2" align="center"><div class="smallfooter" style="padding-bottom: 10px;">Design by <a href="http://www.raisedeyebrow.com/" target="_blank">Raised Eyebrow Web Studio</a>, development by <a href="http://www.igivegoodweb.com/" target="_blank">I Give Good Web</a>.</div></td></tr>
		      </table>
		    </td>
		  </tr>
		</table>
	</body>
</html>
