<!DOCTYPE html>
<html>
<head>
    <title>Simple Scanner Test - No Images</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: #1a1a1a;
            color: #fff;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        h1 {
            color: #FFD700;
            margin-bottom: 20px;
        }
        .status-box {
            background: #2a2a2a;
            border: 3px solid #FFD700;
            padding: 30px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
        }
        .waiting {
            border-color: #666;
            color: #999;
        }
        .time-in {
            border-color: #00ff00;
            background: #003300;
            animation: pulse 1s;
        }
        .time-out {
            border-color: #ff6b6b;
            background: #330000;
            animation: pulse 1s;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .student-info {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }
        .action {
            font-size: 48px;
            font-weight: bold;
            margin: 20px 0;
        }
        .details {
            background: #000;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: left;
            font-family: 'Courier New', monospace;
            font-size: 14px;
        }
        .poll-info {
            color: #666;
            font-size: 12px;
            margin-top: 10px;
        }
        button {
            background: #FFD700;
            color: #800000;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px;
        }
        button:hover {
            background: #FFC700;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Simple Scanner Test (No Image Dependencies)</h1>
        
        <div id="statusBox" class="status-box waiting">
            <div class="action" id="action">READY TO SCAN</div>
            <div class="student-info" id="studentInfo">Tap your ID card</div>
            <div class="poll-info">Polling: <span id="pollCount">0</span> | Last: <span id="lastTime">-</span></div>
        </div>

        <div class="details">
            <strong>Latest Response:</strong>
            <pre id="response">Waiting for scan...</pre>
        </div>

        <div style="text-align: center;">
            <button onclick="location.href='index.php'">← Back to Main Interface</button>
            <button onclick="testNow()">🧪 Check Now</button>
            <button onclick="location.href='debug_attendance.php'">🔧 Debug Tool</button>
        </div>
    </div>

    <script>
        let pollCount = 0;
        let lastScanData = null;

        async function checkForScan() {
            pollCount++;
            document.getElementById('pollCount').textContent = pollCount;
            document.getElementById('lastTime').textContent = new Date().toLocaleTimeString();

            try {
                const response = await fetch('process_scan.php?t=' + Date.now(), {
                    cache: 'no-store'
                });
                const data = await response.json();

                // Always show raw response
                document.getElementById('response').textContent = JSON.stringify(data, null, 2);

                if (data.new_scan && data.student) {
                    // New scan detected!
                    const statusBox = document.getElementById('statusBox');
                    const action = document.getElementById('action');
                    const studentInfo = document.getElementById('studentInfo');

                    // Determine action
                    const isTimeIn = data.action === 'TIME_IN';
                    
                    // Update display
                    statusBox.className = isTimeIn ? 'status-box time-in' : 'status-box time-out';
                    action.textContent = data.action || 'UNKNOWN ACTION';
                    studentInfo.innerHTML = `
                        ${data.student.name}<br>
                        <span style="font-size: 16px;">
                            ${data.student.student_id} | ${data.student.department}<br>
                            RFID: ${data.student.rfid}
                        </span>
                    `;

                    // Store for debugging
                    lastScanData = data;
                    console.log('Scan detected:', data);

                    // Reset after 5 seconds
                    setTimeout(() => {
                        statusBox.className = 'status-box waiting';
                        action.textContent = 'READY TO SCAN';
                        studentInfo.textContent = 'Tap your ID card';
                    }, 5000);

                } else if (data.message && data.message !== 'No new scan') {
                    // Error or other message
                    console.warn('Scanner message:', data.message);
                }

            } catch (error) {
                console.error('Poll error:', error);
                document.getElementById('response').textContent = 'ERROR: ' + error.message;
            }
        }

        function testNow() {
            checkForScan();
        }

        // Start polling every 1 second
        setInterval(checkForScan, 1000);
        checkForScan(); // Initial check
    </script>
</body>
</html>
