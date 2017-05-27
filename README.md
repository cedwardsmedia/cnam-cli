# CNAM-CLI v2.0.2

[![Source](https://img.shields.io/badge/source-cedwardsmedia/cnam--cli-blue.svg?style=flat-square "Source")](https://www.github.com/cedwardsmedia/cnam-cli)
[![Version](https://img.shields.io/badge/version-2.0.2-brightgreen.svg?style=flat-square)]()
[![License](https://img.shields.io/badge/license-BSD-lightgrey.svg?style=flat-square "License")](./LICENSE.md)
[![Gratipay](https://img.shields.io/gratipay/cedwardsmedia.svg?style=flat-square "License")](https://gratipay.com/~cedwardsmedia/)


_CNAM-CLI_ is a command-line client for [EveryoneAPI](https://www.everyoneapi.com/) written in PHP. In order to use CNAM, you must have an [EveryoneAPI account](https://www.everyoneapi.com/sign-up)  with [available funds](https://www.everyoneapi.com/pricing).

## Installation

1. Download and unpack the [latest release](https://github.com/cedwardsmedia/cnam-cli/releases).
2. Run `install.sh` as root or use `sudo`
3. Run `cnam setup` to set your EveryoneAPI credentials

To perform a lookup of a phone number: `cnam [phonenumber] [--data-point]`

### Data Point Flags

Running `cnam <phone_number>` without specifying any data point flags will cause CNAM to return all available data for the provided number.

Providing one or more data point flags will cause CNAM to return ONLY the selected data points. Example: `cnam 5551234567 --name --carrier` will cause CNAM to return only the name and carrier for the provided number.

- Use the `--name` flag to query for the *name* data point.
- Use the `--profile` flag to query for the *profile* data point.
- Use the `--cnam` flag to query for the *cnam* data point.
- Use the `--gender` flag to query for the *gender* data point.
- Use the `--image` flag to query for the *image* data point.
- Use the `--address` flag to query for the *address* data point.
- Use the `--location` flag to query for the *location* data point. (Included free with `--address`)
- Use the `--provider` flag to query for the *provider* data point.
- Use the `--carrier` flag to query for the *carrier* data point.
- Use the `--carrier_o` flag to query for the *carrier_o* data point. (Included free with `--carrier`)
- Use the `--linetype` flag to query for the *linetype* data point.

## Manual Page
__CNAM-CLI__ comes with a UNIX man page `cnam`. You can view the man page using the `man` command or any graphical man page viewer.

## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request ^^,


## Credits
Concept and original codebase: Corey Edwards ([@cedwardsmedia](https://www.twitter.com/cedwardsmedia))

Optimization and Debugging: Brian Seymour ([@eBrian](http://bri.io))

## License
_CNAM-CLI_ is licensed under the **MIT License**. See LICENSE for more.

---
**Disclaimer**: _CNAM-CLI_ is not endorsed by, sponsored by, or otherwise associated with [OpenCNAM](http://www.opencnam.com), [EveryoneAPI](http://www.everyoneapi.com), or [Telo USA, Inc](http://www.telo.com).
