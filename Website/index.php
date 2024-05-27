<?php
$websiteTitle = "ServerPro Solutions";
$headerTitle = "ServerPro Solutions";
$footerDescription = "© 2023 ServerPro Solutions. All rights reserved.";
$contactEmail = "kontakt@serverprosolutions.com";
$contactPhone = "+49 123 456789";
$facebookLink = "https://facebook.com/serverprosolutions";
$instagramLink = "https://instagram.com/serverprosolutions";
$twitterLink = "https://twitter.com/serverprosolutions";

// Hero Block
$heroTitle = "Mieten Sie Ihre Perfekten Server";
$heroSubtitle = "Individuell angepasst mit Ihren gewünschten Anwendungen und Betriebssystemen.";
$heroButton = "Mehr Erfahren";
$heroButtonLink = "about.php";
$heroImage = "images/hero-server-room.jpg";

// Features Block
$featuresTitle = "Unsere Funktionen";
$featuresPoints = [
    ["title" => "Anpassbare Server", "description" => "Wählen Sie Ihre bevorzugten Anwendungen und Betriebssysteme."],
    ["title" => "Hohe Zuverlässigkeit", "description" => "Unsere Server bieten maximale Uptime und Stabilität."],
    ["title" => "Skalierbarkeit", "description" => "Erweitern Sie Ihre Serverkapazitäten nach Bedarf."],
    ["title" => "24/7 Support", "description" => "Unser Support-Team steht Ihnen rund um die Uhr zur Verfügung."]
];

// Blog Block
$blogItems = [
    ["name" => "Die besten Serverkonfigurationen", "description" => "Entdecken Sie die optimalen Einstellungen für verschiedene Anwendungen.", "image" => "images/server-setup.jpg"],
    ["name" => "Anwendungen und Betriebssysteme", "description" => "Welche Kombinationen sind am besten für Ihre Bedürfnisse?", "image" => "images/applications-os.jpg"],
    ["name" => "Wartung und Support", "description" => "Wie Sie Ihre Server in Top-Zustand halten.", "image" => "images/server-maintenance.jpg"],
    ["name" => "Skalierbarkeit im Fokus", "description" => "So passen Sie Ihre Serverkapazitäten dynamisch an.", "image" => "images/server-scalability.jpg"]
];

// FAQ Block
$faqTitle = "Häufig Gestellte Fragen";
$faqPoints = [
    ["title" => "Wie kann ich einen Server mieten?", "description" => "Besuchen Sie unsere Seite und wählen Sie die gewünschten Optionen."],
    ["title" => "Welche Anwendungen kann ich installieren?", "description" => "Sie können jede beliebige Anwendung installieren, die mit dem gewählten Betriebssystem kompatibel ist."],
    ["title" => "Gibt es eine Mindestmietdauer?", "description" => "Nein, Sie können die Mietdauer flexibel anpassen."],
    ["title" => "Wie erreiche ich den Support?", "description" => "Unser Support-Team ist 24/7 per Telefon und E-Mail erreichbar."],
    ["title" => "Kann ich die Serverkapazität später erweitern?", "description" => "Ja, unsere Server sind skalierbar und können jederzeit erweitert werden."],
    ["title" => "Welche Zahlungsmethoden werden akzeptiert?", "description" => "Wir akzeptieren alle gängigen Zahlungsmethoden."]
];

// Kontaktformular Block
$formTitle = "Kontaktieren Sie uns";
$formInputs = [
    ["name" => "Name", "type" => "text"],
    ["name" => "E-Mail", "type" => "email"],
    ["name" => "Nachricht", "type" => "textarea"]
];
$formButtonName = "Senden";

include 'includes/header.php';
?>

<div class="hero" style="background-image: url('<?php echo $heroImage; ?>');">
    <h1><?php echo $heroTitle; ?></h1>
    <p><?php echo $heroSubtitle; ?></p>
    <a href="<?php echo $heroButtonLink; ?>"><?php echo $heroButton; ?></a>
</div>

<div class="container">
    <div class="features">
        <h2><?php echo $featuresTitle; ?></h2>
        <?php foreach ($featuresPoints as $point): ?>
            <div class="feature-item">
                <h3><?php echo $point['title']; ?></h3>
                <p><?php echo $point['description']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="blog">
        <h2>Blog</h2>
        <?php foreach ($blogItems as $item): ?>
            <div class="blog-item">
                <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                <h3><?php echo $item['name']; ?></h3>
                <p><?php echo $item['description']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="faq">
        <h2><?php echo $faqTitle; ?></h2>
        <?php foreach ($faqPoints as $point): ?>
            <div class="faq-item">
                <h3><?php echo $point['title']; ?></h3>
                <p><?php echo $point['description']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="contact" id="contact">
        <h2><?php echo $formTitle; ?></h2>
        <form class="contact-form" action="contact.php" method="post">
            <?php foreach ($formInputs as $input): ?>
                <?php if ($input['type'] == 'textarea'): ?>
                    <textarea name="<?php echo strtolower($input['name']); ?>" placeholder="<?php echo $input['name']; ?>" style="font-family: 'Roboto', sans-serif;"></textarea>
                <?php else: ?>
                    <input type="<?php echo $input['type']; ?>" name="<?php echo strtolower($input['name']); ?>" placeholder="<?php echo $input['name']; ?>" style="font-family: 'Roboto', sans-serif;">
                <?php endif; ?>
            <?php endforeach; ?>
            <button type="submit" class="contact-button"><?php echo $formButtonName; ?></button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>
