<?php


get_header();

/* Start the Loop affichage du contenu de la page créée via WordPress*/

if (have_posts()) {
    while (have_posts()) {
        the_post();
        // Affiche le titre de la page
        the_title('<h1>', '</h1>');
        // Affiche le contenu de la page
        the_content();
    }
}
?>

<?php
get_footer();
?>


