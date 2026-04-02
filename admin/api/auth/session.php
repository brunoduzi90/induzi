<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireMethod('GET');

if (!empty($_SESSION['induzi_user']['userId'])) {
    jsonResponse([
        'ok' => true,
        'loggedIn' => true,
        'user' => [
            'id'    => $_SESSION['induzi_user']['userId'],
            'nome'  => $_SESSION['induzi_user']['nome'],
            'email' => $_SESSION['induzi_user']['email'],
            'role'  => $_SESSION['induzi_user']['role'],
        ],
        'csrfToken' => $_SESSION['csrf_token'] ?? '',
    ]);
}

jsonResponse(['ok' => true, 'loggedIn' => false]);
