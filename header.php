<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>MotaPhoto</title>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <!--pour pouvoir déclarer le chargement des scripts et des styles.-->
        <?php wp_head(); ?>           
    </head>

    <body <?php body_class(); ?>>       
        <?php wp_body_open(); ?> 

        <header>
            <div class="header container">
            <!-- Ajout d'un custom logo -->
            <div class="logo">
                <?php 
                    if (function_exists('the_custom_logo')) {
                        the_custom_logo();
                    }
                ?>
            </div>

            <!-- Appel du menu principal -->
            <nav>
                <?php
                    wp_nav_menu(array(
                        'theme_location' => 'header', 
                        'container' => false, 
                        'menu_class' => 'menu',
                    ));
                 ?>
            </nav>

            <!-- Bouton burger pour les menus responsives -->
            <div class="burger">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
                </div>
       
        </header>

<main>
       
