/* 
*   Webbutveckling II - DT093G
*   Projektuppgift 
*   Blogg-portal
*
*   Utvecklare: Jeanette Krantz
*   2023-03-19
*/

'use strict';
/* Göm/visa meny */

let menu_toggle = document.querySelector('.menu-toggle');
let sidebar = document.querySelector('.sidebar');

menu_toggle.addEventListener('click', () => {
    sidebar.classList.toggle('active');
})
