<?php
include_once("../config/database.php");

/* Récupérer la liste des projets */
$stmt = $pdo->query("SELECT * FROM projects");
$projects = $stmt->fetchAll();

/* action des forms */
if ($_POST) {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action === 'add') {
            // ajout projet
            $title = $_POST['title'];
            $description = $_POST['description'];
            $github_link = $_POST['github_link'];
            $live_demo_link = $_POST['live_demo_link'];
            $status = $_POST['status'];

            // upload thumbnail
            $thumbnail = '';
            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
                $thumbnailTmpPath = $_FILES['thumbnail']['tmp_name'];
                $thumbnailName = $_FILES['thumbnail']['name'];
                $thumbnailSize = $_FILES['thumbnail']['size'];
                $thumbnailType = $_FILES['thumbnail']['type'];
                $thumbnailExtension = pathinfo($thumbnailName, PATHINFO_EXTENSION);
                $thumbnailNewName = uniqid() . '.' . $thumbnailExtension;
                $thumbnailUploadPath = "../uploads/" . $thumbnailNewName;
                move_uploaded_file($thumbnailTmpPath, $thumbnailUploadPath);
                $thumbnail = $thumbnailNewName;
            }

            $stmt = $pdo->prepare("INSERT INTO projects (title, description, thumbnail, github_link, live_demo_link, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $thumbnail, $github_link, $live_demo_link, $status]);
            $projectId = $pdo->lastInsertId();

            // upload images projet
            if (isset($_FILES['project_images'])) {
                $projectImages = $_FILES['project_images'];
                for ($i = 0; $i < count($projectImages['name']); $i++) {
                    if ($projectImages['error'][$i] === UPLOAD_ERR_OK) {
                        $imageTmpPath = $projectImages['tmp_name'][$i];
                        $imageName = $projectImages['name'][$i];
                        $imageSize = $projectImages['size'][$i];
                        $imageType = $projectImages['type'][$i];
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
        } elseif ($action === 'delete') {
            // supprimer
            $projectId = $_POST['project_id'];
            $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
            $stmt->execute([$projectId]);
            header("Location: projects-list.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Projets</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.tiny.cloud/1/glnv7b4e966wxrqluk57p7wfjjs5h8rnni8w2jcdg3up00rk/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
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
        <section id="project-list">
            <h1>Liste des Projets</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($project['id']); ?></td>
                            <td><?php echo htmlspecialchars($project['title']); ?></td>
                            <td><?php echo $project['status'] == 1 ? 'Affiché' : 'Non Affiché'; ?></td>
                            <td>
                                <a href="../project.php?id=<?php echo $project['id']; ?>">Afficher</a>
                                <a href="projects-edit.php?id=<?php echo $project['id']; ?>">Modifier</a>
                                <form action="projects-list.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?');">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        

        <div id="project-add">
            <h2>Ajouter un nouveau projet</h2>
            <form action="projects-list.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                <div>
                    <label for="title">Titre :</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div>
                    <label for="description">Description :</label>
                    <textarea id="description" name="description"></textarea>
                </div>
                <div>
                    <label for="thumbnail">Thumbnail :</label>
                    <input type="file" id="thumbnail" name="thumbnail" required>
                </div>
                <div>
                    <label for="project_images">Images du projet :</label>
                    <input type="file" id="project_images" name="project_images[]" multiple>
                </div>
                <div>
                    <label for="github_link">Lien Github :</label>
                    <input type="text" id="github_link" name="github_link" placeholder="https://example.com">
                </div>
                <div>
                    <label for="live_demo_link">Lien Live Demo :</label>
                    <input type="text" id="live_demo_link" name="live_demo_link" placeholder="https://example.com">
                </div>
                <div>
                    <label for="status">Statut :</label>
                    <select id="status" name="status">
                        <option value="1">Affiché</option>
                        <option value="0">Non Affiché</option>
                    </select>
                </div>
                <button type="submit" id="maj">Ajouter le projet</button>
            </form>
        </div>
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