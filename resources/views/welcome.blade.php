<x-site-layout>
    <div class="card m-auto mt-5" style="width: 30rem;">
        <img src="/images/picwish.png" class="card-img-top" alt="...">
        <div class="card-body">
            <p class="card-text">Making simple quizzes has never been so easy.</p>
            <x-get-button :route="route('quizzes.create')" name="Get Started"></x-get-button>
        </div>
    </div>
</x-site-layout>