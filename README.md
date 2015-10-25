# CNAM v1.0β

[![Source](https://img.shields.io/badge/source-cedwardsmedia/cnam-blue.svg?style=flat-square "Source")](https://www.github.com/cedwardsmedia/cnam)
![Version](https://img.shields.io/badge/version-1.0β-brightgreen.svg?style=flat-square)
[![License](https://img.shields.io/badge/license-MIT-lightgrey.svg?style=flat-square "License")](./LICENSE)

![alt text](https://cdn.cedwardsmedia.com/images/cnam/screenshot.png "CNAM Screenshot")

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

 - [_Oct 23, 2015_]: **1.0β** Total restructure of code and first public release.
 - [_Oct 22, 2015_]: 0.2 Switched to exception catching for handling HTTP status codes.
 - [_Jul 2, 2015_]: 0.1 First working version produced.
 - [_Jun 8, 2015_]: Concept drafted.

## To-do:

1. Add ability to save PDF copy of dossier
2. Brainstorm more features?

## Credits
Concept and original codebase: Corey Edwards ([@cedwardsmedia](https://www.twitter.com/cedwardsmedia))

Optimization and Debugging: Brian Seymour ([@eBrian](http://bri.io))

## License
_CNAM_ is licensed under the **MIT License**. See LICENSE for more.

---
**Disclaimer**: _CNAM_ is not endorsed by, sponsored by, or otherwise associated with EveryoneAPI or Telo USA, Inc.
