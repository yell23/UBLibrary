<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UBAccess - Library Attendance System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            /* UB Brand Colors */
            --ub-maroon: #800000;
            --ub-gold: #FFD700;
            --ub-dark: #1a1a1a;
            --ub-light: #ffffff;
            --ub-gray: #f5f5f5;
            --ub-border: #e0e0e0;
            --ub-text: #2d2d2d;
            --ub-text-light: #666666;
            
            /* Accent colors */
            --success: #059669;
            --error: #dc2626;
            --warning: #f59e0b;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Urbanist', sans-serif;
            background: var(--ub-dark);
            color: var(--ub-text);
            overflow: hidden;
            position: relative;
        }
        
        /* Background Pattern */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                linear-gradient(135deg, var(--ub-maroon) 0%, #2d0000 100%);
            opacity: 1;
            z-index: 0;
        }
        
        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                repeating-linear-gradient(
                    45deg,
                    transparent,
                    transparent 10px,
                    rgba(255, 215, 0, 0.02) 10px,
                    rgba(255, 215, 0, 0.02) 20px
                );
            z-index: 1;
            pointer-events: none;
        }
        
        .container {
            position: relative;
            z-index: 2;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Header */
        .header {
            background: rgba(26, 26, 26, 0.95);
            border-bottom: 3px solid var(--ub-gold);
            padding: 1.5rem 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            backdrop-filter: blur(10px);
        }
        
        .logo-section {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .logo-box {
            width: 60px;
            height: 60px;
            background: var(--ub-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--ub-maroon);
            letter-spacing: -2px;
            transform: rotate(-5deg);
        }
        
        .brand {
            display: flex;
            flex-direction: column;
        }
        
        .brand-name {
            font-size: 2rem;
            font-weight: 800;
            color: var(--ub-light);
            letter-spacing: -1px;
        }
        
        .brand-subtitle {
            font-size: 0.9rem;
            color: var(--ub-gold);
            font-weight: 500;
            letter-spacing: 3px;
            text-transform: uppercase;
        }
        
        .datetime-display {
            text-align: right;
        }
        
        .current-date {
            font-size: 0.95rem;
            color: var(--ub-gold);
            font-weight: 600;
            letter-spacing: 1px;
            font-family: 'JetBrains Mono', monospace;
        }
        
        .current-time {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--ub-light);
            font-family: 'JetBrains Mono', monospace;
            letter-spacing: 2px;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            position: relative;
        }
        
        /* Idle State */
        .idle-state {
            text-align: center;
            animation: fadeIn 1s ease-out;
        }
        
        .scan-icon {
            width: 200px;
            height: 200px;
            margin: 0 auto 2rem;
            background: rgba(255, 215, 0, 0.1);
            border: 4px dashed var(--ub-gold);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            animation: pulse 2s ease-in-out infinite;
        }
        
        .scan-icon svg {
            width: 100px;
            height: 100px;
            color: var(--ub-gold);
        }
        
        .idle-message {
            font-size: 2rem;
            font-weight: 600;
            color: var(--ub-light);
            margin-bottom: 1rem;
        }
        
        .idle-subtitle {
            font-size: 1.2rem;
            color: var(--ub-gold);
            opacity: 0.8;
        }
        
        /* Student Card */
        .student-card {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 30px;
            padding: 3rem;
            max-width: 1000px;
            width: 100%;
            display: none;
            animation: slideIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.5),
                0 0 0 1px rgba(255, 215, 0, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .student-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--ub-maroon) 0%, var(--ub-gold) 100%);
        }
        
        .student-card.show {
            display: block;
        }
        
        .card-header {
            display: flex;
            gap: 3rem;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid var(--ub-border);
        }
        
        .photo-container {
            flex-shrink: 0;
        }
        
        .student-photo {
            width: 200px;
            height: 240px;
            border-radius: 15px;
            object-fit: cover;
            border: 4px solid var(--ub-maroon);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .photo-placeholder {
            width: 200px;
            height: 240px;
            border-radius: 15px;
            background: var(--ub-gray);
            border: 4px solid var(--ub-border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ub-text-light);
            font-size: 0.9rem;
        }
        
        .student-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .student-name {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--ub-maroon);
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }
        
        .student-id {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--ub-text-light);
            font-family: 'JetBrains Mono', monospace;
            margin-bottom: 1.5rem;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
        }
        
        .info-label {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--ub-text-light);
        }
        
        .info-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--ub-text);
        }
        
        .status-section {
            background: var(--ub-gray);
            border-radius: 15px;
            padding: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .status-badge {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .status-indicator {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .status-indicator.time-in {
            background: rgba(5, 150, 105, 0.1);
        }
        
        .status-indicator.time-out {
            background: rgba(220, 38, 38, 0.1);
        }
        
        .status-indicator svg {
            width: 40px;
            height: 40px;
        }
        
        .status-indicator.time-in svg {
            color: var(--success);
        }
        
        .status-indicator.time-out svg {
            color: var(--error);
        }
        
        .status-text {
            display: flex;
            flex-direction: column;
        }
        
        .status-label {
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--ub-text-light);
        }
        
        .status-action {
            font-size: 2rem;
            font-weight: 800;
            color: var(--ub-maroon);
        }
        
        .timestamp {
            text-align: right;
        }
        
        .timestamp-label {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--ub-text-light);
            margin-bottom: 0.3rem;
        }
        
        .timestamp-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--ub-maroon);
            font-family: 'JetBrains Mono', monospace;
        }
        
        /* Progress Bar */
        .progress-bar {
            width: 100%;
            height: 4px;
            background: var(--ub-border);
            border-radius: 2px;
            overflow: hidden;
            margin-top: 2rem;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--ub-maroon) 0%, var(--ub-gold) 100%);
            width: 0%;
            transition: width 0.1s linear;
        }
        
        /* Footer */
        .footer {
            background: rgba(26, 26, 26, 0.95);
            border-top: 2px solid rgba(255, 215, 0, 0.2);
            padding: 1rem 3rem;
            text-align: center;
            color: var(--ub-gold);
            font-size: 0.9rem;
            backdrop-filter: blur(10px);
        }
        
        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(30px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }
        }
        
        /* Admin Link */
        .admin-link {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1000;
            background: var(--ub-gold);
            color: var(--ub-maroon);
            padding: 1rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 20px rgba(255, 215, 0, 0.4);
            transition: all 0.3s ease;
        }
        
        .admin-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 30px rgba(255, 215, 0, 0.6);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-section">
                <div class="logo-box">UB</div>
                <div class="brand">
                    <div class="brand-name">UBAccess</div>
                    <div class="brand-subtitle">Library Attendance</div>
                </div>
            </div>
            <div class="datetime-display">
                <div class="current-date" id="currentDate"></div>
                <div class="current-time" id="currentTime"></div>
            </div>
        </div>
        
        <div class="main-content">
            <div class="idle-state" id="idleState">
                <div class="scan-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                </div>
                <div class="idle-message">Ready to Scan</div>
                <div class="idle-subtitle">Tap your ID card on the scanner</div>
                <div class="idle-subtitle" style="margin-top: 1rem; font-size: 0.95rem; opacity: 0.7;">
                    Please wait a few seconds between scans
                </div>
            </div>
            
            <div class="student-card" id="studentCard">
                <div class="card-header">
                    <div class="photo-container">
                        <img class="student-photo" id="studentPhoto" style="display: none;" alt="Student Photo">
                        <div class="photo-placeholder" id="photoPlaceholder">No Photo</div>
                    </div>
                    <div class="student-info">
                        <div class="student-name" id="studentName">—</div>
                        <div class="student-id" id="studentIdDisplay">—</div>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Department</div>
                                <div class="info-value" id="studentDept">—</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Course</div>
                                <div class="info-value" id="studentCourse">—</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label" style="color: var(--success);">Today's Time In</div>
                                <div class="info-value" id="todayTimeIn">--:-- --</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label" style="color: var(--error);">Today's Time Out</div>
                                <div class="info-value" id="todayTimeOut">--:-- --</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="status-section">
                    <div class="status-badge">
                        <div class="status-indicator" id="statusIndicator">
                            <svg id="statusIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                        </div>
                        <div class="status-text">
                            <div class="status-label">Status</div>
                            <div class="status-action" id="statusAction">TIME IN</div>
                        </div>
                    </div>
                    <div class="timestamp">
                        <div class="timestamp-label">Timestamp</div>
                        <div class="timestamp-value" id="timestampValue">--:--:--</div>
                    </div>
                </div>
                
                <div class="progress-bar">
                    <div class="progress-fill" id="progressFill"></div>
                </div>
            </div>
        </div>
        
        <div class="footer">
            University of BATANGAS • Library Attendance System • 2026
        </div>
    </div>
    
    <a href="admin.php" class="admin-link" style="display: none;">Admin Dashboard</a>
    
    <script>
        let displayTimeout;
        let progressInterval;
        const DISPLAY_DURATION = 5000; // 15 seconds
        
        // Update date and time
        function updateDateTime() {
            const now = new Date();
            
            // Format date
            const dateOptions = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            document.getElementById('currentDate').textContent = 
                now.toLocaleDateString('en-US', dateOptions).toUpperCase();
            
            // Format time (12-hour)
            const timeOptions = {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            };
            document.getElementById('currentTime').textContent = 
                now.toLocaleTimeString('en-US', timeOptions);
        }
        
        // Show student card with data
        function showStudentCard(data) {
            const idleState = document.getElementById('idleState');
            const studentCard = document.getElementById('studentCard');
            
            // Update student info
            document.getElementById('studentName').textContent = data.name || 'Unknown Student';
            document.getElementById('studentIdDisplay').textContent = data.student_id || 'N/A';
            document.getElementById('studentDept').textContent = data.department || 'N/A';
            document.getElementById('studentCourse').textContent = data.course || 'N/A';

            document.getElementById('todayTimeIn').textContent = data.last_in || '--:-- --';
            document.getElementById('todayTimeOut').textContent = data.last_out || '--:-- --';
            
            // Update photo
            // Update photo - skip images for now
         const photo = document.getElementById('studentPhoto');
         const placeholder = document.getElementById('photoPlaceholder');
         photo.style.display = 'none';
         placeholder.style.display = 'flex';
            
            // Update status
            const statusIndicator = document.getElementById('statusIndicator');
            const statusAction = document.getElementById('statusAction');
            const statusIcon = document.getElementById('statusIcon');
            
            if (data.action === 'TIME_IN') {
                statusIndicator.className = 'status-indicator time-in';
                statusAction.textContent = 'TIME IN';
                statusIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />';
            } else {
                statusIndicator.className = 'status-indicator time-out';
                statusAction.textContent = 'TIME OUT';
                statusIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />';
            }
            
            // Update timestamp
            const now = new Date();
            const timeStr = now.toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit',
                hour12: true 
            });
            document.getElementById('timestampValue').textContent = timeStr;
            
            // Show card
            idleState.style.display = 'none';
            studentCard.classList.add('show');
            
            // Start progress bar
            startProgress();
            
            // Auto-hide after duration
            clearTimeout(displayTimeout);
            displayTimeout = setTimeout(() => {
                hideStudentCard();
            }, DISPLAY_DURATION);
        }
        
        // Hide student card
        function hideStudentCard() {
            const idleState = document.getElementById('idleState');
            const studentCard = document.getElementById('studentCard');
            
            studentCard.classList.remove('show');
            idleState.style.display = 'block';
            
            clearInterval(progressInterval);
            document.getElementById('progressFill').style.width = '0%';
        }
        
        // Progress bar animation
        function startProgress() {
            clearInterval(progressInterval);
            const progressFill = document.getElementById('progressFill');
            let progress = 0;
            const increment = 100 / (DISPLAY_DURATION / 100);
            
            progressInterval = setInterval(() => {
                progress += increment;
                if (progress >= 100) {
                    progress = 100;
                    clearInterval(progressInterval);
                }
                progressFill.style.width = progress + '%';
            }, 100);
        }
        
        // Poll for scans
        // Poll for scans
async function pollForScans() {
    try {
        const response = await fetch('process_scan.php', {
            cache: 'no-store'
        });
        
        // Check if response is valid JSON
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        // CASE 1: Successful Scan
        if (data.new_scan && data.student) {
            showStudentCard({
                uid: data.student.rfid,
                student_id: data.student.student_id,
                name: data.student.name,
                department: data.student.department,
                course: data.student.course,
                photo_url: data.student.photo_url,
                action: data.action,
                last_in: data.student.last_in,
                last_out: data.student.last_out
            });
        } 
        // CASE 2: Scan detected but ID not registered
        else if (data.new_scan && !data.student) {
            alert("Card Scanned: " + data.message); // O kaya gumamit ng custom modal
            console.log("Unregistered card scanned");
        }
        
    } catch (error) {
        console.error('Polling error:', error);
    }
}
        
        // Initialize
        updateDateTime();
        setInterval(updateDateTime, 1000);
        setInterval(pollForScans, 1000);
    </script>
</body>
</html>