<?php

include_once 'classes/x/config.php';
include_once 'classes/x/core.php';
include_once 'classes/x.php';

class DescribeXero extends \PHPSpec\Context {

    protected $_xero_config;

    public function before()
    {
        $config = Mockery::mock('X_Config');
        $config->shouldReceive('consumer_key')->andReturn('SKPJVCYEIXN7BYC6SOP5MYSEBZ2NDZ');
        $config->shouldReceive('consumer_secret')->andReturn('NCL9NWEMN0CUHKFEIJBMUIK9E5LZGJ');
        $config->shouldReceive('cert_path_public')->andReturn('/home/vagrant/ssl/publickey.cer');
        $config->shouldReceive('cert_path_private')->andReturn('/home/vagrant/ssl/privatekey.pem');
        $this->_xero_config = $config;
    }

	public function itShouldInstantiateWithoutException()
	{
        X::factory($this->_xero_config);
	}
    
    public function itShouldCreateAContact()
    {
        $xero = X::factory($this->_xero_config);

        $new_contact = array(
            array(
                'CustomerNumber' => 'CUST1',
                'Name' => 'Garfield',
                'FirstName' => 'Garfield',
                'LastName' => 'Jon',
                'Addresses' => array(
                    'Address' => array(
                        array(
                            'AddressType' => 'POBOX',
                            'AddressLine1' => 'PO Box 100',
                            'City' => 'Mombasa',
                            'PostalCode' => '3890'
                        ),
                        array(
                            'AddressType' => 'STREET',
                            'AddressLine1' => '1 Some Street',
                            'City' => 'Someville',
                            'PostalCode' => '3890'
                        )
                    )
                )
            )
        );

        //create the contact
        $result = $xero->contacts($new_contact);

        var_dump($result);
    }

    public function itShouldThrowExceptionWhenCreatingInvalidContact()
    {
        $xero = X::factory($this->_xero_config);

        $new_contact = array();

        //create the contact
        $result = $xero->contacts($new_contact);

        var_dump($result);
    }

    public function ignore()
    {
        if($_REQUEST['sample']==""){
            //the input format for creating a new contact see http://blog.xero.com/developer/api/contacts/ to understand more
            $new_contact = array(
                array(
                    "Name" => "API TEST Contact",
                    "FirstName" => "TEST",
                    "LastName" => "Contact",
                    "Addresses" => array(
                        "Address" => array(
                            array(
                                "AddressType" => "POBOX",
                                "AddressLine1" => "PO Box 100",
                                "City" => "Someville",
                                "PostalCode" => "3890"
                            ),
                            array(
                                "AddressType" => "STREET",
                                "AddressLine1" => "1 Some Street",
                                "City" => "Someville",
                                "PostalCode" => "3890"
                            )
                        )
                    )
                )
            );

            //create the contact
            $contact_result = $xero->Contacts( $new_contact );

            //the input format for creating a new invoice (or credit note) see http://blog.xero.com/developer/api/invoices/
            $new_invoice = array(
                array(
                    "Type"=>"ACCREC",
                    "Contact" => array(
                        "Name" => "API TEST Contact"
                    ),
                    "Date" => "2010-04-08",
                    "DueDate" => "2010-04-30",
                    "Status" => "AUTHORISED",
                    "LineAmountTypes" => "Exclusive",
                    "LineItems"=> array(
                        "LineItem" => array(
                            array(
                                "Description" => "Just another test invoice",
                                "Quantity" => "2.0000",
                                "UnitAmount" => "250.00",
                                "AccountCode" => "200"
                            )
                        )
                    )
                )
            );

            //the input format for creating a new payment see http://blog.xero.com/developer/api/payments/ to understand more
            $new_payment = array(
                array(
                    "Invoice" => array(
                        "InvoiceNumber" => "INV-0002"
                    ),
                    "Account" => array(
                        "Code" => "[account code]"
                    ),
                    "Date" => "2010-04-09",
                    "Amount"=>"100.00",
                )
            );


            //raise an invoice
            $invoice_result = $xero->Invoices( $new_invoice );

            $payment_result = $xero->Payments( $new_payment );

            //get details of an account, with the name "Test Account"
            $result = $xero->Accounts(false, false, array("Name"=>"Test Account") );
            //the params above correspond to the "Optional params for GET Accounts" on http://blog.xero.com/developer/api/accounts/
            //to do a GET request, all params are optional
            //first param optional should be a boolean "false" or a string AccountID,
            //second param  should be a date/time, in any format
            //third param can be an array of filters, with array keys being filter fields (left of operand), and array values
            //being the right of operand values.  The array value can be a string or an array(operand, value), or a boolean
            //the whole third param can also be a string using the format described at
            // http://blog.xero.com/developer/api-overview/http-methods-and-filters/ in the Filters section
            //the fourth param (optional) is a string field name to order by
            //to do a POST request, the first and only param must be a multidimensional array as shown above in $new_contact etc.

            //get details of all accounts
            $all_accounts = $xero->Accounts;

            //echo the results back
            if ( is_object($result) ) {
                //use this to see the source code if the $format option is "xml"
                echo htmlentities($result->asXML()) . "<hr />";
            } else {
                //use this to see the source code if the $format option is "json" or not specified
                echo json_encode($result) . "<hr />";
            }

        }

        if($_REQUEST['sample']=="pdf"){
            // first get an invoice number to use
            $org_invoices = $xero->Invoices;
            $invoice_count = sizeof($org_invoices->Invoices->Invoice);
            $invoice_index = rand(0,$invoice_count);
            $invoice_id = (string) $org_invoices->Invoices->Invoice[$invoice_index]->InvoiceID;
            if(!$invoice_id) echo "You will need some invoices for this...";

            // no retrieve that and display the pdf
            $pdf_invoice = $xero->Invoices($invoice_id, '', '', '', 'pdf');
            header('Content-type: application/pdf'); header('Content-Disposition: inline; filename="the.pdf"');
            echo ($pdf_invoice);
        }
    }

}