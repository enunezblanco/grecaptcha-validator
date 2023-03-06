<?php

namespace Recaptcha;

use Mockery;
use PHPUnit\Framework\TestCase;
use Recaptcha\Http\Client;
use Recaptcha\Http\Response;

class CaptchaTest extends TestCase
{

    private Captcha $captcha;

    private Response $response;

    protected function setUp(): void
    {
        parent::setUp();
        $token = new Token('foobarSecret', 'foobarResponseToken', '127.0.0.1');
        $client = Mockery::mock(Client::class);
        $this->response = Mockery::mock(Response::class);
        $this->captcha = new Captcha($token, $client);
        $client->shouldReceive('sendRequest')->with($token)->andReturns($this->response);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    /**
     * @test
     */
    public function given_response_is_valid_then_return_true()
    {
        $this->response->shouldReceive('errorCodes')->andReturn([]);
        $this->response->shouldReceive('isSuccessful')->andReturn(true);
        $this->assertTrue($this->captcha->isValid());
        $this->assertEmpty($this->captcha->errorCodes());
    }

    /**
     * @test
     */
    public function given_response_is_not_valid_then_return_false()
    {
        $this->response->shouldReceive('isSuccessful')->andReturn(false);
        $this->response->shouldReceive('errorCodes')->andReturn([
            'missing-input-secret',
            'invalid-input-secret',
            'missing-input-response',
            'invalid-input-response',
            'bad-request',
            'timeout-or-duplicate'
        ]);
        $this->assertFalse($this->captcha->isValid());
        $this->assertContains('MISSING_INPUT_SECRET', $this->captcha->errorCodes());
        $this->assertContains('INVALID_INPUT_SECRET', $this->captcha->errorCodes());
        $this->assertContains('MISSING_INPUT_RESPONSE', $this->captcha->errorCodes());
        $this->assertContains('INVALID_INPUT_RESPONSE', $this->captcha->errorCodes());
        $this->assertContains('BAD_REQUEST', $this->captcha->errorCodes());
        $this->assertContains('TIMEOUT_OR_DUPLICATE', $this->captcha->errorCodes());
    }

}
