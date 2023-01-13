# Onionbb: Tor hardening

## Requeriments

- phpBB >= 3.3.9
- PHP >= 8.0

## Features

- IP whitelisting: only these IPs can make request to the forum.
- Block Tor2Web.
- Make sure client is connecting to our service and not the default virtualhost.
- Block non-standard UserAgent (non-browsers and bots).
- Only allow the latest version of Tor Browser and block other browsers.
- Implement HTTP security headers on Response like:
    * Referrer-Policy.
    * X-Content-Type-Options.
    * X-Frame-Options.
    * Content-Security-Policy. Disable Javascript execution.

## Installation

Copy the extension to phpBB/ext/cypherbits/onionbb

Go to "ACP" > "Customise" > "Extensions" and enable the "Onionbb: Tor hardening" extension.

## License

[GPLv2](license.txt)
