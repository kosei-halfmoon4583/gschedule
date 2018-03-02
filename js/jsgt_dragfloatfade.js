  function setDragableFloat(id,x,y)
  {
    //ドラッガブルフロートDIVを生成
    div1 = dragableFloat(id,x,y);
    
    //DIVへHTMLを挿入
    div1.innerHTML="";
    div1.style.display="none";

    //ドラッグ開始
    doDragableFloat()
  }


////
// 設定
//
// @syntax oj = dragableFloat("DIVのID名",初期位置X,初期位置Y)
//
// @sample   div1 = dragableFloat("aaa",100,200) //生成
// @sample   div1.innerHTML="あいうえお"         //HTMLを挿入
// @sample   div1.style.backgroundColor='orange' //CSSで修飾
// @sample   doDragableFloat()                   //開始
//	

  //クロスブラウザ不透明度設定関数 //2006.3 Opera9bpr2対応
  function setOpacity(layName,arg) {
      var ua = navigator.userAgent,oj = document.getElementById(layName)
      if(window.opera){//o9bpr2+
          if((typeof oj.style.opacity)=='string')oj.style.opacity = arg
          else return
      } else if(ua.indexOf('Safari') !=-1 || ua.indexOf('KHTML') !=-1 || 
          (typeof oj.style.opacity)=='string') { //s,k,new m
          oj.style.opacity = arg
      } else if(document.all) {          //win-e4,win-e5,win-e6
          document.all(layName).style.filter="alpha(opacity=0)"
          document.all(layName).filters.alpha.Opacity  = (arg * 100)
      } else if(ua.indexOf('Gecko')!=-1) //n6,n7,m1
          oj.style.MozOpacity = arg
  }
  
  //クロスブラウザフェイド関数
  function fadeOpacity(layName,swt,stopOpacity){
    
    if(!window.fadeOpacity[layName]) //カウンター初期化
      fadeOpacity[layName] =0 
    //フェイドスイッチ引数省略時初期値(不透明から透明へ)
    if(!arguments[1]) swt = -1
    //引数swtが -1 なら不透明から透明へ
    //           1 なら透明から不透明へフェイドする
    if(swt==-1)        var f  = "9876543210"
    else if(swt==1)    var f  = "0123456789"
    else               var f  = "9876543210"
    //停止不透明度引数省略時初期値
    if(!arguments[2] && swt==-1)     stopOpacity = 0
    else if(!arguments[2] && swt==1) stopOpacity = 10

    //フェイド処理    
    if( fadeOpacity[layName] < f.length-1 ){
      //カウンター番目の文字列を取り出す
      var opa = f.charAt(fadeOpacity[layName])/10
      //終了時不透明度なら終了
      if( opa == stopOpacity ){
        setOpacity(layName,stopOpacity)  //終了
        fadeOpacity[layName] = 0     //リセット
        return
      }
      // 不透明度変更を実行する
      setOpacity(layName,opa)
      // カウンターを加算
      fadeOpacity[layName]++
      //--50/1000秒後にfadeOpacityを再実行
      setTimeout('fadeOpacity("'+layName+'","'+swt+'","'+stopOpacity+'")',50)
    } else {
      //終了
      setOpacity(layName,stopOpacity)
      //--リセット
      fadeOpacity[layName] = 0
    }
  }
  


  function fadeBGCOLOR(layName,sColor,eColor,timer,trns){  
  
    //初期化
    if(!window.fadeBGCOLOR[layName]){
      if(!window.fadeBGCOLOR.arguments[1])
        sColor='#000000'     //デフォルト開始色
      if(!window.fadeBGCOLOR.arguments[2])
        eColor='#ffffff'     //デフォルト終了色
      else if(eColor==''||eColor=='transparent')
        var endTranspar='on' //完了時透明指定
      if(!window.fadeBGCOLOR.arguments[3])
        timer ='30'          //書き換え間隔(1/1000秒単位)
      if(!window.fadeBGCOLOR.arguments[4])
             endTranspar='on'//完了時透明指定
      else   endTranspar=trns
  
      //16進指定色分解c&10進数化&開始から終了までの差分
      var s=sColor.split('') //開始色分解
      var e=eColor.split('') //終了色分解
      var saR = parseInt(''+ e[1]+ e[2],16)
               -parseInt(''+ s[1]+ s[2],16)//R
      var saG = parseInt(''+ e[3]+ e[4],16)
               -parseInt(''+ s[3]+ s[4],16)//G
      var saB = parseInt(''+ e[5]+ e[6],16)
               -parseInt(''+ s[5]+ s[6],16)//B
      //加減設定(開始時より終了時が少なければ-1)
      var kaR,kaG,kaB //加減R,加減G,加減B
      if(saR<=-1){kaR=-1}else if(saR>=1){kaR=+1}else{kaR=0}
      if(saG<=-1){kaG=-1}else if(saG>=1){kaG=+1}else{kaG=0}
      if(saB<=-1){kaB=-1}else if(saB>=1){kaB=+1}else{kaB=0}
      //初期値セット[カウント,R差分,G差分,B差分
      //                     ,加減R,加減G,加減B
      //                     ,終了色R,終了色G,終了色B
      //                     ,書き換え間隔,完了時透明指定]
      fadeBGCOLOR[layName]= [0,parseInt(Math.abs(saR)/16,10)
                              ,parseInt(Math.abs(saG)/16,10)
                              ,parseInt(Math.abs(saB)/16,10)
                              ,kaR,kaG,kaB
                              ,parseInt(''+ e[1]+ e[2],16)
                              ,parseInt(''+ e[3]+ e[4],16)
                              ,parseInt(''+ e[5]+ e[6],16)
                             ,timer,endTranspar,0,'']
      //16進変換用配列
      fto0 = new Array( '0','1','2','3','4','5','6','7'
                       ,'8','9','a','b','c','d','e','f')
    } 
  
    if(!sColor)return //エラー時無視
  
    //作業用配列
    var wk  = fadeBGCOLOR[layName] //初期値のコピー
    var c   = new Array()          //各色用
    var run = new Array()          //10進現在色用
  
    //16進現在色取得 カラー分解&10進数化
    s=sColor.split('')
      run[1] = parseInt(''+ s[1]+ s[2],16) //Red
      run[2] = parseInt(''+ s[3]+ s[4],16) //Green
      run[3] = parseInt(''+ s[5]+ s[6],16) //Blue
    //フェイド作業
    if( wk[0] < 16 ){
  
      for( i=1 ; i<=3 ; i++){ 
        
        c[i] = run[i] + wk[i]*wk[(3+i)]      //現在色へ加減 
        c[i] <=  0 ? c[i] =  0 : c[i] = c[i] //0で停止
        c[i] >= 255? c[i] =255 : c[i] = c[i] //255で停止
        if(wk[(3+i)]==1)                     //終了色で停止
          c[i] >= wk[(6+i)]?c[i]=wk[(6+i)]:c[i]=c[i]
        else
          c[i] <= wk[(6+i)]?c[i]=wk[(6+i)]:c[i]=c[i] 
        //16進数へ変換
        c[i] =  fto0[Math.floor(c[i]/(16))] 
              + fto0[Math.floor(c[i]%(16))]
  
      }

      var cl=c[1] + c[2] + c[3]
      setBGCOLOR( layName , '#'+cl )
      fadeBGCOLOR[layName][0] ++
      clearTimeout(wk[12])
      //再帰
      wk[12]=setTimeout('fadeBGCOLOR("'+layName+'","#'+cl
        +'","'+eColor+'","'+wk[10]+'","'+wk[11]+'","'+1+'")',wk[10] )
    } else {
  
      //--リセット(完了時透明がoff以外は背景色を透明に戻す)
      if(wk[11]!='off') setBGCOLOR( layName , '' )
      clearTimeout(wk[12])
      fadeBGCOLOR[layName]=0
    }
  } 
  function setBGCOLOR(layName,color){
    //opera6 は透明が効かないのでページ背景色と同色(ここではwhite)へ便宜修正
    if(color=='')(navigator.userAgent.search("Opera(\ |\/)6")!= -1)
          ?color='white':color='transparent'; //←このwhiteを背景色に書換える
    if(document.getElementById)         //e5,e6,n6,n7,m1,o6,o7,s1用
      document.getElementById(layName).style.backgroundColor =color
    else if(document.all)               //e4用
      document.all(layName).style.backgroundColor=color
    else if(document.layers){           //n4用
      if(color=='transparent')color=null
        document.layers[layName].bgColor=color 
    }
  }




