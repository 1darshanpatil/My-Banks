#!/bin/bash
# A script to automate building and running the My-Banks application

# Ensure PHP is installed
if ! command -v php &> /dev/null; then
    echo "PHP is not installed. Please install PHP first."
    exit 1
fi

# Build the Phar file
echo "Building app.phar..."
php build-phar.php
chmod +x app.phar

if [ "$1" == "--install" ]; then
    echo "Installing app.phar to /usr/local/bin as 'mybanks'..."
    sudo mv app.phar /usr/local/bin/mybanks
    echo "Run the application anywhere using the command 'mybanks'."
else
    echo "Run the application using './app.phar'."
fi