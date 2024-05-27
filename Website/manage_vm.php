<?php
$websiteTitle = "ServerPro Solutions - VM Verwaltung";
$headerTitle = "ServerPro Solutions";
$footerDescription = "© 2023 ServerPro Solutions. All rights reserved.";
$contactEmail = "kontakt@serverprosolutions.com";
$contactPhone = "+49 123 456789";
$facebookLink = "https://facebook.com/serverprosolutions";
$instagramLink = "https://instagram.com/serverprosolutions";
$twitterLink = "https://twitter.com/serverprosolutions";

include 'includes/header.php';
?>

<div class="wrapper">
    <main class="container">
        <h2 class="section-title">VM Verwaltung</h2>
        <form id="vmManageForm" method="post">
            <div class="form-item">
                <label for="vmname">VM Name:</label>
                <input type="text" id="vmname" name="vmname" required pattern="[a-zA-Z0-9]+" title="Nur Buchstaben und Zahlen erlaubt">
            </div>
            <div class="form-item">
                <label for="action">Aktion:</label>
                <select id="action" name="action">
                    <option value="">Bitte auswählen</option>
                    <option value="start">Starten</option>
                    <option value="stop">Stoppen</option>
                    <option value="restart">Neustarten</option>
                </select>
            </div>
            <div class="form-item">
                <label for="cpucount">CPU Anzahl:</label>
                <input type="number" id="cpucount" name="cpucount" min="1" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
            </div>
            <div class="form-item">
                <label for="ramsize">Neue RAM Größe (GB):</label>
                <input type="number" id="ramsize" name="ramsize" min="4" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
            </div>
            <div class="form-item">
                <label for="storage">Neue Speichergröße (GB):</label>
                <input type="number" id="storage" name="storage" min="30" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
            </div>
            <div class="form-item">
                <button type="submit" class="button">Absenden</button>
            </div>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            set_time_limit(1000); // Setzt das maximale Ausführungslimit auf 1000 Sekunden

            // Der Dateiname ist immer change_vm.txt
            $filename = 'change_vm.txt';

            // Beispielwerte (normalerweise kommen diese Werte aus dem Formular)
            $vmname = isset($_POST['vmname']) ? $_POST['vmname'] : '';
            $action = isset($_POST['action']) ? $_POST['action'] : '';
            $cpucount = isset($_POST['cpucount']) ? $_POST['cpucount'] : '';
            $ramsize = isset($_POST['ramsize']) ? $_POST['ramsize'] : '';
            $storage = isset($_POST['storage']) ? $_POST['storage'] : '';

            // Initialisieren Sie das Array mit den Zeileninhalten, wobei leere Felder leere Strings sind
            $lines = [
                $vmname,   // Zeile 1
                $action,   // Zeile 2
                $cpucount, // Zeile 3
                $ramsize,  // Zeile 4
                $storage   // Zeile 5
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
            $psScriptPath = "R:\\Powershell\\Server_PS_creation\\ManageVM_Nico.ps1";
            $command = "C:\\Windows\\System32\\WindowsPowerShell\\v1.0\\powershell.exe -ExecutionPolicy Bypass -NoProfile -File \"$psScriptPath\"";

            $output = shell_exec($command);
            if ($output === null) {
                echo "<script>alert('Fehler beim Ausführen des PowerShell-Skripts.');</script>";
            } else {
                echo "<script>alert('Aktion erfolgreich ausgeführt!');</script>";
            }
        }
        ?>
    </main>
</div>

<?php include 'includes/footer.php'; ?>

<script src="js/script.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.contact-form');
    if (form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            alert('Formular wurde erfolgreich gesendet!');
            form.reset();
        });
    }

    const header = document.querySelector('header');
    let lastScrollY = window.scrollY;

    window.addEventListener('scroll', () => {
        if (lastScrollY < window.scrollY) {
            header.classList.add('hidden-header');
        } else {
            header.classList.remove('hidden-header');
        }
        lastScrollY = window.scrollY;
    });

    // Smooth scroll to contact section
    const contactLinks = document.querySelectorAll('a[href="#contact"]');
    const contactSection = document.getElementById('contact');

    contactLinks.forEach(contactLink => {
        contactLink.addEventListener('click', (event) => {
            event.preventDefault();
            if (window.location.pathname === '/') {
                contactSection.scrollIntoView({ behavior: 'smooth' });
            } else {
                window.location.href = '/#contact';
            }
        });
    });

    // Keep dropdown menu open when hovering over it or the menu button
    const menuBtn = document.querySelector('.menu-btn');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    let dropdownTimeout;

    menuBtn.addEventListener('mouseenter', () => {
        clearTimeout(dropdownTimeout);
        dropdownMenu.style.display = 'block';
    });

    menuBtn.addEventListener('mouseleave', () => {
        dropdownTimeout = setTimeout(() => {
            if (!dropdownMenu.matches(':hover')) {
                dropdownMenu.style.display = 'none';
            }
        }, 300);
    });

    dropdownMenu.addEventListener('mouseenter', () => {
        clearTimeout(dropdownTimeout);
        dropdownMenu.style.display = 'block';
    });

    dropdownMenu.addEventListener('mouseleave', () => {
        dropdownTimeout = setTimeout(() => {
            dropdownMenu.style.display = 'none';
        }, 300);
    });
});
</script>
</body>
</html>
