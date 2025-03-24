# Demo Codeception project

## Prerequisites
- Install PHP on you local machine
- Download and install composer (more details here: https://getcomposer.org/download/)
- Install Selenium Server Standalone. At the moment, I have "selenium-server-standalone-3.5.3.jar" installed: https://selenium-release.storage.googleapis.com/index.html?path=3.5/
- Install Chromedriver. Make sure it is compatible with your OS and the version of your Chrome Browser: https://googlechromelabs.github.io/chrome-for-testing/#stable
- Install Git

## Installation of the repo

Clone this repository on your local machine:
``` 
git clone https://github.com/elenadaninamacovei/codeception_project_upgrade.git
```

Install Codeception & other necessary packages using composer:
``` 
composer install        OR        php composer.phar install
```
Check Codeception can be run with:
```
php vendor/bin/codecept
```
Build test classes:
```
php vendor/bin/codecept build
```

## Run demo API test
```
php vendor/bin/codecept run tests/Api/ExampleTests/FirstCest.php
```

## Run demo Acceptance test
Start ChromeDriver & Selenium server
```
java -Dwebdriver.chrome.driver=[PATH_TO_YOUR_CHROMEDRIVER]/chromedriver.exe -jar [PATH_TO_YOUR_SELENIUM_SERVER]/selenium-server-standalone-3.5.3.jar
```
Run demo Acceptance test
```
php vendor/bin/codecept run tests/Acceptance/ExampleTests/FirstCest.php
```
