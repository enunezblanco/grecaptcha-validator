<?php

namespace Recaptcha\Http;

use CurlHandle;
use Recaptcha\Token;

class Client
{
    /**
     * The verification URI.
     *
     * @var string
     */
    private string $uri;

    /**
     * The token instance.
     *
     * @var Token
     */
    private Token $token;

    private CurlHandle $handle;

    /**
     * Create a new client instance.
     *
     * @param  string  $uri
     */
    public function __construct(string $uri)
    {
        $this->uri = $uri;
    }

    public function sendRequest(Token $token) : string
    {
        $this->token = $token;
        $this->handle = curl_init();
        $this->initRequest();
        $data = curl_exec($this->handle);
        curl_close($this->handle);

        return $data;
    }

    private function initRequest(): void
    {
        curl_setopt($this->handle, CURLOPT_URL, $this->uri);
        curl_setopt($this->handle, CURLOPT_POST, true);
        curl_setopt($this->handle, CURLOPT_POSTFIELDS, $this->fieldsToString());
        curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, true);
    }

    private function fieldsToString(): string
    {
        $fields = array(
            'secret' => $this->token->secret(),
            'response' => $this->token->responseToken()
        );
        if (!is_null($this->token->remoteIp())) {
            $fields['remoteip'] = $this->token->remoteIp();
        }
        return http_build_query($fields);
    }

}
