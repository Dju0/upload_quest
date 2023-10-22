<?php
$errors = [];

// Gestion de l'envoi de la photo
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérifie s'il y a des erreurs
    if ($_FILES['avatar']['error'] === 0) {
        // Vérifie le type de fichier
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $fileExtension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        if (in_array($fileExtension, $allowedExtensions)) {
            // Vérifie la taille du fichier (1 Mo maximum)
            $maxFileSize = 1000000; // 1 Mo en octets
            if ($_FILES['avatar']['size'] <= $maxFileSize) {
                // Génère un nom de fichier unique
                $uniqueFileName = uniqid() . '.' . $fileExtension;
                // Déplace le fichier téléchargé vers le dossier d'uploads
                $uploadDir = 'public/uploads/';
                $uploadFile = $uploadDir . $uniqueFileName;
                move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
                echo "Téléchargement réussi. Voici la photo de profil de Homer :<br>";
                // Affiche la photo de profil
                echo "<img src='$uploadFile' alt='Photo de profil de Homer'><br>";

                // Affiche les informations de Homer
                $firstName = $_POST['first_name'] ?? 'Homer'; // Si le champ est vide, utilise 'Homer' par défaut
                $lastName = $_POST['last_name'] ?? 'Simpson';
                $age = $_POST['age'] ?? '38';

                echo "Nom: $firstName<br>";
                echo "Prénom: $lastName<br>";
                echo "Âge: $age ans<br>";
            } else {
                $errors[] = 'La taille du fichier dépasse 1 Mo.';
            }
        } else {
            $errors[] = 'Seules les extensions jpg, jpeg, png, gif et webp sont autorisées.';
        }
    } else {
        $errors[] = 'Erreur lors du téléchargement du fichier.';
    }

    // Affiche les erreurs s'il y en a
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Uploader la photo de profil</title>
</head>
<body>
    <h1>Uploader la photo de profil de Homer</h1>
    <form method="post" enctype="multipart/form-data">
        <label for="imageUpload">Choisir une photo de profil (jpg, png, gif, webp)</label>
        <input type="file" name="avatar" id="imageUpload" accept=".jpg, .png, .gif, .webp" />

        <label for="first_name">Prénom</label>
        <input type="text" name="first_name" id="first_name" />

        <label for="last_name">Nom</label>
        <input type="text" name="last_name" id="last_name" />

        <label for="age">Âge</label>
        <input type="number" name="age" id="age" />

        <button name="send">Envoyer</button>
    </form>
</body>
</html>
