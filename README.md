Course Cal in PHP
======

Course Cal, works with NTU S.T.A.R.S planner.

## About
Course Cal can generate calendar which can be imported to Apple iCal, Google Calendar and Outlook Calendar with simply pasting course printable page url.

## Demo
Visit [http://ciel.im/course](http://ciel.im/course).

## Usage
* Change app.yaml to your own settings (works with GAE).
* Change mail.php to your own settings (works with GAE).
* Send printable page url to perform.php via post/get request.

## API

###By Printable Page url
If you don't want to install this app, you may send GET/POST request to [http://course-cal.appspot.com/perform.php](http://course-cal.appspot.com/perform.php). It works as well. More details please visit [here](https://github.com/imwithye/course/blob/gh-pages/index.html).

###JSON
You can create Course Cal by yourself with JSON. There are two modes - auto or manual.

**Auto mode**. Course Cal can create event automatically with course code and index (may slower than manual mode).

**Manual mode**. Course Cal can create event automatically with course information (need more information than auto mode).

```JavaScript
var json_auto_mode = '{
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

var json_manual_mode  = '{
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

***Current API Version 1.0.2***

## Change log
* Remove PHPMailer
* Works with GAE. app.yml, GAE mail API added
* Send report automatically

## Contribute
* PHP Code - send pull request to master branch
* Web front - send pull request to gh-pages branch