function initialise()
{
	var menuItem = document.getElementById("topmenu").getElementsByTagName("li");
		
	for (var i = 0; i < menuItem.length; i++)
	{
        if (menuItem[i].id != "nojs") {
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
}