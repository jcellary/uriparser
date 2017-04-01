<?php


namespace App\Helpers\UriParser;

class RegExpDefinition
{
    //Taken from http://jmrware.com/articles/2009/uri_regexp/URI_regex.html
    //Expanded with group names to allow the split of URI
    //Note! The names of fragments defined in this regexp have to match constants defined in code
    const URI_REGEXP = '< ^
    # RFC-3986 URI component:  URI
    (?P<scheme>[A-Za-z][A-Za-z0-9+\-.]*) :                                      # scheme ":"
    (?: //                                                          # hier-part
      (?: (?P<user_info>(?:[A-Za-z0-9\-._~!$&\'()*+,;=:]|%[0-9A-Fa-f]{2})*) @)?
      (?P<hostname>:
        \[
        (?:
          (?:
            (?:                                                    (?:[0-9A-Fa-f]{1,4}:){6}
            |                                                   :: (?:[0-9A-Fa-f]{1,4}:){5}
            | (?:                            [0-9A-Fa-f]{1,4})? :: (?:[0-9A-Fa-f]{1,4}:){4}
            | (?: (?:[0-9A-Fa-f]{1,4}:){0,1} [0-9A-Fa-f]{1,4})? :: (?:[0-9A-Fa-f]{1,4}:){3}
            | (?: (?:[0-9A-Fa-f]{1,4}:){0,2} [0-9A-Fa-f]{1,4})? :: (?:[0-9A-Fa-f]{1,4}:){2}
            | (?: (?:[0-9A-Fa-f]{1,4}:){0,3} [0-9A-Fa-f]{1,4})? ::    [0-9A-Fa-f]{1,4}:
            | (?: (?:[0-9A-Fa-f]{1,4}:){0,4} [0-9A-Fa-f]{1,4})? ::
            ) (?:
                [0-9A-Fa-f]{1,4} : [0-9A-Fa-f]{1,4}
              | (?: (?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?) \.){3}
                    (?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)
              )
          |   (?: (?:[0-9A-Fa-f]{1,4}:){0,5} [0-9A-Fa-f]{1,4})? ::    [0-9A-Fa-f]{1,4}
          |   (?: (?:[0-9A-Fa-f]{1,4}:){0,6} [0-9A-Fa-f]{1,4})? ::
          )
        | [Vv][0-9A-Fa-f]+\.[A-Za-z0-9\-._~!$&\'()*+,;=:]+
        )
        \]
      | (?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}
           (?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)
      | (?:[A-Za-z0-9\-._~!$&\'()*+,;=]|%[0-9A-Fa-f]{2})*
      )
      (?: : (?P<port>[0-9]*) )?
      (?P<path1> (?:/ (?:[A-Za-z0-9\-._~!$&\'()*+,;=:@]|%[0-9A-Fa-f]{2})* )* )
    | (?P<path2> /
      (?:    (?:[A-Za-z0-9\-._~!$&\'()*+,;=:@]|%[0-9A-Fa-f]{2})+
        (?:/ (?:[A-Za-z0-9\-._~!$&\'()*+,;=:@]|%[0-9A-Fa-f]{2})* )*
      )? )
    | (?P<path3>       (?:[A-Za-z0-9\-._~!$&\'()*+,;=:@]|%[0-9A-Fa-f]{2})+
        (?:/ (?:[A-Za-z0-9\-._~!$&\'()*+,;=:@]|%[0-9A-Fa-f]{2})* )* )
    |
    )
    (?:\? (?P<query>(?:[A-Za-z0-9\-._~!$&\'()*+,;=:@/?]|%[0-9A-Fa-f]{2})* ))?   # [ "?" query ]
    (?:\# (?P<fragment>(?:[A-Za-z0-9\-._~!$&\'()*+,;=:@/?]|%[0-9A-Fa-f]{2})* ))?   # [ "#" fragment ]
    $ >Sx';
}