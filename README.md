# Test technique Locasun

Bonjour, merci pour votre temps;

## Installer et demarrer l'application:
Il faut que Docker soit installé, il suffit alors de lancer la commande 
```bash
 make install-start
  ```
et de se rendre sur l'url: http://localhost:8180

## Utilisation
Une fois sur cette page, j'ai réalisé une petite interface graphique très simple afin de pouvoir utiliser les endpoints api (veuillez m'excuser le fait de ne pas avoir fait la traduction des Unicode). Vous pouvez cependant également utiliser la collection Postman qui se trouve dans le dossier sous le nom "Test technique Locasun.postman_collection.json".

Et pour finir voici les requêtes curl pour tester l'application:

### Requêtes Curl:

**Consultation de toutes les annonces** :
```bash
curl -X GET http://localhost:8180/annonces
```

**Consultation d'une seule annonce avec son uuid** (Attention à bien changé l'uuid) : 
```bash
curl -X GET http://localhost:8180/annonce/{uuid}
```

**Creation d'une annonce** : 
```bash
  curl -X POST -H "Content-Type: application/json" -d '{"categorie":"Automobile", "titre":"Lorem", "contenu": "ipsum", "modele": "RS4"}' http://localhost:8180/annonce
  ```

**Modification d'une annonce** (Attention à bien changé l'uuid) :
```bash
  curl -X PUT -H "Content-Type: application/json" -d '{"categorie":"Automobile", "titre":"Lorem", "contenu": "ipsum", "modele": "RS4"}' http://localhost:8180/annonce/{uuid}
  ```

**Suppression d'une annonce** (Attention à bien changé l'uuid) :
```bash
  curl -X DELETE http://localhost:8180/annonce/{uuid}
  ```


## Complément/Explication

J'ai utilisé similar_text et la distance de levenshtein afin de trouver le bon matching entre l'input et les modèles de voitures. J'ai cependant donné 3 fois plus d'importance à la distance de levenshtein lors de la comparaison de ces deux valeurs afin de m'assurer que similar_text a un pourcentage assez haut pour que la donnée soit bonne.

Je serai ravi d'échanger avec vous sur votre manière d'implémenter cet algorithme.