/*
 * Ext JS Library 3.1.0
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */
/*======================================================================+
 | Ext JS Library 3.1.0                                                 |
 +----------------------------------------------------------------------+
 | Copyright (C) 2010.03.12 N.watanuki                                  |
 +----------------------------------------------------------------------+
 | Script-ID      : SearchField.js [Search Fields: userid, jpname]      |
 | DATA-WRITTEN   : 2010.03.24                                          |
 | AUTHER         : N.WATANUKI                                          |
 | UPDATE-WRITTEN : 2010.08.27                                          |
 +======================================================================*/

Ext.app.SearchField = Ext.extend(Ext.form.TwinTriggerField, {
    initComponent : function(){
        Ext.app.SearchField.superclass.initComponent.call(this);
        this.on('specialkey', function(f, e){
            if(e.getKey() == e.ENTER){
                this.onTrigger2Click();
            }
        }, this);
    },

    validationEvent:false,
    validateOnBlur:false,
    trigger1Class:'x-form-clear-trigger',
    trigger2Class:'x-form-search-trigger',
    hideTrigger1:true,
    width:180,
    hasSearch : false,
    paramName : 'query',

    onTrigger1Click : function(){
        if(this.hasSearch){
            this.el.dom.value = '';
            var o = {start: 0, limit: 12};
            this.store.baseParams = this.store.baseParams || {};
            this.store.baseParams[this.paramName] = '';
            this.store.reload({params:o});
            this.triggers[0].hide();
            this.hasSearch = false;
        }
    },

    onTrigger2Click : function(){
        var v = this.getRawValue(); 
        if(v.length < 1) { 
            this.onTrigger1Click(); 
            return;
        } 
        var o = {start: 0, limit: 12};
        this.store.baseParams = this.store.baseParams || {};
        this.store.baseParams[this.paramName] = v;
        this.store.reload({params:o});
        this.hasSearch = true;
        this.triggers[0].show();
    }
});
