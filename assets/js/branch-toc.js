const gawIntensity = document.querySelector('[data-gaw-mode]');

// temp code for testing.
//console.log( gawIntensity.dataset.gawMode );
//gawIntensity.dataset.gawMode = "low";
//onsole.log( gawIntensity.dataset.gawMode );

async function main() {
    const sleep = (delay) => new Promise((resolve) => setTimeout(resolve, delay)),
        tocLink = document.querySelector('.toc-link'),
        blackOut = document.querySelector('.blackout'),
        toc = document.querySelector('.table-of-contents');

    let tocActive = 0;

    if ( tocLink !== null ) {
        tocLink.addEventListener( "click", function(event) {
            event.preventDefault();
            if ( 1 == tocActive ) {
                blackOut.classList.add('blackout-fading');
                setTimeout( function() {
                    blackOut.classList.remove('blackout-active');
                    blackOut.classList.remove('blackout-fading');
                    tocActive = 0;
                }, 500);
            } else {
                blackOut.classList.add('blackout-active');
                tocActive = 1;
            }
            toc.classList.toggle('table-of-contents-active');
        }, false);
    }
}
main()