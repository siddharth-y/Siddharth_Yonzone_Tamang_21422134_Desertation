<?php
include('layout/header.php'); // Include the 'header.php' file, which contains the HTML header section of the website.
include('layout/navigation.php'); // Include the 'navigation.php' file, which contains the website's navigation menu.
?>




<!-- ======= Hero Section ======= -->
<section id="hero">
  <div class="hero-container">
    <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">

      <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

      <div class="carousel-inner" role="listbox">

        <!-- Slide 1 -->
        <div class="carousel-item active" style="background-image: url(assets/img/slide/slides-1.jpg)">
          <div class="carousel-container">
            <div class="carousel-content">
              <h2 class="animate__animated animate__fadeInDown">Welcome to <span>Treks in Nepal</span></h2>
              <p class="animate__animated animate__fadeInUp">Thrilling treks in Nepal's majestic landscapes, featuring Himalayan vistas, ancient trails, and diverse cultural encounters. Unforgettable adventure awaits!</p>
            </div>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item" style="background-image: url(assets/img/slide/slides-2.jpg)">
          <div class="carousel-container">
            <div class="carousel-content">
              <h2 class="animate__animated fanimate__adeInDown">History of <span>Nepal</span></h2>
              <p class="animate__animated animate__fadeInUp">The Himalayan nation of Nepal has a lengthy history that dates back more than 2,500 years. Before King Prithvi Narayan Shah united them in the middle of the 18th century and founded the Shah dynasty, it had previously been split into several tiny kingdoms. Up until the middle of the 20th century, when it began to open up to the world, Nepal had remained mostly unconnected to the outside world. Embracing a federal democratic republic and abolishing its monarchy, Nepal underwent a dramatic political shift in 2008. Today, Nepal is renowned for both its rich cultural legacy and its breathtaking natural vistas, which include Mount Everest.</p>
            </div>
          </div>
        </div>

        <!-- Slide 3 -->
        <div class="carousel-item" style="background-image: url(assets/img/slide/slides-3.jpg)">
          <div class="carousel-container">
            <div class="carousel-content">
              <h2 class="animate__animated animate__fadeInDown">Culture of <span>Nepal</span></h2>
              <p class="animate__animated animate__fadeInUp">Hinduism and Buddhism are two major influences on Nepal's culture, which is weaved from the threads of many different nationalities and religions. Festivals like Dashain, Tihar, and Buddha Jayanti are enthusiastically observed and provide a window into the spiritual core of the nation. The beautifully carved temples and stupas that make up traditional architecture are evidence of Nepal's rich cultural history. Momo and dal bhat are two examples of the tasty ingredients and spices used in Nepali cuisine. Visitors are made to feel at home in this culturally varied and gorgeous Himalayan country by the kindness and hospitality of the Nepali people.
              </p>
            </div>
          </div>
        </div>

        <!-- Slide 4 -->
        <div class="carousel-item" style="background-image: url(assets/img/slide/slides-4.jpg)">
          <div class="carousel-container">
            <div class="carousel-content">
              <h2 class="animate__animated animate__fadeInDown">Geography of <span>Nepal</span></h2>
              <p class="animate__animated animate__fadeInUp">South Asian landlocked nation of Nepal is renowned for its varied geography. It includes Mount Everest, the tallest mountain in the world, which rises 8,848 meters (29,029 ft) above sea level in the Himalayan range that runs along Tibet's northern border. While the southern Terai lowland plains are abundant in fertile land and fauna, the middle region is marked by rolling hills and valleys. The Ganges and Brahmaputra rivers are part of the nation's large river network, and Nepal's varied climate spans from tropical in the Terai to alpine in the Himalayas. The appeal of Nepal as a location for trekking, mountaineering, and discovering its distinctive ecosystems is influenced by its diverse landscape.
              </p>
            </div>
          </div>
        </div>

      </div>

      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
      </a>

      <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
      </a>

    </div>
  </div>
</section><!-- End Hero -->

