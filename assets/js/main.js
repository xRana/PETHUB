document.addEventListener('DOMContentLoaded', () => {
  const cartIcon = document.querySelector('.nav__shop');
  const cart = document.querySelector('.cart');
  const cartItemsContainer = document.getElementById('cart-items');
  const totalPriceElement = document.getElementById('total-price');
  const cartQuantityElement = document.getElementById('cart-quantity');         
  const cartMenu = document.querySelector('.button');
  const cartClose = document.querySelector('.close-cart');
  
  let cartData = [];

  // Toggle cart visibility
  cartIcon.addEventListener('click', () => {
    cart.classList.toggle('visible');
  });
  
  cartMenu.addEventListener('click', () => {
    cart.classList.toggle('visible');
  });
  
  cartClose.addEventListener('click', () => {
    cart.classList.toggle('visible');
  });

  // Add product to cart
  document.querySelectorAll('.bbtn').forEach(button => {
    button.addEventListener('click', (e) => {
      const product = e.target.closest('.product-js');
      const id = product.dataset.id;
      const name = product.dataset.name;
      const price = parseFloat(product.dataset.price);
      const image = product.dataset.img; // Corrected here
      const existingProduct = cartData.find(item => item.id === id);

      if (existingProduct) {
        existingProduct.quantity++;
      } else {
        cartData.push({ image, id, name, price, quantity: 1 });
      }

      updateCart();
    });
  });

  // Update cart display
  function updateCart() {
    cartItemsContainer.innerHTML = '';
    let total = 0;
    let quantity = 0;

    cartData.forEach(item => {
      total += item.price * item.quantity;
      quantity += item.quantity;

      const cartItem = document.createElement('div');
      cartItem.classList.add('cart-item');
      cartItem.innerHTML = `
        <img src="${item.image}" alt="${item.name}">
        <div class="details">
          <div>${item.name}</div>
          <div>$${(item.price * item.quantity).toFixed(2)}</div>
        </div>
        <div class="quantity">
          <button class="minus">-</button>
          <span>${item.quantity}</span>
          <button class="plus">+</button>
        </div>
      `;

      cartItem.querySelector('.minus').addEventListener('click', () => {
        item.quantity--;
        if (item.quantity === 0) {
          cartData = cartData.filter(i => i.id !== item.id);
        }
        updateCart();
      });

      cartItem.querySelector('.plus').addEventListener('click', () => {
        item.quantity++;
        updateCart();
      });

      cartItemsContainer.appendChild(cartItem);
    });

    totalPriceElement.textContent = total.toFixed(2);
    cartQuantityElement.textContent = quantity;
  }
});
