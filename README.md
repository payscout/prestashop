# Payscout 2.0 Payment Gateway for prestashop 1.5 and above
-------
``This plugin is released under the GPL license.``

**If you have any questions or issues, feel free to contact our technical support: support@payscout.com or victor@payscout.com
you can also contact our 24X7 phone support - Tel: 1.888.689.6088

## Table of Contents

1. [Features](#features)
1. [Prerequisites](#prerequisites)
1. [Installation](#installation)
    * [Installing Manually](#installing-manually)
    * [Installing with Prestashop Installer](#installing-with-prestashop-installer)
1. [Configuration](#configuration)

##Features
Payscout Gateway allow payment option and enables you to process the following operations from your eshop:

* Allow customer to make online payment for there order
* Receive or canceling a payment order
* Conducting a refund operation

##Prerequisites

**Important:** This plugin works only with REST API.

The following PHP extensions are required:

* [cURL][ext2] to connect and communicate to many different types of servers with many different types of protocols.
* [hash][ext3] to process directly or incrementally the arbitrary length messages by using a variety of hashing algorithms.

##Installation

There are two ways in which you can install the plugin:

* [manual installation](#installing-manually) by copying and pasting folders from the repository
* [Prestashop Extension Installer](#installing-with-prestashop-installer) from the administration page

See the sections below to find out about steps for each of the procedures.

###Installing Manually

To install the plugin manually, simply extract zip folder and copy folders and files and refresh the list of admin payment method sections:

1. Copy the folders from [the plugin repository][ext1] to your prestashop root folder on the server.
2. Go to module and services **> Payment and Gateway **> Payscout Inc Direct ** Click to install
3. Now click on configuation and complete the configuration detail and make it enable.

###Installing with Prestashop automatic install 

**Before you start**<br />
It is recommended to always backup your installation prior to use.

1. Go to Prestashop administration page [http://your-prestashop-url/admin-url].
2. Go to **Module & Services **> **Payment & Gateways **> Click on add new module.
3. Now select a zip file and click to upload this module.<br /> 
4. Now go to Module & Services **> **Payment & Gateway **> Payscout Inc Direct **> Click to install
5. Click on configuration and complete configuration details.

  
##Configuration

Independently of the installation method, the configuration looks the same:

1. Go to the Prestashop administration page [http://your-prestashop-url/admin-url].
2. Go to **Module & Services** > Payment & Gateway **> Payscout Inc **> **Configuration** window. 
3. Click ![save_config][img2] in the top right corner of the page.

### Configuration Parameters

The tables below present the descriptions of the configuration form parameters.

#### Main parameters

The main parameters for plugin configuration are as follows:

| Parameter | Values | Description | 
|:---------:|:------:|:-----------:|
|Environment|Live/Test|Specifies whether the module is live mode or test mode.|

#### POS parameters

To check the values of the parameters below, go to **Merchant Administration Panel and check the following details:

| Parameter | Description | 
|:---------:|:-----------:|
|Client Username|Merchant login username|
|Client Password|Merchant password|
|Client Token|Client token provided by payscout|

<!--LINKS-->

<!--topic urls:-->

<!--images:-->


[img2]: https://github.com/payscout/prestashop/blob/master/save_config.png