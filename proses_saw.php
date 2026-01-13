<?php
include 'koneksi.php';

// --- FUNGSI BANTUAN ---
function getNilaiBobot($conn, $id_kriteria, $nilai_asli) {
    // Cek apakah nilai asli adalah angka atau teks
    if(!is_numeric($nilai_asli)) {
        // Khusus untuk Text (misal: "Ada"/"Tidak Ada") - Sesuai DB Anda
        if($nilai_asli == "Ada") return 2; 
        return 1;
    }
    
    // Cek Range di Database Parameter
    $q = mysqli_query($conn, "SELECT nilai FROM tb_parameter WHERE id_kriteria='$id_kriteria' AND $nilai_asli >= min_value AND $nilai_asli <= max_value");
    $res = mysqli_fetch_assoc($q);
    
    // Jika tidak ada di range (error handler), kembalikan 1
    return $res ? $res['nilai'] : 1; 
}

// --- 1. SIAPKAN DATA ---
$kriteria = [];
$q_krit = mysqli_query($conn, "SELECT * FROM tb_kriteria");
while($row = mysqli_fetch_assoc($q_krit)) {
    $kriteria[$row['id_kriteria']] = $row;
}

$alternatif = [];
$q_alt = mysqli_query($conn, "SELECT * FROM tb_alternatif");
while($row = mysqli_fetch_assoc($q_alt)) {
    // Hitung Konversi (C1, C2, dst)
    foreach($kriteria as $id => $k) {
        // Asumsi nama kolom di tb_alternatif formatnya: k1_val, k2_val...
        // Jika beda, sesuaikan logic ini
        $val = $row['k'.$id.'_val']; // k1_val
        $row['C'.$id] = getNilaiBobot($conn, $id, $val);
    }
    $alternatif[] = $row;
}

// --- 2. CARI MIN/MAX (Normalisasi) ---
$min_max = [];
foreach($kriteria as $id => $k) {
    $col = array_column($alternatif, 'C'.$id);
    if($k['atribut'] == 'cost') {
        $min_max[$id] = min($col);
    } else {
        $min_max[$id] = max($col);
    }
}

// --- 3. HITUNG NILAI AKHIR (V) ---
foreach($alternatif as $key => $val) {
    $nilai_akhir = 0;
    foreach($kriteria as $id => $k) {
        // Hitung R (Normalisasi)
        if($k['atribut'] == 'cost') {
            $r = $min_max[$id] / $val['C'.$id];
        } else {
            $r = $val['C'.$id] / $min_max[$id];
        }
        
        // Simpan nilai R ke array untuk ditampilkan di Perhitungan
        $alternatif[$key]['R'.$id] = $r;
        
        // Hitung V (Ranking)
        $nilai_akhir += $r * $k['bobot'];
    }
    $alternatif[$key]['nilai_akhir'] = $nilai_akhir;
}

// --- 4. SORTING (Untuk Ranking) ---
// Kita copy array ke variabel baru untuk ranking, agar urutan data asli (ID) tidak acak di tabel matriks
$data_ranking = $alternatif;
usort($data_ranking, function($a, $b) {
    return $b['nilai_akhir'] <=> $a['nilai_akhir'];
});
?>