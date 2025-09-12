import "./bootstrap";

import Alpine from "alpinejs";
import Plyr from "plyr";
import "plyr/dist/plyr.css";

window.Alpine = Alpine;

Alpine.start();

// Exponer inicializador para reproductores
window.initPlyr = (selector = ".js-player") => {
    const elements = document.querySelectorAll(selector);
    return Array.from(elements).map(
        (el) => new Plyr(el, { youtube: { rel: 0 } })
    );
};
