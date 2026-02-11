<?php
header('Content-Type: application/json');

$heartbeatPath = __DIR__ . DIRECTORY_SEPARATOR . 'scanner_heartbeat.txt';
$pidPath = __DIR__ . DIRECTORY_SEPARATOR . 'scanner_pid.txt';

$status = 'stopped';
$lastSeen = null;
$pid = null;

if (is_file($heartbeatPath)) {
    $lastSeen = filemtime($heartbeatPath);
    if ($lastSeen && (time() - $lastSeen) <= 5) {
        $status = 'running';
    }
}

if (is_file($pidPath)) {
    $pid = trim((string)file_get_contents($pidPath));
}

echo json_encode([
    'status' => $status,
    'last_seen' => $lastSeen,
    'pid' => $pid,
]);
