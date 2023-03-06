<?php

namespace Recaptcha;

use InvalidArgumentException;

class Token
{
    /**
     * The shared key between your site and reCAPTCHA.
     *
     * @var string
     */
    private string $secret;

    /**
     * The user response token provided by the reCAPTCHA client-side integration on your site.
     *
     * @var string
     */
    private string $responseToken;

    /**
     * The user's remote IP address.
     *
     * @var string
     */
    private string $remoteIp;

    /**
     * Create a new reCAPTCHA instance.
     *
     * @param  string  $secret
     * @param  string  $responseToken
     * @param  string|null  $remoteIp
     */
    public function __construct(string $secret, string $responseToken, string $remoteIp = null)
    {
        $this->setSecret($secret);
        $this->setResponse($responseToken);
        $this->setRemoteIp($remoteIp);
    }

    private function setSecret(string $secret): void
    {
        if (empty($secret)) {
            throw new InvalidArgumentException("The shared key between your site and reCAPTCHA is require and "
                . "cannot be empty");
        }
        $this->secret = $secret;
    }

    private function setResponse(string $response): void
    {
        if (empty($response)) {
            throw new InvalidArgumentException("The user response token provided by the reCAPTCHA client-side "
                . "integration on your site is require and cannot be empty");
        }
        $this->responseToken = $response;
    }

    private function setRemoteIp(string $remoteIp): void
    {
        if (!is_null($remoteIp) && !filter_var($remoteIp, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException("The user's remote IP address is not a valid IP address");
        }
        $this->remoteIp = $remoteIp;
    }
}
