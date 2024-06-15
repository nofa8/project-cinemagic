@extends('layouts.main')

@section('header-title', 'Statistics')

@section('main')
    <div class="flex justify-end">
        <form action="{{ route('statistics.export') }}" method="POST">
            @csrf
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Export data to Excel
            </button>
        </form>
    </div>

    <div class="flex flex-wrap -mx-3">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
            <div class="bg-white rounded-xl shadow-md overflow-hidden md:max-w-full mt-5 p-4 dark:bg-gray-900">
                <div class="md:flex">
                    <div class="p-8">
                        <div class="uppercase tracking-wide text-sm text-black dark:text-white font-semibold">total tickets sold</div>
                        <p class="block mt-1 text-lg leading-tight font-medium text-gray-700 dark:text-gray-300">{{ $totalTickets }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full md:w-1/2 px-3">
            <div class="bg-white rounded-xl shadow-md overflow-hidden md:max-w-full mt-5 p-4 dark:bg-gray-900">
                <div class="md:flex">
                    <div class="p-8">
                        <div class="uppercase tracking-wide text-sm text-black dark:text-white font-semibold">Total Revenue</div>
                        <p class="block mt-1 text-lg leading-tight font-medium text-gray-700 dark:text-gray-300">{{ number_format($totalRevenue,2) }} €</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap -mx-3">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
            <div class="bg-white rounded-xl shadow-md overflow-hidden md:max-w-full mt-5 p-4 dark:bg-gray-900">
                <div class="md:flex">
                    <div class="p-8">
                        <div class="uppercase tracking-wide text-sm text-black dark:text-white font-semibold">Most expensive purchase</div>
                        <p class="block mt-1 text-lg leading-tight font-medium text-gray-700 dark:text-gray-300">{{ $mostExpensivePurchase }} €</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full md:w-1/2 px-3">
            <div class="bg-white rounded-xl shadow-md overflow-hidden md:max-w-full mt-5 p-4 dark:bg-gray-900">
                <div class="md:flex">
                    <div class="p-8">
                        <div class="uppercase tracking-wide text-sm text-black dark:text-white font-semibold">Average Purchase Price</div>
                        <p class="block mt-1 text-lg leading-tight font-medium text-gray-700 dark:text-gray-300">{{ number_format($averagePurchasePrice,2) }} €</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-center items-center flex-wrap">
        <div id="piechart" style="width: 450px; height: 500px;"></div>
        <div id="columnchart" style="width: 450px; height: 500px;"></div>
    </div>
@endsection

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawPieChart);
google.charts.setOnLoadCallback(drawColumnChart);

function drawPieChart() {
    var data = google.visualization.arrayToDataTable([
    ['Task', 'Hours per Day'],
    ['Work',     11],
    ['Eat',      2],
    ['Commute',  2],
    ['Watch TV', 2],
    ['Sleep',    7]
    ]);

    var isDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

    var textColor = isDarkMode ? 'white' : 'black';
    var legendColor = isDarkMode ? 'white' : 'black';

    var options = {
    title: 'My Daily Activities',
    is3D: true,
    backgroundColor: 'transparent',
    titleTextStyle: {
        color: textColor
    },
    legend: {
        textStyle: {
        color: legendColor
        }
    },
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
}

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
    drawPieChart();
});

function drawColumnChart() {
    var data = google.visualization.arrayToDataTable([
        ['Element', 'Density', { role: 'style' }],
        ['Copper', 8.94, '#b87333'],
        ['Silver', 10.49, 'silver'],
        ['Gold', 19.30, 'gold'],

    ['Platinum', 21.45, 'color: #e5e4e2' ],
    ]);

    var isDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

    var textColor = isDarkMode ? 'white' : 'black';
    var legendColor = isDarkMode ? 'white' : 'black';

    var options = {
    title: 'My Daily Activities',
    is3D: true,
    backgroundColor: 'transparent',
    titleTextStyle: {
        color: textColor
    },
    legend: {
        textStyle: {
        color: legendColor
        }
    },
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('columnchart'));
    chart.draw(data, options);
}

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
    drawColumnChart();
});

</script>

