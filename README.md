# 🏀 NBAShop

**NBAShop** is a modern and user-friendly web application designed for displaying and purchasing NBA-themed products online. This project combines a sleek user interface for customers with a robust admin panel for managing products and orders, providing an excellent e-commerce experience for NBA enthusiasts.

---

## 📚 About the Project

This project focuses on the **frontend** development of an e-commerce platform. It allows users to browse products, add items to their cart, and manage purchases while offering administrators comprehensive management tools.

### User Features:
- 🛒 **Product Listing**: Users can browse NBA jerseys, shoes, accessories, and other items by categories.
- 📖 **Product Details**: View detailed information, including price, description, and images, for each product.
- 🛍️ **Shopping Cart**: Add, remove, and manage items in the shopping cart before proceeding to checkout.
- 🔑 **User Authentication**: Register and log in to access personalized features.
- ✉️ **Contact Form**: Send support or feedback messages directly through the contact form.

### Admin Features:
- **Product Management**: Add, edit, or delete products with ease.
- **Category Management**: Create and organize product categories.
- **Order Management**: View and manage customer orders effectively.
- **Message Management**: Access and respond to user-submitted messages.

---

## 🛠️ Technologies Used

### Frontend:
- **HTML5**: For semantic and structured content.
- **CSS3 / SCSS**: For modern and visually appealing designs.
- **JavaScript (ES6)**: For interactive and dynamic features.
- **Bootstrap**: For responsive and mobile-friendly layouts.
- **jQuery**: For enhanced user interactivity.

### Backend:
- **PHP**: For dynamic data management and server-side operations.
- **MySQL**: For database storage and retrieval.
- **Apache (XAMPP)**: As a local server environment for development.

---

## 📦 Installation and Setup

Follow these steps to set up the project locally:

### Prerequisites
- **XAMPP** or a similar Apache + MySQL server.
- A modern browser (Chrome, Firefox, etc.).

### Steps
1. **Clone the Repository**:
   Clone the project repository to your local machine:
   ```bash
   git clone https://github.com/erturkeryavuz/NBASHOP.git

2. **Move the Files to XAMPP**:
   Move the NBASHOP directory to the `htdocs` folder of your XAMPP installation:
   ```bash
   cp -R NBASHOP /Applications/XAMPP/xamppfiles/htdocs/

3. **Set Up the Database**:
   Open your browser and go to [phpMyAdmin](http://localhost/phpmyadmin).
   Create a new database named `ecommerce_db`.
   Import the `ecommerce_db.sql` file into the database.

4. **Run the Application**:
   Open your browser and navigate to the following URL:
   ```bash
   http://localhost/NBASHOP/nba_shop_frontend



## 📂 Project Structure
Here is an overview of the project directory structure:
```
NBASHOP/
├── ecommerce_db.sql         # Database schema
├── nba_shop_frontend/       # Frontend application files
│   ├── admin_panel/         # Admin panel files
│   │   └── admin_template/  # Admin panel templates
│   └── nba_shop/1/          # User-facing web application files
│       ├── css/             # Stylesheets
│       ├── js/              # JavaScript files
│       ├── images/          # Product images
│       ├── index.php        # Home page
│       ├── cart.php         # Shopping cart
│       ├── detail.php       # Product details
│       └── ...              # Other PHP files
```

## 📜 Template Information

This project uses the **EShopper - Bootstrap Shop Template** by **HTML Codex**.

- **Template Name**: [EShopper - Bootstrap Shop Template](https://htmlcodex.com/bootstrap-shop-template)
- **Template Link**: [HTML Codex Templates](https://htmlcodex.com)
- **Template License**: [License Information](https://htmlcodex.com/license) (or see the `LICENSE.txt` file included in this project)
- **Template Author**: [HTML Codex](https://htmlcodex.com)
- **About HTML Codex**: HTML Codex is a leading creator of free HTML templates, HTML landing pages, HTML email templates, and HTML snippets worldwide. Learn more [here](https://htmlcodex.com/about-us).


## 🤝 Contribution

Contributions are welcome! To contribute to this project, follow these steps:

1. **Fork the Repository**.
2. **Create a new branch**:
   ```bash
   git checkout -b feature-name

3. **Make your changes and commit them**:
   ```bash
   git commit -m "Added a new feature"

4. **Push your branch**:
   ```bash
   git push origin feature-name

5. **Open a Pull Request. Your changes will be reviewed and merged**.

## 📝 License
This project is licensed under the MIT License. See the LICENSE file for more details.

## 📧 Contact
If you have any questions or suggestions about this project, feel free to reach out:

- **GitHub**: [@erturkeryavuz](https://github.com/erturkeryavuz)
- **Email**: [erturkeryavuz@gmail.com](mailto:erturkeryavuz@gmail.com)
- **LinkedIn**: [Ertürk Eryavuz](https://www.linkedin.com/in/ertürk-eryavuz-083b76282)