<main id="main">

  <!-- ======= Featured Section ======= -->
  <section id="featured" class="featured">
    <div class="container">

      <div class="row">
        <div class="col-lg-4">
          <div class="icon-box">
            <img src="assets/img/frontend/city.jpg" alt="City Image" style="width: 100%; ">
            <h3><a href="cityTour.php">City Tour</h3>
            <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident</p>
            </a>
          </div>
        </div>
        <div class="col-lg-4 mt-4 mt-lg-0">
          <div class="icon-box">
            <img src="assets/img/frontend/peak.jpg" alt="Man Waking in snow Image" style="width: 100%;">
            <h3><a href="mountainSummit.php">Mountain Summit</h3>
            <p>Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat tarad limino ata</p>
            </a>
          </div>
        </div>
        <div class=" col-lg-4 mt-4 mt-lg-0">
          <div class="icon-box">
            <img src="assets/img/frontend/trekking.jpg" alt="Man Waking in snow Image" style="width: 100%; height: 69.5%">
            <h3><a href="trekkingCardDetail.php">Trekking</h3>
            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur</p>
            </a>
          </div>
        </div>
      </div>

    </div>
  </section><!-- End Featured Section -->

  <!-- ======= About Section ======= -->
  <section id="about" class="about">
    <div class="container">

      <div class="row">
        <div class="col-lg-6">
          <img src="assets/img/frontend/everest.jpg" class="img-fluid" alt="">
        </div>
        <div class="col-lg-6 pt-4 pt-lg-0 content">
          <h3>About Treks in Nepal</h3>
          <p class="fst-italic">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
            magna aliqua.
          </p>
          <ul>
            <li><i class="bi bi-check-circle"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
            <li><i class="bi bi-check-circle"></i> Duis aute irure dolor in reprehenderit in voluptate velit.</li>
            <li><i class="bi bi-check-circle"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate trideta storacalaperda mastiro dolore eu fugiat nulla pariatur.</li>
          </ul>
          <p>
            Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
            velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
            culpa qui officia deserunt mollit anim id est laborum
          </p>
        </div>
      </div>

    </div>
  </section><!-- End About Section -->

  <!-- ======= Services Section ======= -->
  <section id="services" class="services">
    <div class="container">

      <div class="row">
        <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
          <div class="icon-box">
            <img src="assets/img/slide/hiking.jpeg">
            <h4><a href="">Trekking & Hiking</a></h4>
            <p>Trekking and hiking are outdoor pursuits that entail strolling through the great outdoors, discovering new pathways, and having an experience amidst beautiful scenery.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
          <div class="icon-box">
            <img src="assets/img/slide/sight.jpeg">
            <h4><a href="">Sight Seeing & City Tour</a></h4>
            <p>Indulge in local culture, delve into the country's past, and take in the stunning views of the Himalayas and old temples on sightseeing and city trips in Nepal.
            </p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0">
          <div class="icon-box">
            <img src="assets/img/slide/art.jpeg">
            <h4><a href="">Cultural and Art Tour</a></h4>
            <p>With trips to museums, art galleries, and cultural sites, cultural and art excursions offer a look into Nepal's rich legacy.
            </p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
          <div class="icon-box">
            <img src="assets/img/slide/rafting.jpeg">
            <h4><a href="">Rafting</a></h4>
            <p>Rafting in Nepal is an exciting activity that combines magnificent natural scenery with heart-pounding rapids on the country's pristine rivers.
            </p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
          <div class="icon-box">
            <img src="assets/img/slide/bunjee.jpeg">
            <h4><a href="">Bunjee Jumping</a></h4>
            <p>In Nepal, bungee jumping is a thrilling activity that promises an adrenaline rush and spectacular views.
            </p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
          <div class="icon-box">
            <img src="assets/img/slide/paraliding.jpeg">
            <h4><a href="">Paragliding</a></h4>
            <p>Paragliding is an exhilarating activity that offers amazing aerial views of Nepal's gorgeous landscapes.
            </p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
          <div class="icon-box">
            <img src="assets/img/slide/junglesafari.jpeg">
            <h4><a href="">Jungle Safari</a></h4>
            <p>Explore Nepal's gorgeous national parks on a thrilling jungle safari to see a variety of animals in their natural settings.
            </p>
          </div>
        </div>
      </div>

    </div>
  </section><!-- End Services Section -->


  <!-- ======= Affialiated With Section ======= -->
  <section id="clients" class="clients">
    <div class="container">

      <div class="section-title">
        <h2>Affialiated With</h2>
        <p>We are a trekking company in Nepal with official authorization. We have diligently adhered to all required legal requirements, got all required licenses and certificates, and are now qualified to provide travel services in Nepal.
        </p>
      </div>

      <div class="clients-slider swiper">
        <div class="swiper-wrapper align-items-center">
          <div class="swiper-slide"><img src="assets/img/frontend/nepal-tourism-board-logo.png" class="img-fluid" alt=""></div>
          <div class="swiper-slide"><img src="assets/img/frontend/NGOV.png" class="img-fluid" alt=""></div>
          <div class="swiper-slide"><img src="assets/img/frontend/NMA.png" class="img-fluid" alt=""></div>
          <div class="swiper-slide"><img src="assets/img/frontend/logo-taan.png" class="img-fluid" alt=""></div>
          <div class="swiper-slide"><img src="assets/img/frontend/KEEP.png" class="img-fluid" alt=""></div>
        </div>
        <div class="swiper-pagination"></div>
      </div>

    </div>
  </section><!-- End Clients Section -->

</main><!-- End main -->

<?php

include('layout/footer.php');
?>