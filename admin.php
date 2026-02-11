<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UBAccess - Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --ub-maroon: #800000;
            --ub-gold: #FFD700;
            --ub-dark: #1a1a1a;
            --ub-light: #ffffff;
            --ub-gray: #f5f5f5;
            --ub-border: #e0e0e0;
            --ub-text: #2d2d2d;
            --ub-text-light: #666666;
            --success: #059669;
            --error: #dc2626;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Urbanist', sans-serif;
            background: var(--ub-gray);
            color: var(--ub-text);
        }
        
        /* Header */
        .header {
            background: var(--ub-maroon);
            padding: 1.5rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-content {
            max-width: 1600px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .logo-box {
            width: 50px;
            height: 50px;
            background: var(--ub-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.2rem;
            color: var(--ub-maroon);
            letter-spacing: -2px;
            transform: rotate(-5deg);
        }
        
        .brand {
            color: var(--ub-light);
        }
        
        .brand-name {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        
        .brand-subtitle {
            font-size: 0.75rem;
            color: var(--ub-gold);
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        
        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-primary {
            background: var(--ub-gold);
            color: var(--ub-maroon);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: var(--ub-light);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
        }
        
        /* Main Container */
        .container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: var(--ub-light);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--ub-maroon);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card.gold {
            border-left-color: var(--ub-gold);
        }
        
        .stat-card.success {
            border-left-color: var(--success);
        }
        
        .stat-card.error {
            border-left-color: var(--error);
        }
        
        .stat-label {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--ub-text-light);
            margin-bottom: 0.5rem;
        }
        
        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--ub-maroon);
            font-family: 'JetBrains Mono', monospace;
        }
        
        .stat-subtitle {
            font-size: 0.8rem;
            color: var(--ub-text-light);
            margin-top: 0.5rem;
        }
        
        /* Filters */
        .filters-section {
            background: var(--ub-light);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .filters-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .filters-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--ub-maroon);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .filter-label {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--ub-text-light);
        }
        
        .filter-input,
        .filter-select {
            padding: 0.75rem;
            border: 2px solid var(--ub-border);
            border-radius: 8px;
            font-family: 'Urbanist', sans-serif;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        
        .filter-input:focus,
        .filter-select:focus {
            outline: none;
            border-color: var(--ub-maroon);
        }
        
        .filter-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }
        
        .btn-filter {
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-apply {
            background: var(--ub-maroon);
            color: var(--ub-light);
        }
        
        .btn-apply:hover {
            background: #600000;
        }
        
        .btn-reset {
            background: transparent;
            color: var(--ub-text-light);
            border: 2px solid var(--ub-border);
        }
        
        .btn-reset:hover {
            border-color: var(--ub-text-light);
        }
        
        /* Table Section */
        .table-section {
            background: var(--ub-light);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .table-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--ub-maroon);
        }
        
        .last-updated {
            font-size: 0.85rem;
            color: var(--ub-text-light);
            font-family: 'JetBrains Mono', monospace;
        }
        
        .table-wrapper {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background: var(--ub-gray);
        }
        
        th {
            padding: 1rem;
            text-align: left;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--ub-maroon);
            border-bottom: 2px solid var(--ub-border);
        }
        
        td {
            padding: 1rem;
            border-bottom: 1px solid var(--ub-border);
            font-size: 0.95rem;
        }
        
        tbody tr {
            transition: background 0.2s ease;
        }
        
        tbody tr:hover {
            background: rgba(128, 0, 0, 0.03);
        }
        
        .student-photo-thumb {
            width: 40px;
            height: 48px;
            border-radius: 6px;
            object-fit: cover;
            border: 2px solid var(--ub-border);
        }
        
        .badge {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .badge-in {
            background: rgba(5, 150, 105, 0.1);
            color: var(--success);
        }
        
        .badge-out {
            background: rgba(220, 38, 38, 0.1);
            color: var(--error);
        }
        
        .mono {
            font-family: 'JetBrains Mono', monospace;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--ub-text-light);
        }
        
        .empty-state svg {
            width: 80px;
            height: 80px;
            margin-bottom: 1rem;
            opacity: 0.3;
        }
        
        .empty-state-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .empty-state-text {
            font-size: 0.95rem;
        }
        
        /* Loading */
        .loading {
            text-align: center;
            padding: 2rem;
            color: var(--ub-text-light);
        }
        
        .spinner {
            display: inline-block;
            width: 40px;
            height: 40px;
            border: 4px solid var(--ub-border);
            border-top-color: var(--ub-maroon);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .filters-grid {
                grid-template-columns: 1fr;
            }
            
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }
            
            .header-actions {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <div class="logo-section">
                <div class="logo-box">UB</div>
                <div class="brand">
                    <div class="brand-name">UBAccess Admin</div>
                    <div class="brand-subtitle">Dashboard & Reports</div>
                </div>
            </div>
            <div class="header-actions">
                <button class="btn btn-primary" onclick="exportReport()">
                    <span>📊 Export Report</span>
                </button>
                <a href="index.php" class="btn btn-secondary">
                    <span>← Back to Scanner</span>
                </a>
            </div>
        </div>
    </div>
    
    <div class="container">
        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Visits Today</div>
                <div class="stat-value" id="totalVisits">0</div>
                <div class="stat-subtitle">All time-ins recorded</div>
            </div>
            <div class="stat-card gold">
                <div class="stat-label">Unique Visitors</div>
                <div class="stat-value" id="uniqueVisitors">0</div>
                <div class="stat-subtitle">Different students</div>
            </div>
            <div class="stat-card success">
                <div class="stat-label">Currently Inside</div>
                <div class="stat-value" id="currentlyInside">0</div>
                <div class="stat-subtitle">Active sessions</div>
            </div>
            <div class="stat-card error">
                <div class="stat-label">Completed Sessions</div>
                <div class="stat-value" id="completedSessions">0</div>
                <div class="stat-subtitle">With time-out</div>
            </div>
        </div>
        
        <!-- Filters -->
        <div class="filters-section">
            <div class="filters-header">
                <div class="filters-title">
                    <span>🔍</span>
                    <span>Filter Attendance</span>
                </div>
            </div>
            <div class="filters-grid">
                <div class="filter-group">
                    <label class="filter-label">Department</label>
                    <select class="filter-select" id="filterDept">
                        <option value="">All Departments</option>
                        <option value="CITCS">CITCS</option>
                        <option value="CEBA">CEBA</option>
                        <option value="CENG">CENG</option>
                        <option value="CHSN">CHSN</option>
                        <option value="CAS">CAS</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Course</label>
                    <input type="text" class="filter-input" id="filterCourse" placeholder="e.g., BSIT">
                </div>
                <div class="filter-group">
                    <label class="filter-label">Area</label>
                    <select class="filter-select" id="filterArea">
                        <option value="">All Areas</option>
                        <option value="Library">Library</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Status</label>
                    <select class="filter-select" id="filterStatus">
                        <option value="">All Status</option>
                        <option value="in">Currently Inside</option>
                        <option value="out">Completed</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Date From</label>
                    <input type="date" class="filter-input" id="filterDateFrom">
                </div>
                <div class="filter-group">
                    <label class="filter-label">Date To</label>
                    <input type="date" class="filter-input" id="filterDateTo">
                </div>
            </div>
            <div class="filter-actions">
                <button class="btn-filter btn-reset" onclick="resetFilters()">Reset</button>
                <button class="btn-filter btn-apply" onclick="applyFilters()">Apply Filters</button>
            </div>
        </div>
        
        <!-- Table -->
        <div class="table-section">
            <div class="table-header">
                <div class="table-title">Attendance Records</div>
                <div class="last-updated">Last updated: <span id="lastUpdated">--:--:--</span></div>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Student ID</th>
                            <th>Full Name</th>
                            <th>Department</th>
                            <th>Course</th>
                            <th>Area</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Duration</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="attendanceTableBody">
                        <tr>
                            <td colspan="10">
                                <div class="loading">
                                    <div class="spinner"></div>
                                    <div style="margin-top: 1rem;">Loading attendance data...</div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
        let attendanceData = [];
        let filteredData = [];
        
        // Format date/time
        function formatDateTime(dateString) {
            if (!dateString) return '—';
            const date = new Date(dateString);
            return date.toLocaleString('en-US', {
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            });
        }
        
        // Calculate duration
        function calculateDuration(timeIn, timeOut) {
            if (!timeIn) return '—';
            
            const start = new Date(timeIn);
            const end = timeOut ? new Date(timeOut) : new Date();
            const diff = Math.floor((end - start) / 1000 / 60); // minutes
            
            if (diff < 60) return `${diff}m`;
            const hours = Math.floor(diff / 60);
            const minutes = diff % 60;
            return `${hours}h ${minutes}m`;
        }
        
        // Update stats
        function updateStats() {
            const today = attendanceData.filter(record => {
                const recordDate = new Date(record.TimeIn).toDateString();
                const todayDate = new Date().toDateString();
                return recordDate === todayDate;
            });
            
            document.getElementById('totalVisits').textContent = today.length;
            
            const uniqueStudents = new Set(today.map(r => r.StudentID));
            document.getElementById('uniqueVisitors').textContent = uniqueStudents.size;
            
            const currentlyInside = today.filter(r => !r.TimeOut).length;
            document.getElementById('currentlyInside').textContent = currentlyInside;
            
            const completed = today.filter(r => r.TimeOut).length;
            document.getElementById('completedSessions').textContent = completed;
        }
        
        // Render table
        function renderTable(data) {
            const tbody = document.getElementById('attendanceTableBody');
            
            if (data.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <div class="empty-state-title">No attendance records found</div>
                                <div class="empty-state-text">Try adjusting your filters or wait for new scans</div>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }
            
            tbody.innerHTML = data.map(record => `
                <tr>
                    <td>
                        ${record.PhotoUrl ? 
                            `<img src="${record.PhotoUrl}" class="student-photo-thumb" alt="Student">` : 
                            '<div style="width: 40px; height: 48px; background: var(--ub-gray); border-radius: 6px;"></div>'
                        }
                    </td>
                    <td class="mono">${record.StudentID || '—'}</td>
                    <td><strong>${record.FullName || '—'}</strong></td>
                    <td>${record.Department || '—'}</td>
                    <td>${record.Course || '—'}</td>
                    <td>${record.Area || 'Library'}</td>
                    <td class="mono">${formatDateTime(record.TimeIn)}</td>
                    <td class="mono">${formatDateTime(record.TimeOut)}</td>
                    <td>${calculateDuration(record.TimeIn, record.TimeOut)}</td>
                    <td>
                        <span class="badge ${record.TimeOut ? 'badge-out' : 'badge-in'}">
                            ${record.TimeOut ? 'Time Out' : 'Inside'}
                        </span>
                    </td>
                </tr>
            `).join('');
        }
        
        // Apply filters
        function applyFilters() {
            const dept = document.getElementById('filterDept').value;
            const course = document.getElementById('filterCourse').value.toUpperCase();
            const area = document.getElementById('filterArea').value;
            const status = document.getElementById('filterStatus').value;
            const dateFrom = document.getElementById('filterDateFrom').value;
            const dateTo = document.getElementById('filterDateTo').value;
            
            filteredData = attendanceData.filter(record => {
                if (dept && record.Department !== dept) return false;
                if (course && !record.Course?.includes(course)) return false;
                if (area && record.Area !== area) return false;
                if (status === 'in' && record.TimeOut) return false;
                if (status === 'out' && !record.TimeOut) return false;
                
                if (dateFrom) {
                    const recordDate = new Date(record.TimeIn).toISOString().split('T')[0];
                    if (recordDate < dateFrom) return false;
                }
                
                if (dateTo) {
                    const recordDate = new Date(record.TimeIn).toISOString().split('T')[0];
                    if (recordDate > dateTo) return false;
                }
                
                return true;
            });
            
            renderTable(filteredData);
        }
        
        // Reset filters
        function resetFilters() {
            document.getElementById('filterDept').value = '';
            document.getElementById('filterCourse').value = '';
            document.getElementById('filterArea').value = '';
            document.getElementById('filterStatus').value = '';
            document.getElementById('filterDateFrom').value = '';
            document.getElementById('filterDateTo').value = '';
            
            filteredData = attendanceData;
            renderTable(filteredData);
        }
        
        // Export report
        function exportReport() {
            const dataToExport = filteredData.length > 0 ? filteredData : attendanceData;
            
            if (dataToExport.length === 0) {
                alert('No data to export');
                return;
            }
            
            // Create CSV
            const headers = ['Student ID', 'Full Name', 'Department', 'Course', 'Area', 'Time In', 'Time Out', 'Duration (minutes)', 'Status'];
            const rows = dataToExport.map(record => {
                const duration = record.TimeOut ? 
                    Math.floor((new Date(record.TimeOut) - new Date(record.TimeIn)) / 1000 / 60) : 
                    'Ongoing';
                
                return [
                    record.StudentID || '',
                    record.FullName || '',
                    record.Department || '',
                    record.Course || '',
                    record.Area || 'Library',
                    record.TimeIn || '',
                    record.TimeOut || '',
                    duration,
                    record.TimeOut ? 'Completed' : 'Active'
                ];
            });
            
            const csv = [
                headers.join(','),
                ...rows.map(row => row.map(cell => `"${cell}"`).join(','))
            ].join('\n');
            
            // Download
            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `UBAccess_Report_${new Date().toISOString().split('T')[0]}.csv`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
        
        // Fetch attendance data
        async function fetchAttendance() {
            try {
                const response = await fetch('get_attendance.php', {
                    cache: 'no-store'
                });
                const data = await response.json();
                
                if (data.success) {
                    attendanceData = data.records || [];
                    filteredData = attendanceData;
                    updateStats();
                    renderTable(filteredData);
                    
                    // Update last updated time
                    const now = new Date();
                    document.getElementById('lastUpdated').textContent = 
                        now.toLocaleTimeString('en-US', { hour12: true });
                }
            } catch (error) {
                console.error('Error fetching attendance:', error);
                document.getElementById('attendanceTableBody').innerHTML = `
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <div class="empty-state-title">Error loading data</div>
                                <div class="empty-state-text">Please check your database connection</div>
                            </div>
                        </td>
                    </tr>
                `;
            }
        }
        
        // Set default date filters to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('filterDateFrom').value = today;
        document.getElementById('filterDateTo').value = today;
        
        // Initialize
        fetchAttendance();
        setInterval(fetchAttendance, 4000); // Refresh every 5 seconds
    </script>
</body>
</html>
