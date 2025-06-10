<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $logFile = __DIR__ . '/log.json';

   
    $logs = [];
    if (file_exists($logFile)) {
        $logs = json_decode(file_get_contents($logFile), true) ?: [];
    }

   
    $data['id'] = uniqid('txn_');
    $data['datetime'] = date('Y-m-d H:i:s');

    $logs[] = $data;

    file_put_contents($logFile, json_encode($logs, JSON_PRETTY_PRINT));
    echo 'logged';
}
?>