<?php
header('Content-Type: application/json');

$response = [
    'success' => false,
    'records' => [],
    'message' => 'Database not configured'
];

// Database connection
$dbHost = getenv('RFID_DB_HOST') ?: 'localhost';
$dbName = getenv('RFID_DB_NAME') ?: 'UBAccess';
$dbUser = getenv('RFID_DB_USER') ?: 'root';
$dbPass = getenv('RFID_DB_PASS') ?: '';

if ($dbHost && $dbName && $dbUser) {
    try {
        $dsn = "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4";
        $pdo = new PDO($dsn, $dbUser, $dbPass ?: '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        
        // Get attendance records with student details
        // Order by most recent first
        $sql = "
            SELECT 
                a.AttendanceID,
                a.StudentID,
                s.FullName,
                s.Department,
                s.Course,
                s.PhotoUrl,
                a.Area,
                a.TimeIn,
                a.TimeOut,
                a.CreatedAt
            FROM Attendance a
            INNER JOIN Students s ON a.StudentID = s.StudentID
            ORDER BY a.TimeIn DESC
            LIMIT 1000
        ";
        
        $stmt = $pdo->query($sql);
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $response['success'] = true;
        $response['records'] = $records;
        $response['message'] = 'Success';
        $response['count'] = count($records);
        
    } catch (Throwable $e) {
        $response['success'] = false;
        $response['message'] = 'Database error: ' . $e->getMessage();
    }
} else {
    // Generate sample data for testing when DB is not configured
    $response['success'] = true;
    $response['records'] = [
        [
            'AttendanceID' => 1,
            'StudentID' => '2021-00001',
            'FullName' => 'Juan Dela Cruz',
            'Department' => 'CITCS',
            'Course' => 'BSIT',
            'PhotoUrl' => 'https://via.placeholder.com/250x300?text=Student+1',
            'Area' => 'Library',
            'TimeIn' => date('Y-m-d H:i:s', strtotime('-2 hours')),
            'TimeOut' => null,
            'CreatedAt' => date('Y-m-d H:i:s')
        ],
        [
            'AttendanceID' => 2,
            'StudentID' => '2021-00002',
            'FullName' => 'Maria Santos',
            'Department' => 'CEBA',
            'Course' => 'BSBA',
            'PhotoUrl' => 'https://via.placeholder.com/250x300?text=Student+2',
            'Area' => 'Library',
            'TimeIn' => date('Y-m-d H:i:s', strtotime('-3 hours')),
            'TimeOut' => date('Y-m-d H:i:s', strtotime('-1 hour')),
            'CreatedAt' => date('Y-m-d H:i:s')
        ],
        [
            'AttendanceID' => 3,
            'StudentID' => '2021-00003',
            'FullName' => 'Pedro Reyes',
            'Department' => 'CENG',
            'Course' => 'BSCE',
            'PhotoUrl' => 'https://via.placeholder.com/250x300?text=Student+3',
            'Area' => 'Library',
            'TimeIn' => date('Y-m-d H:i:s', strtotime('-4 hours')),
            'TimeOut' => date('Y-m-d H:i:s', strtotime('-30 minutes')),
            'CreatedAt' => date('Y-m-d H:i:s')
        ]
    ];
    $response['message'] = 'Using sample data (DB not configured)';
}

echo json_encode($response);