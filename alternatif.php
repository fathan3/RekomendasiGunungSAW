<?php 
include 'koneksi.php'; 
include 'header.php'; 

// --- 1. LOGIKA TAMBAH (INSERT) ---
if(isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $k1   = $_POST['k1']; // Biaya
    $k2   = $_POST['k2']; // Durasi
    $k3   = $_POST['k3']; // Air
    $k4   = $_POST['k4']; // Rating

    $q = "INSERT INTO tb_alternatif (nama_alternatif, k1_val, k2_val, k3_val, k4_val) 
          VALUES ('$nama','$k1','$k2','$k3','$k4')";
    
    if(mysqli_query($conn, $q)) {
        echo "<script>alert('Data Berhasil Ditambah!'); window.location='alternatif.php'</script>";
    }
}

// --- 2. LOGIKA UPDATE (EDIT) ---
if(isset($_POST['update'])) {
    $id   = $_POST['id'];
    $nama = $_POST['nama'];
    $k1   = $_POST['k1'];
    $k2   = $_POST['k2'];
    $k3   = $_POST['k3'];
    $k4   = $_POST['k4'];

    $q = "UPDATE tb_alternatif SET 
          nama_alternatif='$nama', 
          k1_val='$k1', 
          k2_val='$k2', 
          k3_val='$k3', 
          k4_val='$k4' 
          WHERE id_alternatif='$id'";

    if(mysqli_query($conn, $q)) {
        echo "<script>alert('Data Berhasil Diupdate!'); window.location='alternatif.php'</script>";
    }
}

// --- 3. LOGIKA HAPUS (DELETE) ---
if(isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM tb_alternatif WHERE id_alternatif='$id'");
    echo "<script>alert('Data Dihapus'); window.location='alternatif.php'</script>";
}
?>

<div class="container mt-4">

    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h6 class="m-0">Input Gunung</h6>
        </div>
        <div class="card-body">
            <form method="POST" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small">Nama Gunung</label>
                    <input type="text" name="nama" class="form-control" placeholder="Contoh: Gn. Prau" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Biaya (Rp)</label>
                    <input type="number" name="k1" class="form-control" placeholder="150000" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Durasi (Jam)</label>
                    <input type="number" step="0.1" name="k2" class="form-control" placeholder="3.5" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Mata Air</label>
                    <select name="k3" class="form-control">
                        <option value="Ada">Ada</option>
                        <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Rating (1-5)</label>
                    <input type="number" step="0.1" name="k4" class="form-control" placeholder="4.8" required>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" name="simpan" class="btn btn-success w-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h6 class="m-0">Data Alternatif</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Gunung</th>
                            <th width="15%">Biaya (Rp)</th>
                            <th width="12%">Durasi (Jam)</th>
                            <th width="15%">Air</th>
                            <th width="10%">Rating</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $q = mysqli_query($conn, "SELECT * FROM tb_alternatif ORDER BY id_alternatif DESC"); 
                        $no = 1;
                        while($d = mysqli_fetch_assoc($q)): 
                        ?>
                        <form method="POST">
                        <input type="hidden" name="id" value="<?=$d['id_alternatif']?>">
                        <tr>
                            <td class="text-center"><?=$no++?></td>
                            
                            <td>
                                <input type="text" name="nama" class="form-control form-control-sm" value="<?=$d['nama_alternatif']?>">
                            </td>
                            
                            <td>
                                <input type="number" name="k1" class="form-control form-control-sm" value="<?=$d['k1_val']?>">
                            </td>
                            
                            <td>
                                <input type="number" step="0.1" name="k2" class="form-control form-control-sm" value="<?=$d['k2_val']?>">
                            </td>
                            
                            <td>
                                <select name="k3" class="form-select form-select-sm">
                                    <option value="Ada" <?=($d['k3_val']=='Ada')?'selected':''?>>Ada</option>
                                    <option value="Tidak Ada" <?=($d['k3_val']=='Tidak Ada')?'selected':''?>>Tidak Ada</option>
                                </select>
                            </td>
                            
                            <td>
                                <input type="number" step="0.1" name="k4" class="form-control form-control-sm" value="<?=$d['k4_val']?>">
                            </td>
                            
                            <td class="text-center">
                                <button type="submit" name="update" class="btn btn-primary btn-sm">Update</button>
                                <a href="?hapus=<?=$d['id_alternatif']?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</a>
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