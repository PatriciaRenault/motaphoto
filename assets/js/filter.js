jQuery(document).ready(function ($) {
  
  // Lorsqu'une valeur est sélectionnée dans le formulaire, on recupere les valeurs des filtres et tris
  $("#filter-form select").change(function (event) {             
    var category = $('select[name="category_filter"]').val();    
    var format = $('select[name="format_filter"]').val();        
    var order = $('select[name="sort_order"]').val(); 
    

    //  requête AJAX vers le serveur en utilisant les données de filtrage sélectionnées par l'utilisateur.
    $.ajax({
      type: "GET",
      url: ajax_object.ajax_url,  // URL vers le point d'accès AJAX de WordPress
      dataType: "json",            
      data: {
        action: "filter_photos",  // Action à effectuer côté serveur
        category_filter: category,
        format_filter: format,
        sort_order: order,
      },
    
      // En cas de succès de la requête AJAX
      success: function (response) {
        // Remplace le contenu de l'élément .photos_list par le contenu HTML retourné par le serveur
        $(".photos_list").empty().html(response.html);
        event.preventDefault();  //empeche le rechargement du formulaire
        initLightbox(); 
      },
    });
  });
});
