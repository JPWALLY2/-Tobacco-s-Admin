<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => '',

    'title_prefix' => '',

    'title_postfix' => ' - Tabaco Admin',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>Tabaco</b>Admin',

    'logo_mini' => '<b>T</b>Ad',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'green',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => 'fixed',

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => '',

    'logout_url' => 'logout',

    'logout_method' => null,

    'login_url' => 'login',

    'register_url' => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menu' => [
        [
            'text'        => 'Cadastros e Listagens',
            'icon'        => 'list',
            'submenu' => [
                [
                    'text' => 'Marcas',
                    'url'  => 'admin/marcas',
                    'icon' => 'circle-notch',
                    'icon_color' => 'green',
                ],
                [
                    'text' => 'Tipos de Insumos',
                    'url'  => 'admin/tiposInsumos',
                    'icon' => 'circle-notch',
                    'icon_color' => 'green',
                ],
                [
                    'text' => 'Insumos',
                    'url'  => 'admin/insumos',
                    'icon' => 'circle-notch',
                    'icon_color' => 'green',
                ],
                [
                    'text' => 'Empresas',
                    'url'  => 'admin/empresas',
                    'icon' => 'circle-notch',
                    'icon_color' => 'green',
                ],
                [
                    'text' => 'Orientadores',
                    'url'  => 'admin/instrutores',
                    'icon' => 'circle-notch',
                    'icon_color' => 'green',
                ],
                [
                    'text' => 'Visitas',
                    'url'  => 'admin/visitas',
                    'icon' => 'circle-notch',
                    'icon_color' => 'green',
                ],
                [
                    'text' => 'Lavouras',
                    'url'  => 'admin/lavouras',
                    'icon' => 'circle-notch',
                    'icon_color' => 'green',
                ],
                [
                    'text' => 'Plantações',
                    'url'  => 'admin/plantacoes',
                    'icon' => 'circle-notch',
                    'icon_color' => 'green',
                ],
                [
                    'text' => 'Classes',
                    'url'  => 'admin/classes',
                    'icon' => 'circle-notch',
                    'icon_color' => 'green',
                ],
                [
                    'text' => 'Estoque',
                    'url'  => 'admin/estoques',
                    'icon' => 'circle-notch',
                    'icon_color' => 'green',
                ],
               
            ],
        ],
        [
            'text'        => 'Operações',
            'icon'        => 'book',
            'submenu' => [
               
                [
                    'text' => 'Produção',
                    'url'  => 'admin/producoes',
                    'icon' => 'circle-notch',
                    'icon_color' => 'aqua',
                ],
                [
                    'text' => 'Baixar Insumos',
                    'url'  => 'admin/indexBaixasInsumos',
                    'icon' => 'circle-notch',
                    'icon_color' => 'aqua',
                ],
                [
                    'text' => 'Compras',
                    'url'  => 'admin/compras',
                    'icon' => 'circle-notch',
                    'icon_color' => 'aqua',
                ],
                [
                    'text' => 'Vendas',
                    'url'  => 'admin/vendas',
                    'icon' => 'circle-notch',
                    'icon_color' => 'aqua',
                ],
                [
                    'text' => 'Histórico de Compras',
                    'url'  => 'admin/historicoCompras',
                    'icon' => 'circle-notch',
                    'icon_color' => 'aqua',
                ],
                [
                    'text' => 'Histórico de Vendas',
                    'url'  => 'admin/historicoVendas',
                    'icon' => 'circle-notch',
                    'icon_color' => 'aqua',
                ],
               
            ],
        ],
        [
            'text'        => 'Gráficos',
            'icon'        => 'chart-bar',
            'submenu' => [
                [
                    'text' => 'Vendas por Empresas',
                    'url'  => 'admin/vendasempgraf',
                    'icon' => 'circle-notch',
                    'icon_color' => 'red',
                ],
                [
                    'text' => 'Compras por Empresas',
                    'url'  => 'admin/comprasempgraf',
                    'icon' => 'circle-notch',
                    'icon_color' => 'red',
                ],
                // [
                //     'text' => 'Vendas por Anos',
                //     'url'  => 'admin/vendasanosgraf',
                //     'icon' => 'circle-notch',
                //     'icon_color' => 'red',
                // ],
                [
                    'text' => 'Marcas por Insumos',
                    'url'  => 'admin/marcasInsumosgraf',
                    'icon' => 'circle-notch',
                    'icon_color' => 'red',
                ],
            ],
        ],
        [
            'text'        => 'Relatórios',
            'icon'        => 'file-invoice',
            'submenu' => [
                [
                    'text' => 'Anos',
                    'url'  => 'admin/relEscolhaAno',
                    'icon' => 'circle-notch',
                    'icon_color' => 'yellow',
                ],
                [
                    'text' => 'Insumos',
                    'url'  => 'admin/relEscolha3',
                    'icon' => 'circle-notch',
                    'icon_color' => 'yellow',
                ],
                [
                    'text' => 'Fumo Vendido',
                    'url'  => 'admin/relEscolha',
                    'icon' => 'circle-notch',
                    'icon_color' => 'yellow',
                ],
                [
                    'text' => 'Insumos Comprados',
                    'url'  => 'admin/relEscolha2',
                    'icon' => 'circle-notch',
                    'icon_color' => 'yellow',
                ],
            ],
        ],
        [
            'text'        => 'Estimativa',
            'icon'        => 'file-invoice-dollar',
            'url'  => 'admin/estimativas',

        
    ],
],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => true,
        'chartjs'    => true,
    ],
];
