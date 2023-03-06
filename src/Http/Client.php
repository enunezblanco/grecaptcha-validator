<?php

namespace Recaptcha\Http;

use Recaptcha\Token;

abstract class Client
{

    abstract public function sendRequest(Token $token) : Response;
}
