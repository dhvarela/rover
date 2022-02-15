# Mars Rover
Before you start, review the [exercise instructions](EXERCISE.md)
##  System requirements:
- docker
- docker-compose

You will need to install Docker and Docker compose in your system.

## Get started

##### Clone the project

    $ git clone https://github.com/dhvarela/rover.git
    $ cd rover/

Open a terminal, go to the repository folder and enter to the "docker" folder.

Execute the initConfigFiles.bash script:
```
$ cd docker/
$ bash initConfigFiles.bash
```
    
##### Go to rover folder and up docker-compose to execute all the configurations and launch all the containers

    $ cd ../rover/
    $ docker-compose up -d --build

and check that all containers are "UP"

    $ docker ps -a | grep rover


```
CONTAINER ID        IMAGE           COMMAND                  CREATED             STATUS              PORTS                         NAMES
d6fc1d793f33        rover_nginx     "nginx -g 'daemon ..."   27 minutes ago      Up 27 minutes       443/tcp, 0.0.0.0:86->80/tcp   rover_nginx_1
e1829aa77512        rover_php       "docker-php-entryp..."   27 minutes ago      Up 27 minutes       9000/tcp                      rover_php_1
```

##### Pass the composer in container

    $ docker exec -it rover_php_1 bash
    $ cp .env.template .env
    $ composer install
    
##### Run the tests!!

    $ ./bin/phpunit --coverage-html tests/build/coverage-report

You can also run a command and test application by yourself passing your own arguments

    ./bin/console app:rover-start-mission <planet-dimensions> <pos-x> <pos-y> <direction> <instructions> [<planet-obstacles>...]

Arguments:
- planet-dimensions -> Planet dimensions
- pos-x -> Rover coordinate X
- pos-y -> Rover coordinate Y
- direction -> Rover direction
- instructions -> Rover instructions
- planet-obstacles -> Planet obstacles (separate multiple coordinates with a space) eg. 2,1 5,5

    
Example:

    ./bin/console app:rover-start-mission 10 2 2 N FFRFLF 2,4 2,5

In the example above, the planet has a 10x10 square terrain, rover starts at coordinate (2,2) and its direction is Nord, obstacles are in coordinates (2,4) and (2,5)