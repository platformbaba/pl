<?php

include_once 'WURFL_LIB/wurfl/examples/demo/inc/wurfl_config_standard.php';

$wurflInfo = $wurflManager->getWURFLInfo();
if (isset($_GET['ua']) && trim($_GET['ua'])) {
	$ua = $_GET['ua'];
	$requestingDevice = $wurflManager->getDeviceForUserAgent($_GET['ua']);
} else {
	$ua = $_SERVER['HTTP_USER_AGENT'];
	// This line detects the visiting device by looking at its HTTP Request ($_SERVER)
	$requestingDevice = $wurflManager->getDeviceForHttpRequest($_SERVER);
}
?>

<html>
<head>

<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
</head>


<body>

Audio
<table style="width:300px">
<th>
	<td>Content Name</td>
	<td>Download link</td>
	<td>Stream link</td>
<tr>
  <td>Jill</td>
  <td>Smith</td>
  <td>50</td>
</tr>
<tr>
  <td>Eve</td>
  <td>Jackson</td>
  <td>94</td>
</tr>
</table> 

<br>

Video
<table style="width:300px">
<th>
	<td>Content Name</td>
	<td>Download link</td>
	<td>Stream link</td>
<tr>
  <td>Jill</td>
  <td>Smith</td>
  <td>50</td>
</tr>
<tr>
  <td>Eve</td>
  <td>Jackson</td>
  <td>94</td>
</tr>
</table> 

<div id="content">
		User Agent: <b> <?php echo htmlspecialchars($ua); ?> </b>
		<ul>
			<li>ID: <?php echo $requestingDevice->id; ?> </li>
			<li>Brand Name: <?php echo $requestingDevice->getCapability('brand_name'); ?> </li>
			<li>Model Name: <?php echo $requestingDevice->getCapability('model_name'); ?> </li>
			<li>Marketing Name: <?php echo $requestingDevice->getCapability('marketing_name'); ?> </li>
			<li>Preferred Markup: <?php echo $requestingDevice->getCapability('preferred_markup'); ?> </li>
			<li>Resolution Width: <?php echo $requestingDevice->getCapability('resolution_width'); ?> </li>
			<li>Resolution Height: <?php echo $requestingDevice->getCapability('resolution_height'); ?> </li>
		</ul>
		<p><b>Query WURFL by providing the user agent:</b></p>
		<form method="get" action="index.php">
			<div>User Agent: <input type="text" name="ua" size="100" value="<?php echo isset($_GET['ua'])? htmlspecialchars($_GET['ua']): ''; ?>" />
			<input type="submit" /></div>
		</form>
	</div>

<script>
	$.get( "/cds/audio?actiontype=get_all_audio&start=0&limit=10", function( data ) {
		alert( data );
		});
</script>
</body>


<html>
