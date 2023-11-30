/* 
*   Webbutveckling II - DT093G
*   Projektuppgift 
*   Blogg-portal
*
*   Utvecklare: Jeanette Krantz
*   2023-03-19
*/

"use strict"

/* Visar popupen med specific post-id */
function showPopup(postid) {
    var popup = document.getElementById("popup");
    var deleteLink = document.getElementById("delete-link");
    deleteLink.href = "admin.php?deleteid=" + postid;
    popup.style.display = "block";
}

/* Tillbaka från popupen */
function hidePopup() {
    var popup = document.getElementById("popup");
    popup.style.display = "none";
}

/* Trycker man vid sidan av popupen stängs den.  */
window.onclick = (event) => {
    if (event.target == popup) {
        hidePopup();
    }
}




