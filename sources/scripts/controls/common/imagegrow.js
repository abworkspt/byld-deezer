var ABW = ABW || {};

ABW.IMAGEGROW = {
    init: function (el, data) {
        this.el = $(el);
        this.initScrollTrigger();
    },

    initScrollTrigger() {
        let mm = gsap.matchMedia();

        mm.add('(min-width: 769px)', () => {
            gsap.to('#home-contacto .imagegrow', {
                scrollTrigger: {
                    trigger: '#home-contacto',
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

ABW.ACTUACAO_IMAGEGROW = {
    init: function (el, data) {
        this.el = $(el);
        this.initScrollTrigger();
    },

    initScrollTrigger() {
        let mm = gsap.matchMedia();

        mm.add('(min-width: 769px)', () => {
            gsap.to('#atuacao-bloco .imagegrow', {
                scrollTrigger: {
                    trigger: '#atuacao-bloco',
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