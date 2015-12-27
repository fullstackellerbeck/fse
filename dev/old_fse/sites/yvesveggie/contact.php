<?	include( "inc/init.php" );

		if( !session_is_registered( "sess_country_id" ) || !session_is_registered( "sess_language_id" ) ) {
			header( "Location: splash.php?referer=$scriptName" );
		}
				
		unset( $errMsg );
		$pageResult = $db->query( "select pages.name, pages_content.page_title, pages_content.title_image, pages_content.content, pages_content.extra_content, pages_content.right_content, pages_content.auto_html, pages.shot_id ".
		                          "  from pages, pages_content ".
		                          " where pages.file_name = '$scriptName' ".
		                          "   and pages.page_id   = pages_content.page_id ".
		                          "   and pages_content.country_id  = '$sess_country_id' ".
		                          "   and pages_content.language_id = '$sess_language_id' " );
		
		if( $db->numRows( $pageResult ) ) {
			list( $pageName, $pageTitle, $titleImage, $content, $extraContent, $rightContent, $autoHTML, $pageShotId ) = $db->fetchRow( $pageResult );
			
			if( $titleImage && file_exists( realpath( $titleImage ) ) ) {
				list( $width, $height, $type, $htmlWh ) = getimagesize( realpath( $titleImage ) );
			}
			
			$shotResult = $db->query( !$pageShotId ? "select name, file_name from beauty_shots order by rand() limit 1" : "select name, file_name from beauty_shots where shot_id = '$pageShotId'" );
			if( $db->numRows( $shotResult ) ) {
				list( $shotName, $shotFileName ) = $db->fetchRow( $shotResult );
			}
		}
		
		if( $continue ) {
			$errMsg .= ( !$subject_id ? prepStr( $copyArr[ "contact_err_subject" ] ) . "<br>" : "" );
			$errMsg .= ( !$message ? prepStr( $copyArr[ "contact_err_message" ] ) . "<br>" : "" );
			$errMsg .= ( !$first_name && !$last_name ? prepStr( $copyArr[ "review_err_flname" ] ) . "<br>" : "" );
			
			if( $email ) {
				if( !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email) ) { 
					$errMsg .= prepStr( $copyArr[ "contact_err_email" ] );
				}
			}

			
			if( !$errMsg ) {
				$pageQuery = $db->createInsert( array( "country_id"    => "'$sess_country_id'",
				                                       "language_id"   => "'$sess_language_id'",
				                                       "subject_id"    => "'$subject_id'",
		                                           "first_name"    => "'$first_name'",
																							 "last_name"     => "'$last_name'",
																							 "email"         => "'$email'",
																							 "message"       => "'$message'",
																							 "date_posted" => "now()" ),
																							 array( "contact_id", "" ),
																							 "contact_us" );
		
				$pageResult = $db->query( $pageQuery );
				$submitted = true;
				
				$subjectResult = $db->query( "select name, action ".
				                             "  from contact_us_subjects ".
				                             " where subject_id = '$subject_id'" );
				if( $db->numRows( $subjectResult ) ) {
					list( $subjectName, $subjectEmail ) = $db->fetchRow( $subjectResult );

					$countryResult = $db->query( "select name from countries where country_id = '$sess_country_id'" );
					if( $db->numRows( $countryResult ) ) {
						list( $countryName ) = $db->fetchRow( $countryResult );
					}

					$languageResult = $db->query( "select name from language where language_id = '$sess_language_id'" );
					if( $db->numRows( $languageResult ) ) {
						list( $languageName ) = $db->fetchRow( $languageResult );
					}

					$emailBody = "yvesveggie.com - Contact-us inquiry\n\n".
					             "Country / Language: $countryName / $languageName\n\n".
					             "Subject: $subjectName\n\n".
					             "Name: $first_name $last_name\n".
					             "E-mail: $email\n".
					             "Date posted: ". date( "F d, Y", time() ) . "\n\n".
					             "$message";
					
					$result = mail( $subjectEmail, "yvesveggie.com - Contact-us inquiry ($subjectName)", $emailBody, "To: $subjectEmail\r\nFrom: contactus@yvesveggie.com\r\nReply-To: $email" );
				}				
			}
		}		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
	<head>
		<title>Yves Veggie Cuisine - <?= prepStr( $pageTitle ); ?></title>

		<script language="javascript" src="js/browser_sniff.js"></script>
		
		<script language="Javascript" src="js/nav.php"></script>
		<script language="Javascript" src="js/init.php"></script>
		<script language="Javascript" src="js/resize.js"></script>

		<link rel="stylesheet" type="text/css" href="css/styles.css" />
		<link rel="stylesheet" type="text/css" href="css/nav.php" />		
	</head>
	
	<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="init('<?= $scriptName; ?>');">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td align="center">
		      <table width="737" border="0" cellspacing="0" cellpadding="0">
		        <tr> 
		          <td colspan="2"><img src="images/universal/logo.gif" width="248" height="147" alt="Yves Veggie Cuisine" /></td>
		          <td colspan="4"><img src="<?= $shotFileName; ?>" width="495" height="110" alt="<?= $shotName; ?>" /><br /><img src="images/universal/h_bot.gif" width="495" height="37" alt="" /></td>
		        </tr>
		        <tr> 
		          <td bgcolor="#FFCC00" rowspan="3"><img src="images/universal/spacer.gif" width="3" height="1" alt="" /></td>
		          <td><img src="images/universal/spacer.gif" width="245" height="1" alt="" /></td>
		          <td rowspan="2"><img src="images/universal/spacer.gif" width="13" height="1" alt="" /></td>
		          <td><img src="images/universal/spacer.gif" width="473" height="1" alt="" /></td>
		          <td rowspan="2"><img src="images/universal/spacer.gif" width="6" height="1" alt="" /></td>
		          <td bgcolor="#FFCC00" rowspan="3"><img src="images/universal/spacer.gif" width="3" height="1" alt="" /></td>
		        </tr>
		        <tr> 
		          <td valign="top"><div name="navLocation" id="navLocation"></div><img src="images/universal/spacer.gif" width="245" height="469" name="navImg" id="navImg" /></td>
		          <td valign="top" align="left">
		          	<form name="bunny" action="contact.php" action="post">
		          		<input type="hidden" name="continue" value="true">
			            <h1><img src="<?= $titleImage; ?>" width="<?= $width; ?>" height="<?= $height; ?>" alt="<?= $pageName; ?>" /></h1>
			            <table width="100%" border="0" cellspacing="0" cellpadding="0">
			              <tr> 
			                <td align="left" valign="top" width="309"> 
										<?	if( !$errMsg ) {
													if( !$submitted ) {	?>
			                    	<p><?= ( $autoHTML == "Y" ? nl2br( prepStr( $content ) ) : prepStr( $content ) );	?></p>
		                <?		} else {	?>
		                				<p><?= prepStr( $copyArr[ "contact_success" ] ); ?></p>
		                	<?	}
		                		} elseif( $errMsg ) {	?>
		                			<p><span class="error"><?= $errMsg; ?></span></p>
		                <?	}	?>
			                  
			             	<?	if( !$submitted ) {	?>
				                  <p>
				                  	<span class="small"><?= prepStr( $copyArr[ "subject" ] ); ?></span><br />
			                      <select name="subject_id" style="width: 228px;">
			                      	<option value="0"></option>												
													<?	$subjectResult = $db->query( "select subject_id, name ".
													                                 "  from contact_us_subjects ".
													                                 " where country_id  = '$sess_country_id' ".
													                                 "   and language_id = '$sess_language_id'" );
													    
													    if( $db->numRows( $subjectResult ) ) {
													    	while( list( $subjectId, $name ) = $db->fetchRow( $subjectResult ) ) {	?>
					                        <option value="<?= $subjectId; ?>"<?= $subject_id == $subjectId ? " selected" : ""; ?>><?= $name; ?></option>
					                   <?	}
					                  	}	?>
			                      </select>
			                      <br /><br />
			                      
			                      <span class="small"><?= prepStr( $copyArr[ "first_name" ] ); ?></span><br>
			                      <input type="text" name="first_name" size="20" class="textbox" style="width: 220px;" value="<?= $first_name; ?>"/>
			                      <br /><br />
			                      
			                      <span class="small"><?= prepStr( $copyArr[ "last_name" ] ); ?></span><br>
			                      <input type="text" name="last_name" class="textbox" size="20" style="width: 220px;" value="<?= $last_name; ?>"/>
				                  </p>
				                  
				                  <p>
				                  	<span class="small"><?= prepStr( $copyArr[ "message" ] ); ?></span><br>
				                    <textarea name="message" class="textarea" cols="30" rows="10" style="width: 220px; height: 180px;" ><?= $message; ?></textarea>
				                  </p>
				                  
				                  <p>
				                  	<span class="small"><?= prepStr( $copyArr[ "email" ] ); ?></span><br />
				                    <input type="text" name="email" class="textbox" size="25" style="width: 220px;" value="<?= $email; ?>" /><br />
				                  </p>
				                  
				                  <p class="small"><?= ( $autoHTML == "Y" ? nl2br( prepStr( $extraContent ) ) : prepStr( $extraContent ) );	?></p>
				                  <a href="javascript:document.bunny.submit();"><img src="<?= $buttonArr[ "send" ][ 0 ]; ?>" width="<?= $buttonArr[ "send" ][ 1 ]; ?>" height="<?= $buttonArr[ "send" ][ 2 ]; ?>" border="0" alt="send" /></a> 
				                  <p>&nbsp; </p>
										<?	}	?>
			            		</td>
			                
			                <td align="center" valign="top" width="8"><img src="images/universal/spacer.gif" width="8" height="1" /></td>
			                
			                <td align="left" valign="top" width="167"><p class="small"><?= (!$submitted ? ( $autoHTML == "Y" ? nl2br( prepStr( $rightContent ) ) : prepStr( $rightContent ) ) : "");	?></p></td>
			              </tr>
			            </table>
			            <p>&nbsp;</p>
		            </form>
		        	</td>
		        </tr>
		        <tr><td valign="top" background="images/universal/gradient.gif" colspan="4"><img src="images/universal/spacer.gif" width="1" height="36" alt="" /></td></tr>
		        <tr><td background="images/universal/wheat.gif" colspan="6"><img src="images/universal/spacer.gif" width="1" height="9" alt="" /></td></tr>
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
<?	include( "nav_layers.php" );	?>
	</body>
</html>
