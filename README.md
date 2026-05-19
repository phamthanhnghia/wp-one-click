

## WP One Click - A Dockerized WordPress Solution

This project provides a simple way to set up a WordPress site on your local machine using Docker.

**Prerequisites**

 - Make sure you have Docker and Docker Compose installed on your machine.
 
**Quick start guide**

1. Clone the git repository:
```
    git clone https://github.com/phamthanhnghia/wp-one-click.git
```
2. Navigate into the cloned directory:
```
    cd wp-one-click
```
3. Create your local environment file:
```
    cp .env.example .env
```
Then edit `.env` and replace the example passwords.

4. Set up the Docker containers:
```
    ./up.sh
```
> If you encounter any permissions error, use the following command to
> grant execute permission and then try again:
```
    chmod +x up.sh
```
5. After the Docker containers are set up, open your web browser and visit http://localhost:8833. You should now see your WordPress site.

phpMyAdmin is available at http://localhost:8081.

Remember, this is the simple version of the instructions. Depending on your operating system and current software, these instructions may vary slightly.
