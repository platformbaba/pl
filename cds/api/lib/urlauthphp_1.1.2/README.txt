OVERVIEW

The URLToken package is designed to help you incorporate URL-
based Edge Authorization / distributed authentication tokens
into your site.

Authenticated URLs are created as follows:

    $sUrlPath = urlauth_gen_url($sUrl, $sParam, $nWindow,
                                $sSalt, $sExtract, $nTime);

where:
    * $sUrlPath     is a string containing the path portion of
                    the URL with the authorization information
                    appended
    * $sUrl         is a string containing the path portion of
                    the URL (i.e., "/path/to/file.ext")
    * $sParam       is a string containing the query string
                    parameter containing the authentication
                    information
    * $nWindow      is an integer containing the length of time
                    the authentication will remain valid
    * $sSalt        is a string that will be used as a salt
                    for the authentication hash
    * $sExtract     is a string containing a specific value
                    that must be present for authorization to
                    succeed
    * $nTime        is an integer containing the time (in Unix
                    epoch format) when the token should become
                    valid


CONTENTS

This archive contains the following items:

URLToken.php
    The PHP functions necessary to create authorization tokens

README.txt
    A summary of the package along with integration information

ChangeLog.txt
    A list of package changes, by version

