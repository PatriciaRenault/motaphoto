<!-- Bloc d'affichage d'une photo de la liste pour page accueil -->

<div class="banner-style">
    <?php 
        $the_query = new WP_Query(array( 
            'orderby' => 'rand',
            'posts_per_page' => 1,
            'post_type' => 'photos',
            'tax_query' => array(
                array(
                    'taxonomy' => 'format',
                    'field' => 'slug',
                    'terms' => 'paysage',
                ),
            ),
        ));
        
    

    // Boucle
    
         while ($the_query -> have_posts()) {
            $the_query -> the_post();
            the_post_thumbnail(); 
        } 

        // Restoration des données
        wp_reset_postdata();
    ?>
    <div class="titre-header">
        <img src="<?php echo get_template_directory_uri() . '/assets/images/titreHeader.png'; ?>" alt="Photographe event">      <!--Affiche l'image du titre -->
    </div>
</div>