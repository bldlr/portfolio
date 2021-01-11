      <?php 
        require_once("include/init.php");
        require_once("include/header.php");
      ?>
      
      <!-- Accueil -->
      
      <main class="main">

        <div class="arrow-left"></div>
        <div class="arrow-right"></div>

        <!-- Start revolution slider -->

        <div class="rev_slider_wrapper">
          <div id="rev_slider" class="rev_slider fullscreenbanner">
            <ul>

              <!-- Slide 1 -->

              <li  data-transition="slotzoom-horizontal" data-slotamount="7" data-masterspeed="1000" data-fsmasterspeed="1000">

                <!-- Main image-->

                <img src="img/imagesUpload/<?= $image1['titre'] ?>"  alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg">

                <!-- Layer 1 -->

                <div class="slide-title tp-caption tp-resizeme" 
                  data-x="['right','right','right','right']" data-hoffset="['-18','-18','-18','-18']" 
                  data-y="['middle','middle','middle','middle']" data-voffset="['-35','-35', '-25']"
                  data-fontsize="['50','45']"
                  data-lineheight="['80','75', '65']"
                  data-width="['1100','700','550']"
                  data-height="none"
                  data-whitespace="normal"
                  data-transform_idle="o:1;"
                  data-transform_in="x:[105%];z:0;rX:45deg;rY:0deg;rZ:90deg;sX:1;sY:1;skX:0;skY:0;s:2000;e:Power2.easeInOut;" 
                  data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" 
                  data-mask_in="x:50px;y:0px;s:inherit;e:inherit;" 
                  data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" 
                  data-start="500" 
                  data-splitin="chars" 
                  data-splitout="none" 
                  data-responsive_offset="on" 
                  data-elementdelay="0.05"><?= $partie1['titre'] ?>
                </div>

                <!-- Layer 2 -->

                <div class="slide-subtitle tp-caption tp-resizeme"
                  data-x="['right','right','right','right']" data-hoffset="['0']" 
                  data-y="['middle','middle','middle','middle']" data-voffset="['75','105']"
                  data-fontsize="['18','19']" 
                  data-lineheight="['30','30']" 
                  data-whitespace="nowrap"
                  data-transform_idle="o:1;"
                  data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1200;e:Power1.easeInOut;" 
                  data-transform_out="opacity:0;s:1000;s:1000;" 
                  data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" 
                  data-start="1500" 
                  data-splitin="none" 
                  data-splitout="none"><?= $partie1['paragraphe1'] ?><br><?= $partie1['paragraphe2'] ?>
                </div>

                <!-- Layer 3 -->

                <div class="tp-caption"
                  data-x="['right','right','right','right']" data-hoffset="['0','0','0','0']" 
                  data-y="['middle','middle','middle','middle']" data-voffset="['195','215']"
                  data-fontsize="['17','18']" 
                  data-width="none"
                  data-height="none"
                  data-whitespace="nowrap"
                  data-transform_idle="o:1;"
                  data-transform_hover="o:1;rX:0;rY:0;rZ:0;z:0;s:300;e:Power1.easeInOut;"
                  data-style_hover="c:rgba(255, 255, 255, 1.00);bc:rgba(255, 255, 255, 1.00);"
                  data-transform_in="y:50px;opacity:0;s:1500;e:Power4.easeInOut;" 
                  data-transform_out="y:[175%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" 
                  data-mask_out="x:inherit;y:inherit;" 
                  data-start="1500" 
                  data-splitin="none" 
                  data-splitout="none" 
                  data-responsive_offset="on"><a href="#developpeur" class="btn js-target-scroll"><?= $partie1['bouton'] ?><i class="icon-next"></i></a>
                </div>
              </li>

              <!-- Slide 2 -->

              <li data-transition="slotzoom-horizontal" data-slotamount="7" data-easein="Power3.easeInOut" data-easeout="Power3.easeInOut" data-masterspeed="1000">

                <!-- Main image -->

                <img src="img/imagesUpload/<?= $image2['titre'] ?>"  alt=""  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg">

                <!-- Layer 1 -->

                <div class="slide-title tp-caption tp-resizeme" 
                  data-x="['right','right','right','right']" data-hoffset="['-18','-18','-18','-18']" 
                  data-y="['middle','middle','middle','middle']" data-voffset="['-35','-35', '-55']"
                  data-fontsize="['50','45', '45']"
                  data-lineheight="['80','75','65']"
                  data-width="['1100','700','550']"
                  data-height="none"
                  data-whitespace="normal"
                  data-transform_idle="o:1;"
                  data-transform_in="x:[105%];z:0;rX:45deg;rY:0deg;rZ:90deg;sX:1;sY:1;skX:0;skY:0;s:2000;e:Power2.easeInOut;" 
                  data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" 
                  data-mask_in="x:50px;y:0px;s:inherit;e:inherit;" 
                  data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" 
                  data-start="500" 
                  data-splitin="chars" 
                  data-splitout="none" 
                  data-responsive_offset="on"
                  data-elementdelay="0.05"><?= $partie2['titre'] ?>
                </div>


                <!-- Layer 2 -->

                <div class="slide-subtitle tp-caption tp-resizeme"
                  data-x="['right','right','right','right']" data-hoffset="['0']" 
                  data-y="['middle','middle','middle','middle']" data-voffset="['75','105']"
                  data-fontsize="['18','19']" 
                  data-lineheight="['30','30']" 
                  data-whitespace="nowrap"
                  data-transform_idle="o:1;"
                  data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1200;e:Power1.easeInOut;" 
                  data-transform_out="opacity:0;s:1000;s:1000;" 
                  data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" 
                  data-start="1500" 
                  data-splitin="none" 
                  data-splitout="none"><?= $partie2['paragraphe1'] ?><br><?= $partie2['paragraphe2'] ?>
                </div>

                <!-- Layer 3 -->

                <div class="tp-caption"
                  data-x="['right','right','right','right']" data-hoffset="['0','0','0','0']" 
                  data-y="['middle','middle','middle','middle']" data-voffset="['195','215']"
                  data-fontsize="['17','18']" 
                  data-width="none"
                  data-height="none"
                  data-whitespace="nowrap"
                  data-transform_idle="o:1;"
                  data-transform_hover="o:1;rX:0;rY:0;rZ:0;z:0;s:300;e:Power1.easeInOut;"
                  data-style_hover="c:rgba(255, 255, 255, 1.00);bc:rgba(255, 255, 255, 1.00);"
                  data-transform_in="y:50px;opacity:0;s:1500;e:Power4.easeInOut;" 
                  data-transform_out="y:[175%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" 
                  data-mask_out="x:inherit;y:inherit;" 
                  data-start="1500" 
                  data-splitin="none" 
                  data-splitout="none" 
                  data-responsive_offset="on"><a href="#formateur" class="btn js-target-scroll"><?= $partie2['bouton'] ?><i class="icon-next"></i></a>
                </div>
              </li>

              <!-- Slide 3 -->

              <li data-transition="slotzoom-horizontal" data-slotamount="7" data-easein="Power3.easeInOut" data-easeout="Power3.easeInOut" data-masterspeed="1000">

                <!-- Main image-->

                <img src="img/imagesUpload/<?= $image3['titre'] ?>"  alt=""  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg">

                <!-- Layer 1 -->

                <div class="slide-title tp-caption tp-resizeme" 
                  data-x="['right','right','right','right']" data-hoffset="['-18','-18','-18','-18']" 
                  data-y="['middle','middle','middle','middle']" data-voffset="['-35','-35', '-25']"
                  data-fontsize="['50','45', '45']"
                  data-lineheight="['80','75', '65']"
                  data-width="['1000','700','550']"
                  data-height="none"
                  data-whitespace="normal"
                  data-transform_idle="o:1;"
                  data-transform_in="x:[105%];z:0;rX:45deg;rY:0deg;rZ:90deg;sX:1;sY:1;skX:0;skY:0;s:2000;e:Power2.easeInOut;" 
                  data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" 
                  data-mask_in="x:50px;y:0px;s:inherit;e:inherit;" 
                  data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" 
                  data-start="500" 
                  data-splitin="chars" 
                  data-splitout="none" 
                  data-responsive_offset="on"
                  data-elementdelay="0.05"><?= $partie3['titre'] ?>
                </div>


                <!-- Layer 2 -->

                <div class="slide-subtitle tp-caption tp-resizeme"
                  data-x="['right','right','right','right']" data-hoffset="['0']" 
                  data-y="['middle','middle','middle','middle']" data-voffset="['75','105']"
                  data-fontsize="['18','19']" 
                  data-lineheight="['30','30']" 
                  data-whitespace="nowrap"
                  data-transform_idle="o:1;"
                  data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1200;e:Power1.easeInOut;" 
                  data-transform_out="opacity:0;s:1000;s:1000;" 
                  data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" 
                  data-start="1500" 
                  data-splitin="none" 
                  data-splitout="none"><?= $partie3['paragraphe1'] ?><br><?= $partie3['paragraphe2'] ?>
                </div>

                <!-- Layer 3 -->

                <div class="tp-caption"
                  data-x="['right','right','right','right']" data-hoffset="['0','0','0','0']" 
                  data-y="['middle','middle','middle','middle']" data-voffset="['195','215']"
                  data-fontsize="['17','18']" 
                  data-width="none"
                  data-height="none"
                  data-whitespace="nowrap"
                  data-transform_idle="o:1;"
                  data-transform_hover="o:1;rX:0;rY:0;rZ:0;z:0;s:300;e:Power1.easeInOut;"
                  data-style_hover="c:rgba(255, 255, 255, 1.00);bc:rgba(255, 255, 255, 1.00);"
                  data-transform_in="y:50px;opacity:0;s:1500;e:Power4.easeInOut;" 
                  data-transform_out="y:[175%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" 
                  data-mask_out="x:inherit;y:inherit;" 
                  data-start="1500" 
                  data-splitin="none" 
                  data-splitout="none" 
                  data-responsive_offset="on"><a href="#services" class="btn js-target-scroll"><?= $partie3['bouton'] ?><i class="icon-next"></i></a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </main>

      <div class="content">   
      
        <!-- developpeur  -->

        <section id="developpeur" class="about section">
          <div class="container">
            <header class="section-header">
              <h2 class="section-title"><?= $dev['titre1'] ?> <span class="text-primary"><?= $dev['titre2'] ?></span></h2>
              <strong class="fade-title-left">Développeur</strong>
            </header>

            <div class="container text-center">
              <div class="text-parallax" data-stellar-background-ratio="0.85" style="background-image: url('img/imagesUpload/<?= $image5['titre'] ?>');">
                <div class="text-parallax-content"><?= experience() ?></div>
              </div>
              <h4 class="experience-info wow fadeInRight"><span class="text-primary">ans d'expérience</span></h4>
            </div>

            <div class="section-content">
              <div class="row-base row">
                <div class="col-base col-sm-12 col-md-12">
                  <h3 class="col-about-title"><?= $dev['titre_txt1'] ?> <span class="text-primary"><?= $dev['titre_txt2'] ?></span></h3>

                  <div class="col-about-info">

                  <p><?= $dev['texte1'] ?></p>
                  <p><?= $dev['texte2'] ?></p>
                  <p><?= $dev['texte3'] ?></p>
                    
                  </div>


                </div>
              </div>

              <div class="row-base row" >
              


              <div class="col-base col-about-img col-sm-12 text-center col-md-6 boiteImg">
                  <img alt="" class="img-responsive imgBartLord" src="img/imagesUpload/<?= $image4['titre'] ?>">
                </div>



                <div class="col-base col-about-spec col-sm-12 text-center col-md-6">
                  <h3 class="col-about-title"><?= $dev['titre_specialisation'] ?><span class="text-primary">:</span></h3>

                  <div class="service-item">
                    <?php while($specialisation = $pdoSpecialisations->fetch(PDO::FETCH_ASSOC)) : ?>

                      <img alt="" src="img/imagesUpload/<?= $specialisation['image'] ?>">
                      <h4><?= $specialisation['titre'] ?></h4>
                    
                    <?php endwhile; ?>
                  </div>

                </div>

        

 

              </div>
            </div>
          </div>
        </section>

        <!-- formateur -->

        <section id="formateur" class="about section">
          <div class="container">
            <header class="section-header">
              <h2 class="section-title"><?= $titreFormateur[0]['titre1'] ?> <span class="text-primary"><?= $titreFormateur[0]['titre2'] ?></span></h2>
              <strong class="fade-title-left">Formateur</strong>
            </header>
            <div class="section-content">

              <div class="col-base col-about-img col-sm-12 col-md-12 mb-5" >
                  <img alt="" class="imgFormateur" src="img/imagesUpload/<?= $image9['titre'] ?>">
              </div>
              <div class="row-base">

                <div class="clearfix visible-sm"></div>

                <div class="row text-center" style='justify-content:space-around'>



                  <div class="col-base connaissances col-about-spec col-sm-12 col-md-3">
                    <h3 class="col-about-title"><?= $titreFormateur[1]['titre1'] ?><span class="text-primary"> :</span></h3>

                    <?php while($connaissancesLangages = $pdoConnaissancesLangages->fetch(PDO::FETCH_ASSOC)) : ?>

                      <div class="service-item">
                        <img alt="" src="img/imagesUpload/<?= $connaissancesLangages['image'] ?>">
                        <h4><?= $connaissancesLangages['titre'] ?></h4>
                      </div>

                    <?php endwhile; ?>
                  </div>


                  <div class="col-base  connaissances col-about-spec col-sm-12 col-md-3">
                    <h3 class="col-about-title"><?= $titreFormateur[2]['titre1'] ?><span class="text-primary"> :</span></h3>

                    <?php while($connaissancesFrameworks = $pdoConnaissancesFrameworks->fetch(PDO::FETCH_ASSOC)) : ?>

                      <div class="service-item">
                        <img alt="" src="img/imagesUpload/<?= $connaissancesFrameworks['image'] ?>">
                        <h4><?= $connaissancesFrameworks['titre'] ?></h4>
                      </div>

                    <?php endwhile; ?>
                  </div>

                  
                  <div class="col-base  connaissances col-about-spec col-sm-12 col-md-3">
                    <h3 class="col-about-title"><?= $titreFormateur[3]['titre1'] ?><span class="text-primary"> :</span></h3>

                    <?php while($connaissancesCms = $pdoConnaissancesCms->fetch(PDO::FETCH_ASSOC)) : ?>

                      <div class="service-item">
                        <img alt="" src="img/imagesUpload/<?= $connaissancesCms['image'] ?>">
                        <h4><?= $connaissancesCms['titre'] ?></h4>
                      </div>

                    <?php endwhile; ?>
                  </div>

                  <div class="col-base  connaissances col-about-spec col-sm-12 col-md-3">
                    <h3 class="col-about-title"><?= $titreFormateur[4]['titre1'] ?><span class="text-primary"> :</span></h3>

                    <?php while($connaissancesLogiciels = $pdoConnaissancesLogiciels->fetch(PDO::FETCH_ASSOC)) : ?>

                      <div class="service-item">
                        <img alt="" src="img/imagesUpload/<?= $connaissancesLogiciels['image'] ?>">
                        <h4><?= $connaissancesLogiciels['titre'] ?></h4>
                      </div>

                    <?php endwhile; ?>
                  </div>


              </div>

            </div>
          </div>
        </section>

        <!-- Services -->

        <section id="services" class="services section">
          <div class="container  text-center">
            <header class="section-header">
              <h2 class="section-title"><span class="text-primary"><?= $titreService['paragraphe1'] ?> </span><?= $titreService['paragraphe2'] ?></h2>
              <strong class="fade-title-right">services</strong>
            </header>
            
            <div class="section-content">
              <div class="row-services row-base row">
                <div class="col-base col-service col-sm-6 col-md-4 wow fadeInUp">
                  <div class="service-item">
                    <img alt="" src="img/imagesUpload/<?= $serviceImage1['titre'] ?>">
                    <h4><?= $service1['titre'] ?></h4>
                    <p><?= $service1['paragraphe1'] ?></p>
                    <p><?= $service1['paragraphe2'] ?></p>
                    <p><?= $service1['paragraphe3'] ?></p>
                  </div>
                </div>
                <div class="col-base col-service col-sm-6 col-md-4 wow fadeInUp" data-wow-delay="0.3s">
                  <div class="service-item">
                    <img alt="" src="img/imagesUpload/<?= $serviceImage2['titre'] ?>">
                    <h4><?= $service2['titre'] ?></h4>
                    <p><?= $service2['paragraphe1'] ?></p>
                    <p><?= $service2['paragraphe2'] ?></p>
                    <p><?= $service2['paragraphe3'] ?></p>
                  </div>
                </div>
                <div class="clearfix visible-sm"></div>
                <div class="col-base col-service col-sm-6 col-md-4 wow fadeInUp" data-wow-delay="0.6s">
                  <div class="service-item">
                    <img alt="" src="img/imagesUpload/<?= $serviceImage3['titre'] ?>">
                    <h4><?= $service3['titre'] ?></h4>
                    <p><?= $service3['paragraphe1'] ?></p>
                    <p><?= $service3['paragraphe2'] ?></p>
                    <p><?= $service3['paragraphe3'] ?></p>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </section>


        <!-- Contact -->

        <section id="contacts" class="contacts section" style="margin-bottom:80px">
          <div class="container">
            <header class="section-header">
              <h2 class="section-title"><?= $infoContact[5]['titre'] ?> <span class="text-primary"><?= $infoContact[5]['nom'] ?></span></h2>
              <strong class="fade-title-right">contact</strong>
            </header>

            <div class="section-content">
              <div class="row-base row">
                <div class="col-address col-base col-md-4  coordonnees-bart-lord">
                <?= $infoContact[0]['nom'] ?><br>
                <?= $infoContact[1]['nom'] ?><br>
                <?= $infoContact[2]['nom'] ?> (<?= $infoContact[3]['nom'] ?>)
                
                </div>


                <div class="col-base  col-md-8">

                <form class="js-ajax-form" id="frm" >

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <input type="text" name="name" id="inputname" placeholder='Nom' class="form-control" required value="<?= isset($_SESSION['inputs']['name']) ? $_SESSION['inputs']['name'] : ''  ; ?>">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <input type="text" name="email" id="inputemail" placeholder='Email' class="form-control" required value="<?= isset($_SESSION['inputs']['email']) ? $_SESSION['inputs']['email'] : ''  ; ?>">
                        </div>           
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <input type="text" name="telephone" id="inputphone" placeholder='Téléphone' class="form-control" required value="<?= isset($_SESSION['inputs']['telephone']) ? $_SESSION['inputs']['telephone'] : ''  ; ?>">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <input type="text" name="entreprise" id="inputcompany" placeholder='Entreprise' class="form-control" value="<?= isset($_SESSION['inputs']['entreprise']) ? $_SESSION['inputs']['entreprise'] : ''  ; ?>">
                        </div>           
                    </div>

                  <div class="col-xs-12">
                      <div class="form-group">
                          <textarea name="message" id="inputmessage" placeholder='Votre message' required class="form-control"><?= isset($_SESSION['inputs']['message']) ? $_SESSION['inputs']['message'] : ''  ; ?></textarea>
                      </div>           
                  </div>



                  <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" /><br >


                  
                  <div class="success-message"><i class="fa fa-check text-primary"></i> Merci, votre message a été envoyé avec succes</div>
                  <div class="error-message">Il y a eu une erreur, votre message n'a pas été envoyé, veuillez recommencer</div>
                  <div class="text-right ">
                    <button type="submit" class="btn btn-shadow-2 wow swing">Envoyer <i class="icon-next"></i></button>
                  </div>

                </form>

                </div>


              </div>
            </div>
          </div>
        </section>

        <!-- Footer -->

        <footer id="footer" class="footer" style='background: #F7F7F7; margin-top:20px'>     
          <div class="container">
            <div class="row-base row">
              <div class="col-base text-left-md col-md-4">
                <a href="#" class="brand">
                  BART<span class="text-primary">.</span>LORD
                </a>
              </div>

              <div class="text-right-md col-base col-md-4">
                <a href="<?= URL ?>mentions-legales-bart-lord.php">Mentions légales</a>
                <p>© Bart Lord <?= date('Y') ?></p>
                
              </div>

              <div class="text-right-md col-base col-md-4 eeee">
                <a href="#hdp"><img style='width:2em' src="img/img-icon/hdp.png" alt=""></a>
                
              </div>
            </div>
          </div>
        </footer>

        <?php 
          require_once("include/footer.php");
        ?>

       