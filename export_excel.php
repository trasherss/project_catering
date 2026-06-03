<?php
require 'vendor/autoload.php';
include "koneksi.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

/* =========================================
   BUAT SPREADSHEET
========================================= */

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setTitle('Laporan Pesanan');

/* =========================================
   HEADER
========================================= */

$header = [
    'A1' => 'ID',
    'B1' => 'Nama Pembeli',
    'C1' => 'Tanggal Acara',
    'D1' => 'Alamat',
    'E1' => 'Metode Bayar',
    'F1' => 'Jenis Bayar',
    'G1' => 'Paket',
    'H1' => 'Total Harga',
    'I1' => 'DP Dibayar',
    'J1' => 'Sisa Pelunasan',
    'K1' => 'Status Pelunasan',
    'L1' => 'Status Pesanan',
    'M1' => 'Bukti DP / Lunas',
    'N1' => 'Bukti Pelunasan'
];

foreach ($header as $cell => $value) {

    $sheet->setCellValue($cell, $value);
}

/* =========================================
   STYLE HEADER
========================================= */

$sheet->getStyle('A1:N1')->applyFromArray([
    'font' => [
        'bold' => true,
        'color' => [
            'rgb' => 'FFFFFF'
        ]
    ],
    'fill' => [
        'fillType' => 'solid',
        'startColor' => [
            'rgb' => '198754'
        ]
    ]
]);

/* =========================================
   UKURAN KOLOM
========================================= */

foreach (range('A', 'N') as $col) {

    $sheet->getColumnDimension($col)
          ->setAutoSize(true);
}

/* =========================================
   QUERY DATA
========================================= */

$query = mysqli_query(
    $conn,
    "SELECT * FROM pesanan ORDER BY id DESC"
);

$rowExcel = 2;

while ($row = mysqli_fetch_assoc($query)) {

    /* =====================================
       HITUNG DP & SISA
    ===================================== */

    if ($row['jenis_bayar'] == 'DP') {

        $dp = $row['total_harga'] * 0.5;
        $sisa = $row['sisa_pembayaran'];

    } else {

        $dp = $row['total_harga'];
        $sisa = 0;
    }

    /* =====================================
       ISI TEXT
    ===================================== */

    $sheet->setCellValue('A'.$rowExcel, $row['id']);
    $sheet->setCellValue('B'.$rowExcel, $row['nama_pembeli']);
    $sheet->setCellValue('C'.$rowExcel, $row['tanggal_acara']);
    $sheet->setCellValue('D'.$rowExcel, $row['alamat']);
    $sheet->setCellValue('E'.$rowExcel, $row['metode_bayar']);
    $sheet->setCellValue('F'.$rowExcel, $row['jenis_bayar']);
    $sheet->setCellValue('G'.$rowExcel, $row['paket']);

    $sheet->setCellValue(
        'H'.$rowExcel,
        'Rp' . number_format($row['total_harga'],0,',','.')
    );

    $sheet->setCellValue(
        'I'.$rowExcel,
        'Rp' . number_format($dp,0,',','.')
    );

    $sheet->setCellValue(
        'J'.$rowExcel,
        'Rp' . number_format($sisa,0,',','.')
    );

    $sheet->setCellValue(
        'K'.$rowExcel,
        $row['status_pelunasan']
    );

    $sheet->setCellValue(
        'L'.$rowExcel,
        $row['status']
    );

    /* =====================================
       TINGGI ROW
    ===================================== */

    $sheet->getRowDimension($rowExcel)
          ->setRowHeight(90);

    /* =====================================
       GAMBAR BUKTI DP / LUNAS
    ===================================== */

    if (!empty($row['bukti_bayar']) &&
        file_exists($row['bukti_bayar'])) {

        $drawing = new Drawing();

        $drawing->setName('Bukti Bayar');
        $drawing->setDescription('Bukti Bayar');
        $drawing->setPath($row['bukti_bayar']);

        $drawing->setHeight(80);

        $drawing->setCoordinates('M'.$rowExcel);

        $drawing->setWorksheet($sheet);
    }

    /* =====================================
       GAMBAR BUKTI PELUNASAN
    ===================================== */

    if (!empty($row['bukti_pelunasan'])) {

        $pathPelunasan =
            "uploads/" . $row['bukti_pelunasan'];

        if (file_exists($pathPelunasan)) {

            $drawing2 = new Drawing();

            $drawing2->setName('Pelunasan');
            $drawing2->setDescription('Pelunasan');
            $drawing2->setPath($pathPelunasan);

            $drawing2->setHeight(80);

            $drawing2->setCoordinates('N'.$rowExcel);

            $drawing2->setWorksheet($sheet);
        }
    }

    $rowExcel++;
}

/* =========================================
   BORDER TABLE
========================================= */

$lastRow = $rowExcel - 1;

$sheet->getStyle('A1:N'.$lastRow)
      ->applyFromArray([

    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
        ]
    ]
]);

/* =========================================
   EXPORT FILE
========================================= */

$fileName =
"Laporan_Pesanan_" .
date('Y-m-d_H-i-s') .
".xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

header(
'Content-Disposition: attachment;filename="'.$fileName.'"'
);

header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

exit;
?>