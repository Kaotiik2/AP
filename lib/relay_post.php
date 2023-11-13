<?php

namespace lib\utils;

function relay_post()
{

    $keys = array_keys($_POST);
    foreach ($keys as $key) {
        $value = $_POST[$key];
        echo "<input type='hidden' name='$key' value='$value' />";
    }
}
