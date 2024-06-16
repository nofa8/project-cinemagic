@extends('layouts.main')

@section('header-title', 'Statistics')

@section('main')
    <div class="flex justify-between max-w-full">
        <div class="flex justify-start">
            <form action="{{ route('statistics.day') }}" method="POST">
                @csrf
                <x-select-input id="day" name="day" class="mt-1 rounded w-full" required autofocus="name">
                    @if(isset($option))
                    @if($option==="MONTH")
                    <option value="MONTH">Last 30 days</option>
                    <option value="WEEK">Last 7 days</option>
                    <option value="TODAY">Today</option>
                    @elseif($option=="WEEK")
                    <option value="WEEK">Last 7 days</option>
                    <option value="TODAY">Today</option>
                    <option value="MONTH">Last 30 days</option>
                    @elseif($option=="TODAY")
                    <option value="TODAY">Today</option>
                    <option value="WEEK">Last 7 days</option>
                    <option value="MONTH">Last 30 days</option>
                    @endif
                    @else
                    <option value="MONTH">Last 30 days</option>
                    <option value="WEEK">Last 7 days</option>
                    <option value="TODAY">Today</option>
                    @endif
                </x-select-input>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 my-2 rounded">
                    Get Statistics
                </button>
            </form>
        </div>
        <div class="flex justify-end">
            <form action="{{ route('statistics.export') }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 my-2 rounded">
                    Export data to Excel
                </button>
            </form>
        </div>
    </div>


    <div class="flex flex-wrap -mx-3">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
            <div class="bg-white rounded-xl shadow-md overflow-hidden md:max-w-full mt-5 p-4 dark:bg-gray-900">
                <div class="md:flex">
                    <div class="p-8">
                        <div class="uppercase tracking-wide text-sm text-black dark:text-white font-semibold">total tickets
                            sold</div>
                        <p class="block mt-1 text-lg leading-tight font-medium text-gray-700 dark:text-gray-300">
                            {{ $totalTickets }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full md:w-1/2 px-3">
            <div class="bg-white rounded-xl shadow-md overflow-hidden md:max-w-full mt-5 p-4 dark:bg-gray-900">
                <div class="md:flex">
                    <div class="p-8">
                        <div class="uppercase tracking-wide text-sm text-black dark:text-white font-semibold">Total Revenue
                        </div>
                        <p class="block mt-1 text-lg leading-tight font-medium text-gray-700 dark:text-gray-300">
                            {{ number_format($totalRevenue, 2) }} €</p>
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
                        <div class="uppercase tracking-wide text-sm text-black dark:text-white font-semibold">Most expensive
                            purchase</div>
                        <p class="block mt-1 text-lg leading-tight font-medium text-gray-700 dark:text-gray-300">
                            {{ $mostExpensivePurchase }} €</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full md:w-1/2 px-3">
            <div class="bg-white rounded-xl shadow-md overflow-hidden md:max-w-full mt-5 p-4 dark:bg-gray-900">
                <div class="md:flex">
                    <div class="p-8">
                        <div class="uppercase tracking-wide text-sm text-black dark:text-white font-semibold">Average
                            Purchase Price</div>
                        <p class="block mt-1 text-lg leading-tight font-medium text-gray-700 dark:text-gray-300">
                            {{ number_format($averagePurchasePrice, 2) }} €</p>
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
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawPieChart);
    google.charts.setOnLoadCallback(drawColumnChart);

    var ticketsTheater = @json($ticketsTheater);
    var moviesGenre = @json($moviesGenre);

    function drawPieChart() {
        var genresData = [
            ['Genre Name', 'Total Movies']
        ];
        moviesGenre.forEach(function(genre) {
            genresData.push([genre.genre_name, genre.total_movies]);
        });

        var data = google.visualization.arrayToDataTable(genresData);

        var isDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
        var textColor = isDarkMode ? 'white' : 'black';
        var legendColor = isDarkMode ? 'white' : 'black';

        var options = {
            title: 'Movies by Genre',
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
        var theaterData = [
            ['Theater', 'Total Tickets', {
                role: 'style'
            }]
        ];
        ticketsTheater.forEach(function(theater) {
            // Adding some default colors for bars, you can customize as needed
            theaterData.push([theater.theater_name, theater.total_tickets, 'color: #76A7FA']);
        });

        console.log(theaterData); // Debugging data

        var data = google.visualization.arrayToDataTable(theaterData);

        var isDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
        var textColor = isDarkMode ? 'white' : 'black';
        var legendColor = isDarkMode ? 'white' : 'black';

        var options = {
            title: 'Theater Ticket Sales',
            backgroundColor: 'transparent',
            titleTextStyle: {
                color: textColor
            },
            legend: {
                textStyle: {
                    color: legendColor
                }
            },
            hAxis: {
                titleTextStyle: {
                    color: textColor
                },
                textStyle: {
                    color: textColor
                }
            },
            vAxis: {
                titleTextStyle: {
                    color: textColor
                },
                textStyle: {
                    color: textColor
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
