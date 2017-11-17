/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 */

function initialise()
{
	var menuItem = document.getElementById("topmenu").getElementsByTagName("li");
		
	for (var i = 0; i < menuItem.length; i++)
	{
        menuItem[i].onmouseover=function()
        {
            this.className+=" float";
        }
        menuItem[i].onmouseout=function()
        {
            this.className=this.className.replace(new RegExp(" float\\b"), "");
        }
	}
}