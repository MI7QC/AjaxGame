<?php
// Inclusion du fichier de configuration qui établit la connexion à la base de données.
require_once('config.php');

// Vérification si l'action 'attaque' a été envoyée via une requête POST.
if (isset($_POST['MenuAttaque']) && $_POST['MenuAttaque'] == 'attaque') {
    // Récupération et conversion en entier de l'ID de l'ennemi envoyé par POST.
    $ennemiId = intval($_POST['ennemiId']);
    // Génération aléatoire des dégâts infligés par le personnage.
    $damagePerso = rand(1, 5);
    // Calcul de la nouvelle constitution de l'ennemi après l'attaque.
    $newConstitutionEnnemi = intval($_POST['ennemiConstitution']) - $damagePerso;

    // Mise à jour de la constitution de l'ennemi dans la base de données en utilisant une requête préparée.
    $updateEnnemi = QSQL("UPDATE `charactera` SET `constitution` = :constitution WHERE `id` = :id", [
        ':constitution' => $newConstitutionEnnemi,
        ':id' => $ennemiId
    ]);

    // Récupération et conversion en entier de l'ID du personnage envoyé par POST.
    $persoId = intval($_POST['persoId']);
    // Génération aléatoire des dégâts infligés par l'ennemi.
    $damageEnnemi = rand(1, 5);
    // Calcul de la nouvelle constitution du personnage après avoir subi l'attaque.
    $newConstitutionPerso = intval($_POST['persoConstitution']) - $damageEnnemi;

    // Mise à jour de la constitution du personnage dans la base de données en utilisant une requête préparée.
    $updatePerso = QSQL("UPDATE `charactera` SET `constitution` = :constitution WHERE `id` = :id", [
        ':constitution' => $newConstitutionPerso,
        ':id' => $persoId
    ]);

    // Vérification si les deux mises à jour ont réussi.
    if ($updateEnnemi && $updatePerso) {
        // Si les mises à jour ont réussi, envoi des nouvelles valeurs au client au format JSON.
        echo json_encode([
            'newConstitutionEnnemi' => $newConstitutionEnnemi,
            'newConstitutionPerso' => $newConstitutionPerso,
            'damageToEnnemi' => $damagePerso,
            'damageToPlayer' => $damageEnnemi
        ]);
    } else {
        // Si une mise à jour a échoué, envoi d'un message d'erreur au client au format JSON.
        echo json_encode(['error' => 'Une erreur est survenue lors de la mise à jour.']);
    }
    // Fin du script pour éviter toute sortie supplémentaire.
    exit;
}






// Vérification si l'action 'defence' a été envoyée via une requête POST.
if (isset($_POST['MenuAttaque']) && $_POST['MenuAttaque'] == 'defence') {

    // Récupération et conversion en entier de l'ID du personnage envoyé par POST.
    $persoId = intval($_POST['persoId']);
    // Génération aléatoire des dégâts infligés par l'ennemi.
    $damageEnnemiToPerso = rand(1, 5);
    // defence du personage.
    $defencePerso = rand(2, 5);
    if ($damageEnnemiToPerso > $defencePerso) {
        $damage = $damageEnnemiToPerso - $defencePerso;
        $damageEnnemiToPerso = 'inflige ' . $damage . ' points de dégâts';
    } else {
        $damage = 0;
        $damageEnnemiToPerso = 'Manque son attaque';
    }
    // Calcul de la nouvelle constitution du personnage après avoir subi l'attaque.
    $newConstitutionPerso = intval($_POST['persoConstitution']) - $damage;

    // Mise à jour de la constitution du personnage dans la base de données en utilisant une requête préparée.
    $updatePerso = QSQL("UPDATE `charactera` SET `constitution` = :constitution WHERE `id` = :id", [
        ':constitution' => $newConstitutionPerso,
        ':id' => $persoId
    ]);

    // Vérification si les deux mises à jour ont réussi.
    if ($updatePerso) {
        // Si les mises à jour ont réussi, envoi des nouvelles valeurs au client au format JSON.
        echo json_encode([
            'newConstitutionPerso' => $newConstitutionPerso,
            'defencePerso' => $defencePerso,
            'damageToPlayer' => $damageEnnemiToPerso
        ]);
    } else {
        // Si une mise à jour a échoué, envoi d'un message d'erreur au client au format JSON.
        echo json_encode(['error' => 'Une erreur est survenue lors de la mise à jour.']);
    }
    // Fin du script pour éviter toute sortie supplémentaire.
    exit;
}





// Vérification si l'action 'potion' a été envoyée via une requête POST.
if (isset($_POST['MenuAttaque']) && $_POST['MenuAttaque'] == 'potion') {

}
