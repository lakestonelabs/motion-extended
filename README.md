# Motion-extended
A wrapper script that adds extra functionality to the [motion](https://motion-project.github.io/) video signaling program.  The first focus of motion-extended was to add scheduling functionality to motion.  More functionality will be added in the future such as sending notificadtions to various endpoints such as email, Riot(matrix), Slack and more. 

### Prerequisites

* Linux
* One or more cameras supported by [motion](https://motion-project.github.io/) .
* PHP CLI >= 7.x
* [Motion](https://motion-project.github.io/) .  This program is usually found in the main repositories of your favorite Linux distro.
* [The PHP Cron Expression Parser](https://github.com/dragonmantank/cron-expression) - This is needed to process the cron expressions defined for each camera so motion-exteded can determine when to enable/disable them.

## Getting Started

* Setup motion's configuration files as you usually would.  It's highly recommended you use motion's 'cron.d' directory to define each camera's attributes.
* Configure motion-extended's configuration file (motion-ext.json) to contain the cron expression(s) for each camera for when you want to capture motion.
* Run 'motion-ext'.  Don't forget to supply the -c and -e switches which are mandatory.
* Enjoy!


## Authors

* **Mike Lee** - *Lakestone Labs* - [LakestoneLabs](https://github.com/lakestonelabs)

## License

This project is licensed under the GPL 3 license - see the [LICENSE.md](gpl.md) file for details


