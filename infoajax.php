<?php
/*
1: $('#attaque').click(function() {: Cette ligne attache un gestionnaire d'événements de clic à 
l'élément avec l'ID attaque. Cela signifie que la fonction définie entre les accolades sera exécutée lorsque cet élément est cliqué.

2: var ennemiId = $('#idPerso2').text().split(': ')[1];: Cette ligne extrait l'ID de l'ennemi en lisant le texte de 
l'élément avec l'ID idPerso2 (qui semble contenir quelque chose comme "id: 3") et en utilisant .split(': ') pour diviser la chaîne en un tableau. 
La deuxième partie du tableau (indice 1) contient l'ID de l'ennemi.

3: var persoId = $('#idPerso1').text().split(': ')[1];: De même, cette ligne extrait l'ID du personnage à partir de l'élément avec l'ID idPerso1.

4: var ennemiConstitution = $('#constitutionPerso2').text().split(': ')[1];: Cette ligne extrait la constitution de l'ennemi à partir de l'élément avec l'ID constitutionPerso2.

5: var persoConstitution = $('#constitutionPerso1').text().split(': ')[1];: De même, cette ligne extrait la constitution du personnage à partir de l'élément avec l'ID constitutionPerso1.

$.ajax({: Démarre une requête Ajax avec les paramètres spécifiés.

6: type: 'POST',: Spécifie la méthode de la requête (POST dans ce cas).

7: url: 'ajax.php',: Spécifie l'URL du fichier PHP qui traitera la requête.

8: data: { MenuAttaque: 'attaque', ennemiId: ennemiId, persoId: persoId, ennemiConstitution: ennemiConstitution, persoConstitution: persoConstitution },: Les données à envoyer avec la requête. 
Ce sont les paramètres que votre script PHP utilisera.

9: dataType: 'json',: Spécifie le type de données attendu en retour. Dans ce cas, vous attendez du JSON.

10: success: function(response) {: La fonction à exécuter si la requête réussit.

11: console.log('Attaque réussie. Nouvelle constitution ennemi : ' + response.newConstitutionEnnemi);: Affiche dans la console le message indiquant que l'attaque a réussi et affiche la nouvelle constitution de l'ennemi.

12: console.log('Attaque réussie. Nouvelle constitution perso : ' + response.newConstitutionPerso);: Affiche dans la console la nouvelle constitution du person


*/


