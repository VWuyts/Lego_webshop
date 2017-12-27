/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * login.js
 */

function checkLogin()
{
    var MIN_PASSW = 8;
    var email = document.getElementById("email").value;
    var passw = document.getElementById("passw").value;
    var emailOK = 1;
    var passwOK = 1;

    // check email
    if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
    {
        emailOK = 1;
        document.getElementById("err").innerHTML = "The email you entered cannot be identified";
    }
    else
    {
        emailOK = 0;

        // check password
        if (passw.length < MIN_PASSW || !/[A-Z]/.test(passw) || !/[a-z]/.test(passw) || !/[0-9]/.test(passw))
        {
            passwOK = 1
            document.getElementById("err").innerHTML = "The password you entered was incorrect";
        }
        else
        {
            passwOK = 0;
            document.getElementById("err").innerHTML = "";
        }
    }
    
    // decide if OK to send to server
    if (emailOK + passwOK > 0)
    {
        return false;
    }
    return true;
} // end function checkLogin()
