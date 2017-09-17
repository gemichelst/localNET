<script src="https://code.highcharts.com/highcharts.src.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>

<!-- PHP START -->
<?php
  	
	function human_filesize($bytes, $decimals = 2) {
	
		$sz = 'BKMGTP';
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
	
	}
	
	$current_time = exec("date +'%d %b %Y %T %Z'");
	$frequency = exec("cat /sys/devices/system/cpu/cpu0/cpufreq/scaling_cur_freq") / 1000;
	$processor = str_replace("-compatible processor", "", explode(": ", exec("cat /proc/cpuinfo | grep Processor"))[1]);
	$cpu_temperature = round(exec("cat /sys/class/thermal/thermal_zone0/temp ") / 1000, 1);
	
	//$RX = exec("ifconfig eth0 | grep 'RX bytes'| cut -d: -f2 | cut -d' ' -f1");
	//$TX = exec("ifconfig eth0 | grep 'TX bytes'| cut -d: -f3 | cut -d' ' -f1");
	
	list($system, $host, $kernel) = split(" ", exec("uname -a"), 4);
	$host = exec('hostname -f');;
	
	//CPU Usage
	$output1 = null;
	$output2 = null;
	//First sample
	exec("cat /proc/stat", $output1);
	//Sleep before second sample
	sleep(1);
	//Second sample
	exec("cat /proc/stat", $output2);
	$cpuload = 0;
	for ($i=0; $i < 1; $i++)
	{
		//First row
		$cpu_stat_1 = explode(" ", $output1[$i+1]);
		$cpu_stat_2 = explode(" ", $output2[$i+1]);
		//Init arrays
		$info1 = array("user"=>$cpu_stat_1[1], "nice"=>$cpu_stat_1[2], "system"=>$cpu_stat_1[3], "idle"=>$cpu_stat_1[4]);
		$info2 = array("user"=>$cpu_stat_2[1], "nice"=>$cpu_stat_2[2], "system"=>$cpu_stat_2[3], "idle"=>$cpu_stat_2[4]);
		$idlesum = $info2["idle"] - $info1["idle"] + $info2["system"] - $info1["system"];
		$sum1 = array_sum($info1);
		$sum2 = array_sum($info2);
		//Calculate the cpu usage as a percent
		$load = (1 - ($idlesum / ($sum2 - $sum1))) * 100;
		$cpuload += $load;
	}
	$cpuload = round($cpuload, 1); //One decimal place
	
	// uptime
	$uptime_array = explode(" ", exec("cat /proc/uptime"));
	$seconds = round($uptime_array[0], 0);
	$minutes = $seconds / 60;
	$hours = $minutes / 60;
	$days = floor($hours / 24);
	$hours = sprintf('%02d', floor($hours - ($days * 24)));
	$minutes = sprintf('%02d', floor($minutes - ($days * 24 * 60) - ($hours * 60)));
	
	if ($days == 0) {

		$uptime = $hours . ":" .  $minutes . " (hh:mm)";
	
	}
	else if($days == 1) {
		
		$uptime = $days . " day, " .  $hours . ":" .  $minutes . " (hh:mm)";
	
	}
	else {
	
		$uptime = $days . " days, " .  $hours . ":" .  $minutes . " (hh:mm)";
	
	}
	
	// load averages
	$loadavg = file("/proc/loadavg");
	
	if (is_array($loadavg)) {
	
		$loadaverages = strtok($loadavg[0], " ");
	
		for ($i = 0; $i < 2; $i++) {
	
			$retval = strtok(" ");
	
			if ($retval === FALSE) break; else $loadaverages .= " " . $retval;
	
		}
	
	}
	
	// memory
	$meminfo = file("/proc/meminfo");
	
	for ($i = 0; $i < count($meminfo); $i++) {

		list($item, $data) = split(":", $meminfo[$i], 2);
		$item = trim(chop($item));
		$data = intval(preg_replace("/[^0-9]/", "", trim(chop($data)))); //Remove non numeric characters
		
		switch($item) {
	
			case "MemTotal": $total_mem = $data; break;
			case "MemFree": $free_mem = $data; break;
			case "SwapTotal": $total_swap = $data; break;
			case "SwapFree": $free_swap = $data; break;
			case "Buffers": $buffer_mem = $data; break;
			case "Cached": $cache_mem = $data; break;
			default: break;
	
		}
	
	}
	
	$used_mem = $total_mem - $free_mem;
	$used_swap = $total_swap - $free_swap;
	$percent_free = round(($free_mem / $total_mem) * 100);
	$percent_used = round(($used_mem / $total_mem) * 100);
	$percent_swap = round((($total_swap - $free_swap ) / $total_swap) * 100);
	$percent_swap_free = round(($free_swap / $total_swap) * 100);
	$percent_buff = round(($buffer_mem / $total_mem) * 100);
	$percent_cach = round(($cache_mem / $total_mem) * 100);
	$used_mem = human_filesize($used_mem*1024,0);
	$used_swap = human_filesize($used_swap*1024,0);
	$total_mem = human_filesize($total_mem*1024,0);
	$free_mem = human_filesize($free_mem*1024,0);
	$total_swap = human_filesize($total_swap*1024,0);
	$free_swap = human_filesize($free_swap*1024,0);
	$buffer_mem = human_filesize($buffer_mem*1024,0);
	$cache_mem = human_filesize($cache_mem*1024,0);
	
	// disk space in kb
	exec("df -T -l -BKB", $diskfree);
	
	$count = 1;

	while ($count < sizeof($diskfree)) {

		list($drive[$count], $typex[$count], $size[$count], $used[$count], $avail[$count], $percent[$count], $mount[$count]) = split(" +", $diskfree[$count]);
		$percent_part[$count] = str_replace( "%", "", $percent[$count]);
		$count++;

	}

