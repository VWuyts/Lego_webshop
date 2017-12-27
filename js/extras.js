/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 *
 * extras.js
 */

function createQueryString(method) 
{
    var age = document.getElementsByName("age");
    var price = document.getElementsByName("price");
    var theme = document.getElementsByName("theme");
    var pieces = document.getElementsByName("pieces");
    var queryString = "where= WHERE category = 'extras' AND isActive = true";
    var i;
    var counter = 0;

    if (method == 'filter')
    {
        for (i = 0; i < age.length; i++)
        {
            if (age[i].checked == true)
            {
                if (counter == 0) queryString += " AND (";
                if (i == 0) queryString += " minAge < " + age[i].value;
                else
                {
                    if (counter > 0) queryString += " OR"
                    if (i == (age.length - 1)) queryString += " minAge >= " + age[i].value;
                    else queryString += " (minAge >= " + age[i - 1].value + " AND minAge < " + age[i].value + ")";
                }
                counter++;
            }
        }
        if (counter > 0) queryString += ")";
        counter = 0;
        for (i = 0; i < price.length; i++)
        {
            if (price[i].checked == true)
            {
                if (counter == 0) queryString += " AND (";
                if (i == 0) queryString += " price < " + price[i].value;
                else
                {
                    if (counter > 0) queryString += " OR"
                    if (i == (price.length - 1)) queryString += " price >= " + price[i].value;
                    else queryString += " (price >= " + price[i - 1].value + " AND price < " + price[i].value + ")";
                }
                counter++;
            }
        }
        if (counter > 0) queryString += ")";
        counter = 0;
        for (i = 0; i < theme.length; i++)
        {
            if (theme[i].checked == true)
            {
                if (counter == 0) queryString += " AND (";
                if (i == 0) queryString += " themeID = " + theme[i].value;
                else
                {
                    if (counter > 0) queryString += " OR"
                    queryString += " themeID = " + theme[i].value;
                }
                counter++;
            }
        }
        if (counter > 0) queryString += ")";
        counter = 0;
        for (i = 0; i < pieces.length; i++)
        {
            if (pieces[i].checked == true)
            {
                if (counter == 0) queryString += " AND (";
                if (i == 0) queryString += " pieces < " + pieces[i].value;
                else
                {
                    if (counter > 0) queryString += " OR"
                    if (i == (pieces.length - 1)) queryString += " pieces >= " + pieces[i].value;
                    else queryString += " (pieces >= " + pieces[i - 1].value + " AND pieces < " + pieces[i].value + ")";
                }
                counter++;
            }
        }
        if (counter > 0) queryString += ")";
        counter = 0;
    }
    else
    {
        for (i = 0; i < age.length; i++)
        {
            age[i].checked = false;
        }
        for (i = 0; i < price.length; i++)
        {
            price[i].checked = false;
        }
        for (i = 0; i < theme.length; i++)
        {
            theme[i].checked = false;
        }
        for (i = 0; i < pieces.length; i++)
        {
            pieces[i].checked = false;
        }
    }
    queryString += " ORDER BY productno;";
    
    return queryString;
} // end function createQueryString

function start(method)
{
    var queryString = "";

    xhr = new XMLHttpRequest();
    if (xhr == null)
    {
        alert ("Problem with creation of filter");
        return;
    }

    var url = "buildingSetsProcess.php?timeStamp=" + new Date().getTime();
    queryString = createQueryString(method);
    xhr.onreadystatechange = showAnswer;
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");    
    xhr.send(queryString);
} // end function start

function showAnswer()
{
    var setsContent = document.getElementById("setsContent");
    if (xhr.readyState == 4 && xhr.status == 200)
    {
      if(xhr.responseText)
      {
        setsContent.innerHTML = xhr.responseText;
      }
      else
      {
        setsContent.innerHTML = "No response from server";
      }
    }
    else
    {
        setsContent.innerHTML = "Not ready";
    }
} // end function showAnswer