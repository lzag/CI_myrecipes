
<div class="col-md-6">
<?php echo form_open_multipart('pages/add');?>
  <div class="form-group">
    <label for="title">Title</label>
    <?=form_error('title','<div class="text-danger small">','</div>')?>
    <input name="title" type="text" class="form-control" id="title" placeholder="Recipe Title" value="<?=set_value('title')?>">
  </div>
  <div class="form-group">
    <label for="type">Type</label>
    <?=form_error('type','<div class="text-danger small">','</div>')?>
    <input name="type" type="text" class="form-control" id="type" placeholder="Recipe type" value="<?=set_value('type')?>">
  </div>
  <div class="form-group">
    <label for="description">Recipe description</label>
    <?=form_error('description','<div class="text-danger small">','</div>')?>
    <textarea name="description" class="form-control" id="description" rows="10" ><?=set_value('description')?></textarea>
  </div>
    <div class="form-group">
    <label for="recipe_photo">Recipe photo</label>
    <?=form_error('photo','<div class="text-danger small">','</div>')?>
    <input type="file" name="photo" class="form-control-file" id="recipe_photo">
  </div>
  	<div class="form-group">
		<label for="captcha">Submit the word you see below:</label>
		<?=form_error('captcha','<div class="text-danger small">','</div>')?>
		<br>
		<?=$cap_img?><br>
		<input type="text" name="captcha" value="">
	</div>
		<button type="submit" class="btn btn-primary">Submit</button>
			<?=form_close()?>

	</div>

