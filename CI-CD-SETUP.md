# CI/CD Setup for Slider GTA Plugin

## What's Been Set Up

Your plugin now has automated **Continuous Integration & Continuous Deployment (CI/CD)** using GitHub Actions.

## Workflows Created

### 1. **ci.yml** - Code Quality & Testing
**Runs on:** Every push and pull request to `main` and `UPDATE` branches

**Checks:**
- ✅ PHP Linting - Checks for PHP syntax errors
- ✅ Code Standards - WordPress Coding Standards compliance
- ✅ Structure Validation - Verifies required plugin files exist
- ✅ Security Checks - Verifies security best practices (nonce verification, sanitization, etc.)

### 2. **deploy.yml** - Deployment & Release
**Runs on:** Push to `main` branch

**Actions:**
- ✅ Creates release archive (ZIP file)
- ✅ Generates release notes
- ✅ Uploads artifacts for distribution

## How It Works

### When You Push Code
1. GitHub automatically detects the push
2. CI workflow starts automatically
3. All tests run in parallel
4. Results appear in GitHub Actions tab
5. Status badge shows on pull requests

### When Tests Fail
- Red ✗ indicator on commit
- PR cannot be merged (if branch protection enabled)
- You get detailed error logs
- Fix issues locally and push again

### When Tests Pass
- Green ✓ indicator on commit
- PR ready for review
- Deploy workflow runs (on main branch)
- Artifacts prepared for release

## Configuration Files

### `.github/workflows/ci.yml`
Main continuous integration workflow:
- PHP linting
- WordPress coding standards
- Plugin structure validation
- Security checks

### `.github/workflows/deploy.yml`
Deployment workflow:
- Creates plugin archive
- Generates release notes
- Uploads distribution files

### `composer.json`
Dependency management and script definitions:
- Specifies PHP requirements
- Dev dependencies (PHPCS, standards)
- Custom scripts for linting

### `phpcs.xml`
PHP CodeSniffer configuration:
- WordPress-Core standard
- Security rules
- PHP compatibility checks

## Local Development

### Setup Dependencies
```bash
composer install
```

### Run Local Linting
```bash
composer lint
```

### Auto-fix Issues
```bash
composer fix
```

## GitHub Actions Dashboard

View your workflows:
1. Go to your repository: https://github.com/imranniaz-st/SliderGTA
2. Click **Actions** tab
3. See all workflow runs
4. Click on a run to see detailed logs

## Branch Protection Rules (Optional)

To require tests to pass before merging:

1. Go to **Settings → Branches**
2. Click **Add rule**
3. Branch name pattern: `main`
4. Check: "Require status checks to pass before merging"
5. Select CI checks you want required

## Workflow Status Badges

Add to your README.md:
```markdown
![CI/CD](https://github.com/imranniaz-st/SliderGTA/workflows/PHP%20Linting%20&%20Code%20Standards/badge.svg)
![Deploy](https://github.com/imranniaz-st/SliderGTA/workflows/Deploy%20to%20Repository/badge.svg)
```

## What Gets Checked

### PHP Syntax
```php
// ✓ Correct
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ✗ Will fail
if ( ! defined( 'ABSPATH' ) ) exit;
```

### WordPress Standards
- Proper escaping: `esc_html()`, `esc_attr()`
- Proper sanitization: `sanitize_*()` functions
- Proper nonce verification: `wp_verify_nonce()`
- Proper indentation: 4 spaces
- Proper naming: snake_case for variables

### Plugin Structure
Required files checked:
- `slider-gta.php` - Main plugin file
- `includes/class-*.php` - Core classes
- `assets/css/slider-gta.css` - Styles
- `assets/js/slider-gta.js` - Scripts
- `README.md` - Documentation

## Troubleshooting

### Workflow not running?
- Check `.github/workflows/` files exist
- Make sure file paths are correct
- Verify branch names in triggers

### Tests failing locally?
```bash
# Install dependencies
composer install

# Run linting
composer lint

# Auto-fix issues
composer fix
```

### PHP version issues?
Edit `.github/workflows/ci.yml` line 15:
```yaml
php-version: '7.4'  # Change to your version
```

## Best Practices

✅ **Always test locally before pushing:**
```bash
composer lint
composer fix
git add .
git commit -m "Fix: code standards"
git push
```

✅ **Use meaningful commit messages:**
```
Feature: add new slider effect
Fix: corrected admin image ordering
Update: improved documentation
```

✅ **Create pull requests for changes:**
1. Push to UPDATE branch
2. Create PR to main
3. Wait for CI to pass
4. Review and merge

✅ **Keep dependencies updated:**
```bash
composer update
```

## Next Steps

1. ✅ CI/CD is now active
2. Make a change and push to test
3. Check Actions tab to see workflows run
4. Watch the green ✓ appear
5. Celebrate automated testing! 🎉

## More Information

- [GitHub Actions Documentation](https://docs.github.com/en/actions)
- [WordPress Coding Standards](https://github.com/WordPress/WordPress-Coding-Standards)
- [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
