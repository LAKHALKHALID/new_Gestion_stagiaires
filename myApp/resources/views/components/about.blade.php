<!-- About Us Section -->
<style>
  /* About Section Custom Tweaks */
.about-section {
    background-color: #f8f9fa;
}

/* Tracking text spacing */
.tracking-wider {
    letter-spacing: 1.5px;
}

/* Subtle image scale effect matching the hero section */
.about-image-container svg {
    transition: transform 0.4s ease, box-shadow 0.4s ease;
}

.about-image-container:hover svg {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05) !important;
}
</style>
    
    <section class="about-section bg-white py-5 border-top border-bottom" id="about">
      <div class="container mb-5 mt-0 text-center">
          <!-- Section Title -->
          <h2 class="fw-bold text-dark display-5 mb-3 position-relative d-inline-block">
              À Propos de Nous
              <span class="position-absolute start-50 translate-middle-x bottom-0 bg-primary rounded" style="width: 50px; height: 4px; transform: translateY(10px);"></span>
          </h2>
          <!-- Section Description (Slightly spaced out with mt-4) -->
          <p class="text-secondary lead max-width-md mx-auto my-0" style="max-width: 600px;">
              Découvrez notre mission, nos valeurs et l'équipe passionnée qui s'engage à simplifier la gestion et le suivi quotidien de vos stagiaires.
          </p>
      </div>
        <div class="container py-0">
            <div class="row align-items-center g-5">
                
                <!-- Left Column: Illustration/Image -->
                <div class="col-lg-6 order-2 order-lg-1">
                    <div class="about-image-container text-center">
                        <!-- Clean Inline SVG representing tracking, collaboration, and management -->
                        <img style="width: 400px" src="{{asset('images/about.png')}}" alt="">
                    </div>
                </div>

                <!-- Right Column: Text Content -->
                <div class="col-lg-6 order-1 order-lg-2">
                    <span class="text-primary fw-bold text-uppercase tracking-wider small d-block mb-2">Qui sommes-nous ?</span>
                    <h2 class="fw-bold text-dark mb-4 mb-lg-3 display-6">
                        Simplifier l'encadrement de vos futurs talents
                    </h2>
                    <p class="text-secondary mb-4">
                        <strong>Gestion des Stagiaires</strong> est une solution conçue pour combler le fossé entre les encadrants, les établissements de formation et les stagiaires. Notre mission est d'automatiser les tâches administratives lourdes afin que vous puissiez vous concentrer sur l'essentiel : le développement des compétences.
                    </p>
                    
                    <!-- Key Pillars List -->
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-circle-check text-success fs-5"></i>
                                <span class="text-dark fw-medium">Gain de temps précieux</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-circle-check text-success fs-5"></i>
                                <span class="text-dark fw-medium">Suivi rigoureux & clair</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-circle-check text-success fs-5"></i>
                                <span class="text-dark fw-medium">Centralisation des données</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-circle-check text-success fs-5"></i>
                                <span class="text-dark fw-medium">Génération de rapports</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>