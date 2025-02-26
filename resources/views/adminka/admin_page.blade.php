<x-layout>
	<x-slot:title>
		Кабинет администратора
	</x-slot>
	<section class="admin wrapper all_cabs">
		<h1 class="title wrapper">Кабинет администратора</h1>

		<button id="update_providers_tech" class="univ_button">
            <span class="opt_butt send">Обновить список поставщиков и техники</span>
            <div class="opt_butt loader hide"></div>
		</button>
		
		<div id="vue_users_all"></div>
	</section>
</x-layout>