# CONTRIBUTING.md

## Welcome Contributors! 👋

We're excited that you're interested in contributing to this project. This document provides guidelines and instructions for contributing.

## Code of Conduct

### Our Standards
- Be respectful and inclusive
- Welcome newcomers and help them get started
- Accept constructive criticism gracefully
- Focus on what's best for the community
- Show empathy towards other contributors

### Unacceptable Behavior
- Harassment or discriminatory language
- Personal attacks or trolling
- Publishing others' private information
- Other conduct deemed inappropriate

## Getting Started

### Prerequisites
```bash
- PHP >= 8.1
- Composer
- Node.js & npm
- Git
- MySQL or PostgreSQL database (for local development)
- Daily.co account (for video/audio calls functionality)
- Paystack account (for payment processing functionality)
- VS Code or a similar IDE with PHP/Laravel extensions (recommended)
```

### Development Setup
```bash
# 1. Clone the repository
git clone https://github.com/your-repo/dr-fintan-medical-appointment.git
cd dr-fintan-medical-appointment

# 2. Install PHP dependencies
composer install

# 3. Install Node.js dependencies
npm install

# 4. Copy .env.example and configure your environment
cp .env.example .env
# Edit .env with your database credentials, Daily.co API key, and Paystack API keys
# php artisan key:generate (if APP_KEY is not set)

# 5. Run database migrations
php artisan migrate

# 6. Seed the database (optional, for demo data)
php artisan db:seed

# 7. Link storage to public (for profile images, etc.)
php artisan storage:link

# 8. Start the development server
php artisan serve
# Application will be accessible at http://127.0.0.1:8000

# 9. Create a new branch for your feature/fix
git checkout -b feature/your-feature-name
```

## Development Workflow

### Branch Naming
- `feature/` - New features
- `fix/` - Bug fixes
- `docs/` - Documentation updates
- `refactor/` - Code refactoring
- `test/` - Test additions/updates
- `chore/` - Maintenance tasks

### Making Changes
1. **Update your local main branch**
   ```bash
   git checkout main
   git pull origin main
   git checkout -b feature/your-feature-name
   ```

2. **Implement your changes**
   - Write clean, readable PHP and JavaScript code following PSR-12 and JavaScript/ESLint standards.
   - Add tests for new features or bug fixes using PHPUnit.
   - Update relevant documentation (e.g., `docs/` files, `README.md`).

3. **Test your changes**
   ```bash
   php artisan test
   npm run dev # or npm run build
   # Manually test the feature in the browser
   ```

## Code Style Guide

### PHP
- Follow PSR-12 coding standard. Laravel Pint can be used for automatic formatting.
- Use type hints for function arguments and return types.
- Prefer Laravel's Eloquent ORM for database interactions.

### JavaScript/Blade
- Use clear, descriptive variable and function names.
- Keep Blade templates clean and logic-free where possible, delegating complex logic to controllers or view composers.

### File Organization
```
app/
├── Http/Controllers/ # Organize by user role (admin, doctor, user) and functionality (API, auth)
├── Models/           # Eloquent models
├── Services/         # Business logic and external API integrations
resources/
├── js/               # Frontend JavaScript
├── views/            # Blade templates (organized by sections/roles)
```

### Naming Conventions
- **PHP Classes**: PascalCase (`UserController`, `AppointmentService`)
- **PHP Methods/Variables**: camelCase (`getUser`, `totalAppointments`)
- **Database Tables**: snake_case, plural (`users`, `appointments`)
- **Database Columns**: snake_case (`user_id`, `created_at`)
- **Blade Views**: kebab-case (`user-dashboard.blade.php`)

## Commit Guidelines

### Commit Message Format
```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation only changes
- `style`: Code style (formatting, semicolons, etc.)
- `refactor`: Code refactoring (no functional changes)
- `perf`: Performance improvements
- `test`: Adding missing tests or correcting existing tests
- `chore`: Build process or auxiliary tool changes

### Examples
```bash
# Good commit messages
feat(appointments): add doctor availability check
fix(auth): prevent XSS in login form
docs: update contributing guidelines
refactor(models): standardize user model relationships

