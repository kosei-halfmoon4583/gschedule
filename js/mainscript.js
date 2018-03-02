//[Update the Entry] 
    var AccountDataStore;
    var AccountColumnModel;
    var AccountListingEditorGrid;
    var AccountListingWindow;

//[Adding New Entry] 
    var AccountCreateForm;
    var AccountCreateWindow;

//[Field defines.]
    var useridField;
    var passwdField;
    var jpnameField;
    var emailField;
    var notifyField;
    var adminField;
    
Ext.BLANK_IMAGE_URL = './resources/images/default/s.gif';

Ext.onReady(function(){

    Ext.QuickTips.init();

    function saveTheAccount(oGrid_event){
        Ext.Ajax.request({   
            waitMsg: 'ちょっと待ってね...',
            url: 'database.php',
            params: {
                task: "UPDATEPRES",
                userid: oGrid_event.record.data.userid,
                passwd: oGrid_event.record.data.passwd,
                jpname: oGrid_event.record.data.jpname,
                email : oGrid_event.record.data.email,
                notify: oGrid_event.record.data.notify,
                admin : oGrid_event.record.data.admin
            }, 
            success: function(response){
                var result=eval(response.responseText);
                switch(result){
                    case 1:
                        AccountDataStore.commitChanges();
                        AccountDataStore.reload();
                        break;
                    default:
                        Ext.MessageBox.alert('あれぇ...','登録できないね...');
                        break;
                }
            },
            failure: function(response){
                var result=response.responseText;
                Ext.MessageBox.alert('Error','Could not connect to the database. retry later'); 
            }
        });   
    }

    //Creates a new account data.
    function createAccount(){
        if(isAccountFormValid()){
            Ext.Ajax.request({   
                waitMsg: 'ちょっと待ってね...',
                url: 'database.php',
                params: {
                    task: "CREATEPRES",
                    userid: useridField.getValue(),
                    passwd: passwdField.getValue(),
                    jpname: jpnameField.getValue(),
                    email : emailField.getValue(),
                    notify: notifyField.getValue(),
                    admin : adminField.getValue()
                }, 
                success: function(response){ 
                    var result=eval(response.responseText);
                    switch(result){
                        case 1:
                            Ext.MessageBox.alert('OK!','アカウントを登録しました！');
                            AccountDataStore.reload();
                            AccountCreateWindow.hide();
                            break;
                        default:
                            Ext.MessageBox.alert('Warning','アカウントを登録できません...');
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
    function resetAccountForm(){
        useridField.setValue('');
        passwdField.setValue('');
        jpnameField.setValue('');
        emailField.setValue('');
        notifyField.setValue('');
        adminField.setValue('');    
    }
  
  //Check if the form is valid
    function isAccountFormValid(){
        return(
        useridField.isValid() && 
        passwdField.isValid() && 
        jpnameField.isValid() && 
        emailField.isValid() && 
        notifyField.isValid() && 
        adminField.isValid());
    }

  //Display or bring forth the form
    function displayFormWindow(){
        if(!AccountCreateWindow.isVisible()){
            resetAccountForm();
            AccountCreateWindow.show();
            useridField.focus("",10);
        } else {
            AccountCreateWindow.toFront();
            useridField.focus("",10);
        }
    }
    /*==================*
     * Delete function. *
     *==================*/
    function confirmDeleteAccount(){
        if(AccountListingEditorGrid.selModel.getCount() == 1)  { //Userが１人しか登録されていな場合の処理
            Ext.MessageBox.confirm('[ 確認！]','削除します、よろしいですか？', deleteAccount);
        } else if(AccountListingEditorGrid.selModel.getCount() > 1) { 
            Ext.MessageBox.confirm('[ 削除！]','削除します！', deleteAccount);
        } else {
            Ext.MessageBox.alert('[ 確認！]','削除できません…削除行を選択していますか？');
        }
    }  

   // This was added in Tutorial 6
    function deleteAccount(btn){
        if(btn=='yes') {
            var selections = AccountListingEditorGrid.selModel.getSelections();
            var account = [];
            for(i = 0; i< AccountListingEditorGrid.selModel.getCount(); i++) {
                account.push(selections[i].json.userid);
            }
            var encoded_array = Ext.encode(account);
            Ext.Ajax.request({  
                waitMsg: 'Please Wait',
                url: 'database.php', 
                params: { 
                    task: "DELETEPRES", 
                    ids:  encoded_array
                }, 
                success: function(response) {
                    var result=eval(response.responseText);
                    switch(result) {
                        case 1:  // Success : simply reload
                            AccountDataStore.reload();
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
        var AccountSearchForm;
        var AccountSearchWindow;
        
        var SearchUseridtem;
        var SearchJpnameItem;
        var SearchEmailItem;
        var SearchNotifyItem;
        var SearchAdminItem;

        function listSearch(){
        // change the store parameters
            AccountDataStore.baseParams = {
                task: 'SEARCH',
                userid: SearchUseridItem.getValue(),
                jpname: SearchJpnameItem.getValue(),
                email : SearchEmailItem.getValue(),
                notify: SearchNotifyItem.getValue(),
                admin : SearchAdminItem.getValue()
            };
        // Cause the datastore to do another query : 
            AccountDataStore.reload({params: {start: 0, limit: 12}});
        }
     
        function resetSearch(){
         // reset the store parameters
            AccountDataStore.baseParams = {
                task: 'LISTING'
            };
         // Cause the datastore to do another query : 
            AccountDataStore.reload({params: {start: 0, limit: 12}});
            AccountSearchWindow.close();
        }
      
        SearchUseridItem = new Ext.form.TextField({
            fieldLabel: 'ユーザID',
            maxLength: 12,
            anchor : '95%',
            maskRe: /([a-zA-Z0-9\s]+)$/
        });

        SearchJpnameItem = new Ext.form.TextField({
            fieldLabel: '氏　名',
            maxLength: 24,
            anchor : '95%',    
            maskRe: /([a-zA-Z0-9\s]+)$/  
        });
      
        SearchAdminItem = new Ext.form.ComboBox({
            fieldLabel: 'Admin',
            store:new Ext.data.SimpleStore({
                fields:['adminValue', 'adminName'],
                data: [['0','Sys利用者'],['1','Sys管理者'],['2','Developer'],['3','Test Staff'],['4','GuestUser']]
            }),
            mode: 'local',
            displayField: 'adminName',
            valueField: 'adminValue',
            anchor:'95%',
            triggerAction: 'all'
        });
            

        SearchEmailItem = new Ext.form.TextField({
            fieldLabel: 'email',
            maxLength: 128,
            anchor:'95%',
            maskRe: new RegExp("")
        });
          
        SearchNotifyItem = new Ext.form.TextField({
            fieldLabel: 'Notify',
            maxLength: 2,
            anchor:'95%',
            maskRe:  /([a-zA-Z0-9\s]+)$/  
        });

        AccountSearchForm = new Ext.FormPanel({
            labelAlign: 'top',
            bodyStyle: 'padding: 5px',
            width: 300,
            items: [{
                layout: 'form',
                border: false,
                items: [ SearchUseridItem,SearchJpnameItem,SearchEmailItem,SearchNotifyItem, SearchAdminItem ],
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
            var item = AccountSearchForm.items.find(findFirst);
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

        AccountSearchWindow = new Ext.Window({
            title: '[ ユーザ検索 ]',
            closable:true,
            width: 200,
            height: 400,
            plain:true,
            layout: 'fit',
            items: AccountSearchForm
        });

        // once all is done, show the search window
        AccountSearchWindow.show();
        // Focus Set.
        SearchUseridItem.focus("",10);
    } 

    //Configulation.
    AccountDataStore = new Ext.data.Store({
        id: 'AccountDataStore',
        proxy: new Ext.data.HttpProxy({
                   url: 'database.php', 
                   method: 'POST'
               }),
            baseParams:{task: "LISTING"}, // this parameter is passed for any HTTP request
        reader: new Ext.data.JsonReader({
            root: 'results',
            totalProperty: 'total',
            id: 'id'
        },[ 
            {name: 'userid', type: 'string', mapping: 'userid'},
            {name: 'passwd', type: 'string', mapping: 'passwd'},
            {name: 'jpname', type: 'string', mapping: 'jpname'},
            {name: 'email', type: 'string', mapping: 'email'},
            {name: 'notify', type: 'int', mapping: 'notify'},
            {name: 'admin', type: 'int', mapping: 'admin'}
        ]),
        sortInfo:{field: 'userid', direction: "ASC"}
    });
    
    AccountColumnModel = new Ext.grid.ColumnModel(
      [{
          header: '[ ユーザID ]',
          readOnly: true,
          dataIndex: 'userid',
          width: 100,
          hidden: false
      },{
          header: '[ Password ]',
          dataIndex: 'passwd',
          width: 100,
          editor: new Ext.form.TextField({
              allowBlank: false,
              maxLength: 20,
              maskRe: /([a-zA-Z0-9\s]+)$/
          })
      },{
          header: '[ 氏　名 ]',
          dataIndex: 'jpname',
          width: 150,
          editor: new Ext.form.TextField({
              allowBlank: false,
              maxLength: 20,
              maskRe: /([a-zA-Z0-9\s]+)$/
          })
      },{
          header: '[ email ]',
          readOnly: true,
          dataIndex: 'email',
          width: 180,
          editor: new Ext.form.TextField({
              allowBlank: false,
              maxLength: 255,
              maskRe: new RegExp("")
          }),
          hidden: false
      },{
          header: 'Notify',
          dataIndex: 'notify',
          width: 44,
          editor: new Ext.form.NumberField({
              allowBlank: false,
              maxLength: 1,
              //maskRe: /([a-zA-Z0-9\s]+)$/
              maskRe: new RegExp("[0-9]")  
          }),
          renderer: function(value, cell){ 
              var str = '';
              if(value > 0){
                  str = "<span style='color:#3366FF;'><b>" + value + "</b></span>";
              } else {
                  str = "<span style='color:#CC0000;'>" + value + "</span>";
              }
              return str; 
          }
      },{
          header: 'Admin',
          dataIndex: 'admin',
          width: 48,
          editor: new Ext.form.NumberField({
              allowBlank: false,
              maxLength: 1,
              maskRe: /([a-zA-Z0-9\s]+)$/
          }),
          renderer: function(value, cell){ 
              var str = '';
              if(value > 0){
                  str = "<span style='color:#3366FF;'>" + value + "</span>";
              } else {
                  str = "<span style='color:#CC0000;'>" + value + "</span>";
              }
              return str; 
          }
      }]
    );
    AccountColumnModel.defaultSortable= true;
    
    AccountListingEditorGrid = new Ext.grid.EditorGridPanel({
        id: 'AccountListingEditorGrid',
        store: AccountDataStore,
        cm: AccountColumnModel,
        enableColLock:false,
        clicksToEdit:1,
        selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),

        bbar: new Ext.PagingToolbar({
            pageSize: 12,
            store: AccountDataStore,
            displayInfo: true
        }),

        tbar: [
            {
                text: '[ユーザ登録]',
                tooltip: 'ユーザ新規登録です！',
                iconCls: 'add', 
                handler: displayFormWindow
            }, '-', {
                text: '[ユーザ削除]',
                tooltip: 'この方を削除します、さよなら…',
                handler: confirmDeleteAccount, 
                iconCls:'remove'
            }, '-', {
                text: '[ユーザ検索]',
                tooltip: 'ユーザを検索します！',
                handler: startAdvancedSearch,   
                iconCls:'search'
            }, '-', {
                text: 'Quick Search[userid]',
                tooltip: '簡易検索：useridで検索してちょ！' 
            },  new Ext.app.SearchField({
                store: AccountDataStore,
                params: {start: 0, limit: 12},
                width: 120
            })
        ]
    });
    
    AccountListingWindow = new Ext.Window({
        id: 'AccountListingWindow',
        title: '[ ユーザ 一覧表 ]',
        closable:true,
        width:660,
        /* height:362, */
        height:342,
        plain:true,
        layout: 'fit',
        items: AccountListingEditorGrid
    });
  
    AccountDataStore.load({params: {start: 0, limit: 12}});
    AccountListingWindow.show();
    AccountListingEditorGrid.on('afteredit', saveTheAccount);

/* Account Entry Field Defines here. */
    useridField = new Ext.form.TextField({
        id: 'useridField',
        fieldLabel: 'ユーザID：',
        maxLength: 8,
        allowBlank: false,
        anchor : '95%',
        maskRe: /([a-zA-Z0-9\s]+)$/
    });

    passwdField = new Ext.form.TextField({
        id: 'passwdField',
        fieldLabel: 'Password：',
        maxLength: 8,
        allowBlank: false,
        anchor : '95%',    
        maskRe: /([a-zA-Z0-9\s]+)$/  
    });
  
    jpnameField = new Ext.form.TextField({
        id:'jpnameField',
        fieldLabel: '氏　名：',
        allowBlank: false,
        anchor:'95%'
    });
    
    emailField = new Ext.form.TextField({
        id:'emailField',
        fieldLabel: 'Email：',
        allowBlank: false,
        anchor:'95%'
    });

    notifyField = new Ext.form.NumberField({
        id:'notifyField',
        fieldLabel: 'NOTIFY：',
        allowNegative: false,
        allowBlank: false,
        anchor:'95%'
    });

    adminField = new Ext.form.ComboBox({
        id:'adminField',
        fieldLabel: '管理者：',
        store:new Ext.data.SimpleStore({
            fields:['adminValue', 'adminName'],
            data: [['0','Sys利用者'],['1','Sys管理者'],['2','Developer'],['3','Test Staff'],['4','GuestUser']]
        }),
        mode: 'local',
        displayField: 'adminName',
        allowBlank: false,
        valueField: 'adminValue',
        anchor:'95%',
        triggerAction: 'all'
    });

    AccountCreateForm = new Ext.FormPanel({
        labelAlign: 'top',
        bodyStyle:'padding:5px',
        width: 600,        
        items: [{
            layout:'column',
            border:false,
            items:[{
                columnWidth:0.5,
                layout: 'form',
                border:false,
                items: [useridField, passwdField, jpnameField]
            },{ /* 横2段組みにするためにFieldを分ける */
                columnWidth:0.5,
                layout: 'form',
                border:false,
                items: [emailField, notifyField, adminField]
            }]
        }],
        buttons: [{
            text: '[保存]',
            handler: createAccount
        },{
            text: 'Cancel',
            handler: function(){
                // because of the global vars, we can only instantiate one window... so let's just hide it.
                AccountCreateWindow.hide();
            }
        }]
    });

    AccountCreateWindow = new Ext.Window({
        id: 'AccountCreateWindow',
        title: '[ユーザ登録]',
        closable:true,
        width: 640,
        height: 250,
        plain:true,
        layout: 'fit',
        items: AccountCreateForm
    });
});
