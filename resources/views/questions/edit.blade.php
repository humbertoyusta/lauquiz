<x-site-layout>
    <x-page-title title="Edit a Question" />
    <div class="card m-auto mt-5 mb-5" style="width: 50rem;">
        <x-form route="{{route('questions.update', ['question' => $question['id']])}}" method="PUT" button_name="Edit Question">
            @csrf
            <x-form-input-text name="content" :errors="$errors" :value="$question['content']" />
        </x-form>
        <ol class="list-group mt-5">
            @foreach($question->answers as $answer)
                <li class="list-group-item">
                    <x-form :route="route('answers.update', ['answer' => $answer->id])" method="PUT" button_name="Edit Answer">
                        <input type="hidden" name="question_id" value="{{$question->id}}" />
                        <x-form-input-text name="content" :errors="$errors" value="{{$answer->content}}"></x-form-input-text>
                    </x-form>
                    <div class="mt-2"> 
                        <x-delete-button :route="route('answers.destroy', ['answer' => $answer->id])" />
                    </div>
                </li>
            @endforeach
            <li class="list-group-item">
                <x-form :route="route('answers.store')" method="POST" button_name="Add new Answer">
                    <input type="hidden" name="question_id" value="{{$question->id}}" />
                    <x-form-input-text name="content" :errors="$errors" value=""></x-form-input-text>
                </x-form>
            </li>
        </ol>
        <div class="mt-4">
            <x-get-button route="{{route('quizzes.edit', ['quiz' => $question['quiz_id']])}}" name="Done" />
        </div>
    </div>
</x-site-layout>