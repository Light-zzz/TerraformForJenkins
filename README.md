# DevOps Engineer Portfolio Website

A modern, responsive portfolio website for DevOps engineers, built with HTML, CSS, JavaScript, and PHP. This portfolio features a beautiful purple/pink gradient theme and includes all the essential sections for showcasing your DevOps expertise.

## Features

- **Responsive Design**: Fully responsive layout that works on all devices
- **Modern UI/UX**: Clean, professional design with smooth animations
- **Contact Form**: Functional PHP contact form with validation
- **Smooth Scrolling**: Enhanced navigation with smooth scroll effects
- **Interactive Elements**: Animated statistics, testimonial carousel, and more
- **SEO Friendly**: Semantic HTML structure

## Sections Included

1. **Header/Navigation**: Fixed header with smooth navigation
2. **Hero Section**: Eye-catching introduction with call-to-action
3. **Statistics**: Animated counters showing experience, projects, and clients
4. **About Section**: Personal introduction with social media links
5. **Work Process**: 4-step process visualization
6. **Portfolio**: Showcase of DevOps projects and case studies
7. **Call to Action**: Project discussion section
8. **Blog**: Recent blog posts section
9. **Services**: What you do section (Cloud, CI/CD, Containerization)
10. **Happy Clients**: Client logos section
11. **Testimonial**: Client testimonials with carousel
12. **Contact**: Contact form with PHP backend
13. **Footer**: Footer with navigation and copyright

## Setup Instructions

### Prerequisites

- A web server with PHP support (Apache, Nginx, or PHP built-in server)
- PHP 7.0 or higher

### Installation

1. **Clone or download** this repository to your web server directory

2. **Configure the contact form**:
   - Open `contact.php`
   - Change the `$to` variable to your email address (line 40)
   - Ensure your server has mail() function configured (or use SMTP)

3. **Customize the content**:
   - Edit `index.html` to update your personal information
   - Replace placeholder images with your own
   - Update portfolio projects, blog posts, and testimonials
   - Modify contact information

4. **Start the server**:

   **Using PHP built-in server** (for development):
   ```bash
   php -S localhost:8000
   ```
   Then open `http://localhost:8000` in your browser

   **Using Apache/Nginx**:
   - Place files in your web root directory
   - Access via your domain or localhost

## File Structure

```
portfolio/
├── index.html          # Main HTML file
├── styles.css          # All CSS styles
├── script.js           # JavaScript for interactivity
├── contact.php         # PHP contact form handler
└── README.md          # This file
```

## Customization

### Colors

The color scheme can be customized in `styles.css` by modifying the CSS variables:

```css
:root {
    --primary-color: #8B5CF6;
    --secondary-color: #EC4899;
    --dark-bg: #1F1F2E;
    --light-bg: #F8F9FA;
}
```

### Images

Replace placeholder images with your own:
- Hero section image
- About section image
- Portfolio project images
- Blog post images

### Contact Form

The contact form saves submissions to:
- Email (configured in `contact.php`)
- Text file: `contact_submissions.txt` (auto-created)

For production, consider:
- Using SMTP instead of mail()
- Adding database storage
- Implementing CAPTCHA
- Adding rate limiting

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## Notes

- The contact form requires PHP and a configured mail server
- For production, consider using a service like PHPMailer with SMTP
- All images are placeholders - replace with your own
- Font Awesome icons are loaded from CDN - ensure internet connection

## License

This project is open source and available for personal and commercial use.

## Support

For issues or questions, please check the code comments or modify as needed for your specific requirements.

