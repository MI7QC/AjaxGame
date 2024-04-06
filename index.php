<?php
require_once('config.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AjaxGame</title>
    <link href="assets/style.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <?php
    $Perso = QSQL("SELECT * FROM `charactera`");
    ?>

    <div class="container">
        <div style='    display: flex;flex-direction: row-reverse;'>

            <!-- Ennemi -->
            <div class="enemy-container">
                <h1><?= $Perso[2]['name'] ?></h1>
                <img src="<?= $Perso[2]['avatar'] ?>" alt="<?= $Perso[2]['name'] ?>">
                <div class="stats-container">
                    <div id='idPerso2' class="stats">ID: <?= $Perso[2]['id'] ?></div>
                    <div class="stats">XP: <?= $Perso[2]['xp'] ?></div>
                    <div class="stats">LVL: <?= $Perso[2]['lvl'] ?></div>
                    <div class="stats">Strength: <?= $Perso[2]['strength'] ?></div>
                    <div id='constitutionPerso2' class="constitution">Constitution: <?= $Perso[2]['constitution'] ?></div>
                    <div class="stats">Wisdom: <?= $Perso[2]['wisdom'] ?></div>
                </div>
            </div>

            <!-- Combat Menu -->
            <div class="combat-menu">
                <div class="menu-group">
                    <div class="menu-item" id="attaque">Attaque</div>
                    <div class="menu-item" id="defence">Defence</div>
                </div>
                <div class="menu-group">
                    <div class="menu-item" id="magie">Magie</div>
                    <div class="menu-item" id="potion">Potion</div>
                </div>
            </div>

            <!-- Personnage -->
            <div class="character-container">
                <h1><?= $Perso[1]['name'] ?></h1>
                <img src="<?= $Perso[1]['avatar'] ?>" alt="<?= $Perso[1]['name'] ?>">
                <div class="stats-container">
                    <div id='idPerso1' class="stats">ID: <?= $Perso[1]['id'] ?></div>
                    <div class="stats">XP: <?= $Perso[1]['xp'] ?></div>
                    <div class="stats">LVL: <?= $Perso[1]['lvl'] ?></div>
                    <div class="stats">Strength: <?= $Perso[1]['strength'] ?></div>
                    <div id='constitutionPerso1' class="constitution">Constitution: <?= $Perso[1]['constitution'] ?></div>
                    <div class="stats">Wisdom: <?= $Perso[1]['wisdom'] ?></div>
                </div>
            </div>
        </div>

        <!-- Log des attaques -->
        <div class="log-container">
            <!-- Ajoutez d'autres éléments de journal en fonction des attaques -->
        </div>
    </div>

    <script>
        // jQuery pour écouter les clics sur les boutons
        $('#attaque').click(function() {
            // Récupérer l'id et la constitution de l'ennemi et du personnage
            var ennemiId = $('#idPerso2').text().split(': ')[1];
            var persoId = $('#idPerso1').text().split(': ')[1];
            var ennemiConstitution = $('#constitutionPerso2').text().split(': ')[1];
            var persoConstitution = $('#constitutionPerso1').text().split(': ')[1];

            // Mettre à jour la base de données avec les nouvelles valeurs pour l'ennemi
            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: {
                    MenuAttaque: 'attaque',
                    ennemiId: ennemiId,
                    persoId: persoId,
                    ennemiConstitution: ennemiConstitution,
                    persoConstitution: persoConstitution
                },
                dataType: 'json',
                success: function(response) {
                    // Réussite de la requête Ajax, afficher les nouvelles constitutions dans la console
                    console.log('Attaque réussie. Nouvelle constitution ennemi : ' + response.newConstitutionEnnemi);
                    console.log('Attaque réussie. Nouvelle constitution perso : ' + response.newConstitutionPerso);
                    // Mettre à jour l'affichage avec les nouvelles constitutions
                    $('#constitutionPerso2').text('Constitution: ' + response.newConstitutionEnnemi);
                    $('#constitutionPerso1').text('Constitution: ' + response.newConstitutionPerso);

                    // Créer deux nouveaux éléments avec la classe log-item
                    var logItemPlayer = $('<div>').addClass('log-item').text('Vous infligez ' + response.damageToEnnemi + ' points de dégâts.');
                    var logItemEnnemi = $('<div>').addClass('log-item').text('L\'ennemi inflige ' + response.damageToPlayer + ' points de dégâts.');

                    // Ajouter les deux éléments au conteneur du journal
                    var logContainer = $('.log-container');
                    logContainer.html(logItemPlayer).append(logItemEnnemi);
                },
                error: function(xhr, status, error) {
                    // Gestion des erreurs, afficher l'erreur dans la console
                    console.error('Erreur lors de l\'attaque : ' + xhr.responseText);
                }
            });
        });

        $('#defence').click(function() {
            // Récupérer l'id et la constitution de l'ennemi et du personnage
            var ennemiId = $('#idPerso2').text().split(': ')[1];
            var persoId = $('#idPerso1').text().split(': ')[1];
            var ennemiConstitution = $('#constitutionPerso2').text().split(': ')[1];
            var persoConstitution = $('#constitutionPerso1').text().split(': ')[1];

            // Mettre à jour la base de données avec les nouvelles valeurs pour l'ennemi
            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: {
                    MenuAttaque: 'defence',
                    ennemiId: ennemiId,
                    persoId: persoId,
                    persoConstitution: persoConstitution
                },
                dataType: 'json',
                success: function(response) {
                    // Mettre à jour l'affichage avec les nouvelles constitutions
                    $('#constitutionPerso1').text('Constitution: ' + response.newConstitutionPerso);

                    // Créer deux nouveaux éléments avec la classe log-item
                    var logItemPlayer = $('<div>').addClass('log-item').text('Vous recevez une Protection de ' + response.defencePerso);
                    var logItemEnnemi = $('<div>').addClass('log-item').text('L\'ennemi  ' + response.damageToPlayer);

                    // Ajouter les deux éléments au conteneur du journal
                    var logContainer = $('.log-container');
                    logContainer.html(logItemPlayer).append(logItemEnnemi);
                },
                error: function(xhr, status, error) {
                    // Gestion des erreurs, afficher l'erreur dans la console
                    console.error('Erreur lors de l\'attaque : ' + xhr.responseText);
                }
            })
        });

        $('#magie').click(function() {
            console.log('Bouton Magie cliqué');
            
        });

        $('#potion').click(function() {
            console.log('Bouton Potion cliqué');
            // Récupérer l'id et la constitution de l'ennemi et du personnage
            var ennemiId = $('#idPerso2').text().split(': ')[1];
            var persoId = $('#idPerso1').text().split(': ')[1];
            var ennemiConstitution = $('#constitutionPerso2').text().split(': ')[1];
            var persoConstitution = $('#constitutionPerso1').text().split(': ')[1];

            // Mettre à jour la base de données avec les nouvelles valeurs pour l'ennemi
            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: {
                    MenuAttaque: 'potion',
                    ennemiId: ennemiId,
                    persoId: persoId,
                    persoConstitution: persoConstitution
                },
                dataType: 'json',
                success: function(response) {
                    // Mettre à jour l'affichage avec les nouvelles constitutions
                    $('#constitutionPerso1').text('Constitution: ' + response.potion);
                    $('#constitutionPerso2').text('Constitution: ' + response.newConstitutionPerso);

                    // Créer deux nouveaux éléments avec la classe log-item
                    var logItemPlayer = $('<div>').addClass('log-item').text('Vous gagnez ' + response.potion + 'points de vie');
                    var logItemEnnemi = $('<div>').addClass('log-item').text('L\'ennemi  ' + response.damageToPlayer);

                    // Ajouter les deux éléments au conteneur du journal
                    var logContainer = $('.log-container');
                    logContainer.html(logItemPlayer).append(logItemEnnemi);
                },
                error: function(xhr, status, error) {
                    // Gestion des erreurs, afficher l'erreur dans la console
                    console.error('Erreur lors de l\'attaque : ' + xhr.responseText);
                }
            })
        });
    </script>
</body>

</html>