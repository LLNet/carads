# Indexed's Quick WP Plugin

## How to use
1. Start by cloning this repo (duh!).
2. Create a new branch for YOUR plugin, with the plugin name as branch name.
3. Edit the `package.json` to have the correct name. This will be used to determine the resulting plugin `.zip` filename.

## CSS / JS compiling

There are two main scripts built in. One for developing and one for compiling to production (minifying)

When developing you can use:

    npm run dev                   // short-hand  
    npm run development

for a one-time run of the script, and 

    npm run watch
    
for a continued watch of any file changes (to `.js` and `.scss`) and rebuild when a change occurs.   

Before building the zip (read below), you should run

    npm run prod                   // short-hand
    npm run production 

This command will compile the minified versions of the js and css files.

## Building the zip file
Building the plugin zip file is an easy task. In command line enter:

    gulp zip

A zip file will be made and put into the parent directory. It will strip the plugin from unwanted files and directories in the zip. In example: `node_modules`, `webpack.mix.js`, this readme and more.
The file will be named after the name in the package.json.
To have more files stripped add them to the `gulpfile.js`