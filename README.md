# Polr API Bundle

This bundle provides Polr API Client integration in Symfony. This bundle is simply a wrapper over PHP package
`adeelnawaz/polr-api-client`. The bundle exposes a service `PolrApiService` that can be utilized to call API methods of
the `PolrApi` class from API Client package.

## Installation via composer

### Step 1: Download the Bundle
In your console, navigate to your Symfony project directory and execute the
following command to download the latest stable version of this package:

```console
$ composer require adeelnawaz/polr-api-bundle
```

### Step 2: Enable the Bundle

Enable the bundle by adding it to the list of registered bundles in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new \Adeelnawaz\PolrApiBundle\PolrApiBundle(),
        );

        // ...
    }

    // ...
}
```

### Step 3: Add parameters
Make sure you've setup the following parameters in your project's `parameters.yml`:  

```
polr_api_url
polr_api_key
polr_api_quota
```

and your `config.yml` has:

```
# Polr API bundle
polr_api:
      api_url: '%polr_api_url%'
      api_key: '%polr_api_key%'      
      api_quota: '%polr_api_quota%'      
``` 

## Usage

In order to consume the API, use the service `PolrApiService`. Create DTO object(s) (`Adeelnawaz\PolrApiClient\DTO\Link`, etc) for the method you
intend to use and call the method. This will result in calling the respective REST API
endpoint and returning the relative `Adeelnawaz\PolrApiClient\DTO\Response` object.  
_(See Docblocks of the `PolrApiService` methods for further information on input/output DTOs)_

In case of a failed API call, the `PolrApiService` methods throw `Adeelnawaz\PolrApiClient\Exception\ApiResponseException`. The
exception has getters for `code`, `message`, and a machine readable short string
`error_code` returned by the Polr REST API.

Example:

```

// In a controller or container aware class
$api = $this->get('polr_api.api_service');

// Prepare DTO for API method input
$link = new \Adeelnawaz\PolrApiClient\DTO\Link();
$link->setUrl('https://www.google.com/search?tbm=isch&source=hp&biw=1863&bih=916&ei=IksNW5eLHqzisAfvgKKQBg&q=samurai+jack&oq=samurai+jack&gs_l=img.3..0l10.799.2671.0.2891.13.10.0.3.3.0.54.372.9.9.0....0...1ac.1.64.img..1.12.380.0...0.NlHgI6Y6mmY')
    ->setIsSecret(true);

try {
    /**
     * @var \Adeelnawaz\PolrApiClient\DTO\Response\Link $responseLink
     */
    $responseLink = $api->shortenLink($link);

    print_r($responseLink);
} catch (\Adeelnawaz\PolrApiClient\Exception\ApiResponseException $e) {
    echo "Error: ({$e->getCode()} - {$e->getErrorCode()}) \"{$e->getMessage()}\"\n";
}
```
### See also  
Polr API Client [Documentation](https://github.com/adeelnawaz/polr-api-client/blob/master/README.md).