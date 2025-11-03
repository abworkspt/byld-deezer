var ABW = ABW || {};

ABW.ADVOGADO = {
    init: function (el, data) {
        this.el = $(el);
        this.initScrollTrigger();
    },

    initScrollTrigger() {

        let mm = gsap.matchMedia();

        mm.add('(min-width: 769px)', () => {
            gsap.to('#advogado .image', {
                scrollTrigger: {
                    trigger: '#advogado .image',
                    start: 'top top',
                    end: '+=' + window.innerHeight,
                    pin: true,
                    scrub: true,
                    //markers: true
                },
                scale: 1
            });
        });
    }
}