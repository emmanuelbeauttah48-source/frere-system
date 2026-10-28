<<<<<<< HEAD
# Kisimani House Management System

A modern property and residential management platform designed to simplify the management of estates, blocks, floors, houses, unit types, facilities, and amenities from a centralized administrative dashboard.

## About the System

**Kisimani House Management System** is a web-based property management solution built to provide an organized and efficient way of managing residential properties and their related information.

The system enables administrators and authorized users to manage the complete structure of a residential development — from **estates and blocks down to individual houses and unit types**.

Instead of relying on spreadsheets, paper records, or disconnected systems, Kisimani provides a centralized platform where property information can be stored, updated, searched, and monitored efficiently.

The system is designed with scalability in mind, allowing additional property-management features to be integrated as the platform grows.

---

## System Objectives

The main objectives of the Kisimani House Management System are to:

* Centralize residential property information.
* Simplify estate and property administration.
* Manage houses and their associated unit types.
* Organize properties by estates, blocks, and floors.
* Maintain accurate property specifications and pricing.
* Manage available facilities and amenities.
* Provide administrators with an intuitive management dashboard.
* Reduce manual record keeping.
* Improve accessibility and organization of property data.
* Provide a foundation for future property-management functionality.

---

## property Structure

The system organizes properties using a structured hierarchy:

Estate
   │
   ├── Block
   │     │
   │     ├── Floor
   │     │     │
   │     │     ├── House
   │     │     ├── House
   │     │     └── House
   │     │
   │     └── Floor
   │
   └── Block


This structure allows administrators to easily locate and manage individual properties within a larger residential development.

---

## Core Features

### Dashboard

The administrative dashboard provides a centralized overview of the property management system.

It is designed to give administrators quick access to important areas of the system and provide a clear view of the overall property portfolio.

---

### Estate Management

Administrators can create and manage residential estates.

Estate information can include:

* Estate name
* Estate code
* Location
* Description
* Estate manager
* Contact information
* Estate status

This provides a centralized record of each residential development managed by the system.

---

### Block Management

Blocks can be associated with individual estates and used to organize residential buildings.

The system supports management of information such as:

* Block name
* Block code
* Estate
* Number of floors
* Number of units

### Floor Management

Floors provide another level of organization between blocks and individual houses.

Administrators can manage floors and associate them with their respective blocks.

This makes it easier to locate houses within multi-storey residential buildings.

### House Management

The House Management module is one of the core components of the system.

Administrators can manage individual residential units and associate them with:

* Estates
* Blocks
* Floors
* Unit Types

House information can be used to maintain an organized record of individual properties within the development.

### Unit Type Management

Unit Types allow properties to be categorized according to their residential configuration.

Examples include:

* Studio
* One Bedroom
* Two Bedroom
* Three Bedroom
* Four Bedroom

Each unit type can contain information such as:

* Unit type name
* Unit code
* Description
* Number of bedrooms
* Number of bathrooms
* Floor area
* Area measurement unit
* Base price
* Billing period
* Active/inactive status
* Floor plan
* Amenities

This makes it possible to maintain consistent specifications for different types of residential units.


### Facilities Management

The system provides a dedicated area for managing facilities available within the residential development.

Facilities can be used to document services and infrastructure provided within an estate or property.

Examples may include:

* Parking
* Security
* Swimming pool
* Gym
* Children's playground
* Community areas

---

### Amenities Management

Amenities can be managed separately to provide additional information about features available to residents.

The system provides a foundation for maintaining an organized list of amenities associated with properties or developments.

---

## Property Pricing

The system supports property pricing through unit types.

Unit types can have a configurable base price and billing period, including:

* Daily
* Weekly
* Monthly
* Yearly
* One-time

Prices can therefore be configured according to the property's intended rental or pricing structure.

---

## Search & Filtering

The administrative interface provides tools for efficiently finding and organizing property information.

Unit types, for example, can be searched and filtered based on information such as:

* Unit type
* Code
* Number of bedrooms
* Billing period
* Active/inactive status

