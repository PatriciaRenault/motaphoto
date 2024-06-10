<!-- affichage d'une image aléatoire avec la taxonomie format égale à paysage -->
<div class="banner-style">
    <?php 
        // Configuration de la requête
        $the_query = new WP_Query(array( 
            'orderby' => 'rand',                      // de manière aléatoire
            'posts_per_page' => 1,                   
            'post_type' => 'photos',                  
            'tax_query' => array(                     // requête de taxonomie
                array(
                    'taxonomy' => 'format',           
                    'field' => 'slug',                
                    'terms' => 'paysage',            
                ),
            ),
        ));
                
        // Boucle WordPress
        if ($the_query->have_posts()) {               
            while ($the_query->have_posts()) {       
                $the_query->the_post();               
                the_post_thumbnail();                 // Afficher l'image mise en avant du post
            } 
            // Réinitialise les données du post
            wp_reset_postdata();                      
        } else {
            // Aucun post trouvé
            echo '<p>Aucune photo trouvée.</p>';      
        }
    ?>

    <div class="titre-header">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/titreHeader.png'); ?>" alt="Photographe event"> <!-- Affiche l'image du titre -->
    </div>
</div>
