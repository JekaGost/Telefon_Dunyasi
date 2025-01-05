
document.addEventListener("DOMContentLoaded",function(){

    var ShoppingCartIcon=document.getElementById("shopping-cart-icon");
    var ShoppingCartDiv=document.getElementById("shopping-cart-div");
    var ShoppingcartStatus="closed";

    //Eğer kullanıcı alışveriş sepeti ikonuna tıklarsa alışveriş sepetinin görünürlüğünü değiştir
    ShoppingCartIcon.addEventListener("click",function(){
      
      //Alışveriş sepeti kapalıysa aç
      if(ShoppingcartStatus=="closed"){
        ShoppingCartDiv.style.display="flex";
        ShoppingcartStatus="open";
      }

      //Alışveriş sepeti açıksa kapat
      else{
        ShoppingCartDiv.style.display="none";
        ShoppingcartStatus="closed";
      }
    });


    //Renk değiştikçe ürün fotosuun değişmesi

    var Photo1=document.getElementById("photo-1");

    var Radio1=document.getElementById("color-input-1");
    var Radio2=document.getElementById("color-input-2");
    var Radio3=document.getElementById("color-input-3");
    
    //TODO:1.Radyo butonuna basılınca fotoğrafı 1.renk yap
    Radio1.addEventListener("change",function(){

      alert("Radio 1");
    });

    //TODO:2.Radyo butonuna tıklandığı zaman fotoğrafı 2.renk yap
    Radio2.addEventListener("change",function(){

      alert("Radio 2");
    });


    //TODO:3.Radyo butonuna tıklandığı zaman fotoğrafı 3.renk yap
    Radio3.addEventListener("change",function(){

      alert("Radio 3");
    });
  });