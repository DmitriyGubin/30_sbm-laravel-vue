<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>{{ $title }}</title>
		<script src="{{ config('global.path') }}/js/functions.js?v=77"></script>
		<!-- @vite(['resources/css/app.scss','resources/js/app.js']) -->
		<link rel="preload" as="style" href="/public/build/assets/app-ChtV2qc_.css">
		<link rel="preload" as="style" href="/public/build/assets/app-Cnu6wNA8.css">
		<link rel="modulepreload" href="/public/build/assets/app-BTY_mriF.js">
		<link rel="stylesheet" href="/public/build/assets/app-ChtV2qc_.css">
		<link rel="stylesheet" href="/public/build/assets/app-Cnu6wNA8.css">
		<script type="module" src="/public/build/assets/app-BTY_mriF.js"></script>
	</head>
	<body>
		<div class="main_wrapper">
			<div>
				<x-headerr />
				{{ $slot }}
			</div>
			
			<x-footer />
		</div>
		<x-popup />
		<x-popup-check />
		<script type="module" src="{{ config('global.path') }}/js/main.js?v=77"></script>

		<!-- <a data-fancybox="" data-src="#check_popup" class="call_order" href="javascript:;">Проверка</a> -->
	</body>
</html> 