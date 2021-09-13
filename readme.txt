=== Delay Scripts ===

Contributors: sekedus
Donate link: https://sociabuzz.com/sekedus/donate
Tags: delay javascript, defer javascript, 3rd party scripts
Requires at least: 4.5
Tested up to: 5.8
Requires PHP: 5.6
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

This is a fork of the "[Flying Scripts by WP Speed Matters](https://wordpress.org/plugins/flying-scripts/)" plugin.

Download and execute JavaScript on user interaction.

## Quick Links

- [Demo video](https://youtu.be/YJ8TQ3bh-TA)
- [Donate](https://sociabuzz.com/sekedus/donate)
- [GitHub](https://github.com/sekedus/delay-scripts)

Delay Scripts delay the execution of JavaScript until there is no user activity. You can specify keywords to include JavaScripts to be delayed. There is also a timeout which executes JavaScript when there is no user activity.

### Why should I use this plugin?
JavaScript is very resource-heavy. By delaying the execution of non-critical JavaScript (that are not needed for the initial render), you're prioritizing and giving more resources to critical JavaScript files. This way you will reduce render time, time to interactive, first CPU idle, max Potential input delay etc. This will also reduce initial payload to browsers by reducing the no. of requests.

#### Contributors
- [Sekedus](https://sekedus.com/)

== Installation ==

1. Visit 'Plugins > Add New'
1. Search for 'Delay Scripts'
1. Activate Delay Scripts for WordPress from your Plugins page.
1. Visit Settings -> Delay Scripts to configure

== Screenshots ==
1. Delay Scripts Settings

== Frequently Asked Questions ==

= What are the ideal scripts to be included? =
Any script that is not crucial for rendering the first view or above fold contents. 3rd party scripts like tracking scripts, chat plugins, etc are ideal.

= What should I put in include keywords =
Any keyword inside your inline script that uniquely identifies that script. For example "fbevents.js" for Facebook Pixel, "gtag" for Google Tag Manager, "customerchat.js" for Facebook Customer Chat plugin.

= How is it different from `defer` =
`defer` tells browser to download the script when found and execute it when HTML parsing is complete. When you include a script in Delay Scripts, those scripts won't be executed until there is a user interaction.

= What is user interaction? =
Events from the user like mouse hover, scroll, keyboard input, touch in mobile device, etc.

= What is timeout? =
Even if there is no user interaction, scripts will be executed after the specified timeout.

== Changelog ==

= 1.0.0 =
- Initial version (based 1.2.2). This is a fork of the "Flying Scripts by WP Speed Matters" plugin, https://wordpress.org/plugins/flying-scripts/. All previous changelogs can be found there.
