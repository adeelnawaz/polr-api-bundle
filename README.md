# Polr API Bundle

_(__Note:__ This version is not compatible with Symfony 3. Please use version [0.1.1](https://github.com/adeelnawaz/polr-api-bundle/releases/tag/0.1.1) for apps
running on Symfony 3)_

This bundle provides Polr API Client integration in Symfony (4|5). This bundle is simply a wrapper over PHP package
`adeelnawaz/polr-api-client`. The bundle exposes a service `PolrApiService` that can be utilized to call API methods of
the `PolrApi` class from API Client package.

## Installation

### Step 1: Configuration
Create a configuration file in your `config` directory named `polr_api.yml` containing the following configuration:
```yaml
polr_api:
  api_url: '%env(POLR_API_URL)%'
  api_key: '%env(POLR_API_KEY)%'
  api_quota: '%env(int:POLR_API_QUOTA)%'
```

In `.env[.*]` file, add the following environment variables

```dotenv
POLR_API_URL=https://your-polr-app.com
POLR_API_KEY=your_polr_api_key
POLR_API_QUOTA=0 # Set to zero for unlimited
```

__Note:__ The `POLR_API_QUOTA` value makes sure that your application separates the API calls with enough delay that you
don't exceed your calls/minute quota. If you specify a smaller value than your API key's actual quota then you will get
an error from your Polr API.

### Step 2: Install via Composer
In your console, navigate to your Symfony project directory and execute the
following command to download the latest stable version of this package:

```console
$ composer require adeelnawaz/polr-api-bundle
```

### Step 3: Enable the Bundle
For apps with Symfony Flex, this step is not needed. Otherwise add the bundle to the list of registered bundles in
`config/bundles.php`:

```php
<?php
// config/bundles.php

return [
    ...,
    Adeelnawaz\PolrApiBundle\PolrApiBundle::class => ['all' => true],
];
```

All done!

## Usage

In order to consume the API, use the service `PolrApiService`. Create DTO object(s)
(`Adeelnawaz\PolrApiClient\DTO\Link`, etc) for the method you
intend to use and call the method. This will result in calling the respective REST API
endpoint and returning the relative `Adeelnawaz\PolrApiClient\DTO\Response` object.  
_(See Docblocks of the `PolrApiService` methods for further information on input/output DTOs)_

In case of a failed API call, the `PolrApiService` methods throw `Adeelnawaz\PolrApiClient\Exception\ApiResponseException`. The
exception has getters for `code`, `message`, and a machine readable short string
`error_code` returned by the Polr REST API.

Example controller:

```php
<?php

namespace App\Controller;

use Adeelnawaz\PolrApiBundle\Service\PolrApiService;
use Adeelnawaz\PolrApiClient\DTO\Link;
use Adeelnawaz\PolrApiClient\Exception\ApiResponseException;

class DefaultController extends AbstractController
{
    public function indexAction(PolrApiService $api)
    {
        // Prepare DTO for API method input
        $link = new Link();
        $link->setUrl('https://www.google.com/search?tbm=isch&source=hp&biw=1863&bih=916&ei=IksNW5eLHqzisAfvgKKQBg&q=samurai+jack&oq=samurai+jack&gs_l=img.3..0l10.799.2671.0.2891.13.10.0.3.3.0.54.372.9.9.0....0...1ac.1.64.img..1.12.380.0...0.NlHgI6Y6mmY')
            ->setIsSecret(true);
            
        try {
            $responseLink = $api->shortenLink($link);
        
            print_r($responseLink);
        } catch (ApiResponseException $e) {
            echo "Error: ({$e->getCode()} - {$e->getErrorCode()}) \"{$e->getMessage()}\"\n";
        }
    }
}
```
### See also  
Polr API Client [Documentation](https://github.com/adeelnawaz/polr-api-client/blob/master/README.md).