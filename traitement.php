<?php
    /*on souhaite enregistrer les produits en session sur le serveur : 
      on effectue l'appel de la fonction : session_start() pour disposer d'une session 

    ->session_start() a 2 utilités : 
       - démarrer une session sur le serveur pour l'utilisateur courant
       - récupérer la session de ce même utilisateur s'il en avait déjà une (possible grâce au cookie PHPSESSID)*/   
    session_start();
 
    // limiter l'accès à traitement.php par les seules requêtes HTTP provenant de la soumission du formulaire :
    // vérifie l'existance de la clé "submit" dans le tableau $_POST -> clé correspondant à l'attribut "name" du bouton
    // -> la condition sera vraie. si la requête POST transmet bien une clé "submit" au serveur
    
    if(isset($_GET['action'])){

        switch($_GET['action']){

            case 'add':
                

                if(isset($_POST['submit'])){

                    //supprime dans chaîne de caractères les caractères spéciaux et toutes balises HTML potentielles ou les encode -> pas d'injectionde code HTML possible
                    $name = filter_input(INPUT_POST,"name",FILTER_SANITIZE_FULL_SPECIAL_CHARS); //FILTER_SANITIZE_STRING->déprécié
            
                    // float :valide le prix que s'il est un nombre à virgule (pas de texte ou autre)
                    $price = filter_input(INPUT_POST,"price",FILTER_VALIDATE_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
                    // allow_fraction : est ajouté pour permettre l'utilisation du caractère "," ou "." pour la décimale.
            
                    // ne valide la quantité que si celle-ci est un nombre entier, au moins égal à 1.
                    $qtt = filter_input(INPUT_POST,"qtt",FILTER_VALIDATE_INT);
            
                    if($name && $price && $qtt){
                        // stocker les données en session en les ajoutant au tableau $_SESSION -> on construit pour chaque produit un tableau associatif $product 
                        $product = [
                            "name" => $name,
                            "price" => $price,
                            "qtt" => $qtt,
                            "total"=> $price*$qtt
                        ];
                        // enregistrer produit nouvellement créé en session
                        $_SESSION['products'][] = $product;
                        // [] ->raccourci pour indiquer à cet emplacement que nous ajoutons une nouvelle entrée au futur tableau "products" associé à cette clé. 
                        // $_SESSION["products"] doit être lui aussi un tableau afin d'y stocker de nouveaux produits par la suite.
                        $_SESSION['success']= "Le produit a bien été ajouté à votre panier.";
                    }else {

                     $_SESSION['error']= "Les données saisies sont invalides.";
                     
                    }
                        
                    

                }


            break;

            case 'deleteAll':
                   //unset() permet de détruire des variables spécifiées -> ici, tous les éléments stockés dans $_SESSION['products] seront supprimés lorsqu'on appuie sur l'input 'DeleteAll'
                    unset($_SESSION['products']);
   
            break;

            case 'deleteOne':
                    // $_SESSION['products'] est une variable de session qui stocke les produits dans un tableau associatif
                    unset($_SESSION['products'][$_GET['id']]);
                    // $_GET['id'] est une varibale qui récupère la valeur de l'ID du produit à supprimer à partir des données envoyées via la méthode GET$
                    // $_GET['id'] est entre [] pour utiliser sa valeur comme index pour accéder à un élément spécifique dans le tableau
                    header('Location:recap.php');
                    // utilisation de la fonction header()pour rediriger vers la page recap.php (ne pas retourner à l'index à chaque fois)
                    exit();
                    // utilisation de la fonction exit() pour interrompre le script à cet endroit précis (ici, ne redirige pas vers index.php)
            break;


            case 'plusOne':
                $_SESSION['products'][$_GET['id']]['qtt']++;
                $_SESSION['products'][$_GET['id']]['total'] = $_SESSION['products'][$_GET['id']]['price'] * $_SESSION['products'][$_GET['id']]['qtt'];
                header('Location:recap.php');
                exit();
            break;
                
                
            case 'minusOne':
                $_SESSION['products'][$_GET['id']]['qtt']--;
                $_SESSION['products'][$_GET['id']]['total'] = $_SESSION['products'][$_GET['id']]['price'] * $_SESSION['products'][$_GET['id']]['qtt'];
                header('Location:recap.php');
                exit();
            break;

            default;

                // faille XSS
        }
    }

   

    // dans l'autre cas, effectue une redirection vers la page d'accueil (formulaire soumis ou non) grâce à header()
    header("Location:index.php");

