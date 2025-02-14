<?php
header("Content-Type: application/json");
$events = [
    ["title" => "Rapat Tim", "start" => "2025-02-10", "description" => "Diskusi proyek baru"],
    ["title" => "Presentasi Klien", "start" => "2025-02-15", "description" => "Presentasi hasil kerja"],
    ["title" => "Meeting Evaluasi", "start" => "2025-02-20", "description" => "Evaluasi bulanan"]
];

echo json_encode($events);
?>