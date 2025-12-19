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