This allows administrators to quickly locate the records they need.

---

## Administration & Access Control

The system is designed around an administrative interface where authorized users can manage property information.

Access control can be extended to support different administrative responsibilities and permissions as the system develops.

---

## Technology Stack

Kisimani House Management System is built using modern web development technologies.

### Backend

* PHP 8.4
* Laravel 13
* Laravel Eloquent ORM

### Administration Panel

* Filament

### Database

* MySQL

### Frontend

* Blade
* Livewire
* Filament UI

### Development Environment

* Laravel Herd
* Composer
* Artisan
* Laravel Tinker

## Project Structure

The project follows Laravel's standard application architecture with Filament resources organized around individual management modules.

app/
├── Filament/
│   └── Resources/
│       ├── Amenities/
│       ├── Blocks/
│       ├── Estates/
│       ├── Facilities/
│       ├── Floors/
│       ├── Houses/
│       └── UnitTypes/
│
├── Models/
│
database/
├── migrations/
└── seeders/

resources/
├── views/
└── css/

routes/
└── web.php

The modular structure makes the system easier to maintain and expand.

## Installation

### 1. Clone the repository

git clone <repository-url>
cd frere_system

### 2. Install PHP dependencies

composer install


### 3. Create the environment file

copy .env.example .env

For Linux/macOS:

cp .env.example .env

### 4. Generate the application key

php artisan key:generate

### 5. Configure the database

Update the `.env` file with your MySQL database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=frere_town
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Run migrations

```bash
php artisan migrate
```

### 7. Seed the database

php artisan db:seed

Or run migrations and seeders together:

```bash
php artisan migrate --seed
```

### 8. Clear application caches

```bash
php artisan optimize:clear
```

### 9. Start the application

```bash
php artisan serve
```

If you are using Laravel Herd, the project can also be accessed through its configured Herd domain.

---

## Development

Laravel Tinker can be used to inspect and manage application data during development:

```bash
php artisan tinker
```

For example, to inspect unit types:

```php
\App\Models\UnitType::all();
```

To inspect the database structure:

```php
Schema::getColumnListing('unit_types');
```

---

## Main Management Modules

| Module     | Purpose                                   |
| ---------- | ----------------------------------------- |
| Dashboard  | System overview and administrative access |
| Estates    | Manage residential estates                |
| Blocks     | Manage buildings within estates           |
| Floors     | Manage floors within blocks               |
| Houses     | Manage individual residential units       |
| Unit Types | Manage residential unit configurations    |
| Facilities | Manage estate/property facilities         |
| Amenities  | Manage available amenities                |

---

## Future Development

The Kisimani House Management System is designed to provide a foundation for additional property-management capabilities.

Potential future modules include:

* Tenant Management
* Landlord Management
* Lease Management
* Rental Payments
* M-Pesa Integration
* Maintenance Requests
* Property Inspections
* Utility Management
* Visitor Management
* Parking Management
* Notifications
* Document Management
* Financial Reports
* Occupancy Tracking
* Property Availability
* Automated Reports
* User Activity Logs

These features can be introduced progressively without changing the core property-management structure.

## Security

Security is an important part of the system's design.

The application uses Laravel's built-in security features and authentication mechanisms, while administrative access can be controlled through roles and permissions.

Sensitive configuration values should always be stored in the `.env` file and should never be committed to version control.

---

## Project Status

**Kisimani House Management System** is currently under active development.

Core property-management functionality is being developed around:

* Estates
* Blocks
* Floors
* Houses
* Unit Types
* Facilities
* Amenities

Additional management, financial, tenant, and reporting functionality can be added as development progresses.

---

## Developer

**Kisimani House Management System**

Built with:

**Laravel · Filament · MySQL · PHP**

## License

This project is intended for the management and administration of residential properties.

For licensing and usage information, refer to the project's applicable license and deployment agreement.
=======
# frere-system
>>>>>>> 5db1107b189aea65299cfd1559093ec5bd8ae3fd
