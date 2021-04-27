<?php
require_once "vendor/autoload.php";
require_once "src/BreedsCollection.php";
require_once "src/CategoryCollection.php";
require_once "src/Collection.php";
require_once "src/DecoratorLogging.php";
require_once "src/FileLogging.php";
require_once "src/ImagesCollection.php";
require_once "src/RequestAdapter.php";

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

?>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
		  integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
			integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
			crossorigin="anonymous"></script>
	<h2>Category search</h2>
	<form action="/" method="get">

		<select name="category-search">
			<?php foreach ( CategoryCollection::getCategoryList( null, null ) as $key => $value ): ?>
				<option value="<?php echo $value->getId(); ?>"><?php echo $value->getName(); ?></option>
			<?php endforeach; ?>
		</select>
		<button type="submit">Submit</button>
	</form>

	<table class="table">
		<thead>
		<tr>
			<th scope="col">#</th>
			<th scope="col">Name</th>
			<th scope="col">Description</th>
			<th scope="col">temperament</th>
			<th scope="col">Image</th>
		</tr>
		</thead>
		<tbody>
		<?php $getBreedsList = BreedsCollection::getBreedsList( 5, $_GET['page-breeds'] ?? 1 ) ?>
		<?php foreach ( $getBreedsList['content'] as $breed ): ?>
			<tr>
				<td><a href="/?breed-id=<?= $breed->getId(); ?>"><?= $breed->getId(); ?></a></td>
				<td><?= $breed->getName(); ?></td>
				<td><?= $breed->getDescription(); ?></td>
				<td><?= $breed->getTemperament(); ?></td>
				<td><img width="100" src="https://cdn2.thecatapi.com/images/<?= $breed->getReferenceImageId(); ?>.jpg">
				</td>
			</tr>
		<?php endforeach; ?>

		</tbody>
	</table>
	<nav aria-label="Page navigation example">
		<ul class="pagination">
			<?php for ( $i = 1; $i < ceil( $getBreedsList['count_page'] / 5 ); $i += 1 ): ?>
				<li class="page-item"><a class="page-link" href="/?<?= http_build_query( [
						'page-breeds' => $i,
					] ) ?>"><?= $i ?></a></li>
			<?php endfor; ?>
		</ul>
	</nav>
<?php
if ( $_GET['breed-id'] ): ?>
	<h2>SearchByBreeds</h2>
	<table class="table">
		<thead>
		<tr>
			<th scope="col">id</th>
			<th scope="col">url</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ( ImagesCollection::searchByBreeds( $_GET['breed-id'] ) as $searchByBreedsKey => $searchByBreedsValue ): ?>
			<tr>
				<td><?= $searchByBreedsValue->getId(); ?></td>
				<td><img width="250" src="<?= $searchByBreedsValue->getUrl(); ?>"></td>
				</td>
			</tr>
		<?php endforeach; ?>

		</tbody>
	</table>
<?php
endif;

if ( $_GET['category-search'] ): ?>
	<h2>SearchByCategory</h2>
	<table class="table">
		<thead>
		<tr>
			<th scope="col">id</th>
			<th scope="col">url</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ( ImagesCollection::searchByCategory( $_GET['category-search'] )[1] as $searchByBreedsKey => $searchByBreedsValue ): ?>
			<tr>
				<td><?= $searchByBreedsValue->getId(); ?></td>
				<td><img width="250" src="<?= $searchByBreedsValue->getUrl(); ?>"></td>
				</td>
			</tr>
		<?php endforeach; ?>

		</tbody>
	</table>
<?php
endif;


