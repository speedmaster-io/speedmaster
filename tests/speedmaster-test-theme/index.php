<?php get_header(); ?>
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <h1>Speedmaster testing page</h1>
      <!-- This comment should not be shown in source if minify HTML is on -->
      <hr>
      <span class="glyphicon glyphicon-check"></span> <- That should be a large GREEN checkbox.

      <div class="delete-me">
        <hr>
        <strong style="color:red">This test should disappear when DOM is loaded.</strong>
      </div>

      <hr>
      <i class="fa fa-check"></i> <- That should be a large green checkmark.

    </div>
    <div class="col-md-6">
      <img src="https://cashloans.nu/wp-content/uploads/2016/03/mobillan.png" alt="">
    </div>
  </div>
</div>
<script>
  jQuery(document).on('ready', function() {
    jQuery('.delete-me').remove();
  });
</script>
<?php get_footer(); ?>
