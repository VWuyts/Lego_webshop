/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 *
 * addAddress.js
 */

// check input fields for shipping address
function checkAddress()
{
    var MIN_SHORT = 1;
    var MIN_LONG = 2;
    var MIN_TAO = 2;
    var MAX_LONG = 50;
    var MAX_SHORT = 8;
    var MAX_TAO = 100;

    var tao = document.getElementById("tao").value;
    var street = document.getElementById("street").value;
    var hNumber = document.getElementById("hNumber").value;
    var box = document.getElementById("box").value;
    var postalCode = document.getElementById("postalCode").value;
    var city = document.getElementById("city").value;
    var country = document.getElementById("country").value;

    var taoOK = 1;
    var streetOK = 1;
    var hNumberOK = 1;
    var boxOK = 1;
    var postalCodeOK = 1;
    var cityOK = 1;
    var countryOK = 1;

    // check tao
    if (tao == "")
    {
        taoOK = 0;
        document.getElementById("taoErr").innerHTML = "";
    }
    else
    {
        if (tao.length < MIN_TAO)
        {
            taoOK = 1;
            document.getElementById("taoErr").innerHTML = " At least "+ MIN_TAO +" characters required";
        }
        else
        {
            if (tao.length > MAX_TAO)
            {
                taoOK = 1;
                document.getElementById("taoErr").innerHTML = " Maximum "+ MAX_TAO +" characters allowed";
            }
            else
            {
                taoOK = 0;
                document.getElementById("taoErr").innerHTML = "";
            }
        }
    }
    // check street
    if (street == "")
    {
        streetOK = 1;
        document.getElementById("streetErr").innerHTML = "* Street is required";
    }
    else
    {
        if (street.length < MIN_LONG)
        {
            streetOK = 1;
            document.getElementById("streetErr").innerHTML = "* At least "+ MIN_LONG +" characters required";
        }
        else
        {
            if (street.length > MAX_LONG)
            {
                streetOK = 1;
                document.getElementById("streetErr").innerHTML = "* Maximum "+ MAX_LONG +" characters allowed";
            }
            else
            {
                streetOK = 0;
                document.getElementById("streetErr").innerHTML = "* ";
            }
        }
    }
    // check hNumber
    if (hNumber == "")
    {
        hNumberOK = 1;
        document.getElementById("hNumberErr").innerHTML = "* Number is required";
    }
    else
    {
        if (hNumber.length < MIN_SHORT)
        {
            hNumberOK = 1;
            document.getElementById("hNumberErr").innerHTML = "* At least "+ MIN_SHORT +" character required";
        }
        else
        {
            if (hNumber.length > MAX_SHORT)
            {
                hNumberOK = 1;
                document.getElementById("hNumberErr").innerHTML = "* Maximum "+ MAX_SHORT +" characters allowed";
            }
            else
            {
                hNumberOK = 0;
                document.getElementById("hNumberErr").innerHTML = "* ";
            }
        }
    }
    // check box
    if (box.length > MAX_SHORT)
    {
        boxOK = 1;
        document.getElementById("boxErr").innerHTML = " Maximum "+ MAX_SHORT +" characters allowed";
    }
    else
    {
        boxOK = 0;
        document.getElementById("boxErr").innerHTML = "";
    }
    // check postal code
    if (postalCode == "")
    {
        postalCodeOK = 1;
        document.getElementById("postalCodeErr").innerHTML = "* Postal code is required";
    }
    else
    {
        if (postalCode.length < MIN_SHORT)
        {
            postalCodeOK = 1;
            document.getElementById("postalCodeErr").innerHTML = "* At least "+ MIN_SHORT +" character required";
        }
        else
        {
            if (postalCode.length > MAX_SHORT)
            {
                postalCodeOK = 1;
                document.getElementById("postalCodeErr").innerHTML = "* Maximum "+ MAX_SHORT +" characters allowed";
            }
            else
            {
                postalCodeOK = 0;
                document.getElementById("postalCodeErr").innerHTML = "* ";
            }
        }
    }
    // check city
    if (city == "")
    {
        cityOK = 1;
        document.getElementById("cityErr").innerHTML = "* City is required";
    }
    else
    {
        if (city.length < MIN_LONG)
        {
            cityOK = 1;
            document.getElementById("cityErr").innerHTML = "* At least "+ MIN_LONG +" characters required";
        }
        else
        {
            if (city.length > MAX_LONG)
            {
                cityOK = 1;
                document.getElementById("cityErr").innerHTML = "* Maximum "+ MAX_LONG +" characters allowed";
            }
            else
            {
                cityOK = 0;
                document.getElementById("cityErr").innerHTML = "* ";
            }
        }
    }
    // check country
    if (country == "")
    {
        countryOK = 1;
        document.getElementById("countryErr").innerHTML = "* Country is required";
    }
    else
    {
        if (country.length < MIN_LONG)
        {
            countryOK = 1;
            document.getElementById("countryErr").innerHTML = "* At least "+ MIN_LONG +" characters required";
        }
        else
        {
            if (country.length > MAX_LONG)
            {
                countryOK = 1;
                document.getElementById("countryErr").innerHTML = "* Maximum "+ MAX_LONG +" characters allowed";
            }
            else
            {
                countryOK = 0;
                document.getElementById("countryErr").innerHTML = "* ";
            }
        }
    }

    // decide if OK to send to server
    if (taoOK + streetOK + hNumberOK + boxOK + postalCodeOK + cityOK + countryOK > 0)
    {
        return false;
    }
    return true;
} // end function checkAddress