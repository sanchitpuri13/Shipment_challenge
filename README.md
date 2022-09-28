# Shipment Data sync process and Rest API Application#

## Resources

- [Docker](https://www.docker.com/) as the container service to isolate the environment.
- [NGINX](https://www.nginx.com/) as a Web Server layer
- [PHP](https://php.net/) to develop backend support.
- [Symfony](https://symfony.com/) as the server framework layer
- [MySQL](https://mysql.com/) as the database layer
- [Api-Platform](https://api-platform.com/) for Open API specification

## How to Setup and Execute

1.  Clone the repository
2.  Run `start.sh` to build docker containers, executing migration, executing import process and PHPunit test cases
3.  Import process will be executed automatically by start.sh script. If you want to execute it by yourself run php bin/console app:import:shipments inside project root directory

## How to access OpenAPI Specification

1. API specification can be accessed at URL http://localhost:8080/api/

## API Documentation

1.  Get shipments

    Method: GET

    URL Path: http://localhost:8080/api/shipments?page=pagenumber&company.name[]=company_name&carrier.name[]=carrier_name

        Query Parameters
            Page : integer
            company.name : array
            carrier.name : array

    Responses:

        Success Response:
        	[
                {
                    "id": 4240,
                    "distance": 340579,
                    "time": 3,
                    "company": {
                    "name": "Ms. Pansy Tremblay",
                    "email": "tressa.mayert@yahoo.com"
                    },
                    "carrier": {
                    "name": "Onie Lowe",
                    "email": "maida.corwin@gmail.com"
                    },
                    "route": [
                    {
                        "stop_id": 250456,
                        "postcode": "19217",
                        "city": "Schlagsdorf",
                        "country": "DE"
                    },
                    {
                        "stop_id": 270605,
                        "postcode": "82418",
                        "city": "Riegsee",
                        "country": "DE"
                    }
                    ],
                    "cost": 81.09
                },
                {
                    "id": 10958,
                    "distance": 507627,
                    "time": 5,
                    "company": {
                    "name": "Sam Feil",
                    "email": "beau44@heidenreich.info"
                    },
                    "carrier": {
                    "name": "Christophe Rodriguez",
                    "email": "danial.romaguera@yahoo.com"
                    },
                    "route": [
                    {
                        "stop_id": 729402,
                        "postcode": "16918",
                        "city": "Freyenstein",
                        "country": "DE"
                    },
                    {
                        "stop_id": 96395,
                        "postcode": "86916",
                        "city": "Kaufering",
                        "country": "DE"
                    }
                    ],
                    "cost": 106.14
                }
        	    ...
        	]
