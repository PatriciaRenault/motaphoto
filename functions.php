<?php
 
//AJOUTE DIVERSES FONCTIONNALITES DE SUPPORT AU THEME WORPRESS
function montheme_supports()
{
    add_theme_support('custom-logo');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
   
}
add_action('after_setup_theme', 'montheme_supports');


// LIENS AVEC LES STYLES
function enqueue_motaphoto_styles() {
    //ajout du CSS
    wp_enqueue_style('style', get_template_directory_uri() . '/style.css', array(), '1.0');
}
// Action pour ajouter la fonction à la file d'attente des styles
add_action('wp_enqueue_scripts', 'enqueue_motaphoto_styles');


// LIENS AVEC LES SCRIPTS
function enqueue_motaphoto_scripts() {

    // script JS
    wp_enqueue_script('script', get_template_directory_uri() . '/assets/js/script.js', array(), '1.0', true);
    wp_enqueue_script('lightbox-scripts', get_template_directory_uri() . '/assets/js/lightbox.js', array('jquery'), null, true);

    // ajout de la configuration ajax pour les boutons charger plus
   wp_enqueue_script('load-more', get_template_directory_uri() . '/assets/ajax/load-more.js', [ 'jquery' ],  '1.0',true );
    // Définir la variable ajax_object pour une utilisation dans le script JavaScript
    wp_localize_script('load-more', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    

    //enregistrement du script ajax-filter pour gerer les filtres ajax
    wp_enqueue_script('ajax-filter', get_template_directory_uri() . '/assets/ajax/filter.js', [ 'jquery' ], '1.0', true);
    //localise le script ajax-filter = permet d'effectuer des requêtes AJAX vers le point d'accès AJAX de WordPress à partir de votre script JavaScript.
    wp_localize_script('ajax-filter', 'afp_vars', array('afp_ajax_url' => admin_url('admin-ajax.php')));
    
    //wp_enqueue_script('ajax-function', get_template_directory_uri() . '/assets/js/ajax.js', [ 'jquery' ], '1.0', true);

    // localise le script ajax_params =>permet d'effectuer des requêtes AJAX vers le point d'accès AJAX de WordPress à partir du script JavaScript.
    //wp_localize_script('script', 'ajax_params', array('ajaxurl' => admin_url('admin-ajax.php')));

   // Enregistrez le script principal
   //wp_enqueue_script('ajax_script', get_template_directory_uri() . '/assets/js/ajax.js', array('jquery'), '1.0.0', true);

   // Localisez le script pour passer l'URL AJAX
   //wp_localize_script('ajax_script', 'wp_data', array('ajax_url' => admin_url('admin-ajax.php'),));
}
// Action pour ajouter la fonction à la file d'attente des scripts
add_action('wp_enqueue_scripts', 'enqueue_motaphoto_scripts');



// FONCTION POUR ENREGISTRER LES MENUS DE NAVIGATION
function register_my_menus() {
    register_nav_menus( array(
        'header' => 'Menu principal',      // Menu de navigation de l'en-tête
        'footer' => 'Menu pied de page',  // Menu de navigation du pied de page
    ) );
}
add_action( 'init', 'register_my_menus' );  // Action pour enregistrer les menus lors de l'initialisation de WordPress



// FONCTION CHARGEMENT DES POSTS SUPPLEMENTAIRES

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

    if (isset($_POST['category_filter']) && $_POST['category_filter']) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['category_filter']),
        );
    }

    if (isset($_POST['format_filter']) && $_POST['format_filter']) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['format_filter']),
        );
    }
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
        $output = ob_get_contents();//récupérer tout le contenu HTML généré à partir de l'exécution de la fonction load_more_photos() et de le stocker dans la variable $output.
        ob_end_clean();// nettoyer et désactiver la mise en mémoire tampon 
    }
    else {
        $response='';
        $output = '';
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


//FONCTION POUR LES FILTRES
function filter_photos() {

    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
        'paged'=> currentPage 
    );

    // Filtre par catégorie
    if (isset($_GET['category_filter']) && $_GET['category_filter']) {      //vérifie si le paramètre de requête GET appelé 'category_filter' est défini et n'est pas null


        // Construit un tableau pour filtrer les éléments en fonction des termes de la taxonomie 'categorie'
        $args['tax_query'] = array(
        // Définit les critères de filtrage
        array(
            // Spécifie la taxonomie à utiliser pour le filtrage
            'taxonomy' => 'categorie',
            // Spécifie le champ de la taxonomie à utiliser pour la correspondance (ici, le slug)
            'field'    => 'slug',
            // Utilise la valeur nettoyée du paramètre de requête GET 'category_filter'
            'terms'    => sanitize_text_field($_GET['category_filter']),
        ),
    );


    }

    // Filtre par format
   

    // Vérifie si le paramètre de requête GET 'format_filter' est défini et non vide
    if (isset($_GET['format_filter']) && $_GET['format_filter']) {
    // Si 'format_filter' est défini et non vide, ajoute une condition de taxonomie pour filtrer les éléments par format
        $args['tax_query'][] = array(
            // Spécifie la taxonomie à utiliser pour le filtrage (ici, 'format')
            'taxonomy' => 'format',
            // Spécifie le champ de la taxonomie à utiliser pour la correspondance (ici, le slug)
            'field'    => 'slug',
            // Utilise la valeur nettoyée du paramètre de requête GET 'format_filter'
            'terms'    => sanitize_text_field($_GET['format_filter']),
        );
    }


// Tri
if (isset($_GET['sort_order'])) {
    $args['orderby'] = 'date';  // Tri toujours par date

    if ($_GET['sort_order'] == 'date-ASC') {
        $args['order'] = 'ASC';
    } else if ($_GET['sort_order'] == 'date-DESC') {
        $args['order'] = 'DESC';
    }
}

    $query = new WP_Query($args);

    $response = '';

    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) :
            $query->the_post();
            get_template_part('template-parts/photo_block', 'photo');
        endwhile;
        $response = ob_get_contents();
        ob_end_clean();
    }

    echo json_encode(array('html' => $response));
    exit;
}


add_action('wp_ajax_filter_photos', 'filter_photos'); // Si utilisateur est connecté
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos'); // Si utilisateur n'est pas connecté



?>