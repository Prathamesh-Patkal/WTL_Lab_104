function alertUser(){
    alert("Your Response has been recorded !!")
}

function addCart(img,title,price){
    window.open("cart.html","_self")
    let cartImg =  document.getElementById(img);
    let cartImgSrc = cartImg.src;
    let cartImgSrcRel = getRelativePath(cartImgSrc);
    let cartTitle = document.getElementById(title).innerHTML;
    let cartPrice = document.getElementById(price).innerHTML;
    
    
    let newCartImg = document.getElementById("cart-img");
    newCartImg.src = cartImgSrcRel;
    
    let newCartTitle = document.getElementById("cart-title");
    newCartTitle.innerHTML = cartTitle;
    
    let newCartPrice = document.getElementById("cart-price")
    newCartPrice.innerHTML = cartPrice;
    
}

// function addCart(imgId, titleId, priceId) {
//     let cartImgSrc = document.getElementById(imgId).src;
//     let cartTitle = document.getElementById(titleId).innerHTML;
//     let cartPrice = document.getElementById(priceId).innerHTML;
    
//     // Store values in localStorage
//     localStorage.setItem("cartImg", cartImgSrc);
//     localStorage.setItem("cartTitle", cartTitle);
//     localStorage.setItem("cartPrice", cartPrice);
    
//     // Navigate to cart.html
//     window.location.href = "cart.html"; // Redirects while keeping stored data
// }

function getRelativePath(fullUrl) {
    let parts = fullUrl.split("/Cloths_shopee/");
    return parts.length > 1 ? parts[1] : fullUrl;
}

