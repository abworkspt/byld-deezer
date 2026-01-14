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

ABW.GLOBAL = {
    init: function (el, data) {
        this.el = $(el);
        this.initSmoothScroller();
        this.checkCookie();
        this.initEvents();
    },

    checkCookie() {
        if (!this.getCookie('dezzerwebsite')) {
            $('#cookie-banner').removeClass('close');
        } else {
            this.loadMatomo();
        }
    },

    initEvents() {
        $('#cookie-banner .js-ok').on('click', this.acceptCookie.bind(this));
        $('#cookie-banner .js-notok').on('click', this.closeCookieBanner.bind(this));
    },

    acceptCookie(e) {
        e.preventDefault();
        this.setCookie('dezzerwebsite', '1', 365);
        this.loadMatomo();
        this.closeCookieBanner(e);
    },

    closeCookieBanner(e) {
        e.preventDefault();
        this.setCookie('dezzerwebsite', '1', 365);
        $('#cookie-banner').addClass('close');
    },

    setCookie(name, value, days) {
        const d = new Date();
        d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
        const expires = "expires=" + d.toUTCString();
        document.cookie = `${name}=${value};${expires};path=/`;
    },

    getCookie(name) {
        const cname = name + "=";
        const decoded = decodeURIComponent(document.cookie);
        const ca = decoded.split(';');
        for (let c of ca) {
            while (c.charAt(0) === ' ') c = c.substring(1);
            if (c.indexOf(cname) === 0) return c.substring(cname.length, c.length);
        }
        return "";
    },

    initSmoothScroller() {
        ABW.smoother = ScrollSmoother.create({
            smooth: 1,
            effects: true,
            smoothTouch: true,
        });

        if (window.innerWidth <= 768) {
            ABW.smoother.kill();
        }

        window.addEventListener("load", () => ScrollTrigger.refresh());
    },

    loadMatomo() {
        var _paq = window._paq = window._paq || [];
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        _paq.push(['setTrackerUrl', 'https://rocon.matomo.cloud/matomo.php']);
        _paq.push(['setSiteId', '1']);

        var g = document.createElement('script');
        g.async = true;
        g.src = 'https://cdn.matomo.cloud/rocon.matomo.cloud/matomo.js';
        document.head.appendChild(g);
    }
}

/*
<script>
		var _paq = window._paq = window._paq || [];
		_paq.push(['trackPageView']);
		_paq.push(['enableLinkTracking']);
		(function() {
			var u = "https://rocon.matomo.cloud/";
			_paq.push(['setTrackerUrl', u + 'matomo.php']);
			_paq.push(['setSiteId', '1']);
			var d = document,
				g = d.createElement('script'),
				s = d.getElementsByTagName('script')[0];
			g.async = true;
			g.src = 'https://cdn.matomo.cloud/rocon.matomo.cloud/matomo.js';
			s.parentNode.insertBefore(g, s);
		})();
	</script>
*/
var ABW = ABW || {};

