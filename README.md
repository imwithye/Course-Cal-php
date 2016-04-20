Course Cal in PHP
======

### This repo is no longer maintained. Visit [https://github.com/imwithye/NTUSTARS](https://github.com/imwithye/NTUSTARS) to get more information.

Check the Chrome extension, [http://bit.ly/course-cal](http://bit.ly/course-cal)

***<font color="red">Developing tree is master. You don't have to hack master tree normally. Please download [release version](https://github.com/imwithye/course/releases) if you want to host Course Cal yourself.</font>***

Course Cal, works with NTU S.T.A.R.S planner.

## About
Course Cal can generate calendar which can be imported to Apple iCal, Google Calendar and Outlook Calendar with simply pasting course printable page url.

## Demo
Visit [http://ciel.im/course](http://ciel.im/course).

## Host by yourself
* Change app.yaml to your own settings (works with GAE).
* Change mail.php to your own settings (works with GAE).
* Send printable page url to perform.php via post/get request.

You can host it with any php server, but mail.php can only work with GAE.

## API

### By Printable Page url
You may send GET/POST request to  `perform.php`(You can also send post request to [http://course-cal.appspot.com/perform.php](http://course-cal.appspot.com/perform.php)). `perform.php` get JSON string from `json`: 

```PHP
$json_data = array_key_exists('json', $_REQUEST) ? $_REQUEST['json'] : null;
```
So you may have a hidden input named `json`, and use it to send data.

```HTML
<input type="hidden" name="json" id="json" value="">
```

Submit by

```JavaScript
$('input#submit').click(function(){
        var json = {'url': $('input#url').val()};
        var element = document.getElementById("json");
        element.value = JSON.stringify(json);
        element.form.submit();
});
```

### JSON
You can create Course Cal by yourself with JSON. You shold post the JSON string as `json` as well. An example is [here](https://github.com/imwithye/course/blob/master/test/test_perform_json.php). You can send JSON string using the same method with printable page url. **Note that if there is `url` in JSON string, all other things will be ignored**. There are two modes - auto or manual.

**Auto mode**. Course Cal can create event automatically with course code and index (may slower than manual mode).

**Manual mode**. Course Cal can create event automatically with course information (need more information than auto mode).

```JavaScript
var json_auto_mode = {
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
		};

var json_manual_mode  = {
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
		};
```

1. `mode`: **optional, set to `auto` by default**.
2. `unique_id`: **optional, set to random number by default**.
3. `tz`: **optional, set to `Asia/Singapore` by default**.
4. `filename`: **optional, set to `Course_Cal_file` by default**.
5. `year` and `sem`: **necessary**. `year` and `sem` are used to get the semester information. `year = 2013 sem = 1` means second half year of 2013, and `year = 2013 sem = 2` means first half year of 2014.
6. `courses`: **necessary**. `courses` is an array which contains all courses.

	1. Auto mode:
		
		1. `code`: **necessary**.
		2. `index`: **necessary**.
		3. `examTime`: **optional**, but if you set this, you have to set all properties.
	
	2. Manual mode:
		
		1. `code`: **necessary**.
		2. `index`: **optional**.
		3. `name`: **optional**.
		4. `au`: **optional**.
		5. `examTime`: **optional**, but if you set this, you have to set all properties.
		6. `lessons`: **optional**, `lessons` is an array which contains all lessons. if you set this, you should follow:
		
			1. `type`: **optional, set to '' by default**.
			2. `group`: **optional, set to '' by default**.
			3. `time`: **necessary**, you have to point out start time, end time and week day.
			4. `venue`: **optional, set to '' by default**.
			5. `remark`: **optional, set to 'Invalid' by default**. `remark` is used to get week repeat information (jump recess week automatically). If `remark` is '', this lesson will repeat every week. `remark` accept these kinds of syntax: `wk2-13`, `wk2,3,4,5`, `wk2-4,6,8,9-10`.

***Current API Version 1.1.2***

***Last stable API Version 1.1.2***

## Change log
* API changes

## Contribute
* PHP Code - send pull request to master branch
