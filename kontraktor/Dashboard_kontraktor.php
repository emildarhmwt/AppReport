<?php
session_start();
include '../Koneksi.php';
$admin_id = $_SESSION['id'];

// Fetch admin data using PostgreSQL
$sql = "SELECT nama, username, file_admin FROM kontraktor_report WHERE id = $1";
$result = pg_query_params($conn, $sql, array($admin_id));

if ($result) {
    $admin = pg_fetch_assoc($result);
    if (!$admin) {
        echo "No supervisor data found.";
        exit; // Stop execution if no data is found
    }
} else {
    echo "Error fetching supervisor data.";
    exit; // Stop execution on error
}

$sql_production = "
    SELECT COUNT(*) 
    FROM production_report
    WHERE proses_pengawas = 'Approved Pengawas' 
    AND proses_kontraktor IS NULL
    AND kontraktor = $1 
";

$sql_hourmeter = "
    SELECT COUNT(*) 
    FROM hourmeter_report
    WHERE proses_pengawas = 'Approved Pengawas'
    AND proses_kontraktor IS NULL 
    AND kontraktor = $1  
";

$rejected_production = pg_fetch_result(pg_query_params($conn, $sql_production, array($_SESSION['username'])), 0, 0);
$rejected_hourmeter = pg_fetch_result(pg_query_params($conn, $sql_hourmeter, array($_SESSION['username'])), 0, 0);

$total_rejected = $rejected_production + $rejected_hourmeter;

$sql_total_produksi = "SELECT COUNT(*) FROM production_report";
$sql_total_jamjalan = "SELECT COUNT(*) FROM hourmeter_report";

$rejected_total_produksi = pg_fetch_result(pg_query($conn, $sql_total_produksi), 0, 0);
$rejected_total_jamjalan = pg_fetch_result(pg_query($conn, $sql_total_jamjalan), 0, 0);

// Fetch production data for the current year
$current_year = date("Y");
$sql_production_data = "
    SELECT 
        EXTRACT(MONTH FROM o.tanggal) AS month,
        COUNT(CASE WHEN p.proses_admin = 'Uploaded' THEN 1 END) AS uploaded,
        COUNT(CASE WHEN p.proses_pengawas = 'Approved Pengawas' THEN 1 END) AS approved_pengawas,
        COUNT(CASE WHEN p.proses_pengawas = 'Rejected Pengawas' THEN 1 END) AS rejected_pengawas,
        COUNT(CASE WHEN p.proses_kontraktor = 'Approved Kontraktor' THEN 1 END) AS approved_kontraktor,
        COUNT(CASE WHEN p.proses_kontraktor = 'Rejected Kontraktor' THEN 1 END) AS rejected_kontraktor
    FROM 
        operation_report o
    JOIN 
        production_report p ON o.id = p.operation_report_id
    WHERE 
        EXTRACT(YEAR FROM o.tanggal) = $1
    GROUP BY 
        month
    ORDER BY 
        month;
";
$result_production_data = pg_query_params($conn, $sql_production_data, array($current_year));

// Prepare data for the chart
$months = range(1, 12);
$data = [
    'uploaded' => array_fill(0, 12, 0),
    'approved_pengawas' => array_fill(0, 12, 0),
    'rejected_pengawas' => array_fill(0, 12, 0),
    'approved_kontraktor' => array_fill(0, 12, 0),
    'rejected_kontraktor' => array_fill(0, 12, 0),
];

while ($row = pg_fetch_assoc($result_production_data)) {
    $month = (int)$row['month'] - 1; // Adjust for zero-based index
    $data['uploaded'][$month] = (int)$row['uploaded'];
    $data['approved_pengawas'][$month] = (int)$row['approved_pengawas'];
    $data['rejected_pengawas'][$month] = (int)$row['rejected_pengawas'];
    $data['approved_kontraktor'][$month] = (int)$row['approved_kontraktor'];
    $data['rejected_kontraktor'][$month] = (int)$row['rejected_kontraktor'];
}