////
// グローバル変数
//
// @var    zcount             全ドラッガブルDIV中で現在のzindex最前面
// @var    clickElement       現在ドラッグ中のDIVのID名
// @var    canvas             document.body のDOCTYPE標準モード対応
// @array  dragableFloatId    全ドラッガブルDIVのID名を格納
//
var zcount = 0          ;
var clickElement = ""   ;
if(document.getElementsByTagName('BODY').length==0)document.write('<body>')//ダミーのbodyタグ
var canvas = document[ 'CSS1Compat' == document.compatMode ? 'documentElement' : 'body'];
var dragableFloatId=[]  ;
var recx1,recy1,recx2,recy2,recxOffset,recyOffset


////
// 設定された全ドラッガブルDIVを開始
//
//
function doDragableFloat()
{ 

  for(i in dragableFloatId){ 
    var oj = document.getElementById(dragableFloatId[i]) ;
    if(oj.floatEnabled){

      if(!(is.safari || is.khtml))
      {
        //スクロール時の動作
        window.onscroll = function(e){
            moveDiv(oj,oj.style.left,oj.style.top);
        }
      } else {
        aaa=setInterval(function(){
          moveDiv(oj,oj.style.left,oj.style.top);
        },100)
      }
    }
  }
}

//全ドラッガブルDIVのフロートをスタート
function startDragableFloat()
{
    for(i in dragableFloat ){
        var oj = document.getElementById(dragableFloat[i].id) ;
        moveDiv(oj,oj.style.left,oj.style.top);
    }
}

