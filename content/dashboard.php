<h1 class="w3-text-teal">Dashboard</h1> 
<div class="w3-text-teal w3-margin-top">

<?php

$xml = simplexml_load_file('http://192.168.11.20/localNET/includes/linfo/?out=xml');
$json_string = json_encode($xml);
$result_array = json_decode($json_string, TRUE);

#print_r($result_array);

# CORE
$os=$result_array[core][os];
$kernel=$result_array[core][kernel];
$uptime=$result_array[core][uptime];
$hostname=$result_array[core][hostname];
$cpu=$result_array[core][cpus];
$ip=$result_array[core][accessed_ip];
$processes=$result_array[core][processes];
$threads=$result_array[core][threads];
$loads=$result_array[core][loads];

# MEMORY
$mem_phy_free=$result_array[memory][Physical][free]/1024;
$mem_phy_total=$result_array[memory][Physical][total]/1024;
$mem_phy_used=$result_array[memory][Physical][used];
$swap_free=$result_array[memory][swap][core][free];
$swap_total=$result_array[memory][swap][core][total];
$swap_used=$result_array[memory][swap][core][used];
$swap_devices=$result_array[memory][swap][devices][device];

# NET INTERFACES

# DEVICES DEVICE

# DRIVES

# MOUNTS

?>

	<div class="w3-padding w3-margin">
		<div class="w3-third">
			<div class="w3-card-4 w3-blue">
			<div class="w3-container w3-blue"><p><?php echo $hostname; ?></p></div>
			<footer class="w3-container w3-white"><p><?php echo $ip; ?></p></footer>
		</div></div>

		<div class="w3-third">
			<div class="w3-card-4 w3-blue">
			<div class="w3-container w3-blue"><p><?php echo $mem_phy_free."/".$mem_phy_total." RAM"; ?></p></div>
			<footer class="w3-container w3-white"><p><?php echo $loads; ?></p></footer>
		</div></div>

		<div class="w3-third">
			<div class="w3-card-4 w3-blue">
			<div class="w3-container w3-blue"><p><?php echo $os." ".$kernel; ?></p></div>
			<footer class="w3-container w3-white"><p><?php echo $cpu; ?></p></footer>
		</div></div>
	</div>

</div>