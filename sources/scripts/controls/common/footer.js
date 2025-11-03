var ABW = ABW || {};

ABW.FOOTER = {
    init: function (el, data) {
        this.el = $(el);
        this.initEvents();
    },

    initEvents() {
        this.el.find('.backtotop').on('click', this.scrollToTop.bind(this));
    },

    scrollToTop() {
        ABW.smoother.scrollTo(0);
    }
}