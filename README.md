# Motion-extended
A wrapper script that adds extra functionality to the [motion](https://motion-project.github.io/) video motion detection program. 

There are many open-source nvr programs out there but many suffer from the same problem(s), difficult to install/setup and trying to be jack of all trades but master of none.

The goal of motion-extended is to take the existing rock-solid 'motion' program and extend it.  Motion is a great app but it does not have any scheduling logic (enabling/disabling motion detection caputure for individual cameras based on a date/time schedule).  That's the first goal of motion-extended, to support scheduling.  More functionality will be added in the future such as sending notifications to various endpoints such as email, Riot(matrix), Slack and more. 

## Prerequisites

* Linux
* One or more cameras supported by v4l2 or having RTSP functionality.
* PHP CLI >= 7.x
* [Motion](https://motion-project.github.io/) .  This program is usually found in the main repositories of your favorite Linux distro.
* [The PHP Cron Expression Parser](https://github.com/dragonmantank/cron-expression) - This is needed to process the cron expressions defined for each camera so motion-exteded can determine when to enable/disable them.

## Getting Started

* Setup motion's configuration files as you usually would.  It's highly recommended you use motion's 'cron.d' directory to define each camera's attributes.
* Disable motion's global setting 'movie_output' by setting it to 'off'.  This setting should be defined on each camera's motion config file.  Not doing so will not allow motion-ext to perform scheduling.  Program logic has been added to catch this misconfiguration.
* Configure motion-extended's configuration file (motion-ext.json) to contain the cron expression(s) for each camera for when you want to capture motion.
* Run 'motion-ext'.  Don't forget to supply the -c and -e switches which are mandatory.
* IMPORTANT!  The name of each camera in the 'motion-ext.json' config file must match the motion config file names for each individual camera.
* Enjoy!

## Example motion-ext.json

```php
{
    "utility-room": 
    {
        "schedules":
        [
            {
                "name": "Capture anything anytime.",
                "cron_expr": "* * * * *"
            }
        ]
    },
    "livingroom":
    {
        "schedules":
        [
            {
                "name": "Late-night captures1.",
                "cron_expr": "* 23 * * *"
            },
            {
                "name": "Late-night captures2.",
                "cron_expr": "* 0-5 * * *"
            }
        ]
    },
    "driveway":
    {
        "schedules":
        [
            {
                "name": "Capture while at work.",
                "cron_expr": "* 7-17 * * *"
            }
        ]
    },
    "downstairs":
    {
        "schedules":
        [
            {
                "name": "Capture anything anytime.",
                "cron_expr": "* * * * *"
            }
        ]
    }
}

```

## Examples
`
motion-ext -c [/path/to/motion/conf/file] -e [/path/to/motion-ext/json/file]
`


## Why PHP?

I wrote this in PHP because I like PHP and it's a very robust general-purpose scripting language.  PHP is not just for webpages.  Those who think that only know of PHP from 15 years ago.  These days PHP is considered a general-purpose scripting language and its speed now rivals other popular languages such as Python.


## Authors

* **Mike Lee** - *Lakestone Labs* - [LakestoneLabs](https://github.com/lakestonelabs)

## License

This project is licensed under the GPL 3 license - see the [LICENSE.md](gpl.md) file for details


