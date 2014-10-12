ms-translator
==================

Translate text using the Bing Translate API

##Instruction

Translate your texts using Microsoft's Bing Translation services HTTP API http://msdn.microsoft.com/en-us/library/ff512419.aspx

The code is based on the one provided by Microsoft at the documentation, prepared for composer. In two lines, you can have a translation service working!

Before working with the code, get your Access Token, using your MSN account. More info at: http://msdn.microsoft.com/en-us/library/hh454950.aspx

Don't get confused with the clientID. It's not the Customer ID nor your account key. The clientID is the text (possibly your app name or some plain-language text) that you specified when registering your application. You can view your client id [here](https://datamarket.azure.com/developer/applications)

There is a free data tier of 2 million characters per month. Check [here](https://datamarket.azure.com/account/datasets) if you haven't used yet your monthly limit: 

## Installation


### With Composer
-------------
The easiest way to install is via [composer](http://getcomposer.org/). Create the following `composer.json` file and run the `php composer.phar` install command to install it.

```json
{
	---
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

$mt = new Gidkom\MsTranslator($client_id, $client_secret);

Translate to single language
return $bt->translate('Hello', 'en', 'fr');


Translate to multiple languagues 
return $mt->multiTranslate('Hello', 'en', ['fr','de']);

```

for a list of all supported languages and codes go to `public/ms-translator-language-codes.txt`