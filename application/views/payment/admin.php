<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #333;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 600;
        }

        .connection-status {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .connected {
            background: rgba(39, 174, 96, 0.2);
            color: #27ae60;
            border: 1px solid #27ae60;
        }

        .disconnected {
            background: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
            border: 1px solid #e74c3c;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            text-align: center;
            border-left: 4px solid #667eea;
        }

        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .payments-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .section-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            background: #f8f9fa;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
        }

        .payments-table {
            width: 100%;
            border-collapse: collapse;
        }

        .payments-table th,
        .payments-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .payments-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #555;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .payments-table tr:hover {
            background: #f8f9fa;
        }

        .payment-id {
            font-family: monospace;
            background: #e9ecef;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
            border: 1px solid #a3d977;
        }

        .status-failed {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f1556c;
        }

        .status-expired {
            background: #e2e3e5;
            color: #383d41;
            border: 1px solid #c6c8ca;
        }

        .status-select {
            padding: 8px 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            background: white;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .status-select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .update-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            margin-left: 10px;
        }

        .update-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .update-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .amount {
            font-weight: 600;
            color: #333;
        }

        .timestamp {
            color: #666;
            font-size: 13px;
        }

        .no-payments {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .refresh-btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            margin-left: auto;
            transition: all 0.3s ease;
        }

        .refresh-btn:hover {
            background: #218838;
            transform: translateY(-1px);
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @keyframes updateSuccess {
            0% { background-color: #d4edda; }
            100% { background-color: transparent; }
        }

        .update-success {
            animation: updateSuccess 1s ease-in-out;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="header-content">
        <h1>💳 Payment Dashboard</h1>
        <div class="connection-status disconnected" id="connectionStatus">
            ● Connecting to WebSocket...
        </div>
    </div>
</div>

<div class="container">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number" id="totalPayments"><?php echo count($payments); ?></div>
            <div class="stat-label">Total Payments</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="pendingCount">
                <?php echo count(array_filter($payments, function($p) { return $p->status === 'pending'; })); ?>
            </div>
            <div class="stat-label">Pending</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="completedCount">
                <?php echo count(array_filter($payments, function($p) { return $p->status === 'completed'; })); ?>
            </div>
            <div class="stat-label">Completed</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="totalAmount">
                $<?php
                $total = array_sum(array_map(function($p) {
                    return $p->status === 'completed' ? $p->amount : 0;
                }, $payments));
                echo number_format($total, 2);
                ?>
            </div>
            <div class="stat-label">Total Revenue</div>
        </div>
    </div>

    <div class="payments-section">
        <div class="section-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2 class="section-title">Recent Payments</h2>
                <button class="refresh-btn" onclick="refreshPayments()">
                    🔄 Refresh
                </button>
            </div>
        </div>

        <?php if (empty($payments)): ?>
            <div class="no-payments">
                <h3>No payments found</h3>
                <p>Payments will appear here when users create them.</p>
            </div>
        <?php else: ?>
            <table class="payments-table">
                <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="paymentsTableBody">
                <?php foreach ($payments as $payment): ?>
                    <tr data-payment-id="<?php echo $payment->payment_id; ?>">
                        <td>
                            <span class="payment-id"><?php echo $payment->payment_id; ?></span>
                        </td>
                        <td>
                            <span class="amount">$<?php echo number_format($payment->amount, 2); ?> <?php echo $payment->currency; ?></span>
                        </td>
                        <td>
                                    <span class="status-badge status-<?php echo $payment->status; ?>">
                                        <?php echo ucfirst($payment->status); ?>
                                    </span>
                        </td>
                        <td>
                            <span class="timestamp"><?php echo date('M j, Y g:i A', strtotime($payment->created_at)); ?></span>
                        </td>
                        <td>
                            <span class="timestamp"><?php echo date('M j, Y g:i A', strtotime($payment->updated_at)); ?></span>
                        </td>
                        <td>
                            <div class="actions">
                                <select class="status-select" data-payment-id="<?php echo $payment->payment_id; ?>">
                                    <option value="pending" <?php echo $payment->status === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="completed" <?php echo $payment->status === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                    <option value="failed" <?php echo $payment->status === 'failed' ? 'selected' : ''; ?>>Failed</option>
                                    <option value="expired" <?php echo $payment->status === 'expired' ? 'selected' : ''; ?>>Expired</option>
                                </select>
                                <button class="update-btn" onclick="updatePaymentStatus('<?php echo $payment->payment_id; ?>')">
                                    Update
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<script>
    let ws;
    let reconnectAttempts = 0;
    let maxReconnectAttempts = 5;

    function connectWebSocket() {
        try {
            ws = new WebSocket('<?php echo $websocket_url; ?>');

            ws.onopen = function() {
                console.log('Admin WebSocket connected');
                updateConnectionStatus(true);
                reconnectAttempts = 0;

                // Join as admin
                ws.send(JSON.stringify({
                    type: 'join_admin'
                }));
            };

            ws.onmessage = function(event) {
                let data = JSON.parse(event.data);
                console.log('Received:', data);

                if (data.type === 'payment_updated') {
                    // Update the UI to reflect the change
                    updatePaymentInTable(data.payment_id, data.status);
                }
            };

            ws.onclose = function() {
                console.log('Admin WebSocket disconnected');
                updateConnectionStatus(false);

                // Attempt to reconnect
                if (reconnectAttempts < maxReconnectAttempts) {
                    reconnectAttempts++;
                    setTimeout(connectWebSocket, 3000);
                }
            };

            ws.onerror = function(error) {
                console.error('Admin WebSocket error:', error);
                updateConnectionStatus(false);
            };

        } catch (error) {
            console.error('Failed to connect Admin WebSocket:', error);
            updateConnectionStatus(false);
        }
    }

    function updateConnectionStatus(connected) {
        const statusEl = document.getElementById('connectionStatus');
        if (connected) {
            statusEl.textContent = '● Connected';
            statusEl.className = 'connection-status connected';
        } else {
            statusEl.textContent = '● Disconnected';
            statusEl.className = 'connection-status disconnected';
        }
    }

    function updatePaymentStatus(paymentId) {
        const selectEl = document.querySelector(`select[data-payment-id="${paymentId}"]`);
        const btnEl = selectEl.parentElement.querySelector('.update-btn');
        const newStatus = selectEl.value;

        btnEl.disabled = true;
        btnEl.textContent = 'Updating...';

        // Send via WebSocket
        if (ws && ws.readyState === WebSocket.OPEN) {
            ws.send(JSON.stringify({
                type: 'update_payment',
                payment_id: paymentId,
                status: newStatus
            }));
        }

        // Also update via AJAX as backup
        fetch('<?php echo base_url("payment/update_status"); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `payment_id=${paymentId}&status=${newStatus}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updatePaymentInTable(paymentId, newStatus);

                    // Add success animation
                    const row = document.querySelector(`tr[data-payment-id="${paymentId}"]`);
                    row.classList.add('update-success');
                    setTimeout(() => row.classList.remove('update-success'), 1000);
                } else {
                    alert('Failed to update payment status');
                }
            })
            .catch(error => {
                console.error('Error updating payment:', error);
                alert('Error updating payment status');
            })
            .finally(() => {
                btnEl.disabled = false;
                btnEl.textContent = 'Update';
            });
    }

    function updatePaymentInTable(paymentId, newStatus) {
        const row = document.querySelector(`tr[data-payment-id="${paymentId}"]`);
        if (row) {
            // Update status badge
            const statusBadge = row.querySelector('.status-badge');
            statusBadge.className = `status-badge status-${newStatus}`;
            statusBadge.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);

            // Update select value
            const selectEl = row.querySelector('.status-select');
            selectEl.value = newStatus;

            // Update timestamp
            const timestampCells = row.querySelectorAll('.timestamp');
            if (timestampCells.length > 1) {
                timestampCells[1].textContent = new Date().toLocaleString();
            }
        }

        // Update stats
        updateStats();
    }

    function updateStats() {
        const rows = document.querySelectorAll('#paymentsTableBody tr');
        let pending = 0, completed = 0, total = 0, revenue = 0;

        rows.forEach(row => {
            const status = row.querySelector('.status-select').value;
            const amountText = row.querySelector('.amount').textContent;
            const amount = parseFloat(amountText.replace(/[^0-9.]/g, ''));

            total++;
            if (status === 'pending') pending++;
            if (status === 'completed') {
                completed++;
                revenue += amount;
            }
        });

        document.getElementById('totalPayments').textContent = total;
        document.getElementById('pendingCount').textContent = pending;
        document.getElementById('completedCount').textContent = completed;
        document.getElementById('totalAmount').textContent = '$' + revenue.toFixed(2);
    }

    function refreshPayments() {
        location.reload();
    }

    // Initialize WebSocket connection
    connectWebSocket();

    // Add keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'r') {
            e.preventDefault();
            refreshPayments();
        }
    });
</script>
</body>
</html>