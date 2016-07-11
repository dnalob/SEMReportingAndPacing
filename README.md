# SEMReportingAndPacing

PHP driven tool that downloads SEM reports from the Google Adwords, Bing Ads, and Yahoo Gemini APIs, extracts PPC data, then inserts data into Google Sheets spreadsheet using the Google Sheets API; complete with GUI and dynamic account list.

![wizard](https://hiduth.com/wp-content/uploads/2015/06/witchcraft-wizards.jpg)

## Libraries Used

* [Google Ads API PHP Client Library](https://github.com/googleads/googleads-php-lib)
* [Bing Ads API in PHP](https://code.msdn.microsoft.com/Bing-Ads-API-Version-9-in-fb27761f)
* [Yahoo Gemini API](https://gist.github.com/ydn/043bd44bfe5fe8b0c1be)
* [PHP Google Spreadsheet Client](https://github.com/asimlqt/php-google-spreadsheet-client)
* [Google APIs Client Library for PHP](https://github.com/google/google-api-php-client)
* [PHPExcel](https://github.com/PHPOffice/PHPExcel)
* [PHPMailer](https://github.com/PHPMailer/PHPMailer)

## Motivation

Pacing is a task that the SEM account managers in my agency have to perform every few days. It requires accessing PPC metrics of each account, namely Spend and Clicks, then inserting them into a Google Sheets file. The account managers then perform a series of calculations to determine whether to increase or decrease their budgets. This is my attempt to automate most of this process.

## Installation

Everything should be there, although you might need to add the Guzzle HTTP dependency because I had to delete it from the project in order to commit.
