<?php 
include('compoments/html-start.php');
include('compoments/nav.php');
include('includes/function.php');
?>

<section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_2.jpg');" data-stellar-background-ratio="0.5">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text align-items-end">
      <div class="col-md-9 ftco-animate pb-5">
        <p class="breadcrumbs mb-2">
          <span class="mr-2"><a href="index.php">Ana Sayfa<i class="ion-ios-arrow-forward"></i></a></span> 
          <span>İletişim <i class="ion-ios-arrow-forward"></i></span>
        </p>
        <h1 class="mb-0 bread">İletişim</h1>
      </div>
    </div>
  </div>
</section>

<section class="ftco-section bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="wrapper">
          <div class="row no-gutters">
            <div class="col-lg-8 col-md-7 order-md-last d-flex align-items-stretch">
              <div class="contact-wrap w-100 p-md-5 p-4">
                <h3 class="mb-4">Koçluk Seansınıza Randevu Alın</h3>
               <form method="POST" id="contactForm" name="contactForm" class="contactForm" action="yonlendir.php">

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="label" for="name">İsim Soyisim</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="İsim Soyisim" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="label" for="email">Email </label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email " required>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="label" for="phone">Numaranız</label>
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Numaranız" required>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="label" for="coaching_type">Koç Türü</label>
                        <select id="coaching_type" name="coaching_type" class="form-control" required>
                          <option value="">Koç Tür Seçin</option>
                          <?php
                          $kocTurleri = kocTurleriniGetir($conn);
                          foreach ($kocTurleri as $tur) {
                              echo "<option value='" . $tur['alan_id'] . "'>" . $tur['alan_isim'] . "</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="label" for="coach">Koç Seçin</label>
                        <select id="coach" name="coach" class="form-control" required>
                          <option value="">Lütfen önce koç türü seçiniz.</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="label" for="date">Tercih ettiğiniz tarih ve saat:</label>
                        <input type="datetime-local" class="form-control" name="date" id="date" required>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="label" for="notes">Notunuz</label>
                        <textarea name="notes" class="form-control" id="notes" cols="30" rows="4" placeholder="Lütfen koçunuzdan hangi alanınız hakkında, detaylı bir şekilde hangi alt dalda destek almak istediğinizi detaylı bir şekilde açıklayınız."></textarea>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="submit" value="Randevu Oluşturun" class="btn btn-primary">
                        <div class="submitting"></div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-lg-4 col-md-5 d-flex align-items-stretch">
              <div class="info-wrap bg-primary w-100 p-md-5 p-4">
                <h3>İletişime Geçelim</h3>
                <p class="mb-4">Randevu oluşturun, sizi arayalım!</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
document.getElementById('coaching_type').addEventListener('change', async function () {
  const coachingTypeId = this.value;
  const coachSelect = document.getElementById('coach');
  coachSelect.innerHTML = '<option value="">Loading...</option>';
  
  if (coachingTypeId) {
    try {
      const response = await fetch(`get_coaches.php?coaching_type_id=${coachingTypeId}`);
      if (!response.ok) throw new Error(`Error: ${response.statusText}`);
      const coaches = await response.json();
      
      coachSelect.innerHTML = '';

      if (coaches.length > 0) {
        coaches.forEach(coach => {
          const option = document.createElement('option');
          option.value = coach.koc_id;
          option.textContent = coach.koc_ad;
          coachSelect.appendChild(option);
        });
      } else {
        coachSelect.innerHTML = '<option value="">No coaches available</option>';
      }
    } catch (error) {
      console.error('Error fetching coaches:', error);
      coachSelect.innerHTML = '<option value="">Error loading coaches</option>';
    }
  } else {
    coachSelect.innerHTML = '<option value="">Please select a coaching type first</option>';
  }
});
</script>

<?php
include('compoments/footer.php');
?>
