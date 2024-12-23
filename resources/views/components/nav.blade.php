<nav class="relative flex items-center justify-between w-full max-w-[1280px] mx-auto px-10 mt-10 mb-10">
    <a href="{{route('front.index')}}">
        <img src="{{asset('assets/images/logos/Logo.svg')}}" class="flex shrink-0" alt="logo">
    </a>
    <ul class="flex items-center gap-6 justify-end">
        <li>
            <a href="{{route('front.pricing')}}" class="leading-19 tracking-03 text-[#141414]">
                Pilihan paket
            </a>
        </li>
        <li>
            <a href="{{route('front.check_booking')}}" class="leading-19 tracking-0.5 text-white font-semibold rounded-[22px] py-3 px-6 bg-[#606DE5]">
                Check subscription saya
            </a>
        </li>
    </ul>
</nav>