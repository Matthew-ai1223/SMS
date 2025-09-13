<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EduManage Pro</title>
    <link rel="stylesheet" href="../asset/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #f8fafc;
            color: #1e293b;
            font-family: 'Inter', sans-serif;
        }
        .admin-navbar {
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
        }
        .admin-navbar .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .admin-navbar .logo {
            font-size: 1.7rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .admin-navbar .logo i {
            font-size: 2rem;
        }
        .admin-navbar .nav-links {
            display: flex;
            gap: 30px;
        }
        .admin-navbar .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .admin-navbar .nav-links a:hover {
            color: #fbbf24;
        }
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .stat-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        .stat-card.pending i { color: #f59e0b; }
        .stat-card.approved i { color: #10b981; }
        .stat-card.rejected i { color: #ef4444; }
        .stat-card.total i { color: #3b82f6; }
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .stat-label {
            color: #64748b;
            font-weight: 500;
        }
        .schools-table {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .table-header {
            background: #f1f5f9;
            padding: 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        .table-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        th {
            background: #f8fafc;
            font-weight: 600;
            color: #374151;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        .status-approved {
            background: #d1fae5;
            color: #065f46;
        }
        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-approve {
            background: #10b981;
            color: white;
        }
        .btn-approve:hover {
            background: #059669;
        }
        .btn-reject {
            background: #ef4444;
            color: white;
        }
        .btn-reject:hover {
            background: #dc2626;
        }
        .btn-view {
            background: #3b82f6;
            color: white;
        }
        .btn-view:hover {
            background: #2563eb;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #64748b;
        }
        .no-data i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #cbd5e1;
        }
        @media (max-width: 768px) {
            .admin-container {
                padding: 10px;
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            table {
                font-size: 0.9rem;
            }
            th, td {
                padding: 10px;
            }
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <nav class="admin-navbar">
        <div class="container">
            <div class="logo">
                <i class="fas fa-graduation-cap"></i> EduManage Pro Admin
            </div>
            <div class="nav-links">
                <a href="../index.php">Home</a>
                <a href="#">Dashboard</a>
                <a href="#">Settings</a>
                <a href="#">Logout</a>
            </div>
        </div>
    </nav>
    <div class="admin-container">
        <div class="stats-grid">
            <div class="stat-card total">
                <i class="fas fa-school"></i>
                <div class="stat-number" id="totalSchools">0</div>
                <div class="stat-label">Total Schools</div>
            </div>
            <div class="stat-card pending">
                <i class="fas fa-clock"></i>
                <div class="stat-number" id="pendingSchools">0</div>
                <div class="stat-label">Pending Approval</div>
            </div>
            <div class="stat-card approved">
                <i class="fas fa-check-circle"></i>
                <div class="stat-number" id="approvedSchools">0</div>
                <div class="stat-label">Approved</div>
            </div>
            <div class="stat-card rejected">
                <i class="fas fa-times-circle"></i>
                <div class="stat-number" id="rejectedSchools">0</div>
                <div class="stat-label">Rejected</div>
            </div>
        </div>
        <div class="schools-table">
            <div class="table-header">
                <h2><i class="fas fa-list"></i> School Registrations</h2>
            </div>
            <div id="schoolsTable">
                <div class="no-data">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Loading school registrations...</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Load dashboard data from backend
        document.addEventListener('DOMContentLoaded', function() {
            loadDashboardData();
        });

        function loadDashboardData() {
            fetch('../../backend/api/admin/dashboard.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateStats(data.stats);
                        updateSchoolsTable(data.schools);
                    } else {
                        showError('Failed to load dashboard data');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Network error loading dashboard data');
                });
        }

        function updateStats(stats) {
            document.getElementById('totalSchools').textContent = stats.total;
            document.getElementById('pendingSchools').textContent = stats.pending;
            document.getElementById('approvedSchools').textContent = stats.approved;
            document.getElementById('rejectedSchools').textContent = stats.rejected;
        }

        function updateSchoolsTable(schools) {
            const tableContainer = document.getElementById('schoolsTable');
            if (!schools || schools.length === 0) {
                tableContainer.innerHTML = `
                    <div class="no-data">
                        <i class="fas fa-inbox"></i>
                        <p>No school registrations found</p>
                    </div>
                `;
                return;
            }
            const tableHTML = `
                <table>
                    <thead>
                        <tr>
                            <th>School Name</th>
                            <th>Email</th>
                            <th>Location</th>
                            <th>Admin Contact</th>
                            <th>Status</th>
                            <th>Registered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${schools.map(school => `
                            <tr>
                                <td><strong>${school.school_name}</strong></td>
                                <td>${school.school_email}</td>
                                <td>${school.school_location.substring(0, 50)}${school.school_location.length > 50 ? '...' : ''}</td>
                                <td>${school.admin_email}</td>
                                <td><span class="status-badge status-${school.status}">${school.status}</span></td>
                                <td>${formatDate(school.created_at)}</td>
                                <td class="action-buttons">
                                    <button class="btn btn-view" onclick="viewSchool(${school.id})"><i class="fas fa-eye"></i> View</button>
                                    ${school.status === 'pending' ? `
                                        <button class="btn btn-approve" onclick="approveSchool(${school.id})"><i class="fas fa-check"></i> Approve</button>
                                        <button class="btn btn-reject" onclick="rejectSchool(${school.id})"><i class="fas fa-times"></i> Reject</button>
                                    ` : ''}
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            `;
            tableContainer.innerHTML = tableHTML;
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString();
        }

        function approveSchool(schoolId) {
            if (confirm('Are you sure you want to approve this school registration?')) {
                updateSchoolStatus(schoolId, 'approved');
            }
        }

        function rejectSchool(schoolId) {
            if (confirm('Are you sure you want to reject this school registration?')) {
                updateSchoolStatus(schoolId, 'rejected');
            }
        }

        function updateSchoolStatus(schoolId, status) {
            fetch('../../backend/api/admin/update-status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    school_id: schoolId,
                    status: status
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccess(`School ${status} successfully`);
                    loadDashboardData(); // Reload data
                } else {
                    showError(data.message || 'Failed to update school status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError('Network error updating school status');
            });
        }

        function viewSchool(schoolId) {
            // Open school details in a new window or modal
            window.open(`school-details.php?id=${schoolId}`, '_blank');
        }

        function showSuccess(message) {
            showMessage(message, 'success');
        }

        function showError(message) {
            showMessage(message, 'error');
        }

        function showMessage(message, type) {
            const messageDiv = document.createElement('div');
            messageDiv.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 20px;
                border-radius: 8px;
                color: white;
                font-weight: 500;
                z-index: 10000;
                max-width: 400px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                animation: slideIn 0.3s ease;
            `;
            if (type === 'success') {
                messageDiv.style.background = 'linear-gradient(135deg, #10b981, #059669)';
            } else {
                messageDiv.style.background = 'linear-gradient(135deg, #ef4444, #dc2626)';
            }
            messageDiv.innerHTML = `
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                    <span>${message}</span>
                </div>
            `;
            document.body.appendChild(messageDiv);
            setTimeout(() => {
                if (messageDiv.parentNode) {
                    messageDiv.style.animation = 'slideOut 0.3s ease';
                    setTimeout(() => {
                        messageDiv.remove();
                    }, 300);
                }
            }, 3000);
        }
    </script>
</body>
</html>
