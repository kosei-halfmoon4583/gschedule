<?php
  /*==========================================================================+
   | PHP version 5.6.30                                                       |
   +--------------------------------------------------------------------------+
   | Copyright (C) 2007.12.30 N.watanuki                                      |
   +--------------------------------------------------------------------------+
   | Hotel Search Script                                                      |
   | Script-ID      : hotels.php                                              |
   | DATA-WRITTEN   : 2007.12.30                                              |
   | AUTHER         : N.WATANUKI                                              |
   | UPDATE-WRITTEN : 2011.04.16                                              |
   | UPDATE-WRITTEN : 2018.03.18 Upgrade to a newer version.                  |
   +==========================================================================*/
    $crrentdate = getdate();
    $dyear = $crrentdate["year"];
    $dmonth = $crrentdate["mon"];
    $wdate = date("Y-m-d");
    $header_title = "[ ホテル検索 ]";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />

<title>KOSEIs Hotel Search!</title>

<link rel="stylesheet" type="text/css" href="./resources/css/screen.css" />
<link rel="stylesheet" type="text/css" href="./resources/css/tree.css" />
<script type="text/javascript" src="./js/yahoo-min.js" ></script>
<script type="text/javascript" src="./js/connection-min.js" ></script>
<script type="text/javascript" src="./js/treeview-min.js" ></script>
<script type="text/javascript" src="./js/event-min.js" ></script>
<script type="text/javascript" src="./js/mktreebyarray4.js" ></script>
<script type="text/javascript" src="./js/jsgt_dragfloatfade.js"></script>
<script type="text/javascript" src="./js/jsgt_indicator.js"></script>
<script type="text/javascript" src="./js/downloadxml.js"></script>

<script type="text/javascript" 
    src="http://maps.googleapis.com/maps/api/js?key=AIzaSyD-3UY1BRI6EikMEXmNAwRDXCuE627CQBw">
</script>

</head>
<body>
<?php require_once("header.php"); ?>
<div id="content">
<div id="menu">
</div>
<div id="main">

<div id = "treeDiv1">
    <img src="./resources/images/loading.gif" alt="loading" />
</div> 

<div id = "yui">
    Powered by YUI Library version 2.3
</div>

<div id = "chkbox1">
    <input type="checkbox" id="imgFlg" 
        checked onclick="
            if(!nowarea){
                alert('先にエリアを選択してください')
            } else {
                jalan_getHotels(nowarea)
            }" />
        :Hotel Image
</div>

<div id = "map"></div>
<div id = "indi1"></div>
<div id = "hotel"></div>
<div id = "msg1"> 
<!-- <pre> -->
Schedule Management System Version 2.2.4 
Copyright(C.) 2009  <font color="#FF5500"><a href="mailto:kosei.halfmoon@gmail.com"><u>Naoshi WATANUKI.</u></a></font>
<!-- </pre> -->
</div>

