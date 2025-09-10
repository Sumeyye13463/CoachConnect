<?php 
include('compoments/html-start.php');
include('compoments/nav.php');

?>
    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_2.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs mb-2"><span class="mr-2"><a href="index.php">Ana Sayfa <i class="ion-ios-arrow-forward"></i></a></span> <span>Hakkımızda <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-0 bread">Hakkımızda</h1>
          </div>
        </div>
      </div>
    </section>
		
		
  <?php 	
  include('compoments/other-service.php');
  ?>

   
		
	<section class="ftco-section bg-light">
  <div class="container">
    <div class="row justify-content-center pb-5 mb-3">
      <div class="col-md-7 heading-section text-center ftco-animate">
        <h2>Bünyemizdeki Yaşam Koçları</h2>
        <span class="subheading">Takım &amp; Personel</span>
      </div>
    </div>
    <div class="row">
      <?php
      
        include('includes/function.php');

        $koclar = koclarGetir($conn);
        foreach ($koclar as $koc) {
      ?>
        <div class="col-md-6 col-lg-3 ftco-animate">
          <div class="staff">
            <div class="img-wrap d-flex align-items-stretch">
              <div class="img align-self-stretch" style="background-image: url(<?php echo $koc['url']; ?>);"></div>
            </div>
            <div class="text pt-3 px-3 pb-4 text-center">
              <h3><?php echo $koc['ad'] . ' ' . $koc['soyad']; ?></h3>
              <span class="position mb-2"><?php echo $koc['alan_isim']; ?></span>
              <div class="faded">
                <p><?php echo $koc['aciklama']; ?></p>
                
              </div>
            </div>
          </div>
        </div>
      <?php
        }
      ?>
    </div>
  </div>
</section>



<?php

include('compoments/footer.php');

 ?>