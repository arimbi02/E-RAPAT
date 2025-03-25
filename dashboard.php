<?php
session_start();
include('koneksierapat.php');

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Query untuk mengambil data profil berdasarkan username
$sql = "SELECT profile.nip, profile.nama, profile.foto, jabatan.nama_jabatan AS division 
        FROM profile 
        JOIN jabatan ON profile.jabatan_id = jabatan.id
        WHERE profile.username = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();

// Menentukan path foto profil
$fotoPath = !empty($profile['foto']) ? "uploads/" . $profile['foto'] : "assets/icons/default-profile.png";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard - E-Rapat</title>
    <style>
        /* Profile Section */
        .profile-container {
            display: flex;
            align-items: center;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 20px auto;
            margin-left: 0px; /* Geser lebih ke kiri */
        }
        .profile-photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
        }

    </style>
    <script defer src="script.js"></script>
</head>
<body>

    <!-- HEADER -->
    <header class="header">
        <div class="header-icons" style="position: absolute; top: 10px; right: 20px; display: flex; gap: 15px;">
            <!-- <div class="dropdown">
                <span class="notification-icon" onclick="toggleDropdown('notif-dropdown')">
                    <img src="assets/icons/ikonnotif.png" alt="Notifikasi" width="24">
                </span>
                <div id="notif-dropdown" class="dropdown-content"></div>
            </div> -->
            <div class="dropdown">
                <span class="profile-icon" onclick="toggleDropdown('profile-dropdown')">
                    <img src="<?= htmlspecialchars($fotoPath) ?>" alt="Foto Profil" width="40" height="40" 
                         style="border-radius: 50%; object-fit: cover;" 
                         onerror="this.src='assets/icons/default-profile.png'">
                </span>
                <div id="profile-dropdown" class="dropdown-content">
                    <button onclick="logout()">Log Out</button>
                </div>           
            </div>
        </div>
    </header>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="logo-container">
            <a href="dashboard.php" style="display: flex; align-items: center; gap: 10px; text-decoration: none; color: inherit;">
                <img src="assets/icons/logo.png" alt="Logo" class="logo">
                <h2>E - Rapat</h2>
            </a>
        </div>
    
        <nav>
            <ul>
                <li><a href="schedule.php"><img src="assets/icons/ikonschedule.png" class="icon"> SCHEDULE</a></li>
                <li><a href="submission.php"><img src="assets/icons/ikonsubmission.png" class="icon"> SUBMISSION</a></li>
                <li><a href="presence.php"><img src="assets/icons/ikonpresence.png" class="icon"> PRESENCE</a></li>
                <li><a href="history.php"><img src="assets/icons/ikonhistory.png" class="icon"> HISTORY</a></li>
            </ul>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="content">
        <h1>Welcome to E-Rapat</h1>
        <p>Manage your meetings efficiently with our dashboard.</p>

        <!-- Profile Section -->
        <div class="profile-container">
            <img src="<?= htmlspecialchars($fotoPath) ?>" alt="Foto Profil" class="profile-photo">
            <div class="profile-info">
                <h2><?= htmlspecialchars($profile['nama'] ?? "Nama Tidak Ditemukan") ?></h2>
                <p><strong>NIP:</strong> <?= htmlspecialchars($profile['nip'] ?? "-") ?></p>
                <p><strong>Jabatan:</strong> <?= htmlspecialchars($profile['division'] ?? "-") ?></p>
            </div>
        </div>
    </main>

    <script>
    function toggleDropdown(id) {
        let dropdown = document.getElementById(id);
        dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    }

    window.onclick = function(event) {
        if (!event.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-content').forEach(dropdown => {
                dropdown.style.display = "none";
            });
        }
    };

    function logout() {
        alert("Anda telah keluar!");
        window.location.href = "logout.php";
    }
    </script>

</body>
</html>