ABW.INSCPHASE1 = {
    init: function (el) {
        this.$root = $(el);
        this.initVars();
        this.initEvents();
    },

    initVars() {
        this.$form = this.$root.find('form.insc-form');
        this.$submitcontainer = this.$root.find('.submit-container');
        this.$upload = this.$root.find('.insc-upload');
        this.$zone = this.$upload.find('.zone');
        this.$input = this.$upload.find('input[type="file"][name="fotos[]"]');
        this.$list = this.$upload.find('.file-list');
        if (!this.$list.length) this.$list = $('<div class="file-list" />').appendTo(this.$upload);

        this.$nome = this.$form.find('[name="nome"]');
        this.$apelido = this.$form.find('[name="apelido"]');
        this.$email = this.$form.find('[name="email"]');
        this.$tel = this.$form.find('[name="telefone"]');
        this.$nasc = this.$form.find('[name="nascimento"]');
        this.$cidade = this.$form.find('[name="cidade"]');
        this.$grupo = this.$form.find('[name="grupo"]');
        this.$estilo = this.$form.find('[name="estilo"]');
        this.$insta = this.$form.find('[name="instagram"]');
        this.$deezer = this.$form.find('[name="deezer"]');
        this.$desc = this.$form.find('[name="description_groupe"]');
        this.$consent = this.$form.find('[name="consent"]');

        this.maxFiles = 5;
        this.minFiles = 1;
        this.maxSize = 10 * 1024 * 1024;
        this.accept = ['image/jpeg', 'image/png'];
        this.allowSend = true;

        this.files = [];
        this.dtSupported = false;
        try { this.dt = new DataTransfer(); this.dtSupported = !!this.dt && !!this.dt.items; } catch (e) { this.dtSupported = false; }
    },

    initEvents() {
        const self = this;

        $('.js-insc-open').on('click', this.openModal.bind(this));
        $('.js-insc-close').on('click', this.closeModal.bind(this));

        this.$zone.on('click', () => this.$input.trigger('click'));
        this.$zone
            .on('dragenter dragover', e => { e.preventDefault(); e.stopPropagation(); this.$zone.addClass('dragover'); })
            .on('dragleave dragend', e => { e.preventDefault(); e.stopPropagation(); this.$zone.removeClass('dragover'); })
            .on('drop', e => {
                e.preventDefault(); e.stopPropagation();
                this.$zone.removeClass('dragover');
                this.addFiles(e.originalEvent.dataTransfer.files);
                this.updatePhotoValidity();
            });

        this.$input.on('change', (e) => {
            this.addFiles(e.target.files);
            e.target.value = '';
            this.updatePhotoValidity();
        });

        this.$list.on('click', '.remove', function () {
            const idx = Number($(this).closest('.file').data('idx'));
            self.removeAt(idx);
            self.updatePhotoValidity();
        });

        this.$form.on('submit', (e) => {
            e.preventDefault();
            if (!self.allowSend) return;
            self.allowSend = false;

            const ok = this.validateAll();
            if (!ok) { self.allowSend = true; return; }

            self.$submitcontainer.addClass('sending');

            const fd = new FormData(this.$form[0]);
            fd.delete('fotos[]');
            this.files.forEach(f => fd.append('fotos[]', f, f.name));

            fetch(this.$form.attr('action'), {
                method: 'POST',
                body: fd,
                credentials: 'same-origin'
            })
                .then(r => r.json())
                .then(json => {
                    if (json && json.success) {
                        self.$root.addClass("success");
                    } else {
                        const msg = (json && json.data && json.data.message) ? json.data.message : "Erreur lors de l'envoi.";
                        self.$submitcontainer.removeClass('sending');
                        alert(msg);
                    }
                    self.allowSend = true;
                })
                .catch(() => {
                    self.allowSend = true;
                    alert("Erreur lors de l'envoi.");
                });
        });

        const onBlurValidate = (sel, fn) => this.$form.on('blur change', sel, () => this.setFieldValidity(fn()));
        onBlurValidate('[name="nome"]', () => this.validateNome());
        onBlurValidate('[name="apelido"]', () => this.validateApelido());
        onBlurValidate('[name="email"]', () => this.validateEmail());
        onBlurValidate('[name="telefone"]', () => this.validateTel());
        onBlurValidate('[name="nascimento"]', () => this.validateNasc());
        onBlurValidate('[name="cidade"]', () => this.validateCidade());
        onBlurValidate('[name="grupo"]', () => this.validateGrupo());
        onBlurValidate('[name="estilo"]', () => this.validateEstilo());
        onBlurValidate('[name="instagram"]', () => this.validateInsta());
        onBlurValidate('[name="deezer"]', () => this.validateDeezer());
        onBlurValidate('[name="description_groupe"]', () => this.validateDesc());
        onBlurValidate('[name="consent"]', () => this.validateConsent());
    },

    openModal: function (e) {
        if (e && e.preventDefault) e.preventDefault();

        // smoother (se existir)
        var smoother = (window.ABW && ABW.smoother) ? ABW.smoother : null;

        // guarda posição atual
        this.scrollY = smoother ? smoother.scrollTop() :
            (window.pageYOffset || document.documentElement.scrollTop || 0);

        // pausa scroll do site
        if (smoother) { smoother.paused(true); }
        var wrap = document.getElementById('smooth-content');
        if (wrap) { wrap.classList.add('lock-scroll'); }

        // esconde a barra global (no <html>)
        document.documentElement.classList.add('modal-open');

        // abre overlay
        var ov = document.querySelector('.insc-overlay');
        if (ov) {
            ov.classList.add('open');
            ov.scrollTop = 0;
        }

        if (typeof _paq !== 'undefined') {
            _paq.push(['trackEvent', 'Modal', 'Ouverture', 'Inscription']);
        }
    },

    closeModal: function () {
        if (!this.allowSend) return;

        // fecha overlay
        var ov = document.querySelector('.insc-overlay');
        if (ov) { ov.classList.remove('open'); }

        // volta a mostrar a barra global
        document.documentElement.classList.remove('modal-open');

        // retoma scroll do site
        var smoother = (window.ABW && ABW.smoother) ? ABW.smoother : null;
        if (smoother) {
            var wrap = document.getElementById('smooth-content');
            if (wrap) { wrap.classList.remove('lock-scroll'); }
            smoother.paused(false);
            smoother.scrollTo(this.scrollY || 0, false);
        } else {
            window.scrollTo(0, this.scrollY || 0);
        }
    },


    addFiles(fileList) {
        const incoming = Array.from(fileList);
        for (const file of incoming) {
            if (this.files.length >= this.maxFiles) { this.flash('Maximum ' + this.maxFiles + ' photos.'); break; }
            if (!this.accept.includes(file.type)) { this.flash('Seulement JPG/PNG.'); continue; }
            if (file.size > this.maxSize) { this.flash('Chaque fichier doit être inférieur à 10 Mo.'); continue; }
            if (this.isDuplicate(file)) { this.flash('Fichier déjà ajouté ignoré.'); continue; }
            this.files.push(file);
        }
        this.syncInput();
        this.renderList();
    },

    removeAt(index) {
        if (index < 0 || index >= this.files.length) return;
        this.files.splice(index, 1);
        this.syncInput();
        this.renderList();
    },

    isDuplicate(file) {
        return this.files.some(f => f.name === file.name && f.size === file.size && f.lastModified === file.lastModified);
    },

    syncInput() {
        if (!this.dtSupported) return;
        this.dt = new DataTransfer();
        this.files.forEach(f => this.dt.items.add(f));
        this.$input[0].files = this.dt.files;
    },

    renderList() {
        this.$list.empty();
        if (!this.files.length) { this.$list.removeClass('has-items'); return; }
        this.$list.addClass('has-items');
        this.files.forEach((f, i) => {
            const url = URL.createObjectURL(f);
            const $item = $(`<div class="file" data-idx="${i}">
              <div class="thumb"><img alt=""></div>
              <div class="meta"><span class="name"></span><span class="size"></span></div>
              <button type="button" class="remove" aria-label="Supprimer">×</button>
            </div>`);
            $item.find('.name').text(f.name);
            $item.find('.size').text(this.humanSize(f.size));
            $item.find('img').attr('src', url).on('load', () => URL.revokeObjectURL(url));
            this.$list.append($item);
        });
    },

    humanSize(bytes) {
        if (bytes < 1024) return bytes + ' o';
        const kb = bytes / 1024;
        if (kb < 1024) return Math.round(kb) + ' Ko';
        return (kb / 1024).toFixed(2) + ' Mo';
    },

    flash(msg) {
        if (!msg) return;
        const $m = $('<div class="dz-msg" />').text(msg).appendTo(this.$zone);
        this.$zone.addClass('shake');
        setTimeout(() => { $m.fadeOut(150, () => $m.remove()); this.$zone.removeClass('shake'); }, 1300);
    },

    // ---------- VALIDAÇÕES ----------
    validateAll() {
        const results = [
            this.validateNome(),
            this.validateApelido(),
            this.validateEmail(),
            this.validateTel(),
            this.validateNasc(),
            this.validateCidade(),
            this.validateGrupo(),
            this.validateEstilo(),
            this.validateInsta(),
            this.validateDeezer(),
            this.validateDesc(),
            this.validateConsent(),
            this.validatePhotos()
        ];
        const firstError = results.find(r => !r.valid);
        if (firstError) {
            this.setFieldValidity(firstError);
            // $('html,body').stop().animate({ scrollTop: firstError.$el.offset().top - 120 }, 200);
            firstError.$el.trigger('focus');
            return false;
        }
        return true;
    },

    validateNome() { return this._required(this.$nome, 'Indique ton nom.'); },
    validateApelido() { return this._required(this.$apelido, 'Indique ton prénom.'); },
    validateEmail() { const v = (this.$email.val() || '').trim(), ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v); return { $el: this.$email, valid: ok, msg: ok ? '' : 'Email invalide.' }; },
    validateTel() { const v = (this.$tel.val() || '').trim(), ok = /^0[1-9](?:[ .-]?\d{2}){4}$/.test(v); return { $el: this.$tel, valid: ok, msg: ok ? '' : 'Numéro de téléphone invalide.' }; },
    validateNasc() { const v = (this.$nasc.val() || '').trim(); let ok = !!v, msg = 'Sélectionne ta date de naissance.'; if (ok) { const d = new Date(v); const age = this.calcAge(d); ok = !isNaN(d.getTime()) && age >= 18 && age <= 120; msg = ok ? '' : 'Âge minimum 18 ans.'; } return { $el: this.$nasc, valid: ok, msg }; },
    validateCidade() {
        const v = (this.$cidade.val() || '').trim();
        const ok = /^[0-9]{5}$/.test(v);
        return {
            $el: this.$cidade,
            valid: ok,
            msg: ok ? '' : 'Indique un code postal valide à 5 chiffres.'
        };
    },
    validateGrupo() { return this._required(this.$grupo, 'Indique le nom de ton groupe.'); },
    validateEstilo() { return this._required(this.$estilo, 'Indique ton style musical.'); },
    validateInsta() { const v = (this.$insta.val() || '').trim(), ok = /^@?[\w\.]{1,30}$/.test(v); return { $el: this.$insta, valid: ok, msg: ok ? '' : 'Handle Instagram invalide.' }; },
    validateDeezer() { const v = (this.$deezer.val() || '').trim(); try { new URL(v); return { $el: this.$deezer, valid: true, msg: '' } } catch (e) { return { $el: this.$deezer, valid: false, msg: 'Lien Deezer invalide.' } } },
    validateDesc() { return this._required(this.$desc, 'Décris ton groupe.'); },
    validateConsent() { const ok = this.$consent.is(':checked'); return { $el: this.$consent, valid: ok, msg: ok ? '' : 'Tu dois accepter le règlement.' }; },

    validatePhotos() {
        const count = this.files.length;
        const ok = count >= this.minFiles && count <= this.maxFiles;
        const msg = !count ? 'Ajoute au moins une photo.' :
            count > this.maxFiles ? 'Maximum ' + this.maxFiles + ' photos.' : '';
        return { $el: this.$zone, valid: ok, msg };
    },

    // Revalida/limpa o erro do upload sempre que a lista muda
    updatePhotoValidity() {
        const res = this.validatePhotos();
        this.setFieldValidity(res);
    },

    _required($el, msg) {
        const v = ($el.val() || '').trim();
        return { $el, valid: !!v, msg: !!v ? '' : msg };
    },

    calcAge(d) {
        const now = new Date();
        let age = now.getFullYear() - d.getFullYear();
        const m = now.getMonth() - d.getMonth();
        if (m < 0 || (m === 0 && now.getDate() < d.getDate())) age--;
        return age;
    },

    setFieldValidity(result) {
        const $el = result.$el;
        // inclui .insc-desc para o textarea e fallback para parent()
        let $wrap = $el.closest('label, .consent, .zone, .insc-desc');
        if (!$wrap.length) {
            $wrap = $el.parent();
        }

        let $err = $wrap.find('.field-error');
        if (!$err.length) {
            $err = $('<span class="field-error" aria-live="polite"></span>').appendTo($wrap);
        }

        if (result.valid) {
            $el.attr('aria-invalid', 'false');
            $wrap.removeClass('has-error');
            $err.text('');
        } else {
            $el.attr('aria-invalid', 'true');
            $wrap.addClass('has-error');
            $err.text(result.msg);
        }

        return result.valid;
    }

};
var ABW = ABW || {};

ABW.PHASE1 = {
    init: function (el) {
        this.el = $(el);
        this.initCountdown();
        this.initEvents();
    },

    initEvents() {
        //this.el.find('.header .menu a').on('click', this.gotoArea.bind(this));
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
var ABW = ABW || {};

ABW.PHASE2_COUNTDOWN = {
    init: function (el) {
        this.el = $(el);
        this.initCountdown();
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