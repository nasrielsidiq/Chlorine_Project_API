<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <title>Sertifikat</title>
</head>
<body>
    <style>
        .border-sertifikat{
            position: relative;
            padding: 40px;
            background-color: rgb(235, 240, 255);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            border: 15px double #1a4b8f;
            border-radius: 10px;
        }

        .border-dalam{
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
        }

        .border-dalam::before{
            content: '';
            position: absolute;
            top: 30px;
            left: 30px;
            border-top: 10px solid #35459c44;
            border-left: 10px solid #1a4b8f;
            width: 150px;
            height: 150px;
        }

        .border-dalam::after{
            content: '';
            position: absolute;
            bottom: 30px;
            right: 30px;
            border-bottom: 10px solid #35459c44;
            border-right: 10px solid #1a4b8f;
            width: 150px;
            height: 150px;
        }

        .judul{
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 100px;
        }

        .judul img{
            width: 80px;
            height: auto;
        }

        .lead {
            font-size: 18px;
            font-weight: normal;
            color: #6c757d;
        }

        .table {
            width: 70%;
            height: 50%;
            margin: 0 auto;
            background-color: transparent;
            table-layout: fixed;
        }

        .table th,
        .table td {
            text-align: center;
            padding: 8px;
            font-size: 14px;
            border: 1px solid black;
            background-color: transparent;
        }

        .table th {
            background-color: #c3d1eb;
            color: black;
            font-size: 16px;
        }

        .nilai-title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
        }

    </style>

    <div class="container my-5 border-sertifikat p-5" style="height: 180mm; width: 297mm;">
        <div class="border-dalam"></div>
        <div class="text-center mb-4 judul m-5">
            <img src="image/smk_ypc.png" alt="Logo Kiri">
            <h1 class="display-4">Sertifikat</h1>
            <img src="image/logo_chlorinee.png" alt="Logo Kanan">
        </div>

        <div class="text-center mb-4">
            <p class="lead">Diberikan kepada</p>
            <h2>Nama Siswa</h2>
            <p>Telah melaksanakan Praktek Kerja Industri di PT Chlorine <br> selama 90 (sembilan puluh) hari kerja dari tanggal 13 Januari hingga  26 April 2025.</p>
        </div>

        <div class="text-center mb-5">
            <h3>Rekayasa Perangkat Lunak</h3>
        </div>

        <div class="d-flex justify-content-between mt-5 mx-4">
            <div class="text-center">
                <hr>
                <p class="mb-0">Kepala Sekolah</p>
                <p class="text-muted">Nama Kepala Sekolah</p>
            </div>
            <div class="text-center">
                <hr>
                <p class="mb-0">HR PT Chlorine</p>
                <p class="text-muted">Nama HR</p>
            </div>
        </div>


    </div>

    <div style="page-break-after: always;"></div>

    <div class="container my-5 border-sertifikat p-5" style="height: 180mm; width: 297mm;">
        <div class="border-dalam"></div>
        <div class="text-center judul mt-5">
            <span class="display-4" style="font-size: 25px;">DAFTAR NILAI</span>
        </div>

        <div class="nilai-title">
            <span>Nilai Tugas</span>
        </div>

        <div class="container">
            <div class="mt-2">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 10%;">No</th>
                            <th scope="col" style="width: 30%;">Nama Tugas</th>
                            <th scope="col" style="width: 30%;">Tanggal</th>
                            <th scope="col" style="width: 30%;">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Tugas ....</td>
                            <td>19/12/2024</td>
                            <td>90</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Tugas ....</td>
                            <td>19/12/2024</td>
                            <td>90</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="nilai-title">
            <span>Nilai Akhir</span>
        </div>

        <div class="container">
            <div class="mt-2">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 10%;">No</th>
                            <th scope="col" style="width: 30%;">Penilaian</th>
                            <th scope="col" style="width: 30%;">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Nilai Prakerin</td>
                            <td>90</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Nilai Sikap</td>
                            <td>90</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-end mx-4">
            <div class="">
                <hr class="border-top border-2" style="width: 200px;">
                <p class="mb-0">Tasikmalaya, 23 Januari 2024 </p>
                <p class="text-muted">Nama Penguji</p>
            </div>
        </div>
    </div>

    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>
