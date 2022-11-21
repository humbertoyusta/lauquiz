<x-site-layout>
    <x-page-title title="Answer a Question" />
    <div class="card m-auto mt-5 mb-5" style="width: 50rem;">
        <h2 class="m-3">{{$question->content}}</h2>
        <img src="{{$question->image}}" alt="Question Image" width="300" height="300" class="rounded mx-auto d-block" />
        <ol class="list-group">
            <x-form :route="route('play.questions.store', ['quiz' => $quiz_id, 'question' => $question->id, 'answered_quiz' => $answered_quiz_id])" method="POST" button_name="Next">
                @foreach($question->answers as $answer)
                    <div class="list-group-item">
                        <x-form-input-radio name="answer_id" :text="$answer->content" :value="$answer->id"></x-form-input-radio>
                    </div>
                @endforeach
                <x-form-input-error name="answer_id" :errors="$errors"></x-form-input-error>
            </x-form>
        </ol>
    </div>
</x-site-layout>