# API REST de Gestion des Employés - Documentation Technique

## Vue d'ensemble

API REST professionnelle pour la gestion des employés d'une entreprise, développée avec Laravel 12, incluant l'authentification JWT et le contrôle d'accès basé sur les rôles.

## Technologies Utilisées

- **Framework**: Laravel 12
- **Base de données**: MySQL / SQLite
- **Authentification**: JWT (tymon/jwt-auth)
- **PHP**: 8.2+
- **Architecture**: REST API

## Installation

### Prérequis

- PHP 8.2 ou supérieur
- Composer
- MySQL ou SQLite
- Serveur web (Apache/Nginx) ou PHP built-in server

### Étapes d'installation

1. **Cloner le projet**
```bash
git clone <repository-url>
cd RestApiBack
```

2. **Installer les dépendances**
```bash
composer install
```

3. **Configurer l'environnement**
```bash
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

4. **Configurer la base de données**
Modifier le fichier `.env` avec vos paramètres de base de données :
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=employee_management
DB_USERNAME=root
DB_PASSWORD=
```

5. **Exécuter les migrations et seeders**
```bash
php artisan migrate:fresh --seed
```

6. **Démarrer le serveur**
```bash
php artisan serve
```

L'API sera accessible sur `http://localhost:8000`

## Comptes par défaut

Après l'exécution des seeders, les comptes suivants sont disponibles :

| Rôle  | Email               | Mot de passe |
|-------|---------------------|--------------|
| ADMIN | admin@example.com   | password     |
| RH    | rh@example.com      | password     |
| USER  | user@example.com    | password     |

## Architecture

### Modèles

- **User**: Utilisateurs avec rôles (ADMIN, RH, USER)
- **Departement**: Départements de l'entreprise
- **Employe**: Employés associés à un département

### Contrôleurs

- **AuthController**: Gestion de l'authentification
- **DepartementController**: CRUD des départements
- **EmployeController**: CRUD des employés

### Middleware

- **auth:api**: Authentification JWT
- **role**: Contrôle d'accès basé sur les rôles

## Endpoints API

### Base URL
```
http://localhost:8000/api
```

### Authentication

#### Register
```http
POST /auth/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password",
    "password_confirmation": "password",
    "role": "USER"
}
```

**Réponse (201)**:
```json
{
    "success": true,
    "message": "Utilisateur créé avec succès",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "USER"
    },
    "token": "eyJ0eXAiOiJKV1QiLCJhbGc..."
}
```

#### Login
```http
POST /auth/login
Content-Type: application/json

{
    "email": "admin@example.com",
    "password": "password"
}
```

**Réponse (200)**:
```json
{
    "success": true,
    "message": "Connexion réussie",
    "user": {
        "id": 1,
        "name": "Admin User",
        "email": "admin@example.com",
        "role": "ADMIN"
    },
    "token": "eyJ0eXAiOiJKV1QiLCJhbGc..."
}
```

#### Get Current User
```http
GET /auth/me
Authorization: Bearer {token}
```

#### Logout
```http
POST /auth/logout
Authorization: Bearer {token}
```

#### Refresh Token
```http
POST /auth/refresh
Authorization: Bearer {token}
```

---

### Departments

#### List All Departments
```http
GET /departements
Authorization: Bearer {token}
```

**Réponse (200)**:
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "nom": "Informatique",
            "description": "Département responsable du développement...",
            "employes_count": 5,
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    ]
}
```

#### Get Department by ID
```http
GET /departements/{id}
Authorization: Bearer {token}
```

#### Create Department (RH/ADMIN only)
```http
POST /departements
Authorization: Bearer {token}
Content-Type: application/json

{
    "nom": "Production",
    "description": "Département de production et fabrication"
}
```

#### Update Department (RH/ADMIN only)
```http
PUT /departements/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "nom": "Production Générale",
    "description": "Description mise à jour"
}
```

#### Delete Department (ADMIN only)
```http
DELETE /departements/{id}
Authorization: Bearer {token}
```

---

### Employees

#### List All Employees
```http
GET /employes
Authorization: Bearer {token}
```

**Réponse (200)**:
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "nom": "Dupont",
            "prenom": "Jean",
            "email": "jean.dupont@example.com",
            "telephone": "+33 6 12 34 56 78",
            "poste": "Développeur Full Stack",
            "salaire": "45000.00",
            "date_embauche": "2024-01-15",
            "departement_id": 1,
            "departement": {
                "id": 1,
                "nom": "Informatique",
                "description": "..."
            }
        }
    ]
}
```

