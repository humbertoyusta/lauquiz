<x-site-layout>
    <div class="card m-auto mt-5" style="width: 36rem;">
        <x-application-logo />
        <div class="card-body">
            @if($weatherOverview)
                <h4>Weather overview:</h4>
                <p class="card-text">
                    Currently, on {{$weatherOverview['city']}}, the temperature is 
                    {{$weatherOverview['temperature']}} °C, it feels like 
                    {{$weatherOverview['feelsLikeTemp']}} °C, the maximum temperature today is
                    {{$weatherOverview['maxTemp']}} °C, and the minimum is
                    {{$weatherOverview['minTemp']}} °C
                </p>
            @endif
        </div>
    </div>
</x-site-layout>