<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireMethod('POST');
$_SESSION = [];
session_destroy();
jsonResponse(['ok' => true, 'msg' => 'Sessao encerrada.']);
