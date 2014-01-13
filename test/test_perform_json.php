<?php
	$json_auto_mode = '{
			"mode" : "auto",
			"unique_id" : "auto_mode",
			"tz" : "Asia/Singapore",
			"filename": "Course-Cal",
			"year" : "2013",
			"sem" : "2",
			"courses" : [
					{
						"code" : "CZ2006",
						"index" : "10271",
						"examTime" : {
							"year" : "2014",
							"month" : "jan",
							"day" : "1",
							"startTime" : "0800",
							"endTime" : "0900"
							}
					},
					{
						"code" : "CZ2007",
						"index" : "10281"
					}
				]
		}';
		
	$json_manual_mode  = '{
			"mode" : "manual",
			"unique_id" : "manual_mode",
			"tz" : "Asia/Singapore",
			"filename": "Course-Cal",
			"year" : "2013",
			"sem" : "2",
			"courses" : [
					{
						"code" : "CI1011",
						"index" : "314159",
						"name" : "I love Ciel",
						"au" : "3 au",
						"examTime" : {
							"year" : "2014",
							"month" : "jan",
							"day" : "1",
							"startTime" : "0800",
							"endTime" : "0900"
							},
						"lessons" : [
								{
									"type" : "LEC",
									"group" : "FSP2",
									"time" : {
											"startTime" : "0830",
											"endTime" : "0930",
											"wkDay" : "mon"
										},
									"venue" : "LT2A",
									"remark" : "wk2-4,5,8-9"
								}
							]
					}
				]
		}';
		
	echo '
		<html xmlns="http://www.w3.org/1999/xhtml" >
		<head>
			<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
			<script>
				function submit_json(form) {
					var data = '.$json_auto_mode.';
					var json_string = JSON.stringify(data);
					$("#json").val(json_string);
					form.submit();
				}
			</script>
		</head>
		<body>
			<form action="../perform.php" method="post" onsubmit="submit_json(this)">
				<input name="json" id="json" hidden></input>
				<input type="submit"></input>
			</form>
		</body>
	';
?>