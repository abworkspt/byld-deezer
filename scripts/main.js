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
            smoothTouch: true
        });

        if(window.innerWidth <= 768) {
            ABW.smoother.kill();
        }
    }
}
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
var ABW = ABW || {};

ABW.SITE_MENU = {
  init: function (el, data) {
    this.el = $(el);
    this.initEvents();
  },

  initEvents() {
    this.el.find('.menuhandle').on('click', this.toggleMenu.bind(this));
    this.el.find('.underlay').on('click', this.closeMenu.bind(this));
  },

  toggleMenu(e) {
    const content = this.el.find('.content');
    const underlay = this.el.find('.underlay');
    const handle = $(e.currentTarget);

    if (!content.hasClass('open')) {
      content.addClass('open');
      this.el.addClass('open');
      underlay.addClass('open');
      handle.addClass('open');
      if(window.innerWidth > 768) ABW.smoother.paused(true);
    } else {
      content.removeClass('open');
      handle.removeClass('open');
      this.el.removeClass('open');
      if(window.innerWidth > 768) ABW.smoother.paused(false);
    }
  },

  closeMenu(e) {   
    const content = this.el.find('.content');
    const underlay = this.el.find('.underlay');
    const handle = $(e.currentTarget);
    content.removeClass('open');
    underlay.removeClass('open');
    handle.removeClass('open');
    this.el.removeClass('open');
  }

}
var ABW = ABW || {};

ABW.ATUACAO_LIST = {
  init: function (el, data) {
    this.el = $(el);
    this.setupSizes();
    this.initEvents();
  },

  setupSizes() {
    this.el.find('.item').each(function () {
      $(this).find('.content').attr('data-h', $(this).find('.content').outerHeight());
      $(this).find('.content').addClass('nopadding');
    });

    setTimeout(function () {
      ScrollTrigger.refresh();
      ScrollTrigger.update();
    }, 500);
  },

  initEvents() {
    this.el.find('.item .top').on('click', this.toggleArea.bind(this));
  },

  toggleArea(e) {
    const content = $(e.currentTarget).parent().find('.content');
    const top = $(e.currentTarget).parent().find('.top');

    if (content.hasClass('open')) {
      content.height('0px');
      content.removeClass('open');
      top.removeClass('open');
    } else {

      this.el.find('.item .content').each(function (idx, el) {
        if (!$(this)[0].isEqualNode(content[0])) {
          $(this).height('0px');
          $(this).removeClass('open');
          $(this).parent().find('.top').removeClass('open');
        }
      });

      content.height(content.attr('data-h') + 'px');
      content.addClass('open');
      top.addClass('open');
    }

    setTimeout(function () {
      ScrollTrigger.refresh();
      ScrollTrigger.update();
    }, 500);

  }

}
var ABW = ABW || {};

ABW.AREAS_ATUACAO = {
  init: function (el, data) {
    this.el = $(el);
    this.setupSizes();
    this.initEvents();
  },

  setupSizes() {
    this.el.find('.item').each(function () {
      $(this).find('.content').attr('data-h', $(this).find('.content').outerHeight());
      $(this).find('.content').addClass('nopadding');

      setTimeout(function () {
        ScrollTrigger.refresh();
        ScrollTrigger.update();
      }, 500);
    });
  },

  initEvents() {
    this.el.find('.item .top').on('click', this.toggleArea.bind(this));
  },

  toggleArea(e) {
    const content = $(e.currentTarget).parent().find('.content');
    const top = $(e.currentTarget).parent().find('.top');

    if (content.hasClass('open')) {
      content.height('0px');
      content.removeClass('open');
      top.removeClass('open');
    } else {

      this.el.find('.item .content').each(function (idx, el) {
        if (!$(this)[0].isEqualNode(content[0])) {
          $(this).height('0px');
          $(this).removeClass('open');
          $(this).parent().find('.top').removeClass('open');
        }
      });

      content.height(content.attr('data-h') + 'px');
      content.addClass('open');
      top.addClass('open');
    }

    setTimeout(function () {
      ScrollTrigger.refresh();
      ScrollTrigger.update();
    }, 500);

  }

}
var ABW = ABW || {};

ABW.HOME_INSIGHTS = {
  init: function (el, data) {
    this.el = $(el);
    this.resizeBoxes();
    this.initEvents();
  },

  initEvents() {
    $(window).on('resize',  this.resizeBoxes.bind(this));
  },

  resizeBoxes() {
    this.el.find('.item').each(function() {
      $(this).height($(this).width());
    });
  }

}
var ABW = ABW || {};

ABW.CODIGOS_LISTA = {
  init: function (el, data) {
    this.el = $(el);
    this.setupSizes();
    this.initEvents();
  },

  setupSizes() {
    this.el.find('.item').each(function () {
      $(this).find('.content').attr('data-h', $(this).find('.content').outerHeight());
      $(this).find('.content').addClass('nopadding');
    });
  },

  initEvents() {
    this.el.find('.item .top').on('click', this.toggleArea.bind(this));
  },

  toggleArea(e) {
    const content = $(e.currentTarget).parent().find('.content');
    const top = $(e.currentTarget).parent().find('.top');

    if (content.hasClass('open')) {
      content.height('0px');
      content.removeClass('open');
      top.removeClass('open');
    } else {

      this.el.find('.item .content').each(function (idx, el) {
        if (!$(this)[0].isEqualNode(content[0])) {
          $(this).height('0px');
          $(this).removeClass('open');
          $(this).parent().find('.top').removeClass('open');
        }
      });

      content.height(content.attr('data-h') + 'px');
      content.addClass('open');
      top.addClass('open');
    }

  }

}
var ABW = ABW || {};

ABW.INSIGHT = {
  init: function (el, data) {
    this.el = $(el);
    this.to;
    this.initEvents();
  },

  initEvents() {
    this.el.find('.copy').on('click', this.copyUrl.bind(this));
  },

  async copyUrl(e) {
    e.preventDefault();
    const target = $(e.currentTarget);
    
    try {
      await navigator.clipboard.writeText(target.attr('href'));
      target.addClass('green');
      clearTimeout(this.to);
      this.to = setTimeout(function() {
        target.removeClass('green');
      }, 2000);

    } catch (err) {
      
    }
  } 
}