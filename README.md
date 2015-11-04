# CNAM v1.2

[![Source](https://img.shields.io/badge/source-cedwardsmedia/cnam-blue.svg?style=flat-square "Source")](https://www.github.com/cedwardsmedia/cnam)
![Version](https://img.shields.io/badge/version-1.2-brightgreen.svg?style=flat-square)
[![License](https://img.shields.io/badge/license-MIT-lightgrey.svg?style=flat-square "License")](./LICENSE)
[![Gratipay](https://img.shields.io/gratipay/cedwardsmedia.svg?style=flat-square "License")](https://gratipay.com/~cedwardsmedia/)

![CNAM Screenshot](https://cdn.cedwardsmedia.com/images/cnam/screenshot.png "CNAM Screenshot")

_CNAM_ is a web-based reverse phone number lookup tool written in PHP and sourced by [EveryoneAPI](https://www.everyoneapi.com/). In order to use CNAM, you must have an [EveryoneAPI account](https://www.everyoneapi.com/sign-up)  with [available funds](https://www.everyoneapi.com/pricing).

## Installation

For **personal** or **private** use:

1. Clone the repo.
2. Rename `config.default.php` to `config.php`.
3. Edit `config.php` and add your EveryoneAPI credentials.
4. Point your browser to index.php and enter a valid 10-digit United States or Canada phone number and click the ![Search](https://cdn.cedwardsmedia.com/images/cnam/search.png "Search") button or press enter.

For **public** use:

1. Clone the repo.
2. Point your browser to index.php
3. Click the ![Settings](https://cdn.cedwardsmedia.com/images/cnam/cog.png "Settings") icon
4. Enter your EveryoneAPI credentials and click "save changes"
5. Enter a valid 10-digit United States or Canada phone number and click the ![Search](https://cdn.cedwardsmedia.com/images/cnam/search.png "Search") button or press enter.

## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request ^^,

## History

 - **[_Nov 3, 2015_]: 1.2 Cleaned up code and organized files**
 - [_Nov 2, 2015_]: 1.1 Added ability to export dossier in vCard format
 - [_Oct 25, 2015_]: 1.0 Ended βeta Testing - First Stable Release
 - [_Oct 23, 2015_]: 1.0β Total restructure of code and first public release.
 - [_Oct 22, 2015_]: 0.2 Switched to exception catching for handling HTTP status codes.
 - [_Jul 2, 2015_]: 0.1 First working version produced.
 - [_Jun 8, 2015_]: Concept drafted.

## To-do:

1. Add ability to save PDF copy of dossier
2. Add modal with checkboxes to select data to query
3. Don't query *everything* by default - costs too much
4. Add ability to export dossier as CSV
5. Brainstorm more features?

## Known Issues:

1. Apple Contacts, Google Contacts, and others do not import avatar from exported vCard. This is an issue with the way these products parse vCard documents and is NOT a bug in CNAM. However, in the interest of interoperability, I will add base64 encoded images to the vCard format in a future release.
2. There is currently no way to select specific fields to return in the query. As such, all current queries request all available data from EveryoneAPI. This will be added in an upcoming release.

## Credits
Concept and original codebase: Corey Edwards ([@cedwardsmedia](https://www.twitter.com/cedwardsmedia))

Optimization and Debugging: Brian Seymour ([@eBrian](http://bri.io))

## License
_CNAM_ is licensed under the **MIT License**. See LICENSE for more.

---
**Disclaimer**: _CNAM_ is not endorsed by, sponsored by, or otherwise associated with [OpenCNAM](http://www.opencnam.com), [EveryoneAPI](http://www.everyoneapi.com), or [Telo USA, Inc](http://www.telo.com).
