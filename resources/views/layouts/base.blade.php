<!DOCTYPE html lang="vi">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
	<script>
		if (navigator.userAgent.match(/MSIE|Internet Explorer/i) || navigator.userAgent.match(/Trident\/7\..*?rv:11/i)) {
			var href = document.location.href;
			if (!href.match(/[?&]nowprocket/)) {
				if (href.indexOf("?") == -1) {
					if (href.indexOf("#") == -1) {
						document.location.href = href + "?nowprocket=1"
					} else {
						document.location.href = href.replace("#", "?nowprocket=1#")
					}
				} else {
					if (href.indexOf("#") == -1) {
						document.location.href = href + "&nowprocket=1"
					} else {
						document.location.href = href.replace("#", "&nowprocket=1#")
					}
				}
			}
		}
	</script>
	<script>
		class RocketLazyLoadScripts {
			constructor() {
				this.triggerEvents = ["keydown", "mousedown", "mousemove", "touchmove", "touchstart", "touchend", "wheel"], this.userEventHandler = this._triggerListener.bind(this), this.touchStartHandler = this._onTouchStart.bind(this), this.touchMoveHandler = this._onTouchMove.bind(this), this.touchEndHandler = this._onTouchEnd.bind(this), this.clickHandler = this._onClick.bind(this), this.interceptedClicks = [], window.addEventListener("pageshow", (e => {
					this.persisted = e.persisted
				})), window.addEventListener("DOMContentLoaded", (() => {
					this._preconnect3rdParties()
				})), this.delayedScripts = {
					normal: [],
					async: [],
					defer: []
				}, this.allJQueries = []
			}
			_addUserInteractionListener(e) {
				document.hidden ? e._triggerListener() : (this.triggerEvents.forEach((t => window.addEventListener(t, e.userEventHandler, {
					passive: !0
				}))), window.addEventListener("touchstart", e.touchStartHandler, {
					passive: !0
				}), window.addEventListener("mousedown", e.touchStartHandler), document.addEventListener("visibilitychange", e.userEventHandler))
			}
			_removeUserInteractionListener() {
				this.triggerEvents.forEach((e => window.removeEventListener(e, this.userEventHandler, {
					passive: !0
				}))), document.removeEventListener("visibilitychange", this.userEventHandler)
			}
			_onTouchStart(e) {
				"HTML" !== e.target.tagName && (window.addEventListener("touchend", this.touchEndHandler), window.addEventListener("mouseup", this.touchEndHandler), window.addEventListener("touchmove", this.touchMoveHandler, {
					passive: !0
				}), window.addEventListener("mousemove", this.touchMoveHandler), e.target.addEventListener("click", this.clickHandler), this._renameDOMAttribute(e.target, "onclick", "rocket-onclick"))
			}
			_onTouchMove(e) {
				window.removeEventListener("touchend", this.touchEndHandler), window.removeEventListener("mouseup", this.touchEndHandler), window.removeEventListener("touchmove", this.touchMoveHandler, {
					passive: !0
				}), window.removeEventListener("mousemove", this.touchMoveHandler), e.target.removeEventListener("click", this.clickHandler), this._renameDOMAttribute(e.target, "rocket-onclick", "onclick")
			}
			_onTouchEnd(e) {
				window.removeEventListener("touchend", this.touchEndHandler), window.removeEventListener("mouseup", this.touchEndHandler), window.removeEventListener("touchmove", this.touchMoveHandler, {
					passive: !0
				}), window.removeEventListener("mousemove", this.touchMoveHandler)
			}
			_onClick(e) {
				e.target.removeEventListener("click", this.clickHandler), this._renameDOMAttribute(e.target, "rocket-onclick", "onclick"), this.interceptedClicks.push(e), e.preventDefault(), e.stopPropagation(), e.stopImmediatePropagation()
			}
			_replayClicks() {
				window.removeEventListener("touchstart", this.touchStartHandler, {
					passive: !0
				}), window.removeEventListener("mousedown", this.touchStartHandler), this.interceptedClicks.forEach((e => {
					e.target.dispatchEvent(new MouseEvent("click", {
						view: e.view,
						bubbles: !0,
						cancelable: !0
					}))
				}))
			}
			_renameDOMAttribute(e, t, n) {
				e.hasAttribute && e.hasAttribute(t) && (event.target.setAttribute(n, event.target.getAttribute(t)), event.target.removeAttribute(t))
			}
			_triggerListener() {
				this._removeUserInteractionListener(this), "loading" === document.readyState ? document.addEventListener("DOMContentLoaded", this._loadEverythingNow.bind(this)) : this._loadEverythingNow()
			}
			_preconnect3rdParties() {
				let e = [];
				document.querySelectorAll("script[type=rocketlazyloadscript]").forEach((t => {
					if (t.hasAttribute("src")) {
						const n = new URL(t.src).origin;
						n !== location.origin && e.push({
							src: n,
							crossOrigin: t.crossOrigin || "module" === t.getAttribute("data-rocket-type")
						})
					}
				})), e = [...new Map(e.map((e => [JSON.stringify(e), e]))).values()], this._batchInjectResourceHints(e, "preconnect")
			}
			async _loadEverythingNow() {
				this.lastBreath = Date.now(), this._delayEventListeners(), this._delayJQueryReady(this), this._handleDocumentWrite(), this._registerAllDelayedScripts(), this._preloadAllScripts(), await this._loadScriptsFromList(this.delayedScripts.normal), await this._loadScriptsFromList(this.delayedScripts.defer), await this._loadScriptsFromList(this.delayedScripts.async);
				try {
					await this._triggerDOMContentLoaded(), await this._triggerWindowLoad()
				} catch (e) {}
				window.dispatchEvent(new Event("rocket-allScriptsLoaded")), this._replayClicks()
			}
			_registerAllDelayedScripts() {
				document.querySelectorAll("script[type=rocketlazyloadscript]").forEach((e => {
					e.hasAttribute("src") ? e.hasAttribute("async") && !1 !== e.async ? this.delayedScripts.async.push(e) : e.hasAttribute("defer") && !1 !== e.defer || "module" === e.getAttribute("data-rocket-type") ? this.delayedScripts.defer.push(e) : this.delayedScripts.normal.push(e) : this.delayedScripts.normal.push(e)
				}))
			}
			async _transformScript(e) {
				return await this._littleBreath(), new Promise((t => {
					const n = document.createElement("script");
					[...e.attributes].forEach((e => {
						let t = e.nodeName;
						"type" !== t && ("data-rocket-type" === t && (t = "type"), n.setAttribute(t, e.nodeValue))
					})), e.hasAttribute("src") ? (n.addEventListener("load", t), n.addEventListener("error", t)) : (n.text = e.text, t());
					try {
						e.parentNode.replaceChild(n, e)
					} catch (e) {
						t()
					}
				}))
			}
			async _loadScriptsFromList(e) {
				const t = e.shift();
				return t ? (await this._transformScript(t), this._loadScriptsFromList(e)) : Promise.resolve()
			}
			_preloadAllScripts() {
				this._batchInjectResourceHints([...this.delayedScripts.normal, ...this.delayedScripts.defer, ...this.delayedScripts.async], "preload")
			}
			_batchInjectResourceHints(e, t) {
				var n = document.createDocumentFragment();
				e.forEach((e => {
					if (e.src) {
						const i = document.createElement("link");
						i.href = e.src, i.rel = t, "preconnect" !== t && (i.as = "script"), e.getAttribute && "module" === e.getAttribute("data-rocket-type") && (i.crossOrigin = !0), e.crossOrigin && (i.crossOrigin = e.crossOrigin), n.appendChild(i)
					}
				})), document.head.appendChild(n)
			}
			_delayEventListeners() {
				let e = {};

				function t(t, n) {
					! function(t) {
						function n(n) {
							return e[t].eventsToRewrite.indexOf(n) >= 0 ? "rocket-" + n : n
						}
						e[t] || (e[t] = {
							originalFunctions: {
								add: t.addEventListener,
								remove: t.removeEventListener
							},
							eventsToRewrite: []
						}, t.addEventListener = function() {
							arguments[0] = n(arguments[0]), e[t].originalFunctions.add.apply(t, arguments)
						}, t.removeEventListener = function() {
							arguments[0] = n(arguments[0]), e[t].originalFunctions.remove.apply(t, arguments)
						})
					}(t), e[t].eventsToRewrite.push(n)
				}

				function n(e, t) {
					let n = e[t];
					Object.defineProperty(e, t, {
						get: () => n || function() {},
						set(i) {
							e["rocket" + t] = n = i
						}
					})
				}
				t(document, "DOMContentLoaded"), t(window, "DOMContentLoaded"), t(window, "load"), t(window, "pageshow"), t(document, "readystatechange"), n(document, "onreadystatechange"), n(window, "onload"), n(window, "onpageshow")
			}
			_delayJQueryReady(e) {
				let t = window.jQuery;
				Object.defineProperty(window, "jQuery", {
					get: () => t,
					set(n) {
						if (n && n.fn && !e.allJQueries.includes(n)) {
							n.fn.ready = n.fn.init.prototype.ready = function(t) {
								e.domReadyFired ? t.bind(document)(n) : document.addEventListener("rocket-DOMContentLoaded", (() => t.bind(document)(n)))
							};
							const t = n.fn.on;
							n.fn.on = n.fn.init.prototype.on = function() {
								if (this[0] === window) {
									function e(e) {
										return e.split(" ").map((e => "load" === e || 0 === e.indexOf("load.") ? "rocket-jquery-load" : e)).join(" ")
									}
									"string" == typeof arguments[0] || arguments[0] instanceof String ? arguments[0] = e(arguments[0]) : "object" == typeof arguments[0] && Object.keys(arguments[0]).forEach((t => {
										delete Object.assign(arguments[0], {
											[e(t)]: arguments[0][t]
										})[t]
									}))
								}
								return t.apply(this, arguments), this
							}, e.allJQueries.push(n)
						}
						t = n
					}
				})
			}
			async _triggerDOMContentLoaded() {
				this.domReadyFired = !0, await this._littleBreath(), document.dispatchEvent(new Event("rocket-DOMContentLoaded")), await this._littleBreath(), window.dispatchEvent(new Event("rocket-DOMContentLoaded")), await this._littleBreath(), document.dispatchEvent(new Event("rocket-readystatechange")), await this._littleBreath(), document.rocketonreadystatechange && document.rocketonreadystatechange()
			}
			async _triggerWindowLoad() {
				await this._littleBreath(), window.dispatchEvent(new Event("rocket-load")), await this._littleBreath(), window.rocketonload && window.rocketonload(), await this._littleBreath(), this.allJQueries.forEach((e => e(window).trigger("rocket-jquery-load"))), await this._littleBreath();
				const e = new Event("rocket-pageshow");
				e.persisted = this.persisted, window.dispatchEvent(e), await this._littleBreath(), window.rocketonpageshow && window.rocketonpageshow({
					persisted: this.persisted
				})
			}
			_handleDocumentWrite() {
				const e = new Map;
				document.write = document.writeln = function(t) {
					const n = document.currentScript,
						i = document.createRange(),
						r = n.parentElement;
					let o = e.get(n);
					void 0 === o && (o = n.nextSibling, e.set(n, o));
					const s = document.createDocumentFragment();
					i.setStart(s, 0), s.appendChild(i.createContextualFragment(t)), r.insertBefore(s, o)
				}
			}
			async _littleBreath() {
				Date.now() - this.lastBreath > 45 && (await this._requestAnimFrame(), this.lastBreath = Date.now())
			}
			async _requestAnimFrame() {
				return document.hidden ? new Promise((e => setTimeout(e))) : new Promise((e => requestAnimationFrame(e)))
			}
			static run() {
				const e = new RocketLazyLoadScripts;
				e._addUserInteractionListener(e)
			}
		}
		RocketLazyLoadScripts.run();
	</script>
	<!-- Google Search Console Quy-->
	<meta name="google-site-verification" content="iiE5x4NNQZDh3sY9fLH667rkmJ-tB09gg9HKj34-APA" />
	<!-- End Google Search Console Quy-->
	<!-- Pnterest Quy-->
	<meta name="p:domain_verify" content="fe69d5adcdd65b58365325203519d196" />
	<!-- End Pinterest Quy-->
	<meta name="google-site-verification" content="-TWdGzuQR7iiWLhhZUvSN4BK2dKiP1a228KuqxACi_c" />

	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta name="description" content="Lạc Gia là đơn vị uy tín hàng đầu chuyên thiết kế và thi công nội thất gỗ óc chó cho biệt thự, chung cư, khách sạn... Mang đến những trải nghiệm tốt nhất, không gian hiện đại, sang trọng." />
	<title>
		Nội Thất Lạc Gia - Thiết Kế và Thi Công Nội Thất Gỗ Óc Chó </title>
	<style id="rocket-critical-css">
		ol,
		ul {
			box-sizing: border-box
		}

		:root {
			--wp--preset--font-size--normal: 16px;
			--wp--preset--font-size--huge: 42px
		}

		html {
			font-family: sans-serif;
			-webkit-text-size-adjust: 100%;
			-ms-text-size-adjust: 100%
		}

		body {
			margin: 0
		}

		nav {
			display: block
		}

		a {
			background-color: transparent
		}

		strong {
			font-weight: 700
		}

		img {
			border: 0
		}

		input {
			margin: 0;
			font: inherit;
			color: inherit
		}

		input[type=submit] {
			-webkit-appearance: button
		}

		input::-moz-focus-inner {
			padding: 0;
			border: 0
		}

		input {
			line-height: normal
		}

		.glyphicon {
			position: relative;
			top: 1px;
			display: inline-block;
			font-family: 'Glyphicons Halflings';
			font-style: normal;
			font-weight: 400;
			line-height: 1;
			-webkit-font-smoothing: antialiased;
			-moz-osx-font-smoothing: grayscale
		}

		.glyphicon-chevron-left:before {
			content: "\e079"
		}

		.glyphicon-chevron-right:before {
			content: "\e080"
		}

		* {
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box
		}

		:after,
		:before {
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box
		}

		html {
			font-size: 10px
		}

		body {
			font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
			font-size: 14px;
			line-height: 1.42857143;
			color: #333;
			background-color: #fff
		}

		input {
			font-family: inherit;
			font-size: inherit;
			line-height: inherit
		}

		a {
			color: #ffffff;
			text-decoration: none
		}

		img {
			vertical-align: middle
		}

		.img-responsive {
			display: block;
			max-width: 100%;
			height: auto
		}

		.sr-only {
			position: absolute;
			width: 1px;
			height: 1px;
			padding: 0;
			margin: -1px;
			overflow: hidden;
			clip: rect(0, 0, 0, 0);
			border: 0
		}

		h2,
		h3 {
			font-family: inherit;
			font-weight: 500;
			line-height: 1.1;
			color: inherit
		}

		h2,
		h3 {
			margin-top: 20px;
			margin-bottom: 10px
		}

		h2 {
			font-size: 30px
		}

		h3 {
			font-size: 20px
		}

		p {
			margin: 0 0 10px
		}

		.text-center {
			text-align: center
		}

		ol,
		ul {
			margin-top: 0;
			margin-bottom: 10px
		}

		ul ul {
			margin-bottom: 0
		}

		.container {
			padding-right: 15px;
			padding-left: 15px;
			margin-right: auto;
			margin-left: auto
		}

		@media (min-width:768px) {
			.container {
				width: 750px
			}
		}

		@media (min-width:992px) {
			.container {
				width: 970px
			}
		}

		@media (min-width:1200px) {
			.container {
				width: 1170px
			}
		}

		.container-fluid {
			padding-right: 15px;
			padding-left: 15px;
			margin-right: auto;
			margin-left: auto
		}

		.row {
			margin-right: -15px;
			margin-left: -15px
		}

		.col-md-1,
		.col-md-2,
		.col-md-6,
		.col-md-9,
		.col-sm-1,
		.col-sm-4 {
			position: relative;
			min-height: 1px;
			padding-right: 15px;
			padding-left: 15px
		}

		@media (min-width:768px) {

			.col-sm-1,
			.col-sm-4 {
				float: left
			}

			.col-sm-4 {
				width: 33.33333333%
			}

			.col-sm-1 {
				width: 8.33333333%
			}
		}

		@media (min-width:992px) {

			.col-md-1,
			.col-md-2,
			.col-md-6,
			.col-md-9 {
				float: left
			}

			.col-md-9 {
				width: 75%
			}

			.col-md-6 {
				width: 50%
			}

			.col-md-2 {
				width: 16.66666667%
			}

			.col-md-1 {
				width: 8.33333333%
			}
		}

		label {
			display: inline-block;
			max-width: 100%;
			margin-bottom: 5px;
			font-weight: 700
		}

		.btn {
			display: inline-block;
			padding: 6px 12px;
			margin-bottom: 0;
			font-size: 14px;
			font-weight: 400;
			line-height: 1.42857143;
			text-align: center;
			white-space: nowrap;
			vertical-align: middle;
			-ms-touch-action: manipulation;
			touch-action: manipulation;
			background-image: none;
			border: 1px solid transparent;
			border-radius: 4px
		}

		.btn-primary {
			color: #fff;
			background-color: #ff8a00;
			border-color: #2e6da4
		}

		.collapse {
			display: none
		}

		.dropdown {
			position: relative
		}

		.dropdown-menu {
			position: absolute;
			top: 100%;
			left: 0;
			z-index: 1000;
			display: none;
			float: left;
			min-width: 160px;
			padding: 5px 0;
			margin: 2px 0 0;
			font-size: 14px;
			text-align: left;
			list-style: none;
			background-color: #fff;
			-webkit-background-clip: padding-box;
			background-clip: padding-box;
			border: 1px solid #ccc;
			border: 1px solid rgba(0, 0, 0, .15);
			border-radius: 4px;
			-webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
			box-shadow: 0 6px 12px rgba(0, 0, 0, .175)
		}

		.dropdown-menu>li>a {
			display: block;
			padding: 3px 20px;
			clear: both;
			font-weight: 400;
			line-height: 1.42857143;
			color: #333;
			white-space: nowrap
		}

		.nav {
			padding-left: 0;
			margin-bottom: 0;
			list-style: none
		}

		.nav>li {
			position: relative;
			display: block
		}

		.nav>li>a {
			position: relative;
			display: block;
			padding: 10px 15px
		}

		.navbar {
			position: relative;
			min-height: 50px;
			margin-bottom: 20px;
			border: 1px solid transparent
		}

		@media (min-width:768px) {
			.navbar {
				border-radius: 4px
			}
		}

		.navbar-collapse {
			padding-right: 15px;
			padding-left: 15px;
			overflow-x: visible;
			-webkit-overflow-scrolling: touch;
			border-top: 1px solid transparent;
			-webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, .1);
			box-shadow: inset 0 1px 0 rgba(255, 255, 255, .1)
		}

		@media (min-width:768px) {
			.navbar-collapse {
				width: auto;
				border-top: 0;
				-webkit-box-shadow: none;
				box-shadow: none
			}

			.navbar-collapse.collapse {
				display: block !important;
				height: auto !important;
				padding-bottom: 0;
				overflow: visible !important
			}
		}

		.navbar-nav {
			margin: 7.5px -15px
		}

		.navbar-nav>li>a {
			padding-top: 10px;
			padding-bottom: 10px;
			line-height: 20px
		}

		@media (min-width:768px) {
			.navbar-nav {
				float: left;
				margin: 0
			}

			.navbar-nav>li {
				float: left
			}

			.navbar-nav>li>a {
				padding-top: 15px;
				padding-bottom: 15px
			}
		}

		.navbar-nav>li>.dropdown-menu {
			margin-top: 0;
			border-top-left-radius: 0;
			border-top-right-radius: 0
		}

		.navbar-default {
			background-color: #f8f8f8;
			border-color: #e7e7e7
		}

		.navbar-default .navbar-nav>li>a {
			color: #777
		}

		.navbar-default .navbar-nav>.active>a {
			color: #555;
			background-color: #e7e7e7
		}

		.navbar-default .navbar-collapse {
			border-color: #e7e7e7
		}

		.carousel {
			position: relative
		}

		.carousel-inner {
			position: relative;
			width: 100%;
			overflow: hidden
		}

		.carousel-inner>.item {
			position: relative;
			display: none
		}

		@media all and (transform-3d),
		(-webkit-transform-3d) {
			.carousel-inner>.item {
				-webkit-backface-visibility: hidden;
				backface-visibility: hidden;
				-webkit-perspective: 1000px;
				perspective: 1000px
			}

			.carousel-inner>.item.active {
				left: 0;
				-webkit-transform: translate3d(0, 0, 0);
				transform: translate3d(0, 0, 0)
			}
		}

		.carousel-inner>.active {
			display: block
		}

		.carousel-inner>.active {
			left: 0
		}

		.carousel-control {
			position: absolute;
			top: 0;
			bottom: 0;
			left: 0;
			width: 15%;
			font-size: 20px;
			color: #fff;
			text-align: center;
			text-shadow: 0 1px 2px rgba(0, 0, 0, .6);
			background-color: rgba(0, 0, 0, 0);
			filter: alpha(opacity=50);
			opacity: .5
		}

		.carousel-control.left {
			background-image: -webkit-linear-gradient(left, rgba(0, 0, 0, .5) 0, rgba(0, 0, 0, .0001) 100%);
			background-image: -o-linear-gradient(left, rgba(0, 0, 0, .5) 0, rgba(0, 0, 0, .0001) 100%);
			background-image: -webkit-gradient(linear, left top, right top, from(rgba(0, 0, 0, .5)), to(rgba(0, 0, 0, .0001)));
			background-image: linear-gradient(to right, rgba(0, 0, 0, .5) 0, rgba(0, 0, 0, .0001) 100%);
			filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#80000000', endColorstr='#00000000', GradientType=1);
			background-repeat: repeat-x
		}

		.carousel-control.right {
			right: 0;
			left: auto;
			background-image: -webkit-linear-gradient(left, rgba(0, 0, 0, .0001) 0, rgba(0, 0, 0, .5) 100%);
			background-image: -o-linear-gradient(left, rgba(0, 0, 0, .0001) 0, rgba(0, 0, 0, .5) 100%);
			background-image: -webkit-gradient(linear, left top, right top, from(rgba(0, 0, 0, .0001)), to(rgba(0, 0, 0, .5)));
			background-image: linear-gradient(to right, rgba(0, 0, 0, .0001) 0, rgba(0, 0, 0, .5) 100%);
			filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00000000', endColorstr='#80000000', GradientType=1);
			background-repeat: repeat-x
		}

		.carousel-control .glyphicon-chevron-left,
		.carousel-control .glyphicon-chevron-right {
			position: absolute;
			top: 50%;
			z-index: 5;
			display: inline-block;
			margin-top: -10px
		}

		.carousel-control .glyphicon-chevron-left {
			left: 50%;
			margin-left: -10px
		}

		.carousel-control .glyphicon-chevron-right {
			right: 50%;
			margin-right: -10px
		}

		.carousel-indicators {
			position: absolute;
			bottom: 10px;
			left: 50%;
			z-index: 15;
			width: 60%;
			padding-left: 0;
			margin-left: -30%;
			text-align: center;
			list-style: none
		}

		.carousel-indicators li {
			display: inline-block;
			width: 10px;
			height: 10px;
			margin: 1px;
			text-indent: -999px;
			background-color: #000\9;
			background-color: rgba(0, 0, 0, 0);
			border: 1px solid #fff;
			border-radius: 10px
		}

		@media screen and (min-width:768px) {

			.carousel-control .glyphicon-chevron-left,
			.carousel-control .glyphicon-chevron-right {
				width: 30px;
				height: 30px;
				margin-top: -10px;
				font-size: 30px
			}

			.carousel-control .glyphicon-chevron-left {
				margin-left: -10px
			}

			.carousel-control .glyphicon-chevron-right {
				margin-right: -10px
			}

			.carousel-indicators {
				bottom: 20px
			}
		}

		.container-fluid:after,
		.container-fluid:before,
		.container:after,
		.container:before,
		.nav:after,
		.nav:before,
		.navbar-collapse:after,
		.navbar-collapse:before,
		.navbar:after,
		.navbar:before,
		.row:after,
		.row:before {
			display: table;
			content: " "
		}

		.container-fluid:after,
		.container:after,
		.nav:after,
		.navbar-collapse:after,
		.navbar:after,
		.row:after {
			clear: both
		}

		.hidden {
			display: none !important
		}

		@-ms-viewport {
			width: device-width
		}

		@media (max-width:767px) {
			.hidden-xs {
				display: none !important
			}
		}

		@media (min-width:768px) and (max-width:991px) {
			.hidden-sm {
				display: none !important
			}
		}

		@media (min-width:992px) and (max-width:1199px) {
			.hidden-md {
				display: none !important
			}
		}

		@media (min-width:1200px) {
			.hidden-lg {
				display: none !important
			}
		}

		.dropdown-menu .dropdown-menu {
			position: absolute;
			left: 100%;
			top: -3px
		}

		body,
		input {
			color: #333333;
			font-weight: 300;
			-webkit-font-smoothing: antialiased;
			-webkit-text-size-adjust: 100%;
			overflow-x: hidden
		}

		body {
			font-size: 14px;
			line-height: 1.6;
		}

		a {
			color: #ff8a00
		}

		ul {
			list-style: none;
			padding: 0;
			margin: 0
		}

		#header {
			position: fixed;
			padding: 8px 0;
			z-index: 9999;
			left: 0;
			right: 0;
			background-image: linear-gradient(#000000, #fff0)
		}

		#topmenu {
			background: transparent;
			margin-bottom: 0;
			border-radius: 0;
			border: none;
			float: right;
			position: unset;
			margin-top: 5px
		}

		.custom {
			position: unset
		}

		#topmenu ul.nav li a {
			color: #fff;
			text-transform: uppercase;
			font-weight: 600
		}

		#topmenu ul.nav li .dropdown-menu {
			padding-top: 0;
			padding-bottom: 0;
			border-radius: 0;
			-moz-border-radius: 0;
			-webkit-border-radius: 0;
			-o-border-radius: 0;
			min-width: 100%
		}

		#topmenu ul.nav li .dropdown-menu li a {
			padding: 10px 15px;
			white-space: nowrap;
			background: rgba(38, 21, 17, 0.5);
			color: #fff;
			text-transform: none !important
		}

		.dropdown-menu {
			background-color: transparent
		}

		#topmenu ul.nav .active a {
			color: #fe8900;
			font-weight: bold
		}

		#home_slider li a img {
			width: 100% !important
		}

		#to_top {
			position: fixed;
			top: 75%;
			right: 10px;
			transform: translateY(-50%);
			-moz-transform: translateY(-50%);
			-webkit-transform: translateY(-50%);
			-o-transform: translateY(-50%);
			z-index: 2000;
			display: none
		}

		#to_top a {
			padding: 12px 16px
		}

		.logo img {
			display: block;
			margin: auto;
			max-width: 100%;
			height: auto
		}

		div#to_top .btn.btn-primary {
			background: #f38301;
			border: none;
			border-radius: 100%
		}

		div#to_top .fa {
			font-size: 18px;
			color: #fff
		}

		#home_slider img {
			display: block;
			margin: auto;
			width: 100%;
			height: auto
		}

		#home_slider li {
			list-style: none
		}

		#home_slider .carousel-control {
			opacity: 1 !important;
			z-index: 300
		}

		#home_slider {
			position: relative
		}

		#home_slider .carousel-indicators {
			z-index: 99;
			bottom: 40px
		}

		#home_slider .carousel-indicators li {
			background-image: url(https://noithatlacgia.vn/wp-content/themes/lacgia/images/bgdothv.png);
			width: 15px !important;
			height: 15px !important;
			background-color: rgba(255, 255, 255, 0);
			border: none
		}

		h2.section-title {
			color: #333333;
			margin: 0 0 50px;
			position: relative;
			text-transform: uppercase;
			font-size: 24px;
			font-weight: bold
		}

		h2.section-title:after {
			display: none;
			content: '';
			margin: auto;
			position: absolute;
			left: 0;
			right: 0;
			bottom: -7px;
			height: 3px;
			width: 60px;
			background: #333333
		}

		.section-one {
			padding: 25px 0px;
			padding-top: 0
		}

		.lh_cotnent {
			text-align: justify;
			font-weight: 500
		}

		.sub_single_title .date {
			display: none;
			margin-right: 15px;
			font-weight: 300
		}

		.navbar-default .navbar-nav>.active>a {
			color: #555;
			background-color: transparent
		}

		.carousel-control.left,
		.carousel-control.right {
			background: transparent
		}

		.box_price {
			display: none;
			text-align: center;
			left: 0;
			right: 0;
			background: rgba(239, 225, 214, 0.5);
			font-size: 18px;
			font-weight: bold;
			color: #f00
		}

		.lh_img img {
			max-width: 100%;
			height: auto;
			display: block;
			margin: auto
		}

		.search {
			margin-top: 20px
		}

		.search .fa {
			font-size: 16px;
			color: #fff
		}

		.box_gt {
			display: inline-block;
			width: 100%
		}

		p.star {
			display: none;
			text-align: center
		}

		p.star .fa {
			color: #ffc107
		}

		.col-haflt {
			width: 50%;
			float: left;
			text-align: center;
			font-size: 16px
		}

		.col-haflt.sale {
			color: #666
		}

		.mega_col {
			width: 25%;
			float: left;
			padding: 0 1%;
			padding-top: 10px;
			overflow: hidden;
			padding-bottom: 10px
		}

		.box_menu_full {
			display: inline-block;
			width: 100%;
			background: rgba(38, 21, 17, 0.5);
			position: relative;
			z-index: 0
		}

		h3.mega_tax_title {
			font-size: 16px;
			text-transform: uppercase;
			font-weight: bold;
			margin: 15px 0;
			margin-bottom: 5px
		}

		.mega_list li a {
			background: transparent !important;
			display: inline-block;
			width: 100%;
			padding: 0 !important;
			font-size: 13px;
			font-weight: 300 !important
		}

		.mega_list li a:before {
			font-family: "FontAwesome";
			content: "\f00c";
			display: inline-block;
			margin: 0 10px 0 0;
			color: #000
		}

		.box_menu {
			background: #fff;
			min-height: 345px
		}

		.box_menu a {
			color: #000 !important
		}

		.box_menu.dark {
			background: transparent;
			min-height: 10px !important
		}

		.box_menu.dark a {
			color: #fff !important
		}

		.dark .mega_list li a:before {
			color: #fff
		}

		.mega_list {
			padding-left: 10px;
			padding-right: 10px
		}

		#product_box {
			padding-top: 3px
		}

		#topmenu ul.nav>li>.dropdown-menu {
			padding-top: 16px;
			box-shadow: none;
			border: none
		}

		#searchform {
			position: relative;
			margin-bottom: 0
		}

		input#searchsubmit {
			position: absolute;
			top: 1px;
			right: 0;
			padding: 2px 15px;
			border: none;
			background-image: url(https://noithatlacgia.vn/wp-content/themes/lacgia/images/icon-search.png);
			background-size: 100%;
			background-repeat: no-repeat;
			background-position: center center;
			outline: none
		}

		.box_s {
			position: fixed;
			padding-top: 30px;
			width: 350px;
			top: 0;
			bottom: 0;
			z-index: 9999;
			height: 100%;
			background: #321c15;
			padding: 15px;
			right: -350px
		}

		input#s {
			outline: none;
			padding-left: 10px;
			padding-right: 0;
			border: 2px solid rgb(239, 239, 239);
			width: 100%
		}

		.icon-search label {
			text-align: right;
			width: 100%
		}

		.col_box_gt {
			position: relative;
			height: 520px;
			overflow: hidden
		}

		.col_box_gt:after {
			content: '';
			position: absolute;
			z-index: 1;
			top: 11px;
			bottom: 11px;
			left: 11px;
			right: 11px;
			display: block;
			border-color: rgba(242, 242, 242, 0.64);
			border-style: solid;
			border-width: 1px
		}

		.col_box_gt.gt_left:after {
			border-color: rgba(194, 196, 200, 0.6)
		}

		.gt_left {
			background-image: url(https://noithatlacgia.vn/wp-content/themes/lacgia/images/home-3-boxed-left.jpg)
		}

		.box_gt_ent {
			padding: 13.2% 18% 12% 20.3%;
			position: relative;
			z-index: 9
		}

		.pd0 {
			padding: 0
		}

		.box_s_fast ul li {
			display: inline-block;
			padding: 5px 10px;
			color: #fff;
			border-radius: 30px;
			background: linear-gradient(to right, #c0954b, #e7bd74);
			background-size: 210% 100%;
			background-position: right bottom;
			border: 2px solid #e7bd74;
			margin: 5px
		}

		.box_s_fast ul li a {
			color: #fff
		}

		.box_s_fast {
			color: #fff
		}

		h3.sfast {
			margin: 0;
			font-size: 14px;
			padding: 10px 0;
			font-style: italic
		}

		p.close_search {
			font-size: 23px;
			color: #fff
		}

		.support-online {
			position: fixed;
			z-index: 999;
			left: 15px;
			top: 85%
		}

		.support-content {
			position: relative
		}

		.support-online a {
			display: block
		}

		.support-online a {
			position: relative;
			margin: 20px 10px;
			text-align: left;
			width: 40px;
			height: 40px
		}

		.support-online i {
			width: 40px;
			height: 40px;
			background: #f19e04;
			color: #fff;
			border-radius: 100%;
			font-size: 20px;
			text-align: center;
			line-height: 1.9;
			position: relative;
			z-index: 999
		}

		.kenit-alo-circle {
			width: 50px;
			height: 50px;
			top: -5px;
			right: -5px;
			position: absolute;
			background-color: transparent;
			-webkit-border-radius: 100%;
			-moz-border-radius: 100%;
			border-radius: 100%;
			border: 2px solid rgba(241, 158, 4, 0.4);
			opacity: .1;
			border-color: #0089B9;
			opacity: .5
		}

		.animated {
			-webkit-animation-fill-mode: both;
			-moz-animation-fill-mode: both;
			-ms-animation-fill-mode: both;
			-o-animation-fill-mode: both;
			animation-fill-mode: both;
			-webkit-animation-duration: 1s;
			-moz-animation-duration: 1s;
			-ms-animation-duration: 1s;
			-o-animation-duration: 1s;
			animation-duration: 1s
		}

		.animated {
			-webkit-animation-duration: 1s;
			animation-duration: 1s;
			-webkit-animation-fill-mode: both;
			animation-fill-mode: both
		}

		.animated.infinite {
			-webkit-animation-iteration-count: infinite;
			animation-iteration-count: infinite;
			-webkit-animation-timing-function: linear;
			animation-timing-function: linear
		}

		@-webkit-keyframes zoomIn {
			from {
				opacity: 0;
				-webkit-transform: scale3d(.3, .3, .3);
				transform: scale3d(.3, .3, .3)
			}

			50% {
				opacity: 1
			}
		}

		@keyframes zoomIn {
			from {
				opacity: 0;
				-webkit-transform: scale3d(.3, .3, .3);
				transform: scale3d(.3, .3, .3)
			}

			50% {
				opacity: 1
			}
		}

		.zoomIn {
			-webkit-animation-name: zoomIn;
			animation-name: zoomIn
		}

		.pulse {
			0% {
				-webkit-transform: scale(1)
			}

			50% {
				-webkit-transform: scale(1.1)
			}

			100% {
				-webkit-transform: scale(1);
				opacity: 1
			}
		}

		@-moz-keyframes pulse {
			0% {
				-moz-transform: scale(1)
			}

			50% {
				-moz-transform: scale(1.1)
			}

			100% {
				-moz-transform: scale(1);
				opacity: 1
			}
		}

		@-o-keyframes pulse {
			0% {
				-o-transform: scale(1)
			}

			50% {
				-o-transform: scale(1.1)
			}

			100% {
				-o-transform: scale(1);
				opacity: 1
			}
		}

		@keyframes pulse {
			0% {
				transform: scale(1)
			}

			50% {
				transform: scale(1.1)
			}

			100% {
				transform: scale(1);
				opacity: 1
			}
		}

		.pulse {
			-webkit-animation-name: pulse;
			-moz-animation-name: pulse;
			-o-animation-name: pulse;
			animation-name: pulse
		}

		.kenit-alo-circle-fill {
			width: 60px;
			height: 60px;
			top: -10px;
			position: absolute;
			-webkit-border-radius: 100%;
			-moz-border-radius: 100%;
			border-radius: 100%;
			border: 2px solid transparent;
			background-color: rgba(241, 158, 4, .5);
			opacity: .75;
			right: -10px
		}

		@-webkit-keyframes zoomIn {
			0% {
				opacity: 0;
				-webkit-transform: scale(.3);
				transform: scale(.3)
			}

			50% {
				opacity: 1
			}
		}

		.support-online a span {
			border-radius: 12px;
			text-align: center;
			background: #f19e04;
			padding: 9px;
			width: 120px;
			position: absolute;
			color: #fff;
			font-weight: bold;
			z-index: 999;
			top: 0px;
			left: 50px;
			-moz-animation: headerAnimation 0.7s 1;
			-webkit-animation: headerAnimation 0.7s 1;
			-o-animation: headerAnimation 0.7s 1;
			animation: headerAnimation 0.7s 1
		}

		.support-online a {
			display: block
		}

		.support-online a span:before {
			content: "";
			position: absolute;
			left: -10px;
			top: 10px;
			width: 0px;
			height: 0px;
			border-bottom: 10px solid transparent;
			border-top: 10px solid transparent;
			border-right: 10px solid #f19e04
		}

		.alo-floating {
			display: block;
			position: fixed;
			z-index: 9999;
			height: 40px;
			font-size: 14px;
			text-shadow: 1px 1px 0 #000;
			border-radius: 40px;
			max-width: 250px;
			overflow: hidden;
			text-overflow: ellipsis;
			padding: 0 10px;
			padding-left: 45px;
			background: url(https://noithatlacgia.vn/wp-content/themes/lacgia/images/icon-zalo.png) 8px center no-repeat, #009dff;
			background-size: 30px auto;
			bottom: 210px;
			left: 30px;
			line-height: 38px
		}

		.carousel-fade .carousel-inner .item {
			opacity: 0
		}

		.carousel-fade .carousel-inner .active {
			opacity: 1
		}

		#topmenu ul.nav li a {
			font-weight: 600;
			font-size: 14px
		}

		@media screen and (max-width:1200px) {
			#topmenu ul.nav li a {
				padding-left: 5px;
				padding-right: 5px;
				font-size: 12px
			}
		}

		@media screen and (max-width:992px) {
			#topmenu ul.nav li a {
				padding-top: 5px;
				padding-bottom: 5px
			}
		}

		@media screen and (max-width:767px) {
			.container {
				width: 425px
			}

			.alo-floating.alo-floating-zalo strong {
				display: none
			}

			#header {
				position: unset
			}

			.alo-floating {
				padding-left: 30px;
				bottom: 110px;
				left: 20px;
				background-position: center
			}

			.pd0 {
				padding: 0 15px
			}

			#home_slider .carousel-indicators {
				display: none
			}

			#home_slider .carousel .carousel-inner,
			#home_slider .carousel .carousel-inner .item,
			#home_slider .carousel {
				height: unset
			}

			.box_gt_ent {
				padding: 25px
			}

			.col_box_gt {
				height: unset;
				margin-bottom: 15px
			}

			.box_price {
				font-size: 12px
			}

			#header {
				padding-top: 5px;
				padding-bottom: 5px;
				background: #261511
			}

			#topmenu,
			.search {
				display: none
			}

			#header .logo {
				text-align: center;
				width: 100%
			}

			#header .logo img {
				height: 50px
			}

			i.fa.fa-bars {
				position: absolute;
				top: 20px;
				left: 15px;
				z-index: 9999;
				font-size: 19px;
				color: #fff
			}

			.lh_img {
				display: block
			}

			.box_gt {
				padding: 15px 0;
				padding-bottom: 0
			}

			.section-one {
				padding-bottom: 0
			}

			#page {
				position: relative
			}

			h2.section-title {
				margin-bottom: 20px;
				font-size: 18px;
				line-height: 1.4258
			}
		}

		@media screen and (max-width:480px) {
			.container {
				width: 360px
			}

			#topmenu ul.nav li a {
				padding-top: 3px;
				padding-bottom: 3px
			}
		}

		@media screen and (max-width:400px) {
			.container {
				width: calc(100% - 10px)
			}
		}

		@media screen and (min-width:1200px) and (max-width:1360px) {
			.container {
				width: 1222px !important
			}
		}

		@media screen and (min-width:996px) and (max-width:1024px) {
			.box_gt_ent {
				padding: 25px
			}

			.col_box_gt {
				height: 345px
			}

			.col_box_gt img {
				height: 345px
			}

			h2.section-title {
				margin-bottom: 25px
			}

			.logo {
				padding-top: 10px
			}
		}

		@media screen and (min-width:768px) and (max-width:995px) {
			.container {
				width: calc(100% - 30px)
			}

			nav#topmenu {
				display: none
			}

			.logo {
				width: 90%
			}

			.header span {
				position: absolute;
				color: #fff;
				font-size: 20px;
				top: 25px;
				z-index: 9999
			}

			.logo img {
				height: 60px
			}
		}

		@media screen and (min-width:1200px) and (max-width:1440px) {
			.col_box_gt {
				position: relative;
				height: 379px;
				overflow: hidden
			}

			.box_gt_ent {
				padding: 44px 50px;
				position: relative;
				z-index: 9
			}
		}

		@media screen and (max-width:768px) and (min-width:560px) {
			.alo-floating.alo-floating-zalo strong {
				display: none
			}

			.alo-floating {
				padding-left: 35px;
				bottom: 150px
			}
		}

		.dropdown-menu .dropdown-menu {
			position: absolute;
			left: 100%;
			top: -3px
		}


		body,
		input {
			color: #333333;
			font-weight: 300;
			-webkit-font-smoothing: antialiased;
			-webkit-text-size-adjust: 100%;
			overflow-x: hidden
		}

		body {
			font-size: 14px;
			line-height: 1.6;
		}

		a {
			color: #ff8a00
		}

		ul {
			list-style: none;
			padding: 0;
			margin: 0
		}

		#header {
			position: fixed;
			padding: 8px 0;
			z-index: 9999;
			left: 0;
			right: 0;
			background-image: linear-gradient(#000000, #fff0)
		}

		#topmenu {
			background: transparent;
			margin-bottom: 0;
			border-radius: 0;
			border: none;
			float: right;
			position: unset;
			margin-top: 5px
		}

		.custom {
			position: unset
		}

		#topmenu ul.nav li a {
			color: #fff;
			text-transform: uppercase;
			font-weight: 600
		}

		#topmenu ul.nav li .dropdown-menu {
			padding-top: 0;
			padding-bottom: 0;
			border-radius: 0;
			-moz-border-radius: 0;
			-webkit-border-radius: 0;
			-o-border-radius: 0;
			min-width: 100%
		}

		#topmenu ul.nav li .dropdown-menu li a {
			padding: 10px 15px;
			white-space: nowrap;
			background: rgba(38, 21, 17, 0.5);
			color: #fff;
			text-transform: none !important
		}

		.dropdown-menu {
			background-color: transparent
		}

		#topmenu ul.nav .active a {
			color: #fe8900;
			font-weight: bold
		}

		#home_slider li a img {
			width: 100% !important
		}

		#to_top {
			position: fixed;
			top: 75%;
			right: 10px;
			transform: translateY(-50%);
			-moz-transform: translateY(-50%);
			-webkit-transform: translateY(-50%);
			-o-transform: translateY(-50%);
			z-index: 2000;
			display: none
		}

		#to_top a {
			padding: 12px 16px
		}

		.logo img {
			display: block;
			margin: auto;
			max-width: 100%;
			height: auto
		}

		div#to_top .btn.btn-primary {
			background: #f38301;
			border: none;
			border-radius: 100%
		}

		div#to_top .fa {
			font-size: 18px;
			color: #fff
		}

		#home_slider img {
			display: block;
			margin: auto;
			width: 100%;
			height: auto
		}

		#home_slider li {
			list-style: none
		}

		#home_slider .carousel-control {
			opacity: 1 !important;
			z-index: 300
		}

		#home_slider {
			position: relative
		}

		#home_slider .carousel-indicators {
			z-index: 99;
			bottom: 40px
		}

		#home_slider .carousel-indicators li {
			background-image: url(https://noithatlacgia.vn/wp-content/themes/lacgia/images/bgdothv.png);
			width: 15px !important;
			height: 15px !important;
			background-color: rgba(255, 255, 255, 0);
			border: none
		}

		h2.section-title {
			color: #333333;
			margin: 0 0 50px;
			position: relative;
			text-transform: uppercase;
			font-size: 24px;
			font-weight: bold
		}

		h2.section-title:after {
			display: none;
			content: '';
			margin: auto;
			position: absolute;
			left: 0;
			right: 0;
			bottom: -7px;
			height: 3px;
			width: 60px;
			background: #333333
		}

		.section-one {
			padding: 25px 0px;
			padding-top: 0
		}

		.lh_cotnent {
			text-align: justify;
			font-weight: 500
		}

		.sub_single_title .date {
			display: none;
			margin-right: 15px;
			font-weight: 300
		}

		.navbar-default .navbar-nav>.active>a {
			color: #555;
			background-color: transparent
		}

		.carousel-control.left,
		.carousel-control.right {
			background: transparent
		}

		.box_price {
			display: none;
			text-align: center;
			left: 0;
			right: 0;
			background: rgba(239, 225, 214, 0.5);
			font-size: 18px;
			font-weight: bold;
			color: #f00
		}

		.lh_img img {
			max-width: 100%;
			height: auto;
			display: block;
			margin: auto
		}

		.search {
			margin-top: 20px
		}

		.search .fa {
			font-size: 16px;
			color: #fff
		}

		.box_gt {
			display: inline-block;
			width: 100%
		}

		p.star {
			display: none;
			text-align: center
		}

		p.star .fa {
			color: #ffc107
		}

		.col-haflt {
			width: 50%;
			float: left;
			text-align: center;
			font-size: 16px
		}

		.col-haflt.sale {
			color: #666
		}

		.mega_col {
			width: 25%;
			float: left;
			padding: 0 1%;
			padding-top: 10px;
			overflow: hidden;
			padding-bottom: 10px
		}

		.box_menu_full {
			display: inline-block;
			width: 100%;
			background: rgba(38, 21, 17, 0.5);
			position: relative;
			z-index: 0
		}

		h3.mega_tax_title {
			font-size: 16px;
			text-transform: uppercase;
			font-weight: bold;
			margin: 15px 0;
			margin-bottom: 5px
		}

		.mega_list li a {
			background: transparent !important;
			display: inline-block;
			width: 100%;
			padding: 0 !important;
			font-size: 13px;
			font-weight: 300 !important
		}

		.mega_list li a:before {
			font-family: "FontAwesome";
			content: "\f00c";
			display: inline-block;
			margin: 0 10px 0 0;
			color: #000
		}

		.box_menu {
			background: #fff;
			min-height: 345px
		}

		.box_menu a {
			color: #000 !important
		}

		.box_menu.dark {
			background: transparent;
			min-height: 10px !important
		}

		.box_menu.dark a {
			color: #fff !important
		}

		.dark .mega_list li a:before {
			color: #fff
		}

		.mega_list {
			padding-left: 10px;
			padding-right: 10px
		}

		#product_box {
			padding-top: 3px
		}

		#topmenu ul.nav>li>.dropdown-menu {
			padding-top: 16px;
			box-shadow: none;
			border: none
		}

		#searchform {
			position: relative;
			margin-bottom: 0
		}

		input#searchsubmit {
			position: absolute;
			top: 1px;
			right: 0;
			padding: 2px 15px;
			border: none;
			background-image: url(https://noithatlacgia.vn/wp-content/themes/lacgia/images/icon-search.png);
			background-size: 100%;
			background-repeat: no-repeat;
			background-position: center center;
			outline: none
		}

		.box_s {
			position: fixed;
			padding-top: 30px;
			width: 350px;
			top: 0;
			bottom: 0;
			z-index: 9999;
			height: 100%;
			background: #321c15;
			padding: 15px;
			right: -350px
		}

		input#s {
			outline: none;
			padding-left: 10px;
			padding-right: 0;
			border: 2px solid rgb(239, 239, 239);
			width: 100%
		}

		.icon-search label {
			text-align: right;
			width: 100%
		}

		.col_box_gt {
			position: relative;
			height: 520px;
			overflow: hidden
		}

		.col_box_gt:after {
			content: '';
			position: absolute;
			z-index: 1;
			top: 11px;
			bottom: 11px;
			left: 11px;
			right: 11px;
			display: block;
			border-color: rgba(242, 242, 242, 0.64);
			border-style: solid;
			border-width: 1px
		}

		.col_box_gt.gt_left:after {
			border-color: rgba(194, 196, 200, 0.6)
		}

		.gt_left {
			background-image: url(https://noithatlacgia.vn/wp-content/themes/lacgia/images/home-3-boxed-left.jpg)
		}

		.box_gt_ent {
			padding: 13.2% 18% 12% 20.3%;
			position: relative;
			z-index: 9
		}

		.pd0 {
			padding: 0
		}

		.box_s_fast ul li {
			display: inline-block;
			padding: 5px 10px;
			color: #fff;
			border-radius: 30px;
			background: linear-gradient(to right, #c0954b, #e7bd74);
			background-size: 210% 100%;
			background-position: right bottom;
			border: 2px solid #e7bd74;
			margin: 5px
		}

		.box_s_fast ul li a {
			color: #fff
		}

		.box_s_fast {
			color: #fff
		}

		h3.sfast {
			margin: 0;
			font-size: 14px;
			padding: 10px 0;
			font-style: italic
		}

		p.close_search {
			font-size: 23px;
			color: #fff
		}

		.support-online {
			position: fixed;
			z-index: 999;
			left: 15px;
			top: 85%
		}

		.support-content {
			position: relative
		}

		.support-online a {
			display: block
		}

		.support-online a {
			position: relative;
			margin: 20px 10px;
			text-align: left;
			width: 40px;
			height: 40px
		}

		.support-online i {
			width: 40px;
			height: 40px;
			background: #f19e04;
			color: #fff;
			border-radius: 100%;
			font-size: 20px;
			text-align: center;
			line-height: 1.9;
			position: relative;
			z-index: 999
		}

		.kenit-alo-circle {
			width: 50px;
			height: 50px;
			top: -5px;
			right: -5px;
			position: absolute;
			background-color: transparent;
			-webkit-border-radius: 100%;
			-moz-border-radius: 100%;
			border-radius: 100%;
			border: 2px solid rgba(241, 158, 4, 0.4);
			opacity: .1;
			border-color: #0089B9;
			opacity: .5
		}

		.animated {
			-webkit-animation-fill-mode: both;
			-moz-animation-fill-mode: both;
			-ms-animation-fill-mode: both;
			-o-animation-fill-mode: both;
			animation-fill-mode: both;
			-webkit-animation-duration: 1s;
			-moz-animation-duration: 1s;
			-ms-animation-duration: 1s;
			-o-animation-duration: 1s;
			animation-duration: 1s
		}

		.animated {
			-webkit-animation-duration: 1s;
			animation-duration: 1s;
			-webkit-animation-fill-mode: both;
			animation-fill-mode: both
		}

		.animated.infinite {
			-webkit-animation-iteration-count: infinite;
			animation-iteration-count: infinite;
			-webkit-animation-timing-function: linear;
			animation-timing-function: linear
		}

		@-webkit-keyframes zoomIn {
			from {
				opacity: 0;
				-webkit-transform: scale3d(.3, .3, .3);
				transform: scale3d(.3, .3, .3)
			}

			50% {
				opacity: 1
			}
		}

		@keyframes zoomIn {
			from {
				opacity: 0;
				-webkit-transform: scale3d(.3, .3, .3);
				transform: scale3d(.3, .3, .3)
			}

			50% {
				opacity: 1
			}
		}

		.zoomIn {
			-webkit-animation-name: zoomIn;
			animation-name: zoomIn
		}

		.pulse {
			0% {
				-webkit-transform: scale(1)
			}

			50% {
				-webkit-transform: scale(1.1)
			}

			100% {
				-webkit-transform: scale(1);
				opacity: 1
			}
		}

		@-moz-keyframes pulse {
			0% {
				-moz-transform: scale(1)
			}

			50% {
				-moz-transform: scale(1.1)
			}

			100% {
				-moz-transform: scale(1);
				opacity: 1
			}
		}

		@-o-keyframes pulse {
			0% {
				-o-transform: scale(1)
			}

			50% {
				-o-transform: scale(1.1)
			}

			100% {
				-o-transform: scale(1);
				opacity: 1
			}
		}

		@keyframes pulse {
			0% {
				transform: scale(1)
			}

			50% {
				transform: scale(1.1)
			}

			100% {
				transform: scale(1);
				opacity: 1
			}
		}

		.pulse {
			-webkit-animation-name: pulse;
			-moz-animation-name: pulse;
			-o-animation-name: pulse;
			animation-name: pulse
		}

		.kenit-alo-circle-fill {
			width: 60px;
			height: 60px;
			top: -10px;
			position: absolute;
			-webkit-border-radius: 100%;
			-moz-border-radius: 100%;
			border-radius: 100%;
			border: 2px solid transparent;
			background-color: rgba(241, 158, 4, .5);
			opacity: .75;
			right: -10px
		}

		@-webkit-keyframes zoomIn {
			0% {
				opacity: 0;
				-webkit-transform: scale(.3);
				transform: scale(.3)
			}

			50% {
				opacity: 1
			}
		}

		.support-online a span {
			border-radius: 12px;
			text-align: center;
			background: #f19e04;
			padding: 9px;
			width: 120px;
			position: absolute;
			color: #fff;
			font-weight: bold;
			z-index: 999;
			top: 0px;
			left: 50px;
			-moz-animation: headerAnimation 0.7s 1;
			-webkit-animation: headerAnimation 0.7s 1;
			-o-animation: headerAnimation 0.7s 1;
			animation: headerAnimation 0.7s 1
		}

		.support-online a {
			display: block
		}

		.support-online a span:before {
			content: "";
			position: absolute;
			left: -10px;
			top: 10px;
			width: 0px;
			height: 0px;
			border-bottom: 10px solid transparent;
			border-top: 10px solid transparent;
			border-right: 10px solid #f19e04
		}

		.alo-floating {
			display: block;
			position: fixed;
			z-index: 9999;
			height: 40px;
			font-size: 14px;
			text-shadow: 1px 1px 0 #000;
			border-radius: 40px;
			max-width: 250px;
			overflow: hidden;
			text-overflow: ellipsis;
			padding: 0 10px;
			padding-left: 45px;
			background: url(https://noithatlacgia.vn/wp-content/themes/lacgia/images/icon-zalo.png) 8px center no-repeat, #009dff;
			background-size: 30px auto;
			bottom: 210px;
			left: 30px;
			line-height: 38px
		}

		.carousel-fade .carousel-inner .item {
			opacity: 0
		}

		.carousel-fade .carousel-inner .active {
			opacity: 1
		}

		#topmenu ul.nav li a {
			font-weight: 600;
			font-size: 14px
		}

		@media screen and (max-width:1200px) {
			#topmenu ul.nav li a {
				padding-left: 5px;
				padding-right: 5px;
				font-size: 12px
			}
		}

		@media screen and (max-width:992px) {
			#topmenu ul.nav li a {
				padding-top: 5px;
				padding-bottom: 5px
			}
		}

		@media screen and (max-width:767px) {
			.container {
				width: 425px
			}

			.alo-floating.alo-floating-zalo strong {
				display: none
			}

			#header {
				position: unset
			}

			.alo-floating {
				padding-left: 30px;
				bottom: 110px;
				left: 20px;
				background-position: center
			}

			.pd0 {
				padding: 0 15px
			}

			#home_slider .carousel-indicators {
				display: none
			}

			#home_slider .carousel .carousel-inner,
			#home_slider .carousel .carousel-inner .item,
			#home_slider .carousel {
				height: unset
			}

			.box_gt_ent {
				padding: 25px
			}

			.col_box_gt {
				height: unset;
				margin-bottom: 15px
			}

			.box_price {
				font-size: 12px
			}

			#header {
				padding-top: 5px;
				padding-bottom: 5px;
				background: #261511
			}

			#topmenu,
			.search {
				display: none
			}

			#header .logo {
				text-align: center;
				width: 100%
			}

			#header .logo img {
				height: 50px
			}

			i.fa.fa-bars {
				position: absolute;
				top: 20px;
				left: 15px;
				z-index: 9999;
				font-size: 19px;
				color: #fff
			}

			.lh_img {
				display: block
			}

			.box_gt {
				padding: 15px 0;
				padding-bottom: 0
			}

			.section-one {
				padding-bottom: 0
			}

			#page {
				position: relative
			}

			h2.section-title {
				margin-bottom: 20px;
				font-size: 18px;
				line-height: 1.4258
			}
		}

		@media screen and (max-width:480px) {
			.container {
				width: 360px
			}

			#topmenu ul.nav li a {
				padding-top: 3px;
				padding-bottom: 3px
			}
		}

		@media screen and (max-width:400px) {
			.container {
				width: calc(100% - 10px)
			}
		}

		@media screen and (min-width:1200px) and (max-width:1360px) {
			.container {
				width: 1222px !important
			}
		}

		@media screen and (min-width:996px) and (max-width:1024px) {
			.box_gt_ent {
				padding: 25px
			}

			.col_box_gt {
				height: 345px
			}

			.col_box_gt img {
				height: 345px
			}

			h2.section-title {
				margin-bottom: 25px
			}

			.logo {
				padding-top: 10px
			}
		}

		@media screen and (min-width:768px) and (max-width:995px) {
			.container {
				width: calc(100% - 30px)
			}

			nav#topmenu {
				display: none
			}

			.logo {
				width: 90%
			}

			.header span {
				position: absolute;
				color: #fff;
				font-size: 20px;
				top: 25px;
				z-index: 9999
			}

			.logo img {
				height: 60px
			}
		}

		@media screen and (min-width:1200px) and (max-width:1440px) {
			.col_box_gt {
				position: relative;
				height: 379px;
				overflow: hidden
			}

			.box_gt_ent {
				padding: 44px 50px;
				position: relative;
				z-index: 9
			}
		}

		@media screen and (max-width:768px) and (min-width:560px) {
			.alo-floating.alo-floating-zalo strong {
				display: none
			}

			.alo-floating {
				padding-left: 35px;
				bottom: 150px
			}
		}
	</style>
	<meta name="keywords" content="" />
	<meta name="robots" content="noodp,index,follow" />
	<meta name='revisit-after' content='1 days' />
	<link rel="shortcut icon" href="https://noithatlacgia.vn/wp-content/uploads/2021/12/favicon.png">
	<link rel="profile" href="" />
	<link rel="pingback" href="https://noithatlacgia.vn/xmlrpc.php" />
	<!--[if lt IE 9]>
	<script src="https://noithatlacgia.vn/wp-content/themes/lacgia/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	<meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />

	<!-- This site is optimized with the Yoast SEO plugin v19.3 - https://yoast.com/wordpress/plugins/seo/ -->
	<title>Nội Thất Lạc Gia - Thiết Kế và Thi Công Nội Thất Gỗ Óc Chó</title>
	<meta name="description" content="Lạc Gia là đơn vị uy tín hàng đầu chuyên thiết kế và thi công nội thất gỗ óc chó cho biệt thự, chung cư, khách sạn... Mang đến những trải nghiệm tốt nhất, không gian hiện đại, sang trọng." />
	<link rel="canonical" href="https://noithatlacgia.vn/" />
	<meta property="og:locale" content="vi_VN" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="Nội Thất Lạc Gia - Thiết Kế và Thi Công Nội Thất Gỗ Óc Chó" />
	<meta property="og:description" content="Lạc Gia là đơn vị uy tín hàng đầu chuyên thiết kế và thi công nội thất gỗ óc chó cho biệt thự, chung cư, khách sạn... Mang đến những trải nghiệm tốt nhất, không gian hiện đại, sang trọng." />
	<meta property="og:url" content="https://noithatlacgia.vn/" />
	<meta property="og:site_name" content="Nội Thất Lạc Gia" />
	<meta property="article:modified_time" content="2023-03-31T04:43:47+00:00" />
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:label1" content="Ước tính thời gian đọc" />
	<meta name="twitter:data1" content="1 phút" />
	<script type="application/ld+json" class="yoast-schema-graph">
		{
			"@context": "https://schema.org",
			"@graph": [{
				"@type": "WebSite",
				"@id": "https://noithatlacgia.vn/#website",
				"url": "https://noithatlacgia.vn/",
				"name": "Nội Thất Lạc Gia",
				"description": "Thiết Kế và Thi Công Nội Thất Gỗ Tự Nhiên Hiện Đại",
				"potentialAction": [{
					"@type": "SearchAction",
					"target": {
						"@type": "EntryPoint",
						"urlTemplate": "https://noithatlacgia.vn/?s={search_term_string}"
					},
					"query-input": "required name=search_term_string"
				}],
				"inLanguage": "vi"
			}, {
				"@type": "ImageObject",
				"inLanguage": "vi",
				"@id": "https://noithatlacgia.vn/#primaryimage",
				"url": "https://noithatlacgia.vn/wp-content/uploads/2022/05/thiet-ke-noi-that-biet-thu-thong-tang-sang-trong-a-duong-10.jpg",
				"contentUrl": "https://noithatlacgia.vn/wp-content/uploads/2022/05/thiet-ke-noi-that-biet-thu-thong-tang-sang-trong-a-duong-10.jpg",
				"width": 1920,
				"height": 1280,
				"caption": "Thiết kế nội thất biệt thự thông tầng sang trọng A Dương - Bình Dương"
			}, {
				"@type": "WebPage",
				"@id": "https://noithatlacgia.vn/",
				"url": "https://noithatlacgia.vn/",
				"name": "Nội Thất Lạc Gia - Thiết Kế và Thi Công Nội Thất Gỗ Óc Chó",
				"isPartOf": {
					"@id": "https://noithatlacgia.vn/#website"
				},
				"primaryImageOfPage": {
					"@id": "https://noithatlacgia.vn/#primaryimage"
				},
				"datePublished": "2019-11-20T16:56:02+00:00",
				"dateModified": "2023-03-31T04:43:47+00:00",
				"description": "Lạc Gia là đơn vị uy tín hàng đầu chuyên thiết kế và thi công nội thất gỗ óc chó cho biệt thự, chung cư, khách sạn... Mang đến những trải nghiệm tốt nhất, không gian hiện đại, sang trọng.",
				"breadcrumb": {
					"@id": "https://noithatlacgia.vn/#breadcrumb"
				},
				"inLanguage": "vi",
				"potentialAction": [{
					"@type": "ReadAction",
					"target": ["https://noithatlacgia.vn/"]
				}]
			}, {
				"@type": "BreadcrumbList",
				"@id": "https://noithatlacgia.vn/#breadcrumb",
				"itemListElement": [{
					"@type": "ListItem",
					"position": 1,
					"name": "Home"
				}]
			}]
		}
	</script>
	<!-- / Yoast SEO plugin. -->


	<link rel='dns-prefetch' href='//s.w.org' />
	<link rel="alternate" type="application/rss+xml" title="Dòng thông tin Nội Thất Lạc Gia &raquo;" href="https://noithatlacgia.vn/feed/" />
	<link rel="alternate" type="application/rss+xml" title="Dòng phản hồi Nội Thất Lạc Gia &raquo;" href="https://noithatlacgia.vn/comments/feed/" />
	<link rel="alternate" type="application/rss+xml" title="Nội Thất Lạc Gia &raquo; Trang chủ Dòng phản hồi" href="https://noithatlacgia.vn/eldas-serum-te-bao-goc-thuong-hieu-noi-tieng-cua-han-quoc/feed/" />
	<script type="rocketlazyloadscript" data-rocket-type="text/javascript">
		window._wpemojiSettings = {"baseUrl":"https:\/\/s.w.org\/images\/core\/emoji\/14.0.0\/72x72\/","ext":".png","svgUrl":"https:\/\/s.w.org\/images\/core\/emoji\/14.0.0\/svg\/","svgExt":".svg","source":{"wpemoji":"https:\/\/noithatlacgia.vn\/wp-includes\/js\/wp-emoji.js?ver=6.0.3","twemoji":"https:\/\/noithatlacgia.vn\/wp-includes\/js\/twemoji.js?ver=6.0.3"}};
