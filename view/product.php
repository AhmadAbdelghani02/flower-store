<?php
require_once '../db.php';
$pdo = Database::getInstance()->getConnection();

// Fetch products from the database
$stmt = $pdo->query("SELECT id, name, price, image, description FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
    <link rel="stylesheet" href="./assets/css/product.css">
    <title>Product List</title>
</head>
<body>
    <section class="container">
        <h2 class="container__title">Select Your Product</h2>
        <div class="card__container">
            <?php foreach ($products as $product): ?>
            <article>
                
                <div class="card__product" data-id="<?= $product['id'] ?>">
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="image" class="card__img">
                    <div>
                        <h3 class="card__name"><?= htmlspecialchars($product['name']) ?></h3>
                        <span class="card__price">$<?= htmlspecialchars($product['price']) ?></span>
                    </div>
                </div>

                
                <div class="modal">
                    <div class="modal__card">
                        <i class="ri-close-large-line modal__close"></i>
                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="image" class="modal__img">
                        <div>
                            <h3 class="modal__name"><?= htmlspecialchars($product['name']) ?></h3>
                            <p class="modal__info"><?= htmlspecialchars($product['description']) ?></p>
                            <span class="modal__price">$<?= htmlspecialchars($product['price']) ?></span>
                        </div>
                        <div class="modal__buttons">
                            
                            <button class="modal__button">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </section>

    <script src="./assets/js/product.js"></script>
</body>
</html> 
