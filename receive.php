<?php
// This file receives RFID scans from the hardware scanner
// POST parameter: uid (the RFID UID)

header('Content-Type: application/json');

$uid = $_POST['uid'] ?? '';

if ($uid !== '') {
    $logPath = __DIR__ . DIRECTORY_SEPARATOR . 'rfid.log';
    $lastUidPath = __DIR__ . DIRECTORY_SEPARATOR . 'last_uid.txt';
    
    // Log the scan with timestamp
    $timestamp = date('c');
    $logEntry = "{$timestamp} {$uid}\n";
    file_put_contents($logPath, $logEntry, FILE_APPEND);
    
    // Update the last scanned UID
    file_put_contents($lastUidPath, $uid);
    
    echo json_encode([
        'success' => true,
        'message' => 'RFID received',
        'uid' => $uid,
        'timestamp' => $timestamp
    ]);
} else {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Missing uid parameter'
    ]);
}
