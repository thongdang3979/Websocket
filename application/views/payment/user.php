<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - <?php echo $payment->payment_id; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }

        .payment-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 40px;
            max-width: 400px;
            width: 100%;
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: all 0.5s ease;
        }

        .payment-container.success-mode {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            transform: scale(1.05);
        }

        .payment-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4);
            transition: all 0.5s ease;
        }

        .payment-container.success-mode::before {
            height: 10px;
            background: linear-gradient(90deg, #27ae60, #2ecc71, #27ae60, #2ecc71);
            animation: successGlow 2s infinite;
        }

        @keyframes successGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .status-indicator {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            transition: all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .status-indicator.success-grow {
            transform: scale(1.3);
            animation: successPulse 0.6s ease-in-out;
        }

        @keyframes successPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.4); }
            100% { transform: scale(1.3); }
        }

        .status-pending {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
        }

        .status-completed {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            position: relative;
        }

        .status-completed::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle, rgba(39,174,96,0.3) 0%, transparent 70%);
            animation: successRipple 1s ease-out;
        }

        @keyframes successRipple {
            0% { transform: scale(0); opacity: 1; }
            100% { transform: scale(3); opacity: 0; }
        }

        .status-failed {
            background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
        }

        .checkmark {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            display: block;
            stroke-width: 3;
            stroke: #27ae60;
            stroke-miterlimit: 10;
            margin: 0 auto;
            box-shadow: inset 0 0 0 #27ae60;
            animation: checkmarkFill 0.4s ease-in-out 0.4s forwards, checkmarkScale 0.3s ease-in-out 0.9s both;
            opacity: 0;
        }

        .checkmark__circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 3;
            stroke-miterlimit: 10;
            stroke: #27ae60;
            fill: none;
            animation: checkmarkStroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }

        .checkmark__check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: checkmarkStroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
        }

        @keyframes checkmarkStroke {
            100% { stroke-dashoffset: 0; }
        }

        @keyframes checkmarkScale {
            0%, 100% { transform: none; }
            50% { transform: scale3d(1.1, 1.1, 1); }
        }

        @keyframes checkmarkFill {
            100% {
                box-shadow: inset 0 0 0 30px #27ae60;
                opacity: 1;
            }
        }

        .payment-id {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
            font-family: monospace;
            background: #f8f9fa;
            padding: 8px 12px;
            border-radius: 8px;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .amount {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            transition: all 0.5s ease;
        }

        .amount.success-amount {
            color: #27ae60;
            transform: scale(1.1);
        }

        .status-text {
            font-size: 18px;
            margin-bottom: 30px;
            font-weight: 600;
            transition: all 0.5s ease;
        }

        .status-text.success-text {
            color: #27ae60;
            font-size: 24px;
            animation: textBounce 0.6s ease-in-out;
        }

        @keyframes textBounce {
            0%, 20%, 53%, 80%, 100% { transform: translate3d(0, 0, 0); }
            40%, 43% { transform: translate3d(0, -10px, 0); }
            70% { transform: translate3d(0, -5px, 0); }
            90% { transform: translate3d(0, -2px, 0); }
        }

        .qr-container {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
            transition: all 0.5s ease;
        }

        .qr-container.fade-out {
            opacity: 0.3;
            transform: scale(0.95);
        }

        .qr-code {
            width: 200px;
            height: 200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed #ddd;
            transition: all 0.3s ease;
        }

        .connection-status {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .connected {
            background: #d4edda;
            color: #155724;
        }

        .disconnected {
            background: #f8d7da;
            color: #721c24;
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .payment-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
            transition: all 0.5s ease;
        }

        .payment-details.success-details {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }

        .refresh-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            margin-top: 15px;
            transition: all 0.3s ease;
        }

        .refresh-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .success-message {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin: 20px 0;
            font-weight: 600;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease;
        }

        .success-message.show {
            opacity: 1;
            transform: translateY(0);
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background: #f39c12;
            animation: confetti-fall 3s linear infinite;
        }

        .confetti:nth-child(1) { left: 10%; background: #e74c3c; animation-delay: -0.5s; }
        .confetti:nth-child(2) { left: 20%; background: #9b59b6; animation-delay: -1s; }
        .confetti:nth-child(3) { left: 30%; background: #3498db; animation-delay: -1.5s; }
        .confetti:nth-child(4) { left: 40%; background: #2ecc71; animation-delay: -2s; }
        .confetti:nth-child(5) { left: 50%; background: #f1c40f; animation-delay: -2.5s; }
        .confetti:nth-child(6) { left: 60%; background: #e67e22; animation-delay: -3s; }
        .confetti:nth-child(7) { left: 70%; background: #e74c3c; animation-delay: -3.5s; }
        .confetti:nth-child(8) { left: 80%; background: #9b59b6; animation-delay: -4s; }
        .confetti:nth-child(9) { left: 90%; background: #3498db; animation-delay: -4.5s; }

        @keyframes confetti-fall {
            0% {
                transform: translateY(-100vh) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(720deg);
                opacity: 0;
            }
        }

        .celebration-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1000;
            opacity: 0;
        }

        .celebration-overlay.active {
            opacity: 1;
        }

        .loading-spinner {
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-left: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
<!-- Celebration Overlay -->
<div class="celebration-overlay" id="celebrationOverlay">
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
</div>

<div class="payment-container" id="paymentContainer">
    <div class="connection-status disconnected" id="connectionStatus">
        ● Connecting...
    </div>

    <div class="status-indicator status-<?php echo $payment->status; ?>" id="statusIndicator">
        <span id="statusIcon">⏳</span>
        <svg class="checkmark" id="checkmark" viewBox="0 0 52 52" style="display: none;">
            <circle class="checkmark__circle" fill="none" cx="26" cy="26" r="25"/>
            <path class="checkmark__check" fill="none" d="m14.1 27.2l7.1 7.2 16.7-16.8"/>
        </svg>
    </div>

    <div class="payment-id">
        Payment ID: <?php echo $payment->payment_id; ?>
    </div>

    <div class="amount" id="amountDisplay">
        $<?php echo number_format($payment->amount, 2); ?> <?php echo $payment->currency; ?>
    </div>

    <div class="status-text" id="statusText">
        <?php echo ucfirst($payment->status); ?>
    </div>

    <div class="success-message" id="successMessage">
        🎉 Payment completed successfully! Thank you for your purchase.
    </div>

    <div class="qr-container" id="qrContainer">
        <div class="qr-code" id="qrCode">
            <div>QR Code Here<br><small>Use QR library to generate</small></div>
        </div>
        <div style="margin-top: 15px; font-size: 14px; color: #666;">
            Scan to pay or share payment link
        </div>
    </div>

    <div class="payment-details" id="paymentDetails">
        <div><strong>Created:</strong> <?php echo date('M j, Y g:i A', strtotime($payment->created_at)); ?></div>
        <div><strong>Last Updated:</strong> <span id="lastUpdated"><?php echo date('M j, Y g:i A', strtotime($payment->updated_at)); ?></span></div>
    </div>

    <button class="refresh-btn" id="refreshBtn" onclick="checkPaymentStatus()">
        🔄 Check Status
    </button>
</div>

<script>
    let ws;
    let paymentId = '<?php echo $payment->payment_id; ?>';
    let reconnectAttempts = 0;
    let maxReconnectAttempts = 5;
    let isCompleted = false;

    function connectWebSocket() {
        try {
            ws = new WebSocket('<?php echo $websocket_url; ?>');

            ws.onopen = function() {
                console.log('WebSocket connected');
                updateConnectionStatus(true);
                reconnectAttempts = 0;

                // Join payment room
                ws.send(JSON.stringify({
                    type: 'join_payment',
                    payment_id: paymentId
                }));
            };

            ws.onmessage = function(event) {
                let data = JSON.parse(event.data);
                console.log('Received:', data);

                if (data.type === 'payment_updated' && data.payment_id === paymentId) {
                    updatePaymentStatus(data.status);
                    updateLastUpdated(data.timestamp);
                }
            };

            ws.onclose = function() {
                console.log('WebSocket disconnected');
                updateConnectionStatus(false);

                // Attempt to reconnect
                if (reconnectAttempts < maxReconnectAttempts) {
                    reconnectAttempts++;
                    setTimeout(connectWebSocket, 3000);
                }
            };

            ws.onerror = function(error) {
                console.error('WebSocket error:', error);
                updateConnectionStatus(false);
            };

        } catch (error) {
            console.error('Failed to connect WebSocket:', error);
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

    function updatePaymentStatus(status) {
        const statusIndicator = document.getElementById('statusIndicator');
        const statusIcon = document.getElementById('statusIcon');
        const statusText = document.getElementById('statusText');
        const qrContainer = document.getElementById('qrContainer');
        const paymentContainer = document.getElementById('paymentContainer');
        const amountDisplay = document.getElementById('amountDisplay');
        const paymentDetails = document.getElementById('paymentDetails');
        const successMessage = document.getElementById('successMessage');
        const checkmark = document.getElementById('checkmark');

        // Remove old status classes
        statusIndicator.className = 'status-indicator status-' + status;

        // Update icon and text
        switch(status) {
            case 'completed':
                if (!isCompleted) {
                    isCompleted = true;

                    // Step 1: Hide status icon and show animated checkmark
                    statusIcon.style.display = 'none';
                    checkmark.style.display = 'block';

                    // Step 2: Update text and styling
                    statusText.textContent = 'Payment Completed!';
                    statusText.classList.add('success-text');

                    // Step 3: Add success styling with animations
                    paymentContainer.classList.add('success-mode');
                    statusIndicator.classList.add('success-grow');
                    amountDisplay.classList.add('success-amount');
                    paymentDetails.classList.add('success-details');
                    qrContainer.classList.add('fade-out');

                    // Step 4: Trigger celebration effects
                    triggerSuccessAnimation();

                    // Step 5: Show success message after 1 second
                    setTimeout(() => {
                        successMessage.classList.add('show');
                    }, 1000);

                    // Step 6: Wait 5 seconds then redirect
                    setTimeout(() => {
                        redirectToSuccessPage();
                    }, 5000);
                }
                break;

            case 'failed':
                statusIcon.textContent = '❌';
                statusText.textContent = 'Payment Failed';
                statusText.style.color = '#e74c3c';
                break;

            case 'expired':
                statusIcon.textContent = '⏰';
                statusText.textContent = 'Payment Expired';
                statusText.style.color = '#f39c12';
                qrContainer.classList.add('fade-out');
                break;

            default:
                statusIcon.textContent = '⏳';
                statusText.textContent = 'Pending Payment';
                statusText.style.color = '#f39c12';
                qrContainer.style.opacity = '1';
                qrContainer.style.transform = 'scale(1)';
        }

        // Add pulse effect for pending
        if (status === 'pending') {
            statusIndicator.classList.add('pulse');
        } else {
            statusIndicator.classList.remove('pulse');
        }
    }

    function triggerSuccessAnimation() {
        // Show confetti
        const celebrationOverlay = document.getElementById('celebrationOverlay');
        celebrationOverlay.classList.add('active');

        // Play success sound (optional - you can add audio file)
        // const audio = new Audio('success-sound.mp3');
        // audio.play().catch(e => console.log('Audio play failed:', e));

        // Hide confetti after 3 seconds
        setTimeout(() => {
            celebrationOverlay.classList.remove('active');
        }, 3000);
    }

    function redirectToSuccessPage() {
        // Show simple loading message
        const statusText = document.getElementById('statusText');
        const refreshBtn = document.getElementById('refreshBtn');

        statusText.textContent = 'Redirecting...';
        refreshBtn.innerHTML = 'Redirecting... <div class="loading-spinner"></div>';
        refreshBtn.disabled = true;

        // Fade out the page
        document.body.style.transition = 'opacity 0.5s ease';
        document.body.style.opacity = '0.8';

        // Redirect after a short delay for smooth transition
        setTimeout(() => {
            window.location.href = '<?php echo base_url("payment/success?payment_id=" . $payment->payment_id); ?>';
        }, 800);
    }

    function updateLastUpdated(timestamp) {
        document.getElementById('lastUpdated').textContent =
            new Date(timestamp).toLocaleString();
    }

    function checkPaymentStatus() {
        if (isCompleted) return; // Don't check if already completed

        const refreshBtn = document.getElementById('refreshBtn');
        refreshBtn.innerHTML = '🔄 Checking... <div class="loading-spinner"></div>';
        refreshBtn.disabled = true;

        fetch('<?php echo base_url("payment/get_status/" . $payment->payment_id); ?>')
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    updatePaymentStatus(data.status);
                    updateLastUpdated(data.updated_at);
                }
            })
            .catch(error => {
                console.error('Error checking payment status:', error);
            })
            .finally(() => {
                if (!isCompleted) {
                    refreshBtn.innerHTML = '🔄 Check Status';
                    refreshBtn.disabled = false;
                }
            });
    }

    // Initialize WebSocket connection
    connectWebSocket();

    // Initial status update
    updatePaymentStatus('<?php echo $payment->status; ?>');

    // Periodic status check as fallback (only if not completed)
    setInterval(() => {
        if (!isCompleted) {
            checkPaymentStatus();
        }
    }, 30000); // Check every 30 seconds
</script>
</body>
</html>