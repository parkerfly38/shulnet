"use strict"

var AlphaManager = {

    instances: [],

    init: function(parameters, element, baseUrl) {

        if (parameters == null)
            parameters = {};

        AlphaManager.Utils.embedCss(
            typeof parameters['skin'] === 'undefined' ? 'flat' : parameters['skin']
        );

        if (!baseUrl)
            baseUrl = AlphaManager.Utils.getBaseUrl();

        if (!("showDialogTitle" in parameters))
            parameters.showDialogTitle = true;
        if (!("showDialogButtons" in parameters))
            parameters.showDialogButtons = true;
        if (!("maxDialogHeight" in parameters))
            parameters.maxDialogHeight = 1000;
        if (!("multiSelect" in parameters))
            parameters.multiSelect = false;

        var instance = {
            parameters: parameters,
            baseUrl: baseUrl,
            elBg: null,
            elContent: null,
            elDlg: null,
            elIframe: null,
            elTitle: null,
            elButtons: null,
            files: [],
            fillElement: function(element) {

            },
            show: function(selectedFiles) {
                if (this.elIframe)
                    this.elIframe.parentNode.removeChild(this.elIframe);
                this.elIframe = document.createElement("iframe")
                this.elContent.appendChild(this.elIframe);
                this.elIframe.className = 'alphamanager_iframe';

                var e = window, a = 'inner';
                if ( !( 'innerWidth' in window ) )
                {
                    a = 'client';
                    e = document.documentElement || document.body;
                }

                window.alphamanager_params = this.parameters;
                this.elIframe.src = this.baseUrl + 'index.html';

                AlphaManager.Utils.addClass(this.elBg, 'alphamanager_show');
                AlphaManager.Utils.addClass(this.elDlg, 'alphamanager_show');

                var wndHeight = e[ a+'Height' ];
                var dlgHeight = parameters.maxDialogHeight;
                if (dlgHeight + 90 > wndHeight)
                    dlgHeight = wndHeight - 90;
                this.setHeight(dlgHeight);
            },
            hide: function() {
                AlphaManager.Utils.removeClass(this.elBg, 'alphamanager_show');
                AlphaManager.Utils.removeClass(this.elDlg, 'alphamanager_show');
            },
            setHeight: function(dlgHeight) {
                this.elDlg.style.height = dlgHeight + 'px';
                this.elDlg.style.marginTop = "-" + Math.floor(dlgHeight/2) + 'px';
                var contentHeight = dlgHeight;
                if (this.elTitle != null)
                    contentHeight -= this.elTitle.offsetHeight;
                if (this.elButtons != null)
                    contentHeight -= this.elButtons.offsetHeight;
                this.elContent.style.height = contentHeight + 'px';
            },
            setWidth: function(dlgWidth) {
                this.elDlg.style.width = dlgWidth + 'px';
                this.elDlg.style.marginLeft = "-" + Math.floor(dlgWidth/2) + 'px';
            },
            onLoaded: function(uiWidth) {
                this.setWidth(uiWidth + 14);
            },
            onFileSelected: function(files) {
                this.files = files;
                var isOkEnabled = this.parameters.multiSelect === true ? files.length > 0 : files.length == 1;
                if (isOkEnabled)
                    AlphaManager.Utils.removeClass(this.elBtnOk, "alphamanager_disabled");
                else
                    AlphaManager.Utils.addClass(this.elBtnOk, "alphamanager_disabled");
            }
        };

        var listener = instance.parameters.onLoaded;
        instance.parameters.onLoaded = (function() {
            var i = instance;
            var l = listener;
            return function(uiWidth) {
                i.onLoaded(uiWidth);
                if (l)
                    l(uiWidth);
            }
        })();

        listener = instance.parameters.onFileSelected;
        instance.parameters.onFileSelected = (function() {
            var i = instance;
            var l = listener;
            return function(files) {
                i.onFileSelected(files);
                if (l)
                    l(files);
            }
        })();
        listener = instance.parameters.onFileSet;
        instance.parameters.onFileSet = (function() {
            var i = instance;
            var l = listener;
            return function(files) {
                i.hide();
                if (l)
                    l(files);
            }
        })();

        if (element) {
            if (typeof element == "string")
                element = document.getElementById(element);
            element.onclick = (function() { var i = instance; return function() { i.show(); }})();
        }

        instance.elBg = document.createElement("div")
        instance.elBg.className = 'alphamanager_bg';

        instance.elContent = document.createElement("div")
        instance.elContent.className = 'alphamanager_content';

        instance.elDlg = document.createElement("div")
        var classes = [ 'alphamanager_dlg' ];
        if (typeof parameters['skinMod'] !== 'undefined') {
            var mods = parameters['skinMod'].split(',');
            for (var i=0; i<mods.length; i++)
                classes.push("alphamanager_mod_" + mods[i]);
        }
        instance.elDlg.className = classes.join(' ');
        instance.elDlg.style.width = '1300px';
        instance.elDlg.style.marginLeft = '-650px';
        instance.setHeight(parameters.maxDialogHeight);

        var body = document.getElementsByTagName('body')[0];

        body.appendChild(instance.elBg);
        body.appendChild(instance.elDlg);

        if (parameters.showDialogTitle === true) {

            instance.elTitle = document.createElement("div");
            instance.elTitle.className = 'alphamanager_title';
            instance.elDlg.appendChild(instance.elTitle);

            var elTitleText = document.createElement("div");
            elTitleText.className = 'alphamanager_title_text';
            elTitleText.textContent = 'Alpha Manager';
            instance.elTitle.appendChild(elTitleText);

            var elBtnClose = document.createElement("div");
            elBtnClose.href = "javascript:void(0)";
            elBtnClose.className = "alphamanager_x";
            elBtnClose.textContent = '×';
            instance.elTitle.appendChild(elBtnClose);

            elBtnClose.onclick = (function() {
                var i = instance;
                return function() {
                    i.hide();
                }
            })();
        }

        instance.elDlg.appendChild(instance.elContent);

        if (parameters.showDialogButtons === true) {
            instance.elButtons = document.createElement("div");
            instance.elButtons.className = 'alphamanager_buttons';

            instance.elBtnOk = document.createElement("a");
            instance.elBtnOk.textContent = "OK";
            instance.elBtnOk.className = 'alphamanager_btn alphamanager_btn_ok alphamanager_disabled';
            instance.elButtons.appendChild(instance.elBtnOk);
            instance.elBtnOk.onclick = (function() {
                var i = instance;
                return function() {
                    if (AlphaManager.Utils.hasClass(this, "alphamanager_disabled"))
                        return;
                    i.parameters.onFileSet(i.files);
                }
            })();

            instance.elBtnCancel = document.createElement("a");
            instance.elBtnCancel.textContent = "Cancel";
            instance.elBtnCancel.className = 'alphamanager_btn';
            instance.elButtons.appendChild(instance.elBtnCancel);
            instance.elBtnCancel.onclick = (function() {
                var i = instance;
                return function() {
                    i.hide();
                }
            })();

            instance.elDlg.appendChild(instance.elButtons);
        }

        AlphaManager.instances.push(instance);
        return instance;
    }

}

