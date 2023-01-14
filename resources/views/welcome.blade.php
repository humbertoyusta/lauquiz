<x-site-layout>
    <div class="card m-auto mt-5" style="width: 36rem;">
        <x-application-logo />
        <div class="card-body">
            <p class="card-text">Making simple quizzes has never been so easy.</p>
            <x-get-button :route="route('play.index')" name="Get Started"></x-get-button>
            <p class="card-text">
                Currently, on {{$weatherOverview['city']}}, the temperature is 
                {{$weatherOverview['temperature']}} °C, it feels like 
                {{$weatherOverview['feelsLikeTemp']}} °C, the maximum temperature today is
                {{$weatherOverview['maxTemp']}} °C, and the minimum is
                {{$weatherOverview['minTemp']}} °C
            </p>
        </div>
    </div>
</x-site-layout>