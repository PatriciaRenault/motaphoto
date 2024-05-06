console.log("load-more chargé");

(function ($) {
    $(document).ready(function () {

      let currentPage = 1;

      $("#load-more-btn").on("click", function () {        //ajoute un gestionnaire d'événements sur le clic du bouton avec l'ID `load-more-btn`. Lorsque ce bouton est cliqué, le code à l'intérieur de la fonction de rappel est exécuté.

        currentPage++; // Incrémentation de currentPage de 1, pour charger la page suivante
        
        $.ajax({      
          type: "POST",   ////effectue une requête AJAX POST
          url: ajax_object.ajax_url,//vers l'URL spécifiée dans `ajax_object.ajax_url`(variable JavaScript qui contient l'URL vers le point d'API AJAX de WordPress. Cette variable est définie à l'aide de la fonction wp_localize_script() dans votre code PHP WordPress.)
          dataType: "json",//`dataType: "json"` vous permet de traiter la réponse de votre requête AJAX comme un objet JavaScript, ce qui facilite le traitement des données renvoyées par le serveur dans votre application front-end.
          data: {
            action: "load_more_photos",   //l'action load_more_photo est  utilisée pour déclencher la fonction PHP qui gère la récupération et le chargement supplémentaire de photos via AJAX.
            paged: currentPage, // on souhaite recuperer la page actuelle
          },
          // si la requete fonctionne
          success: function (res) {             
            $(".photos_list").append(res.html); // Ajoute le contenu à la galerie existante
    
            if (currentPage >= res.max) {  //s'il n'y a plus de photos on masque le bouton
              $("#load-more").hide();
            }
          },
        });
      });
    });
    
  
  })(jQuery);