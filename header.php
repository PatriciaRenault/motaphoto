<!doctype html>
<html lang="fr">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>MotaPhoto</title>
        <?php wp_head(); ?>
    </head>

<body>
<?php wp_body_open(); ?> 
    <div>
       <!-- Appel du menu principal -->
        <?php
                wp_nav_menu(array(
                    'theme_location' => 'header', 
                    'container' => false, 
                    'menu_class' => 'menu-principal',
                ));
        ?>   
    </div>     
       

       
