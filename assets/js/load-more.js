/* SCRIPT AJAX PERMETTANT DE CHARGER PLUS DE PHOTOS */
(function ($) {
  $(document).ready(function () {
    let currentPage = 1;

    $("#load-more-btn").on("click", function () {        //gestionnaire d'événements 
      currentPage++;                                     // Incrémentation de currentPage de 1, pour charger la page suivante
        
      // Recupere les valeurs des filtres
      var category = $('select[name="category_filter"]').val();    
      var format = $('select[name="format_filter"]').val();    
      var order = $('select[name="sort_order"]').val();
        
      // Requete AJAX POST
      $.ajax({      
        type: "POST",   
        url: ajax_object.ajax_url,// URL vers le point d'API AJAX de WordPress
        dataType: "json",// Permet de traiter la réponse comme un objet JavaScript
        data: {
          action: "load_more_photos",   
          paged: currentPage, 
          category_filter: category,
          format_filter: format,
          sort_order: order
        },
        // si la requete reussit
        success: function (res) {             
          $(".photos_list").append(res.html); // Ajoute le contenu à la galerie existante

          // Initialise la ligthbox si elle existe
          if (typeof initLightbox === 'function') {
            initLightbox();
          } else {
            console.error('initLightbox non defined');
          }
        
          // Cache le bouton s'il n'y a plus de photos à charger
          if (currentPage >= res.max) {  
            $("#load-more-btn").hide();
          }
        },
        // gestionnaire d'erreurs pour aider au débogage
        error: function (jqXHR, textStatus, errorThrown) {
          console.error('Erreur AJAX: ' + textStatus, errorThrown);
        }
      });
    });
  });
})(jQuery);