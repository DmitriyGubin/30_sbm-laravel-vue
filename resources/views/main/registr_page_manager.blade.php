<x-layout>
	<x-slot:title>
		Регистрация менеджера
	</x-slot>
	<section class="form_box full">
        <div class="wrap">
            <h1 class="title">Регистрация менеджера</h1>
            <div class="three_col">
                <img class="col" src="{{ config('global.path') }}/img/car_1.png">

               <x-Registr :id="$id" />

                <img class="col" src="{{ config('global.path') }}/img/car_2.png">
            </div>
        </div>
    </section>
</x-layout>