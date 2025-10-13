# SmartElite Initiative - Laptop Application System

**Developed by Abdulmujib Nizary Migambile**

A comprehensive form builder and application system for the SmartElite Initiative, built with CodeIgniter 4. This system manages laptop applications for undergraduate students in Tanzania, providing affordable access to essential digital tools through partnerships with CRDB Bank Foundation and HESLB.

## About SmartElite Initiative

SmartElite is an innovative student-centered initiative designed to bridge the gap between higher education and digital inclusion in Tanzania. It focuses on empowering undergraduate students, particularly HESLB beneficiaries, with affordable access to essential digital tools, training, and support that enhance academic success, innovation, and employability.

### Key Statistics
- **201,000+** undergraduate students enrolled in 2023/24
- **76,000+** HESLB loan beneficiaries
- **5,000** target beneficiaries for 2025/26
- **20** universities across Tanzania
- **TZS 300,000** affordable laptop cost

## System Features

### Admin Panel
- **Authentication**: Secure login/logout system for administrators
- **Application Management**: View and manage laptop applications
- **Student Data**: Track HESLB numbers, university information, and application status
- **Export Functionality**: Export applications to CSV for processing
- **Dashboard**: Overview of application statistics and recent submissions

### Public Interface
- **Laptop Application Form**: Comprehensive application form for students
- **University Selection**: Dropdown with all 20+ Tanzanian universities
- **HESLB Integration**: Validation for HESLB loan numbers
- **Payment Agreement**: Clear terms for TZS 300,000 payment structure
- **Responsive Design**: Mobile-friendly Bootstrap 5 interface

## Tech Stack

- **Backend**: CodeIgniter 4 (PHP 8+)
- **Database**: MySQL
- **Frontend**: Bootstrap 5
- **Architecture**: MVC pattern

## Installation

### Prerequisites
- PHP 8.0 or higher
- MySQL 5.7 or higher
- Composer
- Web server (Apache/Nginx)

### Setup Steps

1. **Clone/Download the project**
   ```bash
   cd /path/to/your/web/directory
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure database**
   - Create a MySQL database named `smartelite`
   - Update database credentials in `app/Config/Database.php`
   - Or configure via environment variables in `.env`

4. **Run setup script**
   ```bash
   php setup.php
   ```
   
   This will:
   - Run database migrations
   - Seed the database with admin user and sample form
   - Set up writable directories

5. **Set web server document root**
   - Point your web server to the `public/` directory
   - Or use CodeIgniter's built-in server: `php spark serve`

## Default Credentials

After running the setup script, you can log in with:

- **Username**: `admin`
- **Email**: `admin@smartelite.com`
- **Password**: `admin123`

**⚠️ IMPORTANT**: Change the default password after first login!

## Usage

### Admin Panel
1. Access admin panel at `/admin/login`
2. Log in with admin credentials (admin/admin123)
3. View laptop applications and manage submissions
4. Export application data for processing
5. Monitor application statistics and trends

### Student Application Process
1. Students visit the homepage to learn about SmartElite
2. Click "Apply for Laptop" to access the application form
3. Fill out comprehensive application including:
   - Personal information
   - HESLB loan number
   - University and course details
   - Current device usage
   - Financial need explanation
   - Payment agreement acceptance
4. Submit application and receive confirmation
5. Applications are reviewed by administrators

## Database Structure

### Tables
- `users` - Admin users
- `forms` - Form definitions
- `form_fields` - Form field configurations
- `form_submissions` - Submitted form data

### Key Features
- **JSON Storage**: Form submissions stored as JSON for flexibility
- **Field Types**: Support for text, email, select, checkbox, radio, textarea, date, number, tel, file
- **Validation**: Custom validation rules per field
- **Ordering**: Drag & drop field ordering
- **Slugs**: SEO-friendly form URLs

## API Endpoints

### Public Routes
- `GET /` - SmartElite homepage with initiative information
- `GET /forms` - View all available forms
- `GET /register/{slug}` - Access specific form by slug
- `POST /register/{slug}` - Submit form data

### Admin Routes (Protected)
- `GET /admin` - Dashboard
- `GET /admin/forms` - List forms
- `GET /admin/forms/create` - Create form
- `POST /admin/forms/store` - Store form
- `GET /admin/forms/{id}/fields` - Manage fields
- `GET /admin/forms/{id}/submissions` - View submissions
- `GET /admin/forms/{id}/submissions/export` - Export CSV

## Customization

### Adding New Field Types
1. Update `form_fields.field_type` enum in migration
2. Add rendering logic in form views
3. Update validation in `Register` controller

### Styling
- Modify Bootstrap classes in view files
- Custom CSS in `public/assets/css/`
- Update layout templates in `app/Views/`

### Validation Rules
- Add custom rules in `app/Config/Validation.php`
- Use in form field configurations

## Security Features

- **CSRF Protection**: Enabled for all forms
- **Authentication**: Session-based admin authentication
- **Input Validation**: Server-side validation for all inputs
- **SQL Injection Protection**: CodeIgniter's built-in protection
- **XSS Protection**: Output escaping in views

## File Structure

```
SmartElite/
├── app/
│   ├── Controllers/
│   │   ├── Admin/          # Admin controllers
│   │   ├── Auth.php        # Authentication
│   │   └── Register.php    # Public form handling
│   ├── Models/             # Database models
│   ├── Views/              # View templates
│   ├── Database/
│   │   ├── Migrations/     # Database migrations
│   │   └── Seeds/          # Database seeders
│   └── Filters/            # Route filters
├── public/                 # Web-accessible files
├── writable/               # Logs, cache, sessions
└── setup.php              # Setup script
```

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check database credentials in `app/Config/Database.php`
   - Ensure MySQL service is running
   - Verify database exists

2. **Permission Errors**
   - Ensure `writable/` directory is writable
   - Run: `chmod -R 755 writable/`

3. **Form Not Found**
   - Check if form slug exists in database
   - Verify form is active (`is_active = 1`)

4. **CSRF Token Mismatch**
   - Clear browser cache
   - Check session configuration

### Logs
- Application logs: `writable/logs/`
- Database errors: Check MySQL error log
- Web server logs: Check Apache/Nginx logs

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is proprietary. Please check the LICENSE file for details.

## Support

For support and questions:
- **Developer**: Abdulmujib Nizary Migambile
- **Email**: migambile25@gmail.com
- Create an issue in the repository
- Check the troubleshooting section
- Review CodeIgniter 4 documentation

---

**SmartElite Initiative** - Bridging the gap between higher education and digital inclusion in Tanzania.

**Partners**: CRDB Bank Foundation, HESLB, Basil Link