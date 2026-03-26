# ⚡ SPARK - Ukrainian E-commerce Platform

A complete, production-ready e-commerce platform built with Laravel 11, designed for Ukrainian market with modern UI and full shopping functionality.

![Laravel](https://img.shields.io/badge/Laravel-11-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.4-blue.svg)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-blue.svg)
![SQLite](https://img.shields.io/badge/Database-SQLite-green.svg)

## 🌟 Features

### 🛍️ Shopping Experience
- **Product Catalog**: Advanced filtering by category, price, brand, rating
- **Product Details**: Full product pages with specifications, reviews, related products
- **Shopping Cart**: Add/remove items, quantity management, persistent cart
- **Checkout Process**: Multi-step checkout with address selection and payment options
- **Order Management**: Order history, tracking, status updates

### 👤 User Management
- **Authentication**: Login/register with validation
- **User Profiles**: Profile management, address book
- **Wishlist**: Save favorite products
- **Reviews & Ratings**: Product reviews with star ratings

### 💳 Payment & Shipping
- **Multiple Payment Methods**: Card (Stripe), LiqPay, Bank Transfer, Cash on Delivery
- **Shipping Options**: Nova Poshta, Meest Express, Pickup
- **Ukrainian Localization**: ₴ currency, Ukrainian text, local payment methods

### 🎨 Modern UI/UX
- **Responsive Design**: Mobile-first approach with Tailwind CSS
- **Ukrainian Interface**: All text in Ukrainian language
- **Fast Loading**: Optimized assets with Vite
- **Accessibility**: WCAG compliant components

## 🚀 Quick Start

### Prerequisites
- PHP 8.4+
- Composer
- Node.js 20+
- SQLite (included)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/YOUR_USERNAME/spark-ecommerce.git
   cd spark-ecommerce
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Build assets**
   ```bash
   npm run build
   # or for development
   npm run dev
   ```

7. **Start the server**
   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` to see your store!

## 📁 Project Structure

```
spark-ecommerce/
├── app/
│   ├── Http/Controllers/     # All controllers
│   ├── Models/              # Eloquent models
│   └── Providers/           # Service providers
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── resources/
│   ├── views/              # Blade templates
│   │   ├── auth/          # Login/register pages
│   │   ├── components/    # Reusable components
│   │   ├── layouts/       # Master layouts
│   │   └── pages/         # Page templates
│   ├── css/               # Stylesheets
│   └── js/                # JavaScript files
├── routes/
│   └── web.php            # Web routes
└── public/                # Public assets
```

## 🗄️ Database Schema

The application uses 10 main tables:
- `users` - User accounts
- `categories` - Product categories
- `products` - Product catalog
- `cart_items` - Shopping cart items
- `orders` - Customer orders
- `order_items` - Order line items
- `addresses` - Delivery addresses
- `payments` - Payment records
- `reviews` - Product reviews
- `wishlists` - User wishlists

## 🎯 Key Controllers

- **ProductController**: Catalog browsing, product details
- **CartController**: Shopping cart management
- **OrderController**: Order processing and checkout
- **AuthController**: User authentication
- **ReviewController**: Product reviews

## 🎨 UI Components

- **Header**: Navigation, search, cart, user menu
- **Footer**: Links, contact info, payment methods
- **Product Card**: Reusable product display component
- **Checkout Form**: Multi-step order form

## 🔧 Technologies Used

- **Backend**: Laravel 11, PHP 8.4
- **Frontend**: Blade templates, Tailwind CSS, Alpine.js
- **Database**: SQLite (development), MySQL/PostgreSQL (production)
- **Build Tools**: Vite, npm
- **Authentication**: Laravel Sanctum compatible
- **Validation**: Laravel built-in validation

## 🌍 Ukrainian Market Features

- Ukrainian language interface
- ₴ (UAH) currency display
- Local payment methods (LiqPay, Privat24)
- Ukrainian shipping providers (Nova Poshta, Meest)
- Local business requirements compliance

## 📊 Sample Data

The application comes with sample data:
- 8 product categories (Smartphones, Laptops, etc.)
- 25 sample products with realistic pricing
- Test user account for development

## 🚀 Deployment

### Vercel Deployment (Recommended)

1. **Install Vercel CLI**
   ```bash
   npm install -g vercel
   ```

2. **Deploy to Vercel**
   ```bash
   vercel --prod
   ```

3. **Configure Environment Variables in Vercel Dashboard**
   - Go to your project in Vercel dashboard
   - Navigate to Settings → Environment Variables
   - Add the following variables:
     ```
     APP_NAME=Spark
     APP_ENV=production
     APP_KEY=your-generated-app-key
     APP_DEBUG=false
     APP_URL=https://your-vercel-app.vercel.app
     DB_CONNECTION=sqlite
     ```

4. **Database Setup**
   - For SQLite: Database will be created automatically
   - For PostgreSQL: Use Vercel Postgres or external provider

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

### Alternative: Railway Deployment

If you prefer Railway for better Laravel support:

1. **Connect to Railway**
   ```bash
   railway login
   railway link
   ```

2. **Deploy**
   ```bash
   railway up
   ```

### Traditional Hosting

For traditional web hosting:

1. Set up web server (Apache/Nginx)
2. Configure database (MySQL/PostgreSQL)
3. Set up SSL certificate
4. Configure payment gateways
5. Set up email service
6. Run migrations and seeders

### Environment Variables
```env
APP_NAME="Spark E-commerce"
APP_ENV=production
APP_KEY=your-app-key
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database (SQLite for Vercel, MySQL/PostgreSQL for others)
DB_CONNECTION=sqlite
# or
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=spark
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password

# Payment gateways
STRIPE_KEY=your-stripe-key
STRIPE_SECRET=your-stripe-secret
LQPAY_PUBLIC_KEY=your-liqpay-key
LQPAY_PRIVATE_KEY=your-liqpay-secret
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 🙏 Acknowledgments

- Built with [Laravel](https://laravel.com/) framework
- Styled with [Tailwind CSS](https://tailwindcss.com/)
- Icons and UI inspiration from Ukrainian e-commerce sites

---

**Made with ❤️ for Ukrainian developers and entrepreneurs**

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
