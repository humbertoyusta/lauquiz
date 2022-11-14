<x-site-layout>
    <x-page-title title="Answer a Question" />
    <div class="card m-auto mt-5 mb-5" style="width: 50rem;">
        <h2 class="m-3">{{$question->content}}</h2>
        <ol class="list-group">
            <x-form :route="route('play.questions.store', ['quiz' => $quiz_id, 'question' => $question->id])" method="POST" button_name="Next">
                @foreach($question->answers as $answer)
                    <div class="list-group-item">
                        <x-form-input-radio name="answer_id" :text="$answer->content" :value="$answer->id"></x-form-input-radio>
                    </div>
                @endforeach
            </x-form>
        </ol>
    </div>
</x-site-layout>