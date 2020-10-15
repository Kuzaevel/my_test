// ==UserScript==
// @name         Move page up und down automaticly
// @namespace    http://tampermonkey.net/
// @version      0.1
// @description  try to take over the world!
// @author       You
// @match        http://vendorpa/srm/pages/kop/lot.php?id=246
// @grant        none
// ==/UserScript==

(function() {
    var t = true;
    const el_top = document.getElementById('notice_head');
    const el_bottom = document.getElementById('el2');
    setInterval(function() {
        if (t) {
            t = false;
            el_bottom.scrollIntoView({behavior: "smooth"});
        } else {
            t = true;
            el_top.scrollIntoView({behavior: "smooth"});
        }

    }, 10000);
})();