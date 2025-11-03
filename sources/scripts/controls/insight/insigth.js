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