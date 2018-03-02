//[Update the keyword Entry] 
    var KwordDataStore; 
    var KwordColumnModel; 
    var KwordListingEditorGrid; 
    var KwordListingWindow; 

//[Adding New Entry] 
    var KwordCreateForm; 
    var KwordCreateWindow; 

//[Field defines.] 
    var kidField; 
    var kwdField; 
    var kurlField; 
    var kusrField; 
    var kemailField; 
    var kdateField; 
    var kcontField; 
    
    var dt = new Date(); 

Ext.BLANK_IMAGE_URL = './resources/images/default/s.gif';

Ext.onReady(function(){

    Ext.QuickTips.init();

    function saveKword(oGrid_event){
        Ext.Ajax.request({   
            waitMsg: 'ちょっと待ってね...',
            url: 'kwddb.php',
            params: {
                task: "UPDATEPRES",
                kid: oGrid_event.record.data.kid,
                kwd: oGrid_event.record.data.kwd,
                kurl: oGrid_event.record.data.kurl,
                kusr: oGrid_event.record.data.kusr,
                kemail: oGrid_event.record.data.kemail,
                kdate : oGrid_event.record.data.kdate,
                kcont : oGrid_event.record.data.kcont
            }, 
            success: function(response){
                var result=eval(response.responseText);
                switch(result){
                    case 1:
                        KwordDataStore.commitChanges();
                        KwordDataStore.reload();
                        break;
                    default:
                        Ext.MessageBox.alert('あれぇ？','登録できないね...'); 
                        break;
                }
            },
            failure: function(response){
                var result=response.responseText;
                Ext.MessageBox.alert('Error','Could not connect to the database. retry later'); 
            }
        });   
    }

    //Creates a new keyword data.
    function createKword(){ 
        if(isKwordFormValid()){
            Ext.Ajax.request({   
                waitMsg: 'ちょっと待ってね...',
                url: 'kwddb.php',
                params: {
                    task: "CREATEPRES",
                    kwd: kwdField.getValue(),
                    kurl: kurlField.getValue(),
                    kusr: kusrField.getValue(),
                    kemail : kemailField.getValue(),
                    kdate: kdateField.getValue(),
                    kcont : kcontField.getValue()
                }, 
                success: function(response){ 
                    var result=eval(response.responseText);
                    switch(result){
                        case 1:
                            Ext.MessageBox.alert('OK!','キーワードを登録しました！');
                            KwordDataStore.reload();
                            KwordCreateWindow.hide();
                            break;
                        default:
                            Ext.MessageBox.alert('Warning','キーワードを登録できません...');
                            break;
                    } 
                },
                failure: function(response){
                    var result=response.responseText;
                    Ext.MessageBox.alert('Error!!','DBに接続できません...'); 
                } 
            });
        } else {
            Ext.MessageBox.alert('Warning', 'Your Form is not valid!');
        }
    }
  
  //reset the Form before opening it
    function resetKwordForm(){ 
        kidField.setValue(''); 
        kwdField.setValue(''); 
        kurlField.setValue(''); 
        kusrField.setValue(''); 
        kemailField.setValue(''); 
        kdateField.setValue(dt.format('Y-m-d H:i:s')); 
        kcontField.setValue('');    
    }

  //Check if the form is valid [必須入力項目チェック]
    function isKwordFormValid(){
        return(
            kwdField.isValid() &&  /* keyword Field */
            kurlField.isValid());  /* URL Field */
    }

  //Display or bring forth the form
    function displayFormWindow(){
        if(!KwordCreateWindow.isVisible()){
            resetKwordForm();
            KwordCreateWindow.show();
            kwdField.focus("",10);
        } else {
            KwordCreateWindow.toFront();
            kwdField.focus("",10);
        }
    }
    /*==================*
     * Delete function. *
     *==================*/
    function confirmDeleteKword(){
        if(KwordListingEditorGrid.selModel.getCount() == 1)  { //Userが１人しか登録されていな場合の処理
            Ext.MessageBox.confirm('[ 確認！]','削除します、よろしいですか？', deleteKword);
        } else if(KwordListingEditorGrid.selModel.getCount() > 1) { 
            Ext.MessageBox.confirm('[ 削除！]','削除します！', deleteKword);
        } else {
            Ext.MessageBox.alert('[ 確認！]','削除できません…削除行を選択していますか？');
        }
    }  

   // This was added in Tutorial 6
    function deleteKword(btn){
        if(btn=='yes') {
            var selections = KwordListingEditorGrid.selModel.getSelections();
            var kword = [];
            for(i = 0; i< KwordListingEditorGrid.selModel.getCount(); i++) {
                kword.push(selections[i].json.kid);
            }
            var encoded_array = Ext.encode(kword);
            Ext.Ajax.request({  
                waitMsg: 'Please Wait',
                url: 'kwddb.php', 
                params: { 
                    task: "DELETEPRES", 
                    ids:  encoded_array
                }, 
                success: function(response) {
                    var result=eval(response.responseText);
                    switch(result) {
                        case 1:  // Success : simply reload
                            KwordDataStore.reload();
                            break;
                        default:
                            Ext.MessageBox.alert('Warning!!','削除できません！');
                            break;
                    }
                },
                failure: function(response) {
                    var result=response.responseText;
                    Ext.MessageBox.alert('Error!!','DBに接続できません！');      
                }
            });
        }  
    }
    function startAdvancedSearch(){
        // local vars
        var KwordSearchForm;
        var KwordSearchWindow;
        
        var SearchkidItem;
        var SearchkwdItem;
        var SearchkemailItem;
        var SearchkusrItem;
        var SearchkurlItem;

        function listSearch(){
        // change the store parameters
            KwordDataStore.baseParams = {
                task: 'SEARCH',
                kid: SearchkidItem.getValue(),
                kwd: SearchkwdItem.getValue(),
                kemail : SearchkemailItem.getValue(),
                kusr: SearchkusrItem.getValue(),
                kurl : SearchkurlItem.getValue()
            };
        // Cause the datastore to do another query : 
            KwordDataStore.reload({params: {start: 0, limit: 10}});
        }
     
        function resetSearch(){
         // reset the store parameters
            KwordDataStore.baseParams = {
                task: 'LISTING'
            };
         // Cause the datastore to do another query : 
            KwordDataStore.reload({params: {start: 0, limit: 10}});
            KwordSearchWindow.close();
        }
      
        SearchkidItem = new Ext.form.TextField({
            fieldLabel: 'KID',
            maxLength: 12,
            anchor : '95%',
            maskRe: /([a-zA-Z0-9\s]+)$/
        });

        SearchkwdItem = new Ext.form.TextField({
            fieldLabel: 'キーワード',
            maxLength: 48,
            anchor : '95%'
            //maskRe: /([a-zA-Z0-9\s]+)$/  
        });
      
        SearchkemailItem = new Ext.form.TextField({
            fieldLabel: 'email',
            maxLength: 128,
            anchor:'95%',
            maskRe: new RegExp("")
        });

        SearchkusrItem = new Ext.form.TextField({
            fieldLabel: 'ユーザ',
            maxLength: 128,
            anchor:'95%',
            maskRe: new RegExp("")
        });
          
        SearchkurlItem = new Ext.form.TextField({
            fieldLabel: 'URL',
            maxLength: 48,
            anchor:'95%',
            maskRe: new RegExp("") 
        });

        KwordSearchForm = new Ext.FormPanel({
            labelAlign: 'top',
            bodyStyle: 'padding: 5px',
            width: 300,
            items: [{
                layout: 'form',
                border: false,
                items: [ SearchkidItem,SearchkwdItem,SearchkurlItem,SearchkusrItem,SearchkemailItem ],
                buttons: [{
                    text: '検索',
                    handler: listSearch
                },{
                    text: 'Close',
                    handler: resetSearch
                }]
            }]
        });

        var focusFirst = function(){
            var item = KwordSearchForm.items.find(findFirst);
        }

        var findFirst = function(item){
            if (item instanceof Ext.form.FieldSet){
                return item.items.find(findFirst);
            }
            if (item instanceof Ext.form.Field && !item.hidden && !item.disabled){
                item.focus(false, 50); // delayed focus by 50 ms
                return true;
            }
            return false;
        }

        KwordSearchWindow = new Ext.Window({
            title: '[ ユーザ検索 ]',
            closable:true,
            width: 200,
            height: 322,
            plain:true,
            layout: 'fit',
            items: KwordSearchForm
        });

        // once all is done, show the search window
        KwordSearchWindow.show();
        // Focus Set.
        SearchkidItem.focus("",10);
    } 

/*-- For Debug --*/
    //Configulation.
    KwordDataStore = new Ext.data.Store({ 
        id: 'KwordDataStore',
        proxy: new Ext.data.HttpProxy({
                   url: 'kwddb.php', 
                   method: 'POST'
               }),
            baseParams:{task: "LISTING"}, // this parameter is passed for any HTTP request
        reader: new Ext.data.JsonReader({
            root: 'results',
            totalProperty: 'total',
            id: 'id'
        },[ 
            {name: 'kid', type: 'int', mapping: 'kid'}, 
            {name: 'kwd', type: 'string', mapping: 'kwd'}, 
            {name: 'kurl', type: 'string', mapping: 'kurl'}, 
            {name: 'kusr', type: 'string', mapping: 'kusr'}, 
            {name: 'kemail', type: 'string', mapping: 'kemail'}, 
            {name: 'kdate', type: 'string', mapping: 'kdate'}, 
            {name: 'kcont', type: 'string', mapping: 'kcont'} 
        ]),
        sortInfo:{field: 'kid', direction: "ASC"}
    });
    
    KwordColumnModel = new Ext.grid.ColumnModel(
      [{
          header: '[ KID ]',
          readOnly: true,
          dataIndex: 'kid',
          width: 54,
          hidden: false
      },{
          header: '[ キーワード ]',
          dataIndex: 'kwd',
          width: 100,
          editor: new Ext.form.TextField({
              allowBlank: false,
              maxLength: 255
              /* maskRe: /([a-zA-Z0-9\s]+)$/ */
          })
      },{
          header: '[ URL ]',
          dataIndex: 'kurl',
          width: 158,
          editor: new Ext.form.TextField({
              allowBlank: false,
              maxLength: 255,
              maskRe: new RegExp("") 
              //maskRe: new RegExp('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/') 
          })
      },{
          header: '[ ユーザ ]',
          dataIndex: 'kusr',
          width: 84,
          editor: new Ext.form.TextField({
              allowBlank: false,
              maxLength: 40,
              maskRe: new RegExp("")
          }),
          hidden: false
      },{
          header: '[ Email ]',
          dataIndex: 'kemail',
          width: 164,
          editor: new Ext.form.TextField({
              allowBlank: false,
              maxLength: 80,
              maskRe: new RegExp("")
          }),
          hidden: false
      },{
          header: '[ 登録日 ]',
          dataIndex: 'kdate',
          width: 78,
          editor: new Ext.form.TextField({
              allowBlank: false,
              maxLength: 10,
              maskRe: new RegExp("/([a-zA-Z0-9\s]+)$/")  
              /* maskRe: new RegExp("[0-9]")  */
          }),
          hidden: false
      }
    /*--------------------------------------*
      {
          header: '備　考',
          dataIndex: 'kcont',
          width: 148,
          editor: new Ext.form.TextField({
              allowBlank: false,
              maxLength: 255,
              maskRe: /([a-zA-Z0-9\s]+)$/
          }),
          hidden: false
       }
      *-------------------------------------*/
      ]
    );
    KwordColumnModel.defaultSortable= true;
    
    KwordListingEditorGrid = new Ext.grid.EditorGridPanel({
        id: 'KwordListingEditorGrid',
        store: KwordDataStore,
        cm: KwordColumnModel,
        enableColLock:false,
        clicksToEdit:1,
        selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),

        bbar: new Ext.PagingToolbar({
            pageSize: 10,
            store: KwordDataStore,
            displayInfo: true
        }),

        tbar: [
            {
                text: '[キーワード登録]',
                tooltip: 'キーワード新規登録です！',
                iconCls: 'add', 
                handler: displayFormWindow
            }, '-', {
                text: '[キーワード削除]',
                tooltip: 'このキーワードを削除します、さよなら…',
                handler: confirmDeleteKword, 
                iconCls:'remove'
            }, '-', {
                text: '[キーワード検索]',
                tooltip: 'キーワードを検索します！',
                handler: startAdvancedSearch,   
                iconCls:'search'
            }, '-', {
                text: 'Quick Search [kwd]',
                tooltip: '簡易検索：キーワードで検索してちょ！' 
            },  new Ext.app.SearchField({
                store: KwordDataStore,
                params: {start: 0, limit: 10},
                width: 120
            })
        ]
    });
    
    KwordListingWindow = new Ext.Window({
        id: 'KwordListingWindow',
        title: '[ キーワード一覧表 ]',
        closable:true,
        width:660,
        height:328,
        plain:true,
        layout: 'fit',
        items: KwordListingEditorGrid
    });
    KwordDataStore.load({params: {start: 0, limit: 10}});
    KwordListingWindow.show();
    KwordListingEditorGrid.on('afteredit', saveKword);

/* Kword Entry Field Defines here. */
    kidField = new Ext.form.TextField({
        id: 'kidField',
        fieldLabel: 'KID：',
        maxLength: 8,
        allowBlank: false,
        anchor : '95%'
        //maskRe: /([a-zA-Z0-9\s]+)$/
    });

    kwdField = new Ext.form.TextField({
        id: 'kwdField',
        fieldLabel: 'キーワード：',
        maxLength: 255,
        allowBlank: false,
        anchor : '95%'   
        /* maskRe: /([a-zA-Z0-9\s]+)$/ */
    });
  
    kurlField = new Ext.form.TextField({
        id:'kurlField', 
        fieldLabel: 'URL：', 
        maxLength: 255, 
        allowBlank: false, 
        anchor:'95%', 
        maskRe: new RegExp("") 
        //maskRe: new RegExp('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/') 
    });
  
    kusrField = new Ext.form.TextField({
        id:'kusrField', 
        fieldLabel: 'ユーザ：', 
        maxLength: 40, 
        allowBlank: true, 
        anchor:'95%' 
    });
    
    kemailField = new Ext.form.TextField({
        id:'kemailField',
        fieldLabel: 'Email：',
        allowBlank: true,
        anchor:'95%'
    });

    kdateField = new Ext.form.TextField({
        id:'kdateField',
        fieldLabel: '登録日：',
        allowNegative: false, 
        allowBlank: false,
        anchor:'95%'
    });

    kcontField = new Ext.form.TextField({
        id:'kcontField',
        fieldLabel: '備　考：',
        allowNegative: false,
        allowBlank: true,
        anchor:'95%'
    });

/* キーワード登録画面 */
    KwordCreateForm = new Ext.FormPanel({
        labelAlign: 'top',
        bodyStyle:'padding:5px',
        width: 600,        
        items: [{
            layout:'column',
            border:false,
            items:[{
                columnWidth:0.5,
                layout: 'form',
                border: false,
                items: [kwdField, kurlField, kusrField]
            },{ /* 横2段組みにするためにFieldを分ける */
                columnWidth:0.5,
                layout: 'form',
                border: false,
                items: [kemailField, kdateField, kcontField] 
            }]
        }],
        buttons: [{
            text: '[保存]',
            handler: createKword
        },{
            text: 'Cancel',
            handler: function(){
                // because of the global vars, we can only instantiate one window... so let's just hide it.
                KwordCreateWindow.hide();
            }
        }]
    });

    KwordCreateWindow = new Ext.Window({
        id: 'KwordCreateWindow',
        title: '[キーワード登録]',
        closable:true,
        width: 640,
        height: 250,
        plain:true,
        layout: 'fit',
        items: KwordCreateForm
    });
});
