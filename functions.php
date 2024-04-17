<?php
    // Fonction pour enregistrer les menus de navigation
    function register_my_menus() {
        register_nav_menus( array(
            'header' => 'Menu principal',      // Menu de navigation de l'en-tête
            'footer' => 'Menu pied de page',  // Menu de navigation du pied de page
        ) );
    }
    add_action( 'init', 'register_my_menus' );  // Action pour enregistrer les menus lors de l'initialisation de WordPress
?>