function addStyles(win, styles) {
    styles.forEach((style) => {
        let link = win.document.createElement("link");
        link.setAttribute("rel", "stylesheet");
        link.setAttribute("type", "text/css");
        link.setAttribute("href", style);
        win.document.getElementsByTagName("head")[0].appendChild(link);
    });
}

const VueHtmlToPaper = {
    install(app, options = {}) {
        app.config.globalProperties.$htmlToPaper = (
            el,
            localOptions,
            cb = () => true
        ) => {
            let defaultName = "_blank",
                defaultSpecs = [
                    "fullscreen=yes",
                    "titlebar=yes",
                    "scrollbars=yes",
                ],
                defaultReplace = true,
                defaultStyles = [];
            let {
                name = defaultName,
                specs = defaultSpecs,
                replace = defaultReplace,
                styles = defaultStyles,
            } = options;

            // If has localOptions
            // TODO: improve logic
            if (!!localOptions) {
                if (localOptions.name) name = localOptions.name;
                if (localOptions.specs) specs = localOptions.specs;
                if (localOptions.replace) replace = localOptions.replace;
                if (localOptions.styles) styles = localOptions.styles;
            }
            const element = window.document.getElementById(el);

            if (!element) {
                alert(`Element to print #${el} not found!`);
                return;
            }

            var ifprint = document.createElement("iframe");
            document.body.appendChild(ifprint);
            ifprint.setAttribute("style", "height:100%;width:0;");

            const win = ifprint.contentWindow;

            win.document.write(`
          <html>
            <head>
              <title>${window.document.title}</title>

<style >
table th {
    border-bottom: 1px solid !important;
    padding: 2mm !important;
    background-color: #f1f1f1 !important;
}

.invoice-box {
    max-width: 100% !important;
    margin: auto !important;
    padding: 0 15px !important;
    font-size: 14px !important;
    font-family:myFirstFont !important;
    color: #555 !important;
}

.invoice-box table td {
    padding: 2px !important;
    vertical-align: top !important;
}

.invoice-box table tr.top table td {
    padding-bottom: 20px !important;
}

h5, p{
    margin: 2px !important;
}

.invoice-box table tr.item.last td {
    border-bottom: none !important;
}

.invoice-box table tr.total td:nth-child(2) {
    border-top: 2px solid #eee !important;
    font-weight: bold !important;
}


/** RTL **/
.invoice-box.rtl {
    direction: rtl !important;
    font-family:myFirstFont !important;
}

.invoice-box.rtl table {
    text-align: right !important;
}

table.table td.num {
    border: 1px solid !important;
    font-weight: normal
}

.num-15 {
    width: 15%
}
.number-15 {
    width: 40%
}

</style>

            </head>
            <body style="margin:0" dir="rtl">
              ${element.innerHTML}
            </body>
          </html>
        `);

            addStyles(win, styles);

            setTimeout(() => {
                win.document.close();
                win.focus();
                win.print();
                win.close();
                document.body.removeChild(ifprint);
                cb();
            }, 1);

            return true;
        };
    },
};

export default VueHtmlToPaper;