AlphaManager.Utils = {

    addClass: function(el, cls) {
        if (AlphaManager.Utils.hasClass(el, cls))
            return;
        el.className = el.className.length == 0 ? cls : el.className + ' ' + cls;
    },

    removeClass: function(el, cls) {
        var classes = AlphaManager.Utils.getClasses(el);
        while (classes.indexOf(cls) > -1)
            classes.splice(classes.indexOf(cls), 1);
        var newCls = classes.join(' ').trim();
        if (newCls.length > 0)
            el.className = newCls;
        else if (el.hasAttribute('class'))
            el.removeAttribute('class');
    },

    getClasses: function(el) {
        if (typeof(el.className) === 'undefined' || el.className == null)
            return [];
        return el.className.split(/\s+/);
    },

    hasClass: function(el, cls) {
        var classes = AlphaManager.Utils.getClasses(el);
        for (var i=0; i<classes.length; i++)
            if (classes[i].toLowerCase() == cls.toLowerCase())
                return true;
        return false;
    },

    embedCss: function(skin) {

        var styles = document.getElementsByTagName('head')[0].getElementsByTagName("style");
        for (var i=styles.length-1; i>=0; i--)
            if (styles[i].getAttribute("data-alphamanager") === 'true')
                styles[i].parentNode.removeChild(styles[i]);

        var style = document.createElement('style');
        style.setAttribute("data-alphamanager", "true")
        document.getElementsByTagName('head')[0].appendChild(style);
        var css = [];
        css['business'] =
              '.alphamanager_bg { background-color: black; opacity: 0.5; position: fixed; left: 0; top: 0; width: 100%; height: 3000px; z-index: 11111; display: none; } ' +
              '.alphamanager_dlg { width: 400px; margin-left: -200px; top: 50%; left: 50%; padding: 0; position: fixed; z-index: 11112; background-color: white; border: 1px solid #999; overflow:hidden; display: none; }' +
              '.alphamanager_show { display: block; }' +

              '.alphamanager_title { box-sizing: border-box; font-size: 18px; font-weight: bold; padding: 7px 0 3px 15px; color: #333; border-bottom: 1px solid #ccc; height: 35px; }'+
              '.alphamanager_title_text { float: left; width: 95%; }' +
              '.alphamanager_x { box-sizing: border-box; float: right; width: 5%; text-align: right; cursor: pointer; padding-right: 17px; color: #999; }' +
              '.alphamanager_x:hover { color: #444; }' +

              '.alphamanager_btn { padding: 4px 10px; font-size: 15px; border: 1px solid #AAA !important; display: inline-block; float: right; cursor: pointer; margin-left: 15px; min-width: 90px; text-align: center; background-color: white; }' +
              '.alphamanager_btn:hover { background-color: #f3f3f3; }' +
              '.alphamanager_btn.alphamanager_disabled, .alphamanager_btn.alphamanager_disabled:hover, .alphamanager_btn.alphamanager_disabled:focus { color: #DDD; border-color: #DDD; background-color: white; cursor: default; }' +

              '.alphamanager_iframe { border: none; width: 100%; height: 100%; }' +
              '.alphamanager_buttons { background: #FAFAFA; height: 60px; padding: 15px 25px 15px 0;}';
        css['mono'] =
              '.alphamanager_bg { background-color: black; opacity: 0.5; position: fixed; left: 0; top: 0; width: 100%; height: 3000px; z-index: 11111; display: none; } ' +
              '.alphamanager_dlg { width: 400px; margin-left: -200px; top: 50%; left: 50%; padding: 0; position: fixed; z-index: 11112; background-color: white; border: 1px solid #999; border-radius: 10px; overflow:hidden; display: none; }' +
              '.alphamanager_show { display: block; }' +

              '.alphamanager_title { box-sizing: border-box; font-size: 18px; font-weight: bold; padding: 7px 0 3px 15px; color: #333; border-bottom: 1px solid #ccc; height: 35px; }'+
              '.alphamanager_title_text { float: left; width: 95%; }' +
              '.alphamanager_x { box-sizing: border-box; float: right; width: 5%; text-align: right; cursor: pointer; padding-right: 17px; color: #999; }' +
              '.alphamanager_x:hover { color: #444; }' +

              '.alphamanager_btn { padding: 4px 10px; font-size: 15px; border: 2px solid #AAA !important; border-radius: 5px; display: inline-block; float: right; cursor: pointer; margin-left: 15px; min-width: 90px; text-align: center; background-color: white; color: #555; }' +
              '.alphamanager_btn:hover { background-color: #555; color: white; border-color: #555; }' +
              '.alphamanager_btn.alphamanager_disabled, .alphamanager_btn.alphamanager_disabled:hover, .alphamanager_btn.alphamanager_disabled:focus { color: #DDD; border-color: #DDD; background-color: white; cursor: default; }' +

              '.alphamanager_iframe { border: none; width: 100%; height: 100%; }' +
              '.alphamanager_buttons { background: #FAFAFA; height: 60px; padding: 15px 25px 15px 0;}' +

              '.alphamanager_mod_blue .alphamanager_btn { border: 2px solid #09F !important; color: #09F; }' +
              '.alphamanager_mod_blue .alphamanager_btn:hover { background-color: #09F; border-color: #09F !important; color: white; }' +
              '.alphamanager_mod_blue .alphamanager_btn.alphamanager_disabled, .alphamanager_mod_blue .alphamanager_btn.alphamanager_disabled:hover, .alphamanager_mod_blue .alphamanager_btn.alphamanager_disabled:focus { color: #DDD; border-color: #DDD; background-color: white; cursor: default; }' +

              '.alphamanager_mod_violet .alphamanager_btn { border: 2px solid #6C538B !important; color: #6C538B !important; }' +
              '.alphamanager_mod_violet .alphamanager_btn:hover { background-color: #6C538B; border-color: #6C538B !important; color: white !important; }' +
              '.alphamanager_mod_violet .alphamanager_btn.alphamanager_disabled, .alphamanager_mod_violet .alphamanager_btn.alphamanager_disabled:hover, .alphamanager_mod_violet .alphamanager_btn.alphamanager_disabled:focus { color: #DDD !important; border-color: #DDD !important; background-color: white; cursor: default; }';
        css['flat'] =
            '.alphamanager_bg { background-color: black; opacity: 0.5; position: fixed; left: 0; top: 0; width: 100%; height: 3000px; z-index: 11111; display: none; } ' +
            '.alphamanager_dlg { width: 400px; margin-left: -200px; top: 50%; left: 50%; padding: 0; position: fixed; z-index: 11112; background-color: white; border-radius: 5px; overflow:hidden; display: none; }' +
            '.alphamanager_show { display: block; }' +

            '.alphamanager_title { box-sizing: border-box; font-size: 18px; font-weight: bold; padding: 7px 0 3px 15px; color: #333; border-bottom: 1px solid #ccc; height: 35px; }'+
            '.alphamanager_title_text { float: left; width: 95%; }' +
            '.alphamanager_x { box-sizing: border-box; float: right; width: 5%; text-align: right; cursor: pointer; padding-right: 17px; color: #999; }' +
            '.alphamanager_x:hover { color: #444; }' +

            '.alphamanager_btn { margin: 0 10px; padding: 5px 0; display: inline-block; float: right; color: white !important; font-size: 15px; margin-bottom: 20px; width: 90px; text-align: center; border-radius: 3px; background-color: #F14444; cursor: pointer; border: none !important; }' +
            '.alphamanager_btn:hover { background-color: #D33232; border: none !important; }' +
            '.alphamanager_btn_ok { background-color: #00FFB8; }' +
            '.alphamanager_btn_ok:hover { background-color: #008661; }' +
            '.alphamanager_btn.alphamanager_disabled, .alphamanager_btn.alphamanager_disabled:hover, .alphamanager_btn.alphamanager_disabled:focus { cursor: default; opacity: 0.3; }' +

            '.alphamanager_iframe { border: none; width: 100%; height: 100%; }' +
            '.alphamanager_buttons { background: #FAFAFA; height:60px; padding: 15px 25px 15px 0;}';

        style.innerHTML = css[skin];
    },

    getBaseUrl: function() {
        var basePathSrcPattern = /(^|.*[\\\/])(alphamanager|gplugin)\.js(?:\?.*|;.*)?$/i;
        var path = null;
        var scripts = document.getElementsByTagName( 'script' );
        for ( var i = 0; i < scripts.length; i++ ) {
            var match = scripts[ i ].src.match( basePathSrcPattern );
            if ( match ) {
                path = match[ 1 ];
                break;
            }
        }
        if (path != null) {
            if ( path.indexOf( ':/' ) == -1 && path.slice( 0, 2 ) != '//' ) {
                if ( path.indexOf( '/' ) === 0 )
                    path = location.href.match( /^.*?:\/\/[^\/]*/ )[ 0 ] + path;
                else
                    path = location.href.match( /^[^\?]*\/(?:)/ )[ 0 ] + path;
            }
        }
        return path;
    }

}