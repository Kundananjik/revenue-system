# Security Policy

## Supported Versions

Security updates are provided for the following versions:

| Version | Supported          |
| ------- | ------------------ |
| 1.0.x   | :white_check_mark: |

## Reporting a Vulnerability

We take security vulnerabilities seriously. If you discover a security issue, please follow these steps:

### Do NOT:
- Open a public GitHub issue
- Disclose the vulnerability publicly before it has been addressed
- Exploit the vulnerability beyond what is necessary to demonstrate it

### DO:
1. **Email the details to**: kundananjisimukonda@gmail.com
2. **Include in your report**:
   - Description of the vulnerability
   - Steps to reproduce the issue
   - Potential impact assessment
   - Suggested fix (if available)
   - Your contact information for follow-up

### Response Timeline

- **Initial Response**: Within 48 hours
- **Status Update**: Within 7 days
- **Fix Timeline**: Depends on severity
  - Critical: 1-7 days
  - High: 7-14 days
  - Medium: 14-30 days
  - Low: 30-90 days

### What to Expect

1. **Acknowledgment**: Confirmation of receipt within 48 hours
2. **Assessment**: We'll evaluate the severity and impact
3. **Updates**: Regular status updates on progress
4. **Resolution**: Patch development and testing
5. **Disclosure**: Coordinated public disclosure after fix is deployed
6. **Credit**: Public acknowledgment in CHANGELOG (if desired)

## Security Best Practices

### For Developers

- Keep dependencies updated
- Run `composer audit` and `npm audit` regularly
- Never commit `.env` files or secrets
- Use prepared statements for database queries
- Validate and sanitize all user inputs
- Implement proper authentication and authorization
- Enable HTTPS in production
- Use CSRF tokens for state-changing operations
- Hash passwords with bcrypt (minimum cost: 12)
- Implement rate limiting on API endpoints

### For Deployment

- Set `APP_DEBUG=false` in production
- Use strong, unique passwords for database and admin accounts
- Restrict database access to application server only
- Enable firewall rules
- Keep server software updated
- Configure proper file permissions (775 for directories, 664 for files)
- Use environment variables for sensitive configuration
- Implement regular backup procedures
- Monitor logs for suspicious activity
- Use secure session configuration

## Known Security Considerations

- Role-based access control enforced at controller level
- SQL injection protection via Eloquent ORM
- XSS prevention through Blade templating
- CSRF protection on all POST/PUT/DELETE requests
- Password reset tokens expire after 60 minutes
- Session lifetime: 120 minutes by default

## Security Updates

Security patches will be released as needed and documented in [CHANGELOG.md](CHANGELOG.md) under the **Security** section.

Subscribe to releases on GitHub to be notified of security updates.

## Bug Bounty Program

Currently, we do not have a formal bug bounty program. However, we greatly appreciate responsible disclosure and will acknowledge security researchers in our CHANGELOG and documentation.

---

**Last Updated**: January 2026