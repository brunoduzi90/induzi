<?php
/**
 * API Analytics do Painel — INDUZI
 */
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/analytics-data.php';

requireMethod('GET');
requireAuth();
session_write_close();

jsonResponse(getAnalyticsData(getDB()));
