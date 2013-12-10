/* WOC online result library */

/* ISO 3361-1 country codes (+some extensions eg. CHE == CHF) */
var country_codes = {
	'ALA': 'ax','AFG': 'af','ALB': 'al','DZA': 'dz','ASM': 'as','AND': 'ad','AGO': 'ao','AIA': 'ai','ATA': 'aq','ATG': 'ag','ARG': 'ar','ARM': 'am','ABW': 'aw','AUS': 'au','AUT': 'at','AZE': 'az','BHS': 'bs','BHR': 'bh','BGD': 'bd','BRB': 'bb','BLR': 'by','BEL': 'be','BLZ': 'bz','BEN': 'bj','BMU': 'bm','BTN': 'bt','BOL': 'bo','BIH': 'ba','BWA': 'bw','BVT': 'bv','BRA': 'br','IOT': 'io','BRN': 'bn','BUL': 'bg','BFA': 'bf','BDI': 'bi','KHM': 'kh','CMR': 'cm','CAN': 'ca','CPV': 'cv','CYM': 'ky','CAF': 'cf','TCD': 'td','CHL': 'cl','CHN': 'cn','CXR': 'cx','CCK': 'cc','COL': 'co','COM': 'km','COD': 'cd','COG': 'cg','COK': 'ck','CRI': 'cr','CIV': 'ci','HRV': 'hr','CUB': 'cu','CYP': 'cy','CZE': 'cz','DNK': 'dk','DEN':'dk','DJI': 'dj','DMA': 'dm','DOM': 'do','ECU': 'ec','EGY': 'eg','SLV': 'sv','GNQ': 'gq','ERI': 'er','EST': 'ee','ETH': 'et','FLK': 'fk','FRO': 'fo','FJI': 'fj','FIN': 'fi','FRA': 'fr','GUF': 'gf','PYF': 'pf','ATF': 'tf','GAB': 'ga','GMB': 'gm','GEO': 'ge','DEU': 'de','GHA': 'gh','GIB': 'gi','GRC': 'gr','GRL': 'gl','GRD': 'gd','GLP': 'gp','GUM': 'gu','GTM': 'gt','GIN': 'gn','GNB': 'gw','GUY': 'gy','HTI': 'ht','HMD': 'hm','HND': 'hn','HKG': 'hk','HUN': 'hu','ISL': 'is','IND': 'in','IDN': 'id','IRN': 'ir','IRQ': 'iq','IRL': 'ie','ISR': 'il','ITA': 'it','JAM': 'jm','JPN': 'jp','JOR': 'jo','KAZ': 'kz','KEN': 'ke','KIR': 'ki','PRK': 'kp','KOR': 'kr','KWT': 'kw','KGZ': 'kg','LAO': 'la','LVA': 'lv', 'LAT': 'lv', 'LBN': 'lb','LSO': 'ls','LBR': 'lr','LBY': 'ly','LIE': 'li','LTU': 'lt','LUX': 'lu','MAC': 'mo','MKD': 'mk','MDG': 'mg','MWI': 'mw','MYS': 'my','MDV': 'mv','MLI': 'ml','MLT': 'mt','MHL': 'mh','MTQ': 'mq','MRT': 'mr','MUS': 'mu','MYT': 'yt','MEX': 'mx','FSM': 'fm','MDA': 'md','MCO': 'mc','MNG': 'mn','MSR': 'ms','MAR': 'ma','MOZ': 'mz','MMR': 'mm','NAM': 'na','NRU': 'nr','NPL': 'np','NLD': 'nl','ANT': 'an','NCL': 'nc','NZL': 'nz','NIC': 'ni','NER': 'ne','NGA': 'ng','NIU': 'nu','NFK': 'nf','MNP': 'mp','NOR': 'no','OMN': 'om','PAK': 'pk','PLW': 'pw','PSE': 'ps','PAN': 'pa','PNG': 'pg','PRY': 'py','PER': 'pe','PHL': 'ph','PCN': 'pn','POL': 'pl','PRT': 'pt','PRI': 'pr','QAT': 'qa','REU': 're','ROU': 'ro','RUS': 'ru','RWA': 'rw','SHN': 'sh','KNA': 'kn','LCA': 'lc','SPM': 'pm','VCT': 'vc','WSM': 'ws','SMR': 'sm','STP': 'st','SAU': 'sa','SEN': 'sn','SCG': 'cs','SRB': 'sb', 'SYC': 'sc','SLE': 'sl','SGP': 'sg','SVK': 'sk','SVN': 'si','SLB': 'sb','SOM': 'so','ZAF': 'za','SGS': 'gs','ESP': 'es','LKA': 'lk','SDN': 'sd','SUR': 'sr','SJM': 'sj','SWZ': 'sz','SWE': 'se','CHE': 'ch','SUI':'ch','SYR': 'sy','TWN': 'tw','TJK': 'tj','TZA': 'tz','THA': 'th','TLS': 'tl','TGO': 'tg','TKL': 'tk','TON': 'to','TTO': 'tt','TUN': 'tn','TUR': 'tr','TKM': 'tm','TCA': 'tc','TUV': 'tv','UGA': 'ug','UKR': 'ua','ARE': 'ae','GBR': 'gb','USA': 'us','UMI': 'um','URY': 'uy','UZB': 'uz','VUT': 'vu','VAT': 'va','VEN': 've','VNM': 'vn','VGB': 'vg','VIR': 'vi','WLF': 'wf','ESH': 'eh','YEM': 'ye','ZMB': 'zm','ZWE': 'zw'
};