// Fetch hourmeter data for the current year
$current_years = date("Y");
$sql_hourmeter_data = "
    SELECT 
        EXTRACT(MONTH FROM o.tanggal) AS month,
        COUNT(CASE WHEN h.proses_admin = 'Uploaded' THEN 1 END) AS uploaded,
        COUNT(CASE WHEN h.proses_pengawas = 'Approved Pengawas' THEN 1 END) AS approved_pengawas,
        COUNT(CASE WHEN h.proses_pengawas = 'Rejected Pengawas' THEN 1 END) AS rejected_pengawas,
        COUNT(CASE WHEN h.proses_kontraktor = 'Approved Kontraktor' THEN 1 END) AS approved_kontraktor,
        COUNT(CASE WHEN h.proses_kontraktor = 'Rejected Kontraktor' THEN 1 END) AS rejected_kontraktor
    FROM 
        operation_report o
    JOIN 
        hourmeter_report h ON o.id = h.operation_report_id
    WHERE 
        EXTRACT(YEAR FROM o.tanggal) = $1
    GROUP BY 
        month
    ORDER BY 
        month;
";
$result_hourmeter_data = pg_query_params($conn, $sql_hourmeter_data, array($current_years));

// Prepare data for the chart
$months = range(1, 12);
$datas = [
    'uploaded' => array_fill(0, 12, 0),
    'approved_pengawas' => array_fill(0, 12, 0),
    'rejected_pengawas' => array_fill(0, 12, 0),
    'approved_kontraktor' => array_fill(0, 12, 0),
    'rejected_kontraktor' => array_fill(0, 12, 0),
];

