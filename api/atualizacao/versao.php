<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../version.php';

requireAuth();

jsonResponse([
    'ok' => true,
    'data' => [
        'version' => INDUZI_VERSION,
        'date' => INDUZI_VERSION_DATE,
    ]
]);
