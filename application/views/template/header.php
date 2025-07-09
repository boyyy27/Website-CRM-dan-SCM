<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <!-- jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <link rel="icon" type="image/png" href="https://i.ibb.co/whrNy6j6/Pngtree-vape-device-8133386.png" />

    <style>
        /* Reset and base styles */
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
            min-height: 100vh;
        }
        a {
            text-decoration: none;
            color: inherit;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* Sidebar */
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

        /* Main content */
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            min-height: 100vh;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .content-header {
            background: linear-gradient(135deg, #ffffff, #f8fafc);
            padding: 2rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.2);
        }
        .content-header h1 {
            font-size: 2.5rem;
            margin: 0;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }
        .content-header p {
            margin: 0.5rem 0 0 0;
            color: #64748b;
            font-size: 1.1rem;
        }

        /* Alert messages */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: slideIn 0.3s ease-out;
        }
        .alert.success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        .alert.error {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Add user button */
        .btn-add-user {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 2rem;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-add-user:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }
        .btn-add-user:active {
            transform: translateY(0);
        }

          .btn-add-category {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 2rem;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-add-category:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }
        .btn-add-category:active {
            transform: translateY(0);
        }
        .btn-add-product {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 2rem;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-add-product:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }
        .btn-add-product:active {
            transform: translateY(0);
        }

         .btn-add-supplier {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 2rem;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-add-supplier:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }
        .btn-add-supplier:active {
            transform: translateY(0);
        }

        /* Table */
        .table-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 1.5rem 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
        }
        th {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        tbody tr {
            transition: all 0.3s ease;
        }
        tbody tr:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
            transform: scale(1.01);
        }
        tbody tr:last-child td {
            border-bottom: none;
        }

        /* Status styling */
        .status-active {
            color: #10b981;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 20px;
            font-size: 0.85rem;
        }
        .status-inactive {
            color: #ef4444;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            background: rgba(239, 68, 68, 0.1);
            border-radius: 20px;
            font-size: 0.85rem;
        }

        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        .btn-action {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-edit {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }
        .btn-delete {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }
        .btn-action:hover {
            transform: translateY(-2px) scale(1.1);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            animation: fadeIn 0.3s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .modal-content {
            background: linear-gradient(135deg, #ffffff, #f8fafc);
            margin: 5% auto;
            padding: 0;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 25px 80px rgba(0,0,0,0.3);
            animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            position: relative;
            border: 1px solid rgba(255,255,255,0.2);
            overflow: hidden;
        }
        @keyframes slideUp {
            from { transform: translateY(50px) scale(0.9); opacity: 0; }
            to { transform: translateY(0) scale(1); opacity: 1; }
        }
        .modal-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
        }
        .modal-header h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
        }
        .close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            color: rgba(255,255,255,0.8);
            font-size: 28px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        .close:hover {
            background: rgba(255,255,255,0.2);
            color: white;
            transform: rotate(90deg);
        }
        .modal-body {
            padding: 2rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.8);
        }
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: white;
        }
        .modal-footer {
            padding: 1.5rem 2rem 2rem;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }
        .btn-modal {
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 1rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }
        .btn-secondary {
            background: #6b7280;
            color: white;
        }
        .btn-modal:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        /* Delete confirmation modal */
        .delete-confirmation {
            text-align: center;
            padding: 1rem 0;
        }
        .delete-icon {
            font-size: 4rem;
            color: #ef4444;
            margin-bottom: 1rem;
            display: block;
        }
        .delete-text {
            font-size: 1.1rem;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        .delete-username {
            font-weight: 700;
            color: #ef4444;
            font-size: 1.2rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .main-content {
                margin-left: 0;
            }
            .modal-content {
                margin: 10% auto;
                width: 95%;
            }
            .table-container {
                overflow-x: auto;
            }
        }

        .sidebar nav ul li a.active {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    transform: translateX(5px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

    </style>
</head>
