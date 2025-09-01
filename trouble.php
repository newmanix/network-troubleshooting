<?php
declare(strict_types=1);
ini_set('display_errors','1');
error_reporting(E_ALL);
//file designed to cause trouble for us to troubleshoot

$mode = $_GET['mode'] ?? 'db';            // 'db' (default) or 'cpu'
$seconds = (int)($_GET['seconds'] ?? 20); // run time
$seconds = max(5, min($seconds, 60));     // clamp to 5..60
$end = microtime(true) + $seconds;

echo "<!doctype html><html><head><meta charset='utf-8'><title>Trouble Maker</title></head><body>";
echo "<h1>Trouble Maker</h1>";
echo "<p>This file was designed to cause us trouble for us to troubleshoot</p>";
echo "<p>Mode: <strong>".htmlspecialchars($mode)."</strong>, seconds: <strong>{$seconds}</strong></p>";
echo "<p><a href='?mode=db&seconds=20'>Run DB stress (20s)</a> | <a href='?mode=cpu&seconds=20'>Run CPU stress (20s)</a></p>";
echo "<pre>";

if ($mode === 'cpu') {
    // Busy CPU loop
    $tick = 0;
    while (microtime(true) < $end) {
        $x = 0;
        for ($j = 0; $j < 500000; $j++) { $x += $j % 7; }
        $tick++;
        if ($tick % 5 === 0) { echo "CPU tick {$tick}\n"; @ob_flush(); flush(); }
    }
    echo "CPU stress complete.\n";
} else {
    // DB stress: lots of short SELECTs
    $mysqli = @new mysqli('db', 'labuser', 'labpass', 'testdb');
    if ($mysqli->connect_errno) {
        http_response_code(500);
        echo "DB connect failed: {$mysqli->connect_error}\n";
        echo "</pre></body></html>";
        exit;
    }
    $mysqli->set_charset('utf8mb4');

    $i = 0;
    while (microtime(true) < $end) {
        // Fast query that still generates notable load at volume
        $res = $mysqli->query("SELECT id, first_name, last_name FROM users ORDER BY id DESC LIMIT 1");
        if ($res) { $res->free(); }
        $i++;
        if ($i % 10 === 0) { echo "DB query {$i}\n"; @ob_flush(); flush(); }
    }
    echo "DB stress complete. Ran {$i} queries.\n";
}

echo "</pre><p>Done.</p></body></html>";
