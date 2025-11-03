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