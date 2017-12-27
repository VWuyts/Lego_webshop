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
createHead(false, 'Legoshop | message', ['message'], NULL);
createHeader(false, NULL, false);
?>
	<div class='center'>
		<p class='message'>You have been logged out.</p>
		<p><a href='../index.php'>Back to home page</a></p>
	</div> <!-- end center -->
<?php
createFooter(false);
?>
