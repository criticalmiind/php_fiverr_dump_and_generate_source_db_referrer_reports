# PHP Fiverr Task Setup Guide

## MYSQL Setup:
* create database in mysql phpmyadmin
* import ```dump_db.sql``` file

## PHP code Setup
* change ```DumpDatabase``` credetials in ```project_name/conn/config.php``` file
  ```php
  class DumpDatabase {
		private $host = "localhost";
		private $db_name = "fiverr_referers";
		private $username = "root";
		private $password = "";
		public $conn;
    ....
  }
  ```
* live php code

## Project Usage Guidelines
* visit your project url e.g ```http://127.0.0.1:8080/fiverr_referral_reports/```
* add source db credentials and table with table primery id key, public id key and referral id key
* check connection with db
* next Create User Referer Report by user id and no of tier(tree level)
* after creating you will see reports in table with state pending, processing or done(view report and delete report option)
* you can also view report by click on view report and download as an csv file
* ```user_referrer_cron.php``` file is your cron file which will execute in backgroud(by linux crontab command)
