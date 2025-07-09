<!-- Logout Modal -->
<div id="logoutModal" class="modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Confirm Logout</h3>
                <span class="close" onclick="closeLogoutModal()">&times;</span>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to logout?</p>
            </div>
            <div class="modal-footer">
                <button class="btn-cancel" onclick="closeLogoutModal()">Cancel</button>
                <a href="<?php echo base_url('index.php/Auth/logout'); ?>" class="btn-logout">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Forbidden Access Modal -->
<div class="modal" id="forbiddenModal" tabindex="-1" aria-labelledby="forbiddenModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="forbiddenModalLabel">Access Denied</h5>
                <button type="button" class="btn-close" onclick="closeForbiddenModal()" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body text-center">
                <p>You do not have access to this page. Please go back to the previous page.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-danger" onclick="window.history.back()">Back</button>
            </div>
        </div>
    </div>
</div>

<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(3px);
        animation: fadeIn 0.2s ease-out;
    }
    .modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .modal-dialog {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding: 20px;
    }
    .modal-dialog-centered {
        min-height: calc(100vh - 3.5rem);
    }
    .modal-content {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        width: 100%;
        max-width: 450px;
        position: relative;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        transform: scale(0.9);
        animation: modalSlideIn 0.3s ease-out forwards;
    }
    .modal-header {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        padding: 24px 28px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    .modal-header.bg-danger {
        background: linear-gradient(135deg, #ff416c 0%, #ff4757 100%);
    }
    .modal-title, .modal-header h3 {
        margin: 0;
        color: #ffffff;
        font-size: 20px;
        font-weight: 600;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    .close, .btn-close {
        color: #ffffff;
        font-size: 24px;
        font-weight: 300;
        cursor: pointer;
        background: none;
        border: none;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.2s ease;
    }
    .close:hover, .btn-close:hover {
        background-color: rgba(255, 255, 255, 0.2);
        transform: rotate(90deg);
    }
    .modal-body {
        padding: 32px 28px;
        text-align: center;
        background: rgba(255, 255, 255, 0.95);
        color: #2c3e50;
    }
    .modal-body p {
        margin: 0;
        font-size: 16px;
        font-weight: 500;
        line-height: 1.5;
        color: #2c3e50;
    }
    .modal-footer {
        padding: 20px 28px 28px;
        display: flex;
        gap: 12px;
        background: rgba(255, 255, 255, 0.95);
    }
    .modal-footer.justify-content-center {
        justify-content: center;
    }
    .modal-footer:not(.justify-content-center) {
        justify-content: flex-end;
    }
    .btn-cancel, .btn-logout, .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        min-width: 100px;
    }
    .btn-cancel {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
    }
    .btn-cancel:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
        background: linear-gradient(135deg, #5a6268 0%, #3e4145 100%);
    }
    .btn-logout, .btn-danger {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
    }
    .btn-logout:hover, .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
        background: linear-gradient(135deg, #c0392b 0%, #a93226 100%);
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes modalSlideIn {
        from {
            transform: scale(0.9) translateY(-20px);
            opacity: 0;
        }
        to {
            transform: scale(1) translateY(0);
            opacity: 1;
        }
    }
    @media (max-width: 576px) {
        .modal-content {
            max-width: 95%;
            margin: 20px;
        }
        .modal-header, .modal-body, .modal-footer {
            padding-left: 20px;
            padding-right: 20px;
        }
        .modal-footer {
            flex-direction: column;
        }
        .btn-cancel, .btn-logout, .btn {
            width: 100%;
        }
    }
</style>
<script>
    // Logout Modal Functions
    function showLogoutModal() {
        const modal = document.getElementById('logoutModal');
        modal.style.display = 'flex';
        setTimeout(() => modal.classList.add('show'), 10);
    }
    function closeLogoutModal() {
        const modal = document.getElementById('logoutModal');
        modal.classList.remove('show');
        setTimeout(() => modal.style.display = 'none', 200);
    }
    // Forbidden Modal Functions
    function showForbiddenModal() {
        const modal = document.getElementById('forbiddenModal');
        modal.style.display = 'flex';
        setTimeout(() => modal.classList.add('show'), 10);
    }
    function closeForbiddenModal() {
        const modal = document.getElementById('forbiddenModal');
        modal.classList.remove('show');
        setTimeout(() => modal.style.display = 'none', 200);
    }
    // Close modal when clicking outside
    window.onclick = function(event) {
        const logoutModal = document.getElementById('logoutModal');
        const forbiddenModal = document.getElementById('forbiddenModal');
        if (event.target === logoutModal) {
            closeLogoutModal();
        }
        if (event.target === forbiddenModal) {
            closeForbiddenModal();
        }
    }
    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeLogoutModal();
            closeForbiddenModal();
        }
    });
</script> 