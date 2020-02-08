# JASPER Framework

Current Stability: **Beta**

Just Another Simple PHP Engine Runtime framework

# Instructions
Install Jasper by installing this project as a composer project. This will create the required files and folders along
with an appropriate starting folder structure.

To be as complete as possible, this will also set up and configure a dependency injection container (PHP-DI) and a
logging system (Monolog). In addition, the site will use the Twig templating engine. The initial web site is built on
Bootstrap.

# Installation
Create a new site based on the JASPER framework using the following command:

    cd <path to folder where you want to install the site>
    php composer create-project jasperfw/jasper .
    
To run the site, point Apache or IIS virtual host to the `public` folder.

# Hello World - Getting Started
Once all the dependencies are installed, getting running on a server is very straighforward.
## Apache 2
Simply point the server or virtual host at the public directory. Make sure .htaccess files are enabled for URL
redirection. All the necessary settings for the site are in /public/.htaccess. Mod_rewrite must also be enabled on the
server in the Apache configuration.
## IIS 7 or later
Simply point the "Web Site" at the /public/ folder. Make sure Rewrite 2.0 or later is installed on the server.

# Initial Configuration
Basic setup of logging, dependency injection and framework initialization is done in /public/index.php. This is the
entry point of the application.