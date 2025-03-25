<?php
session_start();
include('koneksierapat.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$sql = "SELECT profile.foto FROM profile WHERE profile.username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();
$fotoPath = !empty($profile['foto']) ? "uploads/" . $profile['foto'] : "assets/icons/default-profile.png";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Agenda</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <style>
        #calendar {
            max-width: 80%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .fc-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .fc-button {
            background-color: #749BC2 !important;
            border: none !important;
            color: white !important;
            padding: 8px 12px;
            border-radius: 4px;
            text-shadow: none !important;
            box-shadow: none !important;
        }

        .fc-event {
            background-color: #749BC2 !important;
            border: none !important;
            color: white !important;
            padding: 5px;
            border-radius: 5px;
        }

        .new-schedule-button {
            background-color: #749BC2;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 20px;
            display: inline-block;
            text-decoration: none;
        }
    </style>
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
    
    <main>
        <h1>Meeting Agenda</h1>
        <div id="calendar"></div>
        
        <table id="agenda-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Schedule</th>
                    <th>Description</th>
                    <th>Location</th>
                    <th>Invitation Letter</th>
                    <th>Documentation</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <a href="submission.php" class="new-schedule-button">New Schedule</a>
    </main>
    
    <script>
        function toggleDropdown(id) {
            let dropdown = document.getElementById(id);
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        }

        document.addEventListener("click", function(event) {
            let dropdown = document.getElementById("profile-dropdown");
            let profileIcon = document.querySelector(".profile-icon");

            if (!profileIcon.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.style.display = "none";
            }
        });

        function logout() {
            alert("Anda telah keluar!");
            window.location.href = "login.php";
        }
        $(document).ready(function() {
            const agendaTableBody = $("#agenda-table tbody");
            agendaTableBody.html('');
            
            $.getJSON('get_schedule.php', function(agenda) {
                if (agenda && agenda.length > 0) {
                    $('#calendar').fullCalendar({
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay,listWeek'
                        },
                        defaultView: 'month',
                        editable: false,
                        eventLimit: true,
                        events: agenda.map(event => ({
                            title: event.schedule_name,
                            start: event.date,
                            description: event.description
                        })),
                        eventClick: function(event) {
                            alert("Agenda: " + event.title + "\nDeskripsi: " + event.description);
                        }
                    });
                    
                    agenda.forEach(event => {
                        let fileName = event.invitation_letter; 

                        if (fileName.startsWith("uploads/")) {
                            fileName = fileName.replace("uploads/", "");
                        }

                        let filePath = `http://localhost/E-RAPAT/uploads/${fileName}`;
                        let invitationLetter = event.invitation_letter && event.invitation_letter !== '-' 
                            ? `<a href="${filePath}" target="_blank">Lihat File</a>` 
                            : "-";

                        console.log("File Path:", filePath); // Debugging

                        let documentation = "-";
                    if (event.documentation && event.documentation !== '-') {
                        let fileName = event.documentation;

                        // Pastikan tidak ada "uploads/" yang berulang
                        if (fileName.startsWith("uploads/")) {
                            fileName = fileName.replace("uploads/", "");
                        }

                        let filePath = `http://localhost/E-RAPAT/uploads/${fileName}`;

                        let fileExt = fileName.split('.').pop().toLowerCase();
                        if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExt)) {
                            documentation = `<a href="${filePath}" target="_blank"><img src="${filePath}" alt="Dokumentasi" width="50"></a>`;
                        } else {
                            documentation = `<a href="${filePath}" target="_blank">Buka File</a>`;
                        }

                        console.log("Dokumentasi Path:", filePath); // Debugging
                    }

                        let row = `<tr>
                            <td>${event.date}</td>
                            <td>${event.schedule_name}</td>
                            <td>${event.description}</td>
                            <td>${event.location}</td>
                            <td>${invitationLetter}</td>
                            <td>${documentation}</td>
                            <td>
                                <button onclick="window.location.href='edit_schedule.php?id=${event.id}'" style="background: none; border: none; padding: 0;">
                                    <img src="assets/icons/edit.png" alt="Edit" width="30">
                                </button>
                                <button onclick="window.location.href='note.html?id=${event.id}'" style="background: none; border: none; padding: 0;">
                                    <img src="assets/icons/addnote.png" alt="Add Note" width="30">
                                </button>
                                <button onclick="window.location.href='tampilkan_surat.php?id=${event.id}'" style="background: none; border: none; padding: 0;">
                                    <img src="assets/icons/print.png" alt="Print" width="30">
                                </button>
                            </td>
                        </tr>`;
                        agendaTableBody.append(row);
                    });
                }
            }).fail(function() {
                console.error("Error loading agenda data");
            });
        });
    </script>
</body>
</html>