<?	include( "inc/init.php" );

		if( $country_id && $language_id ) {
			$sess_country_id  = $country_id;
			$sess_language_id = $language_id;
			
			$_SESSION['sess_country_id'] = "";
			$_SESSION['sess_language_id'] = "";
		
			header( "Location: " . ($referer ? $referer : "home.php") );
		}	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie Cuisine - Welcome!</title>

		<script language="Javascript" src="js/functions.js"></script>
		<link rel="stylesheet" href="css/styles.css" type="text/css">
	</head>
	
	<body>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td align="center">
		      <table width="743" border="0" cellspacing="0" cellpadding="0">
		        <tr><td colspan="3"><img src="images/splash/header.gif" width="743" height="171" alt="Yves Veggie Cuisine" /></td></tr>
		        <tr> 
		          <td bgcolor="#FFCC00" rowspan="3"><img src="images/universal/spacer.gif" width="3" height="1" /></td>
		          <td><img src="images/universal/spacer.gif" width="737" height="1" alt="" /></td>
		          <td bgcolor="#FFCC00" rowspan="3"><img src="images/universal/spacer.gif" width="3" height="1" alt="" /></td>
		        </tr>
		        <tr><td align="center"><img src="images/splash/welcome.gif" width="257" height="63" alt="Welcome!" /></td></tr>
		        <tr><td align="center">
		        	<p>We invite you to learn about our award winning soy-based veggie products &#8212; <br /> delicious, nutritious alternatives for a healthier lifestyle.</p>
		        	<!-- <p style="font-size: 12px;">This site requires cookies, please make sure they are turned on.</p> -->
		        </td></tr>
		        <tr> 
		          <td bgcolor="#FFCC00"><img src="images/universal/spacer.gif" width="3" height="303" /></td>
		          <td align="center" valign="top" background="images/splash/burger.jpg" height="303">
		            <table width="261" border="0" cellspacing="0" cellpadding="0">
		              <tr> 
		                <td width="1" height="8"><img src="images/universal/spacer.gif" width="174" height="1" /></td>
		                <td><img src="images/universal/spacer.gif" width="87" height="1" /></td>
		              </tr>
		              <tr> 
		                <td align="center"><img src="images/splash/flag_cdn.gif" width="54" height="27" alt="Canadian site" border="0" /></td>
		                <td align="center" width="40%">
		                	<a href="splash.php?country_id=2&language_id=1<?= $referer ? "&referer=$referer" : ""; ?>"><img src="images/splash/flag_us.gif" width="54" height="27" alt="US site" border="0" /></a>
		                </td>
		              </tr>
		              <tr> 
		                <td align="center"><a href="splash.php?country_id=1&language_id=1<?= $referer ? "&referer=$referer" : ""; ?>" onMouseOut="swapImgRestore()" onMouseOver="swapImage('en','','images/splash/en_on.gif',1)"><img name="en" border="0" src="images/splash/en.gif" width="71" height="14" alt="English" hspace="8"></a><a href="splash.php?country_id=1&language_id=2<?= $referer ? "&referer=$referer" : ""; ?>" onMouseOut="swapImgRestore()" onMouseOver="swapImage('fr','','images/splash/fr_on.gif',1)"><img name="fr" border="0" src="images/splash/fr.gif" width="71" height="14" alt="Francais" hspace="8"></a></td>
		                <td align="center" width="40%">&nbsp;</td>
		              </tr>
		            </table>
		          </td>
		          <td bgcolor="#FFCC00"><img src="images/universal/spacer.gif" width="3" height="303" /></td>
		        </tr>
		        <tr><td colspan="3" background="images/splash/wheat.gif"><img src="images/universal/spacer.gif" width="10" height="13" alt="" /></td></tr>
		      </table>
		      <table width="737" border="0" cellspacing="0" cellpadding="0">
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
