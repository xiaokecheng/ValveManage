//editable vars
var goalAmount = 100;//how much are you trying to get
//var currentAmount = 27.5;//how much do you currently have (if you want to define in js, not html)
var valve_lastAmount =0;
var indoor_lastAmount =0;
var animationTime = 1000;//in milliseconds
var numberPrefix = "";//what comes before the number (set to "" if no prefix)  
var numberSuffix = "℃";//what goes after the number
var tickMarkSegementCount = 4;//each segement adds 40px to the height 0到100℃共分为4段，每段高40px
var widthOfNumbers = 30;//the width in px of the numbers on the left  左边数字的宽度（以px为单位）
var thermometercount = 0;  //创建的温度计的个数

//standard resolution images  标准分辨率 图像
var glassTopImg = "images/glassTop.png";          //温度计顶部
var glassBodyImg = "images/glassBody.png";        //温度计中间部分
var redVerticalImg = "images/redVertical.png";    //红色水银条
var tooltipFGImg = "images/tickShine.png";        //刻度条
var glassBottomImg = "images/glassBottom.png";    //温度计底部弧形部分
var tootipPointImg = "images/tooltipPoint.png";     //左
var tooltipMiddleImg = "images/tooltipMiddle.png";  //中
var tooltipButtImg = "images/tooltipButt.png";       //右

//high res images   2倍分辨率图像
var glassTopImg2x = "images/glassTop2x.png";
var glassBodyImg2x = "images/glassBody2x.png";
var redVerticalImg2x = "images/redVertical2x.png";
var tooltipFGImg2x = "images/tickShine2x.png";
var glassBottomImg2x = "images/glassBottom2x.png";
var tootipPointImg2x = "images/tooltipPoint2x.png";
var tooltipMiddleImg2x = "images/tooltipMiddle2x.png";
var tooltipButtImg2x = "images/tooltipButt2x.png";

/////////////////////////////////////////
// ------ don't edit below here ------ //
/////////////////////////////////////////

var arrayOfImages;
var imgsLoaded = 0;
var tickHeight = 40;               //刻度每大段高40px
var mercuryHeightEmpty = 0;        //水银
var numberStartY = 26;            
var thermTopHeight = 13;          //温度计顶部图片高度
var thermBottomHeight = 51;        //温度计低部图片高度
var tooltipOffset = 15;            //提示控件垂直偏移
var heightOfBody;                   //温度计体高
var valve_mercuryId;
var valve_tooltipId;
var indoor_mercuryId;
var indoor_tooltipId;
var resolution2x = false;            //是否开启高像素

//start once the page is loaded
$( document ).ready(function() {
	//仅用作测试
	$(".btn1").click(function(){
	valve_currentAmount = 93.6;
	indoor_currentAmount = 22.4;
   animateThermometer(indoor_currentAmount,indoor_mercuryId,indoor_tooltipId);
   animateThermometer(valve_currentAmount,valve_mercuryId,valve_tooltipId);
   
    $(".btn2").unbind('click').bind('click',function(){
   valve_currentAmount = 22.4;
   indoor_currentAmount = 93.6;
   animateThermometer(indoor_currentAmount,indoor_mercuryId,indoor_tooltipId);
   animateThermometer(valve_currentAmount,valve_mercuryId,valve_tooltipId);
  });
   
  });
	determineImageSet();
});

//this checks if it's the high or normal resolution images  是否是
function determineImageSet(){
	
	resolution2x = window.devicePixelRatio == 2;//check if resolution2x
	
	if(resolution2x){	
		//switch the regular for 2x res graphics
		glassTopImg = glassTopImg2x;
		glassBodyImg = glassBodyImg2x;
		redVerticalImg = redVerticalImg2x;
		glassBottomImg = glassBottomImg2x;
		tootipPointImg = tootipPointImg2x;
		tooltipButtImg = tooltipButtImg2x;	
	}
	
	createGraphics();
}

