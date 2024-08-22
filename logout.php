<?php
    session_unset();
    $par = session_get_cookie_params();
    setcookie(session_name(), '', time()-99999, $par["path"],
    $par["domain"], $par["secure"], $par["httponly"]);
    session_destroy();
    header('Location: login.php');
?>