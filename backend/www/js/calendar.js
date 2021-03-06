function Calendar ( opt ) {
		//元素属性
		var div = opt.div;
		var calDate;
		var calYearMonth;
		var table;
		var dateSpan;
		var tbodyHeight = 0 ;
		var tbodyWidth = 0 ;
		var tbody ;								
		//数据属性
		var cellSpacing = 0;					//单元格相隔
		var tableBorder = 0;					//表格边框
		var tdWidth = 0;						//单元格宽度
		var tdHeight = 0;						//单元格高度
		var fontSize = 0;						//字体大小
		var defaultOpt = {};					//默认参数
		var language;							//语言
		var currentDateList;					//当前日期集合
		var preDateList;						//上个日期集合
		var nextDateList;						//下个日期集合
		var url;								//读取数据地址
		var showInfo;
		var freq_click;
		var td_click;
		var loadingData;
		var c_instance = this;
		var key;								//读取数据key值
		var tdClickKey = "";
		var urlParam;
		
		var dateClick;
		var dateCreate;
		var isRefreshTable = 0;
		
		//静态属性
		Calendar.headString = {
			"chinese" : ["星期天","星期一","星期二","星期三","星期四","星期五","星期六"] ,
			"english" : ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]
		}

		//读取数据
		this.loadData = function () {
			key = new Date().getTime();
			var loadKey = key;
			//传递参数准备
			var paramDateArray = new Array();
			$.merge(paramDateArray,c_instance.preDateList);
			$.merge(paramDateArray,c_instance.currentDateList);
			$.merge(paramDateArray,c_instance.nextDateList);
			for ( var i = 0 ; i < paramDateArray.length ; i++ ) {
				paramDateArray[i] = paramDateArray[i].toJSONString("yyyy-MM-dd");
			}
			var paramObj = {};
			if ( c_instance.urlParam ) {
				var paramObj = c_instance.urlParam();
			}
			$.extend(paramObj,{"date" : obj2String(paramDateArray)});
			
			//清空信息
			$(div).find(".day_and_night_div").remove();
			
			var date_list = [];
			for ( var i = 0 ; i < this.currentDateList.length ; i++ ) {
				date_list.push(this.currentDateList[i].clone().toJSONString("yyyy-MM-dd"));
			}
			this.loadingData({"date" : obj2String(date_list) , "yearMonth_string" : this.calYearMonth } );
			
		}
		
		//选项初始化
		{
			defaultOpt = {
				"language" : "chinese"  ,
				"date" : "now" , 
				"td_click" : function(a){} , 
				"loadingData" : function(a){} , 
				"freq_click" : function(a){}
			};
			$.extend(defaultOpt , opt);
			this.language = defaultOpt.language;
			this.c_instance = this;
			this.urlParam = defaultOpt.urlParam;
			if ( defaultOpt.date == "now" ) {
				this.calDate = new Date();
			} else if ( typeof(defaultOpt.date) == "string" ) {
				this.calDate = Date.parse(defaultOpt.date);
			} else if ( defaultOpt.date instanceof Date ) {
				this.calDate = defaultOpt.date;
			}
			this.td_click = defaultOpt.td_click;
			
			this.calYearMonth = this.calDate.getFullYear() + "-" + (this.calDate.getMonth()+1);
			this.dateSpan = defaultOpt.dateSpan;
			$(this.dateSpan).each(function(){
				$(this).text(this.calYearMonth);	  
			});
			this.url = defaultOpt.url;
			this.showInfo = defaultOpt.showInfo;
			this.freq_click = defaultOpt.freq_click;
			this.td_click = defaultOpt.td_click;
			$(div).addClass(".calendar_div");
			this.loadingData = defaultOpt.loadingData;
			this.dateClick = defaultOpt.dateClick;
			this.dateCreate = defaultOpt.dateCreate;
		}
		
		//初始化table
		this.initTable = function(){
			c_instance.isRefreshTable = 0;
			$(table).remove();
			//添加表格
			table = $("<table border='1' cellspacing='0'/>");
			$(table).attr({"id":opt.tableId});
			$(table).css({ "table-layout" : "fixed"});
			$(table).appendTo($(div));
			
			//添加表头
			var thead = $("<thead class='week_head'/>").appendTo($(table));
			var trInThead = $("<tr/>").appendTo($(thead));
			var headArr = Calendar.headString[this.language];
			$(headArr).each(function(index){
				var th = $("<th/>");
				$("<div/>").text(this.toString()).appendTo($(th));
				$(th).appendTo($(trInThead));
			});
			
			//添加表身
			tbody = $("<tbody/>").appendTo($(table));
			for ( var i = 0 ; i < 6 ; i++ ) {
				var numberTr = $("<tr/>").appendTo($(tbody));
				for ( var j = 0 ; j < 7; j++ ) {
					var numberTd = $("<td/>");
					$(numberTd).appendTo($(numberTr));
				}
			}
		}
		//初始化样式
		this.init = function () {
			tbodyHeight = $(table).height();
			tbodyWidth = $(table).width();
			if ( $(table).attr("cellspacing") ) {
				cellSpacing = $(table).attr("cellspacing");
			}
			if ( $(table).attr("border") ) {
				tableBorder = $(table).attr("border");
			}
			tdWidth = $(tbody).find("td").width();
			tdHeight = tbodyHeight / $(tbody).find("tr").length;
			$(table).find("td").height(tdHeight);
			
			this.refreshCalendar();
			$(window).resize(this.windowResize);
		}
		
		//刷新日历
		this.refreshCalendar = function () {
			//this.clearDayNightDiv();

			if ( c_instance.isRefreshTable == 1 ) {
				this.initTable();
			}
			this.refreshNumber();
			this.refreshDate();
			//访问后台
			//TODO
			//this.loadData();
		}
		
		//刷新数字
		this.refreshNumber = function () {
			//删除今天标识
			//$(".date_toDay").removeClass("date_toDay");
			//
			$(tbody).find(".tdDiv").remove();
			//获取时间
			this.currentDateList = this.calDate.getMonthDateFromToEnd();
			this.preDateList = new Array();
			if ( this.currentDateList != null && this.currentDateList.length > 0 ) {
				this.preDateList = this.currentDateList[0].getPreMonthDate();
			}
			this.nextDateList = new Array();
			if ( this.currentDateList != null && this.currentDateList.length > 0 ) {
				this.nextDateList = this.currentDateList[this.currentDateList.length-1].getNextMonthDate();
			}
			var dateArr = new Array();
			var dateTr = null;
			var dateArrList = [this.preDateList,this.currentDateList,this.nextDateList];
			var tableTds = $(table).find("tbody td");
			for ( var i = 0 , k = 0 , isYet = "" ; i < dateArrList.length ; i++ ) {
				dateArr = dateArrList[i];
				isYet = i % 2 == 0 ?" number_yet":" number_";
				for ( var j = 0 ; dateArr != null && j < dateArr.length ; j++ , k++ ) {
					var dString = dateArr[j].toString("yyyy-MM-dd");
					var tableTd = tableTds[k];
					var tdDiv = $("<div class='tdDiv'/>").attr({"cal_date":dString});
					var tdA = $("<a href='#' class='tdLink'></a>");
					$(tdDiv).append($(tdA));
					var toDay = new Date().toString("yyyy-MM-dd");
					/*if ( dString == toDay ) {
						$(tableTd).addClass("date_toDay");
						//var thisImg=$("<img src='../images/sl_ioc5.jpg' class='thisImg' width='49' height='28'/>");
						//var tdDiv=$(thisImg);
					}*/
					$(tdDiv).appendTo($(tableTd));
					var numberDiv = $("<div/>").attr({"class":"number_div"});
					var numberLi = $("<div/>").attr({"class":"number_li"+isYet});
					
					// 日期样式 begin
					$(tdDiv).css({"position":"relative"});
					fontSize = ((tdWidth+tdHeight)/2)/2;
					$(numberLi).css({"width":"100%","height":"100px","text-align":"center","line-height":"100px","font-size":fontSize+"px"}).text(dateArr[j].getDate());
					// 日期样式 end
					
					$(numberDiv).append($(numberLi));
					if ( dString == toDay ) {
						$(numberDiv).empty();
						$(numberDiv).append("<img src='../images/sl_ioc5.png' alt='今日图标'/>");						
					}
					$(tdDiv).append(numberDiv);
					$(tdDiv).click({"date":dString},function(event){
						var param = event.data;
						c_instance.dateClick(param.date);
					});
					isy = isYet==" number_yet";
					c_instance.dateCreate(dString,tableTd,isy);
				}
			}
			
			// 删掉多余日期关键 begin
			var tr_remove = $(table).find("tbody tr");
			for ( var i = 0 ; i < $(tr_remove).length; i++) {
				var tr_remove_sub = $(tr_remove).eq(i);
				var td_yet = $(tr_remove_sub).find(".number_yet");
				var td_div = $(tr_remove_sub).find(".tdDiv");
				if ( $(td_yet).length == 7 ) {
					$(tr_remove_sub).remove();
					c_instance.isRefreshTable = 1;
				} else if ( $(td_div).length == 0 ) {
					$(tr_remove_sub).remove();
					c_instance.isRefreshTable = 1;
				}
			}
			// 删掉多余日期关键 end
		}
		
		
		//刷新日期字符显示
		this.refreshDate = function () {
			$(c_instance.dateSpan).each(function(){
				$(this).text(c_instance.calYearMonth);
			});
		}
		
		//下一个月
		this.nextMonth = function () {
			this.calDate.addMonths(1);
			this.calYearMonth = this.calDate.getFullYear() + "-" + (this.calDate.getMonth()+1);
			this.refreshCalendar();
			//this.addDayNightDiv();
		}
		
		//上一个月
		this.preMonth = function () {
			this.calDate.addMonths(-1);
			this.calYearMonth = this.calDate.getFullYear() + "-" + (this.calDate.getMonth()+1);
			this.refreshCalendar();
			//this.addDayNightDiv();
		}
		
		this.initTable();
		this.init();
		//this.refreshCalendar();
		//this.addAllDayNightDiv();
		
		this.getCurrentDateList = function (){
			return currentDateList;
		}
		
		
		
		/************************ 帮助 begin ***************************/
		function obj2String ( obj ) {
		if ( !obj || obj == null ) {
			return;
		}
		if ( obj.constructor == String ) {
			return "'" + obj + "'";
		}
		if ( obj.constructor == Number ) {
			return  obj ;
		}
		var objString = "";
		if ( obj.constructor == Array ) {
			for ( var i = 0 ; i < obj.length ; i++ ) {
				var value = obj[i];
				var s = obj2String(value);
				objString += s + " , ";
			}
			objString = objString.substring(0,objString.lastIndexOf(","));
			objString = "[" + objString + "]" ;
		} else if ( obj.constructor == Object ) {
			for ( var key in obj ) {
				var value = obj[key];
				if ( value.constructor == String ) {
					objString += typeStringChange( key , value );
				} else if ( value.constructor == Number ) {
					objString += typeNumberChange( key , value );
				}  else if ( value.constructor == Array ) {
					objString += typeArrayChange( key , value );
				} else if ( value.constructor == Object ) {
					objString += typeObjChange( key , value );
				} else {
					continue;
				}
				objString += " , ";
			}
			objString = objString.substring(0,objString.lastIndexOf(","));
			objString = "{" + objString + "}" ;
		}
		return objString
	}
	
	//类型字符串转换
	function typeStringChange( key , value ) {
		var str = "'" + key + "' : '" + value + "'";
		return str;
	}
	
	//类型数字转换
	function typeNumberChange( key , value ) {
		var str = "'" + key + "' : " + value + "";
		return str;
	}
	
	//类型数组转换
	function typeArrayChange( key , value ) {
		var str = "";
		var arr = "";
		for ( var i = 0 ; i < value.length ; i++ ) {
			var val = value[i];
			arr += obj2String(val);
			arr += ",";
		}
		arr = arr.substring(0,arr.lastIndexOf(","));
		arr = "[" + arr + "]";
		str = "'" + key + "' : " + arr + "";
		//alert(str);
		return str;
	}
	
	
	//类型对象转换
	function typeObjChange( key , value ) {
		var str = obj2String(value);
		str = "'" + key + "' : '" + str + "' ";
		return str;
	}
	
	
	/************************* 帮助 end ***************************/
		
		
	return this;
}