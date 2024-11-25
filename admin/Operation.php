<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report Application</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Acme&family=Coiny&family=Concert+One&family=Fredoka:wght@300..700&family=Outfit:wght@100..900&family=Pacifico&family=Playpen+Sans:wght@100..800&family=Playwrite+DE+Grund:wght@100..400&family=Righteous&family=Sacramento&family=Varela+Round&family=Yatra+One&display=swap"
        rel="stylesheet">
    <style>
    .body-wrapper {
        background-image: url(../assets/images/backgrounds/4.png);
        background-size: cover;
        background-repeat: no-repeat;
    }

    .wajib_isi {
        color: #8b0707;
        font-size: 15px;
    }

    .varela-round-regular {
        font-family: "Varela Round", serif;
        font-weight: 400;
        font-style: normal;
    }

    .judul {
        font-family: "Varela Round", serif;
        text-align: center;
        font-size: 30px;
        margin-bottom: 50px;
        margin-top: 10px;
        color: #0f3f61;
    }

    .sub-judul {
        font-family: "Varela Round", serif;
        color: #0f3f61;
    }

    .form-select.text-white option {
        color: black;
    }

    .form-select.text-white {
        color: white;
    }

    .text-white {
        color: #0f3c61 !important;
    }
    </style>
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div class="body-wrapper">
            <div id="navbar"></div>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <h5 class="judul fw-semibold">Form Operation</h5>
                        <form id="form-operation" method="POST" action="operation_aksi.php">
                            <div class="mb-3">
                                <label for="tanggal" class="sub-judul mb-2">
                                    <span class="wajib_isi">*</span> Hari / Tanggal :</label>
                                <input type="date" class="form-control text-white" id="tanggal" name="tanggal" required>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="shift" class="sub-judul mb-2"> <span class="wajib_isi">*</span> Shift
                                        :</label>
                                    <select class="form-select text-white" id="shift" name="shift" required>
                                        <option value="" selected disabled>Shift</option>
                                        {{ edit_1 }}
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="grup" class="sub-judul mb-2"> <span class="wajib_isi">*</span> Giliran /
                                        Group :</label>
                                    <select class="form-select text-white" id="grup" name="grup" required>
                                        <option value="" selected disabled>Giliran / Grup</option>
                                        {{ edit_1 }}
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="pic" class="sub-judul mb-2"><span class="wajib_isi">*</span> PIC
                                        :</label>
                                    <select class="form-select text-white" id="pic" name="pic" required>
                                        <option value="" selected disabled>PIC</option>
                                        {{ edit_1 }}
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="pengawas" class="sub-judul mb-2"><span class="wajib_isi">*</span>
                                        Pengawas :</label>
                                    <select class="form-select text-white" id="pengawas" name="pengawas" required>
                                        <option value="" selected disabled>Pengawas</option>
                                        {{ edit_1 }}
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="lokasi" class="sub-judul mb-2"><span class="wajib_isi">*</span> Lokasi
                                        Kerja :</label>
                                    <select class="form-select text-white" id="lokasi" name="lokasi" required>
                                        <option value="" selected disabled>Lokasi Kerja</option>
                                        {{ edit_1 }}
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="status" class="sub-judul mb-2"> <span class="wajib_isi">*</span> Status
                                        :</label>
                                    <select class="form-select text-white" id="status" name="status" required>
                                        <option value="" selected disabled>PRODUKSI / JAM JALAN </option>
                                        <option value="Produksi">Produksi</option>
                                        <option value="Jam Jalan">Jam Jalan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary mt-4">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.getElementById('form-operation').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah pengiriman form default
        const formData = new FormData(this);

        fetch('operation_aksi.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                // Periksa apakah response valid JSON
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log("Operation report created successfully");
                    if (data.status === 'Produksi') {
                        window.location.href = 'production.php?id=' + data
                            .operationReportId; // Arahkan ke production.php
                    } else if (data.status === 'Jam Jalan') {
                        window.location.href = 'hourmeter.php?id=' + data
                            .operationReportId; // Arahkan ke hourmeter.php
                    }
                } else {
                    console.error(data.error);
                }
            })
            .catch(error => console.error('Error:', error));
    });

    fetch('Navbar.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('navbar').innerHTML = data;
        });

    fetch('user_report.php') // Fetch data from user_report
        .then(response => response.json())
        .then(users => {
            const picSelect = document.getElementById('pic');
            users.forEach(user => {
                const option = document.createElement('option');
                option.value = user.username; // Use the 'username' field
                option.textContent = user.username; // Display the username
                picSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching user report:', error));

    fetch('lokasi_report.php') // Fetch data from user_report
        .then(response => response.json())
        .then(users => {
            const lokasiSelect = document.getElementById('lokasi');
            users.forEach(user => {
                const option = document.createElement('option');
                option.value = user.lokasi; // Use the 'username' field
                option.textContent = user.lokasi; // Display the username
                lokasiSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching user report:', error));

    fetch('pengawas_report.php') // Fetch data from user_report
        .then(response => response.json())
        .then(users => {
            const pengawasSelect = document.getElementById('pengawas');
            users.forEach(user => {
                const option = document.createElement('option');
                option.value = user.nama; // Use the 'username' field
                option.textContent = user.nama; // Display the username
                pengawasSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching user report:', error));

    fetch('grup_report.php') // Fetch data from user_report
        .then(response => response.json())
        .then(users => {
            const grupSelect = document.getElementById('grup');
            users.forEach(user => {
                const option = document.createElement('option');
                option.value = user.grup; // Use the 'username' field
                option.textContent = user.grup; // Display the username
                grupSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching user report:', error));

    fetch('shift_report.php') // Fetch data from user_report
        .then(response => response.json())
        .then(users => {
            const shiftSelect = document.getElementById('shift');
            users.forEach(user => {
                const option = document.createElement('option');
                option.value = user.shift; // Use the 'username' field
                option.textContent = user.shift; // Display the username
                shiftSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching user report:', error));
    </script>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>