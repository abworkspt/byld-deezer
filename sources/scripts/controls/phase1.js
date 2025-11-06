var ABW = ABW || {};

ABW.PHASE1 = {
    init: function (el) {
        this.el = $(el);
        this.initCountdown();
        this.initEvents();
    },

    initEvents() {
        this.el.find('.header .menu a').on('click', this.gotoArea.bind(this));
    },

    gotoArea(e) {
        e.preventDefault();
        const target = $(e.currentTarget);
        const href = target.attr('href');
        const dest = $(href);
        const targetY = dest[0].getBoundingClientRect().top + window.scrollY - 50;

        if (dest) {
            e.preventDefault();
            ABW.smoother.scrollTo(targetY, true);
        }
    },

    initCountdown() {
        const countdownEl = this.el.find('.countdown');
        const eventDate = countdownEl.data('date');

        const formattedDate = eventDate.replace(
            /(\d{2})\/(\d{2})\/(\d{4}) (.*)/,
            '$3-$2-$1T$4'
        );

        function updateCountdown() {
            const now = new Date().getTime();
            const target = new Date(formattedDate).getTime();
            const diff = target - now;


            if (diff <= 0) {
                countdownEl.text("00j 00h 00m");
                return;
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
            const minutes = Math.floor((diff / (1000 * 60)) % 60);

            countdownEl.text(
                `${days}j ${hours.toString().padStart(2, '0')}h ${minutes.toString().padStart(2, '0')}m`
            );
        }

        updateCountdown();
        setInterval(updateCountdown, 60000); // Atualiza a cada minuto
    }
};