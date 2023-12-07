<?php
require_once "../../model/security.php";
global $SECURITY_ADMIN_LEVEL;

$SECURITY_ADMIN_LEVEL->authorize();
?>

<!DOCTYPE html>
<html>

<head>
    <title>LPFS - Supprimer un utilisateur</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <td>Mail</td>
                <td>Nom</td>
                <td>Prénom</td>
                <td>Téléphone</td>
                <td>Date de naissance</td>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once "model/users.php";

            use model\User;

            $users = User::get_all();

            foreach ($users as $user) {
                $href = "/controller/user_action?action=delete&id=" . $user->id_user;
            ?>
                <tr>
                    <td><?php echo $user->mail ?></td>
                    <td><?php echo $user->name ?></td>
                    <td><?php echo $user->surname ?></td>
                    <td><?php echo $user->telephone ?></td>
                    <td><?php echo $user->birth ?></td>
                    <td>
                        <button>
                            <a href=<?php echo "\'$href\'" ?>>Supprimer</a>
                        </button>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>

</html>