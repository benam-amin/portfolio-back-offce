Menu de navigation : 
ACCUEIL - ABOUT - COMPETENCES - PROJETS - CONTACT 

PLAN D'ACTION :
- Menu de navigation + réseaux sociaux
- Adapter les contenus des pages avec mes besoins 
- Création de la table Catégorie, Projets, Compétences
- Navigation dans la partie administration : revenir à l'accueil en dernier, éditer les projets, les catégories de projets, éditer des éventuels collaborateurs éditer les réseaux sociaux
- Projet : 
    - Titre 
    - Chapo 
    - idCollaborateur
    - Date
    - idCategories
    - Upload De fichier pour des medias
    - Descriptif du projet 
    - Visibilité
    - Technologies utilisées 
    - Couleur du projet
    - Media couverture
- Collaborateur : 
    - id PRIMARY KEY
    - Nom
    - Prénom
    - idProjets External Key
    - Contact (séparés d'une , attends plusieurs valeurs, seulement linkedin et éventuellement lien portfolio)  - on sépare avec la fonction preg-split // Explode but with severals delemiters $array = preg_split('/[YOUR_DELEMITERS_HERE]/', $string); // Example with ".", "-" and "@" $array = preg_split('/[.\-@]/', 'foo.bar@example.com'); // Result ['foo', 'bar', 'example', 'domain', 'com']
    - Liens de contact                                    - pareil ici 
    - uploadDeFichier