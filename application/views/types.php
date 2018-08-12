<ul class="nav">
 <?php foreach ($types as $type) : ?>
  <li class="nav-item">
    <?php echo anchor('pages/by_type/'.$type['type'],$type['type'], array(
																	'class' => 'nav-link ')) ;?>
  </li>
  <?php endforeach; ?>
</ul>
