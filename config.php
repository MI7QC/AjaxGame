<?php
// Définition des constantes pour les informations de connexion à la base de données.
define('DB_SERVER', 'localhost'); // Adresse du serveur de base de données.
define('DB_USERNAME', 'root'); // Nom d'utilisateur pour se connecter à la base de données.
define('DB_PASSWORD', ''); // Mot de passe pour se connecter à la base de données.
define('DB_NAME', 'fichepersoa'); // Nom de la base de données à utiliser.


// Classe Database utilisant le modèle Singleton pour gérer la connexion à la base de données.
class Database
{
    // Propriété statique privée qui contiendra l'instance unique de la connexion PDO.
    private static $instance = null;
    // Constructeur privé pour empêcher la création directe d'instances de cette classe.
    private function __construct()
    {
        try {
            // Tentative de connexion à la base de données avec les informations fournies.
            self::$instance = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
            // Configuration des attributs PDO pour lancer des exceptions en cas d'erreur et désactiver les requêtes préparées émulées.
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            // Enregistrement de l'erreur de connexion dans les logs du serveur.
            error_log("Erreur de connexion à la base de données : " . $e->getMessage());
            // Réinitialisation de l'instance à null en cas d'échec de la connexion.
            self::$instance = null;
        }
    }
    // Méthode __clone privée pour empêcher le clonage de l'instance.
    private function __clone()
    {
        // Le corps de la méthode est vide car le clonage n'est pas autorisé.
    }
    // Méthode publique statique pour obtenir l'instance unique de la connexion PDO.
    public static function getInstance()
    {
        if (!self::$instance) {
            // Si l'instance n'existe pas encore, création d'une nouvelle instance de la classe Database.
            new self();
        }
        // Renvoi de l'instance unique de la connexion PDO.
        return self::$instance;
    }
}


// Fonction QSQL pour exécuter des requêtes SQL avec des paramètres.
function QSQL($sql, $params = [])
{
    // Obtention de l'instance unique de la connexion PDO.
    $pdo = Database::getInstance();
    // Si l'instance PDO est null (connexion échouée), renvoi de false.
    if ($pdo === null) {
        return false;
    }
    try {
        // Préparation de la requête SQL avec les paramètres fournis.
        // La méthode prepare() prépare une requête SQL pour son exécution.
        $statement = $pdo->prepare($sql);
        // Exécution de la requête préparée avec les paramètres passés à la fonction.
        // La méthode execute() exécute la requête préparée.
        $success = $statement->execute($params);
        // Vérification si la requête SQL est une requête SELECT.
        // La fonction strpos() cherche la position de la première occurrence d'une chaîne dans une autre chaîne.
        if (strpos($sql, 'SELECT') === 0) {
            // Si c'est une requête SELECT, récupération de tous les résultats.
            // La méthode fetchAll() récupère toutes les lignes d'un jeu de résultats.
            // PDO::FETCH_ASSOC renvoie les résultats sous forme de tableau associatif.
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // Si ce n'est pas une requête SELECT (par exemple, INSERT, UPDATE, DELETE),
            // renvoi du succès de l'exécution de la requête.
            return $success;
        }
    } catch (PDOException $e) {
        // Enregistrement de l'erreur de base de données dans les logs du serveur.
        // La méthode getMessage() de l'objet exception renvoie le message d'erreur.
        error_log("Erreur de base de données : " . $e->getMessage());
        // Renvoi de false en cas d'erreur lors de l'exécution de la requête.
        return false;
    }
}
