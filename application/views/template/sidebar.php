<!-- Sidebar Toggle Button (moved outside sidebar) -->
<button id="sidebarToggle" class="sidebar-toggle">
    <span class="toggle-icon">☰</span>
</button>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="logo" style="margin-top: 60px;">ZE Vapestore</div>
    <nav>
        <ul>
            <li>
                <a href="<?php echo site_url('index.php/Dashboard/admin_dashboard'); ?>" 
                   class="<?php echo ($this->uri->segment(2) == 'admin_dashboard' || $this->uri->segment(2) == 'Dashboard' && $this->uri->segment(3) == '') ? 'active' : ''; ?>">
                   <span class="icon">📊</span>
                   <span class="menu-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('index.php/Dashboard/role_management'); ?>" 
                   class="<?php echo ($this->uri->segment(2) == 'role_management') ? 'active' : ''; ?>">
                   <span class="icon">👥</span>
                   <span class="menu-text">Role Management</span>
                </a>
            </li>
            
            <!-- SCM Dropdown -->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle <?php echo (in_array($this->uri->segment(2), ['view_product', 'view_supplier', 'view_category', 'pembelian'])) ? 'active' : ''; ?>">
                    <span class="icon">📋</span>
                    <span class="menu-text">SCM</span>
                    <span class="dropdown-arrow">▼</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="<?php echo site_url('index.php/Produk/view_product'); ?>" 
                           class="<?php echo ($this->uri->segment(2) == 'view_product') ? 'active' : ''; ?>">
                           <span class="icon">📦</span>
                           <span class="menu-text">Products</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('index.php/Supplier/view_supplier'); ?>" 
                           class="<?php echo ($this->uri->segment(2) == 'view_supplier') ? 'active' : ''; ?>">
                           <span class="icon">🏭</span>
                           <span class="menu-text">Supplier</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('index.php/category/view_category'); ?>" 
                           class="<?php echo ($this->uri->segment(2) == 'view_category') ? 'active' : ''; ?>">
                           <span class="icon">📂</span>
                           <span class="menu-text">Kategori</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('index.php/Pembelian/pembelian'); ?>" 
                           class="<?php echo ($this->uri->segment(2) == 'pembelian') ? 'active' : ''; ?>">
                           <span class="icon">🛒</span>
                           <span class="menu-text">Pembelian</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('index.php/Scm/laporan'); ?>"
                           class="<?php echo (strtolower($this->uri->segment(1)) == 'scm' && $this->uri->segment(2) == 'laporan') ? 'active' : ''; ?>">
                           <span class="icon">📈</span>
                           <span class="menu-text">Laporan SCM</span>
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- CRM Dropdown -->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle <?php echo (in_array($this->uri->segment(2), ['view_customer', 'penjualan', 'complaint'])) ? 'active' : ''; ?>">
                    <span class="icon">👥</span>
                    <span class="menu-text">CRM</span>
                    <span class="dropdown-arrow">▼</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="<?php echo site_url('index.php/Dashboard/customer_management'); ?>" 
                           class="<?php echo ($this->uri->segment(2) == 'customer_management') ? 'active' : ''; ?>">
                           <span class="icon">👤</span>
                           <span class="menu-text">Member</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('index.php/Penjualan/penjualan'); ?>" 
                           class="<?php echo ($this->uri->segment(2) == 'penjualan') ? 'active' : ''; ?>">
                           <span class="icon">🧾</span>
                           <span class="menu-text">Penjualan</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('index.php/Complaint/admin'); ?>" 
                           class="<?php echo (strtolower($this->uri->segment(1)) == 'complaint') ? 'active' : ''; ?>">
                           <span class="icon">📝</span>
                           <span class="menu-text">Complaints & Suggestions</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('index.php/Crm/laporan'); ?>" 
                           class="<?php echo (strtolower($this->uri->segment(1)) == 'crm' && $this->uri->segment(2) == 'laporan') ? 'active' : ''; ?>">
                           <span class="icon">📈</span>
                           <span class="menu-text">Laporan CRM</span>
                        </a>
                    </li>
                </ul>

            </li>
            
            <!-- Setting Dropdown -->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle <?php echo (in_array($this->uri->segment(2), ['change_profile', 'change_password'])) ? 'active' : ''; ?>">
                   <span class="icon">⚙️</span>
                    <span class="menu-text">Setting</span>
                    <span class="dropdown-arrow">▼</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="<?php echo site_url('index.php/account/change_profile'); ?>" class="<?php echo ($this->uri->segment(2) == 'change_profile') ? 'active' : ''; ?>">
                            <span class="icon">👤</span>
                            <span class="menu-text">Ubah Profil</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('index.php/account/change_password'); ?>" class="<?php echo ($this->uri->segment(2) == 'change_password') ? 'active' : ''; ?>">
                            <span class="icon">🔒</span>
                            <span class="menu-text">Ubah Password</span>
                        </a>
                    </li>
                </ul>
            </li>
            
            <li>
                <a href="#" onclick="showLogoutModal(); return false;">
                    <span class="icon">🚪</span>
                    <span class="menu-text">Logout</span>
                </a>
            </li>
        </ul>
    </nav>
    <?php $this->load->view('template/logout_modal'); ?>
</div>

