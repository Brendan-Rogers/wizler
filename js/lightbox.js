// JavaScript Document
(() => {

    //VARIABLE STACK
    let orgPosterImg = document.querySelectorAll('.orgPosterImg'),
        lightbox = document.querySelector('.lightbox'),
        close = document.querySelector('.closeLightbox'),
        body = document.querySelector('body'),
        lbImg = document.querySelector('.lbImg'),
        open = false,
        openLightbox = 0;


    //FUNCTIONS
    function showLightbox(poster) {
        console.log(poster.src);

    }

    function closeLightbox() {
        lightbox.classList.remove('showLightbox');
        body.classList.remove('scrollStop');
        open = false;
    }

    
    let posters = [];
    orgPosterImg.forEach(function(poster) {
        posters.push(poster);
    });

    for (var i = 0; i < posters.length; i++) {
        (function(index) {
             posters[index].addEventListener("click", function() {
                // console.log(posters[index]);
                open = true;
                lightbox.classList.add('showLightbox');
                body.classList.add('scrollStop');
                lbImg.src = posters[index].src;
                openLightbox = index--;
              })
        })(i);
     }


    //EVENT HANDLING
    close.addEventListener('click', closeLightbox);

    document.addEventListener("keyup", function(event) {
        // deprecate key
        const key = event.key || event.keyCode;

        if (key === 'Escape' || key === 'Esc' || key === 27 || key === 'Backspace' || key === 8) {
            closeLightbox();
        } else if (key === 'ArrowRight' || key === 39 && open == true) {
            // send that item DOWN
            open = true;
            lightbox.classList.add('showLightbox');
            body.classList.add('scrollStop');
            lbImg.src = posters[openLightbox++].src;
             
        } else if (key === 'ArrowLeft' || key === 37 && open == true) {
           // send that item DOWN
            open = true;
            lightbox.classList.add('showLightbox');
            body.classList.add('scrollStop');
            lbImg.src = posters[openLightbox--].src;
        }
    });



})();
