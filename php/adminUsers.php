<?php
/* Lego Webshop
 *
 * Lab assignment for course PHP & MySQL 2017
 * Thomas More campus De Nayer
 * Bachelor Elektronica-ICT -- Application Development
 * 
 * Véronique Wuyts
 * 
 * Administrator page 
 */

    session_start();
    require_once("functions.php");
    require_once("errorHandling.php");
    require_once("exceptionHandling.php");
    require_once("../classes/Connection.php");
    require_once("../classes/RegisteredUser.php");
    
    // Check user role
    if (isset($_SESSION['role']) && $_SESSION['role'] === "admin")
    {
        createHead(true, "Legoshop | admin", ['admin'], NULL);
        createHeader(true, $_SESSION['firstname'], true);

        // create database connection
        $connection = new Connection();

        // process changes
        if (isset($_GET['role']))
        {
            $userID = htmlspecialchars($_GET['role']);
            RegisteredUser::changeRole($userID, $connection);
            unset($_GET['role']);
        }
        if (isset($_GET['active']))
        {
            $userID = htmlspecialchars($_GET['active']);
            RegisteredUser::changeStatus($userID, $connection);
            unset($_GET['active']);
        }

        // variables
        $usersArray = RegisteredUser::getAllUsers($connection);
?>
        <div class="center">
            <h1>Administrator: change role or status of users</h1>
        </div> <!-- end center -->
        <hr />
        <div class="center">
            <form action="<?php echo(htmlspecialchars($_SERVER['PHP_SELF'])); ?>" method="post">
            <a href=""></a>
                <table>
                    <tr>
                        <th>UserID</th>
                        <th>First name</th>
                        <th>Surname</th>
                        <th>E-mail</th>
                        <th>Role</th>
                        <th>Is active?</th>
                        <th>Change role</th>
                        <th>(In)activate</th>
                    </tr>
                <?php
                    for ($i = 0; $i < count($usersArray); $i++)
                    {
                        $userID = $usersArray[$i]->m_userID;
                        $isActive = $usersArray[$i]->m_isActive;
                        echo("\t\t\t\t\t<tr>\n");
                        echo("\t\t\t\t\t\t<td>". $userID."</td>\n");
                        echo("\t\t\t\t\t\t<td>". htmlspecialchars($usersArray[$i]->m_firstname) ."</td>\n");
                        echo("\t\t\t\t\t\t<td>". htmlspecialchars($usersArray[$i]->m_surname) ."</td>\n");
                        echo("\t\t\t\t\t\t<td>". htmlspecialchars($usersArray[$i]->m_email) ."</td>\n");
                        echo("\t\t\t\t\t\t<td>". $usersArray[$i]->m_role ."</td>\n");
                        echo("\t\t\t\t\t\t<td>". ($isActive > 0 ? "true" : "false") ."</td>\n");
                        if ($userID == $_SESSION['userID'])
                        {
                            echo("\t\t\t\t\t\t<td><span class='inactive'>Change role</span></td>\n");
                            echo("\t\t\t\t\t\t<td><span class='inactive'>Inactivate</span></td>\n");
                        }
                        else
                        {
                            echo("\t\t\t\t\t\t<td><a href='adminUsers.php?role=". $userID ."'>Change role</a></td>\n");
                            echo("\t\t\t\t\t\t<td><a href='adminUsers.php?active=". $userID ."'>".
                                ($isActive ? "Inactivate" : "Activate") ."</a></td>\n");
                        }
                        echo("\t\t\t\t\t</tr>\n");
                    }   
                ?>
                </table>
            </form>
        </div>
<?php
        // close database connection
        $connection->close();
        
        createFooter(true);
    }
    else
    {
        // Session variable is not set or role does not comply: user should not be on this page
        header("Location: ../index.php");
    }
?>