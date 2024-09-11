<!-- Loading -->
<div id="loading-ajax" style=""><img src="resources/global/images/loading-ajax.gif" /></div>
<!-- ./Loading -->

<footer class="site-footer">
    <!-- Footer Top Area -->
    <div class="footer-top-area">
        <div class="container">
           <div class="row">
               <div class="col-md-4">
                    <div class="footer-top-info">
                       <span class="footer-icons"><i class="fa fa-map-o"></i></span> <p><?=$dataResult[23]['valor_string']; ?></p>
                    </div>
               </div>
               <div class="col-md-4">
                    <div class="footer-top-info">
                       <span class="footer-icons"><i class="fa fa-clock-o"></i></span> <p><?=$dataResult[15]['valor_string']; ?></p>
                    </div>
               </div>
               <div class="col-md-4">
                    <div class="footer-top-info">
                       <span class="footer-icons"><i class="fa fa-headphones"></i></span> <p>Llaménos al <?=$dataResult[17]['valor_string']; ?></p>
                    </div>
               </div>
           </div>
           <div class="hr-line"></div>
            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <div class="footer-wid">
                        <a href="<?=APP_URL;?>" class="footer-logo"><img src="admin/<?=$dataResult[22]['valor_string']; ?>" alt="logo"></a>
                        <p>
                          <?=$dataResult[35]['valor_string']; ?>
                        </p>
                        <a href="<?=APP_URL;?>/?view=conocenos" class="link-color">Leer más sobre nosotros <i class="fa  fa-long-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12">
                    <div class="row">
                        <div class="col-md-4 col-lg-4">
                            <div class="footer-wid footer-menu">
                                <h3 class="footer-wid-title">Navegación</h3>
                                <ul>
                                  <li class="nav-item">
      																<a class="nav-link" href="<?=APP_URL;?>">Inicio</a>
      														</li>

      														<li class="nav-item">
      																<a class="nav-link" href="<?=APP_URL;?>/?view=conocenos">Conócenos</a>
      														</li>

      														<li class="nav-item">
      																<a class="nav-link" href="<?=APP_URL;?>/?view=servicios">Servicios</a>
      														</li>

      														<li class="nav-item">
      																<a class="nav-link" href="<?=APP_URL;?>/?view=galeria">Galería</a>
      														</li>

      														<li class="nav-item">
      																<a class="nav-link" href="<?=APP_URL;?>/?view=contacto">Contacto</a>
      														</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-4 col-lg-4">
                            <div class="footer-wid footer-menu">
                                <h3 class="footer-wid-title">Nuestros Horarios de atención</h3>
                                <ul>
                                    <li><i class="fa  fa-angle-right"></i> Lunes: <?=$dataResult[28]['valor_string'];?></li>
                                    <li><i class="fa  fa-angle-right"></i> Martes: <?=$dataResult[29]['valor_string'];?></li>
                                    <li><i class="fa  fa-angle-right"></i> Miércoles: <?=$dataResult[30]['valor_string'];?></li>
                                    <li><i class="fa  fa-angle-right"></i> Jueves: <?=$dataResult[31]['valor_string'];?></li>
                                    <li><i class="fa  fa-angle-right"></i> Viernes: <?=$dataResult[32]['valor_string'];?></li>
                                    <li><i class="fa  fa-angle-right"></i> Sábado: <?=$dataResult[33]['valor_string'];?></li>
                                    <li><i class="fa  fa-angle-right"></i> Domingo: <?=$dataResult[34]['valor_string'];?></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-4 col-lg-4">
                            <div class="footer-wid map-preview">
                                <h3 class="footer-wid-title">Estar en Contacto</h3>
                                <p><?=$dataResult[23]['valor_string']; ?></p>
                                <div class="address-info">
                                    <span><i class="fa fa-phone"></i> <?=' ' . $dataResult[17]['valor_string']; ?></span><br>
                                    <span><i class="fa fa-envelope"></i><?=' ' . $dataResult[16]['valor_string']; ?></span>
                                </div>
                                <div class="subscribe">
                                    <form id="frmSuscribirseFooter">
                                        <input type="text" placeholder="Ingrese su correo" required="required"
                                        id="correo_suscribirse" name="correo_suscribirse" autocomplete="off">
                                        <button type="submit" id="btnSuscribirteFooter">Subscríbete ahora <i class="fa  fa-paper-plane"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="social-icos">
                        <ul class="list-inline">
                            <li><a href="<?=$dataResult[18]['valor_string']; ?>" target="_blank"r><i class="fa fa-facebook"></i></a></li>
                            <li><a href="<?=$dataResult[19]['valor_string']; ?>" target="_blank"r><i class="fa fa-instagram"></i></a></li>
                            <li><a href="<?=$dataResult[20]['valor_string']; ?>" target="_blank"r><i class="fa fa-youtube"></i></a></li>
                            <li><a href="<?=$dataResult[21]['valor_string']; ?>" target="_blank"r><i class="fa fa-twitter"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Footer Top -->

    <!-- Footer Bottom Area -->
    <div class="footer-copyright-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-5">
                  <?=APP_TITLE;?>  &copy; Copyright 2019 All Rights Reserved.
                </div>
                <div class="col-lg-6 col-md-7 text-right">
                    <a href="#">Terms & Condition</a> <span class="seprator">|</span> <a href="#">Privacy Policy</a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Bottom Area -->
</footer>
