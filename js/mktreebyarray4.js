//ココから下は触らなくてもO.K！
//(namespaceは使わなくても動作します。）
YAHOO.namespace('tato'); //カスタマイズした関数など用に名前空間を用意しておきます。
YAHOO.tato.tree = function(id) {
  
this.tree = new YAHOO.widget.TreeView(id); //id：ツリーを表示するDIVのID名です。
  
//Tree描画 by Array
YAHOO.tato.tree.prototype.mkTreeByArray = function (treeData,treeNode){
  
    if(!treeNode)treeNode = this.tree.getRoot(); 
    
    for(var i in treeData){
    
      if(treeData[i][0]){
      
        if(!(treeData[i][0]=="_open"||treeData[i][0]=="_close"||treeData[i][0]=="_load"))
          var tmpNode = new YAHOO.widget.TextNode(""+treeData[i][0],treeNode, 
            (treeData[i][1])?(treeData[i][1][0]=="_open"):false);
        
        if(typeof treeData[i][1] == "string"){
        
          if(templateForMakeTreeATagAttr)
            templateForMakeTreeATagAttr(tmpNode,treeData[i]);

        } else 
        if(typeof treeData[i][1] == "object"){
          //  var swt = treeData[i][1][0][0];
          var swt = treeData[i][1][0];
          switch(swt){
              case   "_open"  : tmpNode.expand();
                  break;
              case   "_close" : tmpNode.collapse();
                  break;
              case   "_load"  : YAHOO.tato.loadTreeData(this,tmpNode,treeData[i]);
                  break;
              case   "_loadJSON"  : YAHOO.tato.loadTreeData(this,tmpNode,treeData[i]);
                  break;
              case   "_loadXML"  : YAHOO.tato.loadTreeData(this,tmpNode,treeData[i],true);
                  break;
              dafault :tmpNode.collapse();
                  break;
          }
          this.mkTreeByArray(treeData[i][1],tmpNode); 
        }
      }
    }
    this.tree.draw();
  }
}

YAHOO.tato.loadTreeData = function(oj,tmpNode,treeDataFrg,xml){
  if(!!YAHOO.util.Connect){
      if(treeDataFrg[1][0][1]){
        tmpNode.method=(treeDataFrg[1][0][1].method)?treeDataFrg[1][0][1].method:"GET";
        tmpNode.url=(treeDataFrg[1][0][1].url)?treeDataFrg[1][0][1].url:"";
      }
      tmpNode.setDynamicLoad(
        function (node,onCompleteCallback ){
          tmpNode =new YAHOO.widget.Node("",tmpNode.pearent,false);
          var delay = YAHOO.tato.loadTreeData.delay ;
          if(YAHOO.tato.loadTreeData.delay>0)setTimeout(onCompleteCallback,delay);
          else onCompleteCallback();
        }
      );


      getResponse_XML = function(oj){//alert(oj.argument.node.hasChildren(true))
        data = eval(oj.responseXML);alert('xml')
        //this.mkTreeByXML (data,oj.argument.node); 
      } 
      getResponse_JSON = function(oj){//alert(oj.argument.node.hasChildren(true))
        data = eval(oj.responseText);
        this.mkTreeByArray (data,oj.argument.node); 
      } 

      if(xml)var callbackFn = getResponse_XML;
      else   var callbackFn = getResponse_JSON;

      oj.tree.onExpand= function(node) {//alert(node.hasChildren(true))
        //if(tmpNode.label==node.label)
        if(node.hasChildren(true))
        if(node.children.length<=0){
          YAHOO.util.Connect.asyncRequest(node.method,node.url,{
            argument:{'node':node},scope:oj,success: callbackFn
          },null);
        }
      }
  }
}
YAHOO.tato.loadTreeData.delay = 100;
YAHOO.tato.e = function(oj1,oj2){for(var i in oj2)oj1[i]=oj2[i];return oj1} //簡易extendメソッド
function $(e){return document.getElementById(e)||e} //超簡易ドル関数

