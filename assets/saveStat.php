 <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3 id="target">150</h3>

                <p>Recette</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3 id="target2">53<sup style="font-size: 20px">%</sup></h3>

                <p>Depenses</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3 id="target3">44</h3>

                <p>Prévision</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3 id="target4">65</h3>

                <p>Net en caisse</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>

<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.color.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/js/jquery.animateNumber.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/js/jquery.animateNumber.js"></script>

        <script>
  var decimal_places = 1;
  var decimal_factor = decimal_places === 0 ? 1 : decimal_places * 10;

  $('#target').animateNumber(
    {
      number: 100 * decimal_factor,
      color: 'white',
      'font-size': '30px',

      numberStep: function(now, tween) {
        var floored_number = Math.floor(now) / decimal_factor,
            target = $(tween.elem);
        if (decimal_places > 0) {
          floored_number = floored_number.toFixed(decimal_places);
        }

        target.text(floored_number+ ' FCFA');
      }
    },
    {
      easing: 'swing',
      duration: 2500
    }
  )

   $('#target1').animateNumber(
    {
      number: 100 * decimal_factor,
      color: 'white',
      'font-size': '30px',

      numberStep: function(now, tween) {
        var floored_number = Math.floor(now) / decimal_factor,
            target = $(tween.elem);
        if (decimal_places > 0) {
          floored_number = floored_number.toFixed(decimal_places);
        }

        target.text(floored_number+ ' FCFA');
      }
    },
    {
      easing: 'swing',
      duration: 2500
    }
  )
    $('#target2').animateNumber(
    {
      number: 100 * decimal_factor,
      color: 'white',
      'font-size': '30px',

      numberStep: function(now, tween) {
        var floored_number = Math.floor(now) / decimal_factor,
            target = $(tween.elem);
        if (decimal_places > 0) {
          floored_number = floored_number.toFixed(decimal_places);
        }

        target.text(floored_number+ ' FCFA');
      }
    },
    {
      easing: 'swing',
      duration: 2500
    }
  )
     $('#target3').animateNumber(
    {
      number: 2500000 * decimal_factor,
      color: 'white',
      'font-size': '30px',

      numberStep: function(now, tween) {
        var floored_number = Math.floor(now) / decimal_factor,
            target = $(tween.elem);
        if (decimal_places > 0) {
          floored_number = floored_number.toFixed(decimal_places);
        }

        target.text(floored_number+ ' FCFA');
      }
    },
    {
      easing: 'swing',
      duration: 2500
    }
  )
      $('#target4').animateNumber(
    {
      number: 100000 * decimal_factor,
      color: 'white',
      'font-size': '30px',

      numberStep: function(now, tween) {
        var floored_number = Math.floor(now) / decimal_factor,
            target = $(tween.elem);
        if (decimal_places > 0) {
          floored_number = floored_number.toFixed(decimal_places);
        }

        target.text(floored_number+ ' FCFA');
      }
    },
    {
      easing: 'swing',
      duration: 2500
    }
  )
</script>