ms-translator
==================

[![Build Status](https://scrutinizer-ci.com/g/gidkom/ms-translator/badges/build.png?b=master)](https://scrutinizer-ci.com/g/gidkom/ms-translator/build-status/master)

Translate text using the Bing Translate API

##Instruction

Translate your texts using Microsoft's Bing Translation services HTTP API [http://msdn.microsoft.com/en-us/library/ff512419.aspx](http://msdn.microsoft.com/en-us/library/ff512419.aspx)

The code is based on the one provided by Microsoft at the documentation, prepared for composer. In two lines, you can have a translation service working!

Before working with the code, get your Access Token, using your MSN account. More info: [http://msdn.microsoft.com/en-us/library/hh454950.aspx](http://msdn.microsoft.com/en-us/library/hh454950.aspx)

Don't get confused with the clientID. It's not the Customer ID nor your account key. The clientID is the text (possibly your app name or some plain-language text) that you specified when registering your application. You can view your client id [https://datamarket.azure.com/developer/applications](https://datamarket.azure.com/developer/applications)

There is a free data tier of 2 million characters per month. Check [https://datamarket.azure.com/account/datasets](https://datamarket.azure.com/account/datasets) if you haven't used yet your monthly limit: 

## Installation


### With Composer
-------------
The easiest way to install is via [composer](http://getcomposer.org/). Create the following `composer.json` file and run the `php composer.phar` install command to install it.

```json
{
	...
    "require": {
        "gidkom/ms-translator": "dev-master"
    }
}
```

then the code

```php

include "vendor/autoload.php";

$client_id = 'abc';
$client_secret = 'xyz';

$mt = new Gidkom\MsTranslator\MsTranslator($client_id, $client_secret);

//Translate to single language
$from  = 'en';
$to = 'fr';
return $mt->translate('Hello world', $to, $from);

// To auto detect language leave out the $from argument
return $mt->translate('Hello world', $to);


Translate to multiple languagues 
$from = 'en';
$to= ['fr', 'de'];
return $mt->multiTranslate('Hello world', $to, $from);

```

for a list of all supported languages and codes go to `public/ms-translator-language-codes.txt`