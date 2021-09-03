<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Weather Holiday Forecaster</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28 font-sans bg-gray-50">
<h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl mb-6">Holiday Weather Forecaster</h1>
<div class="text-base text-gray-500 mb-6">
    Want to know if your holiday destination's going to be rained out, snowed in, or subject to a sandstorm? Register your details below and get daily weather updates for the 5 days prior to your trip up until the day that you head home.
</div>
<form>
    <div class="border-2 rounded-md border-gray-200 bg-white p-2 md:p-6 mb-6">
        <div class="">
            <div class="mb-4">
                <input class="border-2 rounded-md border-gray-200 w-full p-4 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50"
                       type="text"
                       id="name"
                       name="name"
                       tabindex="1"
                       placeholder="Your full name">
            </div>
            <div class="mb-4">
                <input class="border-2 rounded-md border-gray-200 w-full p-4 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50"
                       type="text"
                       name="city"
                       tabindex="2"
                       placeholder="Your city">
            </div>
            <div class="mb-4">
                <input class="border-2 rounded-md border-gray-200 w-full p-4 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50"
                       type="tel"
                       name="phone_number"
                       tabindex="3"
                       placeholder="Your telephone number">
            </div>
            <div class="mb-4">
                <input class="border-2 rounded-md border-gray-200 w-full p-4 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50"
                       type="date"
                       name="start_date"
                       tabindex="4"
                       placeholder="Start date of your holidays"
                >
            </div>
            <div class="mb-4">
                <input class="border-2 rounded-md border-gray-200 w-full p-4 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50"
                       type="date"
                       name="end_date"
                       tabindex="5"
                       placeholder="End date of your holidays"
                >
            </div>
        </div>
        <div class="mb-4 md:mb-6 mt-6">
            <input type="checkbox" class="p-4 mr-2 ml-2"> By checking this, you agree to the <a href="" class="underline text-gray-900">Privacy Policy</a> and <a href="">Cookie Policy</a>.
        </div>
        <div>
            <button tabindex="6" class="w-full md:w-auto flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50"><span>Register</span></button>
        </div>
    </div>
    <script src="js/app.js"
</form>
</body>
</html>
