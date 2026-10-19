# Immobilier-Reco : recommandation d'annonces immobilières avec Neo4j

Application web de recommandation d'annonces immobilières. Elle combine **Laravel** (application, authentification, interface) et **Neo4j** (base de données orientée graphe) pour stocker les annonces, les favoris des utilisateurs et générer des recommandations.

Projet réalisé dans le cadre du module **NoSQL**.

## Fonctionnalités

- Inscription, connexion et gestion du profil (Laravel Breeze)
- Consultation des annonces et page détail
- Ajout et suppression de favoris (relation `FAVORITED` dans Neo4j)
- Historique de consultation
- Recommandations personnalisées calculées par des requêtes Cypher
- Tableau de bord utilisateur

## Technologies

| Technologie | Rôle |
|---|---|
| Laravel 11/12 (PHP) | Backend et vues Blade |
| Neo4j + `laudis/neo4j-php-client` | Base de données graphe (annonces, favoris) |
| SQLite | Comptes utilisateurs Laravel |
| Tailwind CSS + Vite | Interface |
| Pest | Tests |

## Modèle de graphe

- Nœuds : `(:users)`, `(:listing)`
- Relation : `(:users)-[:FAVORITED]->(:listing)`

## Prérequis

- PHP 8.2+ et [Composer](https://getcomposer.org)
- [Node.js](https://nodejs.org) et npm
- [Neo4j](https://neo4j.com/download/) (Desktop, Server ou AuraDB) avec les données des annonces importées

## Installation

```bash
git clone https://github.com/sara-nm22/immobilier-reco.git
cd immobilier-reco

composer install
npm install

copy .env.example .env      # Windows (Mac/Linux : cp .env.example .env)
php artisan key:generate
```

Créez le fichier SQLite puis lancez les migrations :

```bash
type nul > database\database.sqlite      # Windows (Mac/Linux : touch database/database.sqlite)
php artisan migrate
```

## Configuration de Neo4j

Dans le fichier `.env`, renseignez vos accès :

```
NEO4J_URI=bolt://127.0.0.1:7687
NEO4J_USER=neo4j
NEO4J_PASSWORD=votre_mot_de_passe
```

Pour AuraDB, utilisez l'URI fournie (par exemple `neo4j+s://xxxx.databases.neo4j.io`).
Ne publiez jamais le fichier `.env`.

> Le jeu de données Neo4j (nœuds `listing`) n'est pas inclus dans ce dépôt : importez vos annonces dans votre base avant de lancer l'application.

## Lancement

Dans deux terminaux :

```bash
php artisan serve     # http://127.0.0.1:8000
npm run dev           # compilation des assets
```

## Tests

```bash
php artisan test
```

## Structure

```
app/Http/Controllers/   # Listing, Favorite, History, Recommendation, Dashboard...
app/Services/Neo4jService.php   # Connexion et requêtes Cypher
resources/views/        # Vues Blade
routes/web.php          # Routes de l'application
database/migrations/    # Migrations SQLite
```

## Auteur

Sara Naim
