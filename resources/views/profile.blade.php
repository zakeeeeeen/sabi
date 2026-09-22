<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

        <title>Profil</title>
        <link rel="icon" type="image/webp" href="{{ asset('assets/sabi.webp') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jua&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-[100dvh] h-[100dvh] overflow-hidden font-['Jua']">
        <div class="landscape-force">
            <div data-app-root data-content style="background-image: url('{{ asset('assets/pantai.webp') }}'); background-size: cover; background-position: center;">
                <div class="w-full h-full flex items-center justify-center p-6">
                @php
                    $isEditing = (bool) request()->query('edit');
                    $currentAvatar = old('avatar', auth()->user()->avatar ?: 'co');
                    $avatarSrc = $currentAvatar === 'ce' ? asset('assets/ce.png') : asset('assets/co.png');
                @endphp

                <div class="w-full max-w-5xl flex flex-col items-center">
            <h1 class="text-5xl md:text-6xl text-[#2D7BFF] mb-6" style="text-shadow: -3px 0 #ffffff, 3px 0 #ffffff, 0 -3px #ffffff, 0 3px #ffffff, 0 6px 0 rgba(0,0,0,0.12);">
                Profil
            </h1>

            @if ($errors->any())
                <div class="w-full max-w-xl mb-4 rounded-xl bg-red-50 border-2 border-red-200 px-4 py-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (! $isEditing)
                <div class="w-full max-w-md flex flex-col items-center">
                    <div class="w-[220px] md:w-[260px] rounded-2xl bg-white p-5 shadow-[0_10px_0_rgba(0,0,0,0.12)] border-4 border-white">
                        <img src="{{ $avatarSrc }}" alt="Avatar" class="w-full h-auto">
                        <div class="mt-4">
                            <label class="block text-xs text-[#2D7BFF] mb-1" for="name_view">Nama</label>
                            <input id="name_view" type="text" value="{{ auth()->user()->name }}" readonly
                                class="w-full h-10 rounded-xl bg-white border-2 border-[#2D7BFF] px-4 text-base outline-none">
                        </div>
                    </div>

                    <a href="{{ route('profile', ['edit' => 1]) }}"
                        class="mt-4 rounded-full border-2 border-white bg-gradient-to-b from-sky-300 to-sky-500 px-10 py-1.5 text-white text-sm shadow-[0_6px_0_rgba(0,0,0,0.12)] hover:brightness-105 active:translate-y-[1px] active:shadow-[0_4px_0_rgba(0,0,0,0.12)]">
                        Edit
                    </a>

                    <a href="{{ route('menu') }}" class="mt-3 text-xs text-slate-800 hover:underline">Kembali</a>
                </div>
            @else
                <form method="POST" action="{{ route('profile.update') }}" class="w-full flex flex-col items-center">
                    @csrf

                    <input type="hidden" name="avatar" id="avatar_value" value="{{ $currentAvatar }}">

                    <div class="w-full max-w-5xl flex items-center justify-center gap-4 md:gap-8">
                        <button type="button" id="avatar_prev" class="w-10 h-10 md:w-12 md:h-12 shrink-0">
                            <img src="{{ asset('assets/kiri.png') }}" alt="Kiri" class="w-full h-full object-contain">
                        </button>

                        <div class="flex items-start justify-center gap-6 md:gap-10">
                            <div id="card_co"
                                class="w-[220px] md:w-[260px] rounded-2xl bg-white p-5 border-4 border-white shadow-[0_10px_0_rgba(0,0,0,0.12)] transition-all duration-300 ease-out">
                                <img src="{{ asset('assets/co.png') }}" alt="Avatar Cowok" class="w-full h-auto">

                                <div class="mt-4">
                                    <label class="block text-xs text-[#2D7BFF] mb-1" for="name_co">Nama</label>
                                    <input id="name_co" type="text" value="{{ old('name', auth()->user()->name) }}"
                                        class="w-full h-10 rounded-xl bg-white border-2 border-[#2D7BFF] px-4 text-base outline-none focus:ring-2 focus:ring-[#2D7BFF]/30">
                                </div>
                            </div>

                            <div id="card_ce"
                                class="w-[220px] md:w-[260px] rounded-2xl bg-white p-5 border-4 border-white shadow-[0_10px_0_rgba(0,0,0,0.12)] transition-all duration-300 ease-out">
                                <img src="{{ asset('assets/ce.png') }}" alt="Avatar Cewek" class="w-full h-auto">

                                <div class="mt-4">
                                    <label class="block text-xs text-[#2D7BFF] mb-1" for="name_ce">Nama</label>
                                    <input id="name_ce" type="text" value="{{ old('name', auth()->user()->name) }}"
                                        class="w-full h-10 rounded-xl bg-white border-2 border-[#2D7BFF] px-4 text-base outline-none focus:ring-2 focus:ring-[#2D7BFF]/30">
                                </div>
                            </div>
                        </div>

                        <button type="button" id="avatar_next" class="w-10 h-10 md:w-12 md:h-12 shrink-0">
                            <img src="{{ asset('assets/kanan.png') }}" alt="Kanan" class="w-full h-full object-contain">
                        </button>
                    </div>

                    <button type="submit"
                        class="mt-4 rounded-full border-2 border-white bg-gradient-to-b from-sky-300 to-sky-500 px-10 py-1.5 text-white text-sm shadow-[0_6px_0_rgba(0,0,0,0.12)] hover:brightness-105 active:translate-y-[1px] active:shadow-[0_4px_0_rgba(0,0,0,0.12)]">
                        Simpan
                    </button>

                    <a href="{{ route('profile') }}" class="mt-3 text-xs text-slate-800 hover:underline">Batal</a>
                </form>

                <script>
                    (function () {
                        const avatarValue = document.getElementById('avatar_value');
                        const prevBtn = document.getElementById('avatar_prev');
                        const nextBtn = document.getElementById('avatar_next');
                        const cardCo = document.getElementById('card_co');
                        const cardCe = document.getElementById('card_ce');
                        const nameCo = document.getElementById('name_co');
                        const nameCe = document.getElementById('name_ce');

                        const applyCardState = (active) => {
                            const activeClasses = ['scale-100', 'opacity-100', 'grayscale-0'];
                            const inactiveClasses = ['scale-90', 'opacity-60', 'grayscale', 'brightness-90'];

                            cardCo.classList.remove(...activeClasses, ...inactiveClasses);
                            cardCe.classList.remove(...activeClasses, ...inactiveClasses);

                            if (active === 'co') {
                                cardCo.classList.add(...activeClasses);
                                cardCe.classList.add(...inactiveClasses);
                            } else {
                                cardCe.classList.add(...activeClasses);
                                cardCo.classList.add(...inactiveClasses);
                            }

                            const currentValue = nameCo.value;
                            nameCo.value = currentValue;
                            nameCe.value = currentValue;

                            if (active === 'co') {
                                nameCo.name = 'name';
                                nameCo.disabled = false;
                                nameCe.removeAttribute('name');
                                nameCe.disabled = true;
                            } else {
                                nameCe.name = 'name';
                                nameCe.disabled = false;
                                nameCo.removeAttribute('name');
                                nameCo.disabled = true;
                            }
                        };

                        const setAvatar = (value) => {
                            avatarValue.value = value;
                            applyCardState(value);
                        };

                        nameCo.addEventListener('input', () => {
                            if (avatarValue.value === 'co') nameCe.value = nameCo.value;
                        });

                        nameCe.addEventListener('input', () => {
                            if (avatarValue.value === 'ce') nameCo.value = nameCe.value;
                        });

                        prevBtn.addEventListener('click', () => {
                            setAvatar(avatarValue.value === 'ce' ? 'co' : 'ce');
                        });

                        nextBtn.addEventListener('click', () => {
                            setAvatar(avatarValue.value === 'ce' ? 'co' : 'ce');
                        });

                        applyCardState(avatarValue.value === 'ce' ? 'ce' : 'co');
                    })();
            </script>
            @endif
        </div>
        </div>
        </div>
    </body>
</html>
