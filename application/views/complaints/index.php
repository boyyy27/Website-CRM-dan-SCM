<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Messages</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="main-content">
    <div class="chat-container">

        <!-- Header -->
        <div class="content-header">
        <h1>Complaints and Suggestions</h1>
        <p>Manage your Customers Suggestions and Complaints</p>
    </div>
        <div class="chat-header">
            <div class="header-content">
                <div class="header-left">
                    <i class="fas fa-comments"></i>
                    <div class="header-info">
                        <h1>Customer Messages</h1>
                        <p>Manage complaints and suggestions</p>
                    </div>
                </div>
                <div class="header-actions">
                    <button class="action-btn">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="action-btn">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Success Alert (PHP Integration) -->
        <?php if ($this->session->flashdata('success')): ?>
        <div class="success-alert">
            <i class="fas fa-check-circle"></i>
            <span><?php echo $this->session->flashdata('success'); ?></span>
        </div>
        <?php endif; ?>

        <!-- Messages List -->
        <div class="messages-container">
            <!-- PHP Integration Template -->
            <?php foreach ($complaints as $c): ?>
            <div class="message-item modern-card" style="animation: fadeIn 0.6s;">
                <div class="avatar-initial" style="background: <?php echo ($c->subject=="Complaint"||$c->subject=="Keluhan")?'#ffeaea':'#e8f0fe'; ?>; color: <?php echo ($c->subject=="Complaint"||$c->subject=="Keluhan")?'#d93025':'#1a73e8'; ?>;">
                    <?php echo strtoupper(substr($c->name,0,1)); ?>
                </div>
                <div class="message-content">
                    <div class="message-header">
                        <div class="sender-info">
                            <span class="sender-name"><?php echo htmlspecialchars($c->name); ?></span>
                            <span class="sender-email-badge">📧 <?php echo htmlspecialchars($c->email); ?></span>
                        </div>
                        <span class="message-time">
                            <i class="fas fa-calendar-alt"></i>
                            <?php echo date('d M Y H:i', strtotime($c->created_at)); ?>
                        </span>
                    </div>
                    <div class="message-subject-badge" style="background:<?php echo ($c->subject=="Complaint"||$c->subject=="Keluhan")?'#ffeaea':'#e8f0fe'; ?>; color:<?php echo ($c->subject=="Complaint"||$c->subject=="Keluhan")?'#d93025':'#1a73e8'; ?>;">
                        <i class="fas fa-tag"></i> <?php echo htmlspecialchars($c->subject); ?>
                    </div>
                    <div class="message-text">
                        <?php echo nl2br(htmlspecialchars($c->message)); ?>
                    </div>
                    <div class="message-actions">
                        <button class="action-btn reply-btn" title="Reply" onclick="replyToMessage('<?php echo htmlspecialchars($c->email); ?>', '<?php echo htmlspecialchars($c->subject); ?>')">
                            <i class="fas fa-reply"></i>
                        </button>
                        <button class="action-btn delete-btn" title="Delete" onclick="deleteMessage(this, '<?php echo site_url('index.php/Complaint/delete/'.$c->id); ?>')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    </div>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

       

        .chat-container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 1400px;
            height: 95vh;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
            color: white;
            padding: 20px 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-left i {
            font-size: 28px;
            background: rgba(255, 255, 255, 0.2);
            padding: 12px;
            border-radius: 50%;
        }

        .header-info h1 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .header-info p {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 400;
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        .action-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
            width: 70px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        .success-alert {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 15px 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 500;
        }

        .messages-container {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background: #f8f9fa;
        }

        .message-item {
            background: white;
            border-radius: 16px;
            margin-bottom: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            display: flex;
            transition: all 0.3s ease;
            position: relative;
        }

        .message-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            margin: 20px;
            flex-shrink: 0;
        }

        .message-content {
            flex: 1;
            padding: 20px 20px 20px 0;
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .sender-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sender-name {
            font-weight: 600;
            font-size: 16px;
            color: #2c3e50;
        }

        .sender-email {
            font-size: 13px;
            color: #7f8c8d;
            opacity: 0.8;
        }

        .message-time {
            font-size: 12px;
            color: #95a5a6;
            display: flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }

        .message-subject {
            font-weight: 600;
            color: #34495e;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 15px;
        }

        .message-subject i {
            color: #3498db;
            font-size: 14px;
        }

        .message-text {
            color: #5d6d7e;
            line-height: 1.6;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .message-actions {
            display: flex;
            gap: 12px;
        }

        .reply-btn {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .reply-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .delete-btn {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .delete-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }

        .message-status {
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            width: 4px;
        }

        .status-indicator {
            width: 100%;
            height: 100%;
        }

        .status-indicator.complaint {
            background: linear-gradient(180deg, #e74c3c 0%, #c0392b 100%);
        }

        .status-indicator.suggestion {
            background: linear-gradient(180deg, #f39c12 0%, #e67e22 100%);
        }

        .status-indicator.positive {
            background: linear-gradient(180deg, #27ae60 0%, #229954 100%);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .chat-container {
                height: 90vh;
                border-radius: 15px;
            }

            .chat-header {
                padding: 15px 20px;
            }

            .header-left i {
                font-size: 24px;
                padding: 10px;
            }

            .header-info h1 {
                font-size: 18px;
            }

            .message-item {
                margin-bottom: 12px;
            }

            .avatar {
                width: 50px;
                height: 50px;
                margin: 15px;
                font-size: 18px;
            }

            .message-content {
                padding: 15px 15px 15px 0;
            }

            .sender-name {
                font-size: 15px;
            }

            .message-actions {
                flex-wrap: wrap;
                gap: 8px;
            }

            .reply-btn, .delete-btn {
                font-size: 12px;
                padding: 8px 16px;
            }
        }

        /* Scrollbar Styling */
        .messages-container::-webkit-scrollbar {
            width: 6px;
        }

        .messages-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .messages-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .messages-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        .modern-card {
            box-shadow: 0 4px 18px rgba(102, 126, 234, 0.10);
            border-radius: 18px;
            margin-bottom: 18px;
            display: flex;
            align-items: flex-start;
            background: #fff;
            transition: box-shadow 0.3s, transform 0.3s;
            border: 1.5px solid #f1f5f9;
        }
        .modern-card:hover {
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.18);
            transform: translateY(-2px) scale(1.01);
        }
        .avatar-initial {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 18px 18px 0 18px;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.10);
            flex-shrink: 0;
        }
        .sender-email-badge {
            display: inline-block;
            background: #f1f5f9;
            color: #64748b;
            font-size: 12px;
            border-radius: 8px;
            padding: 2px 8px;
            margin-top: 2px;
            margin-bottom: 2px;
        }
        .message-subject-badge {
            display: inline-block;
            font-size: 13px;
            font-weight: 600;
            border-radius: 8px;
            padding: 4px 12px;
            margin-bottom: 8px;
            margin-top: 2px;
        }
        .message-actions {
            display: flex;
            gap: 8px;
            margin-top: 8px;
        }
        .action-btn {
            padding: 7px 12px;
            font-size: 15px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s, box-shadow 0.2s;
        }
        .reply-btn {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
        }
        .reply-btn:hover {
            background: linear-gradient(135deg, #2980b9 0%, #3498db 100%);
        }
        .delete-btn {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
        }
        .delete-btn:hover {
            background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px);}
            to { opacity: 1; transform: translateY(0);}
        }
        @media (max-width: 768px) {
            .modern-card {
                flex-direction: column;
                align-items: stretch;
            }
            .avatar-initial {
                margin: 16px auto 0 auto;
            }
        }
    </style>

    <script>
        function replyToMessage(email, subject) {
            const mailtoLink = `mailto:${email}?subject=Re: ${encodeURIComponent(subject)}`;
            window.location.href = mailtoLink;
        }

        function deleteMessage(button, deleteUrl) {
            if (confirm('Hapus pesan ini?')) {
                window.location.href = deleteUrl;
            }
        }

        function showSuccessAlert() {
            const alert = document.getElementById('successAlert');
            alert.style.display = 'flex';
            
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.3s ease';
                
                setTimeout(() => {
                    alert.style.display = 'none';
                    alert.style.opacity = '1';
                }, 300);
            }, 3000);
        }

        // Add smooth scrolling
        document.addEventListener('DOMContentLoaded', function() {
            const messagesContainer = document.querySelector('.messages-container');
            messagesContainer.scrollTop = 0;
        });
    </script>
</body>
</html>