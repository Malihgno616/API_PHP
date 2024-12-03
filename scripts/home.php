<?php
defined('CONTROL') or die('Acesso Inválido'); 

// get all countries data
$api = new ApiConsumer();
$countries = $api->get_all_countries();

?>

<div class="container mt-5">
    <div class="row">
        <div class="col text-center">
            <h3>Países do Mundo</h3>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-4">
            <p>Lista de países</p>
            <select id="select_country" class="form-select">
                <option value="">Selecione um país</option>
                <?php foreach($countries as $country) : ?>
                <option value="<?= $country['name'] ?>"><?= $country['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // country selected
    const select_country = document.querySelector("#select_country");
    select_country.addEventListener('change', () => {
        const country = select_country.value;
        if (country) { // Verifica se o país não está vazio
            console.log(country);
            window.location.href = `?route=country&country_name=${country}`;
        }
    });
});
</script>