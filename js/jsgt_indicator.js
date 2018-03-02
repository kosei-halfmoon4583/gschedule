function jsgt_Indicator(src){
	this.div=s(src);
	this.indi_append=a;
	this.indi_start=t;
	this.indi_stop=o;this.img=new Image();
	this.img.src=src;
	function s(src){
		id="_indicator"+(new Date()).getTime();
		this.div=document.createElement("DIV");
		with(this.div.style){
			position="relative";
			top="0px";
			left="0px";
			width="0px";
			height="0px";
			margin='0px';
			padding='0px';
		};
		return this.div
	};
	function a(id){
		var d=document.getElementById(id);
		if(typeof d!='object')return;
		d.appendChild(this.div);
	};
	function t(){
		this.div.style.height="12px";
		this.div.style.width="auto";this.div.innerHTML='<img src="'+this.img.src+'">';
	};
	function o(){
		this.div.style.width="0px";
		this.div.style.height="0px";
		this.div.innerHTML='';
	};
	return this
}
