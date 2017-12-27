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
createHead(false, 'Legoshop | error', ['message'], ['message']);
createHeader(false, NULL, false);
?>
	<div class='center'>
		<p class='message'>Product number, product name, price, minimum age AND description are required.</p>
		<p class='message'>You will be redirected to the home page.</p>
		<p><a href='../index.php'>Back to home page</a></p>
	</div> <!-- end center -->
<?php
createFooter(false);
?>
