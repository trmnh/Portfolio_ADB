<?php
include_once("config/database.php");

/* Récupérer l'identifiant du projet depuis l'URL */

$projectId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($projectId) {
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->execute([$projectId]);
    $project = $stmt->fetch();
    
    if ($project) {
        // Récupérer les images associées au projet
        $imagesStmt = $pdo->prepare("SELECT * FROM project_images WHERE project_id = ?");
        $imagesStmt->execute([$projectId]);
        $images = $imagesStmt->fetchAll();
    } else {
        echo "Projet non trouvé.";
        exit;
    }
} else {
    echo "Projet non spécifié.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($project['title']); ?></title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
</head>
<body>
    <nav id="desktop-nav">
        <div class="logo">trmnh<sup>©</sup></div>
        <div>
            <ul class="nav-links">
                <li><a href="index.php">Accueil</a></li>
            </ul>
        </div>
    </nav>
    <nav id="hamburger-nav">
        <div class="logo">Minh TRIEU</div>
        <div class="hamburger-menu">
            <div class="hamburger-icon" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="menu-links">
                <li><a href="index.php" onclick="toggleMenu()">Accueil</a></li>
                
            </div>
        </div>
    </nav>
    <main>
        <section id="project-details">
            <h1 class="title"><?php echo htmlspecialchars($project['title']); ?></h1>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach ($images as $image): ?>
                        <div class="swiper-slide">
                            <img src="uploads/<?php echo htmlspecialchars($image['image_path']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="description-container">
                <p><?php echo $project['description']; ?></p>  
            </div>
            
            <div class="btn-container">
                <?php if ($project['github_link']): ?>
                    <button class="btn btn-color-2 project-btn" onclick="location.href='<?php echo htmlspecialchars($project['github_link']); ?>'">
                        Github
                    </button>
                <?php endif; ?>
                <?php if ($project['live_demo_link']): ?>
                    <button class="btn btn-color-2 project-btn" target="_blank" onclick="location.href='<?php echo htmlspecialchars($project['live_demo_link']); ?>'">
                        Live Demo
                    </button>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <footer>
        <nav>
            <div class="nav-links-container">
                <ul class="nav-links">
                    <li><a href="index.php">Accueil</a></li>
                </ul>
            </div>
        </nav>
        <p>Portfolio &#169; 2024 trmnh.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper-container', {
            loop: true,
        });

        function toggleMenu() {
            const menu = document.querySelector(".menu-links");
            const icon = document.querySelector(".hamburger-icon");
            menu.classList.toggle("open");
            icon.classList.toggle("open");
        }
    </script>
</body>
</html>