  function initLightbox() {
    console.log("initialisation ligthbox");

      const lightbox = document.getElementById('myLightbox');  // Récupère la lightbox    
      const btnsFullscreen = document.querySelectorAll('.icon-fullscreen');  // Récupère tous les élements qui ouvre la lightbox   (on obtient un tableau) 
      const close = document.querySelector(".lightbox__close");  // Récupère l'élement qui ferme la lightbox

      // Fonction pour ouvrir la lightbox
      function openLightbox() {
          lightbox.style.display = "block";
      }

      // Fonction pour fermer la lightbox
      function closeLightbox() {
          lightbox.style.display = "none";
      }
      

      close.onclick = closeLightbox;  //// Quand l'utilisateur click sur (x), ferme la lightbox

      // 
      btnsFullscreen.forEach(function(btnFullscreen) {                       // itére sur chaque élément du tableau btnsFullscreen
          btnFullscreen.addEventListener('click', function(event) {          //Ajoute un event listeners sur chaque bouton
              event.preventDefault();                                        // Empêche la navigation par défaut si le lien est un lien hypertexte

              // Récupère les valeurs de la photo spécifique
              const photoThumbnail = btnFullscreen.closest('.post-container').querySelector('.photo-thumbnail');  //sélectionnela miniature de la photo associée au bouton de plein écran sur lequel l'utilisateur a cliqué (la methode closest recherche l'élément ascendant le plus proche qui a la classe CSS post-container .)
              const imageSource = photoThumbnail.querySelector('img').src;                                        //extrait l'URL de la source de l'image de la miniature de la photo.
              const photoRef = photoThumbnail.querySelector('.reference').innerHTML;                              //recupere le contenu HTML de l' élément avec la classe .reference qui est un descendant de photoThumbnail.
              const photoCat = photoThumbnail.querySelector('.categorie').innerHTML;                              // recupere le contenu HTML de la categorie

              // Crée un tableau de toutes les photos du groupe
              const photos = [];                                                          // initialisation du tableau
              const photoItems = document.querySelectorAll('.photo-thumbnail');           //Sélection des éléments de miniature de photo
              photoItems.forEach(function (item) {                                        // le tableau photoItems représente toutes les miniatures de la page
                  const img = item.querySelector('img').src;
                  const ref = item.querySelector('.reference').innerHTML;
                  const cat = item.querySelector('.categorie').innerHTML;
                  photos.push({                 //chaque objet representant la miniature de photo est ajouté au tableau photos à l'aide de la méthode push()
                      imageSource: img,
                      reference: ref,
                      categorie: cat
                  });
              });

              // Trouve l'index de la photo actuelle
              const currentPhotoIndex = photos.findIndex(function (photo) {  //la méthode findIndex() recherche un élément dans le tableau photos qui satisfait une condition spécifiée dans la fonction de rappel.
                  return photo.imageSource === imageSource;  //vérifie si la valeur de la propriété imageSource de chaque objet photo dans le tableau photos est égale à la valeur de la variable imageSource
              });

              remplirRef (imageSource, photoRef, photoCat, photos, currentPhotoIndex);  //remplit les éléments de la lightbox avec les données de la photo actuellement affichée et gère les liens de navigation précédents et suivants
              openLightbox();
          });
      });
  }

  function remplirRef (imageSource, photoRef, photoCat, photos, currentPhotoIndex) {
      // Récupére les éléments à remplir automatiquement

      console.log("remplirRef");
      const lightboxImage = document.getElementById('lightboxImage');
      const lightboxReference = document.querySelector('.lightbox__reference');
      const lightboxCategorie = document.querySelector('.lightbox__categorie');

      // Rempli les éléments de la lightbox avec les données de la photo actuelle
      lightboxImage.src = imageSource;
      lightboxReference.textContent = photoRef;
      lightboxCategorie.textContent = photoCat;

      // Gestion des liens de navigation
      const prevLink = document.querySelector('.lightbox__prev');
      if (prevLink) {
          prevLink.addEventListener('click', function (event) {
              event.preventDefault();
              currentPhotoIndex--;                     // decremente l'index de la photo
              if (currentPhotoIndex < 0) {
                  currentPhotoIndex = photos.length -1;
              }
              const photo = photos[currentPhotoIndex];  //recuperation de la photo a afficher
              remplirRef(photo.imageSource, photo.reference, photo.categorie, photos, currentPhotoIndex);
          });
      }

      const nextLink = document.querySelector('.lightbox__next');
      if (nextLink) {
          nextLink.addEventListener('click', function (event) {
              event.preventDefault();
              currentPhotoIndex++;
              if (currentPhotoIndex >= photos.length) {
                  currentPhotoIndex = 0;
              }
              const photo = photos[currentPhotoIndex];
              remplirRef(photo.imageSource, photo.reference, photo.categorie, photos, currentPhotoIndex);
          });
      }
  }
  
  document.addEventListener('DOMContentLoaded', function() {

  initLightbox();  

});