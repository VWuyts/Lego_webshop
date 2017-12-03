/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 *
 * register.js
 */

// check input fields for registration
function checkRegister()
{
    var MIN_SHORT = 1;
    var MIN_LONG = 2;
    var MIN_NAME = 2;
    var MIN_PASSW = 8;
    var MAX_LONG = 50;
    var MAX_NAME = 50;
    var MAX_SHORT = 8;

    var firstname = document.getElementById("firstname").value;
    var surname = document.getElementById("surname").value;
    var email = document.getElementById("email").value;
    var passw = document.getElementById("passw").value;
    var street = document.getElementById("street").value;
    var hNumber = document.getElementById("hNumber").value;
    var box = document.getElementById("box").value;
    var postalCode = document.getElementById("postalCode").value;
    var city = document.getElementById("city").value;
    var country = document.getElementById("country").value;

    var firstnameOK = 1;
    var surnameOK = 1;
    var emailOK = 1;
    var passwOK = 1;
    var streetOK = 1;
    var hNumberOK = 1;
    var boxOK = 1;
    var postalCodeOK = 1;
    var cityOK = 1;
    var countryOK = 1;

    // check first name
    if (firstname == "")
    {
        firstnameOK = 1;
        document.getElementById("firstnameErr").innerHTML = "* First name is required";
    }
    else
    {
        if (firstname.length < MIN_NAME)
        {
            firstnameOK = 1;
            document.getElementById("firstnameErr").innerHTML = "* At least "+ MIN_NAME +" characters required";
        }
        else
        {
            if (firstname.length > MAX_NAME)
            {
                firstnameOK = 1;
                document.getElementById("firstnameErr").innerHTML = "* Maximum "+ MAX_NAME +" characters allowed";
            }
            else
            {
                firstnameOK = 0;
                document.getElementById("firstnameErr").innerHTML = "* ";
            }
        }
    }
    // check surname
    if (surname == "")
    {
        surnameOK = 1;
        document.getElementById("surnameErr").innerHTML = "* Surname is required";
    }
    else
    {
        if (surname.length < MIN_NAME)
        {
            surnameOK = 1;
            document.getElementById("surnameErr").innerHTML = "* At least "+ MIN_NAME +" characters required";
        }
        else
        {
            if (surname.length > MAX_NAME)
            {
                surnameOK = 1;
                document.getElementById("surnameErr").innerHTML = "* Maximum "+ MAX_NAME +" characters allowed";
            }
            else
            {
                surnameOK = 0;
                document.getElementById("surnameErr").innerHTML = "* ";
            }
        }
    }
    // check email
    if (email == "")
    {
        emailOK = 1;
        document.getElementById("emailErr").innerHTML = "* E-mail is required";
    }
    else
    {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
        {
            emailOK = 0;
            document.getElementById("emailErr").innerHTML = "* ";
        }
        else
        {
            emailOK = 1;
            document.getElementById("emailErr").innerHTML = "* Invalid e-mail format";
        }
    }
    // check password
    if (passw == "")
    {
        passwOK = 1;
        document.getElementById("passwErr").innerHTML = "* Password is required";
    }
    else
    {
        if (passw.length < MIN_PASSW)
        {
            passwOK = 1;
            document.getElementById("passwErr").innerHTML = "* At least "+ MIN_PASSW +" characters required";
        }
        else
        {
            if (!/[A-Z]/.test(passw))
            {
                passwOK = 1;
                document.getElementById("passwErr").innerHTML = "* At least 1 upper case letter required";
            }
            else
            {
                if (!/[a-z]/.test(passw))
                {
                    passwOK = 1;
                    document.getElementById("passwErr").innerHTML = "* At least 1 lower case letter required";
                }
                else
                {
                    if (!/[0-9]/.test(passw))
                    {
                        passwOK = 1;
                        document.getElementById("passwErr").innerHTML = "* At least 1 number required";
                    }
                    else
                    {
                        passwOK = 0;
                        document.getElementById("passwErr").innerHTML = "* ";
                    }
                }
                
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
    if (firstnameOK + surnameOK + emailOK + passwOK + 
        streetOK + hNumberOK + boxOK + postalCodeOK + cityOK + countryOK > 1)
    {
        return false;
    }
    return true;
}