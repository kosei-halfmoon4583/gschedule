//[Update the schedule Entry] 
    var schdTitleDataStore; 
    var schdTitleColumnModel; 
    var schdTitleListingEditorGrid; 
    var schdTitleListingWindow; 

//[Adding New Entry] 
    var schdTitleCreateForm; 
    var schdTitleCreateWindow; 

//[Field variables defines.] 
    var schdidField; 
    var schdField; 
    var surlField; 
    var susrField; 
    var semailField; 
    var sdateField; 
    var sremarkField; 
    
    var dt = new Date(); 

Ext.BLANK_IMAGE_URL = './resources/images/default/s.gif';

Ext.onReady(function(){

    Ext.QuickTips.init();

/* [Field Dataをschddb.phpへパラメータとして引き渡す] */

    function saveSchdTitle(oGrid_event){
        Ext.Ajax.request({   
            waitMsg: 'ちょっと待ってね...',
            url: 'schddb.php',
            params: {
                task: "UPDATEPRES",
                schdid: oGrid_event.record.data.schdid,
                schd: oGrid_event.record.data.schd,
                surl: oGrid_event.record.data.surl,
                susr: oGrid_event.record.data.susr,
                semail: oGrid_event.record.data.semail,
                sdate : oGrid_event.record.data.sdate,
                sremark : oGrid_event.record.data.sremark
            }, 
            success: function(response){
                var result=eval(response.responseText);
                switch(result){
                    case 1:
                        schdTitleDataStore.commitChanges();
                        schdTitleDataStore.reload();
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
    function createSchdTitle(){ 
        if(isSchdTitleFormValid()){
            Ext.Ajax.request({   
                waitMsg: 'ちょっと待ってね...',
                url: 'schddb.php',
                params: {
                    task: "CREATEPRES",
                    schd: schdField.getValue(),
                    surl: surlField.getValue(),
                    susr: susrField.getValue(),
                    semail : semailField.getValue(),
                    sdate: sdateField.getValue(),
                    sremark : sremarkField.getValue()
                }, 
                success: function(response){ 
                    var result=eval(response.responseText);
                    switch(result){
                        case 1:
                            Ext.MessageBox.alert('OK!','キーワードを登録しました！');
                            schdTitleDataStore.reload();
                            schdTitleCreateWindow.hide();
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
    function resetSchdTitleForm(){ 
        schdidField.setValue(''); 
        schdField.setValue(''); 
        surlField.setValue(''); 
        susrField.setValue(''); 
        semailField.setValue(''); 
        sdateField.setValue(dt.format('Y-m-d H:i:s')); 
        sremarkField.setValue('');    
    }

  //Check if the form is valid [必須入力項目チェック]
    function isSchdTitleFormValid(){
        return(
            schdField.isValid() &&  /* keyword Field */
            surlField.isValid());  /* URL Field */
    }

  //Display or bring forth the form
    function displayFormWindow(){
        if(!schdTitleCreateWindow.isVisible()){
            resetSchdTitleForm();
            schdTitleCreateWindow.show();
            schdField.focus("",10);
        } else {
            schdTitleCreateWindow.toFront();
            schdField.focus("",10);
        }
    }
    /*==================*
     * Delete function. *
     *==================*/
    function confirmDeleteSchdTitle(){
        if(schdTitleListingEditorGrid.selModel.getCount() == 1)  { //Userが１人しか登録されていな場合の処理
            Ext.MessageBox.confirm('[ 確認！]','削除します、よろしいですか？', deleteSchdTitle);
        } else if(schdTitleListingEditorGrid.selModel.getCount() > 1) { 
            Ext.MessageBox.confirm('[ 削除！]','削除します！', deleteSchdTitle);
        } else {
            Ext.MessageBox.alert('[ 確認！]','削除できません…削除行を選択していますか？');
        }
    }  

/* [ DELETE Keyword Data ] */
    function deleteSchdTitle(btn){
        if(btn=='yes') {
            var selections = schdTitleListingEditorGrid.selModel.getSelections();
            var schdTitle = [];
            for(i = 0; i< schdTitleListingEditorGrid.selModel.getCount(); i++) {
                schdTitle.push(selections[i].json.schdid);
            }
            var encoded_array = Ext.encode(schdTitle);
            Ext.Ajax.request({  
                waitMsg: 'Please Wait',
                url: 'schddb.php', 
                params: { 
                    task: "DELETEPRES", 
                    ids:  encoded_array
                }, 
                success: function(response) {
                    var result=eval(response.responseText);
                    switch(result) {
                        case 1:  // Success : simply reload
                            schdTitleDataStore.reload();
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

/* [ Keyword 検索 ] */
    function startAdvancedSearch(){
        // local vars
        var SchdTitleSearchForm;
        var SchdTitleSearchWindow;
        
        var SearchschdidItem;
        var SearchschdItem;
        var SearchsemailItem;
        var SearchsusrItem;
        var SearchsurlItem;

        function listSearch(){
        // change the store parameters
            schdTitleDataStore.baseParams = {
                task: 'SEARCH',
                schdid: SearchschdidItem.getValue(),
                schd: SearchschdItem.getValue(),
                semail : SearchsemailItem.getValue(),
                susr: SearchsusrItem.getValue(),
                surl : SearchsurlItem.getValue()
            };
        // Cause the datastore to do another query : 
            schdTitleDataStore.reload({params: {start: 0, limit: 10}});
        }
     
        function resetSearch(){
         // reset the store parameters
            schdTitleDataStore.baseParams = {
                task: 'LISTING'
            };
         // Cause the datastore to do another query : 
            schdTitleDataStore.reload({params: {start: 0, limit: 10}});
            SchdTitleSearchWindow.close();
        }
      
        SearchschdidItem = new Ext.form.TextField({
            fieldLabel: 'KID',
            maxLength: 12,
            anchor : '95%',
            maskRe: /([a-zA-Z0-9\s]+)$/
        });

        SearchschdItem = new Ext.form.TextField({
            fieldLabel: 'キーワード',
            maxLength: 48,
            anchor : '95%',    
            maskRe: /([a-zA-Z0-9\s]+)$/  
        });
      
        SearchsemailItem = new Ext.form.TextField({
            fieldLabel: 'email',
            maxLength: 128,
            anchor:'95%',
            maskRe: new RegExp("")
        });

        SearchsusrItem = new Ext.form.TextField({
            fieldLabel: 'ユーザ',
            maxLength: 128,
            anchor:'95%',
            maskRe: new RegExp("")
        });
          
        SearchsurlItem = new Ext.form.TextField({
            fieldLabel: 'URL',
            maxLength: 48,
            anchor:'95%',
            maskRe: "/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/" 
        });

        SchdTitleSearchForm = new Ext.FormPanel({
            labelAlign: 'top',
            bodyStyle: 'padding: 5px',
            width: 300,
            items: [{
                layout: 'form',
                border: false,
                items: [ SearchschdidItem,SearchschdItem,SearchsurlItem,SearchsusrItem,SearchsemailItem ],
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
            var item = SchdTitleSearchForm.items.find(findFirst);
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

        SchdTitleSearchWindow = new Ext.Window({
            title: '[ ユーザ検索 ]',
            closable:true,
            width: 200,
            height: 322,
            plain:true,
            layout: 'fit',
            items: SchdTitleSearchForm
        });

        // once all is done, show the search window
        SchdTitleSearchWindow.show();
        // Focus Set.
        SearchschdidItem.focus("",10);
    } 

/*-- For Debug --*/
    //Configulation.
    schdTitleDataStore = new Ext.data.Store({ 
        id: 'schdTitleDataStore',
        proxy: new Ext.data.HttpProxy({
                   url: 'schddb.php', 
                   method: 'POST'
               }),
            baseParams:{task: "LISTING"}, // this parameter is passed for any HTTP request
        reader: new Ext.data.JsonReader({
            root: 'results',
            totalProperty: 'total',
            id: 'id'
        },[ 
            {name: 'schdid', type: 'int', mapping: 'schdid'}, 
            {name: 'schd', type: 'string', mapping: 'schd'}, 
            {name: 'surl', type: 'string', mapping: 'surl'}, 
            {name: 'susr', type: 'string', mapping: 'susr'}, 
            {name: 'semail', type: 'string', mapping: 'semail'}, 
            {name: 'sdate', type: 'string', mapping: 'sdate'}, 
            {name: 'sremark', type: 'string', mapping: 'sremark'} 
        ]),
        sortInfo:{field: 'schdid', direction: "ASC"}
    });
    
    schdTitleColumnModel = new Ext.grid.ColumnModel(
      [{
          header: '[ schdID ]',
          readOnly: true,
          dataIndex: 'schdid',
          width: 54,
          hidden: false
      },{
          header: '[ 予定内容 ]',
          dataIndex: 'schd',
          width: 100,
          editor: new Ext.form.TextField({
              allowBlank: false,
              maxLength: 255,
              maskRe: /([a-zA-Z0-9\s]+)$/
          })
      },{
          header: '[ URL ]',
          dataIndex: 'surl',
          width: 158,
          editor: new Ext.form.TextField({
              allowBlank: false,
              maxLength: 255,
              maskRe: "/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/" 
          })
      },{
          header: '[ ユーザ ]',
          dataIndex: 'susr',
          width: 84,
          editor: new Ext.form.TextField({
              allowBlank: false,
              maxLength: 40,
              maskRe: new RegExp("")
          }),
          hidden: false
      },{
          header: '[ Email ]',
          dataIndex: 'semail',
          width: 164,
          editor: new Ext.form.TextField({
              allowBlank: false,
              maxLength: 80,
              maskRe: new RegExp("")
          }),
          hidden: false
      },{
          header: '[ 登録日 ]',
          dataIndex: 'sdate',
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
          dataIndex: 'sremark',
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
    schdTitleColumnModel.defaultSortable= true;
    
    schdTitleListingEditorGrid = new Ext.grid.EditorGridPanel({
        id: 'schdTitleListingEditorGrid',
        store: schdTitleDataStore,
        cm: schdTitleColumnModel,
        enableColLock:false,
        clicksToEdit:1,
        selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),

        bbar: new Ext.PagingToolbar({
            pageSize: 10,
            store: schdTitleDataStore,
            displayInfo: true
        }),

        tbar: [
            {
                text: '[予定内容　登録]',
                tooltip: '予定内容　新規登録です！',
                iconCls: 'add', 
                handler: displayFormWindow
            }, '-', {
                text: '[予定内容　削除]',
                tooltip: 'この予定内容を削除します、さよなら…',
                handler: confirmDeleteSchdTitle, 
                iconCls:'remove'
            }, '-', {
                text: '[予定内容検索]',
                tooltip: '予定内容を検索します！',
                handler: startAdvancedSearch,   
                iconCls:'search'
            }, '-', {
                text: 'Quick Search [schd]',
                tooltip: '簡易検索：予定内容IDで検索してちょ！' 
            },  new Ext.app.SearchField({
                store: schdTitleDataStore,
                params: {start: 0, limit: 10},
                width: 120
            })
        ]
    });
    
    schdTitleListingWindow = new Ext.Window({
        id: 'schdTitleListingWindow',
        title: '[ 予定内容一覧表 ]',
        closable:true,
        width:660,
        height:328,
        plain:true,
        layout: 'fit',
        items: schdTitleListingEditorGrid
    });
    schdTitleDataStore.load({params: {start: 0, limit: 10}});
    schdTitleListingWindow.show();
    schdTitleListingEditorGrid.on('afteredit', saveSchdTitle);

/* SchdTitle Entry Field Defines here. */
    schdidField = new Ext.form.TextField({
        id: 'schdidField',
        fieldLabel: 'KID：',
        maxLength: 8,
        allowBlank: false,
        anchor : '95%',
        maskRe: /([a-zA-Z0-9\s]+)$/
    });

    schdField = new Ext.form.TextField({
        id: 'schdField',
        fieldLabel: '予定内容：',
        maxLength: 255,
        allowBlank: false,
        anchor : '95%',    
        maskRe: /([a-zA-Z0-9\s]+)$/ 
    });
  
    surlField = new Ext.form.TextField({
        id:'surlField', 
        fieldLabel: 'URL：', 
        maxLength: 255, 
        allowBlank: false, 
        anchor:'95%', 
        maskRe: "/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/" 
    });
  
    susrField = new Ext.form.TextField({
        id:'susrField', 
        fieldLabel: 'ユーザ：', 
        maxLength: 40, 
        allowBlank: true, 
        anchor:'95%' 
    });
    
    semailField = new Ext.form.TextField({
        id:'semailField',
        fieldLabel: 'Email：',
        allowBlank: true,
        anchor:'95%'
    });

    sdateField = new Ext.form.TextField({
        id:'sdateField',
        fieldLabel: '登録日：',
        allowNegative: false, 
        allowBlank: false,
        anchor:'95%'
    });

    sremarkField = new Ext.form.TextField({
        id:'sremarkField',
        fieldLabel: '備　考：',
        allowNegative: false,
        allowBlank: true,
        anchor:'95%'
    });

/* キーワード登録画面 */
    schdTitleCreateForm = new Ext.FormPanel({
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
                items: [schdField, surlField, susrField]
            },{ /* 横2段組みにするためにFieldを分ける */
                columnWidth:0.5,
                layout: 'form',
                border: false,
                items: [semailField, sdateField, sremarkField] 
            }]
        }],
        buttons: [{
            text: '[保存]',
            handler: createSchdTitle
        },{
            text: 'Cancel',
            handler: function(){
                // because of the global vars, we can only instantiate one window... so let's just hide it.
                schdTitleCreateWindow.hide();
            }
        }]
    });

    schdTitleCreateWindow = new Ext.Window({
        id: 'schdTitleCreateWindow',
        title: '[予定内容　登録]',
        closable:true,
        width: 640,
        height: 250,
        plain:true,
        layout: 'fit',
        items: schdTitleCreateForm
    });
});
