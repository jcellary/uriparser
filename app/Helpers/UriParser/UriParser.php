<?php

namespace App\Helpers\UriParser;

/**
 * Helper class for parsing Uris
 */
class UriParser
{
    //Names of possible Uri fragments
    const SCHEME = "scheme";
    const USER_INFO = "user_info";
    const HOSTNAME = "hostname";
    const PORT = "port";
    const PATH = "path";
    const QUERY = "query";
    const FRAGMENT = "fragment";

    const MATCH_KEYS = [
        self::SCHEME,
        self::USER_INFO,
        self::HOSTNAME,
        self::PORT,
        self::PATH,
        self::QUERY,
        self::FRAGMENT];

    /**
     * Parses the given Uri and returns information about its fragments
     *
     * @param $uri string Uri to parse
     *
     * @return array of fragments of URI with key names matching defined consts or empty array if Uri is invalid
     */
    public static function parseUri(string $uri)
    {
        $valid = preg_match(RegExpDefinition::URI_REGEXP, $uri, $matches);
        if ($valid)
            return self::normalizeMatches($matches);
        else
            return [];
    }

    /**
     * Filters the key mathes and leaves only key -> value pairs, where key is one of the defined consts
     *
     * Also removes sufixes from keys that were an artifact of the regexp construction i.e. path1 -> path, path2 -> path
     *
     * This is necessary because regexp does not allow duplicated group names, however there are multiple possible
     * uri formats, so the same logical part i.e. path can be described by different regexp patterns.
     *
     * @param $matches array with raw matches from regexp function
     *
     * @return array key -> value with keys being one of defined consts.
     */
    private static function normalizeMatches(array $matches)
    {
        $result = [];
        foreach ($matches as $key => $value) {
            $normalizedKey = self::getKeyIfMatchStartsWithIt($key);
            if ($normalizedKey && !empty($value))
                $result[$normalizedKey] = $value;
        }

        return $result;
    }

    /**
     * Check if the provided key is equal to one of the valid key names or starts with it
     * and returns the normalized version
     *
     * @param $actualKey string group match name from the regexp
     *
     * @return string $actualKey if it is a valid key name; it's truncated version if valid key is its substring or
     */
    private static function getKeyIfMatchStartsWithIt(string $actualKey)
    {
        foreach (self::MATCH_KEYS as $validKey) {
            if (strlen($actualKey) < strlen($validKey))
                continue;

            if (substr($actualKey, 0, strlen($validKey)) === $validKey)
                return $validKey;
        }

        return false;
    }
}