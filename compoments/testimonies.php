<section class="ftco-section testimony-section bg-secondary">
   <div class="container">
     <div class="row justify-content-center pb-5 mb-3">
       <div class="col-md-7 heading-section heading-section-white text-center ftco-animate">
         <h2>Mutlu Müşteriler  &amp; Geri Bildirimler</h2>
         <span class="subheading">Referanslar</span>
       </div>
     </div>
     <div class="row ftco-animate">
       <div class="col-md-12">
         <div class="carousel-testimony owl-carousel ftco-owl">
           <?php
           
           include('includes/function.php');           
           $referanslar = referansGetir($conn);        
      
           foreach ($referanslar as $referans) {
           ?>
           <div class="item">
             <div class="testimony-wrap py-4">
             	<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></span></div>
               <div class="text">
                 <p class="mb-4"><?php echo $referans['yorum']; ?></p> 
                 <div class="d-flex align-items-center">
                 	<div class="user-img" style="background-image: url(<?php echo $referans['url']; ?>)"></div> 
                 	<div class="pl-3">
                   <p class="name"><?php echo $referans['ad']; ?> <?php echo $referans['soyad']; ?></p>
                   <span class="position"><?php echo $referans['pozisyon']; ?></span> 
                 </div>
                </div>
               </div>
             </div>
           </div>
           <?php } ?>
         </div>
       </div>
     </div>
   </div>
</section>