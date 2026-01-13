<?php 
include 'proses_saw.php'; 
include 'header.php'; 
?>

<div class="container mb-5">
    <h3 class="mb-4 text-center">Detail Proses Perhitungan SAW</h3>

    <div class="card mb-4 border-info">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Referensi Rumus</h5>
        </div>
        <div class="card-body bg-light">
            <div class="row">
                <div class="col-md-6">
                    <h6>1. Rumus Normalisasi (R)</h6>
                    <p>Mencari nilai R pada setiap kolom atribut:</p>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Atribut COST (Biaya/Jarak):</strong><br>
                            <code>R = Nilai Min / Nilai Alternatif</code>
                        </li>
                        <li class="list-group-item">
                            <strong>Atribut BENEFIT (Air/Rating):</strong><br>
                            <code>R = Nilai Alternatif / Nilai Max</code>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6>2. Rumus Nilai Akhir (V)</h6>
                    <p>Penjumlahan dari perkalian bobot dengan nilai normalisasi:</p>
                    <div class="alert alert-secondary text-center">
                        <strong>V = (W1 × R1) + (W2 × R2) + ... + (Wn × Rn)</strong>
                    </div>
                    <small>Dimana W adalah Bobot Kriteria.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <strong>Langkah 1: Matriks Rating (X)</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-sm text-center">
                <thead class="table-secondary">
                    <tr>
                        <th rowspan="2" class="align-middle">No</th>
                        <th rowspan="2" class="align-middle">Alternatif</th>
                        <?php foreach($kriteria as $k): ?>
                        <th><?php echo $k['nama_kriteria']; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no=1; 
                    // GUNAKAN $alternatif (URUTAN SESUAI INPUT/EXCEL)
                    foreach($alternatif as $a): 
                    ?>
                    <tr>
                        <td><?=$no++?></td>
                        <td class="text-start"><?php echo $a['nama_alternatif']; ?></td>
                        <?php foreach($kriteria as $id => $k): ?>
                        <td><?php echo $a['C'.$id]; ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                    <tr class="table-warning fw-bold">
                        <td colspan="2">Nilai Min/Max</td>
                        <?php foreach($kriteria as $id => $k): ?>
                        <td><?php echo $min_max[$id]; ?></td>
                        <?php endforeach; ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <strong>Langkah 2: Normalisasi Matriks (R)</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-sm text-center">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Alternatif</th>
                        <?php foreach($kriteria as $k): ?>
                        <th>R-<?php echo $k['kode_kriteria']; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no=1; 
                    // MASIH MENGGUNAKAN URUTAN INPUT
                    foreach($alternatif as $a): 
                    ?>
                    <tr>
                        <td><?=$no++?></td>
                        <td class="text-start"><?php echo $a['nama_alternatif']; ?></td>
                        <?php foreach($kriteria as $id => $k): ?>
                        <td><?php echo round($a['R'.$id], 3); ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <strong>Langkah 3: Perhitungan Nilai Akhir (V)</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Alternatif</th>
                        <th>Perhitungan (R × Bobot)</th>
                        <th>Nilai Akhir (V)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    // MASIH MENGGUNAKAN URUTAN INPUT ($alternatif)
                    foreach($alternatif as $d): 
                    ?>
                    <tr>
                        <td><?=$no++?></td>
                        <td><?php echo $d['nama_alternatif']; ?></td>
                        <td class="small text-muted">
                            <?php 
                            $rumus_text = [];
                            foreach($kriteria as $id => $k) {
                                $rumus_text[] = "(" . round($d['R'.$id],2) . "×" . $k['bobot'] . ")";
                            }
                            echo implode(" + ", $rumus_text);
                            ?>
                        </td>
                        <td class="fw-bold text-success"><?php echo number_format($d['nilai_akhir'], 4); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
</body>
</html>