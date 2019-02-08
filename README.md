# Intelipost PHP Client Library

Intelipost is a simple, fast and secure shipping and logistics gateway API. You can sign up for an account at http://www.intelipost.com.br

Installation
------------
There are two ways to install:

 **Require Library**

```php
require_once("/path/to/lib/intelipost.php");
```

**or via [Composer](http://getcomposer.org/):**

Create or add the following to composer.json in your project root:
```javascript
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/intelipost/sdk-php"
        }
    ],
    "require": {
        "intelipost/api-php": "dev-master"
    }
}
```

Install composer dependancies:
```shell
php composer.phar install
```

Require dependencies:
```php
require_once("/path/to/vendor/autoload.php");
```

Documentation
--------------------
Up-to-date documentation at: http://docs.intelipost.com.br


Releases
--------------------
## 1.0.1
*2016-02-10 | Intelipost*

- Origin zip code to create a shipment order
- ApiKey as parameter on LoadConfigs method

## 1.0.0
*2015-09-30 | Intelipost*

- Get CEP - Auto Complete
- Get Activated Delivery Methods
- Get Quote
- Quote by Volume
- Get Label
- Create Shipment Order
- Get Shipment Order
- Cancel Shipment Order
- Mark Multiple Shipment Orders as "Shipped"
- Mark Multiple Shipment Orders as "Ready for Shipment"
- Webhook

## 0.3.4
*2014-07-07 | Pablo del Vecchio*

- changed basic log format


## 0.3.3
*2014-07-07 | Pablo del Vecchio*

- added round_trip network time


## 0.3.2
*2014-06-23 | Pablo del Vecchio*

- added response model


## 0.3.0
*2014-04-28 | Pablo del Vecchio*

- updated quote example


## 0.2.3
*2014-03-24 | Pablo del Vecchio*

- changed base folder


## 0.2.2
*2014-03-18 | Pablo del Vecchio*

- updated composer.json


## 0.2.1
*2014-03-18 | Pablo del Vecchio*

- added timeout fallback


## 0.1.0
*2014-03-11 | Pablo del Vecchio*

- initial commit
