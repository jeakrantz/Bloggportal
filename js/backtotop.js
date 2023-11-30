/* 
*   Webbutveckling II - DT093G
*   Projektuppgift 
*   Blogg-portal
*
*   Utvecklare: Jeanette Krantz
*   2023-03-19
*/

'use strict';

/* Knapp som tar en tillbaka till toppen på sidan. Syns vid scrollning nedåt. */
let toTop = () => window.scrollTo({ top: 0, behavior: 'smooth' });
let btn = document.getElementById("totop-btn");
let lastScroll = 0;

window.onscroll = () => {

    let currentScroll = window.pageYOffset;

    if (currentScroll < lastScroll) {
        btn.style.display = "none";
    } else {
        btn.style.display = "block";
    }

    lastScroll = currentScroll;

}