<style>
/* Sidebar Toggle Button */
.sidebar-toggle {
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 1200; /* make sure it's above sidebar */
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    color: white;
    font-size: 20px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.sidebar-toggle:hover {
    transform: scale(1.1);
}

/* Sidebar Styles */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 280px;
    height: 100vh;
    background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
    color: #fff;
    display: flex;
    flex-direction: column;
    padding: 2rem 1.5rem;
    box-shadow: 4px 0 20px rgba(0,0,0,0.15);
    z-index: 1000;
    transition: all 0.3s ease;
}

.sidebar.collapsed {
    width: 80px;
    padding: 2rem 0.5rem;
}

.sidebar.collapsed .logo {
    font-size: 0;
    margin-bottom: 2rem;
}

.sidebar.collapsed .menu-text,
.sidebar.collapsed .dropdown-arrow {
    display: none;
}

.sidebar.collapsed .dropdown-menu {
    position: absolute;
    left: 100%;
    top: 0;
    width: 200px;
    background: #1e293b;
    border-radius: 0 8px 8px 0;
    margin-left: 0;
    border-left: none;
    display: none;
}

.sidebar.collapsed .dropdown:hover .dropdown-menu {
    display: block;
}

.sidebar .logo {
    font-size: 1.8rem;
    font-weight: 800;
    margin-bottom: 3rem;
    text-align: center;
    letter-spacing: 3px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    transition: all 0.3s ease;
    margin-top: 60px; /* add space for toggle button */
}

.sidebar nav ul {
    flex-grow: 1;
}

.sidebar nav ul li {
    margin-bottom: 0.5rem;
}

.sidebar nav ul li a {
    color: #cbd5e1;
    font-weight: 500;
    display: flex;
    align-items: center;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.sidebar nav ul li a .icon {
    margin-right: 10px;
    font-size: 1.2rem;
    min-width: 24px;
    text-align: center;
}

.sidebar nav ul li a .menu-text {
    flex-grow: 1;
}

.sidebar nav ul li a:before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    transition: left 0.5s;
}

.sidebar nav ul li a:hover:before {
    left: 100%;
}

.sidebar nav ul li a:hover,
.sidebar nav ul li a.active {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
    transform: translateX(5px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

/* Dropdown Styles */
.sidebar .dropdown {
    position: relative;
}

.sidebar .dropdown-toggle {
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
}

.sidebar .dropdown-arrow {
    transition: transform 0.3s ease;
    font-size: 12px;
}

.sidebar .dropdown.open .dropdown-arrow {
    transform: rotate(180deg);
}

.sidebar .dropdown-menu {
    display: none;
    background-color: rgba(255, 255, 255, 0.1);
    margin-left: 20px;
    border-left: 2px solid rgba(255, 255, 255, 0.2);
}

.sidebar .dropdown.open .dropdown-menu {
    display: block;
}

.sidebar .dropdown-menu li {
    margin: 0;
}

.sidebar .dropdown-menu a {
    padding: 8px 15px;
    font-size: 14px;
    opacity: 0.8;
}

.sidebar .dropdown-menu a:hover {
    opacity: 1;
    background-color: rgba(255, 255, 255, 0.1);
}

.sidebar .dropdown-menu a.active {
    opacity: 1;
    background-color: rgba(255, 255, 255, 0.2);
}

/* Main Content Adjustment */
.main-content {
    margin-left: 280px;
    transition: margin-left 0.3s ease;
}

.main-content.expanded {
    margin-left: 80px;
}

/* Responsive */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
    }
    
    .sidebar.show {
        transform: translateX(0);
    }
    
    .main-content {
        margin-left: 0;
    }
    
    .main-content.expanded {
        margin-left: 0;
    }
    
    .sidebar-toggle {
        top: 15px;
        left: 15px;
    }
    
    .sidebar .logo {
        margin-top: 60px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContent = document.querySelector('.main-content');
    
    // Toggle sidebar
    sidebarToggle.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
    });
    
    // Dropdown functionality
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    dropdownToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            // Only prevent default if href is '#'
            if (this.getAttribute('href') === '#') {
            e.preventDefault();
            }
            const dropdown = this.parentElement;
            // Close other dropdowns
            document.querySelectorAll('.dropdown').forEach(function(item) {
                if (item !== dropdown) {
                    item.classList.remove('open');
                }
            });
            // Toggle current dropdown
            dropdown.classList.toggle('open');
        });
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown').forEach(function(dropdown) {
                dropdown.classList.remove('open');
            });
        }
    });
    
    // Keep dropdown open if current page is in dropdown
    const activeDropdownItems = document.querySelectorAll('.dropdown-menu a.active');
    activeDropdownItems.forEach(function(item) {
        const dropdown = item.closest('.dropdown');
        if (dropdown) {
            dropdown.classList.add('open');
        }
    });
    
    // Close dropdown after clicking a submenu link
    document.querySelectorAll('.dropdown-menu a').forEach(function(link) {
        link.addEventListener('click', function() {
            document.querySelectorAll('.dropdown').forEach(function(dropdown) {
                dropdown.classList.remove('open');
            });
        });
    });
    
    // Handle mobile sidebar
    function handleMobileSidebar() {
        if (window.innerWidth <= 768) {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('expanded');
        } else {
            sidebar.classList.remove('collapsed');
            mainContent.classList.remove('expanded');
        }
    }
    
    // Initial check
    handleMobileSidebar();
    
    // Check on resize
    window.addEventListener('resize', handleMobileSidebar);
});
</script>