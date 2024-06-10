// Fonction d'initialisation de la lightbox
function initLightbox() {
    
    const lightbox = document.getElementById('myLightbox');  
    const btnsFullscreen = document.querySelectorAll('.icon-fullscreen');  // Récupère tous les élements qui ouvre la lightbox   (on obtient un tableau) 
    const close = document.querySelector(".lightbox__close");  

    // Fonction pour ouvrir la lightbox
    function openLightbox() {
        lightbox.style.display = "block";
    }

    // Fonction pour fermer la lightbox
    function closeLightbox() {
        lightbox.style.display = "none";
    }
      
    // Ferme la lightbox quand l'utilisateur clique sur (x)
    close.onclick = closeLightbox; 

    // Itère sur chaque élément du tableau btnsFullscreen
    btnsFullscreen.forEach(function(btnFullscreen) {                       
        btnFullscreen.addEventListener('click', function(event) {          
            event.preventDefault();         // Empêche la navigation par défaut 

            // Récupère les valeurs de la photo spécifique
            const photoThumbnail = btnFullscreen.closest('.post-container').querySelector('.photo-thumbnail');  //sélectionnela miniature de la photo 
            const imageSource = photoThumbnail.querySelector('img').src;  // Extrait l'URL de la source de l'image                                      
            const photoRef = photoThumbnail.querySelector('.reference').innerHTML;                              
            const photoCat = photoThumbnail.querySelector('.categorie').innerHTML;                              

            // Crée un tableau de toutes les photos du groupe
            const photos = [];                                                          
            const photoItems = document.querySelectorAll('.photo-thumbnail');             
            photoItems.forEach(function (item) {     // Itère sur chaque élément de miniature de photo                                   
                const img = item.querySelector('img').src;
                const ref = item.querySelector('.reference').innerHTML;
                const cat = item.querySelector('.categorie').innerHTML;
                photos.push({     // Ajoute chaque objet représentant la miniature de photo au tableau photos            
                    imageSource: img,
                    reference: ref,
                    categorie: cat
                });
            });

            // Trouve l'index de la photo actuelle
            const currentPhotoIndex = photos.findIndex(function (photo) {  
                return photo.imageSource === imageSource;  //vérifie si l'URL de la source de l'image de la photo correspond à l'URL de la source de l'image de la miniature sur laquelle l'utilisateur a cliqué
            });

            remplirRef (imageSource, photoRef, photoCat, photos, currentPhotoIndex);  
            openLightbox(); //ouvre la lightbox
        });
    });
}
// Fonction pour remplir la lightbox avec les informations de la photo
function remplirRef (imageSource, photoRef, photoCat, photos, currentPhotoIndex) {
    const lightboxImage = document.getElementById('lightboxImage');
    const lightboxReference = document.querySelector('.lightbox__reference');
    const lightboxCategorie = document.querySelector('.lightbox__categorie');

    // Remplit les éléments de la lightbox avec les données de la photo actuelle
    lightboxImage.src = imageSource;
    lightboxReference.textContent = photoRef;
    lightboxCategorie.textContent = photoCat;

    // Gestion des liens de navigation
    const prevLink = document.querySelector('.lightbox__prev');
    if (prevLink) {
        prevLink.addEventListener('click', function (event) {
            event.preventDefault();
            currentPhotoIndex--; // Décrémente l'index de la photo
            if (currentPhotoIndex < 0) {
                currentPhotoIndex = photos.length -1;
            }
            const photo = photos[currentPhotoIndex];  // Récupère la photo à afficher
            remplirRef(photo.imageSource, photo.reference, photo.categorie, photos, currentPhotoIndex);
        });
      }

      const nextLink = document.querySelector('.lightbox__next');
      if (nextLink) {
        nextLink.addEventListener('click', function (event) {
            event.preventDefault();
            currentPhotoIndex++; // Incrémente l'index de la photo
            if (currentPhotoIndex >= photos.length) {
                currentPhotoIndex = 0;
            }
            const photo = photos[currentPhotoIndex];
            remplirRef(photo.imageSource, photo.reference, photo.categorie, photos, currentPhotoIndex);
        });
    }
}

// Initialise la lightbox une fois que le DOM est complètement chargé 
document.addEventListener('DOMContentLoaded', function() {
    initLightbox();  
});