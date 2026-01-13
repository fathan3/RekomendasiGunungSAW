<?php 
include 'proses_saw.php'; 
include 'header.php'; 
?>

<div class="p-4 mb-4 bg-light rounded-3 border">
    <div class="container-fluid py-3">
        <h1 class="display-6 fw-bold">Hasil Perankingan</h1>
        <p class="fs-5">Berikut adalah urutan rekomendasi gunung terbaik berdasarkan nilai tertinggi (Metode SAW).</p>
        
        <?php if(!empty($data_ranking)): ?>
        <div class="alert alert-success d-flex align-items-center shadow-sm" role="alert">
            <div class="me-3 fs-1">🥇</div>
            <div>
                <strong>Rekomendasi Terbaik:</strong> <?php echo $data_ranking[0]['nama_alternatif']; ?>
                <div class="small">Skor SAW: <?php echo number_format($data_ranking[0]['nilai_akhir'], 4); ?></div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="card shadow mb-5">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Tabel Ranking Final</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th width="5%">Rank</th>
                        <th class="text-start">Nama Gunung</th>
                        <th>Biaya (Rp)</th>
                        <th>Durasi (Jam)</th>
                        <th>Mata Air</th>
                        <th>Rating</th>
                        <th width="15%">Nilai Akhir (V)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $rank = 1;
                    // GUNAKAN $data_ranking (SUDAH DIURUTKAN DARI NILAI TERBESAR)
                    foreach($data_ranking as $d): 
                    ?>
                    <tr>
                        <td class="fw-bold text-center bg-light fs-5"><?php echo $rank++; ?></td>
                        
                        <td class="fw-bold"><?php echo $d['nama_alternatif']; ?></td>
                        
                        <td class="text-center">Rp <?php echo number_format($d['k1_val']); ?></td>
                        
                        <td class="text-center"><?php echo $d['k2_val']; ?> Jam</td>
                        
                        <td class="text-center">
                            <?php if($d['k3_val'] == 'Ada'): ?>
                                <span class="badge bg-info text-dark">Ada</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Tidak Ada</span>
                            <?php endif; ?>
                        </td>
                        
                        <td class="text-center">⭐ <?php echo $d['k4_val']; ?></td>
                        
                        <td class="text-center">
                            <span class="badge bg-warning text-dark fs-6 border border-dark">
                                <?php echo number_format($d['nilai_akhir'], 4); ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>