?>
<!-- PHP END -->

<h1 class="w3-text-teal">Dashboard</h1>
<div class="w3-row w3-border">
<div class="w3-container w3-half">
<div id="cpu-load" style="min-width: 310px; margin: 0 auto"></div>
<script type="text/javascript">
Highcharts.chart('cpu-load', {

    chart: {
        type: 'gauge',
        plotBackgroundColor: null,
        plotBackgroundImage: null,
        plotBorderWidth: 0,
        plotShadow: false
    },

    title: {
        text: 'CPU'
    },

    pane: {
        startAngle: -150,
        endAngle: 150,
        background: [{
            backgroundColor: {
                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                stops: [
                    [0, '#FFF'],
                    [1, '#333']
                ]
            },
            borderWidth: 0,
            outerRadius: '109%'
        }, {
            backgroundColor: {
                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                stops: [
                    [0, '#333'],
                    [1, '#FFF']
                ]
            },
            borderWidth: 1,
            outerRadius: '107%'
        }, {
            // default background
        }, {
            backgroundColor: '#EEE',
            borderWidth: 0,
            outerRadius: '105%',
            innerRadius: '103%'
        }]
    },

    // the value axis
    yAxis: {
        min: 0,
        max: 100,

        minorTickInterval: 'auto',
        minorTickWidth: 1,
        minorTickLength: 10,
        minorTickPosition: 'inside',
        minorTickColor: '#666',

        tickPixelInterval: 30,
        tickWidth: 2,
        tickPosition: 'inside',
        tickLength: 10,
        tickColor: '#666',
        labels: {
            step: 2,
            rotation: 'auto'
        },
        title: {
            text: '% used'
        },
        plotBands: [{
            from: 0,
            to: 50,
            color: '#55BF3B' // green
        }, {
            from: 50,
            to: 75,
            color: '#DDDF0D' // yellow
        }, {
            from: 75,
            to: 100,
            color: '#DF5353' // red
        }]
    },

    series: [{
        name: 'CPU-LOAD',
        data: [<?php echo $cpuload; ?>],
        tooltip: {
            valueSuffix: '% used'
        }
    }]

},
// Add some life
function (chart) {
    if (!chart.renderer.forExport) {
        setInterval(function () {
            var point = chart.series[0].points[0],
                newVal,
                inc = Math.round((Math.random() - 0.5) * 20);

            newVal = point.y + inc;
            if (newVal < 0 || newVal > 200) {
                newVal = point.y - inc;
            }

            point.update(newVal);

        }, 3000);
    }
});
</script>
</div> 

<div class="w3-container w3-half">		
<div id="container_ram" style="width: 300px; height: 200px; float: left"></div>
<div id="container_swap" style="width: 300px; height: 200px; float: left"></div>
<script type="text/javascript">
var gaugeOptions = {

    chart: {
        type: 'solidgauge'
    },

    title: null,

    pane: {
        center: ['50%', '85%'],
        size: '140%',
        startAngle: -90,
        endAngle: 90,
        background: {
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
            innerRadius: '60%',
            outerRadius: '100%',
            shape: 'arc'
        }
    },

    tooltip: {
        enabled: false
    },

    // the value axis
    yAxis: {
        stops: [
            [0.1, '#55BF3B'], // green
            [0.5, '#DDDF0D'], // yellow
            [0.9, '#DF5353'] // red
        ],
        lineWidth: 0,
        minorTickInterval: null,
        tickAmount: 2,
        title: {
            y: -70
        },
        labels: {
            y: 16
        }
    },

    plotOptions: {
        solidgauge: {
            dataLabels: {
                y: 5,
                borderWidth: 0,
                useHTML: true
            }
        }
    }
};

