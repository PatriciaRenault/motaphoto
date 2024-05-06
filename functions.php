<?php
//ajoute diverses fonctionnalités de support au thème WordPress
function montheme_supports()
{
    add_theme_support('custom-logo');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
   
}
add_action('after_setup_theme', 'montheme_supports');


// Liens avec les styles et les scripts
function enqueue_motaphoto_styles() {
    //ajout du CSS
    wp_enqueue_style('style', get_template_directory_uri() . '/style.css', array(), '1.0');
    // script JS
    wp_enqueue_script('script', get_template_directory_uri() . '/assets/js/script.js', array(), '1.0', true);

    // script pour ajax
    wp_enqueue_script('load-more', get_template_directory_uri() . '/assets/ajax/load-more.js', [ 'jquery' ],  '1.0',true );
    // Définir la variable ajax_object pour une utilisation dans le script JavaScript
    wp_localize_script('load-more', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}

// Action pour ajouter la fonction à la file d'attente des styles
add_action('wp_enqueue_scripts', 'enqueue_motaphoto_styles');



// Fonction pour enregistrer les menus de navigation
function register_my_menus() {
    register_nav_menus( array(
        'header' => 'Menu principal',      // Menu de navigation de l'en-tête
        'footer' => 'Menu pied de page',  // Menu de navigation du pied de page
    ) );
}
add_action( 'init', 'register_my_menus' );  // Action pour enregistrer les menus lors de l'initialisation de WordPress

// Fonction chargement supplémentaire des posts 

function load_more_photos() {
    //arguments de la requête pour récupérer les photos
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
        'orderby' => 'date',
        'order' => 'DESC',
        'paged' => $_POST['paged'],  //numero de la page
    );
    console.log("paged");
    $query = new WP_Query($args);    //Cela récupère les publications de type 'photos' selon les critères spécifiés dans `$args

    $response = '';
    $max_pages = $query->max_num_pages;  //récupère le nombre maximum de pages de la requête


    if ($query->have_posts()) {
        ob_start();   //pour démarrer la mise en mémoire tampon de sortie 
    //boucle `while` parcourt toutes les publications récupérées par la requête WP_Query et génère le HTML correspondant à chaque photo. Ce HTML est concaténé dans la variable `$response`.
        while ($query->have_posts()) :  
            $query->the_post();
            $response .= get_template_part('template-parts/photo_block');  //récupérer le contenu HTML généré à partir du fragment de modèle 'photo_block' pour chaque photo récupérée, et de l'ajouter à la variable `$response`. Cette variable sera ensuite utilisée pour construire la réponse JSON renvoyée à la requête AJAX.
        endwhile;
        $output = ob_get_contents();//écupérer tout le contenu HTML généré à partir de l'exécution de la fonction load_more_photos() et de le stocker dans la variable $output.
        ob_end_clean();// nettoyer et désactiver la mise en mémoire tampon 
    }
    else {
        $response='';
    }
// tableau contenant le nombre de pages et le code html
 $result = [
    'max' => $max_pages,
    'html' => $output,
  ];

 echo json_encode($result);  //encodé en JSON
 exit;                       //arret du script
}

// Action WordPress pour la requête AJAX
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');

?>