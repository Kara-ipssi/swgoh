### RUN LOCALY 
- Clone the repository
- Install the dependencies
- set the environment variables in the .env file
- create the database (if not already created)
- run migrations
- run the server
``` bash
    git clone https://github.com/Kara-ipssi/swgoh
    cd swgoh
    composer install
    cp .env .env.local
    # set the environment variables in the .env.local file
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    php -S localhost:8000 -t public OR symfony serve
    Go to http://localhost:8000.
```

### RUN WITH DOCKER
- Clone the repository
- set the environment variables in the .env file or in the docker-compose.yml file
- run docker-compose
``` bash
    git clone https://github.com/Kara-ipssi/swgoh
    cd swgoh
    # set the environment variables in the .env file or in the docker-compose.yml file
    docker-compose up -d
    Go to http://localhost:{PORT}
```


## API DOCUMENTATION