# Employee Management REST API
## Overview
This Laravel application provides a RESTful API for managing employee data, including batch import functionality for processing CSV files. The API endpoints allow users to retrieve all employees, get details of a specific employee by ID, and delete an employee by ID.

## Installation
1. Clone this repository to your local machine:
```
git clone [<repository_url>](https://github.com/TDanica/lbx.git)

```
2. Navigate to the project directory:
```
cd lbx

```
3. Install dependencies using Composer:
```
composer install --no-dev
```

4. Set up your environment variables by copying the .env.example file to .env:
```
cp .env.example .env
```

5. Generate an application key:
```
cp .env.example .env
```
5. Configure your database connection in the .env file.

6. Migrate the database schema:
```
php artisan migrate
```

7. Run the Laravel development server:
```
php artisan serve
```

### Batch Employee Import
The API provides an endpoint for batch importing employee data from a CSV file.

### Endpoints
1. Start Redis service
```
 sudo service redis-server start
```
2. Start processing jobs from the queue using Redis as the queue driver.
```
 php artisan queue:work redis
```
POST /api/employee

```
curl -X POST -H 'Content-Type: text/csv' --data-binary @import.csv http://{yourapp}/api/employee
```


### Additional Considerations
In a real work scenario, I would incorporate the following additional features and improvements:


**Error Handling**: Enhance error handling to provide meaningful error messages and status codes for different scenarios, such as invalid input or database errors (more improved way of handling errors).

**Authentication**: Implement robust authentication mechanisms to ensure that only authorized users or applications can access my API. (API keys, OAuth 2.0, JWT, and OAuth tokens)

**Authorization**: Implement and enforce authorization rules to control what authenticated users can do within my API. Will define roles and permissions, and ensure that users only have access to the resources they are authorized to access.

 **HTTPS**: To encrypt the data exchanged between the client and the server, preventing eavesdropping and man-in-the-middle attacks.

**Rate Limit**: To prevent abuse of API by limiting the number of requests a client can make within a certain time period. This will protect API from brute force attacks, denial of service attacks, and excessive usage.

**Unit Testing**: Write comprehensive unit tests to ensure the reliability and stability of the application, covering both positive and negative scenarios.

**Documentation**: Provide detailed documentation for the API endpoints, including usage examples and response formats, to assist developers in integrating with the API.

**Logging**: Set up logging to record important events and errors, which can be useful for troubleshooting and monitoring the application in production environments. Already implemented but in more advanced way.

**Performance Optimization**: Identify and optimize performance bottlenecks, such as database queries or resource-intensive operations, to improve the overall responsiveness and scalability of the application.

**Rate Limiting**: Implement rate limiting to prevent abuse of your API by limiting the number of requests a client can make within a certain time period.

**Dokerize the application** using Laravel Sail.

