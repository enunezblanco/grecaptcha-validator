<?php

namespace Recaptcha\Http;

class Response
{
    private bool $success;

    private ?string $challengeTimestamp = null;

    private ?string $hostname = null;

    private array $errorCodes = [];

    /**
     * Create a new response instance.
     *
     * @param  bool  $success
     */
    private function __construct(bool $success)
    {
        $this->success = $success;
    }

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->success;
    }

    /**
     * @param  string  $challengeTimestamp
     */
    private function setTimestamp(string $challengeTimestamp): void
    {
        $this->challengeTimestamp = $challengeTimestamp;
    }

    public function timestamp(): ?string
    {
        return $this->challengeTimestamp;
    }

    /**
     * @param  string  $hostname
     */
    private function setHostname(string $hostname): void
    {
        $this->hostname = $hostname;
    }

    public function hostname(): ?string
    {
        return $this->hostname;
    }

    /**
     * @param  array  $errorCodes
     */
    private function setErrorsCode(array $errorCodes): void
    {
        $this->errorCodes = $errorCodes;
    }

    /**
     * @return array
     */
    public function errorCodes(): array
    {
        return $this->errorCodes;
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $data
     * @return Response
     */
    public static function valueOf(string $data): Response
    {
        $array = json_decode($data, true);
        $response = new Response($array['success']);
        if (isset($array['challenge_ts'])) {
            $response->setTimestamp($array['challenge_ts']);
        }

        if (isset($array['challenge_ts'])) {
            $response->setHostname($array['hostname']);
        }

        if (isset($array['error-codes'])) {
            $response->setErrorsCode($array['error-codes']);
        }
        return $response;
    }

}
