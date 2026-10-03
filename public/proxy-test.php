<?php

header('Content-Type: application/json');

echo json_encode([
    'HTTP_HOST'              => $_SERVER['HTTP_HOST'] ?? null,
    'REQUEST_SCHEME'         => $_SERVER['REQUEST_SCHEME'] ?? null,
    'HTTPS'                  => $_SERVER['HTTPS'] ?? null,
    'SERVER_PORT'            => $_SERVER['SERVER_PORT'] ?? null,
    'HTTP_X_FORWARDED_PROTO' => $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? null,
    'HTTP_X_FORWARDED_HOST'  => $_SERVER['HTTP_X_FORWARDED_HOST'] ?? null,
    'HTTP_X_FORWARDED_PORT'  => $_SERVER['HTTP_X_FORWARDED_PORT'] ?? null,
]);