<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 *
 * Véronique Wuyts
 *
 * Message page
 */

require '../php/functions.php';
createHead(true, 'Legoshop | message', ['message'], NULL);
createHeader(true, NULL);
?>
	<div class='center'>
		<p class='message'>Your Lego account has been created.</p>
		<p class='message'>You can now sign in.</p>
		<p><a href='../php/home.php'>Back to home page</a></p>
	</div> <!-- end center -->
<?php
createFooter(true);
?>
