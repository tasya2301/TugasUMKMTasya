let cart = [];

function addToCart(nama, harga) {
  cart.push({ nama, harga });
  tampilkanCart();
}

function tampilkanCart() {
  const cartList = document.getElementById("cart");
  cartList.innerHTML = "";
  cart.forEach((item, i) => {
    cartList.innerHTML += `<li>${item.nama} - Rp${item.harga.toLocaleString()}</li>`;
  });
  localStorage.setItem("cart", JSON.stringify(cart));
}

window.onload = () => {
  cart = JSON.parse(localStorage.getItem("cart")) || [];
  tampilkanCart();
};
