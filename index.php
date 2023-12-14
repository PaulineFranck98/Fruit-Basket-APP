<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout produit</title>
</head>
<body>

    <h1>Ajouter un produit</h1>
    <!-- form contient 2 attributs : 
    - action -> indique la cible du formulaire, le fichier à atteindre lorsque l'utilisateur soumet le formulaire 
    - method -> précise par quelle méthode HTTP les données du formulaire seront transmises au serveur  
    -> ici, on utilise : POST pour ne pas polluer l'URL avec les données sur formulaire  -->

    <form action="traitement.php?action=add" method="post">
        <p>
            <label>
                Nom du produit :
                <!-- chaque input dispose d'un attribut "name"
                -> va permettre à la requête de classer le contenu de la saisie dans des clés portant le nom choisi 
                -> ainsi, var_dump($_POST) donnera : "name"-> "", "price"-> "", "qtt"-> "",  après saisie et soumission-->
                <input type="text" name="name"> 
            </label> 
        </p> 
        <p>
            <label>
                Prix du produit :
                <!-- possède attribut name -->
                <input type="number" step="any" name="price"> 
            </label> 
        </p> 
        <p>
            <label>
                Quantité désirée :
                <!-- possède attribut name -->
                <input type="number" name="qtt" value="1"> 
            </label> 
        </p> 
        <p>
            <!-- possède AUSSI attribut name : permettra de vérifier côté serveur que le formulaire a bien été validé par l'utilisateur -->
            <input type="submit" name="submit" value="Ajouter le produit">
        </p>
    </form>
 
        
  
</body>
</html>