//visually create the thermometer
function createGraphics(){
	
	//add the html
	$(".goal-thermometer").html(
		"<div class='therm-numbers'>" + 
		"</div>" + 
		"<div class='therm-graphics'>" + 
			"<img class='therm-top' src='"+glassTopImg+"'></img>" + 
			"<img class='therm-body-bg' src='"+glassBodyImg+"' ></img>" + 
			"<img class='therm-body-mercury' src='"+redVerticalImg+"'></img>" + 
			"<div class='therm-body-fore'></div>" + 
			"<img class='therm-bottom' src='"+glassBottomImg+"'></img>" + 
			"<div class='therm-tooltip'>" + 
				"<img class='tip-left' src='"+tootipPointImg+"'></img>" + 
				"<div class='tip-middle'><p>0℃</p></div>" + 
				"<img class='tip-right' src='"+tooltipButtImg+"'></img>" + 
			"</div>" + 
		"</div>"
	);
	
	//preload and add the background images
	//刻度作为前景添加
	$('<img/>').attr('src', tooltipFGImg).load(function(){
		$(this).remove();
		$(".therm-body-fore").css("background-image", "url('"+tooltipFGImg+"')");
		checkIfAllImagesLoaded();
	});
	
	$('<img/>').attr('src', tooltipMiddleImg).load(function(){
		$(this).remove();
		$(".therm-tooltip .tip-middle").css("background-image", "url('" + tooltipMiddleImg + "')");
		checkIfAllImagesLoaded();
	});
	
	//adjust the css
	heightOfBody = tickMarkSegementCount * tickHeight;       //160px
	$(".therm-graphics").css("left", widthOfNumbers);
	$(".therm-body-bg").css("height", heightOfBody);
	$(".goal-thermometer").css("height",  heightOfBody + thermTopHeight + thermBottomHeight);    //160+13+51 = 224
	$(".therm-body-fore").css("height", heightOfBody);                  //刻度高度即为温度计体高
	
	$(".therm-bottom").css("top", heightOfBody + thermTopHeight);       
	valve_mercuryId = $("#valve-thermometer .therm-body-mercury");              //动态水银块
	valve_mercuryId.css("top", heightOfBody + thermTopHeight);                //动态水银块初始顶部
	valve_tooltipId = $("#valve-thermometer .therm-tooltip");
	valve_tooltipId.css("top", heightOfBody + thermTopHeight - tooltipOffset); //提示控件的初始顶部
	
	indoor_mercuryId = $("#indoor-thermometer .therm-body-mercury");             //动态水银块
	indoor_mercuryId.css("top", heightOfBody + thermTopHeight);                //动态水银块初始顶部
	indoor_tooltipId = $("#indoor-thermometer .therm-tooltip");
	indoor_tooltipId.css("top", heightOfBody + thermTopHeight - tooltipOffset); //提示控件的初始顶部
	
	//add the numbers to the left
	var numbersDiv = $(".therm-numbers");
	var countPerTick = goalAmount/tickMarkSegementCount;               //每一段数，100/4=25
	var commaSepCountPerTick = commaSeparateNumber(countPerTick);      
	
	//add the number
	for ( var i = 0; i < tickMarkSegementCount; i++ ) {
		
		var yPos = tickHeight * i + numberStartY;
		var style = $("<style>.pos" + i + " { top: " + yPos + "px; width:"+widthOfNumbers+"px }</style>");
		$("html > head").append(style);                         //向HTML的head标签添加style标签
		var dollarText = FomatNumber(goalAmount - countPerTick * i);    //25 50 75 100
		$( numbersDiv ).append( "<div class='therm-number pos" + i + "'>" +dollarText+ "</div>" );
		
	}
	
	//check that the images are loaded before anything
	arrayOfImages = new Array( ".therm-top", ".therm-body-bg", ".therm-body-mercury", ".therm-bottom", ".tip-left", ".tip-right");
	preload(arrayOfImages);
	
};

//check if each image is preloaded
function preload(arrayOfImages) {
	
	for(i=0;i<arrayOfImages.length;i++){
		$(arrayOfImages[i]).load(function() {   checkIfAllImagesLoaded();  });     //$(selector).load(function)  当指定的元素（及子元素）已加载时，会发生 load() 事件。
	}
}

//check that all the images are preloaded
function checkIfAllImagesLoaded(){
	imgsLoaded++;
	if(imgsLoaded == arrayOfImages.length+2){
		$(".goal-thermometer").fadeTo(1000, 1, function(){  });   //$(selector).fadeTo(speed,opacity,callback)
		animateThermometer(valve_currentAmount,valve_mercuryId,valve_tooltipId);  //这两个动画放到回调函数里面会被执行两次 
		animateThermometer(indoor_currentAmount,indoor_mercuryId,indoor_tooltipId); //造成第一次温度数字不变化，直接显示指定数字
		
	}
}


//animate the thermometer
function animateThermometer(currentAmount,mercuryId,tooltipId){
	
	var percentageComplete = currentAmount/goalAmount;                     //百分比
	var mercuryHeight = Math.round(heightOfBody * percentageComplete);     //动态水银块的高度
	var newMercuryTop = heightOfBody + thermTopHeight - mercuryHeight;     //动态水银块新的顶部
	var temp_lastAmount =0;
	var tooltipTxt;
	if(tooltipId== valve_tooltipId)
	{
		temp_lastAmount = valve_lastAmount;
		tooltipTxt = $("#valve-thermometer .therm-tooltip .tip-middle p");
	}
	else
	{
	    temp_lastAmount = indoor_lastAmount;
		tooltipTxt = $("#indoor-thermometer .therm-tooltip .tip-middle p");
	}
	
	mercuryId.stop().animate({height:mercuryHeight+1, top:newMercuryTop }, animationTime);   //$(selector).animate(styles,options)
	tooltipId.stop().animate({top:newMercuryTop - tooltipOffset},animationTime);
		
	//change the tooltip number as it moves
	$({tipAmount: temp_lastAmount}).stop().animate({tipAmount: currentAmount}, {duration:animationTime,
		step:function(){  //数字变化，每变化一步都回调一次函数
			tooltipTxt.html(commaSeparateNumber(this.tipAmount));
		}
	});
	//tooltipTxt.html(commaSeparateNumber(currentAmount));
	if(tooltipId== valve_tooltipId)
	{
		valve_lastAmount = currentAmount;
	}
	else
	   indoor_lastAmount = currentAmount;
}

//format the numbers with $ and commas   //利用正则表达式格式化
function commaSeparateNumber(val){
	
	//val = Math.round(val);         //取整
	val = parseFloat(val);
	val = val.toFixed(1);            //保留一位小数
    while (/(\d+)(\d{3})/.test(val.toString())){
    val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
    }
    return numberPrefix + val + numberSuffix;
}

function FomatNumber(val){
	val = Math.round(val);          //取整
    return numberPrefix + val + numberSuffix;
}