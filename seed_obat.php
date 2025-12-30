<?php
include 'sim_adhyaksa/koneksi.php';

$obat_list = [
    "Cifroflaxacin 500 mg",
    "Chlorphenamine Meleate",
    "Captopril 25 mg",
    "Paracetamol 500 mg",
    "Ranitidin",
    "Guaifenesin",
    "Metronidazole 500 mg",
    "Sodium Diklofenak 50 mg",
    "Vit B Com",
    "Simvastatin 10 mg",
    "Gentamicin Sulfate 0,1%",
    "Betametashone Velerate",
    "Allopurinol 100 mg",
    "Prednisone",
    "Asammefenamat acid",
    "Methylprednisolone",
    "Amlodipine 5 mg",
    "Amlodipine 10 mg",
    "Amoxicilin",
    "Cetirizine",
    "Glimepiride",
    "Oxytetra Salep",
    "Antasida Doen",
    "Apecure Sirup",
    "Vitamin C",
    "Domperidone tablet",
    "Cetirizine Sirup",
    "Zinc Sirup",
    "Amoxicilin Sirup",
    "Antasida Sirup",
    "Ibu Profen Sirup",
    "Attapulgit",
    "Candesartan",
    "ketoconazole salep",
    "Vitamin B 12",
    "Metformin",
    "Loperamide",
    "acetylcysteine",
    "Hidrocortisone Salep",
    "Salep 24",
    "Cefadroxil",
    "Cotrimoxazole syp",
    "Vit A biru",
    "Dispo 3 cc",
    "Loratadine tablet",
    "Albendazole",
    "Paracetamol Sirup",
    "Metoclopramide",
    "Paracetamol drops",
    "Kalsium Laktat",
    "Glibenclamide",
    "Save Glove (hansscoon) M",
    "Cairan Nacl",
    "Cairan RL.",
    "Tablet Fe",
    "Ketokonazole",
    "Dexamethasone",
    "Masker",
    "Ibu Profen",
    "Abocath 24",
    "Kassa Steril"
];

// Empty table first to avoid duplicates (optional, based on preference, but good for clean slate)
mysqli_query($conn, "TRUNCATE TABLE obat");

$stmt = mysqli_prepare($conn, "INSERT INTO obat (nama_obat, jenis_obat, stok, harga) VALUES (?, ?, ?, ?)");

foreach ($obat_list as $nama) {
    $jenis = "Tablet/Kapsul"; // Default
    if (stripos($nama, 'Sirup') !== false || stripos($nama, 'syp') !== false || stripos($nama, 'drops') !== false)
        $jenis = "Sirup/Cair";
    elseif (stripos($nama, 'Salep') !== false)
        $jenis = "Salep/Topikal";
    elseif (stripos($nama, 'Cairan') !== false)
        $jenis = "Cairan Infus";
    elseif (stripos($nama, 'Masker') !== false || stripos($nama, 'Glove') !== false || stripos($nama, 'Dispo') !== false || stripos($nama, 'Abocath') !== false || stripos($nama, 'Kassa') !== false)
        $jenis = "Alkes";

    $stok = 100; // Default stok
    $harga = 0; // Default harga

    mysqli_stmt_bind_param($stmt, "ssid", $nama, $jenis, $stok, $harga);
    mysqli_stmt_execute($stmt);
}

echo "Berhasil menambahkan " . count($obat_list) . " data obat.";
?>