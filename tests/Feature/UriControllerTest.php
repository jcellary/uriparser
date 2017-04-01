<?php

namespace Tests\Feature;

use App\Helpers\UriParser\UriParser;
use Illuminate\Http\Response;
use Tests\TestCase;

class UriControllerTest extends TestCase
{
    public function testGetMissingParam()
    {
        $response = $this->get('/api/uri');

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testGetInvalidUri()
    {
        $response = $this->get('/api/uri?uri=invalid_uri');

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testGetInvalidEncodedUri()
    {
        $response = $this->get('/api/uri?uri=http://invalid%20space.com');

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testGetValidUri()
    {
        $response = $this->get('/api/uri?uri=http://domain.com');

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson([
            UriParser::SCHEME => "http",
            UriParser::HOSTNAME => "domain.com"
        ]);
    }

    public function testGetValidEncodedUri()
    {
        $response = $this->get('/api/uri?uri=http://domain.com/pa%2520th/');

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson([
            UriParser::SCHEME => "http",
            UriParser::HOSTNAME => "domain.com",
            UriParser::PATH => "/pa%20th"
        ]);
    }

    public function testPostMissingParam()
    {
        $response = $this->post('/api/uri', []);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testPostInvalidUri()
    {
        $response = $this->post('/api/uri', ["uri" => "invalid_uri"]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testPostValidUri()
    {
        $response = $this->post('/api/uri', ["uri" => "http://domain.com"]);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson([
            UriParser::SCHEME => "http",
            UriParser::HOSTNAME => "domain.com"
        ]);
    }

    public function testPostValidUriWithSpecialCharacters()
    {
        $response = $this->post('/api/uri', ["uri" => "http://domain%20.com"]);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson([
            UriParser::SCHEME => "http",
            UriParser::HOSTNAME => "domain%20.com"
        ]);
    }
}
