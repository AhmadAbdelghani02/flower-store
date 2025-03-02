<?php
require_once '../db.php';
$pdo = Database::getInstance()->getConnection();

// // Fetch products from the database
// $stmt = $pdo->prepare("SELECT id, name, price, image, description FROM products");
// $stmt->execute();
// $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// $search = isset($_GET['search']) ? trim($_GET['search']) : '';

// // Prepare and execute the search query safely
// $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE :search");
// $stmt->execute(['search' => "%$search%"]);
// $products = $stmt->fetchAll();


// Fetch categories from the database
$categoryStmt = $pdo->prepare("SELECT id, name FROM categories");
$categoryStmt->execute();
$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch products based on category or search
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$productStmt = $pdo->prepare("SELECT * FROM products WHERE (:search = '' OR name LIKE :search) AND (:category = '' OR category_id = :category)");
$productStmt->execute(['search' => "%$search%", 'category' => $category]);
$products = $productStmt->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />

   <!--=============== REMIXICONS ===============-->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">

   <!--=============== BootstrapIcon ===============-->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

   <link rel="stylesheet" href="./assets/css/home.css">

   <title>Flower-store</title>
</head>

<body>

   <header class="header" id="header">
      <nav class="nav nav-container">
         <a href="#" class="nav__logo">Flower <span class="logo-span">.</span></a>

         <div class="nav__menu" id="nav-menu">
            <ul class="nav__list">
               <li class="nav__item">
                  <a href="#" class="nav__link">
                     <i class="ri-arrow-right-up-line"></i>
                     <span>Home</span>
                  </a>
               </li>

               <li class="nav__item">
                  <a href="#" class="nav__link">
                     <i class="ri-arrow-right-up-line"></i>
                     <span>About</span>
                  </a>
               </li>

               <li class="nav__item">
                  <a href="#" class="nav__link">
                     <i class="ri-arrow-right-up-line"></i>
                     <span>Products</span>
                  </a>
               </li>

               <li class="nav__item">
                  <a href="#" class="nav__link">
                     <i class="ri-arrow-right-up-line"></i>
                     <span>Review</span>
                  </a>
               </li>

               <li class="nav__item">
                  <a href="#" class="nav__link">
                     <i class="ri-arrow-right-up-line"></i>
                     <span>Contact</span>
                  </a>
               </li>
            </ul>

            <!-- Close button -->
            <div class="nav__close" id="nav-close">
               <i class="ri-close-large-line"></i>
            </div>

            <div class="nav__social">
               <a href="#" class="nav__social-link cart-btn">
                  <i class="ri-shopping-cart-2-fill"><small class="cart-qty">0</small></i>
               </a>

               <a href="#" class="nav__social-link">
                  <i class="ri-user-fill"></i>
               </a>

               <a href="#" class="nav__social-link">
                  <i class="ri-logout-box-r-fill"></i>
               </a>
               
            </div>
         </div>

         <!-- Toggle button -->
         <div class="nav__toggle" id="nav-toggle">
            <i class="ri-menu-line"></i>
         </div>
      </nav>
   </header>

   <!--==================== MAIN ====================-->
   <main>
      <section class="crd-container">
         <h2 class="container__title">Select Your Product</h2>

          <!-- Categories Section -->
      
          <div class="categories">
            <h3>Categories <i class="ri-arrow-down-s-fill"></i></h3>
            <ul class="categories_types">
            <li>
                  <a href="home.php?category=" class="category-link">All</a>
               </li>
               <?php foreach ($categories as $category): ?>
                  <li >
                     <a  href="home.php?category=<?= htmlspecialchars($category['id']) ?>">
                        <?= htmlspecialchars($category['name']) ?>
                     </a>
                  </li>
               <?php endforeach; ?>
            </ul>
            <form class="search" method="GET" action="home.php">
      <input class="input" type="text" name="search" placeholder="Search for flowers...">
      <button class="btn" type="submit"><i class="fas fa-search "></i></button>
      </form>
         
         </div>
      

         <!-- ____________search bar___________ -->
         

         <!-- <div class="search">
               <input type="text" class="input" placeholder="Search...">
               <button class="btn">
               <i class="fas fa-search "></i>
               </button>
               </div> -->
         
         <div class="card__container">
            <?php foreach ($products as $product): ?>
               <article>
                  <div class="card__product" data-id="<?= htmlspecialchars($product['id']) ?>">
                     <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image" class="card__img">
                     <div>
                        <h3 class="card__name"><?= htmlspecialchars($product['name']) ?></h3>
                        <span class="card__price">$<?= number_format($product['price'], 2) ?></span>
                     </div>
                  </div>

                  <div class="modal" data-id="<?= htmlspecialchars($product['id']) ?>">
                     <div class="modal__card">
                        <i class="bi bi-x-circle modal__close"></i>
                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image" class="modal__img">
                        <div>
                           <h3 class="modal__name"><?= htmlspecialchars($product['name']) ?></h3>
                           <p class="modal__info"><?= htmlspecialchars($product['description']) ?></p>
                           <span class="modal__price">$<?= number_format($product['price'], 2) ?></span>
                        </div>
                        <div class="modal__buttons">
                           <button class="modal__button add-to-cart" data-id="<?= htmlspecialchars($product['id']) ?>">Add to Cart</button>
                        </div>
                     </div>
                  </div>
               </article>
            <?php endforeach; ?>
         </div>
      </section>
   </main>

   <!--=============== cart ===============-->
   <div class="cart-overlay"></div>
   <div class="cart">
      <div class="cart-header">
         <i class="bi bi-arrow-right cart-close"></i>
         <h2>Your Cart</h2>
      </div>
      <div class="cart-body"></div>
      <div class="cart-footer">
         <div>
            <strong>Total</strong>
            <span class="cart-total">0</span>
         </div>
         <button class="cart-clear">Clear Cart</button>
         <button class="checkout">Checkout</button>
      </div>
   </div>


   <!--=============== MAIN JS ===============-->
   <script src="./assets/js/home.js"></script>
</body>

</html>