<?php
$result = "";
if (isset($_POST['action'])) {
    include "update.php";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Crypto-Moise</title>
<link rel="stylesheet" href="style.css">

<!-- Icônes -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
    body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Dark mode */
body.dark {
    background: #121212;
}

/* Container */
.container {
    background: white;
    padding: 25px;
    width: 420px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    transition: 0.3s;
}

body.dark .container {
    background: #1e1e1e;
    color: white;
}

/* Header */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.dark-btn {
    background: none;
    border: none;
    font-size: 18px;
    cursor: pointer;
}

/* Inputs */
textarea, input, select {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 10px;
    border: 1px solid #ccc;
}

body.dark textarea,
body.dark input,
body.dark select {
    background: #2a2a2a;
    color: white;
    border: none;
}

/* Buttons */
.buttons {
    display: flex;
    gap: 10px;
}

.btn {
    flex: 1;
    padding: 10px;
    border: none;
    border-radius: 10px;
    color: white;
    cursor: pointer;
    transition: 0.2s;
}

.encrypt { background: #28a745; }
.decrypt { background: #dc3545; }

.btn:active {
    transform: scale(0.95);
}

/* Result */
.result {
    margin-top: 15px;
    padding: 15px;
    background: #f1f1f1;
    border-radius: 10px;
}

body.dark .result {
    background: #2a2a2a;
}

.result-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Copy button */
.copy-btn {
    border: none;
    background: #007bff;
    color: white;
    padding: 5px 10px;
    border-radius: 8px;
    cursor: pointer;
}

.copy-btn:active {
    transform: scale(0.9);
}
</style>
</head>

<body>

<div class="container">


    <div class="header">
        <h2><i class="fa-solid fa-lock"></i> Moi c'est BOLONGE EPAMPUKA MOISE alors je vous propse le chiffrement et le déchiffrement de vos phrases avec les differnts algorithmes</h2>
        <button onclick="toggleDarkMode()" class="dark-btn">
            <i class="fa-solid fa-moon"></i>
        </button>
    </div>

    <form method="POST">
        <textarea name="message" placeholder="Entrez votre message..." required></textarea>

        <input type="text" name="key" placeholder="Entrez une clé en tenant compte de l'algo">

        <select name="algo">
            <option value="choix">Veuillez choisir un algorithme</option>
            <option value="cesar">🔤 César</option>
            <option value="vigenere">🔐 Vigenère</option>
            <option value="autokey">🧠 Autokey</option>
            <option value="playfair">🧩 Playfair</option>
        </select>

        <div class="buttons">
            <button name="action" value="encrypt" class="btn encrypt">
                <i class="fa-solid fa-lock"></i> Chiffrer
            </button>

            <button name="action" value="decrypt" class="btn decrypt">
                <i class="fa-solid fa-unlock"></i> Déchiffrer
            </button>
        </div>
    </form>

    <?php if (!empty($result)) : ?>
        <div class="result">
            <div class="result-header">
                <strong>Résultat</strong>
                <button onclick="copyResult()" class="copy-btn">
                    <i class="fa-solid fa-copy"></i>
                </button>
            </div>

            <p id="resultText"><?= htmlspecialchars($result) ?></p>
        </div>
    <?php endif; ?>

</div>

<script src="script.js"></script>
</body>
</html>