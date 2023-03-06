<?php

namespace Recaptcha\Http;

use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{

    /**
     * @test
     */
    public function when_payload_is_successful_then_response_is_successful()
    {
        $data = '{"success": true, "challenge_ts": "2023-03-05T22:57:51Z", "hostname": "google.com"}';
        $response = Response::valueOf(json_decode($data, true));
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('2023-03-05T22:57:51Z', $response->timestamp());
        $this->assertEquals('google.com', $response->hostname());
        $this->assertEmpty($response->errorCodes());
    }

    /**
     * @test
     */
    public function when_payload_is_not_successful_then_successful_is_false()
    {
        $data = '{"success": false, "error-codes": ["invalid-input-response"]}';
        $response = Response::valueOf(json_decode($data, true));
        $this->assertfalse($response->isSuccessful());
        $this->assertNull($response->timestamp());
        $this->assertNull($response->hostname());
        $this->assertContains('invalid-input-response', $response->errorCodes());
    }
}
