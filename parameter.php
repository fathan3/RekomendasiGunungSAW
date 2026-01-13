<?php 
include 'koneksi.php'; 
include 'header.php'; 

// --- 1. LOGIKA TAMBAH (INSERT) ---
if(isset($_POST['simpan'])) {
    $id_kriteria = $_POST['id_kriteria'];
    $nama        = $_POST['nama'];
    $nilai       = $_POST['nilai'];
    $min         = $_POST['min'];
    $max         = $_POST['max'];

    $q = "INSERT INTO tb_parameter (id_kriteria, nama_parameter, nilai, min_value, max_value) 
          VALUES ('$id_kriteria', '$nama', '$nilai', '$min', '$max')";
    
    if(mysqli_query($conn, $q)) {
        echo "<script>alert('Parameter Berhasil Ditambah!'); window.location='parameter.php'</script>";
    }
}

// --- 2. LOGIKA UPDATE (EDIT) ---
if(isset($_POST['update'])) {
    $id_param = $_POST['id_param'];
    $nama     = $_POST['nama'];
    $min      = $_POST['min'];
    $max      = $_POST['max'];
    $nilai    = $_POST['nilai'];

    $q = "UPDATE tb_parameter SET nama_parameter='$nama', min_value='$min', max_value='$max', nilai='$nilai' 
          WHERE id_param='$id_param'";

    if(mysqli_query($conn, $q)) {
        echo "<script>alert('Data Berhasil Diupdate!'); window.location='parameter.php'</script>";
    }
}

// --- 3. LOGIKA HAPUS (DELETE) ---
if(isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM tb_parameter WHERE id_param='$id'");
    echo "<script>alert('Data Dihapus'); window.location='parameter.php'</script>";
}
?>

<div class="container mt-4">

    <div class="card shadow mb-4">
        <div class="card-header bg-info text-white">
            <h6 class="m-0">Input Parameter & Range Nilai</h6>
        </div>
        <div class="card-body">
            <form method="POST" class="row g-2">
                <div class="col-md-3">
                    <label class="form-label small">Pilih Kriteria</label>
                    <select name="id_kriteria" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <?php 
                        $k=mysqli_query($conn, "SELECT * FROM tb_kriteria"); 
                        while($r=mysqli_fetch_assoc($k)){ 
                            echo "<option value='$r[id_kriteria]'>$r[nama_kriteria]</option>"; 
                        } 
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Keterangan (Label)</label>
                    <input type="text" name="nama" class="form-control" placeholder="Contoh: Murah / Ada" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Range Bawah (Min)</label>
                    <input type="number" step="any" name="min" class="form-control" placeholder="0" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Range Atas (Max)</label>
                    <input type="number" step="any" name="max" class="form-control" placeholder="100" required>
                </div>
                <div class="col-md-1">
                    <label class="form-label small">Bobot (1-5)</label>
                    <input type="number" name="nilai" class="form-control" placeholder="1-5" required>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" name="simpan" class="btn btn-success w-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-secondary text-white">
            <h6 class="m-0">Data Parameter</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Kriteria</th>
                            <th>Keterangan</th>
                            <th width="15%">Min</th>
                            <th width="15%">Max</th>
                            <th width="10%">Nilai</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $q = mysqli_query($conn, "SELECT * FROM tb_parameter JOIN tb_kriteria ON tb_parameter.id_kriteria=tb_kriteria.id_kriteria ORDER BY tb_parameter.id_kriteria ASC, nilai ASC");
                        while($d = mysqli_fetch_assoc($q)): 
                        ?>
                        <form method="POST">
                        <input type="hidden" name="id_param" value="<?=$d['id_param']?>">
                        <tr>
                            <td class="bg-light fw-bold"><?=$d['nama_kriteria']?></td>
                            
                            <td>
                                <input type="text" name="nama" class="form-control form-control-sm" value="<?=$d['nama_parameter']?>">
                            </td>
                            <td>
                                <input type="number" step="any" name="min" class="form-control form-control-sm" value="<?=$d['min_value']?>">
                            </td>
                            <td>
                                <input type="number" step="any" name="max" class="form-control form-control-sm" value="<?=$d['max_value']?>">
                            </td>
                            <td>
                                <input type="number" name="nilai" class="form-control form-control-sm" value="<?=$d['nilai']?>">
                            </td>
                            <td class="text-center">
                                <button type="submit" name="update" class="btn btn-primary btn-sm">Update</button>
                                <a href="?hapus=<?=$d['id_param']?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus parameter ini?')">Hapus</a>
                            </td>
                        </tr>
                        </form>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>