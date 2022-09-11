var theme = null;

document.addEventListener('DOMContentLoaded', () => {
    theme = document.getElementById("theme-changer").getAttribute("name"); // get theme name manifested by php
    setCookie("theme", theme);
    document.getElementById("theme-changer").addEventListener('click', () => rotateTheme()); // change theme on click
});

function setCookie(cookieName, cookieValue) { // set new cookie with expiration time of 1 year with strict privacy
    var d = new Date(); d.setTime(d.getTime() + (365*24*60*60*1000));
    document.cookie = `${cookieName}=${cookieValue};expires=${d.toUTCString()};SameSite=Lax;path=/`;
}

function rotateTheme() {
    themeGetter = new XMLHttpRequest();
    themeGetter.open('GET', "/css/themes/index.php", true);
    themeGetter.onload = function() {
        if (themeGetter.status === 200) {
            const lst = JSON.parse(themeGetter.responseText);
            const tmp = lst[((lst.indexOf(theme+".css")+1)%lst.length)].slice(0, -4);
            setCookie("theme", tmp);
            location.reload();
        }
    }
    themeGetter.send();
}