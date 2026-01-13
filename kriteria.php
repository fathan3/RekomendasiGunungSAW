<?php 
include 'koneksi.php'; 
include 'header.php'; 

// --- LOGIKA TAMBAH DATA (INSERT) ---
if(isset($_POST['tambah'])) {
    $kode   = $_POST['kode'];
    $nama   = $_POST['nama'];
    $atribut= $_POST['atribut'];
    $bobot  = $_POST['bobot'];

    $query = "INSERT INTO tb_kriteria (kode_kriteria, nama_kriteria, atribut, bobot) 
              VALUES ('$kode', '$nama', '$atribut', '$bobot')";
    
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Data Berhasil Ditambah!'); window.location='kriteria.php'</script>";
    } else {
        echo "<script>alert('Gagal menambah data!');</script>";
    }
}

// --- LOGIKA UPDATE DATA (EDIT) ---
if(isset($_POST['update'])) {
    $id     = $_POST['id'];
    $nama   = $_POST['nama'];
    $atribut= $_POST['atribut'];
    $bobot  = $_POST['bobot']; // Pastikan desimal menggunakan titik (.)

    $query = "UPDATE tb_kriteria SET nama_kriteria='$nama', atribut='$atribut', bobot='$bobot' WHERE id_kriteria='$id'";
    
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Update Berhasil'); window.location='kriteria.php'</script>";
    }
}

// --- LOGIKA HAPUS DATA ---
if(isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM tb_kriteria WHERE id_kriteria='$id'");
    echo "<script>alert('Data Dihapus'); window.location='kriteria.php'</script>";
}
?>

<div class="container mt-4">
    
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h6 class="m-0">Tambah Kriteria Baru</h6>
        </div>
        <div class="card-body">
            <form method="POST" class="row g-3">
                <div class="col-md-2">
                    <label class="form-label">Kode</label>
                    <input type="text" name="kode" class="form-control" placeholder="Contoh: K5" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nama Kriteria</label>
                    <input type="text" name="nama" class="form-control" placeholder="Contoh: Keamanan" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Atribut</label>
                    <select name="atribut" class="form-select">
                        <option value="benefit">Benefit (Makin besar makin bagus)</option>
                        <option value="cost">Cost (Makin kecil makin bagus)</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Bobot</label>
                    <input type="number" step="0.01" name="bobot" class="form-control" placeholder="0.1" required>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" name="tambah" class="btn btn-success w-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-warning">
            <h6 class="m-0">Data Kriteria & Bobot (Edit Langsung)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="10%">Kode</th>
                            <th>Nama Kriteria</th>
                            <th width="20%">Atribut</th>
                            <th width="15%">Bobot</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $q = mysqli_query($conn, "SELECT * FROM tb_kriteria ORDER BY kode_kriteria ASC"); 
                        while($d = mysqli_fetch_assoc($q)): 
                        ?>
                        <form method="POST">
                        <input type="hidden" name="id" value="<?=$d['id_kriteria']?>">
                        <tr>
                            <td class="text-center fw-bold"><?=$d['kode_kriteria']?></td>
                            <td>
                                <input type="text" name="nama" class="form-control" value="<?=$d['nama_kriteria']?>">
                            </td>
                            <td>
                                <select name="atribut" class="form-select">
                                    <option value="cost" <?=($d['atribut']=='cost')?'selected':''?>>Cost</option>
                                    <option value="benefit" <?=($d['atribut']=='benefit')?'selected':''?>>Benefit</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" step="0.01" name="bobot" class="form-control" value="<?=$d['bobot']?>">
                            </td>
                            <td class="text-center">
                                <button type="submit" name="update" class="btn btn-primary btn-sm mb-1">Update</button>
                                <a href="?hapus=<?=$d['id_kriteria']?>" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Yakin hapus kriteria ini?')">Hapus</a>
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