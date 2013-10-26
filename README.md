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
If you don't want to install this app, you may send GET/POST request to [http://course-cal.appspot.com/perform.php](http://course-cal.appspot.com/perform.php). It works as well. More details please visit [here](https://github.com/imwithye/course/blob/gh-pages/index.html).

***Current API Version 1.0.2***

## Change log
* Remove PHPMailer
* Works with GAE. app.yml, GAE mail API added
* Send report automatically

## Contribute
* PHP Code - send pull request to master branch
* Web front - send pull request to gh-pages branch