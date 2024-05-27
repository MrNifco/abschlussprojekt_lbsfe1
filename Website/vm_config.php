<?php
$websiteTitle = "ServerPro Solutions - VM Konfiguration";
$headerTitle = "ServerPro Solutions";
$footerDescription = "© 2023 ServerPro Solutions. All rights reserved.";
$contactEmail = "kontakt@serverprosolutions.com";
$contactPhone = "+49 123 456789";
$facebookLink = "https://facebook.com/serverprosolutions";
$instagramLink = "https://instagram.com/serverprosolutions";
$twitterLink = "https://twitter.com/serverprosolutions";

include 'includes/header.php';
?>

<div class="container">
    <h2 class="section-title">VM Konfiguration</h2>
    <form id="vmForm" method="post">
        <div class="form-item">
            <label for="vmname">VM Name:</label>
            <input type="text" id="vmname" name="vmname" required pattern="[a-zA-Z0-9]+" title="Nur Buchstaben und Zahlen erlaubt">
        </div>
        <div class="form-item">
            <label for="cpucount">CPU Anzahl:</label>
            <input type="number" id="cpucount" name="cpucount" required min="4">
        </div>
        <div class="form-item">
            <label for="ramsize">RAM Größe (GB):</label>
            <input type="number" id="ramsize" name="ramsize" required min="4">
        </div>
        <div class="form-item">
            <label for="storage">Speicherplatz (GB):</label>
            <input type="number" id="storage" name="storage" required min="30">
        </div>
        <div class="form-item">
            <label for="email">E-Mail-Adresse:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-item">
            <button type="submit" class="button">Absenden</button>
        </div>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        set_time_limit(1000); // Setzt das maximale Ausführungslimit auf 1000 Sekunden

        // Der Dateiname ist immer vm_config.txt
        $filename = 'vm_config.txt';

        // Beispielwerte (normalerweise kommen diese Werte aus dem Formular)
        $vmname = isset($_POST['vmname']) ? $_POST['vmname'] : '';
        $cpucount = isset($_POST['cpucount']) ? $_POST['cpucount'] : '';
        $ramsize = isset($_POST['ramsize']) ? $_POST['ramsize'] : '';
        $storage = isset($_POST['storage']) ? $_POST['storage'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';

        // Initialisieren Sie das Array mit den Zeileninhalten, wobei leere Felder leere Strings sind
        $lines = [
            $vmname,    // Zeile 1
            $cpucount,  // Zeile 2
            $ramsize,   // Zeile 3
            $storage,   // Zeile 4
            $email      // Zeile 5
        ];

        // Öffnen Sie die Datei im Schreibmodus (w+), was eine neue Datei erstellt oder eine vorhandene Datei überschreibt
        $fileHandle = fopen($filename, 'w+');

        // Schreiben Sie jede Zeile in die Datei
        foreach ($lines as $line) {
            fwrite($fileHandle, $line . PHP_EOL);
        }

        // Schließen Sie die Datei
        fclose($fileHandle);

        // PowerShell-Skript ausführen ohne zusätzliche Parameter
        $psScriptPath = "R:\\Powershell\\Server_PS_creation\\GenVM_Nico.ps1";
        $command = "C:\\Windows\\System32\\WindowsPowerShell\\v1.0\\powershell.exe -ExecutionPolicy Bypass -NoProfile -File \"$psScriptPath\"";

        $output = shell_exec($command);
        if ($output === null) {
            echo "<script>alert('Fehler beim Ausführen des PowerShell-Skripts.');</script>";
        } else {
            echo "<script>
                alert('VM erfolgreich generiert!');
                document.getElementById('vmForm').reset();
            </script>";
        }
    }
    ?>
</div>

<?php include 'includes/footer.php'; ?>

<script src="js/script.js"></script>
<script>
document.getElementById('vmForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Zeige ein Pop-up an, dass die VM generiert wird
    alert('Die VM wird generiert. Bitte warten Sie...');

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert('VM erfolgreich generiert!');
            document.getElementById('vmForm').reset();
        } else if (xhr.readyState === 4) {
            alert(`Fehler: ${xhr.statusText}`);
        }
    };

    xhr.onerror = function() {
        alert(`Fehler beim Senden der Anfrage: ${xhr.statusText}`);
    };

    const formData = new FormData(document.getElementById('vmForm'));
    const params = new URLSearchParams();
    for (const pair of formData) {
        params.append(pair[0], pair[1]);
    }

    xhr.send(params.toString());
});
</script>
</body>
</html>
