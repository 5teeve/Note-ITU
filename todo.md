# TP CodeIgniter 4 (4h) — Todo List Détaillée

## 1. Setup du projet (30 minutes maximum)

- Installer et configurer :contentReference[oaicite:0]{index=0}
- Lancer le serveur de développement (`spark serve`)
- Configurer le fichier `.env` :
  - `baseURL`
  - paramètres de connexion :contentReference[oaicite:1]{index=1}
- [x] Créer la base de données

---

## 2. [x] Conception de la base de données (étape critique)

### Tables à créer :
- [x] `parcours`
  - id
  - nom

- [x] `semestre`
  - id
  - numero

- [x] `ue`
  - id
  - code
  - libelle
  - credits

- [x] `groupe_ue`
  - id
  - libelle
  - nb_choix

- [x] `groupe_ue_element`
  - id
  - groupe_ue_id
  - ue_id

- [x] `programme`
  - id
  - parcours_id
  - semestre_id
  - ue_id
  - groupe_ue_id

### Relations :
- [x] Un groupe d'UE (groupe_ue) contient plusieurs éléments (groupe_ue_element) liant à des UEs
- [x] Le programme appartient à un parcours et un semestre
- [x] Le programme peut correspondre à une UE spécifique OU à un groupe d'UE (exclusivement)

### Vérifications :
- [x] Clés primaires définies
- [x] Clés étrangères cohérentes
- [x] Cohérence des types de données
- [x] Contrainte CHECK (ue_id XOR groupe_ue_id) définie sur la table programme

---

## 3. Authentification (login simple)

- Créer un contrôleur `Auth`
- Créer une vue `login`
- Pré-remplir le formulaire avec des valeurs par défaut
- Implémenter :
  - vérification des identifiants
  - gestion de session
  - redirection après connexion
- Protéger les routes nécessitant une authentification

---

## 4. Gestion des étudiants

- Créer un modèle `EtudiantModel`
- Créer un contrôleur `EtudiantController`
- Implémenter :
  - affichage de la liste des étudiants
- Ajouter interaction :
  - clic sur un étudiant → redirection vers ses notes

---

## 5. Ajout des notes

- Créer un formulaire avec :
  - sélection de l’étudiant
  - sélection de la matière
  - sélection du semestre (S3 / S4)
  - saisie de la note

- Permettre l’ajout multiple :
  - rester sur le formulaire après soumission

- Ajouter validation :
  - note comprise entre 0 et 20

- Enregistrer les données en base

---

## 6. Affichage des notes par étudiant

- Créer une page de détail étudiant
- Afficher :
  - liste des notes associées
  - on peut modifier
  - supprimer
  - utilise left join, les sans notes sont 0
  - une gestion strict des notes (pour une matière, on prend la note maximale
pour les matières optionnels, on prend la matière qui a la meilleure note)
- Ajouter filtrage :
  - par semestre (S3 / S4)
- Trier les données si nécessaire

---

## 7. Implémentation des règles de gestion

### Règle 1 : note maximale par matière
- Si plusieurs notes existent pour une même matière
- Ne conserver que la note la plus élevée

### Règle 2 : matières optionnelles
- Identifier les matières optionnelles
- Ne conserver que celle avec la meilleure note

### Règle 3 : séparation des semestres
- Afficher distinctement S3 et S4

### Règle 4 : niveau L2
- Fusionner les notes de S3 et S4
- Appliquer les règles précédentes
- Calculer la moyenne globale

---

## 8. Calcul des moyennes

- Calculer :
  - moyenne par semestre
  - moyenne globale (S3 + S4)
- Gérer :
  - division correcte
  - arrondi des résultats

---

## 9. Intégration du design (à faire en dernier)

- Intégrer le fichier SCSS fourni
- Compiler SCSS en CSS
- Appliquer le design sur :
  - page login
  - liste des étudiants
  - formulaire de notes
  - affichage des notes

- Harmoniser :
  - couleurs
  - typographie
  - boutons
  - espacements

---

## 10. Tests et vérification finale

- Tester le login
- Ajouter plusieurs notes pour une même matière
- Vérifier :
  - sélection de la note maximale
  - gestion correcte des matières optionnelles
  - affichage correct par semestre
  - calcul des moyennes

- Tester navigation :
  - liste étudiants → détail → ajout notes

---

## Ordre de priorité

1. Base de données
2. Authentification
3. Liste des étudiants
4. Ajout des notes
5. Affichage des notes
6. Règles de gestion
7. Calcul des moyennes
8. Design (uniquement si temps restant)