#### Get Employee by ID
```http
GET /employes/{id}
Authorization: Bearer {token}
```

#### Create Employee (RH/ADMIN only)
```http
POST /employes
Authorization: Bearer {token}
Content-Type: application/json

{
    "nom": "Dupont",
    "prenom": "Jean",
    "email": "jean.dupont@example.com",
    "telephone": "+33 6 12 34 56 78",
    "poste": "Développeur Full Stack",
    "salaire": 45000,
    "date_embauche": "2024-01-15",
    "departement_id": 1
}
```

#### Update Employee (RH/ADMIN only)
```http
PUT /employes/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "poste": "Senior Développeur Full Stack",
    "salaire": 55000
}
```

#### Delete Employee (RH/ADMIN only)
```http
DELETE /employes/{id}
Authorization: Bearer {token}
```

---

## Contrôle d'accès par rôle

| Endpoint                  | USER | RH  | ADMIN |
|---------------------------|------|-----|-------|
| GET /departements         | ✅   | ✅  | ✅    |
| POST /departements        | ❌   | ✅  | ✅    |
| PUT /departements/{id}    | ❌   | ✅  | ✅    |
| DELETE /departements/{id} | ❌   | ❌  | ✅    |
| GET /employes             | ✅   | ✅  | ✅    |
| POST /employes            | ❌   | ✅  | ✅    |
| PUT /employes/{id}        | ❌   | ✅  | ✅    |
| DELETE /employes/{id}     | ❌   | ✅  | ✅    |

## Sécurité

### JWT Authentication
- Tous les endpoints (sauf register et login) nécessitent un token JWT valide
- Token à inclure dans le header: `Authorization: Bearer {token}`
- Durée de validité du token: 60 minutes (configurable dans `config/jwt.php`)

### Rate Limiting
- 60 requêtes par minute par IP
- Configurable dans `bootstrap/app.php`

### Validation des données
- Toutes les entrées sont validées
- Messages d'erreur en français
- Codes HTTP appropriés (422 pour validation, 401 pour auth, 403 pour autorisation)

## Codes de réponse HTTP

| Code | Signification                  |
|------|--------------------------------|
| 200  | Succès                         |
| 201  | Ressource créée                |
| 401  | Non authentifié                |
| 403  | Accès interdit (rôle)          |
| 404  | Ressource non trouvée          |
| 422  | Erreur de validation           |
| 429  | Trop de requêtes (rate limit)  |

## Tests avec Postman

1. Importer la collection `Employee_Management_API.postman_collection.json`
2. Utiliser "Login - Admin" pour obtenir un token
3. Le token sera automatiquement sauvegardé dans la variable `jwt_token`
4. Tester les différents endpoints selon les rôles

## Structure du projet

```
RestApiBack/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── DepartementController.php
│   │   │   └── EmployeController.php
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Departement.php
│       └── Employe.php
├── database/
│   ├── migrations/
│   │   ├── 2025_01_01_000000_add_role_to_users_table.php
│   │   ├── 2025_01_01_000001_create_departements_table.php
│   │   └── 2025_01_01_000002_create_employes_table.php
│   └── seeders/
│       ├── UserSeeder.php
│       ├── DepartementSeeder.php
│       └── DatabaseSeeder.php
├── routes/
│   └── api.php
└── config/
    ├── auth.php
    └── jwt.php
```

## Dépannage

### Erreur "Token not provided"
- Vérifier que le header Authorization est bien présent
- Format: `Authorization: Bearer {token}`

### Erreur "Accès non autorisé"
- Vérifier le rôle de l'utilisateur connecté
- Certaines actions nécessitent le rôle RH ou ADMIN

### Erreur de base de données
- Vérifier la configuration dans `.env`
- S'assurer que les migrations ont été exécutées

## Support

Pour toute question ou problème, veuillez consulter la documentation Laravel ou créer une issue dans le repository.
