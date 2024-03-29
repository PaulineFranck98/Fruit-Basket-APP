<?php
    /*on souhaite enregistrer les produits en session sur le serveur : 
      on effectue l'appel de la fonction : session_start() pour disposer d'une session 

    ->session_start() a 2 utilités : 
       - démarrer une session sur le serveur pour l'utilisateur courant
       - récupérer la session de ce même utilisateur s'il en avait déjà une (possible grâce au cookie PHPSESSID)*/   
    session_start();
 
    // limiter l'accès à traitement.php par les seules requêtes HTTP provenant de la soumission du formulaire :
    // vérifie l'existence de la clé "submit" dans le tableau $_POST -> clé correspondant à l'attribut "name" du bouton
    // -> la condition sera vraie. si la requête POST transmet bien une clé "submit" au serveur
    
    // vérifie si le paramètre GET'action' est est défini dans l'URL -> vérifie si une action spécifique doit être exécutée
    if(isset($_GET['action'])){

        //début du switch case basé sur la valeur du paramètre GET'action'
        switch($_GET['action']){
            // ajout d'un produit au panier
            case 'add':
                
                // vérifie si le bouton submit a été pressé (s'assure que le formulaire a bien été envoyé)
                if(isset($_POST['submit'])){
                    // vérifie si le fichier existe et a été upload sans erreur 
                    // lorsque le formulaire est soumis, l’info sur le fichier uploadé est accessible via un tableau superglobal appelé _FILES. 
                    // ici formulaire d’upload contient un champ de sélection de fichier appelé photo (name= »photo »), si un utilisateur a uploadé un fichier en utilisant ce champ
                    // --> on peut obtenir ses détails :nom, le type, la taille, le nom temporaire ou toute erreur survenue lors de la tentative d’upload via le tableau associatif $_FILES["photo"]
                    if(isset($_FILES['photo']) && $_FILES['photo']['error']==0){
                        //définit les extensions autorisées
                        $allowed = [
                            "jpg" => "image/jpg",
                            "jpeg" => "image/jpeg",
                            "png" => "image/png",
                        ];
                        // spécifie le nom original du fichier et le set dans la variable $filename
                        $filename = $_FILES['photo']['name'];
                        // spécifie le type MIME fichier --> (Multipurpose Internet Mail Extensions) est un standard permettant d'indiquer la nature et le format d'un document
                        $filetype = $_FILES['photo']['type'];
                        // spécifie la taille du fichier (en octets) et le set dans la variable $filesize
                        $filesize = $_FILES['photo']['size'];
                        
                        // récupère/retourne l'extension du fichier : (filepath : chemin d'accès au fichier)
                        $extension = pathinfo($filename, PATHINFO_EXTENSION);

                        // md5() retourne la chaîne (nom photo) sous la forme d'un nombre hexadécimal de 32 caractères
                        // permet de créer un ID unique pour l'image téléchargée et ainsi éviter les failles d'upload
                        $namePicture= md5($filename). ".". $extension;
                

                        if(!array_key_exists($extension, $allowed)) die("Erreur : extension non autorisée");
                        // vérifie la taille du fichier 2Mb max
                        $maxsize = 2 * 1024 * 1024;
                        if($filesize > $maxsize) die("Erreur : taille de fichier trop lourde");

                        //vérifie le type MIME du fichier 
                        if(in_array($filetype, $allowed)){
                            // vérifie si le fichier existe dans le répertoire upload avant de le télécharger 
                            if (file_exists("upload/" . $_FILES['photo']['name'])) {
                                echo $_FILES['photo']['name']. " existe déjà";
                            }else {
                                // enregistre le fichier téléchargé dans le répertoire "upload"
                                move_uploaded_file($_FILES['photo']['tmp_name'], "upload/". $namePicture);
                                //$_FILES['photo']['tmp_name'] spécifie le nom temporaire, y compris le chemin complet qui est assigné au fichier une fois qu'il a été uploadé sur le serveur

                                echo "Votre fichier a été téléchargé avec succès!";
                            }
                        }else {
                            echo "Erreur : problème de téléchargement du fichier";
                        }
                    }else {
                        // spécifie le ode d'erreur ou d'état associé à l'upload du fichier, par exemple 0 s'il n'y a pas d'erreur
                        echo "Erreur : " . $_FILES['photo']['error'];

                    }   

                
                    // var_dump($extension); 
                    // die();
                    //supprime dans chaînes de caractères les caractères spéciaux et toutes balises HTML potentielles ou les encode -> pas d'injectionde code HTML possible
                    $name = filter_input(INPUT_POST,"name",FILTER_SANITIZE_FULL_SPECIAL_CHARS); //FILTER_SANITIZE_STRING->déprécié
            
                    // float :valide le prix que s'il est un nombre à virgule (pas de texte ou autre)
                    $price = filter_input(INPUT_POST,"price",FILTER_VALIDATE_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
                    // allow_fraction : est ajouté pour permettre l'utilisation du caractère "," ou "." pour la décimale.
            
                    // ne valide la quantité que si celle-ci est un nombre entier, au moins égal à 1.
                    $qtt = filter_input(INPUT_POST,"qtt",FILTER_VALIDATE_INT);
                    
                    // vérifie si les données saisies sont valides -> si true alors un produit est créé avec les données saisies
                    if($name && $price && $qtt){
                        // stock les données en session en les ajoutant au tableau $_SESSION -> on construit pour chaque produit un tableau associatif $product 
                        $product = [
                            "photo" => $namePicture,
                            "name" => $name,
                            "price" => $price,
                            "qtt" => $qtt,
                            "total"=> $price*$qtt
                        ];
                        // enregistre le produit nouvellement créé en session au tableau des produits stockés en session
                        $_SESSION['products'][] = $product;
                        // [] ->raccourci pour indiquer à cet emplacement que nous ajoutons une nouvelle entrée au futur tableau "products" associé à cette clé. 
                        // $_SESSION["products"] doit être lui aussi un tableau afin d'y stocker de nouveaux produits par la suite.

                        // message succès si les données sont valides 
                        $_SESSION['success']= "Le produit a bien été ajouté à votre panier.";
                    }else {
                    // message d'erreur si les données sont invalides et le produit n'est pas ajouté au panier
                     $_SESSION['error']= "Les données saisies sont invalides.";

                    }
                        
        
                }


            break;
            // suppression de tous les produits du panier
            case 'deleteAll':
                // vérifie s'il y a bien des produits ens session
                if(isset($_SESSION['products'])){
                   //unset() permet de détruire des variables spécifiées -> ici, tous les éléments stockés dans $_SESSION['products] seront supprimés lorsqu'on appuie sur l'input 'DeleteAll'
                    // suppression de tous les éléments $product['photo'] stockés dans $_SESSION['products]
                    foreach ($_SESSION['products'] as $product) {
                        // unlink permet de supprimer un fichier dans le répertoire "upload" 
                        unlink("upload/" . $product['photo'] );
                    }

                   unset($_SESSION['products']);
                    
                }
            break;
            
            case 'deleteOne':
                if(isset($_SESSION['products'])){
                    // $_SESSION['products'] est une variable de session qui stocke les produits dans un tableau associatif
                    unlink("upload/" . $_SESSION['products'][$_GET['id']]['photo'] );
                    unset($_SESSION['products'][$_GET['id']]);
                    // $_GET['id'] est une varibale qui récupère la valeur de l'ID du produit à supprimer à partir des données envoyées via la méthode GET$
                    // $_GET['id'] est entre [] pour utiliser sa valeur comme index pour accéder à un élément spécifique dans le tableau
                }

                header('Location:recap.php');
                // utilisation de la fonction header()pour rediriger vers la page recap.php (ne pas retourner à l'index à chaque fois)
                exit();
                // utilisation de la fonction exit() pour interrompre le script à cet endroit précis (ici, ne redirige pas vers index.php)
            break;

            // incrémentation qtt produit
            case 'plusOne':
                if(isset($_SESSION['products'])){
                    // augmente la qtt du produit spécifié (avec l'iD passé en paramètre GET)
                    $_SESSION['products'][$_GET['id']]['qtt']++;
                    // met à jour le total du produit en multipliant le prix unitaire par la nouvelle qtt
                    $_SESSION['products'][$_GET['id']]['total'] = $_SESSION['products'][$_GET['id']]['price'] * $_SESSION['products'][$_GET['id']]['qtt'];
                    // redirige vers la page recap.php après la maj de la qtt
                }
                header('Location:recap.php');
                // utilisation de la fonction header() pour arrêter le script et éviter toute exécution supplémentaire (ici : rediriger vers l'index) 
                exit();
            break;
                
             // décrémentation qtt produit   
            case 'minusOne':
                if(isset($_SESSION['products'])){
                    $_SESSION['products'][$_GET['id']]['qtt']--;
                    // met à jour le total du produit en multipliant le prix unitaire par la nouvelle qtt
                    $_SESSION['products'][$_GET['id']]['total'] = $_SESSION['products'][$_GET['id']]['price'] * $_SESSION['products'][$_GET['id']]['qtt'];

                    // utilisation de la fonction header() pour arrêter le script
                    if ($_SESSION['products'][$_GET['id']]['qtt'] == 0) {
                        // supprime le produit spécifié (avec l'ID passé en paramètre GET)
                        unlink("upload/" . $_SESSION['products'][$_GET['id']]['photo'] );
                        unset($_SESSION['products'][$_GET['id']]);
                        // diminue la qtt du produit spécifié (avec l'ID passé en paramètre GET)
                        header('Location:recap.php');
                    }
                }    
                header('Location:recap.php');
                exit();
            break;

            default;

        }
    }
    
   

    // dans l'autre cas, effectue une redirection vers la page d'accueil (formulaire soumis ou non) grâce à header()
    header("Location:index.php");
    
    
    // faille XSS : faille permettant à un attaquant d'injecter dans un site web un code malveillant 
    // faille d'upload : faille permettant d'uploader des fichiers avecune extension non autorisée 