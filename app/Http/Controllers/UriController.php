<?php

namespace App\Http\Controllers;

use App\Helpers\UriParser\UriParser;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

/**
 * Class UriController
 *
 * Rest Api controller for Uri resource
 *
 * @package App\Http\Controllers
 */
class UriController extends Controller
{
    /**
     * HTTP Get. Parses uri provided in query param uri and returns fragments.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $uri = $request->query("uri");
        if (empty($uri))
            return Response("Missing required query param: uri", Response::HTTP_BAD_REQUEST);

        return self::processUri($uri);
    }

    /**
     * HTTP Post. Parses Uri provided in data field uri and returns fragments. Does the same as Get, is provided
     * for convenience to avoid potential limitations of query parameters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $uri = $request->input("uri");
        if (empty($uri))
            return Response("Missing required input value: uri", Response::HTTP_BAD_REQUEST);

        return self::processUri($uri);
    }

    private function processUri(string $uri)
    {
        $fragments = UriParser::parseUri($uri);

        if (empty($fragments))
            return Response("The provided Uri is invalid", Response::HTTP_BAD_REQUEST);

        return Response($fragments);
    }
}
