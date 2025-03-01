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
  <title>Online Store</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="./assets/css/cart.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
</head>

<body>

  <header>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <div class="container">
              <a class="navbar-brand" href="#">
                <h1 class="logo">Flower <span class="clrchange">.</span></h1>
              </a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item active">
                    <a class="nav-link" href="#">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#product">Products</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#review">Review</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                  </li>
                </ul>

                <ul class="navbar-nav ml-auto">
                  <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fa-solid fa-heart"></i></a>
                  </li>
                  <li class="nav-item">
                  <a class="nav-link cart-btn" href="#"><i class="fa-solid fa-cart-shopping"></i> <small class="cart-qty">0</small></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fa-solid fa-user"></i></a>
                  </li>

                </ul>
              </div>
            </div>
          </nav>
        </div>
      </div>

    </div>
  </header>

  <main>
    <section class="container">
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

  <script src="./assets/js/cart.js"></script>
</body>

</html>