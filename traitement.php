<?php
    session_start();
    //un utilisateur malveillant pourrait atteindre le fichier traitement.php en saisissant directement l'URL de celui-ci dans la barre d'adresse...
    // et ainsi provoquer des erreurs sur la page qui lui présenterait des infos que nous ne souhaitont pas dévoiler
    // il faut donc limiter l'acès à traitement.php par les seules requêtes HTTP provenant de la soumission de notre formulaire 


    if(isset($_POST['submit'])){

    }

    header("Location:index.php");

    //ici, on vérifie l'existence de la clé "submit" dans le tableau $_post, cette clé correspondant à l'attribut "name" du bouton <input type="submit" name="submit"> du formulaire
    //la condition sera alors vraie seulement si la requête POST transmet bien une clé "submit" au serveur. 
    // dans l'autre cas, header("Location : index.php"); effectue une redirection.
    // il n'y a pas de else à la condition puisque nous souhaitons revenir au formulaire après traitement 'formulaire soumis ou non')
    // --> header() envoie un nouvel entête HTTP 'entêtes d'une réponse) au client. 
    // Avec le type d'appel "Location:" cette réponse est envoyée au client avec le statut code 302, qui indique une redirection
// Attention ! lu'itilisation de header() nécessite 2 précautions :
// -la page qui l'emploie ne doit pas avoir émis un débgut de réponse avant header() (afficher du HTML, appeler des fonctions echo par ex sous peine de perturber la réponse à émettre au cient)
// -l'appel de header() n'arrête pas l'exécution du script courant. Si le fichier effectue à la suite de la fonction d'autres traitements, ils seornt exécutés.
// Il faut alors veiller à ce que header() soit la dernière   