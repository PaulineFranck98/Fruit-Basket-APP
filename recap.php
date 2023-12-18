<!-- recap.php devra nous permettre d'afficher de manière organisée et exhaustive la liste des produits présents en session
Elle doit également présenter le total de l'ensemble de ceux-ci.


Contrairement à index.php -> besoin ici de - parcourir - le tableau de session 
->donc nécessaire d'appeler la fonction session_start() en début de fichier pour récupérer la session correspondante à l'utilisateur -->
<?php 

     session_start();
     require 'functions.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/d004286c36.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&family=Ms+Madi&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <title>Récapitulatif des produits</title>
</head>
<body>
<header>
        <h1>Fruit'<span class="mot-vert">n</span>'Click  <i class="fa-regular fa-lemon" style="color: #8dd912;"></i></h1>
        <h2 class="slogan">le fruit à portée de click!</h2>
        <nav>
            <ul>
                <li><a class='vert' href="index.php">Accueil</a></li>
                <li><a href="">Contact</i></a></li>
                <li><a href="">A propos</a></li>
                <li><a href="">Actualités</a></li>
                <li><a href="">Nos engagements</i></a></li>
                
            </ul>
        </nav>
    </header>
    <?php
    echo "<p class='message_products'><i class='fa-solid fa-apple-whole' style='color: #8dd912;'></i> Nombre de produits dans le panier : ". nombreProduitsSession(). "</p>";
    
    // condition qui vérifie :
    // ->soit la clé "products"du tableau $_SESSION n'existe pas : !isset()
    // ->soit la clé existe mais ne contient aucune donnée : empty()
    if(!isset($_SESSION['products']) || empty($_SESSION['products'])){
        echo "<p>Aucun produit en session ...</p>";
    }
    // on trouve les balises HTML initialisant correctement un tableau HTML
    else{
        echo "<div class='container'>",
            "<figure>",
                "<img src='fruitsboom3.jpg' class='image'>",
            "</figure>",
            "<div class='table'>",
                "<table>",
                    "<thead>",
                        "<tr>",      
                            // ligne d'en-têtes <thead> pour bien décomposer les données de chaque produit
                            "<th class='index_hidden'>#</th>", 
                            "<th>Photo</th>",
                            "<th>Nom</th>",
                            "<th>Prix</th>",
                            "<th></th>",
                            "<th>Quantité</th>",
                            "<th></th>",
                            "<th>Total</th>",
                            "<th></th>",
                        "</tr>",
                    "</div>",
                    "</thead>",
                    "<tbody>";
                // avant la boucle, on initialise une nouvelle variable $totalGeneral à 0.
                $totalGeneral = 0;
                // exécute produit par produit les mêmes instructions qui vont permettre l'affichage uniforme de chacun d'entre eux
                foreach($_SESSION['products'] as $index => $product){ 
                    // La boucle crée une ligne <tr> et toutes les cellules <td> nécessaires à chaque partie du produit à afficher pour chaque produit présent en session.
                    echo "<tr style='font-weight:500;' >",
                            "<td><figure><img class='img-products' src='upload/" . $product['photo'] . "' alt=" . $product['name'] . "></figure></td>",
                            "<td class='index_hidden'>" . $index . "</td>",
                            // ucfirst() première lettre en majuscule
                            "<td class='border-bottom'>" . ucfirst($product['name']) . "</td>",
                            // number_format()permet de modifier l'affichage d'une valeur numérique
                            "<td>" . number_format($product['price'], 2, ",", "&nbsp;") . "&nbsp;€</td>",
                            "<td><a href='traitement.php?action=minusOne&id=" . $index . "'><i class='fa-solid fa-minus'></i></a>", 
                            "<td>" . $product['qtt'] . "</td>",
                            "<td><a href='traitement.php?action=plusOne&id=" . $index . "'><i class='fa-solid fa-plus'></i></a></td>",
                            // le caractère HTML '&nbsp' est un espace insécable
                            "<td>" . number_format($product['total'], 2, ",", "&nbsp;") . "&nbsp;€</td>",
                            "<td><a href='traitement.php?action=deleteOne&id=". $index. "'><i class='fa-solid fa-trash'></i></a></td>",
                            
                        "</tr>";
                    // dans la boucle, grâce à l'opérateur combiné +=, on ajoute le total du produit parcouru à la valeur de $totalGeneral qui augmente d'autant pour chaque produit
                    $totalGeneral += $product['total'];
                } 
                // Une fois la boucle terminée, on affiche une dernière ligne avant de refermer le tableau, elle contient 2 cellules : 
                //-> une cellule fusionnée de 8 cellules (colspan=8) pour l'intitulé
                //-> une cellule affichant le contenu formaté de $totalGeneral avec number_format()

                echo "<tr  class='total'>",
                        "<td colspan=8><span style='font-weight:bold;'>Total général    :</span><span class='total-weight'> " . number_format($totalGeneral, 2, ",", "&nbsp;"). "&nbsp;€</span></td>",  
                        "</tr>",
                    "</tbody>",
                "</table>",
                "<div class='table-button'>",
                "<a href='traitement.php?action=deleteAll'><input type='submit' name='deleteAll' value='Vider le panier'/><a/>",
                "<a class='ajouter'href='index.php'>Ajouter un nouveau produit</a>",
                "</div>",
            "</div>",
            
        "</div>";

    }

    ?> 
    
</body>
</html>