//DIVを浮かす    
function moveDiv (oj,ofx,ofy)
{
    if(oj.draging)return  ;//ドラッグ中は無視
    if(oj.dragcnt == 0 ){ 
        ofx = parseInt(ofx,10) 
        ofy = parseInt(ofx,10) 
        oj.dragcnt++
    } else {//ドラッグ終了位置がオフセット
        ofx = parseInt(oj.pageOffLeft,10) 
        ofy = parseInt(oj.pageOffTop,10) 
    }
    var l = parseInt(canvas.scrollLeft,10) 
    var t = parseInt(canvas.scrollTop,10) 
    oj.style.left = l + ofx+"px"
    oj.style.top  = t + ofy+"px"
}


////
//ブラウザ判定
//
// @sample               alert(is.ie)
//
var is = 
{
    ie     : !!document.all ,
    mac45  : navigator.userAgent.indexOf('MSIE 4.5; Mac_PowerPC') != -1 ,
    opera  : !!window.opera ,
    safari : navigator.userAgent.indexOf('Safari') != -1 ,
    khtml  : navigator.userAgent.indexOf('Konqueror') != -1 
}

////
// ドラッガブルフロートDIV生成
//
// @sample          div1 = dragableFloat("aaa",100,200)
//

function dragableFloat(id,x,y)
{
    if(!!dragableFloatId[id]) return document.getElementById(id)
    
    ////
    // DIV生成
    // @param  id             DIVのID名
    //
    this.mkDiv = function (id) 
    {
        var canvas = document[ 'CSS1Compat' == document.compatMode ? 'documentElement' : 'body'];
        var doc   = document                           ; // documentオブジェクト
        var body  = doc.body                           ;
        var elem  = doc.createElement("DIV")           ; //DIV要素を生成
        var div   = body.appendChild(elem);
            div.setAttribute("id",id)                   ;
            div.style.position = "absolute"           ;
            div.style.left     = x + "px"             ;
            div.style.top      = y + "px"             ;
            div.innerHTML      = ""                   ;
            div.offLeft        = 0                    ;
            div.offTop         = 0                    ;
            div.pageOffLeft    = x-parseInt(canvas.scrollLeft,10)+ "px";
            div.pageOffTop     = y-parseInt(canvas.scrollTop,10) + "px";
            div.dragcnt        = 0                    ;
            div.draging        = false                ;
            div.getTOP         = getTOP               ;
            div.getLEFT        = getLEFT              ;
            div.getMouseX      = getMouseX            ;
            div.getMouseY      = getMouseY            ;
            recx1              = x
            recy1              = y
            
            div.floatEnabled   = true                 ; //フロート可能 true|false
            div.boundEnabled   = false                ; //移動可能領域あり true|false
            
            div.moveTo         = function (x,y){
                div.style.left = x + "px"             ;
                div.style.top  = y + "px"             ;
            }
            div.setBounds      = function (a,b,c,d){
                div.minX=a;div.minY=b;div.maxX=c;div.maxY=d;
                div.boundEnabled = true;
            }
            div.onmouseout     = function (e){ 

                if(!clickElement) return
                selLay=document.getElementById(clickElement);

                //xyエラー時の類推追跡用xyセット
                x =  recx2+=recxOffset  
                y =  recy2+=recyOffset  
                dofollow(x,y)
                x =  recx2+=recxOffset  
                y =  recy2+=recyOffset  
                setTimeout('"dofollow('+x+','+y+')"',10)

                //follow(e)
                //dbg.innerHTML += getMouseX(e)+"--"+getMouseY(e)+"<br>"
                div.style.zIndex = zcount++
                return false 
            }
            div.onselectstart  = function (e){ return false }
            div.onmouseover    = function (e){ return false }
            div.onmousedown    = function (e)
            {
                div.draging    = true  ;
                div.dragcnt ++         ;
                selLay=div
                clickElement = selLay.id

                //DIVのleft,topからカーソル位置までのオフセットをキャプチャ
                if (selLay){    
                    selLay.offLeft = getMouseX(e) - getLEFT(selLay.id)
                    selLay.offTop  = getMouseY(e) - getTOP(selLay.id)
                
                } 
                return false
            }

        dragableFloatId[div.id] = div.id;//windowへ登録
        div.index++;
        return div;
    }

    //マウス移動時の動作
    document.onmousemove  = function (e)
    {
        recTimeOffset(e) //rec
        follow(e)
        //return false
    }
    
    //マウスアップ時の動作
    document.onmouseup  = function (e)
    {
        if(!clickElement) return
        selLay=document.getElementById(clickElement);
        
        //ドラッグ中なのにはずれちゃった場合
        follow(e)
        
        //ドラッグ中止
        selLay.draging   = false ;
        selLay.style.zIndex = zcount++

        //画面内のオフセットleft,top位置をキャプチャ
        if (selLay){
            var sl = parseInt(canvas.scrollLeft,10)
            var st = parseInt(canvas.scrollTop,10)
            selLay.pageOffLeft = getLEFT(selLay.id)-sl
            selLay.pageOffTop  = getTOP(selLay.id)-st
        }
        return false
    }

    //ドラッグ失敗時の類推追跡
    function follow(e)
    {
        if(!clickElement) return
        selLay=document.getElementById(clickElement);

        //マウス位置取得
        var x = getMouseX(e)
        var y = getMouseY(e)

        //xyエラー時の類推追跡用xyセット
        x = (x == -1)? recx2+=recxOffset : x ;
        y = (y == -1)? recy2+=recyOffset : y ;
        if(x == -1 && y == -1)setTimeout('follow('+e+')',100)

        dofollow(x,y)
    }

    //マウス追跡
    function dofollow(x,y)
    {
        if(!clickElement) return
        selLay=document.getElementById(clickElement);
        if(!chkBounds(selLay)){
          return
        } else {
          if(selLay.draging){
            //オフセットを引いて追随
            movetoX = x - selLay.offLeft
            movetoY = y - selLay.offTop
            selLay.style.left = parseInt(movetoX,10) +"px"
            selLay.style.top  = parseInt(movetoY,10) +"px"
          }
        }
       // window.status = selLay.style.left
    }

    //マウス位置を記録
    function recTimeOffset(e)
    {
        if(x == -1 || y == -1)return 
        recx2= recx1
        recy2= recy1
        recx1= getMouseX(e)
        recy1= getMouseY(e)
        recxOffset= recx1 - recx2
        recyOffset= recy1 - recy2
        
    }
    
    //指定領域内かどうかをチェック
    function chkBounds(oj){

      var layName = oj.id
      if(oj.boundEnabled){
      
        //現在位置取得
        var nowX = getLEFT(layName);
        var nowY = getTOP(layName);
        //チェック
        if( 
          nowX >= oj.minX &&
          nowY >= oj.minY &&
          nowX <= oj.maxX &&
          nowY <= oj.maxY
        ){
          return true //指定領域内ならtrue
        } else {
          returnPOS(nowX,nowY,oj)
          return false
        }
      } else {
        return true
      }
    }

    //領域内へ戻す
    function returnPOS(nowX,nowY,oj){
      if(nowX < oj.minX) oj.style.left = oj.minX +"px"
      if(nowY < oj.minY) oj.style.top  = oj.minY +"px"
      if(nowX > oj.maxX) oj.style.left = oj.maxX +"px"
      if(nowY > oj.maxY) oj.style.top  = oj.maxY +"px"
    }

    //マウスX座標get 
    function getMouseX(e)
    {
        if(document.all)               //e4,e5,e6用
            return canvas.scrollLeft+event.clientX
        else if(document.getElementById)    //n6,n7,m1,o7,s1用
            return e.pageX
    }

    //マウスY座標get 
    function getMouseY(e)
    {
        if(document.all)               //e4,e5,e6用
            return canvas.scrollTop+event.clientY
        else if(document.getElementById)    //n6,n7,m1,o7,s1用
            return e.pageY
    }


    //レイヤ－左辺X座標get 
    function getLEFT(layName){
        //デバック
        //document.getElementById('aaa').innerHTML+=layName+'<BR>'
        
        if(document.all)                    //e4,e5,e6,o6,o7用
            return document.all(layName).style.pixelLeft
        else if(document.getElementById)    //n6,n7,m1,s1用
            return (document.getElementById(layName).style.left!="")
                ?parseInt(document.getElementById(layName).style.left):""
    }

    //レイヤ－上辺Y座標get 
    function getTOP(layName){
        if(document.all)                    //e4,e5,e6,o6,o7用
            return document.all(layName).style.pixelTop
        else if(document.getElementById)    //n6,n7,m1,s1用
            return (document.getElementById(layName).style.top!="")
                    ?parseInt(document.getElementById(layName).style.top):""
    }

    //デバック
    function dbg_echo(){
            ////////dbg.innerHTML += selLay.draging+"<br>"
            
        var debugDIV  = document.createElement("DIV")  ; //DIV要素を生成
        var dbg   = document.body.appendChild(debugDIV);
            dbg.setAttribute("id","dbg")                   ;
            dbg.style.position = "absolute"           ;
            dbg.style.left     =  "400px"             ;
            dbg.style.top      = "0px"             ;
            dbg.innerHTML      = "dbg"                   ;
            return dbg;
    }  //dbg = dbg_echo()


	function db1(e)
	{
		dbg.innerHTML += getMouseX(e)+"-1000-"+getMouseY(e)+"<br>"
	}
	
	
	return this.mkDiv(id) ;

}

