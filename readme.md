# Getting Started with Point of sale system

### Demo
[https://pos.ezportal.online](https://pos.ezportal.online)

Username: admin

Password: admin

A point of sale system built using [React.js](https://github.com/ahmedali5530/pos) + Tailwindcss and Symfony as a backend.
### Features

- Order management
- Inventory
- Expenses
- Multiple stores with multiple terminals
- Can support variants. i.e. sizes, colors, anything...
- Supports shortcuts for faster operations
- Day closing
- Supports multiple taxes
- Supports multiple discounts
- Customers management
- Suppliers management
- Supports Refunds

## Requirements
- Apache2/Nginx web server
- php >= 7.4
- MariaDB or Mysql or PostgreSQL
## Installation

- Edit .env file and update DATABASE_URL variable
- Create database using `php bin/console doctrine:database:create`
- Run migrations `php bin/console doctrine:migrations:migrate`
- Run fixtures to load demo data `php bin/console doctrine:fixtures:load`
- Run symfony server using `symfony server` or from apache2 or nginx vhosts
- Once your symfony instance is running copy the base url and paste it in the frontend module .env file under `VITE_API_HOST` variable.
- And start the react development server
