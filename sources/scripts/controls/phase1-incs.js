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
    validateCidade() { return this._required(this.$cidade, 'Indique ta ville.'); },
    validateGrupo() { return this._required(this.$grupo, 'Indique le nom de ton groupe.'); },
    validateEstilo() { return this._required(this.$estilo, 'Indique ton style musical.'); },
    validateInsta() { const v = (this.$insta.val() || '').trim(), ok = /^@?[\w\.]{1,30}$/.test(v); return { $el: this.$insta, valid: ok, msg: ok ? '' : 'Handle Instagram invalide.' }; },
    validateDeezer() { const v = (this.$deezer.val() || '').trim(); try { new URL(v); return { $el: this.$deezer, valid: true, msg: '' } } catch (e) { return { $el: this.$deezer, valid: false, msg: 'Lien Deezer invalide.' } } },
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
        const $wrap = $el.closest('label, .consent, .zone');
        let $err = $wrap.find('.field-error');
        if (!$err.length) $err = $('<span class="field-error" aria-live="polite"></span>').appendTo($wrap);

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