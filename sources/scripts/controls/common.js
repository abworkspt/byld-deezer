var ABW = ABW || {};

ABW.GLOBAL = {
    init: function (el, data) {
        this.el = $(el);
        this.initSmoothScroller();
    },

    initSmoothScroller() {
        ABW.smoother = ScrollSmoother.create({
            smooth: 1,
            effects: true,
            smoothTouch: true,
        });

        if (window.innerWidth <= 768) {
            ABW.smoother.kill();
        }

        window.addEventListener("load", () => ScrollTrigger.refresh());
    }
}