<script type = "text/javascript">
//<![CDATA[

  var treeDivId = "treeDiv1";
  //var mapDivId  = "map";
  var areaURL   = "http://localhost/gschedule/area-013000.xml";
  var iniLatLng = [38.16911413556086, 138.33984375];
  var centerY,centerX,zm,nowarea;

  var wkOj;
  var test1;
  var div1;
  var h_Oj=[];
  var hotelsOj=function (){}
      hotelsOj.prototype.h_name = "";
      hotelsOj.prototype.h_id = "";
      hotelsOj.prototype.h_x = "";
      hotelsOj.prototype.h_y = "";
      hotelsOj.prototype.h_la = "";
      hotelsOj.prototype.h_sa = "";
      hotelsOj.prototype.h_ph = "";
      hotelsOj.prototype.h_catch = "";
      hotelsOj.prototype.h_url = "";

  function mk_hotelsOj(h_id,hotelDom){

      var tmp_h_Oj=[];
      tmp_h_Oj[h_id] = new hotelsOj();
      tmp_h_Oj[h_id].h_name  = getHv('HotelName',hotelDom); //Hotel Name.
      tmp_h_Oj[h_id].h_x     = getHv('X',hotelDom);         //経度 Longitude.
      tmp_h_Oj[h_id].h_y     = getHv('Y',hotelDom);         //緯度 Latitude.
      tmp_h_Oj[h_id].h_la    = getHv('LargeArea',hotelDom); //大エリア
      tmp_h_Oj[h_id].h_sa    = getHv('SmallArea',hotelDom); //小エリア
      if(hotelDom.getElementsByTagName('PictureURL')[0].firstChild!=null)
            tmp_h_Oj[h_id].h_ph  = getHv('PictureURL',hotelDom);
      else  tmp_h_Oj[h_id].h_ph  = "./resources/images/kouzi2_i.gif";
      //wkOj.preLoad(h_id); 
    //wkOj.hotelImg[h_id].src;

      tmp_h_Oj[h_id].h_catch = getHv('HotelCatchCopy',hotelDom);
      tmp_h_Oj[h_id].h_url = getHv('HotelDetailURL',hotelDom);

      return tmp_h_Oj[h_id];
  }
  
  function getHv(nodeName,dom){
      return dom.getElementsByTagName(nodeName)[0].firstChild.nodeValue;
  }

  function tmp_msg(h_id){  
      var img = '<img src="'+wkOj.hotelImg[h_id].src+'" '
              + ' style="height:'+wkOj.hotelImgHeight[h_id]+'px;margin:0px;padding:0px;padding-right:12px;border:0px;" align="left" />';
      var catchCopy = ""+h_Oj[h_id].h_catch+"";
      var hotelURL ='<br />| <a href="'+h_Oj[h_id].h_url+'" target="hotel">詳細ページ</a> |';
      var imgzm =' <a href="javascript:wkOj.chgHotelImgHeight('+h_id+',180);">画像拡大</a> |';
      var reset =' <a href="javascript:wkOj.chgHotelImgHeight('+h_id+',60);">画像サイズ戻す</a> |';
      var htm ='<div style="width:210px">'
              + '<div style="font-weight:900"><nobr>'
              +  h_Oj[h_id].h_name
              +  '</nobr>'
              + (($('imgFlg').checked)?img:'')
              + '<div style="font-weight:100">'
              + (($('imgFlg').checked&&wkOj.hotelImgHeight[h_id]>60)?'<br  clear="all" \/>':'')
              + ((h_Oj[h_id].h_catch)?catchCopy:'')
              + '<br  clear="all" \/>'
              + '<b>経度 : <\/b>'+ (""+h_Oj[h_id].h_x).substr(0,8) + ' '
              + '<b>緯度 : <\/b>'+ (""+h_Oj[h_id].h_y).substr(0,8) + ' '
              + hotelURL
              + (($('imgFlg').checked&&wkOj.hotelImgHeight[h_id]>60)?reset:imgzm)
              + '<\/div>'
              + '<br>'
              + '<\/div>';
              + '<\/div>';
       return htm
  }
  
  function tmp_link(h_id){ 
      var msg = '【'+h_Oj[h_id].h_la+'】'+h_Oj[h_id].h_sa+'<br \/>';//msg=msg.split('"').join("\\'");
      var contents = msg + tmp_msg(h_id).split('"').join("\\'");
      var href  = "javascript:wkOj.openInfoWinByClick('"+h_id+"',\'"+msg + tmp_msg(h_id).split('"').join("\\'")+"\',"+2+")";
      var mover = "javascript:wkOj.openInfoWinByMover('" + h_id + "',\'" + contents + "\')";
      return '' 
            + '【'+h_Oj[h_id].h_la+'】'
            + '<a href="'+href+'" onmouseover="'+mover+'">'+h_Oj[h_id].h_name+'<\/a> '
            + '[<a href="javascript:'+mover+';map.setZoom(map.getZoom() + 1);">+<\/a>]'
            + '[<a href="javascript:'+mover+';map.setZoom(map.getZoom() - 1);">-<\/a>]'
            + '[<a href="javascript:'+mover+';map.setMapTypeId(google.maps.MapTypeId.SATELLITE)">衛星<\/a>]'
            + '[<a href="javascript:'+mover+';map.setMapTypeId(google.maps.MapTypeId.ROADMAP)">地図<\/a>]'
            + '<br \/>'
            + '';
  }

  function templateForMakeTreeATagAttr(tmpNode,data){

      var a   = data[0];
      var b   = data[1];
      var c   = data[2];
      var d   = data[3];
      var oj={ 
          label : a,
          href  : 'java'+'script:jalan_getHotels(\''+d+'\',\''+d+'\',\''+d+'\')'
  }

      return YAHOO.tato.e(tmpNode,oj);
  }

  function areaXML2areaJSON(oj){
       var xml  = oj.responseXML;
       var json = '';
       var pref = xml.getElementsByTagName('Prefecture');
     
       json ='[\n';
       json +='  ["エリア（23区）を選択して下さい",\n';
       json +='    [\n';
       json +='      ["_open"],\n';
       for(var i=0;i<pref.length;i++){
           var p_comma = (pref.length-1!=i)?',':'';
           var p_code  = pref[i].getAttribute('cd');
           var p_name  = pref[i].getAttribute('name');
           json +='      ["'+p_name+'",\n';
           json +='        [\n';
           var l_area = pref[i].getElementsByTagName('LargeArea');
           json +='          ["_open"],\n';
           for(var j=0;j<l_area.length;j++){
               var l_comma = (l_area.length-1!=j)?',':'';
               var l_comma = (l_area.length-1!=j)?',':'';
               var l_code  = l_area[j].getAttribute('cd');
               var l_name  = l_area[j].getAttribute('name');
               json +='          ["'+l_name+'",\n';
               var s_area = l_area[j].getElementsByTagName('SmallArea');
               json +='            [\n';
               for(var k=0; k<s_area.length; k++){
                       var s_comma = (s_area.length-1!=k)?',':'';
                       var s_code  = s_area[k].getAttribute('cd');
                       var s_name  = s_area[k].getAttribute('name');
                       json +='            ["'+s_name+'","'+p_code+'","'+l_code+'","'+s_code+'"]'+s_comma+'\n';
                   }
                   json +='            ]\n';
                   json +='          ]'+l_comma+'\n';
               }
               json +='        ]\n';
               json +='      ]'+p_comma+'\n';
           }
           json +='    ]\n';
           json +='  ]\n';
           json +=']\n';
 
       return eval(""+json)
  }

  //var jalanHotelSearchURL = "http://kosei-halfmoon.dyndns-ip.com/gs/getHotel.php";
  var jalanHotelSearchURL = "./getHotel.php";
  var jalan_getHotels = function(s_area){
      indi.indi_append("indi1");
      indi.indi_start();
      nowarea = s_area;
      url=jalanHotelSearchURL+'?s_area='+s_area;
      loadFile(url,on_loadedHotelXML);
  }

  function on_loadedHotelXML(oj){ put2Map(oj) }

  function put2Map(oj){
      var xml=oj.responseXML;
          window.status+="*";
      var hotels = xml.getElementsByTagName('Hotel');
          hotel_links = '' ; zm =17;



          var mimpoint_x,minpoint_y,maxpoint_x,maxpoint_y;
      for(var i=0;i<hotels.length;i++){

          window.status+="|";

        //XMLからホテルIDを取り出し、その名前でインスタンスを生成する
          var  h_id  = hotels[i].getElementsByTagName('HotelID')[0].firstChild.nodeValue;
          h_Oj[h_id] = mk_hotelsOj(h_id,hotels[i]);

          h_Oj[h_id].h_x=chgUnit(h_Oj[h_id].h_x);
          h_Oj[h_id].h_y=chgUnit(h_Oj[h_id].h_y);


          mimpoint_x = (mimpoint_x)?(Math.min(mimpoint_x,h_Oj[h_id].h_x)):h_Oj[h_id].h_x;
          minpoint_y = (minpoint_y)?(Math.min(minpoint_y,h_Oj[h_id].h_y)):h_Oj[h_id].h_y;

          maxpoint_x = (maxpoint_x)?(Math.max(maxpoint_x,h_Oj[h_id].h_x)):h_Oj[h_id].h_x;
          maxpoint_y = (maxpoint_y)?(Math.max(maxpoint_y,h_Oj[h_id].h_y)):h_Oj[h_id].h_y;

          wkOj.preLoad(h_id);
          wkOj.setHotelImgHeight(h_id,60);
          var msg  ='';tmp_msg(h_id);
          hotel_links += tmp_link(h_id);
          wkOj.setMarkerToMap(h_id);
      }


      var minpoint = new GLatLng_tky( minpoint_y,mimpoint_x);
      var maxpoint = new GLatLng_tky( maxpoint_y,maxpoint_x);
      var bounds = new google.maps.LatLngBounds(minpoint,maxpoint);
      map.fitBounds(bounds);

      show_fade({data:hotel_links});
  }

  function chgUnit(ms){
      return ms/3600000;
  }

 /* Directory(Tree)初期化: area-013000.xmlをセット */
  YAHOO.tato.treeIni = function(){
      YAHOO.widget.TreeView.preload();
      test1 = new YAHOO.tato.tree(treeDivId); 
      loadFile(areaURL,on_loadedXML);

  }
  YAHOO.tato.treeIni();


  function loadFile(url, callbackFunc) {

    var status = -1;
    var time = new Date();

    var request=false;
    if(typeof ActiveXObject!="undefined"){ /* IE5, IE6 */
        try {
            request = new ActiveXObject("Msxml2.XMLHTTP"); /* MSXML3 */
        }
        catch(e){
            request = new ActiveXObject("Microsoft.XMLHTTP"); /* MSXML2 */
        }
    }
    if(!request && typeof XMLHttpRequest != "undefined"){
        request = new XMLHttpRequest(); /* Firefox, Safari, IE7 */
    }

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            callbackFunc(request, request.status);
        }
    }
      request.open("POST",url,true);
      request.setRequestHeader("If-Modified-Since", time.toUTCString());
      request.send(null);

  };


  function on_loadedJSON(oj) {
      var res  =  oj.responseText;
      eval("res ="+res);
      wkOj = new wksByData(res,$(treeDivId));
      wkOj.addTrees();
  }

  function on_loadedXML(oj) {
      var json = XML2JSON(oj);
      wkOj = new wksByData(json,$(treeDivId));
      wkOj.addTrees();
      json = null;
  }

  function XML2JSON(oj) {
      if(areaXML2areaJSON)return areaXML2areaJSON(oj);
  }

  function wksByData(jsonData,oj){
  
      return {
          hotelMarkers : [],
          hotelImg : [],
          hotelImgHeight : [],
          addTrees : function(){test1.mkTreeByArray(jsonData); },
          showToMap : function(lon,lat,msg){
              //map.setCenter(new GLatLng(lat,lon), 17);
              //map.setCenter(new google.maps.LatLng(lat,lon), 17);
              //map.openInfoWindowHtml(map.getCenter(),msg);
              google.maps.InfoWindow({content: msg});
          },
      
      setMarkerToMap : function(h_id){
              var point  = new GPoint_tky(h_Oj[h_id].h_x,h_Oj[h_id].h_y);
              var myLatlng = new google.maps.LatLng(point.y,point.x);
              var gmarker = new google.maps.Marker({
                              position: myLatlng,
                            });
              gmarker.setMap(map);
      },
      
      openInfoWinByClick : function(h_id,msg,zm){
        var point  = new GPoint_tky(h_Oj[h_id].h_x,h_Oj[h_id].h_y);
        var myLatlng = new google.maps.LatLng(point.y,point.x);
          var iwopts = {
              content: msg,
              position: myLatlng
          };

          var infoWindow = new google.maps.InfoWindow(iwopts);

          infoWindow.open(map);

          if(zm) map.setZoom(map.getZoom() + zm);
      },
      
      openInfoWinByMover : function(h_id,msg){
                               
        var point  = new GPoint_tky(h_Oj[h_id].h_x,h_Oj[h_id].h_y);
        var myLatlng = new google.maps.LatLng(point.y,point.x);
        var iwopts = {
            content: msg,
            position: myLatlng
        };

        var infoWindow = new google.maps.InfoWindow(iwopts);

        infoWindow.open(map);
      },
      
      preLoad : function(h_id){
          if($('imgFlg').checked){
              this.hotelImg[h_id] = new Image();
              this.hotelImg[h_id].src = h_Oj[h_id].h_ph;
          } else {
              this.hotelImg[h_id] = '';
          }
      },
      
      chgHotelImgHeight:function(h_id,height){
          if(height)this.setHotelImgHeight(h_id,height);
          var msg  =tmp_msg(h_id);
          var point  = new GPoint_tky(h_Oj[h_id].h_x,h_Oj[h_id].h_y);
          var myLatlng = new google.maps.LatLng(point.y,point.x);
          var iwopts = {
              content: msg,
              position: myLatlng
          };

          var infoWindow = new google.maps.InfoWindow(iwopts);

          infoWindow.open(map);
      },

      setHotelImgHeight:function(h_id,height){
          this.hotelImgHeight[h_id]=height;
      },
      
      reZoom : function (bounds){
          var nowBnd = map.getBounds();
          map.setCenter(new GLatLng_tky(centerY,centerX),zm);
          zm = map.getZoom();

          var minY = nowBnd.getSouthWest().lat();
          var minX = nowBnd.getSouthWest().lng();
          var maxY = nowBnd.getNorthEast().lat();
          var maxX = nowBnd.getNorthEast().lng();
   //delete 
          alert( minX +":"+ bounds.minX +"="+(minX-bounds.minX)+(minX < bounds.minX)+"\n"
              + minY +":"+ bounds.minY +"="+(minY-bounds.minY)+(minY < bounds.minY)+"\n"
              + maxX +":"+ bounds.maxX +"="+(maxX-bounds.maxX)+(maxX > bounds.maxX)+"\n"
              + maxY +":"+ bounds.maxY +"="+(maxY-bounds.maxY)+(maxY > bounds.maxY))
           
          var inn = (
              minX < bounds.minX &&
              minY < bounds.minY &&
              maxX > bounds.maxX &&
              maxY > bounds.maxY )
          
          if(inn||zm<5){
              map.setCenter(new GLatLng_tky(centerY,centerX),zm);
          } else {
             window.status+="||";
             map.setZoom(zm--);
             this.reZoom(bounds);
          }
       }
     }
  }

  //var map = new GMap2($(mapDivId));

  var latlng = new google.maps.LatLng(iniLatLng[0], iniLatLng[1]);
  var opts = {
      zoom: 5,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      scaleControl: true
  };
  var map = new google.maps.Map(document.getElementById("map"), opts);

  
