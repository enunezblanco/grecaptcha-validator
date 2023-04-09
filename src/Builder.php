<?php

namespace Recaptcha;

use Recaptcha\Http\Client;

class Builder
{

    const DEFAULT_VERIFICATION_URI = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * The share key for the captcha.
     *
     * @var string
     */
    private string $sharedKey;

    /**
     * The remote response token.
     *
     * @var string
     */
    private string $responseToken;

    /**
     * The optional remote IP address.
     *
     * @var string
     */
    private string $remoteIp;

    /**
     * The verification URI for the captcha.
     *
     * @var string
     */
    private string $verificationUri;

    /**
     * Create a new Captcha Builder.
     *
     * @param  string  $sharedKey
     * @param  string  $responseToken
     */
    private function __construct(string $sharedKey, string $responseToken)
    {
        $this->sharedKey = $sharedKey;
        $this->responseToken = $responseToken;
        $this->verificationUri = self::DEFAULT_VERIFICATION_URI;
    }

    /**
     * Create a new captcha instance.
     *
     * @return Captcha
     */
    public function build(): Captcha
    {
        return new Captcha($this->buildToken(), new Client($this->verificationUri));
    }

    private function buildToken(): Token
    {
        if (isset($this->remoteIp)) {
            return new Token($this->sharedKey, $this->responseToken, $this->remoteIp);
        }
        return new Token($this->sharedKey, $this->responseToken, null);
    }

    /**
     * Set the remote IP address.
     *
     * @param  string  $remoteIp
     * @return Builder
     */
    public function remoteIp(string $remoteIp): Builder
    {
        $this->remoteIp = $remoteIp;
        return $this;
    }

    /**
     * Set the verification URI.
     * @param  string  $verificationUri
     * @return Builder
     */
    public function verificationUri(string $verificationUri): Builder
    {
        $this->verificationUri = $verificationUri;
        return $this;
    }

    /**
     * Get a new captcha builder instance.
     *
     * @param  string  $sharedKey
     * @param  string  $responseToken
     * @return Builder
     */
    public static function getInstance(string $sharedKey, string $responseToken): Builder
    {
        return new Builder($sharedKey, $responseToken);
    }

}
