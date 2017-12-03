<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 *
 * Véronique Wuyts
 *
 * Error page
 */

require '../php/functions.php';
createHead(true, 'Legoshop | error', ['message'], ['message']);
createHeader(true, false);
?>
	<div class='center'>
		<p class='message'>The database connection failed.</p>
		<p class='message'>You will be redirected to the home page.</p>
		<p><a href='../php/home.php'>Back to home page</a></p>
	</div> <!-- end center -->
<?php
createFooter(true);
?>
