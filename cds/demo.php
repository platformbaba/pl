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

<script>
	$.get( "/cds/audio?actiontype=get_all_audio&start=0&limit=10", function( data ) {
		alert( data );
		});
</script>
</body>


<html>
