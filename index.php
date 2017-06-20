<?php
	require_once('endpoints/phoneFunctions.php');
	$phoneInfoData = null;
	if(!empty($_GET) && $_GET['phone']){
		$phoneInfoData = requestBasicPhoneData($_SERVER, $_GET);
		//echo print_r($phoneInfoData, 1);
	}	

?>

<!DOCTYPE html>
<html>
	<head>
		<title>PHP Test</title>
	</head>
	<body>

		<?php if($phoneInfoData !== null): ?>
			<table>
				<thead>
					<th>Full Name</th>
					<th>State</th>
				</thead>
				<tbody>
					<?php foreach($phoneInfoData as $key => $value): ?>
						<tr>
							<td><?= (!empty($value->firstname)?$value->firstname:"No First Name") ?> <?= (!empty($value->lastname)?$value->lastname:"No First Name") ?></td>
							<td><?= (!empty($value->state)?$value->state:"No State Available") ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<br>
			<br>
			<span>Search again?</span>
		<?php endif; ?>
		<form action="/index.php" method="get">
			Phone Number: <input type="text" name="phone"><br>
			<input type="submit">
		</form>






 	<script type="text/javascript">

		// function getCourierServices(){
		// 	$.ajax({
		// 		url: "/endpoints/testFunc",
		// 	}).done(function(data) {
		// 		console.log(data);
		// 	});
		// }
		// getCourierServices();


		// function getCourierServices(){
		// 	courierSelect = $('#ship-courier');
		// 	courierValue = courierSelect.val();
		// 	// console.log(courierValue);
		// 	$.ajax({
		// 		url: "/admin/ajax/getCourierServices/" + courierValue,
		// 	}).done(function(data) {
		// 		courierSelect = $('#ship-courier-service');
		// 		courierSelect.html("<option value='null'>Please Choose a Service</option>");
		// 		$.each(data, function(val, text) {
		// 			courierSelect.append(
		// 				$('<option></option>').val(val).html(text)
		// 			);
		// 		});
		// 	});
		// 	if(courierValue == 1){
		// 		$('#userLabelContainer').html("<label for=\"{{ trans("app.tracking_code") }}\">{{ trans("app.tracking_code") }}</label>: <input type=\"text\" name=\"tracking_code\">");
		// 	} else {
		// 		$('#userLabelContainer').html('');
		// 	}
		// }

	</script>
 </body>
</html>