<?php
include_once("config/database.php");

/* Récupérer les 3 derniers projets actifs */

try {
  $query = "SELECT * FROM projects WHERE status = 1 LIMIT 3";
  $statement = $pdo->prepare($query);
  $statement->execute();
  $projects = $statement->fetchAll();
} catch (PDOException $e) {
  die("Error retrieving projects: " . $e->getMessage());
}

/* Formulaire de contact */

if ($_POST) {
  $name = htmlspecialchars(trim($_POST["name"]));
  $email = htmlspecialchars(trim($_POST["email"]));
  $message = htmlspecialchars(trim($_POST["message"]));

  $to = "minh.trieu@apprenant.ifapme.be";
  $subject = "Nouveau message de $name";
  $headers = "From: $email\r\n";
  $headers .= "Reply-To: $email\r\n";
  $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

  $body = "Nom: $name\n";
  $body .= "Email: $email\n\n";
  $body .= "Message:\n$message\n";

  if (mail($to, $subject, $body, $headers)) {
      $successMessage = "Votre message a été envoyé avec succès.";
  } else {
      $errorMessage = "Une erreur s'est produite. Veuillez réessayer plus tard.";
  }
}
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Portfolio | Minh TRIEU</title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/mediaqueries.css" />  
  </head>
  <body>
    <nav id="desktop-nav">
      <div class="logo">trmnh<sup>©</sup></div>
      <div>
        <ul class="nav-links">
          <li><a href="#about">A Propos</a></li>
          <li><a href="#competence">Compétences</a></li>
          <li><a href="#projects">Projets</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
      </div>
    </nav>
    <nav id="hamburger-nav">
      <div class="logo">trmnh<sup>©</sup></div>
      <div class="hamburger-menu">
        <div class="hamburger-icon" onclick="toggleMenu()">
          <span></span>
          <span></span>
          <span></span>
        </div>
        <div class="menu-links">
          <li><a href="#about" onclick="toggleMenu()">A Propos</a></li>
          <li><a href="#competence" onclick="toggleMenu()">Compétences</a></li>
          <li><a href="#projects" onclick="toggleMenu()">Projets</a></li>
          <li><a href="#contact" onclick="toggleMenu()">Contact</a></li>
        </div>
      </div>
    </nav>
    <section id="profile">
      <div class="section__pic-container">
        <img src="assets/img/profil.png" alt="Image profil" />
      </div>
      <div class="section__text">
        <p class="section__text__p1">Bonjour! 👋</p>
        <h1 class="title">Je suis Minh,</h1>
        <p class="section__text__p2">Développeur frontend basé à Liège.</p>
        <div class="btn-container">
          <button
            class="btn btn-color-2"
            onclick="window.open('assets/img/CV.pdf')"
          >
            Mon CV
          </button>
          <button class="btn btn-color-1" onclick="location.href='./#projects'">
            Mes projets
          </button>
        </div>
        <div id="socials-container">
          <img
            src="assets/img/linkedin.png"
            alt="Profil LinkedIn"
            class="icon"
            onclick="location.href='https://linkedin.com/'"
          />
          <img
            src="assets/img/github.png"
            alt="Profil Github"
            class="icon"
            onclick="location.href='https://github.com/'"
          />
        </div>
      </div>
    </section>
    <section id="about">
      <p class="section__text__p1">En savoir plus</p>
      <h1 class="title">À propos de moi</h1>
      <div class="section-container">
        <div class="section__pic-container">
          <img
            src="assets/img/apropos.png"
            alt="Image profil à propos"
            class="about-pic"
          />
        </div>
        <div class="about-details-container">
          <div class="about-containers">
            <div class="details-container">
              <img
                src="assets/img/experience.png"
                alt="Icon experience"
                class="icon"
              />
              <h3>Profil</h3>
              <p>
                25 ans<br />Né à Liège <br /> Apprenti développeur frontend
              </p>
            </div>
            <div class="details-container">
              <img
                src="assets/img/education.png"
                alt="Icon education"
                class="icon"
              />
              <h3>Études</h3>
              <p>
                Depuis septembre 2023 | Formation développeur front end -
                IFAPME<br />2019 - 2023 | Droit - ULiège
              </p>
            </div>
          </div>
          <div class="text-container">
            <p>
              Passionné par le développement web et la création d'expériences
              utilisateur innovantes, je suis un développeur frontend à la
              recherche de défis stimulants. Mon objectif est de combiner ma
              passion pour la technologie avec ma créativité pour concevoir des
              solutions web élégantes et fonctionnelles.
            </p>
          </div>
        </div>
      </div>
      <img
        src="assets/img/arrow.png"
        alt="Icon arrow"
        class="icon arrow"
        onclick="location.href='./#competence'"
      />
    </section>
    <section id="competence">
      <p class="section__text__p1">Explorez mes</p>
      <h1 class="title">Compétences</h1>

      <div class="competence-details-container">
        <div class="about-containers">
          <div class="details-container">
            <h2 class="competence-sub-title">Développement frontend</h2>
            <div class="article-container">
              <article>
                <img
                  src="assets/img/checkmark.png"
                  alt="Icon competence"
                  class="icon"
                />
                <div>
                  <h3>HTML</h3>
                  <p>Experienced</p>
                </div>
              </article>
              <article>
                <img
                  src="assets/img/checkmark.png"
                  alt="Icon competence"
                  class="icon"
                />
                <div>
                  <h3>CSS</h3>
                  <p>Experienced</p>
                </div>
              </article>
              <article>
                <img
                  src="assets/img/checkmark.png"
                  alt="Icon competence"
                  class="icon"
                />
                <div>
                  <h3>JavaScript</h3>
                  <p>Basic</p>
                </div>
              </article>
            </div>
          </div>
          <div class="details-container">
            <h2 class="competence-sub-title">Développement backend</h2>
            <div class="article-container">
              <article>
                <img
                  src="assets/img/checkmark.png"
                  alt="Icon competence"
                  class="icon"
                />
                <div>
                  <h3>SQL</h3>
                  <p>Basic</p>
                </div>
              </article>
              <article>
                <img
                  src="assets/img/checkmark.png"
                  alt="Icon competence"
                  class="icon"
                />
                <div>
                  <h3>PHP</h3>
                  <p>Basic</p>
                </div>
              </article>
              <article>
                <img
                  src="assets/img/checkmark.png"
                  alt="Icon competence"
                  class="icon"
                />
                <div>
                  <h3>GIT</h3>
                  <p>Basic</p>
                </div>
              </article>
            </div>
          </div>
        </div>
      </div>

      <div class="logos container">
        <div class="marquee">
          <div class="track">
            <img src="assets/img/html.png" alt="HTML" width="128" />
            <img src="assets/img/css.png" alt="CSS" width="128" />
            <img src="assets/img/javascript.png" alt="JS" width="128" />
            <img src="assets/img/sass.png" width="128" alt="Sass" />
            <img src="assets/img/vscode.png" width="128" alt="VS Code" />
            <img src="assets/img/php.png" width="128" alt="PHP" />
            <img src="assets/img/sqlwb.png" width="128" alt="SQL Workbench" />
            <img src="assets/img/mamp.png" width="128" alt="Mamp" />
            <img src="assets/img/html.png" alt="HTML" width="128" />
            <img src="assets/img/css.png" alt="CSS" width="128" />
            <img src="assets/img/javascript.png" alt="JS" width="128" />
            <img src="assets/img/sass.png" width="128" alt="Sass" />
            <img src="assets/img/vscode.png" width="128" alt="VS Code" />
            <img src="assets/img/php.png" width="128" alt="PHP" />
            <img src="assets/img/sqlwb.png" width="128" alt="SQL Workbench" />
            <img src="assets/img/mamp.png" width="128" alt="Mamp" />
          </div>
        </div>
      </div>

      <img
        src="assets/img/arrow.png"
        alt="Icon arrow"
        class="icon arrow"
        onclick="location.href='./#projects'"
      />
    </section>
    <section id="projects">
    <p class="section__text__p1">Découvrez mon travail</p>
    <h1 class="title">Projets</h1>
    <div class="competence-details-container">
      <div class="about-containers">
        <?php foreach ($projects as $project): ?>
          <div class="details-container color-container">
            <div class="article-container">
              <a href="project.php?id=<?php echo intval($project['id']); ?>">
                <img src="uploads/<?php echo htmlspecialchars($project['thumbnail']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" class="project-img">
              </a>
            </div>
            <h2 class="competence-sub-title project-title"><?php echo htmlspecialchars($project['title']); ?></h2>
            <div class="btn-container">
              <button class="btn btn-color-2 project-btn" onclick="location.href='project.php?id=<?php echo intval($project['id']); ?>'">
                Voir Projet
              </button>
              <?php if ($project['github_link']): ?>
                <button class="btn btn-color-2 project-btn" onclick="location.href='<?php echo htmlspecialchars($project['github_link']); ?>'" formtarget="_blank">
                  Github
                </button>
              <?php endif; ?>
              <?php if ($project['live_demo_link']): ?>
                <button class="btn btn-color-2 project-btn" onclick="location.href='<?php echo htmlspecialchars($project['live_demo_link']); ?>'" formtarget="_blank">
                  Live Demo
                </button>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      </div>
    <img src="assets/img/arrow.png" alt="Icon arrow" class="icon arrow" onclick="location.href='./#contact'">
    </section>

    <section id="contact">
      <p class="section__text__p1">Discutons ensemble</p>
      <h1 class="title">Contactez-Moi</h1>
      <div class="contact-info-upper-container">
          <div class="contact-info-container">
            <img
              src="assets/img/email.png"
              alt="Icon email"
              class="icon contact-icon email-icon"
            />
            <p>
              <a href="mailto:minh.trieu@apprenant.ifapme.be"
                >minh.trieu@apprenant.ifapme.be</a
              >
            </p>
          </div>
          <div class="contact-info-container">
            <img
              src="assets/img/linkedin.png"
              alt="Icon LinkedIn"
              class="icon contact-icon"
            />
            <p><a href="https://www.linkedin.com">LinkedIn</a></p>
          </div>
        </div>
  
  <!-- Formulaire de contact -->
        <div id="contact-form-container">
          <?php if (isset($successMessage)): ?>
            <p class="success-message"><?php echo $successMessage; ?></p>
          <?php endif; ?>
          <?php if (isset($errorMessage)): ?>
            <p class="error-message"><?php echo $errorMessage; ?></p>
          <?php endif; ?>
          <form action="index.php" method="POST" id="contact-form">
            <div>
              <label for="name">Nom :</label>
              <input type="text" id="name" name="name" required>
            </div>
            <div>
              <label for="email">Email :</label>
              <input type="email" id="email" name="email" required>
            </div>
            <div>
              <label for="message">Message :</label>
              <textarea id="message" name="message" required></textarea>
            </div>
            <button type="submit" id="submit-btn">Envoyer</button>
          </form>
        </div>
    </section>
    <footer>
      <nav>
        <div class="nav-links-container">
          <ul class="nav-links">
            <li><a href="#about">A Propos</a></li>
            <li><a href="#competence">Compétences</a></li>
            <li><a href="#projects">Projets</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div>
      </nav>
      <p>Portfolio &#169; 2024 trmnh.</p>
    </footer>
    <script src="assets/js/script.js"></script>
  </body>
</html>
