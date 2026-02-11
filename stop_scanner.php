<?php
header('Content-Type: application/json');

$pidPath = __DIR__ . DIRECTORY_SEPARATOR . 'scanner_pid.txt';

if (!is_file($pidPath)) {
    echo json_encode(['ok' => false, 'message' => 'No PID file found']);
    exit;
}

$pid = trim((string)file_get_contents($pidPath));
if ($pid === '') {
    echo json_encode(['ok' => false, 'message' => 'Empty PID']);
    exit;
}

$cmd = 'taskkill /F /PID ' . escapeshellarg($pid);
@pclose(@popen($cmd, 'r'));

echo json_encode(['ok' => true, 'message' => 'Stop command issued']);
