document.observe("dom:loaded", function() {
    $$(".dpi-modal").invoke("observe", "click", function(event) {
        if ($('browser_window') && typeof(Windows) != 'undefined') {
            Windows.focus('browser_window');
            return;
        }
        Dialog.info($('product-page').innerHTML, {
            closable:true,
            resizable:false,
            draggable:true,
            className:'magento',
            windowClassName:'popup-window',
            title: this.title,
            top: 100,
            width: 600,
            height: 500,
            zIndex: 1000,
            recenterAuto: true,
            hideEffect: Element.hide,
            showEffect: Element.show,
            id: 'browser_window',
            onClose:function (param, el) {
                param.destroy.bind(param);
            }
        });
    });

    $$(".dpi-toggle").invoke("observe", "click", function() {
        Element.toggle('product-page');
    });
});