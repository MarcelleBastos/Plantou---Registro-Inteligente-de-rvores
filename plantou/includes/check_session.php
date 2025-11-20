<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['is_admin']) {
        echo 'admin';
    } else {
        echo 'logado';
    }
} else {
    echo 'nao_logado';
}
?>
