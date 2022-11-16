<x-site-layout>
    <x-page-title title="Finished" />
    <div class="card m-auto mt-5 mb-5" style="width: 30rem;">
        <h2 class="m-3">You have completed quiz {{$quiz->title}}</h2>
        <p class="m-3">
            You have answered correctly {{$performance['correct_answers_count']}} 
            out of {{$performance['answers_count']}} questions
        </p>
    </div>
</x-site-layout>