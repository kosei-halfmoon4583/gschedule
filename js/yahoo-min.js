/* Copyright (c) 2006, Yahoo! Inc. All rights reserved.
   Code licensed under the BSD License: http://developer.yahoo.net/yui/license.txt
   version: 0.10.0 */ 
var YAHOO=window.YAHOO||{};
YAHOO.namespace=function(_1) {
    if(!_1||!_1.length){
        return null;
    }
    var _2=_1.split(".");
    var _3=YAHOO;
    for(var i=(_2[0]=="YAHOO")?1:0;i<_2.length;++i){
		_3[_2[i]]=_3[_2[i]]||{};
		_3=_3[_2[i]];
	}return _3;
};
YAHOO.log=function(_5,_6){
	if(YAHOO.widget.Logger){
		YAHOO.widget.Logger.log(null,_5,_6);
	}else{
		return false;
	}
};
YAHOO.namespace("util");
YAHOO.namespace("widget");
YAHOO.namespace("example");
