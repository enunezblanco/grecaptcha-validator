<?php

namespace Recaptcha;

use Mockery;
use PHPUnit\Framework\TestCase;
use Recaptcha\Http\Client;

class CaptchaTest extends TestCase
{

    private Captcha $captcha;

    private CLient $client;

    private Token $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->token = new Token('foobarSecret', 'foobarResponseToken', '127.0.0.1');
        $this->client = Mockery::mock(Client::class);

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
        $data = '{"success": true, "challenge_ts": "2023-03-05T22:57:51Z", "hostname": "google.com"}';
        $this->client->shouldReceive('sendRequest')->with($this->token)->andReturns($data);
        $this->captcha = new Captcha($this->token, $this->client);
        $this->assertTrue($this->captcha->isValid());
        $this->assertEmpty($this->captcha->errorCodes());
    }

    /**
     * @test
     */
    public function given_response_is_not_valid_then_return_false()
    {
        $data = '{"success": false, "error-codes": ["invalid-input-response","missing-input-secret", '
            . '"invalid-input-secret", "missing-input-response", "invalid-input-response", "bad-request", '
            . '"timeout-or-duplicate"]}';
        $this->client->shouldReceive('sendRequest')->with($this->token)->andReturns($data);
        $this->captcha = new Captcha($this->token, $this->client);
        $this->assertFalse($this->captcha->isValid());
        $this->assertContains('MISSING_INPUT_SECRET', $this->captcha->errorCodes());
        $this->assertContains('INVALID_INPUT_SECRET', $this->captcha->errorCodes());
        $this->assertContains('MISSING_INPUT_RESPONSE', $this->captcha->errorCodes());
        $this->assertContains('INVALID_INPUT_RESPONSE', $this->captcha->errorCodes());
        $this->assertContains('BAD_REQUEST', $this->captcha->errorCodes());
        $this->assertContains('TIMEOUT_OR_DUPLICATE', $this->captcha->errorCodes());
    }

}
