<?php get_header(); ?>
<!-- Appel template-part du hero header -->
<div>
	<?php get_template_part('template-parts/hero_banner'); ?>
</div>
<!-- liste des photos -->
<article>   
    <div class="filter-options">
        <form id="filter-form" method="GET">  
            <div class="filters">
                <!-- catégories -->
                <select name="category_filter" id="category_filter"> 
                    <option value="">Catégories</option>
                    <?php
                        $categories = get_terms('categorie'); 
                        foreach ($categories as $category) {
                            // Génère une option pour chaque catégorie avec le slug comme valeur et le nom de la catégorie comme texte affiché
                            echo '<option value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</option>';
                        }
                    ?>
                </select>

                <!-- Formats -->
                <select name="format_filter" id="format_filter"> 
                    <option value="">Formats</option>
                    <?php
                        $formats = get_terms('format');
                        foreach ($formats as $format) {
                            // Génère une option pour chaque format avec le slug comme valeur et le nom du format comme texte affiché
                            echo '<option value="' . esc_attr($format->slug) . '">' . esc_html($format->name) . '</option>';
                        }
                    ?>
                </select>
            </div>
            <!-- Tri par date -->
            <div class="sort-order">
                <select name="sort_order" id="sort_order">
                    <option value="">Trier par</option>
                    <option value="date-DESC">À partir des plus récentes</option>
                    <option value="date-ASC">À partir des plus anciennes</option>
                </select>
            </div>
        </form>
    </div>
    

    <div id="all-photos" class="photos_list"> 
       <?php 
            // définit les arguments pour la WP Query
            $args = array(
                'post_type' => 'photos',
                'order' => 'DESC', 
                'orderby' => 'date', 
                'posts_per_page' => 8,
                'paged'=> 1,
            );
                
            // On exécute la WP Query
            $my_query = new WP_Query( $args );

            // Boucle wordpress
            if( $my_query->have_posts() ) : 
                while( $my_query->have_posts() ) : 
                    $my_query->the_post();      
                    get_template_part( 'template-parts/photo_block' );  // Utilisation d'un template déjà créé 
            endwhile;
            endif;

            // Réinitialisation des données de la requête principale
            wp_reset_postdata();
        ?>
    </div>
    <input id="load-more-btn" class="btn" type="button" value="Charger plus">
</article>

<?php get_footer(); ?>	