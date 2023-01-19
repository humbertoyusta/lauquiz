<div class="card-body">
    <a class="btn btn-outline-primary" wire:click.prevent="getDailyOverview">Daily</a>
    <a class="btn btn-outline-primary" wire:click.prevent="getWeeklyOverview">Weekly</a>
    @if($isDaily)
        <h4>Today's Weather overview:</h4>
        <p class="card-text">
            Today, on {{$city}}, the temperature is
            {{$todayOverview['temperature']}} °C, it feels like
            {{$todayOverview['feelsLikeTemp']}} °C, the maximum temperature today is
            {{$todayOverview['maxTemp']}} °C, and the minimum is
            {{$todayOverview['minTemp']}} °C
        </p>
    @else
        <h4>Weekly Weather Overview: (on {{$city}})</h4>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Date</th>
                <th scope="col">Minimum Temp (°C)</th>
                <th scope="col">maximum Temp (°C)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($weeklyOverview as $dailyOverview)
                    <tr>
                        <th scope="row">{{$dailyOverview['date']}}</th>
                        <td>{{$dailyOverview['minTemp']}}</td>
                        <td>{{$dailyOverview['maxTemp']}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
