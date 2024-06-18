<?php
include_once("../config/database.php");

/* recup id projet */
$projectId = isset($_GET['id']) ? intval($_GET['id']) : 0;


// recup projet
if ($projectId) {
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->execute([$projectId]);
    $project = $stmt->fetch();

    if (!$project) {
        echo "Projet non trouvé.";
        exit;
    }

    // recup img du projet
    $imagesStmt = $pdo->prepare("SELECT * FROM project_images WHERE project_id = ?");
    $imagesStmt->execute([$projectId]);
    $projectImages = $imagesStmt->fetchAll();

    if ($_POST) {
        // maj projet
        $title = $_POST['title'];
        $description = $_POST['description'];
        $github_link = $_POST['github_link'];
        $live_demo_link = $_POST['live_demo_link'];
        $status = $_POST['status'];

        // upload thumbnail
        $thumbnail = $project['thumbnail'];
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $thumbnailTmpPath = $_FILES['thumbnail']['tmp_name'];
            $thumbnailName = $_FILES['thumbnail']['name'];
            $thumbnailExtension = pathinfo($thumbnailName, PATHINFO_EXTENSION);
            $thumbnailNewName = uniqid() . '.' . $thumbnailExtension;
            $thumbnailUploadPath = "../uploads/" . $thumbnailNewName;
            move_uploaded_file($thumbnailTmpPath, $thumbnailUploadPath);
            $thumbnail = $thumbnailNewName;
        }

        $stmt = $pdo->prepare("UPDATE projects SET title = ?, description = ?, thumbnail = ?, github_link = ?, live_demo_link = ?, status = ? WHERE id = ?");
        $stmt->execute([$title, $description, $thumbnail, $github_link, $live_demo_link, $status, $projectId]);

        // supprimer les images de projet
        if (!empty($_POST['delete_images'])) {
            foreach ($_POST['delete_images'] as $imageId) {
                $stmt = $pdo->prepare("SELECT image_path FROM project_images WHERE id = ? AND project_id = ?");
                $stmt->execute([$imageId, $projectId]);
                $image = $stmt->fetch();

                if ($image) {
                    $imagePath = "../uploads/" . $image['image_path'];
                    if (file_exists($imagePath)) {
                        unlink($imagePath); // Supprimer l'image du serveur
                    }

                    $stmt = $pdo->prepare("DELETE FROM project_images WHERE id = ? AND project_id = ?");
                    $stmt->execute([$imageId, $projectId]);
                }
            }
        }

        // upload nouvelles images de projet
        if (isset($_FILES['project_images'])) {
            $projectImages = $_FILES['project_images'];
            for ($i = 0; $i < count($projectImages['name']); $i++) {
                if ($projectImages['error'][$i] === UPLOAD_ERR_OK) {
                    $imageTmpPath = $projectImages['tmp_name'][$i];
                    $imageName = $projectImages['name'][$i];
                    $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
                    $imageNewName = uniqid() . '.' . $imageExtension;
                    $imageUploadPath = "../uploads/" . $imageNewName;
                    move_uploaded_file($imageTmpPath, $imageUploadPath);

                    $stmt = $pdo->prepare("INSERT INTO project_images (project_id, image_path) VALUES (?, ?)");
                    $stmt->execute([$projectId, $imageNewName]);
                }
            }
        }

        header("Location: projects-list.php");
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
    <title>Modifier le Projet</title>
    <script src="https://cdn.tiny.cloud/1/glnv7b4e966wxrqluk57p7wfjjs5h8rnni8w2jcdg3up00rk/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <nav id="desktop-nav">
        <div class="logo">trmnh<sup>©</sup></div>
        <div>
            <ul class="nav-links">
                <li><a href="../index.php">Accueil</a></li>
                <li><a href="projects-list.php">Liste des Projets</a></li>
            </ul>
        </div>
    </nav>

    <main>
        <section id="edit-project">
            <h1>Modifier le Projet</h1>
            <form action="projects-edit.php?id=<?php echo $projectId; ?>" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="title">Titre :</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($project['title']); ?>" required>
                </div>
                <div>
                    <label for="description">Description :</label>
                    <textarea id="description" name="description" required><?php echo htmlspecialchars($project['description']); ?></textarea>
                </div>
                <div>
                    <label for="thumbnail">Thumbnail :</label>
                    <input type="file" id="thumbnail" name="thumbnail">
                    <p>Image actuelle : <?php echo htmlspecialchars($project['thumbnail']); ?></p>
                    <?php if ($project['thumbnail']): ?>
                        <img src="../uploads/<?php echo htmlspecialchars($project['thumbnail']); ?>" alt="Thumbnail" style="max-width: 200px;">
                    <?php endif; ?>
                </div>
                <div>
                    <label for="project_images">Images du projet :</label>
                    <input type="file" id="project_images" name="project_images[]" multiple>
                    <?php if ($projectImages): ?>
                        <p>Images actuelles :</p>
                        <?php foreach ($projectImages as $image): ?>
                            <div style="display: inline-block; text-align: center; margin-right: 10px;">
                                <img src="../uploads/<?php echo htmlspecialchars($image['image_path']); ?>" alt="Project Image" style="max-width: 100px; display: block;">
                                <input type="checkbox" name="delete_images[]" value="<?php echo $image['id']; ?>"> Supprimer
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="github_link">Lien Github :</label>
                    <input type="text" id="github_link" name="github_link" value="<?php echo htmlspecialchars($project['github_link']); ?>">
                </div>
                <div>
                    <label for="live_demo_link">Lien Live Demo :</label>
                    <input type="text" id="live_demo_link" name="live_demo_link" value="<?php echo htmlspecialchars($project['live_demo_link']); ?>">
                </div>
                <div>
                    <label for="status">Statut :</label>
                    <select id="status" name="status">
                        <option value="1" <?php echo $project['status'] == 1 ? 'selected' : ''; ?>>Affiché</option>
                        <option value="0" <?php echo $project['status'] == 0 ? 'selected' : ''; ?>>Non Affiché</option>
                    </select>
                </div>
                <button type="submit" id="maj">Mettre à jour le projet</button>
            </form>
        </section>
    </main>


    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>
</body>
</html>