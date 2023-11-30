<?php

require_once "model/users.php";
require_once "lib/relay_post.php";

use lib\utils;

$result = model\new_pre_admission($_POST);

if (!$result) {
?>
    <form action="/views/admission/error.php" method="POST">
        <input type="hidden" name="error" value="<?php echo $result; ?>" />
        <input type="submit" />
    </form>
    <script defer>
        document.querySelector("form").submit();
    </script>
<?php
} else {
?>
    <form action="/views/admission/confirm_pre_admission.php" method="POST">
        <?php
        utils\relay_post();
        ?>
        <input type="submit" />
    </form>
    <script defer>
        document.querySelector("form").submit();
    </script>

<?php
}
