kohana-xero
===========

API wrapper for Xero.com.

## Running tests / contributing

KohanaXero uses PHPSpec and Mockery for it's testing suite. These are pulled in with Composer:

	php composer.phar install

This will install composer. Run the specs with:

	./phpspec-composer.php specs -f d -b -c --bootstrap specs/bootstrap.php

If you are contributing to KohanaXero, you must include specs with your contribution.