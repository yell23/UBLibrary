<?php
header('Content-Type: application/json');

$pythonPath = 'C:\Users\Noriecel\AppData\Local\Programs\Python\Python313-32\python.exe';
$scriptPath = __DIR__ . DIRECTORY_SEPARATOR . 'rfid_dcrf_post.py';
$heartbeatPath = __DIR__ . DIRECTORY_SEPARATOR . 'scanner_heartbeat.txt';

if (!is_file($scriptPath)) {
    echo json_encode(['ok' => false, 'message' => 'Helper script not found']);
    exit;
}

if (!is_file($pythonPath)) {
    echo json_encode(['ok' => false, 'message' => 'Python path not found. Update $pythonPath.']);
    exit;
}

if (is_file($heartbeatPath)) {
    $lastSeen = filemtime($heartbeatPath);
    if ($lastSeen && (time() - $lastSeen) <= 5) {
        echo json_encode(['ok' => true, 'message' => 'Scanner already running']);
        exit;
    }
}

$cmd = 'start "" /b ' . escapeshellarg($pythonPath) . ' ' . escapeshellarg($scriptPath);
@pclose(@popen($cmd, 'r'));

echo json_encode(['ok' => true, 'message' => 'Start command issued']);
