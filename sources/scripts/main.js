var ABW = ABW || {};

ABW.MAIN = (function () {

    return {
        init: function () {
            $('[data-control]').each(function (index, elem) {
                var data = $(elem).data(),
                    control = data.control;

                if (!ABW[control]) return;

                if (typeof ABW[control] === 'function') {
                    var obj = new ABW[control]; obj.init(elem, data);
                } else if (typeof ABW[control] === 'object') {
                    ABW[control].init(elem, data);
                }
            });
        }
    }
})();

if (history.scrollRestoration) {
    history.scrollRestoration = 'manual';
} else {
    window.onbeforeunload = function () {
        window.scrollTo(0, 0);
    }
}

document.addEventListener("DOMContentLoaded", (event) => {
    gsap.registerPlugin(ScrollTrigger, ScrollSmoother)
    ABW.MAIN.init();
});