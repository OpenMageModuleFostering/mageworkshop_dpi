AttributesList = {
    init: function() {
        $$(".dpi-modal").invoke("observe", "click", function() {
            if($('browser_window' + this.id) && typeof(Windows) != 'undefined') {
                Windows.focus('browser_window' + this.id);
                return;
            }
            if(this.href.toQueryParams().ajax.replace('/','') && !$('product-' + this.id)) {
                AttributesList.getAjaxData(this.href, this);
            } else {
                AttributesList.displayModal(this);
            }
        });

        $$(".dpi-toggle").invoke("observe", "click", function(event) {
            if(this.href.toQueryParams().ajax.replace('/','') && !$('product-' + this.id)) {
                AttributesList.getAjaxData(this.href, this);
            } else {
                Element.toggle('product-' + this.id);
            }
            event.stop();
            AttributesList.hideAttributes('product-' + this.id);
        });

        Event.observe(document, 'click', function() {
            AttributesList.hideAttributes(this.id);
        });
    },

    hideAttributes: function(id) {
        $$('.attr-table').each(function(item){
            if(id == null) {
                Element.hide(item);
            } else if(id != item.id) {
                Element.hide(item);
            }
        });
    },

    getAjaxData: function(url, obj) {
        var params = url.toQueryParams();
        new Ajax.Request(url, {
            parameters: { id: params.id, store: params.store},
            onLoading:  Element.toggle($('loading-mask')),
            onComplete: function(response){
                Element.toggle($('loading-mask'));
                obj.up(0).insert(response.responseText);
                var modal = parseInt(params.modal.replace('/', ''));
                if(modal) {
                    AttributesList.displayModal(obj);
                } else {
                    Element.toggle('product-' + obj.id);
                }
            }
        });
    },

    displayModal: function(obj) {
        Dialog.info($('product-' + obj.id).innerHTML, {
            closable:true,
            resizable:false,
            draggable:true,
            className:'magento',
            windowClassName:'popup-window',
            title: obj.title,
            top: 100,
            width: 600,
            height: 500,
            zIndex: 1000,
            recenterAuto: true,
            hideEffect: Element.hide,
            showEffect: Element.show,
            id: 'browser_window' + obj.id,
            onClose: function(param, el) {
                param.destroy.bind(param);
            }
        });
    }
}

document.observe("dom:loaded", function() {
    AttributesList.init();
});