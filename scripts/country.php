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

// Verificações para evitar erros
$flag_url = $country_data['flags']['png'] ?? 'default_flag.png'; // Use uma imagem padrão se não houver flag
$country_name = $country_data['name'] ?? 'Nome não disponível';
$capital = $country_data['capital'] ?? 'Capital não disponível';
$region = $country_data['region'] ?? 'Região não disponível';
$subregion = $country_data['subregion'] ?? 'Sub-região não disponível';
$population = number_format($country_data['population'] ?? 0);
$area = number_format($country_data['area'] ?? 0);

?>

<div class="countainer mt-5">
    <div class="d-flex">
        <div class="card p-2 shadow">
            <img src="<?= $flag_url ?>" alt="Flag of <?= htmlspecialchars($country_name) ?>">
        </div>
        <div class="ms-5 align-self-center">
            <p class="display-3"><strong><?= htmlspecialchars($country_name) ?></strong></p>
            <p class="p-0 m-0">Capital: </p>
            <p class="p-0 m-0"><?= htmlspecialchars($capital) ?></p>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <p>Região:<br><strong><?= htmlspecialchars($region) ?></strong></p>
            <p>Sub-região:<br><strong><?= htmlspecialchars($subregion) ?></strong></p>
            <p>População:<br><strong><?= $population ?></strong></p>
            <p>Área:<br><strong><?= $area ?> km<sup>2</sup></strong></p>
        </div>
    </div>
    <div>
        <a href="?route=home" class="btn btn-primary px-5">Voltar</a>
    </div>
</div>