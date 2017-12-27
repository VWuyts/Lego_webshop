/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 *
 * adminProductAdd.js
 */

// check input fields to add a product to the database
function checkProduct()
{
    var MAX_PRODUCTNO = 16777215; // max MEDIUM INT UNSIGNED
    var MAX_VARCHAR = 50;
    var MAX_PRICE = 9999.99;
    var MAX_AGE = 16;
    var MAX_TEXT = 65535; // max number of chars in TEXT
    var MAX_PIECES = 10000;
    var MIN_CHAR = 2;

    var productno = document.getElementById("productno").value;
    var pName = document.getElementById("pName").value;
    var price = document.getElementById("price").value;
    var minAge = document.getElementById("minAge").value;
    var description = document.getElementById("description").value;
    var category = document.getElementById("category").value;
    var pieces = document.getElementById("pieces").value;
    var themeID = document.getElementById("themeID").value;
    var sortID = document.getElementById("sortID").value;
    var labelID = document.getElementById("labelID").value;

    var productnoOK = 1;
    var pNameOK = 1;
    var priceOK = 1;
    var minAgeOK = 1;
    var descriptionOK = 1;
    var categoryOK = 1;
    var piecesOK = 1;
    var themeIDOK = 1;
    var sortIDOK = 1;
    var labelIDOK = 1;

    // check product number
    if (productno == "")
    {
        productno = 1;
        document.getElementById("productnoErr").innerHTML = "* Product number is required";
    }
    else
    {
        if (productno < 0)
        {
            productnoOK = 1;
            document.getElementById("productnoErr").innerHTML = "* Has to be greater than zero";
        }
        else
        {
            if (productno > MAX_PRODUCTNO)
            {
                productnoOK = 1;
                document.getElementById("productnoErr").innerHTML = "* Maximum "+ MAX_PRODUCTNO +" allowed";
            }
            else
            {
                productnoOK = 0;
                document.getElementById("productnoErr").innerHTML = "* ";
            }
        }
    }
    // check product name
    if (pName == "")
    {
        pNameOK = 1;
        document.getElementById("pNameErr").innerHTML = "* Product name  is required";
    }
    else
    {
        if (pName.length < MIN_CHAR)
        {
            pNameOK = 1;
            document.getElementById("pNameErr").innerHTML = "* At least "+ MIN_CHAR +" characters required";
        }
        else
        {
            if (pName.length > MAX_VARCHAR)
            {
                pNameOK = 1;
                document.getElementById("pNameErr").innerHTML = "* Maximum "+ MAX_VARCHAR +" characters allowed";
            }
            else
            {
                pNameOK = 0;
                document.getElementById("pNameErr").innerHTML = "* ";
            }
        }
    }
    // check price
    if (price == "")
    {
        priceOK = 1;
        document.getElementById("priceErr").innerHTML = "* Price is required";
    }
    else
    {
        if (price < 0)
        {
            priceOK = 1;
            document.getElementById("priceErr").innerHTML = "* Has to be greater than zero";
        }
        else
        {
            if (price > MAX_PRICE)
            {
                priceOK = 1;
                document.getElementById("priceErr").innerHTML = "* Maximum " + MAX_PRICE + " allowed";
            }
            else
            {
                priceOK = 0;
                document.getElementById("priceErr").innerHTML = "* ";
            }
        }
        
    }
    // check minimum age
    if (minAge == "")
    {
        minAgeOK = 1;
        document.getElementById("minAgeErr").innerHTML = "* Minimum age is required";
    }
    else
    {
        if (minAge < 0)
        {
            minAgeOK = 1;
            document.getElementById("minAgeErr").innerHTML = "* Has to be greater than zero";
        }
        else
        {
            if (minAge > MAX_AGE)
            {
                minAgeOK = 1;
                document.getElementById("minAgeErr").innerHTML = "* Maximum " + MAX_AGE + " allowed";
            }
            else
            {
                minAgeOK = 0;
                document.getElementById("minAgeErr").innerHTML = "* ";
            }
        }    
    }
    // check description
    if (description.trim() == "")
    {
        descriptionOK = 1;
        document.getElementById("descriptionErr").innerHTML = "* description is required";
    }
    else
    {
        if (description.length < MIN_CHAR)
        {
            descriptionOK = 1;
            document.getElementById("descriptionErr").innerHTML = "* At least "+ MIN_CHAR +" characters required";
        }
        else
        {
            if (description.length > MAX_TEXT)
            {
                descriptionOK = 1;
                document.getElementById("descriptionErr").innerHTML = "* Maximum "+ MAX_TEXT +" characters allowed";
            }
            else
            {
                descriptionOK = 0;
                document.getElementById("descriptionErr").innerHTML = "* ";
            }
        }
    }
    // check category
    if (category == "")
    {
        categoryOK = 1;
        document.getElementById("categoryErr").innerHTML = "* Category is required";
    }
    else
    {
        if (category != 'sets' && category != 'extras')
        {
            categoryOK = 1;
            document.getElementById("categoryErr").innerHTML = "* Has to be 'sets' or 'extras'";
        }
        else
        {
            categoryOK = 0;
            document.getElementById("categoryErr").innerHTML = "* ";
        }
    }
    // check pieces
    if (pieces < 0)
    {
        piecesOK = 1;
        document.getElementById("piecesErr").innerHTML = " Has to be greater than zero";
    }
    else
    {
        if (pieces > MAX_PIECES)
        {
            piecesOK = 1;
            document.getElementById("piecesErr").innerHTML = " Maximum" + MAX_PIECES + " allowed";
        }
        else
        {
            piecesOK = 0;
            document.getElementById("piecesErr").innerHTML = "";
        }
    }
    
    // check themeID
    if ((themeID == "" || themeID == 'not applicable') && category == 'sets')
    {
        themeIDOK = 1;
        document.getElementById("themeIDErr").innerHTML = " Theme is required for sets";
    }
    else
    {
        themeIDOK = 0;
        document.getElementById("themeIDErr").innerHTML = " ";
    }
    // check sortID
    if ((sortID == "" || sortID == 'not applicable') && category == 'sets')
    {
        sortOK = 1;
        document.getElementById("sortIDErr").innerHTML = " Interest is required for sets";
    }
    else
    {
        if (sortID < 0)
        {
            sortIDOK = 1;
            document.getElementById("sortIDErr").innerHTML = " Has to be greater than zero";
        }
        else
        {
            sortIDOK = 0;
            document.getElementById("sortIDErr").innerHTML = " ";
        }
    }
    // check labelID
    if (labelID < 0)
    {
        labelIDOK = 1;
        document.getElementById("labelID").innerHTML = " Has to be greater than zero";
    }
    else
    {
        labelIDOK = 0;
        document.getElementById("labelIDErr").innerHTML = " ";
    }

    // decide if OK to send to server
    if (productnoOK + pNameOK + priceOK + minAgeOK + descriptionOK + categoryOK + piecesOK + themeIDOK
        + sortIDOK + labelIDOK > 0)
    {
        return false;
    }
    else return true;
} // end function checkProduct