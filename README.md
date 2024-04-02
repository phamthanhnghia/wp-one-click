

## WP One Click - A Dockerized Wordpress Solution

This project provides a simple way to set up a Wordpress site on your local machine using Docker.

**Prerequisites**

 - Make sure you have Docker and Docker-compose installed on your machine. If not, you can download and install from Docker's official site.
 
**Quick start guide**

1. Clone the git repository:

    git clone https://github.com/phamthanhnghia/wp-one-click.git
2. Navigate into the cloned directory:

    cd wp-one-click
3. Set up the Docker containers:

    ./up.sh
    
> If you encounter any permissions error, use the following command to
> grant execute permission and then try again:

    chmod +x up.sh

4. After the Docker containers are set up, open your web browser and visit http://localhost:8080. You should now see your Wordpress site.

Remember, this is the simple version of the instructions. Depending on your operating system and current software, these instructions may vary slightly. Enjoy your new Wordpress site!

Note: Please don't forget to modify the `.env` file with your custom settings before running the `up.sh` script.