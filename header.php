<!doctype html>
<html lang="fr">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>MotaPhoto</title>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <?php wp_head(); ?>             <!--ajoute dynamiquement des éléments à l'en-tête du site.-->
    </head>

    <body <?php body_class(); ?>>
<?php wp_body_open(); ?> 

<header class="header">
        <!-- Ajout d'un custom logo -->
        <div class="logo">
            <?php the_custom_logo();?>
        </div>

       <!-- Appel du menu principal -->
       <nav>
            <ul>
                <?php
                    wp_nav_menu(array(
                        'theme_location' => 'header', 
                        'container' => false, 
                        'menu_class' => 'menu',
                    ));
                ?>
            </ul>  
        </nav>
        <div class="burger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
        </nav>   
       
</header>

<main>
       
