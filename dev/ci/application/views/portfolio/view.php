    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <span class="bebas-title">FULL STACK ELLERBECK</span>
        </div>
      </div>
    </nav>

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

    </div> <!-- /container -->
    <footer class="footer">
      <div class="container">
          <p>&copy; Copyright 2015 Chris Ellerbeck</p>
      </div>
    </footer>
