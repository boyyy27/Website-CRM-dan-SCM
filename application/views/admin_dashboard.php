<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard - ZE Vapestore</title>
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

    /* Dashboard cards */
    .dashboard-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2rem;
    }
    .card {
      background: #fff;
      border-radius: 12px;
      padding: 1.5rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      font-weight: 600;
      color: #1e293b;
    }
    .card h2 {
      font-size: 1.5rem;
      margin-bottom: 0.5rem;
    }
    .card p {
      font-size: 1rem;
      color: #64748b;
    }

    /* Table */
    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 1rem;
      text-align: left;
      border-bottom: 1px solid #e2e8f0;
    }
    th {
      background-color: #667eea;
      color: white;
      font-weight: 600;
    }
    tr:hover {
      background-color: #f1f5f9;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        position: relative;
        width: 100%;
        height: auto;
        flex-direction: row;
        padding: 0.5rem;
      }
      .sidebar .logo {
        margin-bottom: 0;
        flex-grow: 1;
        text-align: left;
      }
      .sidebar nav ul {
        display: flex;
        flex-direction: row;
        gap: 1rem;
      }
      .sidebar nav ul li {
        margin-bottom: 0;
      }
      .main-content {
        margin-left: 0;
        padding: 1rem;
      }
      .dashboard-cards {
        grid-template-columns: 1fr;
      }
    }

    /* Sales Cards */
    .sales-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 24px;
      margin: 32px 0;
    }
    .sale-card {
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 2px 12px #0001;
      padding: 24px 20px 16px 20px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      min-height: 210px;
      transition: box-shadow 0.2s;
    }
    .sale-card:hover {
      box-shadow: 0 6px 24px #0002;
    }
    .sale-card .card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }
    .sale-card .invoice {
      font-weight: 700;
      color: #2563eb;
      font-size: 1.1rem;
    }
    .sale-card .card-body {
      margin-bottom: 12px;
      color: #374151;
      font-size: 1rem;
    }
    .sale-card .card-actions {
      display: flex;
      gap: 10px;
      justify-content: flex-end;
    }
    .status-badge {
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 500;
      text-transform: uppercase;
    }
    .status-lunas {
      background-color: #d1fae5;
      color: #065f46;
    }
    .status-belum_lunas {
      background-color: #fee2e2;
      color: #dc2626;
    }

    /* Purchase Cards */
    .purchase-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 24px;
      margin: 32px 0;
    }
    .purchase-card {
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 2px 12px #0001;
      padding: 24px 20px 16px 20px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      min-height: 180px;
      transition: box-shadow 0.2s;
    }
    .purchase-card:hover {
      box-shadow: 0 6px 24px #0002;
    }
    .purchase-card .card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }
    .purchase-card .invoice {
      font-weight: 700;
      color: #2563eb;
      font-size: 1.1rem;
    }
    .purchase-card .card-body {
      margin-bottom: 12px;
      color: #374151;
      font-size: 1rem;
    }
    .purchase-card .card-actions {
      display: flex;
      gap: 10px;
      justify-content: flex-end;
    }
    .status-diterima {
      background-color: #d1fae5;
      color: #065f46;
    }
    .status-dipesan {
      background-color: #fee2e2;
      color: #dc2626;
    }
    .status-dibatalkan {
      background-color: #fef3c7;
      color: #d97706;
    }

    /* Grafik Penjualan Per Bulan & Top Products Pie Chart */
    .dashboard-charts-row {
      display: flex;
      gap: 1rem;
      margin: 2rem 0;
      background: none;
      box-shadow: none;
      padding: 0;
      align-items: stretch;
      flex-wrap: wrap;
    }
    .dashboard-chart-col {
      flex: 1 1 350px;
      min-width: 300px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .dashboard-chart-col.revenue-col {
      flex: 1.5 1 600px;
    }
    .dashboard-chart-col .card {
      width: 100%;
      max-width: 430px;
      min-height: 380px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 2rem 1rem;
    }
    .dashboard-chart-col.revenue-col .card {
      max-width: 1200px;
      min-height: 420px;
    }
    .dashboard-chart-col canvas {
      width: 100% !important;
      max-width: 350px;
      height: 260px !important;
      max-height: 260px;
    }
    .dashboard-chart-col.revenue-col canvas {
      max-width: 900px;
      height: 340px !important;
      max-height: 340px;
    }
  </style>

  <!-- DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

  <!-- DataTables JS -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

  <script>
    $(document).ready(function() {
      $('#recent-orders-table').DataTable({
        "pageLength": 5,
        "order": [[2, "desc"]]
      });
      $('#recent-sales-table').DataTable({
        "pageLength": 5,
        "order": [[2, "desc"]]
      });
      $('#recent-purchases-table').DataTable({
        "pageLength": 5,
        "order": [[2, "desc"]]
      });
      $('#top-customers-table').DataTable({
        "pageLength": 5,
        "order": [[2, "desc"]], // Sort by total purchase amount
        "columns": [
          null, // Customer ID
          null, // Name
          { "type": "num-fmt" }, // Total Purchase (formatted number)
          { "type": "num" }  // Transactions
        ]
      });
      $('#top-products-table').DataTable({
        "pageLength": 5,
        "order": [[3, "desc"]], // Sort by total sold
        "columns": [
          null, // Product Code
          null, // Product Name
          null, // Category
          { "type": "num" }, // Total Sold
          { "type": "num-fmt" } // Total Revenue
        ]
      });
      $('#fast-slow-moving-table').DataTable({
        "pageLength": 10,
        "order": [[3, "desc"]], // Sort by total sold
        "columns": [
          null, // Product Code
          null, // Product Name
          null, // Category
          { "type": "num" }, // Total Sold
          { "type": "num-fmt" }, // Total Revenue
          null // Status
        ]
      });
    });
  </script>
</head>

   <div class="main-content">
    <!-- Greeting -->
    
    <!-- Header -->
    <div class="content-header">
    <div style="margin-bottom: 1.5rem;">
      <h2 style="font-size:1.5rem;font-weight:700;color:#6366f1;">
        Halo, <?php echo htmlspecialchars($this->session->userdata('nama_lengkap') ?? $this->session->userdata('username') ?? 'User'); ?> 👋<br>
        <span style="font-size:1.1rem;font-weight:400;color:#374151;">Selamat datang di halaman admin</span>
      </h2>
    </div>
        <h1>Admin Dashboard </h1>
        
        <p>Monitoring user roles, permissions, and access levels</p>
        
    </div>
    <div class="dashboard-cards">
      <div class="card">
        <h2>Orders</h2>
        <p><?php echo $orders_count; ?></p>
      </div>
      <div class="card">
        <h2>Products</h2>
        <p><?php echo $products_count; ?></p>
      </div>
      <div class="card">
        <h2>Member</h2>
        <p><?php echo $customers_count; ?></p>
      </div>
  </div>

  <!-- Grafik Penjualan Per Bulan & Top Products Pie Chart -->
  <div class="dashboard-charts-row">
    <div class="dashboard-chart-col revenue-col">
      <div class="card">
        <h2 style="margin: 0 0 1.5rem 0; text-align: center; color: #333;">Revenue</h2>
        <canvas id="salesChart"></canvas>
      </div>
    </div>
    <div class="dashboard-chart-col">
      <div class="card">
        <h2 style="margin: 0 0 1.5rem 0; text-align: center; color: #333;">Top Products</h2>
        <canvas id="topProductsPie"></canvas>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    <?php
    // Siapkan array bulan Jan–Des
    $all_months = ['01','02','03','04','05','06','07','08','09','10','11','12'];
    $month_names = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    $chart_data = [];
    foreach ($all_months as $i => $m) {
        $found = false;
        if (!empty($sales_chart)) {
            foreach ($sales_chart as $row) {
                $parts = explode('-', $row->bulan);
                if (isset($parts[1]) && (int)$parts[1] == (int)$m) {
                    $chart_data[] = (int)$row->total_penjualan;
                    $found = true;
                    break;
                }
            }
        }
        if (!$found) $chart_data[] = 0;
    }
    ?>
    const labels = <?php echo json_encode($month_names); ?>;
    const data = <?php echo json_encode($chart_data); ?>;
    // Gradasi oranye untuk batang
    function getBarGradient(ctx, chartArea) {
      const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
      gradient.addColorStop(0, '#ffb347'); // oranye muda
      gradient.addColorStop(1, '#ff8008'); // oranye tua
      return gradient;
    }
    const ctx = document.getElementById('salesChart').getContext('2d');
    let barGradient;
    const salesChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Revenue',
            data: data,
            backgroundColor: function(context) {
              const chart = context.chart;
              const {ctx, chartArea} = chart;
              if (!chartArea) return '#ffb347';
              if (!barGradient) barGradient = getBarGradient(ctx, chartArea);
              return barGradient;
            },
            borderColor: '#ff8008',
            borderWidth: 1.5,
            borderRadius: 4,
            maxBarThickness: 40,
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false },
          title: {
            display: false
          }
        },
        layout: {
          padding: { top: 20, right: 20, bottom: 20, left: 20 }
        },
        scales: {
          x: {
            title: {
              display: true,
              text: 'Month',
              color: '#333',
              font: { size: 16 }
            },
            grid: {
              display: false
            },
            ticks: {
              color: '#333',
              font: { size: 14 }
            }
          },
          y: {
            title: {
              display: true,
              text: 'Rp.',
              color: '#333',
              font: { size: 16 }
            },
            grid: {
              color: '#ddd',
              lineWidth: 1
            },
            ticks: {
              color: '#333',
              font: { size: 14 },
              callback: function(value) {
                return value;
              }
            }
          }
        }
      },
      plugins: [{
        beforeDraw: function(chart) {
          barGradient = null; // Reset gradient saat resize
        }
      }]
    });

    // Pie Chart for Top Products
    const topProductsLabels = <?php echo json_encode(array_map(function($p){return $p->nama_produk;}, $top_products)); ?>;
    const topProductsData = <?php echo json_encode(array_map(function($p){return (int)$p->total_terjual;}, $top_products)); ?>;
    const topProductsColors = [
      '#667eea', '#764ba2', '#ffb347', '#ff8008', '#36a2eb'
    ];
    const pieCtx = document.getElementById('topProductsPie').getContext('2d');
    const topProductsPie = new Chart(pieCtx, {
      type: 'pie',
      data: {
        labels: topProductsLabels,
        datasets: [{
          data: topProductsData,
          backgroundColor: topProductsColors,
          borderColor: '#fff',
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'right', align: 'center' },
          title: { display: false }
        }
      }
    });
  </script>

    <!-- Low Stock Alert -->
    <div class="alert <?php echo !empty($low_stock_products) ? 'alert-warning' : 'alert-success'; ?>" style="margin-top:2rem;padding:1rem;border-radius:8px;background:<?php echo !empty($low_stock_products) ? '#fef3c7' : '#d1fae5'; ?>;color:<?php echo !empty($low_stock_products) ? '#d97706' : '#065f46'; ?>;">
      <strong>Stock Status:</strong>
      <?php if (!empty($low_stock_products)): ?>
        <?php echo count($low_stock_products); ?> products have less than 3 items in stock:
        <ul style="margin-top:0.5rem;margin-bottom:0;padding-left:1.5rem;">
          <?php foreach ($low_stock_products as $product): ?>
            <li><?php echo htmlspecialchars($product->nama_produk); ?> (Stock: <?php echo $product->jumlah_stok; ?>)</li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        All products are well stocked.
      <?php endif; ?>
    </div>

    <!-- Fast Moving & Slow Moving Products Section -->
    <h2 style="margin-top:2rem;">Fast Moving & Slow Moving Products</h2>
    <div class="table-responsive">
      <table id="fast-slow-moving-table" class="table">
        <thead>
          <tr>
            <th>Product Code</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Total Sold</th>
            <th>Total Revenue</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($fast_slow_moving)): foreach ($fast_slow_moving as $product): ?>
            <tr>
              <td><?php echo htmlspecialchars($product['kode_produk'] ?? ''); ?></td>
              <td><?php echo htmlspecialchars($product['nama_produk'] ?? ''); ?></td>
              <td><?php echo htmlspecialchars($product['nama_kategori'] ?? ''); ?></td>
              <td><?php echo number_format($product['total_terjual'] ?? 0); ?></td>
              <td>Rp <?php echo number_format($product['total_pendapatan'] ?? 0, 0, ',', '.'); ?></td>
              <td>
                <span class="status-badge <?php echo ($product['kategori'] ?? '') == 'Fast Moving' ? 'status-lunas' : 'status-belum_lunas'; ?>">
                  <?php echo htmlspecialchars($product['kategori'] ?? ''); ?>
                </span>
              </td>
            </tr>
          <?php endforeach; else: ?>
            <tr><td colspan="6" style="text-align:center;color:#64748b;">No product data found</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    
    <!-- Top Customers Section -->
    <h2 style="margin-top:2rem;">Top Member</h2>
    <div class="table-responsive">
      <table id="top-customers-table" class="table">
        <thead>
          <tr>
            <th>Customer ID</th>
            <th>Name</th>
            <th>Total Purchase</th>
            <th>Transactions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($top_customers)): foreach ($top_customers as $customer): ?>
            <tr>
              <td><?php echo htmlspecialchars($customer->kode_customer); ?></td>
              <td><?php echo htmlspecialchars($customer->nama_lengkap); ?></td>
              <td>Rp <?php echo number_format($customer->total_pembelian, 0, ',', '.'); ?></td>
              <td><?php echo number_format($customer->jumlah_transaksi); ?></td>
            </tr>
          <?php endforeach; else: ?>
            <tr><td colspan="4" style="text-align:center;color:#64748b;">No customer data found</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Analitik Perilaku Pelanggan (Offline) -->
    <h2 style="margin-top:2rem; margin-bottom:1rem; display:flex; align-items:center; gap:10px; font-size:1.6rem;">
      <span style="font-size:1.5em; color:#059669;">&#128200;</span> Analitik Perilaku Pelanggan (Offline)
    </h2>
    <div style="margin-bottom:1.5rem;">
      <input id="search-customer-analytics" type="text" placeholder="Cari nama pelanggan..." style="width: 320px; max-width:100%; padding: 10px 16px; border-radius: 8px; border: 1px solid #d1d5db; font-size: 1rem; outline: none; box-shadow: 0 1px 4px #667eea11;">
    </div>
    <div id="customer-analytics-list" style="display: flex; flex-wrap: wrap; gap: 1.5rem; margin-bottom:2rem;">
      <?php if (!empty($customer_analytics)): foreach ($customer_analytics as $cid => $data): ?>
        <div class="customer-analytics-card" data-name="<?php echo strtolower(htmlspecialchars($data['nama_lengkap'])); ?>" style="background: linear-gradient(135deg, #f8fafc 60%, #e0e7ff 100%); border-radius: 18px; box-shadow: 0 4px 16px #667eea22; padding: 1.5rem 2rem; min-width: 260px; max-width: 340px; flex:1; display: flex; flex-direction: column; align-items: flex-start; position:relative;">
          <div style="display:flex; align-items:center; gap:14px; margin-bottom:1rem;">
            <?php if (!empty($data['foto'])): ?>
              <img src="<?php echo base_url('assets/uploads/' . $data['foto']); ?>" alt="Foto" style="width:48px; height:48px; border-radius:50%; object-fit:cover; border:2px solid #667eea33; background:#fff;">
            <?php else: ?>
              <div style="width:48px; height:48px; border-radius:50%; background:#667eea22; display:flex; align-items:center; justify-content:center; font-size:2rem; font-weight:700; color:#667eea;">
                <span><?php echo strtoupper(substr($data['nama_lengkap'],0,1)); ?></span>
              </div>
            <?php endif; ?>
            <div>
              <div style="font-weight:700; font-size:1.1rem; color:#1e293b; margin-bottom:2px;">
                <?php echo htmlspecialchars($data['nama_lengkap']); ?>
              </div>
              <?php if ($cid === null): ?>
                <div style="font-size:0.95rem; color:#10b981; font-weight:600;">Non Member</div>
              <?php else: ?>
                <div style="font-size:0.95rem; color:#64748b;">Pelanggan</div>
              <?php endif; ?>
            </div>
          </div>
          <div style="width:100%; margin-bottom:0.5rem; font-size:1.05rem; color:#374151; font-weight:600;">Top Produk Favorit:</div>
          <ul style="margin:0 0 0.5rem 0; padding-left:1.2em; width:100%;">
            <?php foreach ($data['produk'] as $i => $prod): ?>
              <li style="margin-bottom:4px; font-size:1rem; <?php if($i==0): ?>font-weight:700; color:#059669;<?php endif; ?>">
                <span style="margin-right:6px; "><?php echo $i==0 ? '⭐' : '•'; ?></span>
                <?php echo htmlspecialchars($prod['nama_produk']); ?> <span style="color:#64748b; font-size:0.95em;">(<?php echo $prod['jumlah_dibeli']; ?>x)</span>
              </li>
            <?php endforeach; ?>
          </ul>
          <div style="margin-top:0.7rem; width:100%;">
            <div style="font-size:0.98rem; color:#374151; font-weight:600; margin-bottom:2px;">Rekomendasi Produk:</div>
            <ul style="margin:0; padding-left:1.2em;">
              <?php foreach (($data['rekomendasi']['populer'] ?? []) as $prod): ?>
                <li style="color:#2563eb; font-weight:500;">
                  <span style="margin-right:6px;">🔥</span><?php echo htmlspecialchars($prod['nama_produk']); ?> <span style="color:#64748b; font-size:0.95em;">(Populer)</span>
                </li>
              <?php endforeach; ?>
              <?php foreach (($data['rekomendasi']['baru'] ?? []) as $prod): ?>
                <li style="color:#059669; font-weight:500;">
                  <span style="margin-right:6px;">🆕</span><?php echo htmlspecialchars($prod['nama_produk']); ?> <span style="color:#64748b; font-size:0.95em;">(Baru)</span>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      <?php endforeach; else: ?>
        <div style="color:#64748b; font-size:1.1rem;">No analytics data found</div>
      <?php endif; ?>
    </div>
    <!-- Kartu Analitik Non Member -->
    <div class="customer-analytics-card" data-name="non member" style="background: linear-gradient(135deg, #f8fafc 60%, #e0e7ff 100%); border-radius: 18px; box-shadow: 0 4px 16px #667eea22; padding: 1.5rem 2rem; min-width: 260px; max-width: 340px; flex:1; display: flex; flex-direction: column; align-items: flex-start; position:relative;">
      <div style="display:flex; align-items:center; gap:14px; margin-bottom:1rem;">
        <div style="width:48px; height:48px; border-radius:50%; background:#10b98122; display:flex; align-items:center; justify-content:center; font-size:2rem; font-weight:700; color:#10b981;">
          <span>NM</span>
        </div>
        <div>
          <div style="font-weight:700; font-size:1.1rem; color:#1e293b; margin-bottom:2px;">Non Member</div>
          <div style="font-size:0.95rem; color:#10b981; font-weight:600;">Non Member</div>
        </div>
      </div>
      <div style="width:100%; margin-bottom:0.5rem; font-size:1.05rem; color:#374151; font-weight:600;">Top Produk Favorit:</div>
      <ul style="margin:0 0 0.5rem 0; padding-left:1.2em; width:100%;">
        <?php foreach ($non_member_analytics as $i => $prod): ?>
          <li style="margin-bottom:4px; font-size:1rem; <?php if($i==0): ?>font-weight:700; color:#059669;<?php endif; ?>">
            <span style="margin-right:6px; "><?php echo $i==0 ? '⭐' : '•'; ?></span>
            <?php echo htmlspecialchars($prod['nama_produk']); ?> <span style="color:#64748b; font-size:0.95em;">(<?php echo $prod['jumlah_dibeli']; ?>x)</span>
          </li>
        <?php endforeach; ?>
      </ul>
      <div style="margin-top:0.7rem; width:100%;">
        <div style="font-size:0.98rem; color:#374151; font-weight:600; margin-bottom:2px;">Rekomendasi Produk:</div>
        <ul style="margin:0; padding-left:1.2em;">
          <?php foreach (($customer_analytics[null]['rekomendasi']['populer'] ?? []) as $prod): ?>
            <li style="color:#2563eb; font-weight:500;">
              <span style="margin-right:6px;">🔥</span><?php echo htmlspecialchars($prod['nama_produk']); ?> <span style="color:#64748b; font-size:0.95em;">(Populer)</span>
            </li>
          <?php endforeach; ?>
          <?php foreach (($customer_analytics[null]['rekomendasi']['baru'] ?? []) as $prod): ?>
            <li style="color:#059669; font-weight:500;">
              <span style="margin-right:6px;">🆕</span><?php echo htmlspecialchars($prod['nama_produk']); ?> <span style="color:#64748b; font-size:0.95em;">(Baru)</span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
    <script>
      // Search bar filter for customer analytics
      document.getElementById('search-customer-analytics').addEventListener('input', function() {
        const val = this.value.trim().toLowerCase();
        document.querySelectorAll('#customer-analytics-list .customer-analytics-card').forEach(card => {
          const name = card.getAttribute('data-name');
          card.style.display = (!val || name.includes(val)) ? '' : 'none';
        });
      });
    </script>
  </div>
</body>
</html>
