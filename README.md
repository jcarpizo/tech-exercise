# Version-Controlled Key-Value API

A Laravel REST API for storing and retrieving key-value records, supporting timestamp-based lookups, duplicate-key validation, and caching.

## Technology Stack

- PHP 8.5
- Laravel 13
- MySQL 8.0
- Composer 2
- PHPUnit 13.4

## API Documentation

### Base URL

Local development:

```text
http://127.0.0.1:8000
```
All API requests should include:

```http
Accept: application/json
```

### 1. Store a Key-Value Pair

Creates a new key-value record.

**Endpoint**

```http
POST /api/object
```

Send exactly one key-value pair as a JSON object. The property name represents the key, and its value represents the stored value.

**Example using cURL**

```bash
curl -X POST http://127.0.0.1:8081/api/object \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"example_key":"example_value"}'
```

A successful request returns HTTP `201 Created`. Duplicate keys and invalid payloads are rejected by the API.

### 2. Get the Latest Key-Value Record

Retrieves the value associated with a key.

**Endpoint**

```http
GET /api/object/{key_name}
```

**Example**

```bash
curl -H "Accept: application/json" \
  http://127.0.0.1:8081/api/object/example_key
```

### 3. Get a Key-Value Record by Timestamp

Retrieves a record associated with a key and a specified Unix timestamp.

**Endpoint**

```http
GET /api/object/{key_name}?timestamp={timestamp}
```

**Example**

```bash
curl -H "Accept: application/json" \
  "http://127.0.0.1:8081/api/object/example_key?timestamp=1650206284"
```

The timestamp is expressed in Unix time, in seconds. If no matching record is found, the API returns HTTP `404 Not Found`.

### 4. Get All Key-Value Records

Retrieves all available key-value records.

**Endpoint**

```http
GET /api/object/get_all_records
```

**Example**

```bash
curl -H "Accept: application/json" \
  http://127.0.0.1:8000/api/object/get_all_records
```

## Local Development Setup

### Prerequisites

- PHP 8.5
- Composer 2
- MySQL 8.0
- Git

### 1. Clone the Repository

```bash
git clone https://github.com/jcarpizo/key-value.git
cd key-value
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Configure the Environment

Create your local environment file:

```bash
cp .env.example .env
```

Update the database settings in `.env`:

```dotenv
APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bus_service
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

Replace `your_mysql_password` with your MySQL password. Create the `bus_service` database before running migrations.

### 4. Generate the Application Key

```bash
php artisan key:generate
```

### 5. Run Migrations and Seeders

```bash
php artisan migrate:fresh --seed
```

**Warning:** `migrate:fresh` drops all tables in the configured database before recreating them. Use it only with a development database whose data can be deleted.

### 6. Start the Development Server

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

The API will be available at:

```text
http://127.0.0.1:8000
```

## Continuous Integration

The GitHub Actions workflow is located at:

```text
.github/workflows/laravel.yml
```


### 7. API Screenshots

### Create Key-Value
![Create Key-Value API](https://github.com/jcarpizo/tech-exercise/blob/master/screenshots/createvalue.png)

### Get Key-Value
![Get Key-Value API](https://github.com/jcarpizo/tech-exercise/blob/master/screenshots/getkey.png)

### Get by Timestamp
![Get by Timestamp API](https://github.com/jcarpizo/tech-exercise/blob/master/screenshots/keytimestamp.png)

### Get All Records
![Get All Records API](https://github.com/jcarpizo/tech-exercise/blob/master/screenshots/allrecords.png)

### 8. GitHub Workflow, Code Test Coverage

![GitHub Workflow](https://github.com/jcarpizo/tech-exercise/blob/master/screenshots/workflow.png)

![GitHub Workflow](https://github.com/jcarpizo/tech-exercise/blob/master/screenshots/workflowcoverage.png)

![GitHub Workflow](https://github.com/jcarpizo/tech-exercise/blob/master/screenshots/testcoverage.png)
