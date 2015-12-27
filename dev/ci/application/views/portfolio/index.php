    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <span class="bebas-title">FULL STACK ELLERBECK</span>
        </div>
      </div>
    </nav>

    <div class="fse">
      <div class="container">
        <h1>Portfolio</h1>
        <p>Below is a sample of some of the web development, design, and motion graphics work I've done over the course of my career.</p>
        <p>This page will be changing on a regular basis with new work, experiments, and anything I feel like showing publically.</p>
        <p>Many pieces were a team effort, but that's what it's all about, team, likeminded professionals making cool things.</p>
      </div>
    </div>

    <div class="container">
      <div class="row">

  <?php $count = 0;
        foreach ($portfolio as $portfolio_item) {
          if( $count % 3 ) echo( '<div class="row">' ); ?>
            <div class="col-sm-6 col-md-4">
              <div class="thumbnail">
                <img src="<?= base_url(); ?>img/<?php echo( $portfolio_item['thumb_url'] ); ?>" alt="..." style="border: 1px solid #ddd;">
                <div class="caption">
                  <h3><a href="<?php echo( $portfolio_item['project_url'] ); ?>" target="blank"><?php echo $portfolio_item['project_name']; ?></a></h3>
                  <p><i><?php echo $portfolio_item['intro_blurb']; ?></i></p>
                  <p><a href="portfolio/view/<?php echo( $portfolio_item[ 'slug' ] ); ?>" class="btn btn-default" role="button">Details</a></p>
                </div>
              </div>
            </div>
    <?php if( $count % 3 ) echo( '</row>' );
       } 
       $count++; // foreach ?>
      </div>
    </div> <!-- /container -->
    <footer class="footer">
      <div class="container">
          <p>&copy; Copyright 2015 Chris Ellerbeck</p>
      </div>
    </footer>