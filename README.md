# forecast.io Symfony2 bundle

## Description
[forecast.io](https://developer.forecast.io/) library, handily packaged as a Symfony2 bundle

## Installation
We made this easily installable as a composer dependency. Not yet publihed on packagist, so please bear with us the extra step for now.

Open up your `composer.json` file, add the `cti/forecast-io-bundle` in the `require` section; also ensure you have in defined the `repositories` section. Below is a sample of how the composer should look like after the changes:
```json
{
	...
	"require" : {
		...
		"cti/forecast-io-bundle" : "dev-master",
		...
	},

    "repositories" : [
    	...
		{
		    "type" : "vcs",
		    "url" : "git@github.com:lolaent/forecast-io-bundle.git"
		}
		...
    ],
    ...	
}
```

# Developer notes

## Prepare local environment
```bash
# start fresh
rm -rf composer.lock vendor

# get dependencies
composer install
```

## Run tests
```bash
./vendor/bin/phpunit Tests/
```

Output should be similar to
```
➜  ./vendor/bin/phpunit Tests
PHPUnit 4.2.4 by Sebastian Bergmann.

.

Time: 345 ms, Memory: 6.50Mb

OK (1 test, 30 assertions)
```
