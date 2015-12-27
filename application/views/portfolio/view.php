    <div class="fse">
      <div class="container">
        <h1><?= $portfolio_item[ 'project_name' ]; ?></h1>
        <p><?= $portfolio_item[ 'description' ]; ?></p>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-6">
            <div class="thumbnail">
            <div class="bs-example">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Carousel indicators -->
                    <!-- Wrapper for carousel items -->
                    <div class="carousel-inner">
                      <?php $inCnt = 0;
                            foreach ($portfolio_image as $image_row) { ?>                        
                              <div class="item<? if( $inCnt == 0 ) echo( ' active' ); ?>">
                                <img src="<?= base_url() . $image_row->image_url; ?>" />
                              </div>
                      <?php   $inCnt++;
                            } ?>
                    </div>
                    <ol class="carousel-indicators">
                      <?php 
                        $inCnt = 0;
                        foreach ($portfolio_image as $image_indicator_row) { ?>
                          <li data-target="#myCarousel" data-slide-to="<?= $inCnt; ?>"<?php if( $inCnt == 0) { ?> class="active"<?php } ?>></li>
                  <?php   $inCnt++;
                        } ?>
                    </ol>   
                    <!-- Carousel controls -->
                </div>
            </div>
            </div>          
        </div>
        
        <div class="col-md-6">
    <?php foreach ($portfolio_detail as $portfolio_row) { ?>
            <h2><?= $portfolio_row->title; ?></h2>
            <p class="details"><? echo( $portfolio_row->detail_text ); ?></p><br />
    <?php } ?>
        </div>
      </div> 
      <div class="row">       
        <div class="col-md-12">
          <br />&nbsp;<hr />
          <h2>Somewhat Socially Active</h2><br />
          <p><img src="<?= base_url(); ?>img/twitter_logo.png" alt="Twitter" class="logo-img" />Come check out things I've been reading lately, reposted on Twitter <a href="http://twitter.com/fullstackebeck" target="_blank">@fullstackebeck</a>, and sometimes, the occasional original thought.<br />
          <img src="<?= base_url(); ?>img/linkedin_logo.png" alt="LinkedIn" class="logo-img" />Or have a look a my <a href="https://ca.linkedin.com/in/chris-ellerbeck-238a9b2" target="_blank">LinkedIn</a> profile photo for an example of my Photoshop skills. My face was way too shiny.</p>
        </div>        
      </div>  
    </div> <!-- /container -->
    <footer class="footer">
      <div class="container">
          <p>&copy; Copyright 2015 Chris Ellerbeck</p>
      </div>
    </footer>
