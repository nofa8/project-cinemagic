<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Details</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 p-6">
    <div class="max-w-lg mx-auto bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 border-l-4 border-blue-500 dark:border-blue-400">
        <h1 class="text-2xl font-bold mb-4 text-blue-500 dark:text-blue-400">Ticket Details</h1>
        <ul class="list-none p-0">
            <li class="mb-2">
                <span class="font-semibold text-blue-600 dark:text-blue-300">Ticket ID:</span>
                <span class="text-gray-700 dark:text-gray-300">{{ $ticket->id }}</span>
            </li>
            <li class="mb-2">
                <span class="font-semibold text-blue-600 dark:text-blue-300">Theater:</span>
                <span class="text-gray-700 dark:text-gray-300">{{ $ticket->screening->theater->name }}</span>
            </li>
            <li class="mb-2">
                <span class="font-semibold text-blue-600 dark:text-blue-300">Movie:</span>
                <span class="text-gray-700 dark:text-gray-300">{{ $ticket->screening->movie->title }}</span>
            </li>
            <li class="mb-2">
                <span class="font-semibold text-blue-600 dark:text-blue-300">Date & Time:</span>
                <span class="text-gray-700 dark:text-gray-300">{{ $ticket->screening->date }} {{ $ticket->screening->start_time }}</span>
            </li>
            <li class="mb-2">
                <span class="font-semibold text-blue-600 dark:text-blue-300">Seat:</span>
                <span class="text-gray-700 dark:text-gray-300">{{ $ticket->seat->row }}{{ $ticket->seat->seat_number }}</span>
            </li>
        </ul>
    </div>
</body>
</html>
