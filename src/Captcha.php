<?php

namespace Recaptcha;

use Recaptcha\Http\Client;
use Recaptcha\Http\Response;

class Captcha
{
    /**
     * The google captcha instance.
     *
     * @var Token
     */
    private Token $token;

    /**
     * The http client instance.
     *
     * @var Client
     */
    private Client $client;

    /**
     * Indicates if the captcha is valid.
     *
     * @var bool
     */
    private bool $status;

    /**
     * The errors codes.
     *
     * @var array
     */
    private array $errorCodes;

    /**
     * @param  Token  $token
     * @param  Client  $client
     */
    public function __construct(Token $token, Client $client)
    {
        $this->token = $token;
        $this->client = $client;
        $this->errorCodes = [];
    }

    /**
     * Check if the captcha is valid.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        $this->validate();
        return $this->status;
    }

    /**
     * Get the error codes if the validation fails.
     *
     * @return array
     */
    public function errorCodes(): array
    {
        return $this->errorCodes;
    }

    /**
     * Make the remote request to validate the captcha.
     *
     * @return void
     */
    private function validate(): void
    {
        $this->errorCodes = [];
        $response = Response::valueOf($this->client->sendRequest($this->token));
        $this->status = $response->isSuccessful();
        if (!$this->status) {
            $this->parseErrorCodes($response->errorCodes());
        }
    }

    /**
     * Parse the error codes if the request fails to validate.
     *
     * @param  array  $codes
     * @return void
     */
    private function parseErrorCodes(array $codes): void
    {
        foreach ($codes as $value) {
            $this->errorCodes[] = strtoupper(str_replace('-', '_', $value));
        }
    }
}
