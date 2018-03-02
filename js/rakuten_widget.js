//#######################################################
//## Rakuten Widget                                    ##
//##                                                   ##
//## Copyright 2009 Rakuten, Inc. All rights reserved. ##
//##    v1.0                                           ##
//#######################################################

//--- browser Check
var ffOption ='false';
  if(checkBrowser() == "Firefox"){
    ffOption = "true";
  }

//--- recommend api
var rapi = 'on';

var rakuten_ver;
var rakuten_size;
var formatPointbackId = "_RTmtlk20000";

var rakuten_pointbackId;
var itemNumber;
var sizeNumber;
var previewTag = '';
var rakutenPreviewTag = '';
if(typeof rakuten_preview != "undefined" && "true" == rakuten_preview){
    previewTag = '&preview=true';
    rakutenPreviewTag = '&rakuten_preview=true';
}

    if(rakuten_items == "ashiato" && rakuten_rlogin == "on"){
        itemNumber = "3";
    } else if(rakuten_items == "ashiato" && rakuten_rlogin == "off" ){
        itemNumber = "4";
    } else {
        itemNumber = itemMap()(rakuten_items);
    }

//--- Design & Size Check
    if(rakuten_design == "slide"){
        sizeNumber = slideSizeMap()(rakuten_size);
        switch (rakuten_size){
            case '120x170':
                swf_width  = 120;
                swf_height = 170;
                break;
            case '120x240':
                swf_width  = 120;
                swf_height = 240;
                break;
            case '148x300':
                swf_width  = 148;
                swf_height = 300;
                break;
            case '148x600':
                swf_width  = 148;
                swf_height = 600;
                break;
            case '200x350':
                swf_width  = 200;
                swf_height = 350;
                break;
            case '200x600':
                swf_width  = 200;
                swf_height = 600;
                break;
            case '300x160':
                swf_width  = 300;
                swf_height = 160;
                break;
            case '300x250':
                swf_width  = 300;
                swf_height = 250;
                break;
            case '468x160':
                swf_width  = 468;
                swf_height = 160;
                break;
            case '450x160':
                swf_width  = 450;
                swf_height = 160;
                break;
            case '600x200':
                swf_width  = 600;
                swf_height = 200;
                break;
            case '728x200':
                swf_width  = 728;
                swf_height = 200;
                break;
            case '250x250':
                swf_width  = 250;
                swf_height = 250;
                break;
            case '800x180':
                swf_width  = 800;
                swf_height = 180;
                break;
            default :
                //default
                rakuten_design = 'slide';
                rakuten_size   = '120x240';
                swf_width  = 120;
                swf_height = 240;
                break;
        }
    }else if(rakuten_design == "circle"){
        sizeNumber = circleSizeMap()(rakuten_size);
        switch (rakuten_size){
            case '120x300':
                swf_width  = 120;
                swf_height = 300;
                break;
            case '148x500':
                swf_width  = 148;
                swf_height = 500;
                break;
            case '200x600':
                swf_width  = 200;
                swf_height = 600;
                break;
            case '300x160':
                swf_width  = 300;
                swf_height = 160;
                break;
            case '300x250':
                swf_width  = 300;
                swf_height = 250;
                break;
            case '468x160':
                swf_width  = 468;
                swf_height = 160;
                break;
            case '600x200':
                swf_width  = 600;
                swf_height = 200;
                break;
            case '728x200':
                swf_width  = 728;
                swf_height = 200;
                break;
            case '250x250':
                swf_width  = 250;
                swf_height = 250;
                break;
            case '800x180':
                swf_width  = 800;
                swf_height = 180;
                break;
            default :
                //default
                rakuten_design = 'slide';
                rakuten_size   = '120x240';
                swf_width  = 120;
                swf_height = 240;
                break;
        }
    }else{
        //default
        rakuten_design = 'slide';
        rakuten_size   = '120x240';
        swf_width  = 120;
        swf_height = 240;
        sizeNumber = slideSizeMap()(rakuten_size);
    }

    var pointbackId;
    if((typeof rakuten_pointbackId == "undefined") || (rakuten_pointbackId == "")){
        pointbackId = formatPointbackId + itemNumber + sizeNumber;
    }else {
        if(rakuten_pointbackId == "undefined"){
            pointbackId = formatPointbackId + itemNumber + sizeNumber;
        }else {
            pointbackId = rakuten_pointbackId;
        }
    }

    if(typeof rakuten_no_link === "undefined"){
        var rakuten_no_link = 'off';
    }
    if(typeof rakuten_no_afl === "undefined"){
        var rakuten_no_afl = 'off';
    }
    if(typeof rakuten_no_logo === "undefined"){
        var rakuten_no_logo = 'off';
    }
    if(typeof rakuten_undispGenre === "undefined"){
        var rakuten_undispGenre = 'off';
    }
    if(typeof rakuten_items_sub === "undefined"){
        var rakuten_items_sub = '';
    }

    swf_width  = swf_width  -2;
    swf_height = swf_height -2;

    if(rakuten_design == "circle"
        && !isFlashPlayerVer10()){
        document.write('<a href="http://get.adobe.com/jp/flashplayer/"><img src="http://www.adobe.com/images/shared/download_buttons/get_adobe_flash_player.png"></a><img src="//xml.affiliate.rakuten.co.jp/widget/img/f.gif">');
    }else if(typeof rakuten_recommend != "undefined"
        && rakuten_recommend == "on") {
        // recommend(view history)
        iframe_width    = swf_width  + 2;
        iframe_height   = swf_height + 2;
        document.write('<iframe width="'    + iframe_width  + '"'
                        + ' height="'       + iframe_height + '"'
                        + ' frameBorder="0"'
                        + ' scrolling="no"'
                        + ' marginheight="0"'
                        + ' marginwidth="0"'
                        + ' allowtransparency="true"'
                        + ' src="//xml.affiliate.rakuten.co.jp/widget/recommend/index.php'
                        + '?rakuten_design='       + rakuten_design
                        + '&rakuten_affiliateId='  + rakuten_affiliateId
                        + '&rakuten_items='        + rakuten_items
                        + '&rakuten_items_sub='    + rakuten_items_sub
                        + '&rakuten_genreId='      + rakuten_genreId
                        + '&rakuten_size='         + rakuten_size
                        + '&rakuten_target='       + rakuten_target
                        + '&rakuten_theme='        + rakuten_theme
                        + '&rakuten_border='       + rakuten_border
                        + '&rakuten_auto_mode='    + rakuten_auto_mode
                        + '&rakuten_genre_title='  + rakuten_genre_title
                        + '&rakuten_pointbackId='  + rakuten_pointbackId
                        + '&rakuten_no_link='      + rakuten_no_link
                        + '&rakuten_no_afl='       + rakuten_no_afl
                        + '&rakuten_no_logo='      + rakuten_no_logo
                        + '&rakuten_undispGenre='  + rakuten_undispGenre
                        + rakutenPreviewTag
                        + '">'
                        + '</iframe>'
                        );
    }else{

        if(rakuten_border == "on"){
            document.write('<div style="border:1px solid black;width:'+ swf_width + 'px;">');
        }else{
            document.write('<div>');
        }

        if(typeof rakuten_rlogin === "undefined"){
            var rakuten_rlogin = 'none';
        }

        if(rakuten_items != "ranking") {
            rakuten_genre_title = "on";
        }

        //Auto Install
        document.write('<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" '
                        + 'codebase="https://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab" '
                        + 'id="externalfi1" align="" allowscriptaccess="always" '
                        + 'width="'  + swf_width  + '" '
                        + 'height="' + swf_height + '" '
                        + '>'
                        );
        document.write('<param name="movie" '
                            +'value="//xml.affiliate.rakuten.co.jp/widget/swf/new_' + rakuten_design + '_' + rakuten_size + '.swf?'
                            + 'item='           + rakuten_items
                            + '&item_sub='      + rakuten_items_sub
                            + '&genreId='       + rakuten_genreId
                            + '&affiliateId='   + rakuten_affiliateId
                            + '&target='        + rakuten_target
                            + '&theme='         + rakuten_theme
                            + '&auto='          + rakuten_auto_mode
                            + '&title='         + rakuten_genre_title
                            + '&ff='            + ffOption
                            + '&rapi='          + rapi
                            + '&rlogin='        + rakuten_rlogin
                            + '&pointbackId='   + pointbackId
                            + '&noLink='        + rakuten_no_link
                            + '&noAffiliate='   + rakuten_no_afl
                            + '&noLogo='        + rakuten_no_logo
                            + '&undispGenre='   + rakuten_undispGenre
                            + '&design='        + rakuten_design
                            + '&size='          + rakuten_size
                            + '&version=20110310'
                            + previewTag
                            + '">');
        document.write('<param name="allowscriptaccess" value="always">');

        document.write('<embed src="//xml.affiliate.rakuten.co.jp/widget/swf/new_' + rakuten_design + '_' + rakuten_size + '.swf?'
                            + 'item='           + rakuten_items
                            + '&item_sub='      + rakuten_items_sub
                            + '&genreId='       + rakuten_genreId
                            + '&affiliateId='   + rakuten_affiliateId
                            + '&target='        + rakuten_target
                            + '&theme='         + rakuten_theme
                            + '&auto='          + rakuten_auto_mode
                            + '&title='         + rakuten_genre_title
                            + '&ff='            + ffOption
                            + '&rapi='          + rapi
                            + '&rlogin='        + rakuten_rlogin
                            + '&pointbackId='   + pointbackId
                            + '&noLink='        + rakuten_no_link
                            + '&noAffiliate='   + rakuten_no_afl
                            + '&noLogo='        + rakuten_no_logo
                            + '&undispGenre='   + rakuten_undispGenre
                            + '&version=20110310'
                            + previewTag
                            + '" '
                        + 'width="'  + swf_width  + '" '
                        + 'height="' + swf_height + '" '
                        + 'allowscriptaccess="always" name="externalfi1" align="" '
                        + 'type="application/x-shockwave-flash" pluginspage="https://www.macromedia.com/go/getflashplayer" '
                        + '></embed>'
                        );

        document.write('</object>');
        document.write('</div>');
    }
    rakuten_pointbackId='';