while ($row = pg_fetch_assoc($result_hourmeter_data)) {
    $month = (int)$row['month'] - 1; // Adjust for zero-based index
    $datas['uploaded'][$month] = (int)$row['uploaded'];
    $datas['approved_pengawas'][$month] = (int)$row['approved_pengawas'];
    $datas['rejected_pengawas'][$month] = (int)$row['rejected_pengawas'];
    $datas['approved_kontraktor'][$month] = (int)$row['approved_kontraktor'];
    $datas['rejected_kontraktor'][$month] = (int)$row['rejected_kontraktor'];
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report Application</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Acme&family=Coiny&family=Concert+One&family=Fredoka:wght@300..700&family=Outfit:wght@100..900&family=Pacifico&family=Playpen+Sans:wght@100..800&family=Playwrite+DE+Grund:wght@100..400&family=Righteous&family=Sacramento&family=Varela+Round&family=Yatra+One&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    .body-wrapper {
        background-image: url(../assets/images/backgrounds/4.png);
        background-size: cover;
        background-repeat: no-repeat;
    }

    .logo-report {
        width: 40px;
        height: auto;
    }

    .tulisanlogo {
        width: auto;
        height: 50px;
    }

    .varela-round-regular {
        font-family: "Varela Round", serif;
        font-weight: 400;
        font-style: normal;
    }

    .judul-grafik {
        font-family: "Varela Round", serif;
        font-size: 20px;
        font-weight: bold;
        color: #0f3c61;
    }

    .selamat {
        font-family: "Varela Round", serif;
        font-size: 26px;
        font-weight: bold;
        color: #e7e9d8;
        margin-left: 10%;
        margin-top: 6%;
    }

    .kamu {
        font-family: "Varela Round", serif;
        font-size: 10px;
        color: #e7e9d8;
        margin-left: 10%;
    }

    .view {
        font-family: "Varela Round", serif;
        font-size: 15px;
        color: #fdfdfdd4;
        text-decoration: underline;
        margin-left: 10%;
    }

    .hello {
        width: 160%;
        height: auto;
        z-index: 1;
        right: 17%;
        bottom: 16%;
        position: relative;
    }

    .admin {
        background-image: url(../assets/images/backgrounds/7.png);
        background-size: cover;
    }

    .user {
        background-image: url(../assets/images/backgrounds/9.png);
        background-size: cover;
    }

    .kontraktor {
        background-image: url(../assets/images/backgrounds/8.png);
        background-size: cover;
    }

    .total {
        margin-top: 63%;
        margin-left: -10%;
        font-family: "Varela Round", serif;
        font-size: 17px;
        color: #0f3c61;
        font-weight: bold;
    }

    .total2 {
        font-family: "Varela Round", serif;
        font-size: 20px;
        color: #0f3c61;
        font-weight: bold;
    }

    .bg-selamat {
        background-image: url(../assets/images/backgrounds/10.png);
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }

    .total_produksi {
        background-image: url(../assets/images/backgrounds/12.png);
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }

    .gmbr-jj {
        width: 150%;
        height: auto;
        margin-left: -15%;
        margin-top: 15%;

    }

    .gmbr-p {
        width: 220%;
        height: auto;
        margin-left: -35%;
        margin-top: 15%;
    }

    .tj {
        font-family: "Varela Round", serif;
        font-size: 18px;
        color: #0f3c61;
        font-weight: bold;
        margin-top: 25%;
        margin-left: 8%;
    }

    .tj2 {
        font-family: "Varela Round", serif;
        font-size: 25px;
        color: #0f3c61;
        font-weight: bold;
        margin-left: 8%;
    }

    .tjp {
        font-family: "Varela Round", serif;
        font-size: 18px;
        color: #0f3c61;
        font-weight: bold;
        margin-top: 25%;
        margin-left: 18%;
    }

    .tjp2 {
        font-family: "Varela Round", serif;
        font-size: 25px;
        color: #0f3c61;
        font-weight: bold;
        margin-top: 8%;
        margin-left: 18%;
    }
    </style>
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div class="body-wrapper">
            <!--  Header Start -->
            <div id="navbar"></div>
            <!--  Header End -->
            <div class="container-fluid">
                <div class="row" style="margin-top: 17px;">
                    <div class=" col-lg-1">
                        <img src="../assets/images/backgrounds/6.png" class="hello">
                    </div>
                    <div class="col-lg-5">
                        <div class="card bg-selamat" style="height: 77%;">
                            <div class="card-body">
                                <h1 class="selamat"> Selamat Datang
                                    <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?>
                                </h1>
                                <h5 class="kamu"> Anda memiliki <?php echo $total_rejected; ?> berkas yang menunggu
                                    persetujuan. Mohon segera diperiksa.</h5>
                                <a href="Report.php" class="view">View Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card total_produksi" style="height: 77%;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 d-flex align-items-center">
                                        <img src="../assets/images/backgrounds/14.png" class="gmbr-p">
                                    </div>
                                    <div class="col-lg-8">
                                        <h5 class="tjp"> Total Produksi</h5>
                                        <h5 class="tjp2"><?php echo $rejected_total_produksi; ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="card total_produksi" style="height: 77%;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 d-flex align-items-center">
                                        <img src="../assets/images/backgrounds/13.png" class="gmbr-jj">
                                    </div>
                                    <div class="col-lg-8">
                                        <h5 class="tj"> Total Jam Jalan</h5>
                                        <h5 class="tj2"><?php echo $rejected_total_jamjalan; ?>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <h5 class="judul-grafik"> Laporan Produksi</h5>
                                    </div>
                                    <div class="col-lg-6 d-flex justify-content-end">
                                        <input type="number" class="form-control text-white me-2"
                                            style="width: 100px; height: 32px;" id="yearInput" placeholder="Year"
                                            min="2000" />
                                        <button type="button" class="btn btn-sm btn-primary"
                                            onclick="filterYear()">Filter
                                            Year</button>
                                    </div>
                                </div>
                                <canvas id="productionChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <h5 class="judul-grafik"> Laporan Jam Jalan</h5>
                                    </div>
                                    <div class="col-lg-6 d-flex justify-content-end">
                                        <input type="number" class="form-control text-white me-2"
                                            style="width: 100px; height: 32px;" id="yearInputs" placeholder="Year"
                                            min="2000" />
                                        <button type="button" class="btn btn-sm btn-primary"
                                            onclick="filterYears()">Filter
                                            Year</button>
                                    </div>
                                </div>
                                <canvas id="hourmeterChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    fetch('Navbar.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('navbar').innerHTML = data;
        });

    const ctx = document.getElementById('productionChart').getContext('2d');
    const productionChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                'Nov',
                'Dec'
            ],
            datasets: [{
                    label: 'Uploaded',
                    data: <?php echo json_encode($data['uploaded']); ?>,
                    borderColor: 'rgba(8, 51, 66, 1)',
                    fill: false,
                },
                {
                    label: 'Approved Pengawas',
                    data: <?php echo json_encode($data['approved_pengawas']); ?>,
                    borderColor: 'rgba(117, 14, 14, 1)',
                    fill: false,
                },
                {
                    label: 'Rejected Pengawas',
                    data: <?php echo json_encode($data['rejected_pengawas']); ?>,
                    borderColor: 'rgba(255, 136, 0, 1)',
                    fill: false,
                },
                {
                    label: 'Approved Kontraktor',
                    data: <?php echo json_encode($data['approved_kontraktor']); ?>,
                    borderColor: 'rgba(143, 11, 93, 1)',
                    fill: false,
                },
                {
                    label: 'Rejected Kontraktor',
                    data: <?php echo json_encode($data['rejected_kontraktor']); ?>,
                    borderColor: 'rgba(11, 143, 120, 1)',
                    fill: false,
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'bottom' // Move legend below the chart
                }
            }
        }
    });

    function filterYear() {
        const year = document.getElementById('yearInput').value;
        fetch('fetch_production_data.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'year': year
                })
            })
            .then(response => response.json())
            .then(data => {
                // Update the chart with the new data
                productionChart.data.datasets[0].data = data.uploaded;
                productionChart.data.datasets[1].data = data.approved_pengawas;
                productionChart.data.datasets[2].data = data.rejected_pengawas;
                productionChart.data.datasets[3].data = data.approved_kontraktor;
                productionChart.data.datasets[4].data = data.rejected_kontraktor;
                productionChart.update();
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    const ctxy = document.getElementById('hourmeterChart').getContext('2d');
    const hourmeterChart = new Chart(ctxy, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                'Nov',
                'Dec'
            ],
            datasets: [{
                    label: 'Uploaded',
                    data: <?php echo json_encode($datas['uploaded']); ?>,
                    borderColor: 'rgba(8, 51, 66, 1)',
                    fill: false,
                },
                {
                    label: 'Approved Pengawas',
                    data: <?php echo json_encode($datas['approved_pengawas']); ?>,
                    borderColor: 'rgba(117, 14, 14, 1)',
                    fill: false,
                },
                {
                    label: 'Rejected Pengawas',
                    data: <?php echo json_encode($datas['rejected_pengawas']); ?>,
                    borderColor: 'rgba(255, 136, 0, 1)',
                    fill: false,
                },
                {
                    label: 'Approved Kontraktor',
                    data: <?php echo json_encode($datas['approved_kontraktor']); ?>,
                    borderColor: 'rgba(143, 11, 93, 1)',
                    fill: false,
                },
                {
                    label: 'Rejected Kontraktor',
                    data: <?php echo json_encode($datas['rejected_kontraktor']); ?>,
                    borderColor: 'rgba(11, 143, 120, 1)',
                    fill: false,
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'bottom' // Move legend below the chart
                }
            }
        }
    });

    function filterYears() {
        const year = document.getElementById('yearInputs').value;
        fetch('fetch_hourmeter_data.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'year': year
                })
            })
            .then(response => response.json())
            .then(data => {
                // Update the chart with the new data
                hourmeterChart.data.datasets[0].data = data.uploaded;
                hourmeterChart.data.datasets[1].data = data.approved_pengawas;
                hourmeterChart.data.datasets[2].data = data.rejected_pengawas;
                hourmeterChart.data.datasets[3].data = data.approved_kontraktor;
                hourmeterChart.data.datasets[4].data = data.rejected_kontraktor;
                hourmeterChart.update();
            })
            .catch(error => console.error('Error fetching data:', error));
    }
    </script>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="../assets/js/dashboard.js"></script>
</body>

</html>