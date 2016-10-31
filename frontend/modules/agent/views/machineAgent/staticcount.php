<?php Yii::app()->clientScript->registerScriptFile(AGENT_DOMAIN . "/agent/js/highcharts.js"); ?> 
<link href="<?php echo AGENT_DOMAIN;?>/agent/css/agent.css" rel="stylesheet" type="text/css" />
<div class='dMainBody'>
	<div class="ctx">
	    <div class="optPanel">
	        <div class="toolbar img08"><?php echo Yii::t('Machine','盖机运行情况')?>
                <?php echo CHtml::link(Yii::t('Public','返回'),$this->createUrl('machineAgent/index'),array('class'=>'button_05 floatRight'))?>
                </div>
                
	        <div class="panel">
	            <table cellpadding="0" cellspacing="0" class="searchTable" style="margin-left:20px;">
		       
	            </table>
	    	</div>
    	</div>
		
	


		<div id="container" style="min-width: 310px; height: auto; margin: 0 auto"></div>
		
               
                
                <div class="line pagebox" style="margin-left:40%;margin-bottom: 30px;">
                     <?php    
    
                        $this->widget('CLinkPager',array(    
                            'header'=>'',    
                            'firstPageLabel' => '首页',    
                            'lastPageLabel' => '末页',    
                            'prevPageLabel' => '上一页',    
                            'nextPageLabel' => '下一页',    
                            'pages' => $pages,    
                            'maxButtonCount'=>13    
                            )    
                        );    
                        ?>  
                    
                </div>
    </div>
</div>
<script type="text/javascript">
  var  machineName =111;

    // 每天的开机时间

//    var tasks = eval('[{name: "12-18",intervals: [{from: "2013/12/18 16:06:56",to: "2013/12/18 16:10:17", label:""}] },{name: "07-04",intervals: [{from: "2013/7/4 18:21:48",to: "2013/7/4 18:22:11", label:""}]}]');
    var tasks = eval(<?php echo $data?>);

    var series = [];
    $.each(tasks.reverse(), function (i, task) {
        
        var item = {
            name: task.name,
            data: []
        };
        $.each(task.intervals, function (j, interval) {
            
            var startDate =new Date(Date.parse(interval.from.replace(/-/g,   "/")));
            var endDate = new Date(Date.parse(interval.to.replace(/-/g,   "/")));

            var startUDate = Date.UTC(0, 0, 0, startDate.getHours(), startDate.getMinutes(), startDate.getMilliseconds());
            var endUDate = Date.UTC(0, 0, 0, endDate.getHours(), endDate.getMinutes(), endDate.getMilliseconds());

            item.data.push({
                x: startUDate,
                y: i,
                label: interval.label,
                from: startUDate,
                to: endUDate
            }, {
                x: endUDate,
                y: i,
                from: startUDate,
                to: endUDate
            });

            // add a null value between intervals
            if (task.intervals[j + 1]) {
                item.data.push(
                [(endUDate + task.intervals[j + 1].from) / 2, null]
            );
            }

        });

        series.push(item);
    });


    // 创建图表
    var chart = new Highcharts.Chart({

        chart: {
            renderTo: 'container',
           // height:document.body.offsetHeight  - 150
        },

        title: {
            text: "<?php echo $machineName;?>"
        },

        xAxis: {
            type: 'datetime',
            startOnTick: true,
            endOnTick: true,
        },

        yAxis: {
            tickInterval: 1,
            labels: {
                formatter: function () {
                    if (tasks[this.value]) {
                        return tasks[this.value].name;
                    }
                }
            },
            startOnTick: true,
            endOnTick: true,
            title: {
                text: "<?php echo Yii::t('Public','日期')?>"
            },
            minPadding: 0.01,
            maxPadding: 0.01,
           
        },

        legend: {
            enabled: true
        },

        tooltip: {
            formatter: function () {
                return '<b>' + tasks[this.y].name + '</b><br/>' +
                Highcharts.dateFormat('%H:%M', this.point.options.from) +
                ' - ' + Highcharts.dateFormat('%H:%M', this.point.options.to);
            }
        },

        plotOptions: {
            line: {
                lineWidth: 9,
                marker: {
                    enabled: false
                },
                dataLabels: {
                    enabled: true,
                    align: 'left',
                    formatter: function () {
                        return this.point.options && this.point.options.label;
                    }
                }
            }
        },

        series: series

    });
    
 
    </script>
    
   
    
    