/**
 * @output wp-includes/js/wp-emoji-loader.js
 */

( function( window, document, settings ) {
	var src, ready, ii, tests;

	// Create a canvas element for testing native browser support of emoji.
	var canvas = document.createElement( 'canvas' );
	var context = canvas.getContext && canvas.getContext( '2d' );

	/**
	 * Checks if two sets of Emoji characters render the same visually.
	 *
	 * @since 4.9.0
	 *
	 * @private
	 *
	 * @param {number[]} set1 Set of Emoji character codes.
	 * @param {number[]} set2 Set of Emoji character codes.
	 *
	 * @return {boolean} True if the two sets render the same.
	 */
	function emojiSetsRenderIdentically( set1, set2 ) {
		var stringFromCharCode = String.fromCharCode;

		// Cleanup from previous test.
		context.clearRect( 0, 0, canvas.width, canvas.height );
		context.fillText( stringFromCharCode.apply( this, set1 ), 0, 0 );
		var rendered1 = canvas.toDataURL();

		// Cleanup from previous test.
		context.clearRect( 0, 0, canvas.width, canvas.height );
		context.fillText( stringFromCharCode.apply( this, set2 ), 0, 0 );
		var rendered2 = canvas.toDataURL();

		return rendered1 === rendered2;
	}

	/**
	 * Detects if the browser supports rendering emoji or flag emoji.
	 *
	 * Flag emoji are a single glyph made of two characters, so some browsers
	 * (notably, Firefox OS X) don't support them.
	 *
	 * @since 4.2.0
	 *
	 * @private
	 *
	 * @param {string} type Whether to test for support of "flag" or "emoji".
	 *
	 * @return {boolean} True if the browser can render emoji, false if it cannot.
	 */
	function browserSupportsEmoji( type ) {
		var isIdentical;

		if ( ! context || ! context.fillText ) {
			return false;
		}

		/*
		 * Chrome on OS X added native emoji rendering in M41. Unfortunately,
		 * it doesn't work when the font is bolder than 500 weight. So, we
		 * check for bold rendering support to avoid invisible emoji in Chrome.
		 */
		context.textBaseline = 'top';
		context.font = '600 32px Arial';

		switch ( type ) {
			case 'flag':
				/*
				 * Test for Transgender flag compatibility. This flag is shortlisted for the Emoji 13 spec,
				 * but has landed in Twemoji early, so we can add support for it, too.
				 *
				 * To test for support, we try to render it, and compare the rendering to how it would look if
				 * the browser doesn't render it correctly (white flag emoji + transgender symbol).
				 */
				isIdentical = emojiSetsRenderIdentically(
					[ 0x1F3F3, 0xFE0F, 0x200D, 0x26A7, 0xFE0F ],
					[ 0x1F3F3, 0xFE0F, 0x200B, 0x26A7, 0xFE0F ]
				);

				if ( isIdentical ) {
					return false;
				}

				/*
				 * Test for UN flag compatibility. This is the least supported of the letter locale flags,
				 * so gives us an easy test for full support.
				 *
				 * To test for support, we try to render it, and compare the rendering to how it would look if
				 * the browser doesn't render it correctly ([U] + [N]).
				 */
				isIdentical = emojiSetsRenderIdentically(
					[ 0xD83C, 0xDDFA, 0xD83C, 0xDDF3 ],
					[ 0xD83C, 0xDDFA, 0x200B, 0xD83C, 0xDDF3 ]
				);

				if ( isIdentical ) {
					return false;
				}

				/*
				 * Test for English flag compatibility. England is a country in the United Kingdom, it
				 * does not have a two letter locale code but rather an five letter sub-division code.
				 *
				 * To test for support, we try to render it, and compare the rendering to how it would look if
				 * the browser doesn't render it correctly (black flag emoji + [G] + [B] + [E] + [N] + [G]).
				 */
				isIdentical = emojiSetsRenderIdentically(
					[ 0xD83C, 0xDFF4, 0xDB40, 0xDC67, 0xDB40, 0xDC62, 0xDB40, 0xDC65, 0xDB40, 0xDC6E, 0xDB40, 0xDC67, 0xDB40, 0xDC7F ],
					[ 0xD83C, 0xDFF4, 0x200B, 0xDB40, 0xDC67, 0x200B, 0xDB40, 0xDC62, 0x200B, 0xDB40, 0xDC65, 0x200B, 0xDB40, 0xDC6E, 0x200B, 0xDB40, 0xDC67, 0x200B, 0xDB40, 0xDC7F ]
				);

				return ! isIdentical;
			case 'emoji':
				/*
				 * Why can't we be friends? Everyone can now shake hands in emoji, regardless of skin tone!
				 *
				 * To test for Emoji 14.0 support, try to render a new emoji: Handshake: Light Skin Tone, Dark Skin Tone.
				 *
				 * The Handshake: Light Skin Tone, Dark Skin Tone emoji is a ZWJ sequence combining 🫱 Rightwards Hand,
				 * 🏻 Light Skin Tone, a Zero Width Joiner, 🫲 Leftwards Hand, and 🏿 Dark Skin Tone.
				 *
				 * 0x1FAF1 == Rightwards Hand
				 * 0x1F3FB == Light Skin Tone
				 * 0x200D == Zero-Width Joiner (ZWJ) that links the code points for the new emoji or
				 * 0x200B == Zero-Width Space (ZWS) that is rendered for clients not supporting the new emoji.
				 * 0x1FAF2 == Leftwards Hand
				 * 0x1F3FF == Dark Skin Tone.
				 *
				 * When updating this test for future Emoji releases, ensure that individual emoji that make up the
				 * sequence come from older emoji standards.
				 */
				isIdentical = emojiSetsRenderIdentically(
					[0x1FAF1, 0x1F3FB, 0x200D, 0x1FAF2, 0x1F3FF],
					[0x1FAF1, 0x1F3FB, 0x200B, 0x1FAF2, 0x1F3FF]
				);

				return ! isIdentical;
		}

		return false;
	}

	/**
	 * Adds a script to the head of the document.
	 *
	 * @ignore
	 *
	 * @since 4.2.0
	 *
	 * @param {Object} src The url where the script is located.
	 * @return {void}
	 */
	function addScript( src ) {
		var script = document.createElement( 'script' );

		script.src = src;
		script.defer = script.type = 'text/javascript';
		document.getElementsByTagName( 'head' )[0].appendChild( script );
	}

	tests = Array( 'flag', 'emoji' );

	settings.supports = {
		everything: true,
		everythingExceptFlag: true
	};

	/*
	 * Tests the browser support for flag emojis and other emojis, and adjusts the
	 * support settings accordingly.
	 */
	for( ii = 0; ii < tests.length; ii++ ) {
		settings.supports[ tests[ ii ] ] = browserSupportsEmoji( tests[ ii ] );

		settings.supports.everything = settings.supports.everything && settings.supports[ tests[ ii ] ];

		if ( 'flag' !== tests[ ii ] ) {
			settings.supports.everythingExceptFlag = settings.supports.everythingExceptFlag && settings.supports[ tests[ ii ] ];
		}
	}

	settings.supports.everythingExceptFlag = settings.supports.everythingExceptFlag && ! settings.supports.flag;

	// Sets DOMReady to false and assigns a ready function to settings.
	settings.DOMReady = false;
	settings.readyCallback = function() {
		settings.DOMReady = true;
	};

	// When the browser can not render everything we need to load a polyfill.
	if ( ! settings.supports.everything ) {
		ready = function() {
			settings.readyCallback();
		};

		/*
		 * Cross-browser version of adding a dom ready event.
		 */
		if ( document.addEventListener ) {
			document.addEventListener( 'DOMContentLoaded', ready, false );
			window.addEventListener( 'load', ready, false );
		} else {
			window.attachEvent( 'onload', ready );
			document.attachEvent( 'onreadystatechange', function() {
				if ( 'complete' === document.readyState ) {
					settings.readyCallback();
				}
			} );
		}

		src = settings.source || {};

		if ( src.concatemoji ) {
			addScript( src.concatemoji );
		} else if ( src.wpemoji && src.twemoji ) {
			addScript( src.twemoji );
			addScript( src.wpemoji );
		}
	}

} )( window, document, window._wpemojiSettings );
</script>
	<style type="text/css">
		img.wp-smiley,
		img.emoji {
			display: inline !important;
			border: none !important;
			box-shadow: none !important;
			height: 1em !important;
			width: 1em !important;
			margin: 0 0.07em !important;
			vertical-align: -0.1em !important;
			background: none !important;
			padding: 0 !important;
		}
	</style>
	<link data-minify="1" rel='preload' href="{{ asset('css/style_client.css') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" onerror="this.removeAttribute('data-rocket-async')" type='text/css' media='all' />
	<style id='global-styles-inline-css' type='text/css'>
		body {
			--wp--preset--color--black: #000000;
			--wp--preset--color--cyan-bluish-gray: #abb8c3;
			--wp--preset--color--white: #ffffff;
			--wp--preset--color--pale-pink: #f78da7;
			--wp--preset--color--vivid-red: #cf2e2e;
			--wp--preset--color--luminous-vivid-orange: #ff6900;
			--wp--preset--color--luminous-vivid-amber: #fcb900;
			--wp--preset--color--light-green-cyan: #7bdcb5;
			--wp--preset--color--vivid-green-cyan: #00d084;
			--wp--preset--color--pale-cyan-blue: #8ed1fc;
			--wp--preset--color--vivid-cyan-blue: #0693e3;
			--wp--preset--color--vivid-purple: #9b51e0;
			--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(135deg, rgba(6, 147, 227, 1) 0%, rgb(155, 81, 224) 100%);
			--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan: linear-gradient(135deg, rgb(122, 220, 180) 0%, rgb(0, 208, 130) 100%);
			--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange: linear-gradient(135deg, rgba(252, 185, 0, 1) 0%, rgba(255, 105, 0, 1) 100%);
			--wp--preset--gradient--luminous-vivid-orange-to-vivid-red: linear-gradient(135deg, rgba(255, 105, 0, 1) 0%, rgb(207, 46, 46) 100%);
			--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray: linear-gradient(135deg, rgb(238, 238, 238) 0%, rgb(169, 184, 195) 100%);
			--wp--preset--gradient--cool-to-warm-spectrum: linear-gradient(135deg, rgb(74, 234, 220) 0%, rgb(151, 120, 209) 20%, rgb(207, 42, 186) 40%, rgb(238, 44, 130) 60%, rgb(251, 105, 98) 80%, rgb(254, 248, 76) 100%);
			--wp--preset--gradient--blush-light-purple: linear-gradient(135deg, rgb(255, 206, 236) 0%, rgb(152, 150, 240) 100%);
			--wp--preset--gradient--blush-bordeaux: linear-gradient(135deg, rgb(254, 205, 165) 0%, rgb(254, 45, 45) 50%, rgb(107, 0, 62) 100%);
			--wp--preset--gradient--luminous-dusk: linear-gradient(135deg, rgb(255, 203, 112) 0%, rgb(199, 81, 192) 50%, rgb(65, 88, 208) 100%);
			--wp--preset--gradient--pale-ocean: linear-gradient(135deg, rgb(255, 245, 203) 0%, rgb(182, 227, 212) 50%, rgb(51, 167, 181) 100%);
			--wp--preset--gradient--electric-grass: linear-gradient(135deg, rgb(202, 248, 128) 0%, rgb(113, 206, 126) 100%);
			--wp--preset--gradient--midnight: linear-gradient(135deg, rgb(2, 3, 129) 0%, rgb(40, 116, 252) 100%);
			--wp--preset--duotone--dark-grayscale: url('#wp-duotone-dark-grayscale');
			--wp--preset--duotone--grayscale: url('#wp-duotone-grayscale');
			--wp--preset--duotone--purple-yellow: url('#wp-duotone-purple-yellow');
			--wp--preset--duotone--blue-red: url('#wp-duotone-blue-red');
			--wp--preset--duotone--midnight: url('#wp-duotone-midnight');
			--wp--preset--duotone--magenta-yellow: url('#wp-duotone-magenta-yellow');
			--wp--preset--duotone--purple-green: url('#wp-duotone-purple-green');
			--wp--preset--duotone--blue-orange: url('#wp-duotone-blue-orange');
			--wp--preset--font-size--small: 13px;
			--wp--preset--font-size--medium: 20px;
			--wp--preset--font-size--large: 36px;
			--wp--preset--font-size--x-large: 42px;
		}

		.has-black-color {
			color: var(--wp--preset--color--black) !important;
		}

		.has-cyan-bluish-gray-color {
			color: var(--wp--preset--color--cyan-bluish-gray) !important;
		}

		.has-white-color {
			color: var(--wp--preset--color--white) !important;
		}

		.has-pale-pink-color {
			color: var(--wp--preset--color--pale-pink) !important;
		}

		.has-vivid-red-color {
			color: var(--wp--preset--color--vivid-red) !important;
		}

		.has-luminous-vivid-orange-color {
			color: var(--wp--preset--color--luminous-vivid-orange) !important;
		}

		.has-luminous-vivid-amber-color {
			color: var(--wp--preset--color--luminous-vivid-amber) !important;
		}

		.has-light-green-cyan-color {
			color: var(--wp--preset--color--light-green-cyan) !important;
		}

		.has-vivid-green-cyan-color {
			color: var(--wp--preset--color--vivid-green-cyan) !important;
		}

		.has-pale-cyan-blue-color {
			color: var(--wp--preset--color--pale-cyan-blue) !important;
		}

		.has-vivid-cyan-blue-color {
			color: var(--wp--preset--color--vivid-cyan-blue) !important;
		}

		.has-vivid-purple-color {
			color: var(--wp--preset--color--vivid-purple) !important;
		}

		.has-black-background-color {
			background-color: var(--wp--preset--color--black) !important;
		}

		.has-cyan-bluish-gray-background-color {
			background-color: var(--wp--preset--color--cyan-bluish-gray) !important;
		}

		.has-white-background-color {
			background-color: var(--wp--preset--color--white) !important;
		}

		.has-pale-pink-background-color {
			background-color: var(--wp--preset--color--pale-pink) !important;
		}

		.has-vivid-red-background-color {
			background-color: var(--wp--preset--color--vivid-red) !important;
		}

		.has-luminous-vivid-orange-background-color {
			background-color: var(--wp--preset--color--luminous-vivid-orange) !important;
		}

		.has-luminous-vivid-amber-background-color {
			background-color: var(--wp--preset--color--luminous-vivid-amber) !important;
		}

		.has-light-green-cyan-background-color {
			background-color: var(--wp--preset--color--light-green-cyan) !important;
		}

		.has-vivid-green-cyan-background-color {
			background-color: var(--wp--preset--color--vivid-green-cyan) !important;
		}

		.has-pale-cyan-blue-background-color {
			background-color: var(--wp--preset--color--pale-cyan-blue) !important;
		}

		.has-vivid-cyan-blue-background-color {
			background-color: var(--wp--preset--color--vivid-cyan-blue) !important;
		}

		.has-vivid-purple-background-color {
			background-color: var(--wp--preset--color--vivid-purple) !important;
		}

		.has-black-border-color {
			border-color: var(--wp--preset--color--black) !important;
		}

		.has-cyan-bluish-gray-border-color {
			border-color: var(--wp--preset--color--cyan-bluish-gray) !important;
		}

		.has-white-border-color {
			border-color: var(--wp--preset--color--white) !important;
		}

		.has-pale-pink-border-color {
			border-color: var(--wp--preset--color--pale-pink) !important;
		}

		.has-vivid-red-border-color {
			border-color: var(--wp--preset--color--vivid-red) !important;
		}

		.has-luminous-vivid-orange-border-color {
			border-color: var(--wp--preset--color--luminous-vivid-orange) !important;
		}

		.has-luminous-vivid-amber-border-color {
			border-color: var(--wp--preset--color--luminous-vivid-amber) !important;
		}

		.has-light-green-cyan-border-color {
			border-color: var(--wp--preset--color--light-green-cyan) !important;
		}

		.has-vivid-green-cyan-border-color {
			border-color: var(--wp--preset--color--vivid-green-cyan) !important;
		}

		.has-pale-cyan-blue-border-color {
			border-color: var(--wp--preset--color--pale-cyan-blue) !important;
		}

		.has-vivid-cyan-blue-border-color {
			border-color: var(--wp--preset--color--vivid-cyan-blue) !important;
		}

		.has-vivid-purple-border-color {
			border-color: var(--wp--preset--color--vivid-purple) !important;
		}

		.has-vivid-cyan-blue-to-vivid-purple-gradient-background {
			background: var(--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple) !important;
		}

		.has-light-green-cyan-to-vivid-green-cyan-gradient-background {
			background: var(--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan) !important;
		}

		.has-luminous-vivid-amber-to-luminous-vivid-orange-gradient-background {
			background: var(--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange) !important;
		}

		.has-luminous-vivid-orange-to-vivid-red-gradient-background {
			background: var(--wp--preset--gradient--luminous-vivid-orange-to-vivid-red) !important;
		}

		.has-very-light-gray-to-cyan-bluish-gray-gradient-background {
			background: var(--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray) !important;
		}

		.has-cool-to-warm-spectrum-gradient-background {
			background: var(--wp--preset--gradient--cool-to-warm-spectrum) !important;
		}

		.has-blush-light-purple-gradient-background {
			background: var(--wp--preset--gradient--blush-light-purple) !important;
		}

		.has-blush-bordeaux-gradient-background {
			background: var(--wp--preset--gradient--blush-bordeaux) !important;
		}

		.has-luminous-dusk-gradient-background {
			background: var(--wp--preset--gradient--luminous-dusk) !important;
		}

		.has-pale-ocean-gradient-background {
			background: var(--wp--preset--gradient--pale-ocean) !important;
		}

		.has-electric-grass-gradient-background {
			background: var(--wp--preset--gradient--electric-grass) !important;
		}

		.has-midnight-gradient-background {
			background: var(--wp--preset--gradient--midnight) !important;
		}

		.has-small-font-size {
			font-size: var(--wp--preset--font-size--small) !important;
		}

		.has-medium-font-size {
			font-size: var(--wp--preset--font-size--medium) !important;
		}

		.has-large-font-size {
			font-size: var(--wp--preset--font-size--large) !important;
		}

		.has-x-large-font-size {
			font-size: var(--wp--preset--font-size--x-large) !important;
		}
	</style>
	<link data-minify="1" rel='preload' href='https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/plugins/contact-form-7/includes/css/styles.css?ver=1680517523' data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" onerror="this.removeAttribute('data-rocket-async')" type='text/css' media='all' />
	<style id='extendify-gutenberg-patterns-and-templates-utilities-inline-css' type='text/css'>
		.ext-absolute {
			position: absolute !important
		}

		.ext-relative {
			position: relative !important
		}

		.ext-top-base {
			top: var(--wp--style--block-gap, 1.75rem) !important
		}

		.ext-top-lg {
			top: var(--extendify--spacing--large, 3rem) !important
		}

		.ext--top-base {
			top: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
		}

		.ext--top-lg {
			top: calc(var(--extendify--spacing--large, 3rem)*-1) !important
		}

		.ext-right-base {
			right: var(--wp--style--block-gap, 1.75rem) !important
		}

		.ext-right-lg {
			right: var(--extendify--spacing--large, 3rem) !important
		}

		.ext--right-base {
			right: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
		}

		.ext--right-lg {
			right: calc(var(--extendify--spacing--large, 3rem)*-1) !important
		}

		.ext-bottom-base {
			bottom: var(--wp--style--block-gap, 1.75rem) !important
		}

		.ext-bottom-lg {
			bottom: var(--extendify--spacing--large, 3rem) !important
		}

		.ext--bottom-base {
			bottom: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
		}

		.ext--bottom-lg {
			bottom: calc(var(--extendify--spacing--large, 3rem)*-1) !important
		}

		.ext-left-base {
			left: var(--wp--style--block-gap, 1.75rem) !important
		}

		.ext-left-lg {
			left: var(--extendify--spacing--large, 3rem) !important
		}

		.ext--left-base {
			left: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
		}

		.ext--left-lg {
			left: calc(var(--extendify--spacing--large, 3rem)*-1) !important
		}

		.ext-order-1 {
			order: 1 !important
		}

		.ext-order-2 {
			order: 2 !important
		}

		.ext-col-auto {
			grid-column: auto !important
		}

		.ext-col-span-1 {
			grid-column: span 1/span 1 !important
		}

		.ext-col-span-2 {
			grid-column: span 2/span 2 !important
		}

		.ext-col-span-3 {
			grid-column: span 3/span 3 !important
		}

		.ext-col-span-4 {
			grid-column: span 4/span 4 !important
		}

		.ext-col-span-5 {
			grid-column: span 5/span 5 !important
		}

		.ext-col-span-6 {
			grid-column: span 6/span 6 !important
		}

		.ext-col-span-7 {
			grid-column: span 7/span 7 !important
		}

		.ext-col-span-8 {
			grid-column: span 8/span 8 !important
		}

		.ext-col-span-9 {
			grid-column: span 9/span 9 !important
		}

		.ext-col-span-10 {
			grid-column: span 10/span 10 !important
		}

		.ext-col-span-11 {
			grid-column: span 11/span 11 !important
		}

		.ext-col-span-12 {
			grid-column: span 12/span 12 !important
		}

		.ext-col-span-full {
			grid-column: 1/-1 !important
		}

		.ext-col-start-1 {
			grid-column-start: 1 !important
		}

		.ext-col-start-2 {
			grid-column-start: 2 !important
		}

		.ext-col-start-3 {
			grid-column-start: 3 !important
		}

		.ext-col-start-4 {
			grid-column-start: 4 !important
		}

		.ext-col-start-5 {
			grid-column-start: 5 !important
		}

		.ext-col-start-6 {
			grid-column-start: 6 !important
		}

		.ext-col-start-7 {
			grid-column-start: 7 !important
		}

		.ext-col-start-8 {
			grid-column-start: 8 !important
		}

		.ext-col-start-9 {
			grid-column-start: 9 !important
		}

		.ext-col-start-10 {
			grid-column-start: 10 !important
		}

		.ext-col-start-11 {
			grid-column-start: 11 !important
		}

		.ext-col-start-12 {
			grid-column-start: 12 !important
		}

		.ext-col-start-13 {
			grid-column-start: 13 !important
		}

		.ext-col-start-auto {
			grid-column-start: auto !important
		}

		.ext-col-end-1 {
			grid-column-end: 1 !important
		}

		.ext-col-end-2 {
			grid-column-end: 2 !important
		}

		.ext-col-end-3 {
			grid-column-end: 3 !important
		}

		.ext-col-end-4 {
			grid-column-end: 4 !important
		}

		.ext-col-end-5 {
			grid-column-end: 5 !important
		}

		.ext-col-end-6 {
			grid-column-end: 6 !important
		}

		.ext-col-end-7 {
			grid-column-end: 7 !important
		}

		.ext-col-end-8 {
			grid-column-end: 8 !important
		}

		.ext-col-end-9 {
			grid-column-end: 9 !important
		}

		.ext-col-end-10 {
			grid-column-end: 10 !important
		}

		.ext-col-end-11 {
			grid-column-end: 11 !important
		}

		.ext-col-end-12 {
			grid-column-end: 12 !important
		}

		.ext-col-end-13 {
			grid-column-end: 13 !important
		}

		.ext-col-end-auto {
			grid-column-end: auto !important
		}

		.ext-row-auto {
			grid-row: auto !important
		}

		.ext-row-span-1 {
			grid-row: span 1/span 1 !important
		}

		.ext-row-span-2 {
			grid-row: span 2/span 2 !important
		}

		.ext-row-span-3 {
			grid-row: span 3/span 3 !important
		}

		.ext-row-span-4 {
			grid-row: span 4/span 4 !important
		}

		.ext-row-span-5 {
			grid-row: span 5/span 5 !important
		}

		.ext-row-span-6 {
			grid-row: span 6/span 6 !important
		}

		.ext-row-span-full {
			grid-row: 1/-1 !important
		}

		.ext-row-start-1 {
			grid-row-start: 1 !important
		}

		.ext-row-start-2 {
			grid-row-start: 2 !important
		}

		.ext-row-start-3 {
			grid-row-start: 3 !important
		}

		.ext-row-start-4 {
			grid-row-start: 4 !important
		}

		.ext-row-start-5 {
			grid-row-start: 5 !important
		}

		.ext-row-start-6 {
			grid-row-start: 6 !important
		}

		.ext-row-start-7 {
			grid-row-start: 7 !important
		}

		.ext-row-start-auto {
			grid-row-start: auto !important
		}

		.ext-row-end-1 {
			grid-row-end: 1 !important
		}

		.ext-row-end-2 {
			grid-row-end: 2 !important
		}

		.ext-row-end-3 {
			grid-row-end: 3 !important
		}

		.ext-row-end-4 {
			grid-row-end: 4 !important
		}

		.ext-row-end-5 {
			grid-row-end: 5 !important
		}

		.ext-row-end-6 {
			grid-row-end: 6 !important
		}

		.ext-row-end-7 {
			grid-row-end: 7 !important
		}

		.ext-row-end-auto {
			grid-row-end: auto !important
		}

		.ext-m-0:not([style*=margin]) {
			margin: 0 !important
		}

		.ext-m-auto:not([style*=margin]) {
			margin: auto !important
		}

		.ext-m-base:not([style*=margin]) {
			margin: var(--wp--style--block-gap, 1.75rem) !important
		}

		.ext-m-lg:not([style*=margin]) {
			margin: var(--extendify--spacing--large, 3rem) !important
		}

		.ext--m-base:not([style*=margin]) {
			margin: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
		}

		.ext--m-lg:not([style*=margin]) {
			margin: calc(var(--extendify--spacing--large, 3rem)*-1) !important
		}

		.ext-mx-0:not([style*=margin]) {
			margin-left: 0 !important;
			margin-right: 0 !important
		}

		.ext-mx-auto:not([style*=margin]) {
			margin-left: auto !important;
			margin-right: auto !important
		}

		.ext-mx-base:not([style*=margin]) {
			margin-left: var(--wp--style--block-gap, 1.75rem) !important;
			margin-right: var(--wp--style--block-gap, 1.75rem) !important
		}

		.ext-mx-lg:not([style*=margin]) {
			margin-left: var(--extendify--spacing--large, 3rem) !important;
			margin-right: var(--extendify--spacing--large, 3rem) !important
		}

		.ext--mx-base:not([style*=margin]) {
			margin-left: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important;
			margin-right: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
		}

		.ext--mx-lg:not([style*=margin]) {
			margin-left: calc(var(--extendify--spacing--large, 3rem)*-1) !important;
			margin-right: calc(var(--extendify--spacing--large, 3rem)*-1) !important
		}

		.ext-my-0:not([style*=margin]) {
			margin-bottom: 0 !important;
			margin-top: 0 !important
		}

		.ext-my-auto:not([style*=margin]) {
			margin-bottom: auto !important;
			margin-top: auto !important
		}

		.ext-my-base:not([style*=margin]) {
			margin-bottom: var(--wp--style--block-gap, 1.75rem) !important;
			margin-top: var(--wp--style--block-gap, 1.75rem) !important
		}

		.ext-my-lg:not([style*=margin]) {
			margin-bottom: var(--extendify--spacing--large, 3rem) !important;
			margin-top: var(--extendify--spacing--large, 3rem) !important
		}

		.ext--my-base:not([style*=margin]) {
			margin-bottom: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important;
			margin-top: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
		}

		.ext--my-lg:not([style*=margin]) {
			margin-bottom: calc(var(--extendify--spacing--large, 3rem)*-1) !important;
			margin-top: calc(var(--extendify--spacing--large, 3rem)*-1) !important
		}

		.ext-mt-0:not([style*=margin]) {
			margin-top: 0 !important
		}

		.ext-mt-auto:not([style*=margin]) {
			margin-top: auto !important
		}

		.ext-mt-base:not([style*=margin]) {
			margin-top: var(--wp--style--block-gap, 1.75rem) !important
		}

		.ext-mt-lg:not([style*=margin]) {
			margin-top: var(--extendify--spacing--large, 3rem) !important
		}

		.ext--mt-base:not([style*=margin]) {
			margin-top: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
		}

		.ext--mt-lg:not([style*=margin]) {
			margin-top: calc(var(--extendify--spacing--large, 3rem)*-1) !important
		}

		.ext-mr-0:not([style*=margin]) {
			margin-right: 0 !important
		}

		.ext-mr-auto:not([style*=margin]) {
			margin-right: auto !important
		}

		.ext-mr-base:not([style*=margin]) {
			margin-right: var(--wp--style--block-gap, 1.75rem) !important
		}

		.ext-mr-lg:not([style*=margin]) {
			margin-right: var(--extendify--spacing--large, 3rem) !important
		}

		.ext--mr-base:not([style*=margin]) {
			margin-right: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
		}

		.ext--mr-lg:not([style*=margin]) {
			margin-right: calc(var(--extendify--spacing--large, 3rem)*-1) !important
		}

		.ext-mb-0:not([style*=margin]) {
			margin-bottom: 0 !important
		}

		.ext-mb-auto:not([style*=margin]) {
			margin-bottom: auto !important
		}

		.ext-mb-base:not([style*=margin]) {
			margin-bottom: var(--wp--style--block-gap, 1.75rem) !important
		}

		.ext-mb-lg:not([style*=margin]) {
			margin-bottom: var(--extendify--spacing--large, 3rem) !important
		}

		.ext--mb-base:not([style*=margin]) {
			margin-bottom: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
		}

		.ext--mb-lg:not([style*=margin]) {
			margin-bottom: calc(var(--extendify--spacing--large, 3rem)*-1) !important
		}

		.ext-ml-0:not([style*=margin]) {
			margin-left: 0 !important
		}

		.ext-ml-auto:not([style*=margin]) {
			margin-left: auto !important
		}

		.ext-ml-base:not([style*=margin]) {
			margin-left: var(--wp--style--block-gap, 1.75rem) !important
		}

		.ext-ml-lg:not([style*=margin]) {
			margin-left: var(--extendify--spacing--large, 3rem) !important
		}

		.ext--ml-base:not([style*=margin]) {
			margin-left: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
		}

		.ext--ml-lg:not([style*=margin]) {
			margin-left: calc(var(--extendify--spacing--large, 3rem)*-1) !important
		}

		.ext-block {
			display: block !important
		}

		.ext-inline-block {
			display: inline-block !important
		}

		.ext-inline {
			display: inline !important
		}

		.ext-flex {
			display: flex !important
		}

		.ext-inline-flex {
			display: inline-flex !important
		}

		.ext-grid {
			display: grid !important
		}

		.ext-inline-grid {
			display: inline-grid !important
		}

		.ext-hidden {
			display: none !important
		}

		.ext-w-auto {
			width: auto !important
		}

		.ext-w-full {
			width: 100% !important
		}

		.ext-max-w-full {
			max-width: 100% !important
		}

		.ext-flex-1 {
			flex: 1 1 0% !important
		}

		.ext-flex-auto {
			flex: 1 1 auto !important
		}

		.ext-flex-initial {
			flex: 0 1 auto !important
		}

		.ext-flex-none {
			flex: none !important
		}

		.ext-flex-shrink-0 {
			flex-shrink: 0 !important
		}

		.ext-flex-shrink {
			flex-shrink: 1 !important
		}

		.ext-flex-grow-0 {
			flex-grow: 0 !important
		}

		.ext-flex-grow {
			flex-grow: 1 !important
		}

		.ext-list-none {
			list-style-type: none !important
		}

		.ext-grid-cols-1 {
			grid-template-columns: repeat(1, minmax(0, 1fr)) !important
		}

		.ext-grid-cols-2 {
			grid-template-columns: repeat(2, minmax(0, 1fr)) !important
		}

		.ext-grid-cols-3 {
			grid-template-columns: repeat(3, minmax(0, 1fr)) !important
		}

		.ext-grid-cols-4 {
			grid-template-columns: repeat(4, minmax(0, 1fr)) !important
		}

		.ext-grid-cols-5 {
			grid-template-columns: repeat(5, minmax(0, 1fr)) !important
		}

		.ext-grid-cols-6 {
			grid-template-columns: repeat(6, minmax(0, 1fr)) !important
		}

		.ext-grid-cols-7 {
			grid-template-columns: repeat(7, minmax(0, 1fr)) !important
		}

		.ext-grid-cols-8 {
			grid-template-columns: repeat(8, minmax(0, 1fr)) !important
		}

		.ext-grid-cols-9 {
			grid-template-columns: repeat(9, minmax(0, 1fr)) !important
		}

		.ext-grid-cols-10 {
			grid-template-columns: repeat(10, minmax(0, 1fr)) !important
		}

		.ext-grid-cols-11 {
			grid-template-columns: repeat(11, minmax(0, 1fr)) !important
		}

		.ext-grid-cols-12 {
			grid-template-columns: repeat(12, minmax(0, 1fr)) !important
		}

		.ext-grid-cols-none {
			grid-template-columns: none !important
		}

		.ext-grid-rows-1 {
			grid-template-rows: repeat(1, minmax(0, 1fr)) !important
		}

		.ext-grid-rows-2 {
			grid-template-rows: repeat(2, minmax(0, 1fr)) !important
		}

		.ext-grid-rows-3 {
			grid-template-rows: repeat(3, minmax(0, 1fr)) !important
		}

		.ext-grid-rows-4 {
			grid-template-rows: repeat(4, minmax(0, 1fr)) !important
		}

		.ext-grid-rows-5 {
			grid-template-rows: repeat(5, minmax(0, 1fr)) !important
		}

		.ext-grid-rows-6 {
			grid-template-rows: repeat(6, minmax(0, 1fr)) !important
		}

		.ext-grid-rows-none {
			grid-template-rows: none !important
		}

		.ext-flex-row {
			flex-direction: row !important
		}

		.ext-flex-row-reverse {
			flex-direction: row-reverse !important
		}

		.ext-flex-col {
			flex-direction: column !important
		}

		.ext-flex-col-reverse {
			flex-direction: column-reverse !important
		}

		.ext-flex-wrap {
			flex-wrap: wrap !important
		}

		.ext-flex-wrap-reverse {
			flex-wrap: wrap-reverse !important
		}

		.ext-flex-nowrap {
			flex-wrap: nowrap !important
		}

		.ext-items-start {
			align-items: flex-start !important
		}

		.ext-items-end {
			align-items: flex-end !important
		}

		.ext-items-center {
			align-items: center !important
		}

		.ext-items-baseline {
			align-items: baseline !important
		}

		.ext-items-stretch {
			align-items: stretch !important
		}

		.ext-justify-start {
			justify-content: flex-start !important
		}

		.ext-justify-end {
			justify-content: flex-end !important
		}

		.ext-justify-center {
			justify-content: center !important
		}

		.ext-justify-between {
			justify-content: space-between !important
		}

		.ext-justify-around {
			justify-content: space-around !important
		}

		.ext-justify-evenly {
			justify-content: space-evenly !important
		}

		.ext-justify-items-start {
			justify-items: start !important
		}

		.ext-justify-items-end {
			justify-items: end !important
		}

		.ext-justify-items-center {
			justify-items: center !important
		}

		.ext-justify-items-stretch {
			justify-items: stretch !important
		}

		.ext-gap-0 {
			gap: 0 !important
		}

		.ext-gap-base {
			gap: var(--wp--style--block-gap, 1.75rem) !important
		}

		.ext-gap-lg {
			gap: var(--extendify--spacing--large, 3rem) !important
		}

		.ext-gap-x-0 {
			-moz-column-gap: 0 !important;
			column-gap: 0 !important
		}

		.ext-gap-x-base {
			-moz-column-gap: var(--wp--style--block-gap, 1.75rem) !important;
			column-gap: var(--wp--style--block-gap, 1.75rem) !important
		}

		.ext-gap-x-lg {
			-moz-column-gap: var(--extendify--spacing--large, 3rem) !important;
			column-gap: var(--extendify--spacing--large, 3rem) !important
		}

		.ext-gap-y-0 {
			row-gap: 0 !important
		}

		.ext-gap-y-base {
			row-gap: var(--wp--style--block-gap, 1.75rem) !important
		}

		.ext-gap-y-lg {
			row-gap: var(--extendify--spacing--large, 3rem) !important
		}

		.ext-justify-self-auto {
			justify-self: auto !important
		}

		.ext-justify-self-start {
			justify-self: start !important
		}

		.ext-justify-self-end {
			justify-self: end !important
		}

		.ext-justify-self-center {
			justify-self: center !important
		}

		.ext-justify-self-stretch {
			justify-self: stretch !important
		}

		.ext-rounded-none {
			border-radius: 0 !important
		}

		.ext-rounded-full {
			border-radius: 9999px !important
		}

		.ext-rounded-t-none {
			border-top-left-radius: 0 !important;
			border-top-right-radius: 0 !important
		}

		.ext-rounded-t-full {
			border-top-left-radius: 9999px !important;
			border-top-right-radius: 9999px !important
		}

		.ext-rounded-r-none {
			border-bottom-right-radius: 0 !important;
			border-top-right-radius: 0 !important
		}

		.ext-rounded-r-full {
			border-bottom-right-radius: 9999px !important;
			border-top-right-radius: 9999px !important
		}

		.ext-rounded-b-none {
			border-bottom-left-radius: 0 !important;
			border-bottom-right-radius: 0 !important
		}

		.ext-rounded-b-full {
			border-bottom-left-radius: 9999px !important;
			border-bottom-right-radius: 9999px !important
		}

		.ext-rounded-l-none {
			border-bottom-left-radius: 0 !important;
			border-top-left-radius: 0 !important
		}

		.ext-rounded-l-full {
			border-bottom-left-radius: 9999px !important;
			border-top-left-radius: 9999px !important
		}

		.ext-rounded-tl-none {
			border-top-left-radius: 0 !important
		}

		.ext-rounded-tl-full {
			border-top-left-radius: 9999px !important
		}

		.ext-rounded-tr-none {
			border-top-right-radius: 0 !important
		}

		.ext-rounded-tr-full {
			border-top-right-radius: 9999px !important
		}

		.ext-rounded-br-none {
			border-bottom-right-radius: 0 !important
		}

		.ext-rounded-br-full {
			border-bottom-right-radius: 9999px !important
		}

		.ext-rounded-bl-none {
			border-bottom-left-radius: 0 !important
		}

		.ext-rounded-bl-full {
			border-bottom-left-radius: 9999px !important
		}

		.ext-border-0 {
			border-width: 0 !important
		}

		.ext-border-t-0 {
			border-top-width: 0 !important
		}

		.ext-border-r-0 {
			border-right-width: 0 !important
		}

		.ext-border-b-0 {
			border-bottom-width: 0 !important
		}

		.ext-border-l-0 {
			border-left-width: 0 !important
		}

		.ext-p-0:not([style*=padding]) {
			padding: 0 !important
		}

		.ext-p-base:not([style*=padding]) {
			padding: var(--wp--style--block-gap, 1.75rem) !important
		}

		.ext-p-lg:not([style*=padding]) {
			padding: var(--extendify--spacing--large, 3rem) !important
		}

		.ext-px-0:not([style*=padding]) {
			padding-left: 0 !important;
			padding-right: 0 !important
		}

		.ext-px-base:not([style*=padding]) {
			padding-left: var(--wp--style--block-gap, 1.75rem) !important;
			padding-right: var(--wp--style--block-gap, 1.75rem) !important
		}

		.ext-px-lg:not([style*=padding]) {
			padding-left: var(--extendify--spacing--large, 3rem) !important;
			padding-right: var(--extendify--spacing--large, 3rem) !important
		}

		.ext-py-0:not([style*=padding]) {
			padding-bottom: 0 !important;
			padding-top: 0 !important
		}

		.ext-py-base:not([style*=padding]) {
			padding-bottom: var(--wp--style--block-gap, 1.75rem) !important;
			padding-top: var(--wp--style--block-gap, 1.75rem) !important
		}

		.ext-py-lg:not([style*=padding]) {
			padding-bottom: var(--extendify--spacing--large, 3rem) !important;
			padding-top: var(--extendify--spacing--large, 3rem) !important
		}

		.ext-pt-0:not([style*=padding]) {
			padding-top: 0 !important
		}

		.ext-pt-base:not([style*=padding]) {
			padding-top: var(--wp--style--block-gap, 1.75rem) !important
		}

		.ext-pt-lg:not([style*=padding]) {
			padding-top: var(--extendify--spacing--large, 3rem) !important
		}

		.ext-pr-0:not([style*=padding]) {
			padding-right: 0 !important
		}

		.ext-pr-base:not([style*=padding]) {
			padding-right: var(--wp--style--block-gap, 1.75rem) !important
		}

		.ext-pr-lg:not([style*=padding]) {
			padding-right: var(--extendify--spacing--large, 3rem) !important
		}

		.ext-pb-0:not([style*=padding]) {
			padding-bottom: 0 !important
		}

		.ext-pb-base:not([style*=padding]) {
			padding-bottom: var(--wp--style--block-gap, 1.75rem) !important
		}

		.ext-pb-lg:not([style*=padding]) {
			padding-bottom: var(--extendify--spacing--large, 3rem) !important
		}

		.ext-pl-0:not([style*=padding]) {
			padding-left: 0 !important
		}

		.ext-pl-base:not([style*=padding]) {
			padding-left: var(--wp--style--block-gap, 1.75rem) !important
		}

		.ext-pl-lg:not([style*=padding]) {
			padding-left: var(--extendify--spacing--large, 3rem) !important
		}

		.ext-text-left {
			text-align: left !important
		}

		.ext-text-center {
			text-align: center !important
		}

		.ext-text-right {
			text-align: right !important
		}

		.ext-leading-none {
			line-height: 1 !important
		}

		.ext-leading-tight {
			line-height: 1.25 !important
		}

		.ext-leading-snug {
			line-height: 1.375 !important
		}

		.ext-leading-normal {
			line-height: 1.5 !important
		}

		.ext-leading-relaxed {
			line-height: 1.625 !important
		}

		.ext-leading-loose {
			line-height: 2 !important
		}

		.clip-path--rhombus img {
			-webkit-clip-path: polygon(15% 6%, 80% 29%, 84% 93%, 23% 69%);
			clip-path: polygon(15% 6%, 80% 29%, 84% 93%, 23% 69%)
		}

		.clip-path--diamond img {
			-webkit-clip-path: polygon(5% 29%, 60% 2%, 91% 64%, 36% 89%);
			clip-path: polygon(5% 29%, 60% 2%, 91% 64%, 36% 89%)
		}

		.clip-path--rhombus-alt img {
			-webkit-clip-path: polygon(14% 9%, 85% 24%, 91% 89%, 19% 76%);
			clip-path: polygon(14% 9%, 85% 24%, 91% 89%, 19% 76%)
		}

		.wp-block-columns[class*=fullwidth-cols] {
			margin-bottom: unset
		}

		.wp-block-column.editor\:pointer-events-none {
			margin-bottom: 0 !important;
			margin-top: 0 !important
		}

		.is-root-container.block-editor-block-list__layout>[data-align=full]:not(:first-of-type)>.wp-block-column.editor\:pointer-events-none,
		.is-root-container.block-editor-block-list__layout>[data-align=wide]>.wp-block-column.editor\:pointer-events-none {
			margin-top: calc(var(--wp--style--block-gap, 28px)*-1) !important
		}

		.ext .wp-block-columns .wp-block-column[style*=padding] {
			padding-left: 0 !important;
			padding-right: 0 !important
		}

		.ext .wp-block-columns+.wp-block-columns:not([class*=mt-]):not([class*=my-]):not([style*=margin]) {
			margin-top: 0 !important
		}

		[class*=fullwidth-cols] .wp-block-column:first-child,
		[class*=fullwidth-cols] .wp-block-group:first-child {
			margin-top: 0
		}

		[class*=fullwidth-cols] .wp-block-column:last-child,
		[class*=fullwidth-cols] .wp-block-group:last-child {
			margin-bottom: 0
		}

		[class*=fullwidth-cols] .wp-block-column:first-child>*,
		[class*=fullwidth-cols] .wp-block-column>:first-child {
			margin-top: 0
		}

		.ext .is-not-stacked-on-mobile .wp-block-column,
		[class*=fullwidth-cols] .wp-block-column>:last-child {
			margin-bottom: 0
		}

		.wp-block-columns[class*=fullwidth-cols]:not(.is-not-stacked-on-mobile)>.wp-block-column:not(:last-child) {
			margin-bottom: var(--wp--style--block-gap, 1.75rem)
		}

		@media (min-width:782px) {
			.wp-block-columns[class*=fullwidth-cols]:not(.is-not-stacked-on-mobile)>.wp-block-column:not(:last-child) {
				margin-bottom: 0
			}
		}

		.wp-block-columns[class*=fullwidth-cols].is-not-stacked-on-mobile>.wp-block-column {
			margin-bottom: 0 !important
		}

		@media (min-width:600px) and (max-width:781px) {
			.wp-block-columns[class*=fullwidth-cols]:not(.is-not-stacked-on-mobile)>.wp-block-column:nth-child(2n) {
				margin-left: var(--wp--style--block-gap, 2em)
			}
		}

		@media (max-width:781px) {
			.tablet\:fullwidth-cols.wp-block-columns:not(.is-not-stacked-on-mobile) {
				flex-wrap: wrap
			}

			.tablet\:fullwidth-cols.wp-block-columns:not(.is-not-stacked-on-mobile)>.wp-block-column,
			.tablet\:fullwidth-cols.wp-block-columns:not(.is-not-stacked-on-mobile)>.wp-block-column:not([style*=margin]) {
				margin-left: 0 !important
			}

			.tablet\:fullwidth-cols.wp-block-columns:not(.is-not-stacked-on-mobile)>.wp-block-column {
				flex-basis: 100% !important
			}
		}

		@media (max-width:1079px) {
			.desktop\:fullwidth-cols.wp-block-columns:not(.is-not-stacked-on-mobile) {
				flex-wrap: wrap
			}

			.desktop\:fullwidth-cols.wp-block-columns:not(.is-not-stacked-on-mobile)>.wp-block-column,
			.desktop\:fullwidth-cols.wp-block-columns:not(.is-not-stacked-on-mobile)>.wp-block-column:not([style*=margin]) {
				margin-left: 0 !important
			}

			.desktop\:fullwidth-cols.wp-block-columns:not(.is-not-stacked-on-mobile)>.wp-block-column {
				flex-basis: 100% !important
			}

			.desktop\:fullwidth-cols.wp-block-columns:not(.is-not-stacked-on-mobile)>.wp-block-column:not(:last-child) {
				margin-bottom: var(--wp--style--block-gap, 1.75rem) !important
			}
		}

		.direction-rtl {
			direction: rtl
		}

		.direction-ltr {
			direction: ltr
		}

		.is-style-inline-list {
			padding-left: 0 !important
		}

		.is-style-inline-list li {
			list-style-type: none !important
		}

		@media (min-width:782px) {
			.is-style-inline-list li {
				display: inline !important;
				margin-right: var(--wp--style--block-gap, 1.75rem) !important
			}
		}

		@media (min-width:782px) {
			.is-style-inline-list li:first-child {
				margin-left: 0 !important
			}
		}

		@media (min-width:782px) {
			.is-style-inline-list li:last-child {
				margin-right: 0 !important
			}
		}

		.bring-to-front {
			position: relative;
			z-index: 10
		}

		.text-stroke {
			-webkit-text-stroke-color: var(--wp--preset--color--background)
		}

		.text-stroke,
		.text-stroke--primary {
			-webkit-text-stroke-width: var(--wp--custom--typography--text-stroke-width, 2px)
		}

		.text-stroke--primary {
			-webkit-text-stroke-color: var(--wp--preset--color--primary)
		}

		.text-stroke--secondary {
			-webkit-text-stroke-width: var(--wp--custom--typography--text-stroke-width, 2px);
			-webkit-text-stroke-color: var(--wp--preset--color--secondary)
		}

		.editor\:no-caption .block-editor-rich-text__editable {
			display: none !important
		}

		.editor\:no-inserter .wp-block-column:not(.is-selected)>.block-list-appender,
		.editor\:no-inserter .wp-block-cover__inner-container>.block-list-appender,
		.editor\:no-inserter .wp-block-group__inner-container>.block-list-appender,
		.editor\:no-inserter>.block-list-appender {
			display: none
		}

		.editor\:no-resize .components-resizable-box__handle,
		.editor\:no-resize .components-resizable-box__handle:after,
		.editor\:no-resize .components-resizable-box__side-handle:before {
			display: none;
			pointer-events: none
		}

		.editor\:no-resize .components-resizable-box__container {
			display: block
		}

		.editor\:pointer-events-none {
			pointer-events: none
		}

		.is-style-angled {
			justify-content: flex-end
		}

		.ext .is-style-angled>[class*=_inner-container],
		.is-style-angled {
			align-items: center
		}

		.is-style-angled .wp-block-cover__image-background,
		.is-style-angled .wp-block-cover__video-background {
			-webkit-clip-path: polygon(0 0, 30% 0, 50% 100%, 0 100%);
			clip-path: polygon(0 0, 30% 0, 50% 100%, 0 100%);
			z-index: 1
		}

		@media (min-width:782px) {

			.is-style-angled .wp-block-cover__image-background,
			.is-style-angled .wp-block-cover__video-background {
				-webkit-clip-path: polygon(0 0, 55% 0, 65% 100%, 0 100%);
				clip-path: polygon(0 0, 55% 0, 65% 100%, 0 100%)
			}
		}

		.has-foreground-color {
			color: var(--wp--preset--color--foreground, #000) !important
		}

		.has-foreground-background-color {
			background-color: var(--wp--preset--color--foreground, #000) !important
		}

		.has-background-color {
			color: var(--wp--preset--color--background, #fff) !important
		}

		.has-background-background-color {
			background-color: var(--wp--preset--color--background, #fff) !important
		}

		.has-primary-color {
			color: var(--wp--preset--color--primary, #4b5563) !important
		}

		.has-primary-background-color {
			background-color: var(--wp--preset--color--primary, #4b5563) !important
		}

		.has-secondary-color {
			color: var(--wp--preset--color--secondary, #9ca3af) !important
		}

		.has-secondary-background-color {
			background-color: var(--wp--preset--color--secondary, #9ca3af) !important
		}

		.ext.has-text-color h1,
		.ext.has-text-color h2,
		.ext.has-text-color h3,
		.ext.has-text-color h4,
		.ext.has-text-color h5,
		.ext.has-text-color h6,
		.ext.has-text-color p {
			color: currentColor
		}

		.has-white-color {
			color: var(--wp--preset--color--white, #fff) !important
		}

		.has-black-color {
			color: var(--wp--preset--color--black, #000) !important
		}

		.has-ext-foreground-background-color {
			background-color: var(--wp--preset--color--foreground, var(--wp--preset--color--black, #000)) !important
		}

		.has-ext-primary-background-color {
			background-color: var(--wp--preset--color--primary, var(--wp--preset--color--cyan-bluish-gray, #000)) !important
		}

		.wp-block-button__link.has-black-background-color {
			border-color: var(--wp--preset--color--black, #000)
		}

		.wp-block-button__link.has-white-background-color {
			border-color: var(--wp--preset--color--white, #fff)
		}

		.has-ext-small-font-size {
			font-size: var(--wp--preset--font-size--ext-small) !important
		}

		.has-ext-medium-font-size {
			font-size: var(--wp--preset--font-size--ext-medium) !important
		}

		.has-ext-large-font-size {
			font-size: var(--wp--preset--font-size--ext-large) !important;
			line-height: 1.2
		}

		.has-ext-x-large-font-size {
			font-size: var(--wp--preset--font-size--ext-x-large) !important;
			line-height: 1
		}

		.has-ext-xx-large-font-size {
			font-size: var(--wp--preset--font-size--ext-xx-large) !important;
			line-height: 1
		}

		.has-ext-x-large-font-size:not([style*=line-height]),
		.has-ext-xx-large-font-size:not([style*=line-height]) {
			line-height: 1.1
		}

		.ext .wp-block-group>* {
			margin-bottom: 0;
			margin-top: 0
		}

		.ext .wp-block-group>*+* {
			margin-bottom: 0
		}

		.ext .wp-block-group>*+*,
		.ext h2 {
			margin-top: var(--wp--style--block-gap, 1.75rem)
		}

		.ext h2 {
			margin-bottom: var(--wp--style--block-gap, 1.75rem)
		}

		.has-ext-x-large-font-size+h3,
		.has-ext-x-large-font-size+p {
			margin-top: .5rem
		}

		.ext .wp-block-buttons>.wp-block-button.wp-block-button__width-25 {
			min-width: 12rem;
			width: calc(25% - var(--wp--style--block-gap, .5em)*.75)
		}

		.ext .ext-grid>[class*=_inner-container] {
			display: grid
		}

		.ext>[class*=_inner-container]>.ext-grid:not([class*=columns]),
		.ext>[class*=_inner-container]>.wp-block>.ext-grid:not([class*=columns]) {
			display: initial !important
		}

		.ext .ext-grid-cols-1>[class*=_inner-container] {
			grid-template-columns: repeat(1, minmax(0, 1fr)) !important
		}

		.ext .ext-grid-cols-2>[class*=_inner-container] {
			grid-template-columns: repeat(2, minmax(0, 1fr)) !important
		}

		.ext .ext-grid-cols-3>[class*=_inner-container] {
			grid-template-columns: repeat(3, minmax(0, 1fr)) !important
		}

		.ext .ext-grid-cols-4>[class*=_inner-container] {
			grid-template-columns: repeat(4, minmax(0, 1fr)) !important
		}

		.ext .ext-grid-cols-5>[class*=_inner-container] {
			grid-template-columns: repeat(5, minmax(0, 1fr)) !important
		}

		.ext .ext-grid-cols-6>[class*=_inner-container] {
			grid-template-columns: repeat(6, minmax(0, 1fr)) !important
		}

		.ext .ext-grid-cols-7>[class*=_inner-container] {
			grid-template-columns: repeat(7, minmax(0, 1fr)) !important
		}

		.ext .ext-grid-cols-8>[class*=_inner-container] {
			grid-template-columns: repeat(8, minmax(0, 1fr)) !important
		}

		.ext .ext-grid-cols-9>[class*=_inner-container] {
			grid-template-columns: repeat(9, minmax(0, 1fr)) !important
		}

		.ext .ext-grid-cols-10>[class*=_inner-container] {
			grid-template-columns: repeat(10, minmax(0, 1fr)) !important
		}

		.ext .ext-grid-cols-11>[class*=_inner-container] {
			grid-template-columns: repeat(11, minmax(0, 1fr)) !important
		}

		.ext .ext-grid-cols-12>[class*=_inner-container] {
			grid-template-columns: repeat(12, minmax(0, 1fr)) !important
		}

		.ext .ext-grid-cols-13>[class*=_inner-container] {
			grid-template-columns: repeat(13, minmax(0, 1fr)) !important
		}

		.ext .ext-grid-cols-none>[class*=_inner-container] {
			grid-template-columns: none !important
		}

		.ext .ext-grid-rows-1>[class*=_inner-container] {
			grid-template-rows: repeat(1, minmax(0, 1fr)) !important
		}

		.ext .ext-grid-rows-2>[class*=_inner-container] {
			grid-template-rows: repeat(2, minmax(0, 1fr)) !important
		}

		.ext .ext-grid-rows-3>[class*=_inner-container] {
			grid-template-rows: repeat(3, minmax(0, 1fr)) !important
		}

		.ext .ext-grid-rows-4>[class*=_inner-container] {
			grid-template-rows: repeat(4, minmax(0, 1fr)) !important
		}

		.ext .ext-grid-rows-5>[class*=_inner-container] {
			grid-template-rows: repeat(5, minmax(0, 1fr)) !important
		}

		.ext .ext-grid-rows-6>[class*=_inner-container] {
			grid-template-rows: repeat(6, minmax(0, 1fr)) !important
		}

		.ext .ext-grid-rows-none>[class*=_inner-container] {
			grid-template-rows: none !important
		}

		.ext .ext-items-start>[class*=_inner-container] {
			align-items: flex-start !important
		}

		.ext .ext-items-end>[class*=_inner-container] {
			align-items: flex-end !important
		}

		.ext .ext-items-center>[class*=_inner-container] {
			align-items: center !important
		}

		.ext .ext-items-baseline>[class*=_inner-container] {
			align-items: baseline !important
		}

		.ext .ext-items-stretch>[class*=_inner-container] {
			align-items: stretch !important
		}

		.ext.wp-block-group>:last-child {
			margin-bottom: 0
		}

		.ext .wp-block-group__inner-container {
			padding: 0 !important
		}

		.ext.has-background {
			padding-left: var(--wp--style--block-gap, 1.75rem);
			padding-right: var(--wp--style--block-gap, 1.75rem)
		}

		.ext [class*=inner-container]>.alignwide [class*=inner-container],
		.ext [class*=inner-container]>[data-align=wide] [class*=inner-container] {
			max-width: var(--responsive--alignwide-width, 120rem)
		}

		.ext [class*=inner-container]>.alignwide [class*=inner-container]>*,
		.ext [class*=inner-container]>[data-align=wide] [class*=inner-container]>* {
			max-width: 100% !important
		}

		.ext .wp-block-image {
			position: relative;
			text-align: center
		}

		.ext .wp-block-image img {
			display: inline-block;
			vertical-align: middle
		}

		body {
			--extendify--spacing--large: var(--wp--custom--spacing--large, clamp(2em, 8vw, 8em));
			--wp--preset--font-size--ext-small: 1rem;
			--wp--preset--font-size--ext-medium: 1.125rem;
			--wp--preset--font-size--ext-large: clamp(1.65rem, 3.5vw, 2.15rem);
			--wp--preset--font-size--ext-x-large: clamp(3rem, 6vw, 4.75rem);
			--wp--preset--font-size--ext-xx-large: clamp(3.25rem, 7.5vw, 5.75rem);
			--wp--preset--color--black: #000;
			--wp--preset--color--white: #fff
		}

		.ext * {
			box-sizing: border-box
		}

		.block-editor-block-preview__content-iframe .ext [data-type="core/spacer"] .components-resizable-box__container {
			background: transparent !important
		}

		.block-editor-block-preview__content-iframe .ext [data-type="core/spacer"] .block-library-spacer__resize-container:before {
			display: none !important
		}

		.ext .wp-block-group__inner-container figure.wp-block-gallery.alignfull {
			margin-bottom: unset;
			margin-top: unset
		}

		.ext .alignwide {
			margin-left: auto !important;
			margin-right: auto !important
		}

		.is-root-container.block-editor-block-list__layout>[data-align=full]:not(:first-of-type)>.ext-my-0,
		.is-root-container.block-editor-block-list__layout>[data-align=wide]>.ext-my-0:not([style*=margin]) {
			margin-top: calc(var(--wp--style--block-gap, 28px)*-1) !important
		}

		.block-editor-block-preview__content-iframe .preview\:min-h-50 {
			min-height: 50vw !important
		}

		.block-editor-block-preview__content-iframe .preview\:min-h-60 {
			min-height: 60vw !important
		}

		.block-editor-block-preview__content-iframe .preview\:min-h-70 {
			min-height: 70vw !important
		}

		.block-editor-block-preview__content-iframe .preview\:min-h-80 {
			min-height: 80vw !important
		}

		.block-editor-block-preview__content-iframe .preview\:min-h-100 {
			min-height: 100vw !important
		}

		.ext-mr-0.alignfull:not([style*=margin]):not([style*=margin]) {
			margin-right: 0 !important
		}

		.ext-ml-0:not([style*=margin]):not([style*=margin]) {
			margin-left: 0 !important
		}

		.is-root-container .wp-block[data-align=full]>.ext-mx-0:not([style*=margin]):not([style*=margin]) {
			margin-left: calc(var(--wp--custom--spacing--outer, 0)*1) !important;
			margin-right: calc(var(--wp--custom--spacing--outer, 0)*1) !important;
			overflow: hidden;
			width: unset
		}

		@media (min-width:782px) {
			.tablet\:ext-absolute {
				position: absolute !important
			}

			.tablet\:ext-relative {
				position: relative !important
			}

			.tablet\:ext-top-base {
				top: var(--wp--style--block-gap, 1.75rem) !important
			}

			.tablet\:ext-top-lg {
				top: var(--extendify--spacing--large, 3rem) !important
			}

			.tablet\:ext--top-base {
				top: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
			}

			.tablet\:ext--top-lg {
				top: calc(var(--extendify--spacing--large, 3rem)*-1) !important
			}

			.tablet\:ext-right-base {
				right: var(--wp--style--block-gap, 1.75rem) !important
			}

			.tablet\:ext-right-lg {
				right: var(--extendify--spacing--large, 3rem) !important
			}

			.tablet\:ext--right-base {
				right: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
			}

			.tablet\:ext--right-lg {
				right: calc(var(--extendify--spacing--large, 3rem)*-1) !important
			}

			.tablet\:ext-bottom-base {
				bottom: var(--wp--style--block-gap, 1.75rem) !important
			}

			.tablet\:ext-bottom-lg {
				bottom: var(--extendify--spacing--large, 3rem) !important
			}

			.tablet\:ext--bottom-base {
				bottom: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
			}

			.tablet\:ext--bottom-lg {
				bottom: calc(var(--extendify--spacing--large, 3rem)*-1) !important
			}

			.tablet\:ext-left-base {
				left: var(--wp--style--block-gap, 1.75rem) !important
			}

			.tablet\:ext-left-lg {
				left: var(--extendify--spacing--large, 3rem) !important
			}

			.tablet\:ext--left-base {
				left: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
			}

			.tablet\:ext--left-lg {
				left: calc(var(--extendify--spacing--large, 3rem)*-1) !important
			}

			.tablet\:ext-order-1 {
				order: 1 !important
			}

			.tablet\:ext-order-2 {
				order: 2 !important
			}

			.tablet\:ext-m-0:not([style*=margin]) {
				margin: 0 !important
			}

			.tablet\:ext-m-auto:not([style*=margin]) {
				margin: auto !important
			}

			.tablet\:ext-m-base:not([style*=margin]) {
				margin: var(--wp--style--block-gap, 1.75rem) !important
			}

			.tablet\:ext-m-lg:not([style*=margin]) {
				margin: var(--extendify--spacing--large, 3rem) !important
			}

			.tablet\:ext--m-base:not([style*=margin]) {
				margin: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
			}

			.tablet\:ext--m-lg:not([style*=margin]) {
				margin: calc(var(--extendify--spacing--large, 3rem)*-1) !important
			}

			.tablet\:ext-mx-0:not([style*=margin]) {
				margin-left: 0 !important;
				margin-right: 0 !important
			}

			.tablet\:ext-mx-auto:not([style*=margin]) {
				margin-left: auto !important;
				margin-right: auto !important
			}

			.tablet\:ext-mx-base:not([style*=margin]) {
				margin-left: var(--wp--style--block-gap, 1.75rem) !important;
				margin-right: var(--wp--style--block-gap, 1.75rem) !important
			}

			.tablet\:ext-mx-lg:not([style*=margin]) {
				margin-left: var(--extendify--spacing--large, 3rem) !important;
				margin-right: var(--extendify--spacing--large, 3rem) !important
			}

			.tablet\:ext--mx-base:not([style*=margin]) {
				margin-left: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important;
				margin-right: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
			}

			.tablet\:ext--mx-lg:not([style*=margin]) {
				margin-left: calc(var(--extendify--spacing--large, 3rem)*-1) !important;
				margin-right: calc(var(--extendify--spacing--large, 3rem)*-1) !important
			}

			.tablet\:ext-my-0:not([style*=margin]) {
				margin-bottom: 0 !important;
				margin-top: 0 !important
			}

			.tablet\:ext-my-auto:not([style*=margin]) {
				margin-bottom: auto !important;
				margin-top: auto !important
			}

			.tablet\:ext-my-base:not([style*=margin]) {
				margin-bottom: var(--wp--style--block-gap, 1.75rem) !important;
				margin-top: var(--wp--style--block-gap, 1.75rem) !important
			}

			.tablet\:ext-my-lg:not([style*=margin]) {
				margin-bottom: var(--extendify--spacing--large, 3rem) !important;
				margin-top: var(--extendify--spacing--large, 3rem) !important
			}

			.tablet\:ext--my-base:not([style*=margin]) {
				margin-bottom: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important;
				margin-top: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
			}

			.tablet\:ext--my-lg:not([style*=margin]) {
				margin-bottom: calc(var(--extendify--spacing--large, 3rem)*-1) !important;
				margin-top: calc(var(--extendify--spacing--large, 3rem)*-1) !important
			}

			.tablet\:ext-mt-0:not([style*=margin]) {
				margin-top: 0 !important
			}

			.tablet\:ext-mt-auto:not([style*=margin]) {
				margin-top: auto !important
			}

			.tablet\:ext-mt-base:not([style*=margin]) {
				margin-top: var(--wp--style--block-gap, 1.75rem) !important
			}

			.tablet\:ext-mt-lg:not([style*=margin]) {
				margin-top: var(--extendify--spacing--large, 3rem) !important
			}

			.tablet\:ext--mt-base:not([style*=margin]) {
				margin-top: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
			}

			.tablet\:ext--mt-lg:not([style*=margin]) {
				margin-top: calc(var(--extendify--spacing--large, 3rem)*-1) !important
			}

			.tablet\:ext-mr-0:not([style*=margin]) {
				margin-right: 0 !important
			}

			.tablet\:ext-mr-auto:not([style*=margin]) {
				margin-right: auto !important
			}

			.tablet\:ext-mr-base:not([style*=margin]) {
				margin-right: var(--wp--style--block-gap, 1.75rem) !important
			}

			.tablet\:ext-mr-lg:not([style*=margin]) {
				margin-right: var(--extendify--spacing--large, 3rem) !important
			}

			.tablet\:ext--mr-base:not([style*=margin]) {
				margin-right: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
			}

			.tablet\:ext--mr-lg:not([style*=margin]) {
				margin-right: calc(var(--extendify--spacing--large, 3rem)*-1) !important
			}

			.tablet\:ext-mb-0:not([style*=margin]) {
				margin-bottom: 0 !important
			}

			.tablet\:ext-mb-auto:not([style*=margin]) {
				margin-bottom: auto !important
			}

			.tablet\:ext-mb-base:not([style*=margin]) {
				margin-bottom: var(--wp--style--block-gap, 1.75rem) !important
			}

			.tablet\:ext-mb-lg:not([style*=margin]) {
				margin-bottom: var(--extendify--spacing--large, 3rem) !important
			}

			.tablet\:ext--mb-base:not([style*=margin]) {
				margin-bottom: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
			}

			.tablet\:ext--mb-lg:not([style*=margin]) {
				margin-bottom: calc(var(--extendify--spacing--large, 3rem)*-1) !important
			}

			.tablet\:ext-ml-0:not([style*=margin]) {
				margin-left: 0 !important
			}

			.tablet\:ext-ml-auto:not([style*=margin]) {
				margin-left: auto !important
			}

			.tablet\:ext-ml-base:not([style*=margin]) {
				margin-left: var(--wp--style--block-gap, 1.75rem) !important
			}

			.tablet\:ext-ml-lg:not([style*=margin]) {
				margin-left: var(--extendify--spacing--large, 3rem) !important
			}

			.tablet\:ext--ml-base:not([style*=margin]) {
				margin-left: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
			}

			.tablet\:ext--ml-lg:not([style*=margin]) {
				margin-left: calc(var(--extendify--spacing--large, 3rem)*-1) !important
			}

			.tablet\:ext-block {
				display: block !important
			}

			.tablet\:ext-inline-block {
				display: inline-block !important
			}

			.tablet\:ext-inline {
				display: inline !important
			}

			.tablet\:ext-flex {
				display: flex !important
			}

			.tablet\:ext-inline-flex {
				display: inline-flex !important
			}

			.tablet\:ext-grid {
				display: grid !important
			}

			.tablet\:ext-inline-grid {
				display: inline-grid !important
			}

			.tablet\:ext-hidden {
				display: none !important
			}

			.tablet\:ext-w-auto {
				width: auto !important
			}

			.tablet\:ext-w-full {
				width: 100% !important
			}

			.tablet\:ext-max-w-full {
				max-width: 100% !important
			}

			.tablet\:ext-flex-1 {
				flex: 1 1 0% !important
			}

			.tablet\:ext-flex-auto {
				flex: 1 1 auto !important
			}

			.tablet\:ext-flex-initial {
				flex: 0 1 auto !important
			}

			.tablet\:ext-flex-none {
				flex: none !important
			}

			.tablet\:ext-flex-shrink-0 {
				flex-shrink: 0 !important
			}

			.tablet\:ext-flex-shrink {
				flex-shrink: 1 !important
			}

			.tablet\:ext-flex-grow-0 {
				flex-grow: 0 !important
			}

			.tablet\:ext-flex-grow {
				flex-grow: 1 !important
			}

			.tablet\:ext-list-none {
				list-style-type: none !important
			}

			.tablet\:ext-grid-cols-1 {
				grid-template-columns: repeat(1, minmax(0, 1fr)) !important
			}

			.tablet\:ext-grid-cols-2 {
				grid-template-columns: repeat(2, minmax(0, 1fr)) !important
			}

			.tablet\:ext-grid-cols-3 {
				grid-template-columns: repeat(3, minmax(0, 1fr)) !important
			}

			.tablet\:ext-grid-cols-4 {
				grid-template-columns: repeat(4, minmax(0, 1fr)) !important
			}

			.tablet\:ext-grid-cols-5 {
				grid-template-columns: repeat(5, minmax(0, 1fr)) !important
			}

			.tablet\:ext-grid-cols-6 {
				grid-template-columns: repeat(6, minmax(0, 1fr)) !important
			}

			.tablet\:ext-grid-cols-7 {
				grid-template-columns: repeat(7, minmax(0, 1fr)) !important
			}

			.tablet\:ext-grid-cols-8 {
				grid-template-columns: repeat(8, minmax(0, 1fr)) !important
			}

			.tablet\:ext-grid-cols-9 {
				grid-template-columns: repeat(9, minmax(0, 1fr)) !important
			}

			.tablet\:ext-grid-cols-10 {
				grid-template-columns: repeat(10, minmax(0, 1fr)) !important
			}

			.tablet\:ext-grid-cols-11 {
				grid-template-columns: repeat(11, minmax(0, 1fr)) !important
			}

			.tablet\:ext-grid-cols-12 {
				grid-template-columns: repeat(12, minmax(0, 1fr)) !important
			}

			.tablet\:ext-grid-cols-none {
				grid-template-columns: none !important
			}

			.tablet\:ext-flex-row {
				flex-direction: row !important
			}

			.tablet\:ext-flex-row-reverse {
				flex-direction: row-reverse !important
			}

			.tablet\:ext-flex-col {
				flex-direction: column !important
			}

			.tablet\:ext-flex-col-reverse {
				flex-direction: column-reverse !important
			}

			.tablet\:ext-flex-wrap {
				flex-wrap: wrap !important
			}

			.tablet\:ext-flex-wrap-reverse {
				flex-wrap: wrap-reverse !important
			}

			.tablet\:ext-flex-nowrap {
				flex-wrap: nowrap !important
			}

			.tablet\:ext-items-start {
				align-items: flex-start !important
			}

			.tablet\:ext-items-end {
				align-items: flex-end !important
			}

			.tablet\:ext-items-center {
				align-items: center !important
			}

			.tablet\:ext-items-baseline {
				align-items: baseline !important
			}

			.tablet\:ext-items-stretch {
				align-items: stretch !important
			}

			.tablet\:ext-justify-start {
				justify-content: flex-start !important
			}

			.tablet\:ext-justify-end {
				justify-content: flex-end !important
			}

			.tablet\:ext-justify-center {
				justify-content: center !important
			}

			.tablet\:ext-justify-between {
				justify-content: space-between !important
			}

			.tablet\:ext-justify-around {
				justify-content: space-around !important
			}

			.tablet\:ext-justify-evenly {
				justify-content: space-evenly !important
			}

			.tablet\:ext-justify-items-start {
				justify-items: start !important
			}

			.tablet\:ext-justify-items-end {
				justify-items: end !important
			}

			.tablet\:ext-justify-items-center {
				justify-items: center !important
			}

			.tablet\:ext-justify-items-stretch {
				justify-items: stretch !important
			}

			.tablet\:ext-justify-self-auto {
				justify-self: auto !important
			}

			.tablet\:ext-justify-self-start {
				justify-self: start !important
			}

			.tablet\:ext-justify-self-end {
				justify-self: end !important
			}

			.tablet\:ext-justify-self-center {
				justify-self: center !important
			}

			.tablet\:ext-justify-self-stretch {
				justify-self: stretch !important
			}

			.tablet\:ext-p-0:not([style*=padding]) {
				padding: 0 !important
			}

			.tablet\:ext-p-base:not([style*=padding]) {
				padding: var(--wp--style--block-gap, 1.75rem) !important
			}

			.tablet\:ext-p-lg:not([style*=padding]) {
				padding: var(--extendify--spacing--large, 3rem) !important
			}

			.tablet\:ext-px-0:not([style*=padding]) {
				padding-left: 0 !important;
				padding-right: 0 !important
			}

			.tablet\:ext-px-base:not([style*=padding]) {
				padding-left: var(--wp--style--block-gap, 1.75rem) !important;
				padding-right: var(--wp--style--block-gap, 1.75rem) !important
			}

			.tablet\:ext-px-lg:not([style*=padding]) {
				padding-left: var(--extendify--spacing--large, 3rem) !important;
				padding-right: var(--extendify--spacing--large, 3rem) !important
			}

			.tablet\:ext-py-0:not([style*=padding]) {
				padding-bottom: 0 !important;
				padding-top: 0 !important
			}

			.tablet\:ext-py-base:not([style*=padding]) {
				padding-bottom: var(--wp--style--block-gap, 1.75rem) !important;
				padding-top: var(--wp--style--block-gap, 1.75rem) !important
			}

			.tablet\:ext-py-lg:not([style*=padding]) {
				padding-bottom: var(--extendify--spacing--large, 3rem) !important;
				padding-top: var(--extendify--spacing--large, 3rem) !important
			}

			.tablet\:ext-pt-0:not([style*=padding]) {
				padding-top: 0 !important
			}

			.tablet\:ext-pt-base:not([style*=padding]) {
				padding-top: var(--wp--style--block-gap, 1.75rem) !important
			}

			.tablet\:ext-pt-lg:not([style*=padding]) {
				padding-top: var(--extendify--spacing--large, 3rem) !important
			}

			.tablet\:ext-pr-0:not([style*=padding]) {
				padding-right: 0 !important
			}

			.tablet\:ext-pr-base:not([style*=padding]) {
				padding-right: var(--wp--style--block-gap, 1.75rem) !important
			}

			.tablet\:ext-pr-lg:not([style*=padding]) {
				padding-right: var(--extendify--spacing--large, 3rem) !important
			}

			.tablet\:ext-pb-0:not([style*=padding]) {
				padding-bottom: 0 !important
			}

			.tablet\:ext-pb-base:not([style*=padding]) {
				padding-bottom: var(--wp--style--block-gap, 1.75rem) !important
			}

			.tablet\:ext-pb-lg:not([style*=padding]) {
				padding-bottom: var(--extendify--spacing--large, 3rem) !important
			}

			.tablet\:ext-pl-0:not([style*=padding]) {
				padding-left: 0 !important
			}

			.tablet\:ext-pl-base:not([style*=padding]) {
				padding-left: var(--wp--style--block-gap, 1.75rem) !important
			}

			.tablet\:ext-pl-lg:not([style*=padding]) {
				padding-left: var(--extendify--spacing--large, 3rem) !important
			}

			.tablet\:ext-text-left {
				text-align: left !important
			}

			.tablet\:ext-text-center {
				text-align: center !important
			}

			.tablet\:ext-text-right {
				text-align: right !important
			}
		}

		@media (min-width:1080px) {
			.desktop\:ext-absolute {
				position: absolute !important
			}

			.desktop\:ext-relative {
				position: relative !important
			}

			.desktop\:ext-top-base {
				top: var(--wp--style--block-gap, 1.75rem) !important
			}

			.desktop\:ext-top-lg {
				top: var(--extendify--spacing--large, 3rem) !important
			}

			.desktop\:ext--top-base {
				top: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
			}

			.desktop\:ext--top-lg {
				top: calc(var(--extendify--spacing--large, 3rem)*-1) !important
			}

			.desktop\:ext-right-base {
				right: var(--wp--style--block-gap, 1.75rem) !important
			}

			.desktop\:ext-right-lg {
				right: var(--extendify--spacing--large, 3rem) !important
			}

			.desktop\:ext--right-base {
				right: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
			}

			.desktop\:ext--right-lg {
				right: calc(var(--extendify--spacing--large, 3rem)*-1) !important
			}

			.desktop\:ext-bottom-base {
				bottom: var(--wp--style--block-gap, 1.75rem) !important
			}

			.desktop\:ext-bottom-lg {
				bottom: var(--extendify--spacing--large, 3rem) !important
			}

			.desktop\:ext--bottom-base {
				bottom: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
			}

			.desktop\:ext--bottom-lg {
				bottom: calc(var(--extendify--spacing--large, 3rem)*-1) !important
			}

			.desktop\:ext-left-base {
				left: var(--wp--style--block-gap, 1.75rem) !important
			}

			.desktop\:ext-left-lg {
				left: var(--extendify--spacing--large, 3rem) !important
			}

			.desktop\:ext--left-base {
				left: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
			}

			.desktop\:ext--left-lg {
				left: calc(var(--extendify--spacing--large, 3rem)*-1) !important
			}

			.desktop\:ext-order-1 {
				order: 1 !important
			}

			.desktop\:ext-order-2 {
				order: 2 !important
			}

			.desktop\:ext-m-0:not([style*=margin]) {
				margin: 0 !important
			}

			.desktop\:ext-m-auto:not([style*=margin]) {
				margin: auto !important
			}

			.desktop\:ext-m-base:not([style*=margin]) {
				margin: var(--wp--style--block-gap, 1.75rem) !important
			}

			.desktop\:ext-m-lg:not([style*=margin]) {
				margin: var(--extendify--spacing--large, 3rem) !important
			}

			.desktop\:ext--m-base:not([style*=margin]) {
				margin: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
			}

			.desktop\:ext--m-lg:not([style*=margin]) {
				margin: calc(var(--extendify--spacing--large, 3rem)*-1) !important
			}

			.desktop\:ext-mx-0:not([style*=margin]) {
				margin-left: 0 !important;
				margin-right: 0 !important
			}

			.desktop\:ext-mx-auto:not([style*=margin]) {
				margin-left: auto !important;
				margin-right: auto !important
			}

			.desktop\:ext-mx-base:not([style*=margin]) {
				margin-left: var(--wp--style--block-gap, 1.75rem) !important;
				margin-right: var(--wp--style--block-gap, 1.75rem) !important
			}

			.desktop\:ext-mx-lg:not([style*=margin]) {
				margin-left: var(--extendify--spacing--large, 3rem) !important;
				margin-right: var(--extendify--spacing--large, 3rem) !important
			}

			.desktop\:ext--mx-base:not([style*=margin]) {
				margin-left: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important;
				margin-right: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
			}

			.desktop\:ext--mx-lg:not([style*=margin]) {
				margin-left: calc(var(--extendify--spacing--large, 3rem)*-1) !important;
				margin-right: calc(var(--extendify--spacing--large, 3rem)*-1) !important
			}

			.desktop\:ext-my-0:not([style*=margin]) {
				margin-bottom: 0 !important;
				margin-top: 0 !important
			}

			.desktop\:ext-my-auto:not([style*=margin]) {
				margin-bottom: auto !important;
				margin-top: auto !important
			}

			.desktop\:ext-my-base:not([style*=margin]) {
				margin-bottom: var(--wp--style--block-gap, 1.75rem) !important;
				margin-top: var(--wp--style--block-gap, 1.75rem) !important
			}

			.desktop\:ext-my-lg:not([style*=margin]) {
				margin-bottom: var(--extendify--spacing--large, 3rem) !important;
				margin-top: var(--extendify--spacing--large, 3rem) !important
			}

			.desktop\:ext--my-base:not([style*=margin]) {
				margin-bottom: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important;
				margin-top: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
			}

			.desktop\:ext--my-lg:not([style*=margin]) {
				margin-bottom: calc(var(--extendify--spacing--large, 3rem)*-1) !important;
				margin-top: calc(var(--extendify--spacing--large, 3rem)*-1) !important
			}

			.desktop\:ext-mt-0:not([style*=margin]) {
				margin-top: 0 !important
			}

			.desktop\:ext-mt-auto:not([style*=margin]) {
				margin-top: auto !important
			}

			.desktop\:ext-mt-base:not([style*=margin]) {
				margin-top: var(--wp--style--block-gap, 1.75rem) !important
			}

			.desktop\:ext-mt-lg:not([style*=margin]) {
				margin-top: var(--extendify--spacing--large, 3rem) !important
			}

			.desktop\:ext--mt-base:not([style*=margin]) {
				margin-top: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
			}

			.desktop\:ext--mt-lg:not([style*=margin]) {
				margin-top: calc(var(--extendify--spacing--large, 3rem)*-1) !important
			}

			.desktop\:ext-mr-0:not([style*=margin]) {
				margin-right: 0 !important
			}

			.desktop\:ext-mr-auto:not([style*=margin]) {
				margin-right: auto !important
			}

			.desktop\:ext-mr-base:not([style*=margin]) {
				margin-right: var(--wp--style--block-gap, 1.75rem) !important
			}

			.desktop\:ext-mr-lg:not([style*=margin]) {
				margin-right: var(--extendify--spacing--large, 3rem) !important
			}

			.desktop\:ext--mr-base:not([style*=margin]) {
				margin-right: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
			}

			.desktop\:ext--mr-lg:not([style*=margin]) {
				margin-right: calc(var(--extendify--spacing--large, 3rem)*-1) !important
			}

			.desktop\:ext-mb-0:not([style*=margin]) {
				margin-bottom: 0 !important
			}

			.desktop\:ext-mb-auto:not([style*=margin]) {
				margin-bottom: auto !important
			}

			.desktop\:ext-mb-base:not([style*=margin]) {
				margin-bottom: var(--wp--style--block-gap, 1.75rem) !important
			}

			.desktop\:ext-mb-lg:not([style*=margin]) {
				margin-bottom: var(--extendify--spacing--large, 3rem) !important
			}

			.desktop\:ext--mb-base:not([style*=margin]) {
				margin-bottom: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
			}

			.desktop\:ext--mb-lg:not([style*=margin]) {
				margin-bottom: calc(var(--extendify--spacing--large, 3rem)*-1) !important
			}

			.desktop\:ext-ml-0:not([style*=margin]) {
				margin-left: 0 !important
			}

			.desktop\:ext-ml-auto:not([style*=margin]) {
				margin-left: auto !important
			}

			.desktop\:ext-ml-base:not([style*=margin]) {
				margin-left: var(--wp--style--block-gap, 1.75rem) !important
			}

			.desktop\:ext-ml-lg:not([style*=margin]) {
				margin-left: var(--extendify--spacing--large, 3rem) !important
			}

			.desktop\:ext--ml-base:not([style*=margin]) {
				margin-left: calc(var(--wp--style--block-gap, 1.75rem)*-1) !important
			}

			.desktop\:ext--ml-lg:not([style*=margin]) {
				margin-left: calc(var(--extendify--spacing--large, 3rem)*-1) !important
			}

			.desktop\:ext-block {
				display: block !important
			}

			.desktop\:ext-inline-block {
				display: inline-block !important
			}

			.desktop\:ext-inline {
				display: inline !important
			}

			.desktop\:ext-flex {
				display: flex !important
			}

			.desktop\:ext-inline-flex {
				display: inline-flex !important
			}

			.desktop\:ext-grid {
				display: grid !important
			}

			.desktop\:ext-inline-grid {
				display: inline-grid !important
			}

			.desktop\:ext-hidden {
				display: none !important
			}

			.desktop\:ext-w-auto {
				width: auto !important
			}

			.desktop\:ext-w-full {
				width: 100% !important
			}

			.desktop\:ext-max-w-full {
				max-width: 100% !important
			}

			.desktop\:ext-flex-1 {
				flex: 1 1 0% !important
			}

			.desktop\:ext-flex-auto {
				flex: 1 1 auto !important
			}

			.desktop\:ext-flex-initial {
				flex: 0 1 auto !important
			}

			.desktop\:ext-flex-none {
				flex: none !important
			}

			.desktop\:ext-flex-shrink-0 {
				flex-shrink: 0 !important
			}

			.desktop\:ext-flex-shrink {
				flex-shrink: 1 !important
			}

			.desktop\:ext-flex-grow-0 {
				flex-grow: 0 !important
			}

			.desktop\:ext-flex-grow {
				flex-grow: 1 !important
			}

			.desktop\:ext-list-none {
				list-style-type: none !important
			}

			.desktop\:ext-grid-cols-1 {
				grid-template-columns: repeat(1, minmax(0, 1fr)) !important
			}

			.desktop\:ext-grid-cols-2 {
				grid-template-columns: repeat(2, minmax(0, 1fr)) !important
			}

			.desktop\:ext-grid-cols-3 {
				grid-template-columns: repeat(3, minmax(0, 1fr)) !important
			}

			.desktop\:ext-grid-cols-4 {
				grid-template-columns: repeat(4, minmax(0, 1fr)) !important
			}

			.desktop\:ext-grid-cols-5 {
				grid-template-columns: repeat(5, minmax(0, 1fr)) !important
			}

			.desktop\:ext-grid-cols-6 {
				grid-template-columns: repeat(6, minmax(0, 1fr)) !important
			}

			.desktop\:ext-grid-cols-7 {
				grid-template-columns: repeat(7, minmax(0, 1fr)) !important
			}

			.desktop\:ext-grid-cols-8 {
				grid-template-columns: repeat(8, minmax(0, 1fr)) !important
			}

			.desktop\:ext-grid-cols-9 {
				grid-template-columns: repeat(9, minmax(0, 1fr)) !important
			}

			.desktop\:ext-grid-cols-10 {
				grid-template-columns: repeat(10, minmax(0, 1fr)) !important
			}

			.desktop\:ext-grid-cols-11 {
				grid-template-columns: repeat(11, minmax(0, 1fr)) !important
			}

			.desktop\:ext-grid-cols-12 {
				grid-template-columns: repeat(12, minmax(0, 1fr)) !important
			}

			.desktop\:ext-grid-cols-none {
				grid-template-columns: none !important
			}

			.desktop\:ext-flex-row {
				flex-direction: row !important
			}

			.desktop\:ext-flex-row-reverse {
				flex-direction: row-reverse !important
			}

			.desktop\:ext-flex-col {
				flex-direction: column !important
			}

			.desktop\:ext-flex-col-reverse {
				flex-direction: column-reverse !important
			}

			.desktop\:ext-flex-wrap {
				flex-wrap: wrap !important
			}

			.desktop\:ext-flex-wrap-reverse {
				flex-wrap: wrap-reverse !important
			}

			.desktop\:ext-flex-nowrap {
				flex-wrap: nowrap !important
			}

			.desktop\:ext-items-start {
				align-items: flex-start !important
			}

			.desktop\:ext-items-end {
				align-items: flex-end !important
			}

			.desktop\:ext-items-center {
				align-items: center !important
			}

			.desktop\:ext-items-baseline {
				align-items: baseline !important
			}

			.desktop\:ext-items-stretch {
				align-items: stretch !important
			}

			.desktop\:ext-justify-start {
				justify-content: flex-start !important
			}

			.desktop\:ext-justify-end {
				justify-content: flex-end !important
			}

			.desktop\:ext-justify-center {
				justify-content: center !important
			}

			.desktop\:ext-justify-between {
				justify-content: space-between !important
			}

			.desktop\:ext-justify-around {
				justify-content: space-around !important
			}

			.desktop\:ext-justify-evenly {
				justify-content: space-evenly !important
			}

			.desktop\:ext-justify-items-start {
				justify-items: start !important
			}

			.desktop\:ext-justify-items-end {
				justify-items: end !important
			}

			.desktop\:ext-justify-items-center {
				justify-items: center !important
			}

			.desktop\:ext-justify-items-stretch {
				justify-items: stretch !important
			}

			.desktop\:ext-justify-self-auto {
				justify-self: auto !important
			}

			.desktop\:ext-justify-self-start {
				justify-self: start !important
			}

			.desktop\:ext-justify-self-end {
				justify-self: end !important
			}

			.desktop\:ext-justify-self-center {
				justify-self: center !important
			}

			.desktop\:ext-justify-self-stretch {
				justify-self: stretch !important
			}

			.desktop\:ext-p-0:not([style*=padding]) {
				padding: 0 !important
			}

			.desktop\:ext-p-base:not([style*=padding]) {
				padding: var(--wp--style--block-gap, 1.75rem) !important
			}

			.desktop\:ext-p-lg:not([style*=padding]) {
				padding: var(--extendify--spacing--large, 3rem) !important
			}

			.desktop\:ext-px-0:not([style*=padding]) {
				padding-left: 0 !important;
				padding-right: 0 !important
			}

			.desktop\:ext-px-base:not([style*=padding]) {
				padding-left: var(--wp--style--block-gap, 1.75rem) !important;
				padding-right: var(--wp--style--block-gap, 1.75rem) !important
			}

			.desktop\:ext-px-lg:not([style*=padding]) {
				padding-left: var(--extendify--spacing--large, 3rem) !important;
				padding-right: var(--extendify--spacing--large, 3rem) !important
			}

			.desktop\:ext-py-0:not([style*=padding]) {
				padding-bottom: 0 !important;
				padding-top: 0 !important
			}

			.desktop\:ext-py-base:not([style*=padding]) {
				padding-bottom: var(--wp--style--block-gap, 1.75rem) !important;
				padding-top: var(--wp--style--block-gap, 1.75rem) !important
			}

			.desktop\:ext-py-lg:not([style*=padding]) {
				padding-bottom: var(--extendify--spacing--large, 3rem) !important;
				padding-top: var(--extendify--spacing--large, 3rem) !important
			}

			.desktop\:ext-pt-0:not([style*=padding]) {
				padding-top: 0 !important
			}

			.desktop\:ext-pt-base:not([style*=padding]) {
				padding-top: var(--wp--style--block-gap, 1.75rem) !important
			}

			.desktop\:ext-pt-lg:not([style*=padding]) {
				padding-top: var(--extendify--spacing--large, 3rem) !important
			}

			.desktop\:ext-pr-0:not([style*=padding]) {
				padding-right: 0 !important
			}

			.desktop\:ext-pr-base:not([style*=padding]) {
				padding-right: var(--wp--style--block-gap, 1.75rem) !important
			}

			.desktop\:ext-pr-lg:not([style*=padding]) {
				padding-right: var(--extendify--spacing--large, 3rem) !important
			}

			.desktop\:ext-pb-0:not([style*=padding]) {
				padding-bottom: 0 !important
			}

			.desktop\:ext-pb-base:not([style*=padding]) {
				padding-bottom: var(--wp--style--block-gap, 1.75rem) !important
			}

			.desktop\:ext-pb-lg:not([style*=padding]) {
				padding-bottom: var(--extendify--spacing--large, 3rem) !important
			}

			.desktop\:ext-pl-0:not([style*=padding]) {
				padding-left: 0 !important
			}

			.desktop\:ext-pl-base:not([style*=padding]) {
				padding-left: var(--wp--style--block-gap, 1.75rem) !important
			}

			.desktop\:ext-pl-lg:not([style*=padding]) {
				padding-left: var(--extendify--spacing--large, 3rem) !important
			}

			.desktop\:ext-text-left {
				text-align: left !important
			}

			.desktop\:ext-text-center {
				text-align: center !important
			}

			.desktop\:ext-text-right {
				text-align: right !important
			}
		}
	</style>
	<link data-minify="1" rel='preload' href='https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/plugins/shi-plugins-thuocloban/css/loban.css?ver=1680517523' data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" onerror="this.removeAttribute('data-rocket-async')" type='text/css' media='all' />
	<link data-minify="1" rel='preload' href='https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/plugins/twenty20/assets/css/twenty20.css?ver=1680517523' data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" onerror="this.removeAttribute('data-rocket-async')" type='text/css' media='all' />
	<link data-minify="1" rel='preload' href="{{ asset('css/style_client.css') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" onerror="this.removeAttribute('data-rocket-async')" type='text/css' media='all' />
	<link rel='preload' href='https://noithatlacgia.vn/wp-content/themes/lacgia/css/owl.carousel.min.css?ver=6.0.3' data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" onerror="this.removeAttribute('data-rocket-async')" type='text/css' media='all' />
	<link data-minify="1" rel='preload' href="{{ asset('css/bootstrap.min.css') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" onerror="this.removeAttribute('data-rocket-async')" type='text/css' media='all' />
	<link data-minify="1" rel='preload' href="{{ asset('css/font-awesome.min.css') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" onerror="this.removeAttribute('data-rocket-async')" type='text/css' media='all' />
	<link data-minify="1" rel='preload' href="{{ asset('css/main.css') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" onerror="this.removeAttribute('data-rocket-async')" type='text/css' media='all' />
	<link data-minify="1" rel='preload' href='https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/themes/lacgia/css/fl_screen.css?ver=1680517523' data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" onerror="this.removeAttribute('data-rocket-async')" type='text/css' media='all' />
	<link rel='preload' href='https://noithatlacgia.vn/wp-content/themes/lacgia/js/owl.carousel.min.js?ver=6.0.3' data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" onerror="this.removeAttribute('data-rocket-async')" type='text/css' media='all' />
	<script type='text/javascript' src='https://noithatlacgia.vn/wp-includes/js/jquery/jquery.js?ver=3.6.0' id='jquery-core-js'></script>
	<script data-minify="1" type='text/javascript' src='https://noithatlacgia.vn/wp-content/cache/min/1/wp-includes/js/jquery/jquery-migrate.js?ver=1680517523' id='jquery-migrate-js'></script>
	<link rel="https://api.w.org/" href="https://noithatlacgia.vn/wp-json/" />
	<link rel="alternate" type="application/json" href="https://noithatlacgia.vn/wp-json/wp/v2/pages/3" />
	<link rel="EditURI" type="application/rsd+xml" title="RSD" href="https://noithatlacgia.vn/xmlrpc.php?rsd" />
	<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="https://noithatlacgia.vn/wp-includes/wlwmanifest.xml" />
	<meta name="generator" content="WordPress 6.0.3" />
	<link rel='shortlink' href='https://noithatlacgia.vn/' />
	<link rel="alternate" type="application/json+oembed" href="https://noithatlacgia.vn/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fnoithatlacgia.vn%2F" />
	<link rel="alternate" type="text/xml+oembed" href="https://noithatlacgia.vn/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fnoithatlacgia.vn%2F&#038;format=xml" />

	<!-- Meta Pixel Code -->
	<script type="rocketlazyloadscript" data-rocket-type='text/javascript'>
		!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
</script>
	<!-- End Meta Pixel Code -->
	<script type="rocketlazyloadscript" data-rocket-type='text/javascript'>
		fbq('init', '2951798121596047', {}, {
    "agent": "wordpress-6.0.3-3.0.7"
});
  </script>
	<script type="rocketlazyloadscript" data-rocket-type='text/javascript'>
		fbq('track', 'PageView', []);
  </script>
	<!-- Meta Pixel Code -->
	<noscript>
		<img height="1" width="1" style="display:none" alt="fbpx" src="https://www.facebook.com/tr?id=2951798121596047&ev=PageView&noscript=1" />
	</noscript>
	<!-- End Meta Pixel Code -->
	<style type="text/css">
		.recentcomments a {
			display: inline !important;
			padding: 0 !important;
			margin: 0 !important;
		}
	</style>
	<script type="rocketlazyloadscript">
		/*! loadCSS rel=preload polyfill. [c]2017 Filament Group, Inc. MIT License */
(function(w){"use strict";if(!w.loadCSS){w.loadCSS=function(){}}
var rp=loadCSS.relpreload={};rp.support=(function(){var ret;try{ret=w.document.createElement("link").relList.supports("preload")}catch(e){ret=!1}
return function(){return ret}})();rp.bindMediaToggle=function(link){var finalMedia=link.media||"all";function enableStylesheet(){link.media=finalMedia}
if(link.addEventListener){link.addEventListener("load",enableStylesheet)}else if(link.attachEvent){link.attachEvent("onload",enableStylesheet)}
setTimeout(function(){link.rel="stylesheet";link.media="only x"});setTimeout(enableStylesheet,3000)};rp.poly=function(){if(rp.support()){return}
var links=w.document.getElementsByTagName("link");for(var i=0;i<links.length;i++){var link=links[i];if(link.rel==="preload"&&link.getAttribute("as")==="style"&&!link.getAttribute("data-loadcss")){link.setAttribute("data-loadcss",!0);rp.bindMediaToggle(link)}}};if(!rp.support()){rp.poly();var run=w.setInterval(rp.poly,500);if(w.addEventListener){w.addEventListener("load",function(){rp.poly();w.clearInterval(run)})}else if(w.attachEvent){w.attachEvent("onload",function(){rp.poly();w.clearInterval(run)})}}
if(typeof exports!=="undefined"){exports.loadCSS=loadCSS}
else{w.loadCSS=loadCSS}}(typeof global!=="undefined"?global:this))
</script> <!-- Google Tag Manager -->
	<script type="rocketlazyloadscript">(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-P6JBTGV');</script>
	<!-- End Google Tag Manager -->
	<!-- Code Tiktok -->
	<script type="rocketlazyloadscript">
		!function (w, d, t) {
	  w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};var o=document.createElement("script");o.type="text/javascript",o.async=!0,o.src=i+"?sdkid="+e+"&lib="+t;var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(o,a)};

	  ttq.load('CGEI3CJC77U6LAATLOS0');
	  ttq.page();
	}(window, document, 'ttq');
</script>
	<!-- End Code Tiktok -->
</head>

<body data-rsssl=1 class="home page-template page-template-page-home page-template-page-home-php page page-id-3">
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P6JBTGV" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<div id="fb-root"></div>
	<link rel="preload" type="text/css" href="{{ asset('css/style_client.css') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" onerror="this.removeAttribute('data-rocket-async')">
	<link rel="preload" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" onerror="this.removeAttribute('data-rocket-async')">
	<link data-minify="1" rel="preload" type="text/css" href="{{ asset('css/main.css') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" onerror="this.removeAttribute('data-rocket-async')">
	<link data-minify="1" rel="preload" type="text/css" href="{{ asset('css/font-awesome.min.css') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" onerror="this.removeAttribute('data-rocket-async')">
	<link rel="preload" type="text/css" href="https://noithatlacgia.vn/wp-content/themes/lacgia/css/owl.carousel.min.css" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" onerror="this.removeAttribute('data-rocket-async')">
	<link data-minify="1" rel="preload" type="text/css" href="https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/themes/lacgia/css/fl_screen.css?ver=1680517523" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" onerror="this.removeAttribute('data-rocket-async')">
	<link data-minify="1" rel="preload" type="text/css" href="https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/themes/lacgia/css/jquery.mmenu.all.css?ver=1680517523" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" onerror="this.removeAttribute('data-rocket-async')">
	<link data-minify="1" rel="preload" type="text/css" href="https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/themes/lacgia/css/fancybox4.css?ver=1680517523" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" onerror="this.removeAttribute('data-rocket-async')">
	<div id="header">
		<div class="container">
			<div class="row">
				<div id="page" class="hidden-md hidden-lg">
					<div class="header">
						<a href="#menu"><span><i class="fa fa-bars"></i></span></a>
					</div>
				</div>
				<div class="col-sm-4 col-md-2 logo">
					<a href="{{route('client.home')}}"><img class="img-responsive" src="https://noithatlacgia.vn/wp-content/uploads/2022/09/logo-1.png" alt="Nội Thất Lạc Gia"></a>
				</div>
				@livewire('client.header')

				<div class="col-sm-1 col-md-1 search">

					<div class="icon-search">
						<label><i class="fa fa-search"></i></label>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="box_s">
		<p class="close_search"><i class="fa fa-close"></i></p>
		<form action="https://noithatlacgia.vn" id="searchform" method="get">
			<input type="text" id="s" name="s" value="" placeholder=" Tìm kiếm sản phẩm" />
			<input type="submit" value="" id="searchsubmit" />
		</form>
		<div class="box_s_fast">
			<h3 class="sfast">Tìm kiếm nhanh</h3>
			<ul>
				<li>
					<a href="https://noithatlacgia.vn/thiet-ke-noi-that/thiet-ke-noi-that-biet-thu/">Thiết kế nội thất biệt thự gỗ óc chó</a>
				</li>
				<li>
					<a href="https://noithatlacgia.vn/thiet-ke-noi-that/thiet-ke-noi-that-chung-cu/">Thiết kế nội thất chung cư cao cấp</a>
				</li>
				<li>
					<a href="https://noithatlacgia.vn/thiet-ke-noi-that/thiet-ke-noi-that-khach-san/">Thiết kế nội thất khách sạn</a>
				</li>
				<li>
					<a href="https://noithatlacgia.vn/duan/thiet-ke-noi-that-biet-thu-ecopark-200m2-hien-dai/">Dự án thiết kế nội thất biệt thự Ecopark 2 tầng</a>
				</li>
				<li>
					<a href="https://noithatlacgia.vn/duan/thiet-ke-noi-that-biet-thu-lien-ke-an-vuong-duong-noi/">Thiết kế nội thất biệt thự liền kề An Vượng – Dương Nội</a>
				</li>
			</ul>
		</div>
	</div>
	<!--end header-->
	@yield('content')
	<!-- Scripts -->
	<div id="to_top">
		<a href="#" class="btn btn-primary"><i class="fa fa-angle-double-up"></i></a>
	</div>
	<div id="footer">
		<div class="overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-5 ftcol ft1">
					<h3 class="sub-title text-uppercase ft_slogan">CÔNG TY CỔ PHẦN KIẾN TRÚC NỘI THẤT LẠC GIA</h3>
					<div class="ft_logo">
						<img src="https://noithatlacgia.vn/wp-content/uploads/2022/09/logo-1.png">
					</div>
					<div class="ft_gt">
						Mỗi tác phẩm của Lạc Gia đều được viết lên từ những câu chuyện ý nghĩa mà sứ mệnh cuối cùng chính là sự xóa nhòa mọi đứt đoạn trong cuộc sống đương đại, kết nối con người với tự nhiên và muôn điều bình dị. </div>
					<div class="box-social">
						<ul class="clear">
							<a href="" rel="nofollow">
								<img width="150px" src="https://noithatlacgia.vn/wp-content/uploads/2020/07/da-thong-bao-bo-cong-thuong.png">
							</a>
							<a href="//www.dmca.com/Protection/Status.aspx?ID=3c37a030-2c6c-4d60-80b8-25fd8244fa5b" rel="nofollow" title="DMCA.com Protection Status" class="dmca-badge">
								<img src="https://images.dmca.com/Badges/DMCA_logo-grn-btn120w.png?ID=3c37a030-2c6c-4d60-80b8-25fd8244fa5b" alt="DMCA.com Protection Status" />
							</a>
							<script data-minify="1" src="https://noithatlacgia.vn/wp-content/cache/min/1/Badges/DMCABadgeHelper.min.js?ver=1680517524"> </script>
						</ul>
					</div>
				</div>
				<div class="col-md-4 ftcol ft2">
					<h3 class="sub-title text-uppercase">Thông tin liên hệ</h3>
					<div class="ft_bx">
						<li><i class="fa fa-map-marker"></i> Showroom: M12-01, KĐT Dương Nội, Hà Đông, Hà Nội</li>
						<li><i class="fa fa-map-marker"></i> Nhà máy : Hòa Bình, Cần Kiệm, Thạch Thất, Hà Nội</li>
						<!-- <li><i class="fa fa-phone"></i> Hotline: <span class="hotline"><a href="tel:0836 555 355">0836 555 355 (Bán lẻ)</a></span></li> -->
						<li><i class="fa fa-phone"></i> Hotline: <span class="hotline"><a href="tel:0836 555 355">0836 555 355 </a></span></li>
						<li><i class="fa fa-envelope"></i> Email: <span><a href="mailto:lacgia6688@gmail.com">lacgia6688@gmail.com</a></span></li>
						<!--   <li>Chủ tài khoản : PHAN LẠC KIÊN</li>
                 <li>Ngân Hàng BIDV Chi Nhánh Thạch Thất</li>
                 <li class="nh"><span>45210000281906</span></li> -->
						<div class="ft_xh">
							<a href="https://www.facebook.com/lacgiainterior" target="_blank" rel="nofollow" style="color:#2196f3"><i class="fa fa-facebook  fa-2x" title="Facebook"></i></a>
							<a href="https://www.pinterest.com/noithatlacgia/" target="_blank" rel="nofollow" style="color:#f00"><i class="fa fa-pinterest fa-2x" title="Pinterest"> </i></a>
						</div>
					</div>
				</div>
				<div class="col-md-3 ftcol ft3">
					<h3 class="sub-title text-uppercase">Hỗ trợ khách hàng</h3>
					<div class="ft_bx">
						<div class="menu-footer-menu-container">
							<ul id="menu-footer-menu" class="menu">
								<li id="menu-item-1427" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1427"><a href="https://noithatlacgia.vn/cam-ket-chat-luong-va-bao-hanh/">Cam kết chất lượng và bảo hành</a></li>
								<li id="menu-item-466" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-466"><a href="https://noithatlacgia.vn/chinh-sach-bao-mat-thong-tin/">Chính sách bảo mật thông tin</a></li>
								<li id="menu-item-467" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-467"><a href="https://noithatlacgia.vn/chinh-sach-va-quy-dinh/">Chính sách và quy định</a></li>
								<li id="menu-item-724" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-724"><a href="https://noithatlacgia.vn/so-do-chi-duong/">Sơ đồ chỉ đường</a></li>
								<li id="menu-item-469" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-469"><a href="https://noithatlacgia.vn/lien-he/">Liên hệ</a></li>
								<li id="menu-item-1160" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1160"><a href="https://noithatlacgia.vn/thuoc-lo-ban/">THƯỚC LỖ BAN</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="copyright">
		<div class="container">
			<p>Copyright &copy; 2023 by noithatlacgia.vn. All right reserved</p>
		</div>
	</div>
	<div class="hidden">
		<div id="product_box">
			<div class="container">
				<div class="box_menu_full">
					<div class="mega_col">
						<div class="box_menu dark">
							<div class="mega_list ">
								<a href="https://noithatlacgia.vn/san-pham-tieu-bieu/">
									<h3 class="mega_tax_title">Sản phẩm tiêu biểu</h3>
								</a>
							</div>
						</div>
					</div>
					<div class="mega_col">
						<div class="box_menu dark">
							<div class="mega_list ">
								<a href="https://noithatlacgia.vn/phong-khach/">
									<h3 class="mega_tax_title">Phòng khách</h3>
								</a>

								<ul class="mega_sub">
									<li><a href="https://noithatlacgia.vn/phong-khach/sofa-go-tu-nhien/">Sofa gỗ</a></li>
									<li><a href="https://noithatlacgia.vn/phong-khach/ban-tra/">Bàn trà</a></li>
									<li><a href="https://noithatlacgia.vn/phong-khach/ke-tivi/">Kệ tivi</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="mega_col">
						<div class="box_menu dark">
							<div class="mega_list ">
								<a href="https://noithatlacgia.vn/phong-bep/">
									<h3 class="mega_tax_title">Phòng bếp</h3>
								</a>

								<ul class="mega_sub">
									<li><a href="https://noithatlacgia.vn/phong-bep/ban-ghe-an-go/">Bàn ghế ăn gỗ</a></li>
									<li><a href="https://noithatlacgia.vn/phong-bep/tu-bep/">Tủ bếp</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="mega_col">
						<div class="box_menu dark">
							<div class="mega_list ">
								<a href="https://noithatlacgia.vn/phong-ngu/">
									<h3 class="mega_tax_title">Phòng ngủ</h3>
								</a>

								<ul class="mega_sub">
									<li><a href="https://noithatlacgia.vn/phong-ngu/giuong/">Giường</a></li>
									<li><a href="https://noithatlacgia.vn/phong-ngu/tu-quan-ao/">Tủ quần áo</a></li>
									<li><a href="https://noithatlacgia.vn/phong-ngu/ban-phan/">Bàn phấn</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<a title="Chat Zalo" rel="nofollow" target="_blank" href="https://zalo.me/0966555355">
		<div class="alo-floating alo-floating-zalo">
			<strong>Chat Zalo</strong>
		</div>
	</a>
	<div class="support-online">
		<div class="support-content">
			<a href="tel:0836 555 355" class="call-now" rel="nofollow">
				<i class="fa fa-whatsapp" aria-hidden="true"></i>
				<div class="animated infinite zoomIn kenit-alo-circle"></div>
				<div class="animated infinite pulse kenit-alo-circle-fill"></div>
				<span class="hidden-sm hidden-xs">0836 555 355</span>
			</a>
		</div>
	</div>
	<style>
		div.autoAdsMaxLead-widget div {
			overflow: visible !important;
		}

		.aml-highlight-item .aml-icon-box {
			width: 60px;
			height: 60px;
			border-radius: 100%;
			display: inline-flex;
			align-items: center;
			justify-content: center;
		}

		.aml-highlight-item .aml-icon-box.aml-right {
			float: left !important;
			margin: 4px;
		}
	</style>
	<script src="https://noithatlacgia.vn/wp-content/themes/lacgia/js/jquery.min.js" type="text/javascript"></script>
	<!-- Meta Pixel Event Code -->
	<script type="rocketlazyloadscript" data-rocket-type='text/javascript'>
		document.addEventListener( 'wpcf7mailsent', function( event ) {
        if( "fb_pxl_code" in event.detail.apiResponse){
          eval(event.detail.apiResponse.fb_pxl_code);
        }
      }, false );
    </script>
	<!-- End Meta Pixel Event Code -->
	<div id='fb-pxl-ajax-code'></div>
	<script data-minify="1" type='text/javascript' src='https://noithatlacgia.vn/wp-content/cache/min/1/wp-includes/js/dist/vendor/regenerator-runtime.js?ver=1680517524' id='regenerator-runtime-js'></script>
	<script data-minify="1" type='text/javascript' src='https://noithatlacgia.vn/wp-content/cache/min/1/wp-includes/js/dist/vendor/wp-polyfill.js?ver=1680517524' id='wp-polyfill-js'></script>
	<script type='text/javascript' id='contact-form-7-js-extra'>
		/* <![CDATA[ */
		var wpcf7 = {
			"api": {
				"root": "https:\/\/noithatlacgia.vn\/wp-json\/",
				"namespace": "contact-form-7\/v1"
			},
			"cached": "1"
		};
		/* ]]> */
	</script>
	<script data-minify="1" type='text/javascript' src='https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/plugins/contact-form-7/includes/js/index.js?ver=1680517524' id='contact-form-7-js'></script>
	<script data-minify="1" type='text/javascript' src='https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/plugins/shi-plugins-thuocloban/js/iscroll.js?ver=1680517524' id='script-shi-ỉscroll-js'></script>
	<script data-minify="1" type='text/javascript' src='https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/plugins/twenty20/assets/js/jquery.twenty20.js?ver=1680517524' id='twenty20-style-js'></script>
	<script data-minify="1" type='text/javascript' src='https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/plugins/twenty20/assets/js/jquery.event.move.js?ver=1680517524' id='twenty20-eventmove-style-js'></script>
	<script type='text/javascript' id='rocket-browser-checker-js-after'>
		class RocketBrowserCompatibilityChecker {

			constructor(options) {
				this.passiveSupported = false;

				this._checkPassiveOption(this);
				this.options = this.passiveSupported ? options : false;
			}

			/**
			 * Initializes browser check for addEventListener passive option.
			 *
			 * @link https://developer.mozilla.org/en-US/docs/Web/API/EventTarget/addEventListener#Safely_detecting_option_support
			 * @private
			 *
			 * @param self Instance of this object.
			 * @returns {boolean}
			 */
			_checkPassiveOption(self) {
				try {
					const options = {
						// This function will be called when the browser attempts to access the passive property.
						get passive() {
							self.passiveSupported = true;
							return false;
						}
					};

					window.addEventListener('test', null, options);
					window.removeEventListener('test', null, options);
				} catch (err) {
					self.passiveSupported = false;
				}
			}

			/**
			 * Checks if the browser supports requestIdleCallback and cancelIdleCallback. If no, shims its behavior with a polyfills.
			 *
			 * @link @link https://developers.google.com/web/updates/2015/08/using-requestidlecallback
			 */
			initRequestIdleCallback() {
				if (!'requestIdleCallback' in window) {
					window.requestIdleCallback = (cb) => {
						const start = Date.now();
						return setTimeout(() => {
							cb({
								didTimeout: false,
								timeRemaining: function timeRemaining() {
									return Math.max(0, 50 - (Date.now() - start));
								}
							});
						}, 1);
					};
				}

				if (!'cancelIdleCallback' in window) {
					window.cancelIdleCallback = (id) => clearTimeout(id);
				}
			}

			/**
			 * Detects if data saver mode is on.
			 *
			 * @link https://developers.google.com/web/fundamentals/performance/optimizing-content-efficiency/save-data/#detecting_the_save-data_setting
			 *
			 * @returns {boolean|boolean}
			 */
			isDataSaverModeOn() {
				return (
					'connection' in navigator &&
					true === navigator.connection.saveData
				);
			}

			/**
			 * Checks if the browser supports link prefetch.
			 *
			 * @returns {boolean|boolean}
			 */
			supportsLinkPrefetch() {
				const elem = document.createElement('link');
				return (
					elem.relList &&
					elem.relList.supports &&
					elem.relList.supports('prefetch') &&
					window.IntersectionObserver &&
					'isIntersecting' in IntersectionObserverEntry.prototype
				);
			}

			isSlowConnection() {
				return (
					'connection' in navigator &&
					'effectiveType' in navigator.connection &&
					(
						'2g' === navigator.connection.effectiveType ||
						'slow-2g' === navigator.connection.effectiveType
					)
				)
			}
		}
	</script>
	<script type='text/javascript' id='rocket-preload-links-js-extra'>
		/* <![CDATA[ */
		var RocketPreloadLinksConfig = {
			"excludeUris": "\/(?:.+\/)?feed(?:\/(?:.+\/?)?)?$|\/(?:.+\/)?embed\/|\/(index\\.php\/)?wp\\-json(\/.*|$)|\/wp-admin\/|\/logout\/|\/wp-login.php|\/refer\/|\/go\/|\/recommend\/|\/recommends\/",
			"usesTrailingSlash": "1",
			"imageExt": "jpg|jpeg|gif|png|tiff|bmp|webp|avif|pdf|doc|docx|xls|xlsx|php",
			"fileExt": "jpg|jpeg|gif|png|tiff|bmp|webp|avif|pdf|doc|docx|xls|xlsx|php|html|htm",
			"siteUrl": "https:\/\/noithatlacgia.vn",
			"onHoverDelay": "100",
			"rateThrottle": "3"
		};
		/* ]]> */
	</script>
	<script type='text/javascript' id='rocket-preload-links-js-after'>
		class RocketPreloadLinks {

			constructor(browser, config) {
				this.browser = browser;
				this.config = config;
				this.options = this.browser.options;

				this.prefetched = new Set;
				this.eventTime = null;
				this.threshold = 1111;
				this.numOnHover = 0;
			}

			/**
			 * Initializes the handler.
			 */
			init() {
				if (
					!this.browser.supportsLinkPrefetch() ||
					this.browser.isDataSaverModeOn() ||
					this.browser.isSlowConnection()
				) {
					return;
				}

				this.regex = {
					excludeUris: RegExp(this.config.excludeUris, 'i'),
					images: RegExp('.(' + this.config.imageExt + ')$', 'i'),
					fileExt: RegExp('.(' + this.config.fileExt + ')$', 'i')
				};

				this._initListeners(this);
			}

			/**
			 * Initializes the event listeners.
			 *
			 * @private
			 *
			 * @param self instance of this object, used for binding "this" to the listeners.
			 */
			_initListeners(self) {
				// Setting onHoverDelay to -1 disables the "on-hover" feature.
				if (this.config.onHoverDelay > -1) {
					document.addEventListener('mouseover', self.listener.bind(self), self.listenerOptions);
				}

				document.addEventListener('mousedown', self.listener.bind(self), self.listenerOptions);
				document.addEventListener('touchstart', self.listener.bind(self), self.listenerOptions);
			}

			/**
			 * Event listener. Processes when near or on a valid <a> hyperlink.
			 *
			 * @param Event event Event instance.
			 */
			listener(event) {
				const linkElem = event.target.closest('a');
				const url = this._prepareUrl(linkElem);
				if (null === url) {
					return;
				}

				switch (event.type) {
					case 'mousedown':
					case 'touchstart':
						this._addPrefetchLink(url);
						break;
					case 'mouseover':
						this._earlyPrefetch(linkElem, url, 'mouseout');
				}
			}

			/**
			 *
			 * @private
			 *
			 * @param Element|null linkElem
			 * @param object url
			 * @param string resetEvent
			 */
			_earlyPrefetch(linkElem, url, resetEvent) {
				const doPrefetch = () => {
					falseTrigger = null;

					// Start the rate throttle: 1 sec timeout.
					if (0 === this.numOnHover) {
						setTimeout(() => this.numOnHover = 0, 1000);
					}
					// Bail out when exceeding the rate throttle.
					else if (this.numOnHover > this.config.rateThrottle) {
						return;
					}

					this.numOnHover++;
					this._addPrefetchLink(url);
				};

				// Delay to avoid false triggers for hover/touch/tap.
				let falseTrigger = setTimeout(doPrefetch, this.config.onHoverDelay);

				// On reset event, reset the false trigger timer.
				const reset = () => {
					linkElem.removeEventListener(resetEvent, reset, {
						passive: true
					});
					if (null === falseTrigger) {
						return;
					}

					clearTimeout(falseTrigger);
					falseTrigger = null;
				};
				linkElem.addEventListener(resetEvent, reset, {
					passive: true
				});
			}

			/**
			 * Adds a <link rel="prefetch" href="<url>"> for the given URL.
			 *
			 * @param string url The Given URL to prefetch.
			 */
			_addPrefetchLink(url) {
				this.prefetched.add(url.href);

				return new Promise((resolve, reject) => {
					const elem = document.createElement('link');
					elem.rel = 'prefetch';
					elem.href = url.href;
					elem.onload = resolve;
					elem.onerror = reject;

					document.head.appendChild(elem);
				}).catch(() => {
					// ignore and continue.
				});
			}

			/**
			 * Prepares the target link's URL.
			 *
			 * @private
			 *
			 * @param Element|null linkElem Instance of the link element.
			 * @returns {null|*}
			 */
			_prepareUrl(linkElem) {
				if (
					null === linkElem ||
					typeof linkElem !== 'object' ||
					!'href' in linkElem ||
					// Link prefetching only works on http/https protocol.
					['http:', 'https:'].indexOf(linkElem.protocol) === -1
				) {
					return null;
				}

				const origin = linkElem.href.substring(0, this.config.siteUrl.length);
				const pathname = this._getPathname(linkElem.href, origin);
				const url = {
					original: linkElem.href,
					protocol: linkElem.protocol,
					origin: origin,
					pathname: pathname,
					href: origin + pathname
				};

				return this._isLinkOk(url) ? url : null;
			}

			/**
			 * Gets the URL's pathname. Note: ensures the pathname matches the permalink structure.
			 *
			 * @private
			 *
			 * @param object url Instance of the URL.
			 * @param string origin The target link href's origin.
			 * @returns {string}
			 */
			_getPathname(url, origin) {
				let pathname = origin ?
					url.substring(this.config.siteUrl.length) :
					url;

				if (!pathname.startsWith('/')) {
					pathname = '/' + pathname;
				}

				if (this._shouldAddTrailingSlash(pathname)) {
					return pathname + '/';
				}

				return pathname;
			}

			_shouldAddTrailingSlash(pathname) {
				return (
					this.config.usesTrailingSlash &&
					!pathname.endsWith('/') &&
					!this.regex.fileExt.test(pathname)
				);
			}

			/**
			 * Checks if the given link element is okay to process.
			 *
			 * @private
			 *
			 * @param object url URL parts object.
			 *
			 * @returns {boolean}
			 */
			_isLinkOk(url) {
				if (null === url || typeof url !== 'object') {
					return false;
				}

				return (
					!this.prefetched.has(url.href) &&
					url.origin === this.config.siteUrl // is an internal document.
					&&
					url.href.indexOf('?') === -1 // not a query string.
					&&
					url.href.indexOf('#') === -1 // not an anchor.
					&&
					!this.regex.excludeUris.test(url.href) // not excluded.
					&&
					!this.regex.images.test(url.href) // not an image.
				);
			}

			/**
			 * Named static constructor to encapsulate how to create the object.
			 */
			static run() {
				// Bail out if the configuration not passed from the server.
				if (typeof RocketPreloadLinksConfig === 'undefined') {
					return;
				}

				const browser = new RocketBrowserCompatibilityChecker({
					capture: true,
					passive: true
				});
				const instance = new RocketPreloadLinks(browser, RocketPreloadLinksConfig);
				instance.init();
			}
		}

		RocketPreloadLinks.run();
	</script>
	<script data-minify="1" type='text/javascript' src='https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/themes/lacgia/js/jquery.fitvids.js?ver=1680517524' id='fl-fitvid-js'></script>
	<script type='text/javascript' src='https://noithatlacgia.vn/wp-content/themes/lacgia/js/theme.min.js?ver=1' id='fl-theme-js'></script>
	<script type='text/javascript' src='https://noithatlacgia.vn/wp-content/themes/lacgia/js/bootstrap.min.js?ver=1.0' id='fl-bootstrap-script-js'></script>
	<script data-minify="1" type='text/javascript' src='https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/themes/lacgia/js/main.js?ver=1680517524' id='fl-man-js-js'></script>
	<script type="rocketlazyloadscript">
		jQuery(document).ready(function($) {
var flag = true;
$('.icon-search').click(function(e){
e.preventDefault();
if(flag === true){
$('.box_s').addClass('show');
flag = false;
}else{
$('.box_s').removeClass('show');
flag = true;
}
});
$('.close_search').click(function(e){
$('.box_s').removeClass('show');
flag = true;
});
});
</script>
	<script type="rocketlazyloadscript">var cb = function() {
var l = document.createElement('link'); l.rel = 'stylesheet';
l.href = 'PATH_TO_COMBINED_CSS_FILE';
var h = document.getElementsByTagName('head')[0]; h.parentNode.insertBefore(l, h);
};
var raf = requestAnimationFrame || mozRequestAnimationFrame ||
webkitRequestAnimationFrame || msRequestAnimationFrame;
if (raf) raf(cb);
else window.addEventListener('load', cb);</script>
	<!--Start of Tawk.to Script-->
	<script type="rocketlazyloadscript" data-rocket-type="text/javascript">
		var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/5f1250f37258dc118bee75ce/default';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
	<!--End of Tawk.to Script-->
	<script>
		function wprRemoveCPCSS() {
			let preload_stylesheets = document.querySelectorAll('link[data-rocket-async="style"][rel="preload"]');
			if (preload_stylesheets && preload_stylesheets.length > 0) {
				for (let stylesheet_index = 0; stylesheet_index < preload_stylesheets.length; stylesheet_index++) {
					let media = preload_stylesheets[stylesheet_index].getAttribute('media') || 'all';
					if (window.matchMedia(media).matches) {
						setTimeout(wprRemoveCPCSS, 200);
						return;
					}
				}
			}

			const elem = document.getElementById('rocket-critical-css');
			if (elem && 'remove' in elem) {
				elem.remove();
			}
		}

		if (window.addEventListener) {
			window.addEventListener('load', wprRemoveCPCSS);
		} else if (window.attachEvent) {
			window.attachEvent('onload', wprRemoveCPCSS);
		}
	</script><noscript>
		<link data-minify="1" rel='stylesheet' id='wp-block-library-css' href="{{ asset('css/style_client.css') }}" type='text/css' media='all' />
		<link data-minify="1" rel='stylesheet' id='contact-form-7-css' href='https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/plugins/contact-form-7/includes/css/styles.css?ver=1680517523' type='text/css' media='all' />
		<link data-minify="1" rel='stylesheet' id='style-shi-popup-css' href='https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/plugins/shi-plugins-thuocloban/css/loban.css?ver=1680517523' type='text/css' media='all' />
		<link data-minify="1" rel='stylesheet' id='twenty20-style-css' href='https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/plugins/twenty20/assets/css/twenty20.css?ver=1680517523' type='text/css' media='all' />
		<link data-minify="1" rel='stylesheet' id='fl-style-css' href="{{ asset('css/style_client.css') }}"  type='text/css' media='all' />
		<link rel='stylesheet' id='fl-owl-css-css' href='https://noithatlacgia.vn/wp-content/themes/lacgia/css/owl.carousel.min.css?ver=6.0.3' type='text/css' media='all' />
		<link data-minify="1" rel='stylesheet' id='fl-bootstrap-css-css' href="{{ asset('css/bootstrap.min.css') }}" type='text/css' media='all' />
		<link data-minify="1" rel='stylesheet' id='fl-fontawesome-css' href="{{ asset('css/font-awesome.min.css') }}" type='text/css' media='all' />
		<link data-minify="1" rel='stylesheet' id='fl-main-css' href="{{ asset('css/main.css') }}" type='text/css' media='all' />
		<link data-minify="1" rel='stylesheet' id='fl-screen-css' href='https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/themes/lacgia/css/fl_screen.css?ver=1680517523' type='text/css' media='all' />
		<link rel='stylesheet' id='fl-owl-js-css' href='https://noithatlacgia.vn/wp-content/themes/lacgia/js/owl.carousel.min.js?ver=6.0.3' type='text/css' media='all' />
		<link rel="stylesheet" type="text/css" href="{{ asset('css/style_client.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
		<link data-minify="1" rel="stylesheet" type="text/css" href="https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/themes/lacgia/css/main.css?ver=1680517523">
		<link data-minify="1" rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
		<link rel="stylesheet" type="text/css" href="https://noithatlacgia.vn/wp-content/themes/lacgia/css/owl.carousel.min.css">
		<link data-minify="1" rel="stylesheet" type="text/css" href="https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/themes/lacgia/css/fl_screen.css?ver=1680517523">
		<link data-minify="1" rel="stylesheet" type="text/css" href="https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/themes/lacgia/css/jquery.mmenu.all.css?ver=1680517523">
		<link data-minify="1" rel="stylesheet" type="text/css" href="https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/themes/lacgia/css/fancybox4.css?ver=1680517523">
		<link rel="stylesheet" href="https://noithatlacgia.vn/wp-content/themes/lacgia/css/jquery.fancybox.min.css" />
        <link data-minify="1" href="https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/themes/lacgia/css/fotorama.css?ver=1681220832" rel="stylesheet">
	</noscript>
</body>

</html>
<script src="https://noithatlacgia.vn/wp-content/themes/lacgia/js/jquery.fancybox.min.js"></script>
<!-- This website is like a Rocket, isn't it? Performance optimized by WP Rocket. Learn more: https://wp-rocket.me - Debug: cached@1680603876 -->