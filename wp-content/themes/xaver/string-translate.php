<?php

if (is_plugin_active('polylang\polylang.php')) {
    


$groupe = 'Theme';

pll_register_string( 'sidebar',     'ДИСКУССИОННЫЙ КЛУБ',           $groupe);
pll_register_string( 'sidebar',     'Дискуссионных клубов нет.',    $groupe);
pll_register_string( 'sidebar',     'Посмотреть все',    $groupe);
pll_register_string( 'meta',     'Идеи и Идеалы',    $groupe);
pll_register_string( 'CF Taxonomy',     'Том журнала',    'plugin');
pll_register_string( 'CF Taxonomy',     'Год издания журнала',    'plugin');
pll_register_string( 'CF Taxonomy',     'Номер журнала',    'plugin');
//pll_register_string( 'II-redcolegiao',     'РЕДАКЦИЯ',    'plugin');
//pll_register_string( 'II-redcolegiao',     'РЕДАКЦИОННЫЙ СОВЕТ',    'plugin');
//pll_register_string( 'II-redcolegiao',     'МЕЖДУНАРОДНЫЙ РЕДАКЦИОННЫЙ СОВЕТ',    'plugin');

}