# CNAM-CLI Changelog
All notable changes to this project will be documented in this file.

## Work in Progress

#### Added
- Added manual page for `cnam`
- Added `--testconfig` and `-tc` flags to test EveryoneAPI credentials.

#### Changed
- Moved source files to `src/` directory to maintain cleanliness of repo


## [2.0.0] - 2015-12-28

#### Added
- Added `--test` flag to query the test number provided by EveryoneAPI
- Added INI-based config file `cnam.conf`
- Added check for file_exists(config) with a printed warning when no file found
- Added `setup` command to write EveryoneAPI credentials to config file
- Added ability to print line_provider, image->cover, note, and cost.


#### Changed
- Migrated from built-in APICaller to [EveryonePHP](http://github.com/cedwardsmedia/everyonephp)
- Config file now located in ~/.cnam/
- Split web-based client off into [separate project](https://github.com/cedwardsmedia/webcnam)

#### Removed
- config.php deprecated in favor of cnam.conf

### [1.4.0] - 2015-12-25

#### Added
- Added `--name` flag to query for the *name* data point.
- Added `--profile` flag to query for the *profile* data point.
- Added `--cnam` flag to query for the *cnam* data point.
- Added `--gender` flag to query for the *gender* data point.
- Added `--image` flag to query for the *image* data point.
- Added `--address` flag to query for the *address* data point.
- Added `--location` flag to query for the *location* data point.
- Added `--provider` flag to query for the *provider* data point.
- Added `--carrier` flag to query for the *carrier* data point.
- Added `--carrier_o` flag to query for the *carrier_o* data point.
- Added `--linetype` flag to query for the *linetype* data point.

#### Changed
- Moved project history to CHANGELOG.md
- Changed dates in CHANGELOG.md to meet [ISO 8601 Standard](http://www.iso.org/iso/home/standards/iso8601.htm).


### [1.3.1] - 2015-11-06

#### Added
- Added debug flag to CLI client



#### Changed
- Minor tweaks




### [1.3] - 2015-11-04

#### Added
- Added command line tool - cnam.php



### [1.2] - 2015-11-03

#### Changed
- Cleaned up code and organized files



### [1.1] - 2015-11-02
#### Added
- Added ability to export dossier in vCard format


### [1.0] - 2015-11-25
- Ended βeta Testing - First Stable Release



### [1.0β] - 2015-10-23
- Total restructure of code and first public release.



### [0.2] - 2015-10-22
- Switched to exception catching for handling HTTP status codes.



### [0.2] - 2015-07-02
- First working version produced.



### 2015-06-08
- Initial concept drafted
- Initial design planned
