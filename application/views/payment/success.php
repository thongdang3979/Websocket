<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful!</title>
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
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .success-container {
            background: white;
            border-radius: 25px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            padding: 50px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            position: relative;
            overflow: hidden;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .success-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(90deg, #27ae60, #2ecc71, #58d68d, #85c88a);
            animation: successGlow 2s infinite alternate;
        }

        @keyframes successGlow {
            0% { opacity: 0.8; }
            100% { opacity: 1; }
        }

        .success-icon-container {
            margin-bottom: 30px;
            position: relative;
        }

        .success-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto;
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            animation: successIconPulse 2s infinite;
        }

        @keyframes successIconPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .success-icon::before {
            content: '';
            position: absolute;
            width: 140px;
            height: 140px;
            border: 3px solid rgba(39, 174, 96, 0.3);
            border-radius: 50%;
            animation: ripple 2s infinite;
        }

        @keyframes ripple {
            0% {
                transform: scale(0.8);
                opacity: 1;
            }
            100% {
                transform: scale(1.2);
                opacity: 0;
            }
        }

        .checkmark {
            width: 60px;
            height: 60px;
            stroke-width: 4;
            stroke: white;
            stroke-miterlimit: 10;
            animation: checkmarkDraw 0.8s ease-in-out 0.3s both;
        }

        .checkmark__circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 4;
            stroke: white;
            fill: none;
            animation: checkmarkCircle 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }

        .checkmark__check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: checkmarkCheck 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
        }

        @keyframes checkmarkCircle {
            100% { stroke-dashoffset: 0; }
        }

        @keyframes checkmarkCheck {
            100% { stroke-dashoffset: 0; }
        }

        @keyframes checkmarkDraw {
            0% { opacity: 0; transform: scale(0.5); }
            100% { opacity: 1; transform: scale(1); }
        }

        .success-title {
            font-size: 36px;
            font-weight: bold;
            color: #27ae60;
            margin-bottom: 15px;
            animation: titleSlide 0.8s ease-out 0.5s both;
        }

        @keyframes titleSlide {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-subtitle {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
            animation: subtitleSlide 0.8s ease-out 0.7s both;
        }

        @keyframes subtitleSlide {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .payment-summary {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 25px;
            margin: 30px 0;
            animation: summarySlide 0.8s ease-out 0.9s both;
        }

        @keyframes summarySlide {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .payment-summary h3 {
            color: #333;
            margin-bottom: 20px;
            font-size: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            padding: 8px 0;
        }

        .summary-row:last-child {
            margin-bottom: 0;
            padding-top: 15px;
            border-top: 2px solid #dee2e6;
            font-weight: bold;
            font-size: 18px;
        }

        .summary-label {
            color: #666;
            font-size: 16px;
        }

        .summary-value {
            color: #333;
            font-weight: 600;
            font-size: 16px;
        }

        .payment-id-display {
            background: #e9ecef;
            padding: 8px 12px;
            border-radius: 8px;
            font-family: monospace;
            font-size: 14px;
            color: #495057;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            animation: buttonsSlide 0.8s ease-out 1.1s both;
        }

        @keyframes buttonsSlide {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn {
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            color: white;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(108, 117, 125, 0.4);
            color: white;
            text-decoration: none;
        }

        .floating-particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            top: 0;
            left: 0;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            background: #27ae60;
            border-radius: 50%;
            opacity: 0.7;
            animation: float 6s infinite ease-in-out;
        }

        .particle:nth-child(1) { width: 6px; height: 6px; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 8px; height: 8px; left: 20%; animation-delay: 1s; }
        .particle:nth-child(3) { width: 4px; height: 4px; left: 30%; animation-delay: 2s; }
        .particle:nth-child(4) { width: 10px; height: 10px; left: 40%; animation-delay: 3s; }
        .particle:nth-child(5) { width: 6px; height: 6px; left: 50%; animation-delay: 4s; }
        .particle:nth-child(6) { width: 8px; height: 8px; left: 60%; animation-delay: 5s; }
        .particle:nth-child(7) { width: 4px; height: 4px; left: 70%; animation-delay: 0.5s; }
        .particle:nth-child(8) { width: 12px; height: 12px; left: 80%; animation-delay: 1.5s; }
        .particle:nth-child(9) { width: 6px; height: 6px; left: 90%; animation-delay: 2.5s; }

        @keyframes float {
            0%, 100% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10%, 90% {
                opacity: 0.7;
            }
            50% {
                transform: translateY(-10px) rotate(180deg);
                opacity: 1;
            }
        }

        .success-badge {
            position: absolute;
            top: -10px;
            right: -10px;
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            animation: badgeBounce 2s infinite;
        }

        @keyframes badgeBounce {
            0%, 100% { transform: translateY(0) rotate(-5deg); }
            50% { transform: translateY(-5px) rotate(-5deg); }
        }

        @media (max-width: 480px) {
            .success-container {
                margin: 20px;
                padding: 30px 25px;
            }

            .success-title {
                font-size: 28px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        .email-sent {
            background: #d4edda;
            color: #155724;
            padding: 12px 20px;
            border-radius: 10px;
            margin: 20px 0;
            font-size: 14px;
            animation: emailSlide 0.8s ease-out 1.3s both;
        }

        @keyframes emailSlide {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
<div class="floating-particles">
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
</div>

<div class="success-container">
    <div class="success-badge">
        ✓ Verified
    </div>

    <div class="success-icon-container">
        <div class="success-icon">
            <svg class="checkmark" viewBox="0 0 52 52">
                <circle class="checkmark__circle" fill="none" cx="26" cy="26" r="25"/>
                <path class="checkmark__check" fill="none" d="m14.1 27.2l7.1 7.2 16.7-16.8"/>
            </svg>
        </div>
    </div>

    <h1 class="success-title">Payment Successful!</h1>
    <p class="success-subtitle">Thank you for your purchase. Your payment has been processed successfully.</p>

    <div class="payment-summary">
        <h3>📄 Payment Summary</h3>
        <div class="summary-row">
            <span class="summary-label">Payment ID:</span>
            <span class="payment-id-display"><?php echo $payment->payment_id; ?></span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Amount:</span>
            <span class="summary-value">$<?php echo number_format($payment->amount, 2); ?> <?php echo $payment->currency; ?></span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Status:</span>
            <span class="summary-value" style="color: #27ae60;">✅ Completed</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Date:</span>
            <span class="summary-value"><?php echo date('M j, Y - g:i A', strtotime($payment->updated_at)); ?></span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Total Paid:</span>
            <span class="summary-value" style="color: #27ae60;">$<?php echo number_format($payment->amount, 2); ?> <?php echo $payment->currency; ?></span>
        </div>
    </div>

    <div class="email-sent">
        📧 A receipt has been sent to your email address
    </div>

    <div class="action-buttons">
        <a href="<?php echo base_url('payment'); ?>" class="btn btn-primary">
            💳 New Payment
        </a>
        <a href="<?php echo base_url(); ?>" class="btn btn-secondary">
            🏠 Back to Home
        </a>
    </div>
</div>

<script>
    // Auto-scroll to top on page load
    window.scrollTo(0, 0);

    // Add some interactive effects
    document.addEventListener('DOMContentLoaded', function() {
        // Create additional floating elements
        setTimeout(() => {
            createFloatingHearts();
        }, 2000);
    });

    function createFloatingHearts() {
        const container = document.querySelector('.floating-particles');
        const hearts = ['💚', '💖', '✨', '🎉', '⭐'];

        for (let i = 0; i < 5; i++) {
            setTimeout(() => {
                const heart = document.createElement('div');
                heart.textContent = hearts[Math.floor(Math.random() * hearts.length)];
                heart.style.position = 'absolute';
                heart.style.left = Math.random() * 100 + '%';
                heart.style.bottom = '-50px';
                heart.style.fontSize = '20px';
                heart.style.animation = 'floatUp 3s ease-out forwards';
                heart.style.pointerEvents = 'none';
                heart.style.zIndex = '1000';

                container.appendChild(heart);

                setTimeout(() => {
                    heart.remove();
                }, 3000);
            }, i * 500);
        }
    }

    // Add the floating animation CSS
    const style = document.createElement('style');
    style.textContent = `
            @keyframes floatUp {
                0% {
                    transform: translateY(0) rotate(0deg);
                    opacity: 1;
                }
                100% {
                    transform: translateY(-150vh) rotate(360deg);
                    opacity: 0;
                }
            }
        `;
    document.head.appendChild(style);

    // Add click effects to buttons
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const ripple = document.createElement('div');
            ripple.style.position = 'absolute';
            ripple.style.borderRadius = '50%';
            ripple.style.background = 'rgba(255,255,255,0.6)';
            ripple.style.transform = 'scale(0)';
            ripple.style.animation = 'rippleEffect 0.6s linear';
            ripple.style.left = (e.clientX - this.offsetLeft) + 'px';
            ripple.style.top = (e.clientY - this.offsetTop) + 'px';
            ripple.style.width = ripple.style.height = '20px';
            ripple.style.pointerEvents = 'none';

            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // Add ripple effect CSS
    const rippleStyle = document.createElement('style');
    rippleStyle.textContent = `
            @keyframes rippleEffect {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
    document.head.appendChild(rippleStyle);
</script>
</body>
</html>