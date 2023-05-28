# Jump Park Project API

This is the API documentation for the Jump Park project, providing endpoints for the system resources.

## Requirements

- PHP 8.1 or newer
- Laravel 10.x

## Install

1. Clone the project repo:

```
git clone git@bitbucket.org:martinslmendes/jump-park.git
```

2. Install project dependencies using Composer:

```
composer install
```

3. Start the development server:

```
php artisan serve
```

The API will be available on the address `http://127.0.0.1:8000/`.

## Endpoints

Here's a list of all available endpoints, all of them must be preceded by `api/`

### Listing

- `POST /service-orders/index`: Returns a list of all service orders, limited by 5 per page

Available filters

* **vehiclePlate:** Filters by vehicle plate
* **page:** selects the page to view
* **limit:** change the quantity of registers per page, remains limited by 5

### Storage

- `POST /service-orders/store`: Stores a new register on service orders

Available fields

* **vehiclePlate:** char(7)
* **entryDateTime:** datetime on format Y-m-d H:i:s
* **exitDateTime:** datetime on format Y-m-d H:i:s
* **priceType:** varchar(55)
* **price:** decimal(12,2)
* **userId:** foreign key for users

All fields are required. If any field is invalid, the API will return an error message informing which field(s) are wrong. 