function checkTime(i) {
	
	if (i<10) {
		i="0" + i;
	}
	return i;
}

function tssort(cell) {

	if (cell == "" || cell == "DQ")
		return 999999999999;
	else
		return Number(cell);
}

function timeFmt(cellvalue, options, rowObject) {
	if (cellvalue != "" && rowObject.classification == 0) {
		d = new Date(Number(cellvalue));
		fmt = checkTime(d.getMinutes()) + ":" + checkTime(d.getSeconds());
		h = d.getUTCHours();
		if (h > 0)
			fmt = h + ":" + fmt;
		return fmt;
	}
	if (cellvalue == "DQ") {
		return cellvalue;
	}
	return "";
}

function nameFmt(cellvalue, options, rowObject) {

	return "<span class=\"runner\">" + cellvalue + "</span>";
}

function hasOwnProperty(obj, prop){

    var proto = obj.__proto__ || obj.constructor.prototype;
    return (prop in obj) &&
        (!(prop in proto) || proto[prop] !== obj[prop]);
}

function flagFmt(cellvalue, options, rowObject) {

	if (hasOwnProperty(country_codes, cellvalue))
		return "<div class=\"flag flag-" + country_codes[cellvalue] + "\"></div><div class=\"country_name\">"+cellvalue+"</div>";	
	return cellvalue;
}

function timeGapFmt(cellvalue, options, rowObject) {

	if (rowObject.classification == 0 && (cellvalue == "0" || cellvalue == ""))
		return "";
	if (cellvalue != "" && rowObject.classification == 0) {
		d = new Date(Number(cellvalue));
		fmt = checkTime(d.getMinutes()) + ":" + checkTime(d.getSeconds());
		h = d.getUTCHours();
		if (h > 0)
			fmt = h + ":" + fmt;
			
		colName = options.colModel.name;
		
		if (rowObject[colName + "Gap"] > 0)
			fmt = fmt + " <span class=\"gap\">(+"+timeFmt(rowObject[colName + "Gap"], options, rowObject)+")</span>"; 
			/*fmt = fmt + " <span class=\"gap\">(+00:00:00)</span>";*/
		return fmt;
		
		
		
	}
	else {
		return "DQ";
	}
}

function getKeys(obj) {
   var keys = [];
   for(var key in obj){
      keys.push(key);
   }
   return keys;
}

