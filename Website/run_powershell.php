<?php
header('Content-Type: text/plain');
header('Cache-Control: no-cache');
header('X-Accel-Buffering: no'); // Disables output buffering in Nginx

echo "Debug: run_powershell.php aufgerufen\n";

$psScriptPath = "R:\\Powershell\\Server_PS_creation\\GenVM_Nico.ps1";

// Debugging-Ausgabe: Überprüfen, ob die Datei existiert
if (!file_exists($psScriptPath)) {
    echo "PowerShell-Skriptdatei nicht gefunden: $psScriptPath";
    exit;
}

$command = "powershell -ExecutionPolicy Bypass -NoProfile -File \"$psScriptPath\"";

// Debugging-Ausgabe: Befehl ausgeben
echo "Ausführen des Befehls: $command\n";

// Starten Sie den Prozess
$proc = popen($command, 'r');

// Überprüfen, ob der Prozess gestartet wurde
if (is_resource($proc)) {
    while (!feof($proc)) {
        echo fread($proc, 4096);
        ob_flush();
        flush();
    }
    pclose($proc);
} else {
    echo "Fehler beim Starten des PowerShell-Skripts.";
}
?>
