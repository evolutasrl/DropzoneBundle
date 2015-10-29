DropzoneBundle
=============

The DropzoneBundle adds support for a **direct S3 upload** in Symfony2 forms. 
It provides a form type for sending files directly to your Amazon AWS S3 bucket without touch your webserver.

Read more about this technique [in Aws website](http://docs.aws.amazon.com/AmazonS3/latest/API/sigv4-authentication-HTTPPOST.html).

Features include:

- Single file upload
- Multiple file upload

This bundle is well unit tested by phpspec.

[![Build Status](https://travis-ci.org/evolutasrl/DropzoneBundle.svg)](https://travis-ci.org/evolutasrl/DropzoneBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/evolutasrl/DropzoneBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/evolutasrl/DropzoneBundle/?branch=master)


Installation
------------

Installation is a quick (I promise!) 3 step process:

1. Download DropzoneBundle using composer
2. Enable the Bundle
3. Configure the DropzoneBundle
4. Javascript and css

###Step 1: Download DropzoneBundle using composer
   
Require the bundle with composer:
   
       $ composer require evoluta/dropzone-bundle "1.0.x-dev"
   
Composer will install the bundle to your project's ``vendor/evoluta/dropzone-bundle`` directory.

###Step 2: Enable the bundle

Enable the bundle in the kernel::

    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Evoluta\DropzoneBundle\DropzoneBundle(),
            // ...
        );
    }
    
###Step 3: Configure DropzoneBundle
The next step is to configure the bundle to work with the specific needs of your application.

Add the following configuration to your ``parameters.yml`` file.

    dropzone_endpoint: //s3-eu-west-1.amazonaws.com/
    dropzone_accessKey: <aws_accesskey>
    dropzone_secret: <aws_secret>
    dropzone_bucket: <aws_bucket>
    
You can override configurations from ``parameters.yml`` in your type usage. 

Add the following configuration to your ``config.yml`` file.

	evoluta_dropzone:
    	endpoint: "%dropzone_endpoint%"
    	accessKey: "%dropzone_accessKey%"
    	secret: "%dropzone_secret%"
    	bucket: "%dropzone_bucket%"
    	
###Step 4: Javascript and css
Todo: describe assets dump and declare in main template.

Usage - upload single
------------

With this bundle, is available for you a new form field type called ``dropzoneS3File``.
This field type extends the symfony default url field type.

``````
class DropzoneController extends Controller
{

    public function testAction(Request $request)
    {
    
    	// ...
    	
        $form = $this->createFormBuilder()
            ->add(
                'task1',
                'dropzoneS3File'
            )
            ->add(
                'task2',
                'dropzoneS3File',
                array(
                    'acceptedFiles' => 'image/*',
                    'directory' => 'images/sub1/sub2'
                )
            )
            ->getForm();

        // ...
    }
}
``````
###Options
####Endpoint
You can override global aws endpoint configuration for this field.

``````
$form = $this->createFormBuilder()
	->add(
	'File upload',
	'dropzoneS3File',
	array(
		'endpoint' => '//s3-eu-west-1.amazonaws.com/',
	)
)
``````
####AccessKey
You can override global accessKey configuration for this field.

``````
$form = $this->createFormBuilder()
	->add(
	'File upload',
	'dropzoneS3File',
	array(
		'accessKey' => '<your accessKey>',
	)
)
``````
####Secret
You can override global secret configuration for this field.

``````
$form = $this->createFormBuilder()
	->add(
	'File upload',
	'dropzoneS3File',
	array(
		'secret' => '<your secret>',
	)
)
``````
####Bucket
You can override global secret configuration for this field.

``````
$form = $this->createFormBuilder()
	->add(
	'File upload',
	'dropzoneS3File',
	array(
		'bucket' => '<your bucket>',
	)
)
``````
####Acl
Amazon S3 supports a set of predefined grants, known as canned ACLs. Each canned ACL has a predefined a set of grantees and permissions.
You ca read more [here](http://docs.aws.amazon.com/AmazonS3/latest/dev/acl-overview.html#canned-acl)

You can override global all configuration for this field.

You can use one of these options:

- private
- public-read
- public-read-write
- authenticated-read
- bucket-owner-read
- bucket-owner-full-control

The default value is *public-read*


``````
$form = $this->createFormBuilder()
	->add(
	'File upload',
	'dropzoneS3File',
	array(
		'all' => 'public-read',
	)
)
``````
####Directory
The sub directory where to put file.
The default value is null.

``````
$form = $this->createFormBuilder()
	->add(
	'File upload',
	'dropzoneS3File',
	array(
		'directory' => 'images/sub1/sub2'
	)
)
``````

####AcceptedFiles
The default implementation checks the file's mime type or extension against this list. This is a comma separated list of mime types or file extensions. Eg.: image/*,application/pdf,.psd. 
The default config allow to upload every kind of file.

``````
$form = $this->createFormBuilder()
	->add(
	'File upload',
	'dropzoneS3File',
	array(
		'acceptedFiles' => 'image/*'
	)
)
``````

####ExpireAt
The expiration element specifies the expiration date and time of the POST policy.
Indicate how long the user can wait from page loading to finish upload.
It expects to be given a string containing an English date format.
You can use this keywords:

- now
- +1 hour
- +4 hours
- +1 day
- +5 days
- +1 week
- +1 week 2 days 4 hours 2 seconds
- next Thursday
- last Monday

Internal this function use strtotime read more in [php website](http://php.net/manual/en/function.strtotime.php).



``````
$form = $this->createFormBuilder()
	->add(
	'File upload',
	'dropzoneS3File',
	array(
		'expireAt' => '+1 hour'
	)
)
``````

Usage - upload multiple
-----------
Still in progress. Please help us!


###TODO

- configure aws




License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE

About
-----

DropzoneBundle is a [evolutasrl](https://github.com/evolutasrl) initiative coded by [brainrepo](https://github.com/brainrepo) proudly made in Sardinia with love :).

Reporting an issue or a feature request
---------------------------------------

Issues and feature requests are tracked in the [Github issue tracker](https://github.com/evolutasrl/DropzoneBundle/issues).

When reporting a bug, it may be a good idea to reproduce it in a basic project
built using the [Symfony Standard Edition](https://github.com/symfony/symfony-standard)
to allow developers of the bundle to reproduce the issue by simply cloning it
and following some steps.