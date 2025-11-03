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