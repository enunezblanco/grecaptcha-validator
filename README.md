

# Google's reCAPTCHA validator

<a href="https://github.com/enunezblanco/grecaptcha-validator/actions"><img src="https://github.com/enunezblanco/grecaptcha-validator/workflows/tests/badge.svg" alt="Build Status"></a>
![Packagist License](https://img.shields.io/packagist/l/enunez/grecaptcha-validator)
![Packagist Version (including pre-releases)](https://img.shields.io/packagist/v/enunez/grecaptcha-validator?include_prereleases)

The Google reCAPTCHA Verification PHP library is a tool for software developers to verify the response of Google reCAPTCHA v2 or v3 from within their PHP applications. This library simplifies the process of verifying the user's response to a reCAPTCHA challenge and provides an easy-to-use interface for integrating the verification process into your PHP code.

With this library, you can easily configure and set up reCAPTCHA verification for your PHP application, without the need for complicated coding. You can easily specify your reCAPTCHA API key, secret key, and other necessary configuration parameters, and then call the library functions to verify the response received from the reCAPTCHA challenge.

This library supports both the v2 and v3 versions of Google reCAPTCHA, so you can use it for a wide range of applications. It provides error handling and reporting functionality, allowing you to easily detect and handle any errors that may occur during the verification process.

The Google reCAPTCHA Verification PHP library is open-source and available for free on GitHub. This library helps you easily integrate the power of Google reCAPTCHA into your PHP application, ensuring that your users are protected from spam and abuse.

### Quick start

#### Installation

Installation is handle via Composer:

```bash
$ composer require enunez/grecaptcha-validator
```

or add it manually to you ```composer.json``` file

```json
{
  "require": {
    "enunez/grecaptcha-validator": "^1.0.0"
  }
}
```

#### Usage
This is a quick example of how to use the library:

```PHP
$captcha = Builder::getInstance(YOUR_SHARED_KEY, USER_RESPONSE_TOKEN)->build();

$captcha->isValid();
```

To include the remote IP address:

```PHP
$captcha = Builder::getInstance(YOUR_SHARED_KEY, USER_RESPONSE_TOKEN)->remoteIp(REMOTE_IP)->build();

$captcha->isValid();
```

If verification fails you can access all error codes by using:


```PHP
if (!$captcha->isValid()) {
    foreach ($errorCode as $captcha->errorCodes()) {
        // processing the error code
    }
}
```

For more details on the supported error codes please check: https://developers.google.com/recaptcha/docs/verify#error_code_reference

## License

This library is open-sourced software licensed under the [MIT license](LICENSE.md).
