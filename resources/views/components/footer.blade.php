<footer>
        <div class="wrapper gid_box">
            <div class="foot_item">
                <img src="{{ config('global.path') }}/img/logo_white.avif" alt="лого" class="logo">
                <div class="rekv">
                    <div>ИНН 542501016420</div>
                    <div>ОГРНИП 320547600100694</div>
                </div>
                <div class="year">
                    Все права защищены 2025
                </div>
            </div>

            <ul class="foot_item menu">
                <x-menu />
            </ul>

            <div class="foot_item">
                <div class="title">Мы в социальных сетях:</div>
                <div class="social_box">
                    <a target="_blank" class="round" href="https://vk.com/sbm_nsk">
                        <img src="{{ config('global.path') }}/img/vk.svg" alt="Вконтакте">
                    </a>
                </div>
            </div>

            <div class="foot_item last">
                <div class="title">
                    <div>Новосибирск, ул. Галущака 4</div>
                    <div>Работаем с 9:00 до 17:00</div>
                </div>

                <a class="cont_item" href="tel:+73832304389">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#ffffff"
                        stroke="#ffffff" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-phone-call">
                        <path
                            d="M15.05 5A5 5 0 0 1 19 8.95M15.05 1A9 9 0 0 1 23 8.94m-1 7.98v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                    </svg>
                    <div class="cont_title phone">8 (383) 230-43-89</div>
                </a>

                <a class="cont_item" href="mailto:lid@1sbm.ru">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff"
                        class="bi bi-envelope-fill" viewBox="0 0 16 16">
                        <path
                            d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z" />
                    </svg>
                    <div class="cont_title">lid@1sbm.ru</div>
                </a>
            </div>
        </div>
</footer>

