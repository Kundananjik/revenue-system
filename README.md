# Revenue Management System

A Laravel-based financial management platform for tracking revenues, payments, penalties, and maintaining comprehensive audit trails.

[![Tests](https://github.com/laravel/framework/workflows/tests/badge.svg)](https://github.com/laravel/framework/actions)
[![License](https://img.shields.io/packagist/l/laravel/framework)](https://opensource.org/licenses/MIT)

## Overview

Enterprise-grade revenue tracking system with role-based access control, automated financial calculations, and complete audit logging. Built for organizations requiring detailed financial oversight and compliance tracking.

## Features

### Core Functionality
- **Revenue Management**: Category-based organization with hierarchical item tracking
- **Payment Processing**: Multi-payment support with automated reconciliation
- **Penalty System**: Automated penalty calculations with configurable rules
- **Audit Trail**: Complete action logging for compliance and forensic analysis
- **User Roles**: Super admin and standard user permissions with granular access control

### Technical Features
- Observer pattern for automated revenue updates
- Real-time dashboard with financial metrics
- RESTful API architecture
- Responsive UI with Tailwind CSS
- Comprehensive test coverage with Pest

## Requirements

- PHP 8.2+
- Composer 2.x
- Node.js 18+ / npm 9+
- MySQL 8.0+ / PostgreSQL 14+
- Redis (optional, for caching/queues)

## Installation

### 1. Clone and Setup
```bash
git clone <repository-url>
cd revenue-system
composer install
npm install
```

### 2. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

Configure `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=revenue_system
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 3. Database Setup
```bash
php artisan migrate
php artisan db:seed
```

Default credentials (change immediately):
- Email: `admin@example.com`
- Password: (check `SuperAdminSeeder`)

### 4. Build Assets
```bash
npm run build  # Production
npm run dev    # Development with hot reload
```

### 5. Start Application
```bash
php artisan serve
# Access at http://localhost:8000
```

## Architecture

```
app/
├── Models/
│   ├── RevenueCategory.php
│   ├── RevenueItem.php
│   ├── Payment.php
│   └── Penalty.php
├── Observers/
│   └── RevenueItemObserver.php
├── Http/Controllers/
│   ├── RevenueCategoryController.php
│   ├── RevenueItemController.php
│   ├── PaymentController.php
│   └── PenaltyController.php
└── Services/
    └── AuditLogService.php
```

## Usage

### Managing Revenue Categories
```php
// Create category
POST /revenue-categories
{
    "name": "Property Tax",
    "description": "Annual property assessments"
}
```

### Recording Payments
```php
// Log payment
POST /payments
{
    "revenue_item_id": 1,
    "amount": 1500.00,
    "payment_date": "2024-01-15",
    "reference": "TXN-001"
}
```

### Accessing Audit Logs
```php
// View logs
GET /audit-logs?model=RevenueItem&model_id=1
```

## Testing

```bash
# Run all tests
./vendor/bin/pest

# Run specific suite
./vendor/bin/pest --filter=RevenueItemTest

# Generate coverage
./vendor/bin/pest --coverage
```

## Development

### Code Style
```bash
composer format  # PHP CS Fixer
npm run lint     # ESLint
```

### Database Refresh
```bash
php artisan migrate:fresh --seed
```

### Queue Workers
```bash
php artisan queue:work
```

## Deployment

### Production Checklist
- [ ] Set `APP_ENV=production` and `APP_DEBUG=false`
- [ ] Configure proper database credentials
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Set up queue workers with Supervisor
- [ ] Configure scheduled tasks in cron
- [ ] Enable HTTPS
- [ ] Set up backup automation

### Optimization
```bash
php artisan optimize
composer install --optimize-autoloader --no-dev
```

## Security

- All inputs are validated and sanitized
- SQL injection protection via Eloquent ORM
- CSRF protection on all state-changing operations
- Password hashing with bcrypt
- Role-based authorization checks
- Audit logging for sensitive operations

**Report vulnerabilities**: security@yourdomain.com

## API Documentation

Full API documentation available at `/api/documentation` (requires authentication).

## Troubleshooting

### Common Issues

**Migration errors**: Ensure database exists and credentials are correct
```bash
mysql -u root -p -e "CREATE DATABASE revenue_system"
```

**Permission errors**: Fix storage permissions
```bash
chmod -R 775 storage bootstrap/cache
```

**Asset compilation fails**: Clear npm cache
```bash
npm cache clean --force
rm -rf node_modules package-lock.json
npm install
```

## Contributing

1. Fork the repository
2. Create feature branch: `git checkout -b feature/feature-name`
3. Commit changes: `git commit -m 'Add feature'`
4. Push to branch: `git push origin feature/feature-name`
5. Submit pull request

### Commit Conventions
- `feat:` New feature
- `fix:` Bug fix
- `docs:` Documentation changes
- `refactor:` Code refactoring
- `test:` Test additions/modifications

## Authors & Contributors

**Lead Developer**
- **Kundananji Simukonda** - *System Architecture & Development* 
  - [GitHub](https://github.com/Kundananjik)
  - [LinkedIn](https://www.linkedin.com/in/kundananji-simukonda)
  - [Email](mailto:kundananjisimukonda@gmail.com)
  - Phone: +260971863462

See [CONTRIBUTORS.md](CONTRIBUTORS.md) for additional contributors.

## License

MIT License. See [LICENSE](LICENSE) file for details.

## Support

- Documentation: [docs/](docs/)
- Issues: [GitHub Issues](https://github.com/your-org/revenue-system/issues)
- Discussions: [GitHub Discussions](https://github.com/your-org/revenue-system/discussions)

---

**Version**: 1.0.0  
**Last Updated**: January 2026