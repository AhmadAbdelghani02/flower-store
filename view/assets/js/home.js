
/*=============== Nav ===============*/
/*=============== SHOW MENU ===============*/
const navMenu = document.getElementById('nav-menu'),
      navToggle = document.getElementById('nav-toggle'),
      navClose = document.getElementById('nav-close')

/* Menu show */
if(navToggle){
   navToggle.addEventListener('click', () =>{
      navMenu.classList.add('show-menu')
   })
}

/* Menu hidden */
if(navClose){
   navClose.addEventListener('click', () =>{
      navMenu.classList.remove('show-menu')
   })
}

/*=============== Nav ===============*/

// Modal functionality
document.querySelectorAll(".card__product").forEach((card) => {
    card.addEventListener("click", () => {
        const modal = document.querySelector(`.modal[data-id="${card.dataset.id}"]`);
        if (modal) modal.classList.add("active-modal");
    });
  });
  
  document.querySelectorAll(".modal__close").forEach((closeBtn) => {
    closeBtn.addEventListener("click", () => {
        document.querySelectorAll(".modal").forEach((modal) => modal.classList.remove("active-modal"));
    });
  });
  
  document.querySelectorAll(".modal").forEach((modal) => {
    modal.addEventListener("click", (e) => {
        if (!e.target.closest(".modal__card")) modal.classList.remove("active-modal");
    });
  });
  
  // Cart functionality
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  
  // Selectors
  const selectors = {
    cartBtn: document.querySelector(".cart-btn"),
    cartQty: document.querySelector(".cart-qty"),
    cartClose: document.querySelector(".cart-close"),
    cart: document.querySelector(".cart"),
    cartOverlay: document.querySelector(".cart-overlay"),
    cartClear: document.querySelector(".cart-clear"),
    cartBody: document.querySelector(".cart-body"),
    cartTotal: document.querySelector(".cart-total"),
  };
  
  // Event Listeners
  selectors.cartBtn.addEventListener("click", () => {
    selectors.cart.classList.add("show");
    selectors.cartOverlay.classList.add("show");
  });
  
  selectors.cartClose.addEventListener("click", hideCart);
  selectors.cartOverlay.addEventListener("click", hideCart);
  selectors.cartClear.addEventListener("click", () => {
    cart = [];
    saveCart();
    renderCart();
  });
  
  // Delegated event listener for dynamically created buttons
  document.addEventListener("click", (e) => {
    if (e.target.classList.contains("add-to-cart")) {
        addToCart(parseInt(e.target.dataset.id));
        hideModal(e.target.dataset.id);
    }
    if (e.target.dataset.btn === "incr") {
        updateQuantity(parseInt(e.target.closest(".cart-item").dataset.id), "increase");
    } else if (e.target.dataset.btn === "decr") {
        updateQuantity(parseInt(e.target.closest(".cart-item").dataset.id), "decrease");
    }
  });
  
  // Cart Functions
  function hideCart() {
    selectors.cart.classList.remove("show");
    selectors.cartOverlay.classList.remove("show");
  }
  
  function hideModal(id) {
    const modal = document.querySelector(`.modal[data-id="${id}"]`);
    if (modal) modal.classList.remove("active-modal");
  }
  
  function addToCart(id) {
    let product = cart.find((item) => item.id === id);
    if (product) {
        product.qty++;
    } else {
        cart.push({ id, qty: 1 });
    }
    saveCart();
    renderCart();
  }
  
  function removeFromCart(id) {
    cart = cart.filter((item) => item.id !== id);
    saveCart();
    renderCart();
  }
  
  function updateQuantity(id, action) {
    let product = cart.find((item) => item.id === id);
    if (product) {
        action === "increase" ? product.qty++ : product.qty--;
        if (product.qty === 0) removeFromCart(id);
    }
    saveCart();
    renderCart();
  }
  
  function saveCart() {
    localStorage.setItem("cart", JSON.stringify(cart));
  }
  
  function renderCart() {
    selectors.cartBody.innerHTML = "";
    let totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
    
    // Update cart quantity on the cart icon
    selectors.cartQty.textContent = totalItems;
    selectors.cartQty.style.display = totalItems > 0 ? "block" : "none"; // Hide when empty
  
    if (cart.length === 0) {
        selectors.cartBody.innerHTML = "<div class='cart-empty'>Your cart is empty.</div>";
        selectors.cartTotal.textContent = "$0.00";
        return;
    }
  
    let total = 0;
    cart.forEach(({ id, qty }) => {
        let product = document.querySelector(`.card__product[data-id="${id}"]`);
        if (!product) return;
  
        let name = product.querySelector(".card__name").textContent;
        let price = parseFloat(product.querySelector(".card__price").textContent.replace("$", ""));
        let image = product.querySelector(".card__img").src;
        let amount = price * qty;
        total += amount;
  
        selectors.cartBody.innerHTML += `
            <div class="cart-item" data-id="${id}">
                <img src="${image}" alt="${name}" />
                <div class="cart-item-detail">
                    <h3>${name}</h3>
                    <h5>$${price.toFixed(2)}</h5>
                    <div class="cart-item-amount">
                        <button data-btn="decr">-</button>
                        <span class="qty">${qty}</span>
                        <button data-btn="incr">+</button>
                        <span class="cart-item-price">$${amount.toFixed(2)}</span>
                    </div>
                </div>
            </div>`;
    });
  
    selectors.cartTotal.textContent = `$${total.toFixed(2)}`;
  }
  
  // Initial render on page load
  renderCart();