<?php
    session_start();
    session_destroy();
    header('Location: ../controllers/CombatController.php');
?>