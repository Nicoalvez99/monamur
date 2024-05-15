<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('images/favicon-monamur.png') }}" type="image/x-icon">
    <title>Monamur - Charts</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/assets/css/tailwind.output.css') }}" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="{{ asset('/assets/js/init-alpine.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>

<body>
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
        @include('layouts.sidebar')
        <div class="flex flex-col flex-1 w-full">
            @include('layouts.header')
            <main class="h-full overflow-y-auto">
                <div class="container px-6 mx-auto grid">
                    <div class="flex justify-between">
                        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                            Charts
                        </h2>
                    </div>
                    <div class="my-3">
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                            <div class="max-w-sm w-full rounded-lg shadow bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center me-3">
                                            <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                                                <path d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z" />
                                                <path d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-1">{{ Number::abbreviate($totalHistorial, precision: 2) }}</h5>
                                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Ventas generadas por semana</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="column-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div style="display: none;">
        <div class="col-12 col-sm-6">
            <p>Ventas del día domingo: <span id="domingo">{{ $ventasPorDiasSemana['domingo'] ?? 0 }}</span></p>
            <p>Ventas del día Lunes: <span id="lunes">{{ $ventasPorDiasSemana['lunes'] ?? 0 }}</span></p>
            <p>Ventas del día Martes: <span id="martes">{{ $ventasPorDiasSemana['martes'] ?? 0 }}</span></p>
            <p>Ventas del día Miercoles: <span id="miercoles">{{ $ventasPorDiasSemana['miércoles'] ?? 0 }}</span></p>
            <p>Ventas del día Jueves: <span id="jueves">{{ $ventasPorDiasSemana['jueves'] ?? 0 }}</span></p>
            <p>Ventas del día viernes: <span id="viernes">{{ $ventasPorDiasSemana['viernes'] ?? 0 }}</span></p>
            <p>Ventas del día sabado: <span id="sabado">{{ $ventasPorDiasSemana['sábado'] ?? 0 }}</span></p>
        </div>
    </div>
    <script>
        let lunes = document.getElementById('lunes').textContent;
        let martes = document.getElementById('martes').textContent;
        let miercoles = document.getElementById('miercoles').textContent;
        let jueves = document.getElementById('jueves').textContent;
        let viernes = document.getElementById('viernes').textContent;
        let sabado = document.getElementById('sabado').textContent;
        let domingo = document.getElementById('domingo').textContent;
        const options = {
            colors: ["#1A56DB", "#FDBA8C"],
            series: [{
                name: "Ventas",
                color: "#1A56DB",
                data: [{
                        x: "Lun",
                        y: lunes
                    },
                    {
                        x: "Mar",
                        y: martes
                    },
                    {
                        x: "Mie",
                        y: miercoles
                    },
                    {
                        x: "Jue",
                        y: jueves
                    },
                    {
                        x: "Vie",
                        y: viernes
                    },
                    {
                        x: "Sab",
                        y: sabado
                    },
                    {
                        x: "Dom",
                        y: domingo
                    },
                ],
            }, ],
            chart: {
                type: "bar",
                height: "320px",
                fontFamily: "Inter, sans-serif",
                toolbar: {
                    show: false,
                },
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "70%",
                    borderRadiusApplication: "end",
                    borderRadius: 8,
                },
            },
            tooltip: {
                shared: true,
                intersect: false,
                style: {
                    fontFamily: "Inter, sans-serif",
                },
            },
            states: {
                hover: {
                    filter: {
                        type: "darken",
                        value: 1,
                    },
                },
            },
            stroke: {
                show: true,
                width: 0,
                colors: ["transparent"],
            },
            grid: {
                show: false,
                strokeDashArray: 4,
                padding: {
                    left: 2,
                    right: 2,
                    top: -14
                },
            },
            dataLabels: {
                enabled: false,
            },
            legend: {
                show: false,
            },
            xaxis: {
                floating: false,
                labels: {
                    show: true,
                    style: {
                        fontFamily: "Inter, sans-serif",
                        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                    }
                },
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
            },
            yaxis: {
                show: false,
            },
            fill: {
                opacity: 1,
            },
        }

        if (document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("column-chart"), options);
            chart.render();
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>

</html>