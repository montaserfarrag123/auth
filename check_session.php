<?php

    if (!isset($_SESSION['User'])) {
        header('location: login.php');
    }

?>