function checkBrowser(){
  var agent = navigator.userAgent;
  if(agent.indexOf('MSIE') != -1){
    return "IE";
  }else if(agent.indexOf('Safari') != -1){
    return "Safari";
  }else if(agent.indexOf('Firefox') != -1){
    return "Firefox";
  }else{
    return "other";
  }
}

function itemMap() {
    var innerfunction = (function(){
        var mapping = {'ranking': '0','ctsmatch': '1','ashiato': '4'};
        return function(code) {
            return (typeof mapping[code] != "undefined")? mapping[code] : '';
        };
        })();
    return innerfunction;
}

function slideSizeMap() {
    var innerfunction = (function(){
        var mapping = {'468x160': '00','600x200': '10','728x200': '20','120x240': '30','148x300': '40','200x350': '50','148x600': '60','200x600': '70','450x160': '80','300x160':'90','300x250':'02', '120x170':'12'};
        return function(code) {
            return (typeof mapping[code] != "undefined")? mapping[code] : '';
        };
        })();
    return innerfunction;
}

function circleSizeMap() {
    var innerfunction = (function(){
        var mapping = {'468x160': '01','600x200': '11','728x200': '21','120x300': '31','148x500': '41','200x600': '51','300x160':'61','300x250':'71'};
        return function(code) {
            return (typeof mapping[code] != "undefined")? mapping[code] : '';
        };
        })();
    return innerfunction;
}

//flash player version check
function isFlashPlayerVer10(){
    if(checkBrowser() == "IE"){
        // for IE
        try{
            // flash player install check
            var aox = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.10");
        }catch(e){
            return false;
        }
        return true;
    }else{
        // for not IE
        var plugin = navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin;
        if(plugin){
            var f_ver = parseInt(plugin.description.match(/\d+\.\d+/));
            if(f_ver == 10) {
                return true;
            }
        }
        return false;
    }
}
