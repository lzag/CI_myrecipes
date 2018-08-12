<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">My Recipes</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">

     <?=anchor('pages/index', 'Home', 'class="nav-item nav-link"')?>
     <?=anchor('pages/all', 'See all recipes', 'class="nav-item nav-link"')?>
     <?=anchor('pages/by_type', 'See recipes by type', 'class="nav-item nav-link"')?>
     <?=anchor('pages/add', 'Add a recipe', 'class="nav-item nav-link"')?>
     <?=anchor('pages/manage', 'Manage recipes', 'class="nav-item nav-link"')?>
<!--
      <a class="nav-item nav-link" href="#">Home</a>
      <a class="nav-item nav-link" href="#">See recipes</a>
      <a class="nav-item nav-link" href="#">Add a recipe</a>
      <a class="nav-item nav-link" href="#">Manage recipes</a>
-->
    </div>
  </div>
</nav>

	<div class="container mt-3">
