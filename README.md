# SilverStripe Elemental Links

Links block for SilverStripe Elemental

[![CI](https://github.com/dynamic/silverstripe-elemental-links/actions/workflows/ci.yml/badge.svg)](https://github.com/dynamic/silverstripe-elemental-links/actions/workflows/ci.yml)
[![codecov](https://codecov.io/gh/dynamic/silverstripe-elemental-links/branch/master/graph/badge.svg)](https://codecov.io/gh/dynamic/silverstripe-elemental-links)

[![Latest Stable Version](https://poser.pugx.org/dynamic/silverstripe-elemental-links/v/stable)](https://packagist.org/packages/dynamic/silverstripe-elemental-links)
[![Total Downloads](https://poser.pugx.org/dynamic/silverstripe-elemental-links/downloads)](https://packagist.org/packages/dynamic/silverstripe-elemental-links)
[![Latest Unstable Version](https://poser.pugx.org/dynamic/silverstripe-elemental-links/v/unstable)](https://packagist.org/packages/dynamic/silverstripe-elemental-links)
[![License](https://poser.pugx.org/dynamic/silverstripe-elemental-links/license)](https://packagist.org/packages/dynamic/silverstripe-elemental-links)


## Requirements

* dnadesign/silverstripe-elemental: ^5
* gorriecoe/silverstripe-linkfield: ^1.1
* symbiote/silverstripe-gridfieldextensions: ^4

## Installation

`composer require dynamic/silverstripe-elemental-links`

## License

See [License](license.md)

## Upgrading from version 1

LinksElement drops `sheadawson/silverstripe-linkable` usage in favor of `gorriecoe/silverstripe-linkfield`. To avoid data loss, install the `dynamic/silverstripe-link-migrator` module as follows:

```markdown
composer require dynamic/silverstripe-link-migrator
```

Then, run the task "Linkable to SilverStripe Link Migration" via `/dev/tasks`, or cli via:
```markdown
vendor/bin/sake dev/tasks/LinkableMigrationTask
```

This will populate all of the new Link fields with data from the old class.


## Example usage

A block to display a list of links.

## Getting more elements

See [Elemental modules by Dynamic](https://github.com/orgs/dynamic/repositories?q=elemental&type=all&language=&sort=)

## Configuration

See [SilverStripe Elemental Configuration](https://github.com/silverstripe/silverstripe-elemental#configuration)

## Maintainers

 *  [Dynamic](https://www.dynamicagency.com) (<dev@dynamicagency.com>)

## Bugtracker
Bugs are tracked in the issues section of this repository. Before submitting an issue please read over
existing issues to ensure yours is unique.

If the issue does look like a new bug:

 - Create a new issue
 - Describe the steps required to reproduce your issue, and the expected outcome. Unit tests, screenshots
 and screencasts can help here.
 - Describe your environment as detailed as possible: SilverStripe version, Browser, PHP version,
 Operating System, any installed SilverStripe modules.

Please report security issues to the module maintainers directly. Please don't file security issues in the bugtracker.

## Development and contribution
If you would like to make contributions to the module please ensure you raise a pull request and discuss with the module maintainers.

