*Unmaintained*, sorry! Since composer makes package management so simple I feel the concept of adapting the Xero PHP API wrapper for Kohana is unnecessary. 

kohana-xero
===========

API wrapper for Xero.com.

## Running tests / contributing

KohanaXero uses PHPSpec and Mockery for it's testing suite. These are pulled in with Composer:

	php composer.phar install

This will install composer. Run the specs with:

	./phpspec-composer.php specs -f d -b -c --bootstrap specs/bootstrap.php

If you are contributing to KohanaXero, you must include specs with your contribution.

You will need to set up public and private keys:

    http://blog.xero.com/developer/api-overview/setup-an-application/

Xero API limits

    1000 API calls per day
    60 oauth token accesses per minute
    3.5 MB maximum per request

    ## Request Size Limit
    A single POST to the API has a size limit of 3.5MB. There is no limit to the number of elements within a request, provided the overall request size does not exceed 3.5MB.
    However, to ensure you receive a timely response from the API (large inserts can take quite a while), we recommend you look to batch elements in bundles of up to 50.
