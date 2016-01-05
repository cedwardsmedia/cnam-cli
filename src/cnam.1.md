<!---
This man page can be generated using ronn - http://rtomayko.github.com/ronn/
-->
cnam(1) -- CLI client for EveryoneAPI.
=============================================

## SYNOPSIS

`cnam` &lt;phone number&gt; &#91;options&#93;  

## DESCRIPTION

**CNAM** is a command-line client for EveryoneAPI written in PHP. In order to use CNAM, you must have an EveryoneAPI account with available funds.

More information about EveryoneAPI can be found here: <https://www.everyoneapi.com/pricing>

## FIRST RUN

Run `cnam setup` to set your EveryoneAPI account credentials. `CNAM` will ask for your API SID and TOKEN, then write this information to the config file - `~/.cnam/cnam.conf`.  

## OPTIONS

**Data Points**

Running `cnam` with any of the following flags will cause CNAM to return *only* that particular data point.

Running `cnam` *without* any of the following flags will cause CNAM to return all available information from `EveryoneAPI`.

*Note:* These flags should come *AFTER* the phone number.

  * `--name`:
    Query for the *name* data point.
  * `--profile`:
    Query for the *profile* data point.
  * `--cnam`:
    Query for the *cnam* data point.
  * `--gender`:
    Query for the *gender* data point.
  * `--image`:
    Query for the *image* data point.
  * `--address`:
    Query for the *address* data point.
  * `--location`:
    Query for the *location* data point. (Included free with `--address`)
  * `--provider`:
    Query for the *provider* data point.
  * `--carrier`:
    Query for the *carrier* data point.
  * `--carrier_o`:
    Query for the *carrier_o* data point. (Included free with `--carrier`)
  * `--linetype`:
    Query for the *linetype* data point.

**Misc. Options**

These options offer additional functionality to `CNAM` but do not return results  from EveryoneAPI.

* `-d`, `--debug`:
  Prints debug information to the screen. Useful for reporting issues to the developer.
* `-h`, `--help`:
  Prints help information to the screen. Albeit, this manual page contains far more information.
* `-v`, `--version`:
  Prints version information to the screen.
* `--test`:
  Queries EveryoneAPI using the testing number +15551234567. Useful for testing your connection and ensuring EveryoneAPI is not experiencing downtime.
* `--testconfig`, `-tc`:
  Queries EveryoneAPI to test your credentials.  

  **Note** this will cost **$.001** as `cnam` must request at least one data point. (I have reached out to EveryoneAPI about adding another no-cost means of verifying credentials. The most recent feedback is that they are considering it.)


## CREDITS

`CNAM` uses `EveryonePHP`, an MIT-licensed PHP class available through Composer.

## DISCLAIMER

`CNAM` is not endorsed by, sponsored by, or otherwise associated with OpenCNAM, EveryoneAPI, or Telo USA, Inc.

## AUTHOR

Corey Edwards &lt;<https://www.cedwardsmedia.com/>&gt;

## SEE ALSO
