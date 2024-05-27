<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $websiteTitle; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="navbar">
            <h1><?php echo $headerTitle; ?></h1>
            <div class="menu-btn">☰</div>
            <div class="dropdown-menu">
                <a href="index.php">Home</a>
                <a href="about.php">Über uns</a>
                <a href="history.php">Unsere Geschichte</a>
                <a href="vm_config.php">VM Konfigurator</a>
				<a href="manage_vm.php">VM Manager</a>
                <a href="impressum.php">Impressum</a>
                <div class="search-container">
                    <form action="search.php" method="GET">
                        <input type="text" name="query" placeholder="Suchen...">
                    </form>
                </div>
            </div>
        </div>
    </header>
