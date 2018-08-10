
	<div class="col-md-6">
	<?=$error?>
<?php echo form_open_multipart('pages/upload_recipe');?>
  <div class="form-group">
    <label for="title">Title</label>
    <input name="title" type="text" class="form-control" id="title" placeholder="Recipe Title">
  </div>
  <div class="form-group">
    <label for="type">Type</label>
    <input name="type" type="text" class="form-control" id="type" placeholder="Recipe type">
  </div>
  <div class="form-group">
    <label for="description">Recipe description</label>
    <textarea name="description" class="form-control" id="description" rows="10"></textarea>
  </div>
    <div class="form-group">
    <label for="recipe_photo">Recipe photo</label>
    <input type="file" name="photo" class="form-control-file" id="recipe_photo">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
<?=form_close()?>

	</div>

