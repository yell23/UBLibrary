<?php
header('Content-Type: application/json');

// Get the last scanned UID
$lastUidPath = __DIR__ . DIRECTORY_SEPARATOR . 'last_uid.txt';
$processedUidPath = __DIR__ . DIRECTORY_SEPARATOR . 'processed_uid.txt';

$currentUid = null;
$processedUid = null;
$newScan = false;

if (is_file($lastUidPath)) {
    $currentUid = trim((string)file_get_contents($lastUidPath));
}

if (is_file($processedUidPath)) {
    $processedUid = trim((string)file_get_contents($processedUidPath));
}

// Check if this is a new scan
if ($currentUid && $currentUid !== $processedUid) {
    $newScan = true;
    file_put_contents($processedUidPath, $currentUid);
}

$response = [
    'new_scan' => $newScan,
    'student' => null,
    'action' => null,
    'message' => 'No new scan'
];

if ($newScan && $currentUid) {
    // Database connection
    $dbHost = getenv('RFID_DB_HOST') ?: 'localhost';
    $dbName = getenv('RFID_DB_NAME') ?: 'UBAccess';
    $dbUser = getenv('RFID_DB_USER') ?: 'root'; // XAMPP default is 'root'
    $dbPass = getenv('RFID_DB_PASS') ?: '';
    
    if ($dbHost && $dbName && $dbUser) {
        try {
            $dsn = "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4";
            $pdo = new PDO($dsn, $dbUser, $dbPass ?: '', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
            
            // First, get student details to ensure they exist
            $studentStmt = $pdo->prepare("
                SELECT StudentID, RFID, FullName, Department, Course, PhotoUrl 
                FROM Students 
                WHERE RFID = ?
            ");
            $studentStmt->execute([$currentUid]);
            $student = $studentStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$student) {
                $response['message'] = 'RFID not registered';
                echo json_encode($response);
                exit;
            }
            
            // Call stored procedure to process attendance
            $area = 'Library'; // Default area
            $stmt = $pdo->prepare("CALL sp_ProcessAttendance(?, ?, @action, @time)");
            $stmt->execute([$currentUid, $area]);
            
            // CRITICAL FIX: Close the statement to clear any buffered results
            $stmt->closeCursor();
            
            // Get the output parameters
            $resultStmt = $pdo->query("SELECT @action as Action, @time as ActionTime");
            $result = $resultStmt->fetch(PDO::FETCH_ASSOC);
            $resultStmt->closeCursor();
            
            if ($result && $result['Action'] !== 'ERROR') {
    // NEW: Fetch the most recent Time In and Time Out for this student
            // FIX: Gumamit ng TimeIn at TimeOut columns imbes na Action/LogTime
    $historyStmt = $pdo->prepare("
        SELECT 
            MAX(TimeIn) as last_in,
            MAX(TimeOut) as last_out
        FROM Attendance 
        WHERE RFID = ? AND DATE(TimeIn) = CURDATE()
    ");
                $historyStmt->execute([$currentUid]);
                $history = $historyStmt->fetch(PDO::FETCH_ASSOC);

                     $response['student'] = [
                    'student_id' => $student['StudentID'],
                      'rfid' => $currentUid,
                     'name' => $student['FullName'],
                     'department' => $student['Department'],
                     'course' => $student['Course'],
                     'photo_url' => $student['PhotoUrl'],
            // Add these two lines:
                      'last_in' => $history['last_in'] ? date('h:i A', strtotime($history['last_in'])) : '--:-- --',
                         'last_out' => $history['last_out'] ? date('h:i A', strtotime($history['last_out'])) : '--:-- --'
                ];
                $response['action'] = $result['Action'];
                $response['action_time'] = $result['ActionTime'];
                $response['message'] = $result['Action'] === 'TIME_IN' ? 'Welcome!' : 'Goodbye!';
            } else {
                $response['message'] = 'Error processing attendance';
            }
            
        } catch (PDOException $e) {
            $response['message'] = 'Database error: ' . $e->getMessage();
            error_log('Database error in process_scan.php: ' . $e->getMessage());
        } catch (Throwable $e) {
            $response['message'] = 'System error: ' . $e->getMessage();
            error_log('System error in process_scan.php: ' . $e->getMessage());
        }
    } else {
        // No database configured - return basic info
        $response['student'] = [
            'student_id' => 'N/A',
            'rfid' => $currentUid,
            'name' => 'Database Not Configured',
            'department' => 'Please set environment variables',
            'course' => 'RFID_DB_HOST, RFID_DB_NAME, RFID_DB_USER, RFID_DB_PASS',
            'photo_url' => null
        ];
        $response['action'] = 'TIME_IN';
        $response['message'] = 'Scanned (DB not configured)';
    }
}

echo json_encode($response);