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