/*
  map.addControl(
      new GLargeMapControl(),
      new GControlPosition(G_ANCHOR_BOTTOM_RIGHT, new GSize(5,160))
  );
   
  map.addControl(new GScaleControl());

  map.addControl(new GOverviewMapControl(new GSize(200,150)));
*/
  GLatLng_tky = function (la,ln){
      var lat = la - la * 0.00010695  + ln * 0.000017464 + 0.0046017;
      var lng = ln - la * 0.000046038 - ln * 0.000083043 + 0.010040;
      //return new GLatLng(lat,lng);
      return new google.maps.LatLng(lat,lng);
  }
 
  GPoint_tky = function (a,b){
      this.y = b - b * 0.00010695  + a * 0.000017464 + 0.0046017;
      this.x = a - b * 0.000046038 - a * 0.000083043 + 0.010040;
  }
  map.setCenter(new GLatLng_tky(iniLatLng[0],iniLatLng[1]), 5);
  setDragableFloat("output",120,360) ;
  div1.style.zIndex=100;
  
  function show_fade(oj) {
      window.status+="|";
      div1.moveTo(120,300);
      div1.innerHTML='<img src="./resources/images/loading.gif">';
      div1.style.backgroundColor ="#B2D6FF";
      div1.style.border = "2px outset #333366";
      div1.style.padding ="18px";
      div1.style.paddingTop ="8px";
      div1.style.display="block";
      var bar=''
          +'<a href="javascript:hide_fade()" style="text-decoration:none">'
          +'<span  style="color:#000066;font-size:12px;font-weight:900">'
          +'[Clear] '
          +'</span>'
          +'</a>'
          +'<span  style="color:#000066;font-size:12px;font-weight:900">'
          +'この地域のホテル情報です！'
          +'</span>'
          +'<font color="#000066">'
              + '[<a href="javascript:map.setZoom(map.getZoom() + 1);">+<\/a>]'
              + '[<a href="javascript:map.setZoom(map.getZoom() - 1);">-<\/a>]'
              + '[<a href="javascript:map.setMapTypeId(google.maps.MapTypeId.SATELLITE)">衛星<\/a>]'
              + '[<a href="javascript:map.setMapTypeId(google.maps.MapTypeId.ROADMAP)">地図<\/a>]'
              +'</font>'
              +'<br />'
              +'*このペインはドラッグできます' 
              +'<br />'
           
      window.status+="|";
       
      div1.innerHTML=bar+oj.data+'<br />'+'<span style="position:absolute;right:8px;color:#000066;font-size:11px">It is Drag able DIV Tag.</span>'; 
      fadeOpacity('output',1,0.8);
      indi.indi_stop();
      window.status="";
  }
  function hide_fade() {
      fadeOpacity('output',0.8,0);
  }

  var indi = new jsgt_Indicator('./resources/images/pleasewait.gif') ;

//]]>
</script>
</div>
</div>
</body>
</html>
