<?php
require_once '../db.php';
$pdo = Database::getInstance()->getConnection();

// Fetch products from the database
$stmt = $pdo->prepare("SELECT id, name, price, image, description FROM products");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

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