// The speed gauge
var chartSpeed = Highcharts.chart('container_swap', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 100,
        title: {
            text: 'SWAP'
        }
    },

    credits: {
        enabled: false
    },

    series: [{
        name: 'Swap',
        data: [<?php echo $percent_swap; ?>],
        dataLabels: {
            format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                   '<span style="font-size:12px;color:silver">% used</span></div>'
        },
        tooltip: {
            valueSuffix: '% used'
        }
    }]

}));

// The RPM gauge
var chartRpm = Highcharts.chart('container_ram', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 100,
        title: {
            text: 'RAM'
        }
    },

    series: [{
        name: 'RAM',
        data: [<?php echo $percent_used; ?>],
        dataLabels: {
            format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y:.1f}</span><br/>' +
                   '<span style="font-size:12px;color:silver">% used</span></div>'
        },
        tooltip: {
            valueSuffix: '% used'
        }
    }]

}));

// Bring life to the dials
setInterval(function () {
    // Speed
    var point,
        newVal,
        inc;

    if (chartSpeed) {
        point = chartSpeed.series[0].points[0];
        inc = Math.round((Math.random() - 0.5) * 100);
        newVal = point.y + inc;

        if (newVal < 0 || newVal > 200) {
            newVal = point.y - inc;
        }

        point.update(newVal);
    }

    // RPM
    if (chartRpm) {
        point = chartRpm.series[0].points[0];
        inc = Math.random() - 0.5;
        newVal = point.y + inc;

        if (newVal < 0 || newVal > 5) {
            newVal = point.y - inc;
        }

        point.update(newVal);
    }
}, 2000);
</script>
</div>
</div>

<div class="w3-row w3-border">
<div id="diskSpace" class="w3-container" style="padding: 0; margin: 0">
<?
for ($i = 1; $i < $count; $i++) {

			$total = human_filesize(intval(preg_replace("/[^0-9]/", "", trim($size[$i])))*1024,0);
			$usedspace = human_filesize(intval(preg_replace("/[^0-9]/", "", trim($used[$i])))*1024,0);
			$freespace = human_filesize(intval(preg_replace("/[^0-9]/", "", trim($avail[$i])))*1024,0);
			
			echo "\n\t\t\t<table class=\"w3-table-all\" style=\"width: 100%;\">";

			echo "\n\t\t\t\t<tr>";
			echo "\n\t\t\t\t\t<td class=\"w3-align-right\" colspan=\"2\" width=\"50%\" style=\"border-top-left-radius:5px;\">" . $total . "</td>";
			echo "\n\t\t\t\t\t<td class=\"w3-blue\" colspan=\"2\" width=\"50%\" style=\"border-top-right-radius:5px;\">" . $mount[$i] . " (" . $typex[$i] . ")</td>";
			echo "\n\t\t\t\t</tr>";
	
			echo "\n\t\t\t\t<tr>";
			echo "\n\t\t\t\t\t<td class=\"column1\">Used</td>";
			echo "\n\t\t\t\t\t<td class=\"w3-align-right\">" . $usedspace . "</td>";
			echo "\n\t\t\t\t\t<td class=\"column3\"><div class=\"w3-red\" style=\"width:" . $percent[$i] . "\"><div></td>";
			echo "\n\t\t\t\t\t<td class=\"w3-align-right\">" . $percent[$i] . "</td>";
			echo "\n\t\t\t\t</tr>";

			echo "\n\t\t\t\t<tr>";	
			echo "\n\t\t\t\t\t<td class=\"column1\" style=\"border-bottom-left-radius:5px;\">Free</td>";
			echo "\n\t\t\t\t\t<td class=\"w3-align-right\">" . $freespace . "</td>";
			echo "\n\t\t\t\t\t<td class=\"column3\"><div class=\"w3-red\" style=\"width:" . (100 - (floatval($percent_part[$i]))) . "%\"></td>";
			echo "\n\t\t\t\t\t<td class=\"w3-align-right\" style=\"border-bottom-right-radius:5px;\">" . (100 - (floatval($percent_part[$i]))) . "%</td>";
			echo "\n\t\t\t\t</tr>";

			echo "\n\t\t\t</table>";

		}
?>	
</div> <!-- w3-container -->
</div> <!-- <div class="w3-row w3-border"> -->
