<?php

defined('CONTROL') or die('Acesso Inválido');

$api = new ApiConsumer();
$country = $_GET['country_name'] ?? null;

if (!$country) {
  header('Location:?route=home');
  die();
}

$country_data = $api->get_country($country);

if (is_string($country_data)) {
    echo "<p>$country_data</p>";
    die();
}

?>

<div class="countainer mt-5">
  <div class="d-flex">
      <div class="card p-2 shadow">
        <img src="<?= $country_data['flags']['png'] ?>" alt="Flag of <?= $country_data['name']['common'] ?>">
      </div>
      <div class="ms-5 align-self-center">
        <p class="display-3"><strong><?= $country_data['name']['common'] ?></strong></p>
        <p class="p-0 m-0">Capital: </p>
        <p class="p-0 m-0"><?= $country_data['capital'][0] ?></p>
      </div>
  </div>
  <div class="row mt-3">
    <div class="col">
      <p>Região:<br><strong><?= $country_data['region'] ?></strong></p>
      <p>Sub-região:<br><strong><?= $country_data['subregion'] ?></strong></p>
      <p>População:<br><strong><?= number_format($country_data['population']) ?></strong></p>
      <p>Área:<br><strong><?= number_format($country_data['area']) ?> km<sup>2</sup></strong></p>
    </div>
  </div>
  <div>
    <a href="?route=home" class="btn btn-primary px-5">Voltar</a>
  </div>
</div>
