<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report Application</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo3.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Acme&family=Coiny&family=Concert+One&family=Fredoka:wght@300..700&family=Outfit:wght@100..900&family=Pacifico&family=Playpen+Sans:wght@100..800&family=Playwrite+DE+Grund:wght@100..400&family=Righteous&family=Sacramento&family=Varela+Round&family=Yatra+One&display=swap"
        rel="stylesheet">
    <style>
    .notif {
        font-size: 12px;
        margin-top: 5px;
        margin-left: 5px;
        color: #6a0707;
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
        color: white;
    }

    .sub-judul {
        font-family: "Varela Round", serif;
        color: white;
    }

    .form-select.text-white option {
        color: black;
    }

    .form-select.text-white {
        color: white;
    }

    .form-control::placeholder {
        color: white;
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
                        <h5 class="judul fw-semibold">Form Produksi</h5>
                        <form id="form-production" method="POST" action="production_aksi.php">
                            <div class="mb-3">
                                <label for="executor" class="sub-judul mb-2"><span class="wajib_isi">*</span>
                                    Executor :</label>
                                <select class="form-select text-white" id="excecutor" name="excecutor" required>
                                    <option value="" selected disabled>Executor</option>
                                    <option value="SPPH 95 - PT PUTRA PERKASA ABADI">
                                        SPPH 95 - PT PUTRA PERKASA ABADI
                                    </option>
                                    <option value="SPPH 17518 - PT PUTRA PERKASA ABADI">
                                        SPPH 17518 - PT PUTRA PERKASA ABADI
                                    </option>
                                    <option value="SPPH 17443 - PT PUTRA PERKASA ABADI">
                                        SPPH 17443 - PT PUTRA PERKASA ABADI
                                    </option>
                                    <option value="ELEKTRIFIKASI - PT BUKIT ASAM TBK">
                                        ELEKTRIFIKASI - PT BUKIT ASAM TBK
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="alat" class="sub-judul mb-2"><span class="wajib_isi">*</span> Alat Gali
                                    / Muat :</label>
                                <select class="form-select text-white" id="alat" name="alat" required>
                                    <option value="" selected disabled>Alat Gali / Muat</option>
                                    <option value="E2043 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                        E2043 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                    </option>
                                    <option value="E2044 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                        E2044 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                    </option>
                                    <option value="E2045 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                        E2045 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                    </option>
                                    <option value="E1226 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                        E1226 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                    </option>
                                    <option value="E1227 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                        E1227 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                    </option>
                                    <option value="E1228 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                        E1228 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                    </option>
                                    <option value="E1229 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                        E1229 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                    </option>
                                    <option value="E1230 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                        E1230 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                    </option>
                                    <option value="E6101 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                        E6101 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                    </option>
                                    <option value="E6102 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                        E6102 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                    </option>
                                    <option value="E6103 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                        E6103 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                    </option>
                                    <option value="E6104 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                        E6104 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                    </option>
                                    <option value="E6105 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                        E6105 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                    </option>
                                    <option value="E52007 - PT PUTRA PERKASA ABADI">
                                        E52007 - PT PUTRA PERKASA ABADI
                                    </option>
                                    <option value="E52009 - PT PUTRA PERKASA ABADI">
                                        E52009 - PT PUTRA PERKASA ABADI
                                    </option>
                                    <option value="SE-3001 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )">
                                        SE-3001 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )
                                    </option>
                                    <option value="SE-3002 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )">
                                        SE-3002 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )
                                    </option>
                                    <option value="SE-3003 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )">
                                        SE-3003 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )
                                    </option>
                                    <option value="SE-3004 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )">
                                        SE-3004 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )
                                    </option>
                                    <option value="SE-3005 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )">
                                        SE-3005 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )
                                    </option>
                                    <option value="SE-3006 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )">
                                        SE-3006 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )
                                    </option>
                                    <option value="SE-3007 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )">
                                        SE-3007 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="timbunan" class="sub-judul mb-2"><span class="wajib_isi">*</span>
                                    Timbunan :</label>
                                <select class="form-select text-white" id="timbunan" name="timbunan" required>
                                    <option value="" selected disabled>Timbunan</option>
                                    <option value="Banko Barat - Disposal Backfill Pit 1 Utara">
                                        Banko Barat - Disposal Backfill Pit 1 Utara
                                    </option>
                                    <option value="Banko Tengah - Disposal Utara Pit 3 Timur">
                                        Banko Tengah - Disposal Utara Pit 3 Timur
                                    </option>
                                    <option value="Banko Tengah - Disposal Selatan Pit 3 Timur">
                                        Banko Tengah - Disposal Selatan Pit 3 Timur
                                    </option>
                                    <option value="Banko Barat - Disposal Selatan Timur Pit 2">
                                        Banko Barat - Disposal Selatan Timur Pit 2
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="material" class="sub-judul mb-2"><span class="wajib_isi">*</span>
                                    Material :</label>
                                <select class="form-select text-white" id="material" name="material" required>
                                    <option value="" selected disabled>Material</option>
                                    <option value="OB A1">OB A1</option>
                                    <option value="OB A2">OB A2</option>
                                    <option value="OB B1">OB B1</option>
                                    <option value="OB B2">OB B2</option>
                                    <option value="OB BC">OB BC</option>
                                    <option value="OB C">OB C</option>
                                    <option value="Overburden">Overburden</option>
                                    <option value="Lumpur">Lumpur</option>
                                    <option value="Lumpur C">Lumpur C</option>
                                    <option value="Interburden">Interburden</option>
                                    <option value="Topsoil">Topsoil</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="jarak" class="sub-judul mb-2"><span class="wajib_isi">*</span> Jarak
                                    :</label>
                                <input type="text" class="form-control text-white" id="jarak" name="jarak"
                                    placeholder="Input Data (gunakan titik untuk desimal)" required>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="tipe" class="sub-judul mb-2"><span class="wajib_isi">*</span>
                                            Tipe Hauler 1 :</label>
                                        <select class="form-select text-white" id="tipe" name="tipe" required>
                                            <option value="" selected disabled>Tipe Hauler</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="ritase" class="sub-judul mb-2"><span class="wajib_isi">*</span>
                                            Ritase 1 :</label>
                                        <input type="number" class="form-control text-white" id="ritase" name="ritase"
                                            placeholder="Input Data" required>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" class="form-control" id="muatan" name="muatan" placeholder="Muatan"
                                readonly>
                            <input type="hidden" class="form-control" id="volume" name="volume" placeholder="Volume"
                                readonly oninput="calculateVolumes()">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="tipe" class="sub-judul mb-2"><span class="wajib_isi">*</span>
                                            Tipe Hauler 2 :</label>
                                        <select class="form-select text-white" id="tipe2" name="tipe2" required>
                                            <option value="" selected disabled>Tipe Hauler</option>
                                        </select>
                                        <h5 class="notif"> Jika tidak ada tipe hauler, pilih (-)
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="ritase" class="sub-judul mb-2"><span class="wajib_isi">*</span>
                                            Ritase 2 :</label>
                                        <input type="number" class="form-control text-white" id="ritase2" name="ritase2"
                                            placeholder="Input Data" required>
                                        <h5 class="notif"> Jika tidak ada nilai ritase, isikan 0
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" class="form-control" id="muatan2" name="muatan2" placeholder="Muatan"
                                readonly>
                            <input type="hidden" class="form-control" id="volume2" name="volume2" placeholder="Volume"
                                readonly oninput="calculateVolumes()">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="total_ritase" class="sub-judul mb-2">
                                            Total Ritase :</label>
                                        <input type="number" class="form-control text-white" id="total_ritase"
                                            name="total_ritase" placeholder="Total Ritase" readonly
                                            oninput="calculateTotalRitase()">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="volume" class="sub-judul mb-2">Volume :</label>
                                        <input type="number" class="form-control text-white" id="total_volume"
                                            name="total_volume" placeholder="Total Volume" readonly
                                            oninput="calculateVolumes()" step="0.01">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="operation_report_id" name="operation_report_id"
                                value="<?php echo $_GET['id']; ?>">
                            <input type="hidden" id="proses_admin" name="proses_admin" value="Uploaded">
                            <input type="hidden" id="proses_pengawas" name="proses_pengawas">
                            <input type="hidden" id="proses_kontraktor" name="proses_kontraktor">
                            <input type="hidden" id="alasan_reject" name="alasan_reject">
                            <input type="hidden" id="kontraktor" name="kontraktor">
                            <input type="hidden" id="name_pengawas" name="name_pengawas">
                            <input type="hidden" id="file_pengawas" name="file_pengawas">
                            <input type="hidden" id="name_kontraktor" name="name_kontraktor">
                            <input type="hidden" id="file_kontraktor" name="file_kontraktor">
                            <button type="submit" class="btn btn-primary me-2"> Submit</button>
                            <button type="button" class="btn btn-danger" onclick="goBack()"> Kembali</button>
                        </form>
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

    function goBack() {
        window.location.href = 'operation.php';
    }

    document.getElementById('form-production').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah pengiriman form default
        const formData = new FormData(this);

        fetch('production_aksi.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                return response.text(); // Change to text to see the raw response
            })
            .then(data => {
                console.log(data); // Log the raw response
                try {
                    const jsonData = JSON.parse(data); // Try to parse it as JSON
                    if (jsonData.message) {
                        console.log(jsonData.message); // Handle success
                        this.reset(); // Clear form
                    } else {
                        console.error(jsonData.error); // Handle error
                    }
                } catch (e) {
                    console.error('Error parsing JSON:', e); // Handle JSON parse error
                }
            })
            .catch(error => console.error('Error:', error));
    });

    let muatanData = {};

    // Fetch muatan data from server
    fetch('getMuatan.php')
        .then(response => response.json())
        .then(data => {
            muatanData = data.reduce((acc, item) => {
                acc[item.tipe] = item.jumlah;
                return acc;
            }, {});

            // Populate select options
            const tipeSelects = document.querySelectorAll('#tipe, #tipe2');
            tipeSelects.forEach(select => {
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.tipe;
                    option.textContent = item.tipe;
                    select.appendChild(option);
                });
            });
        });

    // Update muatan value based on selected tipe
    document.getElementById('tipe').addEventListener('change', function() {
        const selectedTipe = this.value;
        document.getElementById('muatan').value = muatanData[selectedTipe] || 0;
        calculateTotalRitase();
    });

    document.getElementById('tipe2').addEventListener('change', function() {
        const selectedTipe = this.value;
        document.getElementById('muatan2').value = muatanData[selectedTipe] || 0;
        calculateTotalRitase();
    });

    document.getElementById('ritase').addEventListener('input', function() {
        calculateVolumes();
        calculateTotalRitase();
    });
    document.getElementById('ritase2').addEventListener('input', function() {
        calculateVolumes();
        calculateTotalRitase();
    });


    function calculateTotalRitase() {
        const ritase = parseFloat(document.getElementById('ritase').value) || 0;
        const ritase2 = parseFloat(document.getElementById('ritase2').value) || 0;

        const totalRitase = ritase + ritase2;
        document.getElementById('total_ritase').value = totalRitase;
    }

    function calculateVolumes() {
        const ritase = parseFloat(document.getElementById('ritase').value) || 0;
        const muatan = parseFloat(document.getElementById('muatan').value) || 0;
        const volume = ritase * muatan;
        document.getElementById('volume').value = volume;

        const ritase2 = parseFloat(document.getElementById('ritase2').value) || 0;
        const muatan2 = parseFloat(document.getElementById('muatan2').value) || 0;
        const volume2 = ritase2 * muatan2;
        document.getElementById('volume2').value = volume2;

        const totalVolume = volume + volume2;
        document.getElementById('total_volume').value = totalVolume.toFixed(2);
    }
    </script>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>