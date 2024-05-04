<?php get_header(); ?>
<div class="container">

	<!-- Appel template-part du hero header -->

	<?php get_template_part('template-parts/hero_banner'); ?>
</div>
<article>
    <div id="all-photos" class="photos_list">
       
                <?php 

                // On définit les arguments pour définir ce que l'on souhaite récupérer
                $args = array(
                    'post_type' => 'photos',
                    'order' => 'DESC', // ASC ou DESC 
                    'orderby' => 'date', // title, date, comment_count…
                    'posts_per_page' => 8,
                );
                
                // On exécute la WP Query
                $my_query = new WP_Query( $args );

                // On lance la boucle !
                if( $my_query->have_posts() ) : while( $my_query->have_posts() ) : $my_query->the_post();
                    
                    get_template_part( 'template-parts/photo_block' );

                endwhile;
                endif;

                // On réinitialise à la requête principale (important)
                wp_reset_postdata();
                ?>
            </div>
            <input id="load-more-button" type="submit" value="Charger plus">
        </div>
    </div>
</article>


<?php get_footer(); ?>	