<?php
$websiteTitle = "ServerPro Solutions";
$headerTitle = "ServerPro Solutions";
$footerDescription = "© 2023 ServerPro Solutions. All rights reserved.";
$contactEmail = "kontakt@serverprosolutions.com";
$contactPhone = "+49 123 456789";
$facebookLink = "https://facebook.com/serverprosolutions";
$instagramLink = "https://instagram.com/serverprosolutions";
$twitterLink = "https://twitter.com/serverprosolutions";

include 'includes/header.php';

// Simulierte Datenbankeinträge
$featuresPoints = [
    ["title" => "Anpassbare Server", "description" => "Wählen Sie Ihre bevorzugten Anwendungen und Betriebssysteme."],
    ["title" => "Hohe Zuverlässigkeit", "description" => "Unsere Server bieten maximale Uptime und Stabilität."],
    ["title" => "Skalierbarkeit", "description" => "Erweitern Sie Ihre Serverkapazitäten nach Bedarf."],
    ["title" => "24/7 Support", "description" => "Unser Support-Team steht Ihnen rund um die Uhr zur Verfügung."]
];

$blogItems = [
    ["name" => "Die besten Serverkonfigurationen", "description" => "Entdecken Sie die optimalen Einstellungen für verschiedene Anwendungen.", "image" => "images/server-setup.jpg"],
    ["name" => "Anwendungen und Betriebssysteme", "description" => "Welche Kombinationen sind am besten für Ihre Bedürfnisse?", "image" => "images/applications-os.jpg"],
    ["name" => "Wartung und Support", "description" => "Wie Sie Ihre Server in Top-Zustand halten.", "image" => "images/server-maintenance.jpg"],
    ["name" => "Skalierbarkeit im Fokus", "description" => "So passen Sie Ihre Serverkapazitäten dynamisch an.", "image" => "images/server-scalability.jpg"]
];

$faqPoints = [
    ["title" => "Wie kann ich einen Server mieten?", "description" => "Besuchen Sie unsere Seite und wählen Sie die gewünschten Optionen."],
    ["title" => "Welche Anwendungen kann ich installieren?", "description" => "Sie können jede beliebige Anwendung installieren, die mit dem gewählten Betriebssystem kompatibel ist."],
    ["title" => "Gibt es eine Mindestmietdauer?", "description" => "Nein, Sie können die Mietdauer flexibel anpassen."],
    ["title" => "Wie erreiche ich den Support?", "description" => "Unser Support-Team ist 24/7 per Telefon und E-Mail erreichbar."],
    ["title" => "Kann ich die Serverkapazität später erweitern?", "description" => "Ja, unsere Server sind skalierbar und können jederzeit erweitert werden."],
    ["title" => "Welche Zahlungsmethoden werden akzeptiert?", "description" => "Wir akzeptieren alle gängigen Zahlungsmethoden."]
];

$query = $_GET['query'] ?? '';

function searchResults($query, $data, $keys) {
    $results = [];
    foreach ($data as $item) {
        foreach ($keys as $key) {
            if (isset($item[$key]) && stripos($item[$key], $query) !== false) {
                $results[] = $item;
                break;
            }
        }
    }
    return $results;
}

$featureResults = searchResults($query, $featuresPoints, ['title', 'description']);
$blogResults = searchResults($query, $blogItems, ['name', 'description']);
$faqResults = searchResults($query, $faqPoints, ['title', 'description']);

?>

<div class="container">
    <h2 class="section-title">Suchergebnisse für "<?php echo htmlspecialchars($query); ?>"</h2>

    <?php if (empty($featureResults) && empty($blogResults) && empty($faqResults)): ?>
        <p>Keine Ergebnisse gefunden.</p>
    <?php else: ?>

        <?php if (!empty($featureResults)): ?>
            <div class="features">
                <h2>Funktionen</h2>
                <?php foreach ($featureResults as $result): ?>
                    <div class="feature-item">
                        <h3><?php echo $result['title']; ?></h3>
                        <p><?php echo $result['description']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($blogResults)): ?>
            <div class="blog">
                <h2>Blog</h2>
                <?php foreach ($blogResults as $result): ?>
                    <div class="blog-item">
                        <img src="<?php echo $result['image']; ?>" alt="<?php echo $result['name']; ?>">
                        <h3><?php echo $result['name']; ?></h3>
                        <p><?php echo $result['description']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($faqResults)): ?>
            <div class="faq">
                <h2>Häufig Gestellte Fragen</h2>
                <?php foreach ($faqResults as $result): ?>
                    <div class="faq-item">
                        <h3><?php echo $result['title']; ?></h3>
                        <p><?php echo $result['description']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
