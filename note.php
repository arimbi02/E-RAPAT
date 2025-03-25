<?php
include 'koneksierapat.php';

// Ambil data jabatan dari tabel jabatan
$sql = "SELECT id, nama_jabatan FROM jabatan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Note Berita Acara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Add Note Berita Acara</h2>
        <form action="submit_surat.php" method="POST">

            <!-- ID Agenda (Hidden) -->
            <input type="hidden" id="id_agenda" name="id_agenda">
            
            <!-- Pimpinan Rapat -->
            <div class="mb-3">
                <label for="pimpinan_rapat" class="form-label">Pimpinan Rapat</label>
                <input type="text" class="form-control" id="pimpinan_rapat" name="pimpinan_rapat" required>
            </div>

            <!-- Peserta Rapat -->
            <div class="mb-3">
                <label for="peserta_rapat" class="form-label">Peserta Rapat</label>
                <select class="form-control" id="peserta_rapat" name="peserta_rapat[]" multiple>
                    <?php
                    include 'koneksi.php'; // Pastikan koneksi database benar
                    $sql = "SELECT id, nama_jabatan FROM jabatan";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['nama_jabatan'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Data jabatan tidak tersedia</option>";
                    }
                    ?>
                </select>
                <small class="text-muted">Tekan Ctrl (Windows) atau Command (Mac) untuk memilih lebih dari satu.</small>
            </div>


            <!-- Notulen -->
            <div class="mb-3">
                <label for="notulen" class="form-label">Notulen</label>
                <input type="text" class="form-control" id="notulen" name="notulen" required>
            </div>

            <!-- Perihal -->
            <div class="mb-3">
                <label for="perihal" class="form-label">Perihal</label>
                <textarea class="form-control" id="perihal" name="perihal" rows="2" required></textarea>
            </div>

            <!-- Pembahasan -->
            <div class="mb-3">
                <label for="pembahasan" class="form-label">Pembahasan</label>
                <textarea class="form-control" id="pembahasan" name="pembahasan" rows="4" required></textarea>
            </div>

            <!-- Kesimpulan -->
            <div class="mb-3">
                <label for="kesimpulan" class="form-label">Kesimpulan</label>
                <textarea class="form-control" id="kesimpulan" name="kesimpulan" rows="3" required></textarea>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="btn btn-primary w-100">Simpan Data</button>
        </form>
    </div>

    <script>
        // Ambil ID Agenda dari URL
        const urlParams = new URLSearchParams(window.location.search);
        const idAgenda = urlParams.get('id');

        // Jika ID Agenda ditemukan, set ke input hidden
        if (idAgenda) {
            document.getElementById("id_agenda").value = idAgenda;
        } else {
            // Jika tidak ada ID di URL, tampilkan alert dan redirect ke schedule.php
            alert("ID Agenda tidak ditemukan!");
            window.location.href = "schedule.php";
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
