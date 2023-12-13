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
    -action -> indique la cible du formulaire, le fichier à atteindre lorsque l'utilisateur soumet le formulaire 
    -method -> précise par quelle méthode HTTP les données du formulaire seront transmises au serveur  
    méthode employée ici : POST pour ne pas polluer l'URL avec les données sur formulaire 
    il est possible d'envoyer avec GET mais les infos envoyées se retrouvent alors inscrites dans l'URL et limitée en nb caractères -->

    <form action="traitement.php" method="post">
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

    <!-- on souhaite enregistrer les produits en session sur la serveur : 
    on effectue l'appel de la fonction : session_start() pour disposer d'une session 
    - session_start() a 2 utilités : 
        - démarrer une session sur le serveur pour l'utilisateur courant
        - récupérer la session de ce même utilisateur s'il en avait déjà une    
        ->cette 2e fonctionnalité est possible car au démarrage d'une session : 
          le serveur enregistrera :  un cookie PHPSESSID dans le navigateur client, contenant l'identifiant de la session appartenant à celui-ci 
        ->les cookies sont transmis au serveur avec chaque requête HTTP effectuée par le client
    
        ->la durée de vie du cookie dépend de la configuration serveur à ce sujet. 
        ->par défaut, le cookie expirera à la fermeture du navigateur (Expirtion/ax-Age=Session)
        ->si le cookie venait à être supprimé ou modifié, alors le serveur considérera la prochaine requête effectuée
        par le client comme devant démarrer une nouvelle session.
        Les données de la session précédente, tant que l'identifiant précédent ne sera pas retransmis dans une éventulle prochaine requête, resteront inaccessibles.
        Le serveur, lui, conservera la session selon le paramètre de configuration session.cache_limiter, défini à 180min par défaut  --> 

  
</body>
</html>