function initLive(raceConf) {
	/*
		Init jqGrid based live result sheet
	*/
	
	function buildColModel(classConf) {
		/* add base cols */
		colModel = [
			{name:'id', index:'id', width:30, sortable: false, hidden: true}, 
			{name:'name', index:'name', width:180, sortable: false, formatter: nameFmt}, 
			{name:'club', index:'club', width:70, sortable: false, formatter: flagFmt},
			{name:'startTime', index:'startTime', width:90, sortable: true, formatter: timeFmt, hidden:true},
			{name:'classification', index:'classification', width:80, hidden:true, sortable: false}
			];
		
		/* add radio control cols */
		for (i=0; i < classConf.radioControls.length; i++) {
			name = classConf.radioControls[i].code;
			
		
			colModel.push({name: name, index: name, width:120, sorttype: tssort, formatter: timeGapFmt} );
			colModel.push({name: name + "Gap", index: name + "Gap", width:120, hidden:true} );
		};
		
		colModel.push({name:'raceTime', index:'raceTime', width:120, sorttype: tssort, formatter: timeGapFmt});
		colModel.push({name:'raceTimeGap', index:'raceTimeGap', width:120, hidden:true});
		return colModel;
	}
	
	function buildColNames(classConf) {
		colNames = ['Bip', 'Name', 'Country',  'Start time', 'Classification'];

		/* add radio control cols */
		for (k=0; k < classConf.radioControls.length; k++) {
			na = classConf.radioControls[k].title;
			colNames.push(na);
			
			colNames.push(na + "Gap");
	 	}
	 	
	 	colNames.push('Race time');
	 	colNames.push('Race time gap');
		return colNames;
	}
	
	$.map(raceConf.classes, function(classconf, idx){
	
	
		var tabselector = classconf.selector;
		var title = classconf.title;
		
		$(tabselector).jqGrid({
		datatype: 'clientSide',
		colNames: buildColNames(classconf),
		colModel : buildColModel(classconf),
		sortname: 'starttime',
		sortorder: 'asc',
		viewrecords: true,
		gridview: true,
		caption: title,
		rownumbers: true,
		viewsortcols: [true,'vertical',true],
		altRows: false,
		rowNum: 500
		});
		
	});
	
	function updateLists(resp) {
		
		bt = {}
		brt = {}
		for (c=0; c < raceConf.classes.length; c++) {
			classConf = raceConf.classes[c];
			/* reset grid */
			$(classConf.selector).clearGridData();
			
			/* get best split times */
			btStr = getKeys(resp.bestSplitTime[classConf.classcode]);
			bt[classConf.classcode] = $.map(btStr, function(val, i) { return { code: val, time: Number(resp.bestSplitTime[classConf.classcode][val])};});
			
			/* get best race time */
			brt[classConf.classcode] = Number(resp.bestRaceTime[classConf.classcode]);
		}
		

		/* insert new data */
		for (i=0; i < resp.rows.length; i++) {
						
			for (c=0; c < raceConf.classes.length; c++) {
				classcode = raceConf.classes[c].classcode;
				
				/* insert row into tables */
				if (resp.rows[i].cell["cate"] == classcode) {
					if (resp.rows[i].cell.classification == 0) {
						record = resp.rows[i].cell;
						
						$(raceConf.classes[c].selector).addRowData(resp.rows[i].id, record);
						
						rt = Number(record.raceTime);
						
						if (rt.toString() != "NaN") {
							$(raceConf.classes[c].selector).setRowData(resp.rows[i].id, { raceTimeGap: rt - brt[classcode]});
						}
						
						/* split time gaps */
						gaps = {};
						$.map(bt[classcode], function(post, i) {
							gaps[post.code + "Gap"] = record[post.code] - post.time;
							
						});
						
						$(raceConf.classes[c].selector).setRowData(resp.rows[i].id, gaps);

						/* TODO: compute & resize table height */
						$(raceConf.classes[c].selector).setGridHeight('auto');
					}
					else
						$(raceConf.classes[c].selector).addRowData(resp.rows[i].id, {name: resp.rows[i].cell.name, club: resp.rows[i].cell.club, startTime: resp.rows[i].cell.startTime, raceTime: "DQ"});
					break;
				}
			}
		}
		for (var ci=0; ci < raceConf.classes.length; ci++) {
			/* apply stored sorting state */
			$(raceConf.classes[ci].selector).trigger("reloadGrid");
		}
	}
	
	/* init timer, ajax + json */
	if (raceConf.updateInterval > 0) {
		$(document).everyTime(raceConf.updateInterval, function() {
		$.getJSON(raceConf.url, function(obj) {
				updateLists(obj);
				$(raceConf.updateTimeSelector).text(obj.updatetime);
			});
		});
	}
		  
	/* first time table initialization */
	$.getJSON(raceConf.url, function(obj) {
		updateLists(obj);
		$(raceConf.updateTimeSelector).text(obj["updatetime"]);
	});
};
