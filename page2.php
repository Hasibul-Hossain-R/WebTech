<?php
if (isset($_COOKIE['sectione'])) {
    echo "Cookie value: " . $_COOKIE['sectione'];
} else {
    echo "Cookie not set.";
}
?>