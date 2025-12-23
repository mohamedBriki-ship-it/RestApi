# API REST de Gestion des Employés

[![Laravel](https://img.shields.io/badge/Laravel-12-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![JWT](https://img.shields.io/badge/JWT-Auth-green.svg)](https://jwt-auth.readthedocs.io)

API REST professionnelle pour la gestion des employés d'une entreprise avec authentification JWT et contrôle d'accès basé sur les rôles.

## 🚀 Fonctionnalités

- ✅ **Authentification JWT** - Inscription, connexion, déconnexion
- ✅ **Gestion des utilisateurs** - Rôles: ADMIN, RH, USER
- ✅ **Gestion des départements** - CRUD complet
- ✅ **Gestion des employés** - CRUD avec relations
- ✅ **Contrôle d'accès** - Basé sur les rôles utilisateurs
- ✅ **Rate Limiting** - Protection contre les abus (60 req/min)
- ✅ **Validation** - Validation complète des données
- ✅ **Documentation** - Collection Postman incluse

## 📋 Prérequis

- PHP 8.2 ou supérieur
- Composer
- MySQL ou SQLite
- Serveur web (Apache/Nginx) ou PHP built-in server

## 🔧 Installation

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

Modifier le fichier `.env`:
```env
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

## 👥 Comptes par défaut

| Rôle  | Email               | Mot de passe |
|-------|---------------------|--------------|
| ADMIN | admin@example.com   | password     |
| RH    | rh@example.com      | password     |
| USER  | user@example.com    | password     |

## 📚 Documentation

### Endpoints principaux

**Base URL**: `http://localhost:8000/api`

#### Authentication
- `POST /auth/register` - Inscription
- `POST /auth/login` - Connexion
- `POST /auth/logout` - Déconnexion
- `GET /auth/me` - Utilisateur actuel
- `POST /auth/refresh` - Rafraîchir le token

#### Départements
- `GET /departements` - Liste des départements
- `GET /departements/{id}` - Détails d'un département
- `POST /departements` - Créer (RH/ADMIN)
- `PUT /departements/{id}` - Modifier (RH/ADMIN)
- `DELETE /departements/{id}` - Supprimer (ADMIN)

#### Employés
- `GET /employes` - Liste des employés
- `GET /employes/{id}` - Détails d'un employé
- `POST /employes` - Créer (RH/ADMIN)
- `PUT /employes/{id}` - Modifier (RH/ADMIN)
- `DELETE /employes/{id}` - Supprimer (RH/ADMIN)

### Exemple d'utilisation

**1. Connexion**
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@example.com",
    "password": "password"
  }'
```

**2. Créer un employé (avec token)**
```bash
curl -X POST http://localhost:8000/api/employes \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{
    "nom": "Dupont",
    "prenom": "Jean",
    "email": "jean.dupont@example.com",
    "telephone": "+33 6 12 34 56 78",
    "poste": "Développeur Full Stack",
    "salaire": 45000,
    "date_embauche": "2024-01-15",
    "departement_id": 1
  }'
```

## 🧪 Tests avec Postman

1. Importer la collection: `Employee_Management_API.postman_collection.json`
2. Utiliser "Login - Admin" pour obtenir un token
3. Le token sera automatiquement sauvegardé
4. Tester les différents endpoints

## 🔒 Sécurité

- **JWT Authentication**: Tous les endpoints protégés nécessitent un token valide
- **Role-Based Access Control**: Contrôle d'accès granulaire par rôle
- **Rate Limiting**: 60 requêtes par minute
- **Validation**: Validation complète de toutes les entrées
- **Password Hashing**: Mots de passe hashés avec bcrypt

## 📁 Structure du projet

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
│   └── seeders/
├── routes/
│   └── api.php
└── config/
    ├── auth.php
    └── jwt.php
```

## 🛠️ Technologies utilisées

- **Laravel 12** - Framework PHP
- **JWT Auth** - Authentification par token
- **MySQL** - Base de données
- **Eloquent ORM** - Gestion des modèles

## 📖 Documentation complète

Pour plus de détails, consultez:
- [DOCUMENTATION_API.md](DOCUMENTATION_API.md) - Documentation technique complète
- [Employee_Management_API.postman_collection.json](Employee_Management_API.postman_collection.json) - Collection Postman

## 🤝 Contribution

Les contributions sont les bienvenues! N'hésitez pas à ouvrir une issue ou une pull request.

## 📝 Licence

Ce projet est sous licence MIT.

## 👨‍💻 Auteur

Développé dans le cadre d'un travail pratique en développement backend.
