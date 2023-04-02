<?php

namespace Recaptcha;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class TokenTest extends TestCase
{

    /**
     * @test
     */
    public function instantiating_with_an_empty_secret_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        new Token("", "foobarToken");
    }

    /**
     * @test
     */
    public function instantiating_with_an_empty_response_token_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        new Token("foobarSecret", "");
    }

    /**
     * @test
     */
    public function instantiating_with_an_invalid_remote_ip_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        new Token("foobarSecret", "foobarResponseToken", "");
    }
}
