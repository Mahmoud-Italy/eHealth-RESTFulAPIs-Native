README
# Introduction

Set up the project using Docker.
Initialize the database and test data.
Run the server and API tests.

```bash
docker-compose up --build
```

# Project Structure
```bash
/app
    /controllers
        MedicationController.php
    /models
        Medication.php
    /helpers
        ImageHelper.php
/config
    connection.php
    database.php
/public
    index.php
/storage
    /images
/tests
    bootstrap.php
    MedicationTest.php
```


# Test
```bash
vendor/bin/phpunit
```
