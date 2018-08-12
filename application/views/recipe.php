<div class="row">
<?php echo $links; ?>
</div>
<div class="row">

<?php

foreach($recipes as $recipe) : ?>
<div class="col-md-3">

 <div class="card" style="">
  <img class="card-img-top" src="<?php echo base_url('img/recipes/') . $recipe['photo_path']; ?>" alt="recipe image">
  <div class="card-body">
    <h5 class="card-title"><?=$recipe['title']; ?></h5>
    <p class="card-text"><?=word_limiter($recipe['description'],100); ?></p>
    <?php echo anchor('pages/get_recipe/'.$recipe['recipe_id'],'See recipe',array(
				'class' => 'btn btn-primary')); ?>
  </div>
</div>
</div>

<?php endforeach; ?>

</div>

