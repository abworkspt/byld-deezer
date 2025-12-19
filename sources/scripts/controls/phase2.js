var ABW = ABW || {};

ABW.PHASE2 = {
    init: function (el) {
        this.el = $(el);
        this.popup = $('#popup-vote');
        this.initEvents();
    },

    initEvents() {
        const _this = this;

        this.el.find('.js-open-vote').on('click', this.openPopup.bind(this));
        this.el.find('.copy-link').on('click', function (e) { _this.copyShareLink(e); });
        this.popup.find('.sendVote').on('click', this.submitVote.bind(this));
        this.popup.find('.check').on('click', this.checkBoces.bind(this));
        this.popup.find('.email-input').on('focus', this.clearError.bind(this));
        this.popup.find('.bg, .close, .js-close').on('click', this.closePopup.bind(this));
        //this.popup.on('click', this.clearError.bind(this));
    },

    openPopup(e) {
        e.preventDefault();
        this.popup.addClass('open');
    },

    closePopup(e) {
        e.preventDefault();
        this.popup.removeClass('open');
    },

    copyShareLink(e) {
        e.preventDefault();

        const url = window.location.href;

        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(url)
                .then(() => {
                    alert('Lien copié !');
                })
                .catch(() => {
                    alert("Impossible de copier le lien.");
                });
        } else {
            const temp = document.createElement('input');
            temp.value = url;
            document.body.appendChild(temp);
            temp.select();
            document.execCommand('copy');
            document.body.removeChild(temp);
            alert('Lien copié !');
        }
    },

    checkBoces(e) {
        console.log('checkBoces');
        var target = $(e.currentTarget);
        target.toggleClass('checked');
        const $error = this.popup.find('.error');
        $error.empty().hide();
    },

    clearError() {
        const $error = this.popup.find('.error');
        $error.empty().hide();
    },

    submitVote(e) {
        e.preventDefault();

        const $form = this.popup.find('#vote-form');
        const $error = this.popup.find('.error'); // div onde aparece a mensagem
        const email = $form.find('.email-input').val().trim();
        const $terms = this.popup.find('.js-terms');
        const $reg = this.popup.find('.js-reg');
        const $inside = this.popup.find('.inside');
        const $success = this.popup.find('.success');
        $error.empty().hide();

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const messages = [];

        if (!emailRegex.test(email)) {
            messages.push("Merci d'entrer une adresse email valide.");
            $error.html(messages).show();
            return;
        }

        /*if (!$terms.hasClass('checked')) {
            messages.push("Merci d'accepter de recevoir nos offres et informations commerciales.");
            $error.html(messages).show();
            return;
        }*/

        if (!$reg.hasClass('checked')) {
            messages.push("Merci d’accepter le réglement du concours et de certifier avoir plus de 18 ans.");
            $error.html(messages).show();
            return;
        }

        $.post(appapi.ajaxurl, $form.serialize(), function (res) {
            if (res.success) {
                //$error.removeClass('is-error').html(res.data.message).show();
                $inside.removeClass('show');
                $success.addClass('show');
            } else {
                $error.addClass('is-error').html(res.data.message).show();
            }
        });
    }


};