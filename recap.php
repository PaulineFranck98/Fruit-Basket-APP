<!-- recap.php devra nous permettre d'afficher de manière organisée et exhaustive la liste des produits présents en session
Elle doit également présenter le total de l'ensemble de ceux-ci.


Contrairement à index.php -> besoin ici de - parcourir - le tableau de session 
->donc nécessaire d'appeler la fonction session_start() en début de fichier pour récupérer la session correspondante à l'utilisateur -->
<?php 

     session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif des produits</title>
</head>
<body>
    <?php
    // condition qui vérifie :
    // soit la clé "products"du tableau $_SESSION n'existe pas : !isset()
    // soit la clé existe mais ne contient aucune donnée : empty()

    if(!isset($_SESSION['products']) || empty($_SESSION['products'])){
        echo "<p>Aucun produit en session ...</p>";
    }
    // on trouve les balises HTML initialisant correctement un tableau HTML
    else{
        echo "<table>",
               "<thead>",
                   "<tr>",      
                       // ligne d'en-têtes <thead> pour bien décomposer les données de chaque produit
                       "<th>#</th>", 
                       "<th>Nom</th>",
                       "<th>Prix</th>",
                       "<th>Quantité</th>",
                       "<th>Total</th>",
                   "</tr>",
               "</thead>",
            "<tbody>";
        // avant la boucle, on initialise une nouvelle variable $totalGeneral à 0.
        $totalGeneral = 0;
        // exécute produit par produit les mêmes instructions qui vont permettre l'affichage uniforme de chacun d'entre eux
        foreach($_SESSION['products'] as $index => $product){
            // La boucle crée une ligne <tr> et toutes les cellules <td> nécessaires à chaque partie du produit à afficher pour chaque produit présent en session.
            echo "<tr>",
                    "<td>" . $index . "</td>",
                    "<td>" . $product['name'] . "</td>",
                    // number_format()permet de modifier l'affichage d'une valeur numérique
                    "<td>" . number_format($product['price'], 2, ",", "&nbsp;") . "&nbsp;€</td>",
                    "<td>" . $product['qtt'] . "</td>",
                    // le caractère HTML &nbsp est un espace insécable
                    "<td>" . number_format($product['total'], 2, ",", "&nbsp;") . "&nbsp;€</td>",
                "</tr>";
            // dans la boucle, grâce à l'opérateur combiné +=, on ajoute le total du produit parcouru à la valeur de $totalGeneral qui augmente d'autant pour chaque produit
            $totalGeneral += $product['total'];
        } 
        // Une fois la boucle terminée, on affiche une dernière ligne avant de refermer le tableau, elle contient 2 cellules : 
        //-> une cellule fusionnée de 4 cellules (colspan=4) pour l'intitulé
        //-> une cellule affichant le contenu formaté de $totalGeneral avec number_format()

        echo "<tr>",
                 "<td colspan=4>Total général : </td>",
                 "<td><strong>" . number_format($totalGeneral, 2, ",", "&nbsp;"). "&nbsp;€</strong></td>",  
                 "</tr>",
            "</tbody>",
            "</table>";

    }
    ?> 
</body>
</html>