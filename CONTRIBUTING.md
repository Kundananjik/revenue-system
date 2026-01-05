# Contributing to Revenue Management System

Thank you for considering contributing to this project. This guide will help you get started.

## Table of Contents

- [Getting Started](#getting-started)
- [Development Workflow](#development-workflow)
- [Coding Standards](#coding-standards)
- [Commit Guidelines](#commit-guidelines)
- [Pull Request Process](#pull-request-process)
- [Testing](#testing)
- [Documentation](#documentation)

## Getting Started

### Prerequisites

- PHP 8.2+
- Composer 2.x
- Node.js 18+
- MySQL 8.0+ or PostgreSQL 14+
- Git

### Setup

1. Fork the repository
2. Clone your fork:
   ```bash
   git clone https://github.com/YOUR_USERNAME/revenue-system.git
   cd revenue-system
   ```

3. Add upstream remote:
   ```bash
   git remote add upstream https://github.com/Kundananjik/revenue-system.git
   ```

4. Install dependencies:
   ```bash
   composer install
   npm install
   ```

5. Configure environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

6. Set up database:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

## Development Workflow

### Creating a Feature

1. Update your local repository:
   ```bash
   git checkout main
   git pull upstream main
   ```

2. Create a feature branch:
   ```bash
   git checkout -b feature/your-feature-name
   ```

3. Make your changes and commit regularly

4. Push to your fork:
   ```bash
   git push origin feature/your-feature-name
   ```

5. Open a Pull Request

### Branch Naming

- `feature/` - New features
- `fix/` - Bug fixes
- `refactor/` - Code refactoring
- `docs/` - Documentation updates
- `test/` - Test additions/updates
- `chore/` - Maintenance tasks

Examples:
- `feature/payment-export`
- `fix/penalty-calculation`
- `docs/api-documentation`

## Coding Standards

### PHP

Follow PSR-12 coding standards:

```bash
# Check code style
./vendor/bin/phpcs

# Fix code style automatically
./vendor/bin/phpcbf
```

**Key conventions:**
- Use type hints for parameters and return types
- DocBlocks for all classes and methods
- Single responsibility principle
- Meaningful variable and method names
- Keep methods under 30 lines when possible

### JavaScript

Follow Airbnb JavaScript Style Guide:

```bash
# Check style
npm run lint

# Fix automatically
npm run lint:fix
```

### Database

- Use migrations for schema changes
- Include rollback logic in migrations
- Follow Laravel naming conventions:
  - Tables: plural snake_case (`revenue_items`)
  - Foreign keys: `table_id` (`revenue_category_id`)
  - Pivot tables: alphabetical order (`payment_revenue_item`)

## Commit Guidelines

### Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types

- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes (formatting, missing semicolons)
- `refactor`: Code refactoring
- `test`: Adding or updating tests
- `chore`: Maintenance tasks
- `perf`: Performance improvements

### Examples

```bash
feat(payments): add export to Excel functionality

Implement Excel export for payment records using PhpSpreadsheet.
Users can now export filtered payment data.

Closes #123
```

```bash
fix(penalties): correct calculation for late payments

Fixed decimal precision issue in penalty calculation that caused
rounding errors for amounts over 1000.

Fixes #456
```

### Rules

- Use imperative mood ("add" not "added")
- Capitalize first letter
- No period at the end
- Limit subject to 50 characters
- Wrap body at 72 characters
- Reference issues and PRs in footer

## Pull Request Process

### Before Submitting

- [ ] Code follows project style guidelines
- [ ] All tests pass: `./vendor/bin/pest`
- [ ] New tests added for new features
- [ ] Documentation updated
- [ ] No console errors or warnings
- [ ] Migrations tested (up and down)
- [ ] Self-review completed

### PR Template

```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Testing
Steps to test the changes

## Screenshots (if applicable)

## Checklist
- [ ] Tests pass
- [ ] Documentation updated
- [ ] No breaking changes (or documented)

## Related Issues
Closes #issue_number
```

### Review Process

1. Automated checks must pass
2. At least one maintainer approval required
3. All review comments addressed
4. Conflicts resolved with main branch
5. Maintainer will merge when ready

## Testing

### Running Tests

```bash
# All tests
./vendor/bin/pest

# Specific test file
./vendor/bin/pest tests/Feature/PaymentTest.php

# With coverage
./vendor/bin/pest --coverage

# Watch mode
./vendor/bin/pest --watch
```

### Writing Tests

- Test file per feature/class
- Descriptive test names
- Arrange-Act-Assert pattern
- Test edge cases and error handling

**Example:**

```php
test('payment can be recorded for revenue item', function () {
    // Arrange
    $revenueItem = RevenueItem::factory()->create();
    
    // Act
    $payment = Payment::create([
        'revenue_item_id' => $revenueItem->id,
        'amount' => 1000.00,
        'payment_date' => now(),
    ]);
    
    // Assert
    expect($payment->amount)->toBe(1000.00);
    $this->assertDatabaseHas('payments', [
        'revenue_item_id' => $revenueItem->id,
    ]);
});
```

## Documentation

### Code Documentation

- Document all public methods
- Include parameter types and return types
- Explain complex logic
- Update PHPDoc blocks

### User Documentation

- Update README for major changes
- Add examples for new features
- Update API documentation
- Include migration guides for breaking changes

## Questions?

- Open a [Discussion](https://github.com/Kundananjik/revenue-system/discussions)
- Email: kundananjisimukonda@gmail.com
- Review existing [Issues](https://github.com/Kundananjik/revenue-system/issues)

## Recognition

Contributors will be added to [CONTRIBUTORS.md](CONTRIBUTORS.md) and acknowledged in release notes.

---

**Thank you for contributing!**