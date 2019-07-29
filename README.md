# Projet Symfony 4 : Rotten Potatoes
Comme vous l'avez compris, c'est un `fork` (une copie / reboot) du célèbre Rottent Tomatoes : un site sur lequel les internautes donnent des critiques et des notes aux films afin qu'on ait une rapide idée du niveau.

# Les notions nécessaires 
Pour mener ce projet à bien il vous faudra mettre en place :
- Des **routes** et des **controllers**
- Des **formulaires**
- De la **validation**
- Des **requêtes DQL**
- L'**authentification** et les **autorisations** en fonction de **divers rôles d'utilisateurs**
-----------------------------------------
# Modèle de donnée
Ce projet met en oeuvre XXX entités qu'il faudra créer et mettre en place (y compris les fausses données qui permettront de travailler rapidement - _fixtures_).

### Category (catégorie)
- title (string, 255, not null) : le titre de la catégorie
- slug (string, 255, not null) : le slug
- movies (relation ManyToMnay avec Movie)

### Movie (film)
- title (string, 255, not null) : le titre du film
- slug (string, 255, not null) : le slug 
- poster (string, 255, not null) : l'URL vers l'image du film
- director (relation ManyToOne avec People) : le réalisateur du film
- actors (relation ManyToMany avec People) : les acteurs du film
- releasedAt (datetime, not null) : la date de sortie
- synopsis (text, not null) : le résumé du film
- categories (relation ManyToMany avec Category)

### People (personne)
- firstName (string, 255, not null)
- lastName (string, 255, not null)
- description (text, not null)
- slug (string, 255, not null)
- birthday (datetime, not null)
- picture (string, 255, not null)
- actedIn (relation ManyToMany avec Movie) 
- directed (relation ManyToMany avec Movie)

### Rating (note)
- author (relation ManyToOne avec User)
- createdAt (datetime, not null)
- notation (integer, not null)
- comment (text, nullable)
- movie (relation ManyToOne avec Movie)

### User (utilisateur)
Les champs en gras sont générés automatiquement
- **email** (string, 255, not null)
- username (string, 255, not null)
- avatar (string, 255, not null)
- **password** (string, 255, not null)
- **roles** (json, not null)


-------------------------------------------
# Fonctionnalités du site 
Le site devra présenter différentes pages et fonctionnalités :

### Page d'inscription (route: /register)

### Page de connexion (route: /login)

### Déconnexion (route: /logout)

### Page d'une catégorie de films (route: /category/{slug})
Elle présente la liste des films de la catégories classés par date de sortie des films.

### Page d'un film (route: /movie/{slug})
- Elle présente un film avec ses acteurs, son réalisateur et les notes existantes
- Elle doit évidemment présenter sa note moyenne
- Elle doit aussi présenter un formulaire qui permet de donner une note au film UNIQUEMENT si l'utilisateur est connecté, sinon elle donne un lien vers la page de connexion.
- **BONUS : Empêcher un utilisateur qui a déjà noté de donner une deuxième note !**

### Page d'une personne (route: /people/{slug})
- Elle présente les infos de la personne et sa description
- Elle présente aussi les films dans lesquels la personne a joué organisés par date
- Elle présente aussi les films que la personne a réalisé organisés par date

### Administration des films (route: /admin/movie)
**Accessible uniquement aux utilisateur possédant le ROLE_ADMIN**
La liste des films avec lien de suppression / modification / ajout
### Administration des notations (route: /admin/rating)
**Accessible uniquement aux utilisateurs possédant le ROLE_MODERATOR (et donc le ROLE_ADMIN)**
La liste des commentaires avec lien de suppression

### Page d'accueil (route: /) - à faire en dernier :-)
**Les 3 derniers films sortis**
Il faut présenter les 3 derniers films sortis avec
- L'image du film
- Le réalisateur du film (prénom et nom)
- L'année de sortie
- 2 acteurs au hasard (leur nom et prénom)
- La note moyenne

**Les 3 meilleurs films**
Il faut présenter les 3 films les mieux notés avec :
- L'image du film
- Le réalisateur du film (prénom et nom)
- L'année de sortie
- 2 acteurs au hasard (leur nom et prénom)
- La note moyenne

**Les 3 pires films**
Il faut présenter les 3 films les moins bien notés avec :
- L'image du film
- Le réalisateur du film (prénom et nom)
- L'année de sortie
- 2 acteurs au hasard (leur nom et prénom)
- La note moyenne
