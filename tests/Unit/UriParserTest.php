<?php

namespace Tests\Unit;

use App\Helpers\UriParser\UriParser;
use Tests\TestCase;

class UriParserTest extends TestCase
{
    /**
     * Tests parsing of valid Uris
     *
     * @param $uri string Uri to parse
     * @param $expectedFragments array fragments that are expected to be found in the uri
     *
     * @dataProvider validUris
     */
    public function testSuccessfulParsing(string $uri, array $expectedFragments)
    {
        $actualFragments = URIParser::parseUri($uri);

        $this->assertEquals($expectedFragments, $actualFragments);
    }

    /**
     * Test data provider
     *
     * @return array valid Uris and their fragments
     */
    public function validUris()
    {
        return
            [
                [
                    "abc://username:password@example.com:123/path/data?key=value&key2=value2#fragid1",
                    [
                        URIParser::SCHEME => "abc",
                        URIParser::USER_INFO => "username:password",
                        URIParser::HOSTNAME => "example.com",
                        URIParser::PORT => "123",
                        URIParser::PATH => "/path/data",
                        URIParser::QUERY => "key=value&key2=value2",
                        URIParser::FRAGMENT => "fragid1"
                    ]
                ],
                [
                    "urn:example:mammal:monotreme:echidna",
                    [
                        URIParser::SCHEME => "urn",
                        URIParser::PATH => "example:mammal:monotreme:echidna"
                    ]
                ],
                [
                    "http://domain.com/keep/it/real",
                    [
                        URIParser::SCHEME => "http",
                        URIParser::HOSTNAME => "domain.com",
                        URIParser::PATH => "/keep/it/real"
                    ]
                ],
                [
                    "http://encoding.play/kee%20p/it/real",
                    [
                        URIParser::SCHEME => "http",
                        URIParser::HOSTNAME => "encoding.play",
                        URIParser::PATH => "/kee%20p/it/real"
                    ]
                ]
            ];
    }

    /**
     * Tests parsing of invalid Uris
     *
     * @param $uri string Uri to parse
     *
     * @dataProvider invalidUris
     */
    public function testUnsuccessfulParsing(string $uri)
    {
        $actualFragments = URIParser::parseUri($uri);

        $this->assertEmpty($actualFragments);
    }

    /**
     * Test data provider
     *
     * @return array invalid Uris
     */
    public function invalidUris()
    {
        return
            [
                ["invalid_uri"],
                ["http//domain.com"],
                ["http://user:user@user@domain.com"],
                ["/only/absolute/uri/allowed"]
            ];
    }
}
