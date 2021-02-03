<?php
    //Highcharts에 series 데이터를 추가할 빈 배열 생성
    $csv = array();
    $APEX_date = array();
    $outflow = array();
    $TN = array();

    //파일을 읽어오기
    $lines = file('sample.csv', FILE_IGNORE_NEW_LINES);

    #CSV 파일을 한줄씩 읽으며 변수 가상리스트에 추가
    foreach ($lines as $key => $value) {
        $csv[$key] = str_getcsv($value);
        foreach($csv as $dsyang) {
            $dt1 = $dsyang[0];
            $streamflow = $dsyang[1];
            $baseflow = $dsyang[2];
        }
    //Highcharts에 series 데이터 배열에 값 추가하기
    array_push($APEX_date, $dt1);
    array_push($outflow, $streamflow);
    array_push($TN, $baseflow);
    }

    //series 데이터 배열 확인
    /*
    echo '<pre>';
    print_r($APEX_date);
    print_r($outflow);
    print_r($TN);
    echo '</pre>';
    */

    //Highcharts CSV 표 출력을 위한 배열
    $arr_c1 = count($APEX_date);
    for ($i = 0; $i  <= $arr_c1; $i ++) {
		$arr_table[$i] = '['.$APEX_date[$i].','.$outflow[$i].','.$TN[$i].']';
    }

?>



<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    
    <title>Ext.Panel</title>
	<link rel="stylesheet" type="text/css" href="./openlayers3/css/ol.css">
    
    <script type="text/javascript" src="./imports/extjs6/build/ext-all.js"></script>
	<script type="text/javascript" src="./imports/extjs6/examples/classic/shared/include-ext.js"></script>
    
    <script type="text/javascript" src="./imports/Highcharts/js/highcharts.js"></script> 
    <script type="text/javascript" src="./imports/Highcharts/js/modules/exporting.js"></script>
</head>

<body>

		<script language="javascript">	
			
			Ext.onReady(function() {
			var how = '<?php echo $how; ?>';
			if (how == 2) {Ext.Msg.alert('알림','최적 회귀식이 존재하지 않습니다!');}
			    // sample static data for the store

    			var myData = [<?php echo join($arr_table,','); ?>];
			    // create the data store
			    var store = Ext.create('Ext.data.ArrayStore', {
			        fields: [
                        {name: 'APEX_date', type: 'date', dateFormat: 'Y-m-d'},
                        {name: 'outflow',      type: 'float'},
                        {name: 'TN',      type: 'float'}
			        ],
			        data: myData
			    });
			    	
					var data = [<?php echo join($arr_table,','); ?>];
					var csvContent = "data:text/csv;charset=utf-8,";
							csvContent+= "APEX_date, outflow, TN \n";
							
					data.forEach(function(infoArray, index){
					   dataString = infoArray.join(",");
					   csvContent += index < data.length ? dataString+ "\n" : dataString;
					}); 
					

			    var btn = Ext.create('Ext.Button', {
					    text: 'DownLoad File',
					    width: '100%',				    
					    //renderTo: Ext.getBody(),        
					    handler: function() {
					    	var encodedUri = encodeURI(csvContent);
					      var link = document.createElement("a");
								link.setAttribute("href", encodedUri);
								link.setAttribute("download", "<?php echo trim($nier_name) ?>.csv");
								document.body.appendChild(link); // Required for FF				
								link.click(); // This will download the data file named "my_data.csv".
					    }			    
					});
	
								    
					//'Ext.ux.LiveSearchGridPanel'
			    var gridPanel = Ext.create('Ext.ux.LiveSearchGridPanel', {
			        store: store,
			        columnLines: true,
			        columns: [
			            {
			                text     : '날짜',
			                width    : 120,
			                sortable : true,
			                formatter: 'date',
			                dataIndex: 'APEX_date'
			            },			        
			            {
			                text     : '유출량(mm)',
			                width    : 125,
			                sortable : true,
			                dataIndex: 'outflow'
			            },
			            {
			                text     : 'T-N부하량(kg/has)',
			                width    : 125,
			                sortable : true,
			                dataIndex: 'TN'
			            }
			        ],
			        //height: 350,
			        anchor:'100% 100%',
			        autoScroll: true,
			        layout:'fit',
			        //title: 'Live Search Grid',
			        //renderTo: Ext.getBody(),
			        viewConfig: {
			            stripeRows: false
			        }
			    });				


			    var viewport = Ext.create('Ext.Viewport', {
			        layout: {
			            type: 'border',
			            padding: 1
			        },
			        defaults: {
			            split: true
			        },
			        items: [
			        {
			            region: 'center',
			            html: '',
			            //title: 'Center',
			            minHeight: 80,
			            width: '70%',	            
							    items: [{
										xtype:'component',
										height: '100%',
										width: '90%',
										
										//title:'Example Chart',
										id:Ext.id(),
										listeners:{
											afterrender:function( component, eOpts ){
												var chartref = new Highcharts.Chart({
													
													chart: {
														spacingBottom: 15,
										                spacingTop: 10,
										                spacingLeft: 10,
										                spacingRight: 10,
														//zoomType: 'xy',
														zoomType: 'x',
														renderTo:this.getId()
													},
													title: {
														text: ''
													},
													credits:{
														enabled:true												
													},
													xAxis: {
														type: 'datetime',
								            title: {
								                text: '날짜'
								            },
								            dateTimeLabelFormats: { // don't display the dummy year
								                day: '%e. c%b \'%y',
								            },								            
														categories: [<?php echo join($APEX_date, ",") ?>]
													},
													yAxis: {
														min: 0,
														title: {
														text: '유출량(mm)'
														}
													},
													legend: {
														reversed: true
													},
													plotOptions: {
														series: {
															fillOpacity: 0.5,
                                                            turboThreshold: 0,
														},
													},
													series: [{
														name: '유출량(mm)',
														type: 'areaspline',
														data: [<?php echo join($outflow, ',') ?>]
													},{
														name: 'T-N(kg/ha)',
														type: 'areaspline',
														data: [<?php echo join($TN, ',') ?>]
													},]
												//});
											});



											}
										}
									}]
			        },{
			            region: 'east',
			            collapsible: true,
			            collapsed: true, 
			            floatable: true,
			            split: true,
			            width: '45%',
			            minWidth: 120,
			            minHeight: 140,
			            title: '<?php echo $nier_name ?> Table',
			            layout: {
			                type: 'anchor',
			                padding: 5,
			                align: 'stretch'
			            },
			            items: [gridPanel],
			            bbar: [btn]
			            
			        }]
			    });
			});
		</script>
    <!--
	  <style type="text/css">
			.panel-container {
			   margin-bottom: 20px;
			}
	  </style>  
	  --> 
</body>
</html>