# Bad commit messages
fix: fixed stuff
update code
WIP
```

### Commit Best Practices
- Keep commits atomic (one logical change per commit).
- Write clear, descriptive commit messages.
- Reference issues when applicable: `fixes #123`, `closes #456`.

## Pull Request Process

### Before Submitting
- [ ] Code follows Laravel and project-specific style guidelines.
- [ ] Self-review of code performed.
- [ ] Comments added for complex logic or non-obvious code.
- [ ] Relevant documentation updated (if applicable).
- [ ] New features have corresponding tests; bug fixes have regression tests.
- [ ] All automated tests are passing.
- [ ] Frontend assets compile without errors (`npm run dev` or `npm run build`).
- [ ] Application runs locally without errors (`php artisan serve`).

### PR Template
```markdown
## Description
Brief description of the changes made, why they were made, and what problem they solve.

## Type of Change
- [ ] Bug fix (non-breaking change which fixes an issue)
- [ ] New feature (non-breaking change which adds functionality)
- [ ] Breaking change (fix or feature that would cause existing functionality to not work as expected)
- [ ] Documentation update (changes to documentation files)

## Testing
Describe the tests that you ran to verify your changes. Provide instructions so we can reproduce.
- [ ] Unit tests (`php artisan test`)
- [ ] Feature/Integration tests (e.g., Postman for API, manual browser tests)

## Checklist
- [ ] My code follows the style guidelines of this project.
- [ ] I have performed a self-review of my own code.
- [ ] I have commented my code, particularly in hard-to-understand areas.
- [ ] I have made corresponding changes to the documentation.
- [ ] My changes generate no new warnings.
- [ ] I have added tests that prove my fix is effective or that my feature works.
- [ ] New and existing unit tests pass with my changes.
- [ ] Any dependent changes have been merged and published in downstream modules.

## Related Issues
Fixes #(issue number) or Closes #(issue number)

## Screenshots (if applicable)
```

### Review Process
1. Submit a Pull Request with a clear description and all required checklist items completed.
2. Address feedback and make necessary changes based on reviewer comments.
3. Keep your branch up-to-date with the main branch (`git pull upstream main`).
4. Once approved, your PR will be merged. Consider squashing commits if your branch has many small, iterative commits.
5. Delete your feature branch after it has been merged.

## Testing Guidelines

### Writing Tests
- Use PHPUnit for backend tests.
- Test files should mirror the directory structure of the code they test.
- Follow the Arrange-Act-Assert (AAA) pattern for test readability.

### Test Coverage
- Aim for high test coverage, especially for critical business logic.
- Focus on testing behavior, not implementation details.

## Documentation

### Code Documentation
- Use PHPDoc for PHP classes, methods, and properties.
- Use JSDoc for JavaScript functions.
- Keep `README.md` updated with setup instructions and project overview.

### API Documentation
- Update `docs/API.md` for any new or modified API endpoints.

## Release Process

### Versioning
We use [Semantic Versioning](https://semver.org/) (MAJOR.MINOR.PATCH):
- **MAJOR**: Incompatible API changes.
- **MINOR**: Add functionality in a backwards compatible manner.
- **PATCH**: Backwards compatible bug fixes.

### Creating a Release
1. Ensure all features/fixes for the release are merged into `main`.
2. Update version in `composer.json` and `package.json`.
3. Update `CHANGELOG.md` with release notes.
4. Create a git tag: `git tag -a vX.Y.Z -m "Version X.Y.Z"`.
5. Push the tag: `git push origin vX.Y.Z`.
6. Create a new release on GitHub from the tag.

## Getting Help

### Resources
- [Laravel Documentation](https://laravel.com/docs)
- [PHP Documentation](https://www.php.net/manual/en/)
- [Project Documentation](./docs)
- [Issue Tracker](https://github.com/owner/repo/issues) (if applicable)

### Asking Questions
- Search existing issues and documentation first.
- Provide clear, concise questions with relevant context (code snippets, error messages).

## Recognition

### Contributors
All contributors are recognized in:
- `README.md` contributors section.
- GitHub contributors page.
- Release notes.

### First-Time Contributors
We especially welcome first-time contributors! Look for issues labeled:
- `good first issue`
- `help wanted`

## Keywords <!-- #keywords -->
- contributing
- laravel
- development
- workflow
- pull request
- code style
- testing
- git
