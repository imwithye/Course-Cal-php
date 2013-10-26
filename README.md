Course Cal in PHP
======

Course Cal, works with NTU S.T.A.R.S planner.

## About
Course Cal can generate calendar which can be imported to Apple iCal, Google Calendar and Outlook Calendar with simply pasting course printable page url.

## Demo
Visit [http://ciel.im/course](http://ciel.im/course).

## Usage
Send printable page url to perform.php via post/get request.

## Options
You may enable error report with phpmailer following these steps:

1. In perform.php, delete <code>//</code> before <code>foreach</code> and <code>report</code>.
2. Set up mail.php following comments after each line.

## Contribute
* PHP Code - send pull request to master branch
* Web front - send pull request to gh-pages branch
