</main>
 <!-- integration de la popup de contact  -->
 <?php get_template_part('/template-parts/modal');?>
 <?php get_template_part('template-parts/lightbox');?>
<footer class="navfooter">
    <div class="navfooter__menu">
        <?php
            wp_nav_menu(array(
                'theme_location' => 'footer', 
                'container' => 'ul', 
                'menu_class' => 'menu-footer',
            ));
            ?>
        <p>TOUT DROITS RÉSERVÉS</p>
       
    </div>
</div>
 
</footer>

<?php wp_footer(); ?>       <!--ajoute dynamiquement des éléments au footer du site.-->

</body>
</html>