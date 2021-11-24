<?php
$nomFichier = basename (__FILE__);
require 'php/header.php';
session_start();
require('php/fonctions/fonctionR.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/index.css" rel="stylesheet">
        <title>Accueil</title>
    </head>
    <body>
        <header>

        </header>
        <main>
            <div class="header">
                <div class="info">
                   <h1>Bienvenue <br> chez <br> Addict N' Shoes </h1> 
                </div>
            </div>
            <div class="content">
                <h1>Actualites</h1>
                <div class="contentArticle">
                    <div class="article">
                        <img class = 'imgArticleIndex' src="http://cdn.shopify.com/s/files/1/0496/4325/8009/products/baskets-air-jordan-1-retro-high-og-sp-travis-scott-fragment-military-blue-air-jordan-kikikickz-604686_1200x1200.jpg?v=1626432662" alt="TS Aj1" width = '104%'>
                        <p class="textArticle">
                            La collaboration entre la marque au Jumpman, Jacques Berman Webster II AKA Travis Scott
                            et Hiroshi Fujiwara, entre dans sa seconde phase. La Air Jordan One Retro High Military Blue passe à une 
                            coupe basse. En incluant la Playstation, c’est la 3ème du genre. L’édition limitée conserve l’essence 
                            de sa grande soeur. Les logos (Cactus Jack & Lightning Bolt) sont toujours à la même place. Des pointes 
                            de bleu apparaissent ici et là. A la différence, la AJ1 x Travis Scott x Fragment x Low OG SP Sail 
                            Muslin dispose d’une Black Toe. Ce détail emprunté à un colorway de 1985.
                        </p>
                        <button class="glow" type="button"><b>Lire la suite</b></button>
                    </div>
                    <div class="article2">
                        <img class = 'imgArticleIndex' src="https://www.sneakerstyle.fr/wp-content/uploads/2020/06/off-white-x-air-jordan-4-wmns-sail-CV9388-100.jpg" alt="OW AJ4" width = '100%'>
                        <p class="textArticle">
                            En soutien au mouvement Black Lives Matter, Virgil Abloh a mis aux enchères une Air Jordan 4 Retro W Off 
                            White™️ Sail Cream. Lancée fin juin, la vente a permis de récolter une somme avoisinant les 200000 dollars. 
                            Vous n’aurez pas à débourser une telle somme pour la chaussure en cuir beige et en mesh quadrillé blanc 
                            cassé existant uniquement en tailles femme. Son prix au retail s’élève à 225€ ( au moins le triple à la revente).
                            Toutefois, les fans ne se font guère d’illusions. Réussir à avoir cette AJ4 déstructurée avec un logo Nike Air 
                            et un Jumpman transparents s’annonce compliquée.
                        </p>
                        <button class="glow" type="button"><b>Lire la suite</b></button>
                    </div>
                    <div class="article3">
                    <img class = 'imgArticleIndex' src="https://mivintagelabel.com/wp-content/uploads/2020/10/Air-Jordan-1-x-Dior-2.jpg" alt="OW AF1" width = '94%'>
                        <p class="textArticle">
                        Le coronavirus bouscule la sortie de la Air Jordan 1 High Retro ‘Air Dior‘. La marque de luxe et la firme au 
                        Jumpman prévoyaient d’organiser une grande raffle internationale et d’ouvrir des pop up stores à certains 
                        endroits dont Paris. L’épidémie les oblige à revoir leur plan et repousser la release du modèle au swoosh en 
                        tissu jacquard affichant le motif Dior Oblique. Son lancement aura lieu plus tard dans l’année. Pourtant, ils 
                        n’ont pas lésiné sur les moyens en matière de communication. Nombreux sont les influenceurs à avoir reçu la 
                        Jordan 1 imaginée par Kim Jones.
                        </p>
                        <button class="glow" type="button"><b>Lire la suite</b></button>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
<?php
require 'php/footer.php';
?>