# SmartElite Form Builder & Registration System - User Guide

**Developed by Abdulmujib Nizary Migambile**

## Table of Contents
1. [System Overview](#system-overview)
2. [Getting Started](#getting-started)
3. [Admin Panel Guide](#admin-panel-guide)
4. [Public Form Submission](#public-form-submission)
5. [Security Features](#security-features)
6. [Advanced Features](#advanced-features)
7. [Troubleshooting](#troubleshooting)
8. [API Integration](#api-integration)
9. [Best Practices](#best-practices)

---

## System Overview

The SmartElite Form Builder and Registration System is a comprehensive solution for creating, managing, and processing dynamic forms. The system is built with CodeIgniter 4 and provides both administrative and public interfaces.

### Key Features
- **Dynamic Form Builder**: Create forms with various field types
- **Bulk Field Management**: Add multiple fields at once
- **Smart Field Naming**: Auto-generate field names from labels
- **Primary Form System**: Designate main forms for easy access
- **Soft Delete System**: Restore accidentally deleted content
- **Email & SMS Notifications**: Automated notifications via Brevo and Textify
- **Duplicate Detection**: Prevent duplicate submissions
- **Rate Limiting**: Protect against spam and abuse
- **CSRF & Honeypot Protection**: Advanced security measures
- **Export Functionality**: Download submissions as CSV
- **Forms Gallery**: Public discovery of available forms

---

## Getting Started

### System Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- CodeIgniter 4 framework

### Initial Setup
1. **Database Configuration**: Update `app/Config/Database.php` with your database credentials
2. **Run Migrations**: Execute database migrations to create tables
3. **Seed Data**: Run seeders to create sample forms and admin user
4. **Configure Notifications**: Set up Brevo and Textify API keys in `app/Config/Notifications.php`

### Default Admin Access
- **Username**: `admin`
- **Password**: `admin123`
- **URL**: `/admin`

---

## Admin Panel Guide

### Dashboard Overview

The admin dashboard provides a comprehensive overview of your form system:

#### Key Metrics
- **Total Forms**: Number of active forms in the system
- **Total Submissions**: All-time submission count
- **Recent Submissions**: Latest form submissions (configurable limit: 5, 10, 20, 50)
- **Forms Overview**: Card-based view of all forms with direct actions

#### Dashboard Features
- **Configurable Submission Limit**: Use the dropdown to change how many recent submissions to display
- **Quick Actions**: Direct access to forms, submissions, notifications, and duplicate detection
- **Primary Form Indicator**: Visual badge showing which form is marked as primary
- **Submission Preview**: Quick preview of submission data without opening full details

### Form Management

#### Creating Forms
1. Navigate to **Forms** → **Create New Form**
2. Fill in form details:
   - **Title**: Display name for the form
   - **Slug**: URL-friendly identifier (auto-generated from title)
   - **Description**: Optional form description
   - **Success Message**: Message shown after successful submission
   - **Primary Form**: Check to make this the main form (only one can be primary)
3. Click **Create Form**

#### Form Field Management

##### Single Field Creation
1. Go to **Forms** → Select form → **Fields** → **Add Field**
2. Configure field properties:
   - **Field Label**: User-visible label (required)
   - **Field Name**: Technical identifier (auto-generated if empty)
   - **Field Type**: Choose from available types
   - **Field Options**: For select/radio/checkbox fields
   - **Required**: Mark field as mandatory
   - **Validation Rules**: Custom validation (optional)
3. Click **Create Field**

##### Bulk Field Creation
1. Go to **Forms** → Select form → **Fields** → **Bulk Add Fields**
2. Use the template system:
   - **Common Fields**: Pre-configured field templates
   - **Custom Fields**: Add your own fields
3. Configure each field or use templates
4. Click **Add All Fields**

##### Field Types Available
- **Text**: Single-line text input
- **Textarea**: Multi-line text input
- **Email**: Email address with validation
- **Tel**: Phone number with validation
- **Number**: Numeric input
- **Date**: Date picker
- **Select**: Dropdown selection
- **Radio**: Radio button group
- **Checkbox**: Multiple selection checkboxes
- **File**: File upload (basic support)

#### Form Status Management
- **Active/Inactive**: Toggle form availability
- **Primary Form**: Set one form as the main form
- **Soft Delete**: Remove forms while preserving data
- **Restore**: Recover deleted forms
- **Permanent Delete**: Completely remove forms and data

### Submission Management

#### Viewing Submissions
1. Navigate to **Forms** → Select form → **Submissions**
2. View submission details:
   - **Submission ID**: Unique identifier
   - **Data Preview**: Quick overview of submitted data
   - **Submission Date**: When the form was submitted
   - **IP Address**: Submitter's IP (for security)
   - **User Agent**: Browser information

#### Submission Actions
- **View Details**: Full submission data in organized format
- **Export CSV**: Download submission data
- **Soft Delete**: Remove from active view
- **Restore**: Recover deleted submissions
- **Permanent Delete**: Completely remove submission

#### Submission Data Display
- **Card-based Layout**: Organized, easy-to-read format
- **Smart Field Detection**: Automatic formatting for emails, phones, URLs
- **Array Handling**: Proper display of checkbox selections
- **Long Text Formatting**: Readable display of lengthy content

### Notification Management

#### Email Notifications (Brevo Integration)
1. Navigate to **Admin** → **Notifications**
2. Configure Brevo settings:
   - **API Key**: Your Brevo API key
   - **Sender Email**: From address for notifications
   - **Sender Name**: Display name for emails
3. Test email functionality

#### SMS Notifications (Textify Integration)
1. Configure Textify settings:
   - **API Key**: Your Textify API key
   - **Sender ID**: SMS sender identifier
2. Test SMS functionality

#### Notification Types
- **User Confirmation**: Sent to form submitter
- **Admin Alert**: Sent to administrators
- **Custom Templates**: Personalized message content

### Duplicate Detection

#### Overview
The system automatically detects and prevents duplicate submissions based on:
- **Email addresses**: Exact matches
- **Phone numbers**: Normalized comparison
- **Name combinations**: First name + last name matching
- **Custom criteria**: Configurable duplicate rules

#### Duplicate Statistics
1. Navigate to **Admin** → **Duplicates**
2. View duplicate prevention metrics:
   - **Total Duplicates Blocked**: Number of prevented duplicates
   - **Prevention Rate**: Percentage of duplicates blocked
   - **Form-specific Analysis**: Duplicate statistics per form

---

## Public Form Submission

### Form Discovery

#### Forms Gallery
1. Visit `/forms` to see all available forms
2. Browse forms in a clean, card-based layout
3. Each form shows:
   - **Title**: Form name
   - **Description**: Form purpose
   - **Access Button**: Direct link to form

#### Primary Form Access
- The primary form is prominently displayed on the homepage
- Direct access via homepage button
- Automatic redirection for main application forms

### Form Submission Process

#### Step-by-Step Guide
1. **Access Form**: Click on form from gallery or homepage
2. **Fill Form**: Complete all required fields
3. **Validation**: System validates input in real-time
4. **Submit**: Click submit button
5. **Confirmation**: Receive success message
6. **Notifications**: Get email/SMS confirmation

#### Form Features
- **Breadcrumb Navigation**: Easy navigation back to forms
- **Field Validation**: Real-time validation feedback
- **Required Field Indicators**: Clear marking of mandatory fields
- **CSRF Protection**: Automatic security token validation
- **Rate Limiting**: Protection against spam submissions

#### Success Page
After successful submission:
- **Confirmation Message**: Personalized success message
- **Form Title**: Dynamic display of submitted form
- **Navigation Options**:
  - Submit Another Application
  - View Other Forms
  - Return to Homepage

### Security Features for Users

#### Automatic Protection
- **CSRF Tokens**: Prevents cross-site request forgery
- **Rate Limiting**: Limits submissions per IP address
- **Input Validation**: Server-side validation of all inputs
- **Honeypot Fields**: Hidden fields to catch bots

#### User Experience
- **Clear Error Messages**: Helpful validation feedback
- **Progress Indicators**: Visual feedback during submission
- **Mobile Responsive**: Works on all device sizes
- **Accessibility**: Screen reader friendly

---

## Security Features

### Bot Protection

#### Rate Limiting
- **Hourly Limit**: 5 submissions per IP per form per hour
- **Daily Limit**: 20 submissions per IP per form per day
- **Automatic Reset**: Limits reset after time periods
- **User Feedback**: Clear messages when limits exceeded

#### Suspicious Activity Detection
- **Bot User Agents**: Detection of automated tools
- **Spam Keywords**: Filtering of suspicious content
- **Honeypot Fields**: Hidden fields to catch bots
- **Activity Logging**: Detailed logs of suspicious attempts

#### Input Validation
- **Server-side Validation**: All inputs validated on server
- **Field-specific Rules**: Custom validation per field type
- **Sanitization**: Automatic cleaning of user input
- **XSS Protection**: Prevention of cross-site scripting

### Data Protection

#### Soft Delete System
- **Data Preservation**: Deleted items can be restored
- **Audit Trail**: Track of all deletions and restorations
- **Admin Control**: Full control over data lifecycle
- **Recovery Options**: Easy restoration of accidentally deleted content

#### Database Security
- **Prepared Statements**: Protection against SQL injection
- **Input Escaping**: Automatic escaping of user input
- **Access Control**: Role-based access to admin functions
- **Session Management**: Secure session handling

---

## Advanced Features

### Bulk Operations

#### Bulk Field Creation
- **Template System**: Pre-configured field templates
- **Common Fields**: Quick access to frequently used fields
- **Custom Fields**: Add your own field configurations
- **Validation**: Automatic validation of all fields

#### Bulk Data Management
- **CSV Export**: Download all submissions
- **Batch Operations**: Process multiple items at once
- **Data Filtering**: Filter submissions by various criteria
- **Search Functionality**: Find specific submissions quickly

### Form Customization

#### Dynamic Field Types
- **Text Fields**: Various text input types
- **Selection Fields**: Dropdowns, radio buttons, checkboxes
- **Date/Time Fields**: Date and time pickers
- **File Upload**: Basic file upload support
- **Custom Validation**: Add your own validation rules

#### Form Styling
- **Bootstrap Integration**: Modern, responsive design
- **Custom CSS**: SmartElite branding and colors
- **Mobile Responsive**: Works on all devices
- **Accessibility**: WCAG compliant design

### Integration Features

#### API Integration
- **Brevo Email API**: Professional email delivery
- **Textify SMS API**: Reliable SMS notifications
- **Webhook Support**: Extend functionality with webhooks
- **REST API**: Programmatic access to form data

#### Export Options
- **CSV Export**: Download submission data
- **Formatted Reports**: Professional report generation
- **Data Filtering**: Export specific data sets
- **Scheduled Exports**: Automated data exports

---

## Troubleshooting

### Common Issues

#### Form Submission Problems
**Issue**: Form submission fails without error message
**Solution**: 
1. Check browser console for JavaScript errors
2. Verify CSRF token is present
3. Check server logs for PHP errors
4. Ensure all required fields are filled

**Issue**: "Too many submissions" error
**Solution**:
1. Wait for rate limit to reset (1 hour for hourly limit)
2. Check if you're using a shared IP address
3. Contact administrator if legitimate submissions are blocked

#### Admin Panel Issues
**Issue**: Cannot access admin panel
**Solution**:
1. Verify correct URL: `/admin`
2. Check username/password: `admin`/`admin123`
3. Clear browser cache and cookies
4. Check server error logs

**Issue**: Forms not displaying in public gallery
**Solution**:
1. Ensure forms are marked as "Active"
2. Check if forms have been soft-deleted
3. Verify database connection
4. Check form slug generation

#### Notification Problems
**Issue**: Email notifications not sending
**Solution**:
1. Verify Brevo API key is correct
2. Check email configuration in `app/Config/Notifications.php`
3. Test email functionality in admin panel
4. Check server logs for API errors

**Issue**: SMS notifications not working
**Solution**:
1. Verify Textify API key is correct
2. Check SMS configuration settings
3. Test SMS functionality in admin panel
4. Ensure phone numbers are in correct format

### Performance Issues

#### Slow Form Loading
**Solutions**:
1. Check database query performance
2. Optimize form field queries
3. Enable database query caching
4. Check server resources

#### High Server Load
**Solutions**:
1. Implement additional rate limiting
2. Enable server-side caching
3. Optimize database indexes
4. Consider CDN for static assets

### Data Issues

#### Missing Submissions
**Solutions**:
1. Check if submissions were soft-deleted
2. Verify form is active and accessible
3. Check database connection
4. Review server logs for errors

#### Duplicate Detection Issues
**Solutions**:
1. Check duplicate detection configuration
2. Verify field normalization is working
3. Review duplicate detection logs
4. Test with known duplicate data

---

## API Integration

### Brevo Email API

#### Configuration
```php
// app/Config/Notifications.php
public array $brevo = [
    'api_key' => 'your_brevo_api_key',
    'sender_email' => 'noreply@smartelite.com',
    'sender_name' => 'SmartElite Initiative'
];
```

#### Features
- **Transactional Emails**: Reliable email delivery
- **Template Support**: Custom email templates
- **Delivery Tracking**: Monitor email delivery status
- **Bounce Handling**: Automatic bounce management

### Textify SMS API

#### Configuration
```php
// app/Config/Notifications.php
public array $textify = [
    'api_key' => 'your_textify_api_key',
    'sender_id' => 'SmartElite'
];
```

#### Features
- **SMS Delivery**: Reliable SMS notifications
- **International Support**: Global SMS delivery
- **Delivery Reports**: Track SMS delivery status
- **Cost Optimization**: Efficient SMS routing

### Webhook Integration

#### Setup
1. Configure webhook endpoints in your application
2. Set up webhook handlers for form submissions
3. Implement error handling and retry logic
4. Monitor webhook delivery status

#### Use Cases
- **CRM Integration**: Send data to customer management systems
- **Analytics**: Track form performance metrics
- **Third-party Services**: Integrate with external tools
- **Custom Workflows**: Trigger custom business logic

---

## Best Practices

### Form Design

#### Field Organization
- **Logical Grouping**: Group related fields together
- **Clear Labels**: Use descriptive, user-friendly labels
- **Required Field Indicators**: Clearly mark mandatory fields
- **Help Text**: Provide guidance for complex fields

#### User Experience
- **Progressive Disclosure**: Show fields as needed
- **Validation Feedback**: Provide immediate feedback
- **Error Prevention**: Use appropriate field types
- **Mobile Optimization**: Ensure mobile-friendly design

### Data Management

#### Submission Handling
- **Data Validation**: Validate all inputs thoroughly
- **Data Sanitization**: Clean user input before storage
- **Backup Strategy**: Regular database backups
- **Data Retention**: Implement data retention policies

#### Security Practices
- **Regular Updates**: Keep system components updated
- **Access Control**: Limit admin access appropriately
- **Monitoring**: Monitor system for suspicious activity
- **Incident Response**: Have procedures for security incidents

### Performance Optimization

#### Database Optimization
- **Indexing**: Proper database indexes
- **Query Optimization**: Efficient database queries
- **Connection Pooling**: Optimize database connections
- **Caching**: Implement appropriate caching strategies

#### Server Optimization
- **Resource Monitoring**: Monitor server resources
- **Load Balancing**: Distribute load across servers
- **CDN Usage**: Use CDN for static assets
- **Compression**: Enable gzip compression

### Maintenance

#### Regular Tasks
- **Database Cleanup**: Remove old, unnecessary data
- **Log Rotation**: Manage log file sizes
- **Security Updates**: Apply security patches
- **Performance Monitoring**: Monitor system performance

#### Backup Procedures
- **Database Backups**: Regular database backups
- **File Backups**: Backup uploaded files
- **Configuration Backups**: Backup system configuration
- **Recovery Testing**: Test backup restoration procedures

---

## Support and Resources

### Documentation
- **CodeIgniter 4 Documentation**: [https://codeigniter.com/user_guide/](https://codeigniter.com/user_guide/)
- **Bootstrap 5 Documentation**: [https://getbootstrap.com/docs/5.0/](https://getbootstrap.com/docs/5.0/)
- **Brevo API Documentation**: [https://developers.brevo.com/docs/](https://developers.brevo.com/docs/)
- **Textify API Documentation**: [https://textify.africa/docs/](https://textify.africa/docs/)

### System Logs
- **Application Logs**: `writable/logs/`
- **Error Logs**: Check server error logs
- **Access Logs**: Web server access logs
- **Database Logs**: MySQL query logs

### Contact Information
For technical support or questions about the SmartElite Form Builder system:
- **Developer**: Abdulmujib Nizary Migambile
- **Email**: migambile25@gmail.com
- Please refer to your system administrator or development team for additional support

---

*This user guide covers the SmartElite Form Builder and Registration System v1.0. Developed by Abdulmujib Nizary Migambile. For updates and additional features, please refer to the system documentation and release notes.*
