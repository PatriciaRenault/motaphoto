<?php get_header(); ?>
<!-- Appel template-part du hero header -->
<div class="container">
	<?php get_template_part('template-parts/hero_banner'); ?>
</div>
<!-- liste des photos -->
<article>
    <div class="filter-options">
        <form id="filter-form" method="GET">  <!--les données du formulaire seront envoyées à l'URL de la page actuelle via une requête GET -->

            <!-- catégories -->
            <select name="category_filter">    <!--menu déroulant "category_filter" -->

                <option value="">Catégories</option>

                <?php
                    $categories = get_terms('categorie');  //récupère toutes les catégories de la taxonomie "categorie" 
                    foreach ($categories as $category) {
                        echo '<option value="' . $category->slug . '">' . $category->name . '</option>';  //Pour chaque catégorie, cette ligne génère une option avec la valeur du slug de la catégorie comme valeur et le nom de la catégorie comme texte affiché dans le menu déroulant.
                    }
                ?>
            </select>

            <!-- menu deroulant formats -->
            <select name="format_filter">
                <option value="">Formats</option>
                <?php
                    $formats = get_terms('format');
                    foreach ($formats as $format) {
                        echo '<option value="' . $format->slug . '">' . $format->name . '</option>';
                    }
            ?>
            </select>

            <!-- Pour le tri par années -->
            <select name="sort_order">
                <option value="">Trier par </option>
                <option value="date-DESC">A partir des plus récentes</option>
                <option value="date-ASC">A partir des plus anciennes</option>
            </select>

        </form>
    </div>
    <div id="all-photos" class="photos_list"> 

       <?php 
            // définit les arguments pour définir ce que l'on souhaite récupérer
            $args = array(
                'post_type' => 'photos',
                'order' => 'DESC', // ASC ou DESC 
                'orderby' => 'date', // title, date, comment_count…
                'posts_per_page' => 8,
                'paged'=> 1,
            );
                
            // On exécute la WP Query
            $my_query = new WP_Query( $args );

            // On lance la boucle !
            if( $my_query->have_posts() ) : while( $my_query->have_posts() ) : $my_query->the_post();
                //utilise de template déja crée         
                get_template_part( 'template-parts/photo_block' );
            endwhile;
            endif;

            // réinitialise à la requête principale
            wp_reset_postdata();
        ?>

        </div>
            <input id="load-more-btn" class="btn" type="button" value="Charger plus">
        
    </div>
</article>


<?php get_footer(); ?>	