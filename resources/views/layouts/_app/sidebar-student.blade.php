@php
    $navbars = [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard'),
            'active' => request()->routeIs('dashboard'),
            'icon' => 'heroicon-m-square-3-stack-3d',
        ],
        [
            'label' => 'Profile',
            'url' => false,
            'active' => false,
            'icon' => 'heroicon-s-user',
            'child' => [
                [
                    'label' => 'Biodata',
                    'url' => false,
                    'active' => false,
                ],
                [
                    'label' => 'Biaya Kuliah',
                    'url' => false,
                    'active' => false,
                ],
                [
                    'label' => 'History Slip SPP',
                    'url' => false,
                    'active' => false,
                ],
                [
                    'label' => 'Ubah Password',
                    'url' => false,
                    'active' => false,
                ],
            ],
        ],
        [
            'label' => 'KRS',
            'url' => false,
            'active' => false,
            'icon' => 'fas-book-open',
            'child' => [
                [
                    'label' => 'Isi KRS',
                    'url' => false,
                    'active' => false,
                ],
                [
                    'label' => 'Ubah KRS',
                    'url' => false,
                    'active' => false,
                ],
                [
                    'label' => 'Cetak KRS',
                    'url' => false,
                    'active' => false,
                ],
                [
                    'label' => 'KHS',
                    'url' => false,
                    'active' => false,
                ],
                [
                    'label' => 'Mata Kuliah',
                    'url' => false,
                    'active' => false,
                ],
            ],
        ],
        [
            'label' => 'Transkrip',
            'url' => false,
            'active' => false,
            'icon' => 'akar-file',
            'child' => [
                [
                    'label' => 'Sementara',
                    'url' => false,
                    'active' => false,
                ],
                [
                    'label' => 'History Nilai',
                    'url' => false,
                    'active' => false,
                ],
                [
                    'label' => 'Download Transkrip',
                    'url' => false,
                    'active' => false,
                ],
            ],
        ],
    ];
    
@endphp
<aside
    class="sidebar fixed left-0 top-0 z-40 h-screen w-64 bg-white pt-20 transition-transform dark:bg-background-925 sm:translate-x-0 md:bg-transparent"
    id="logo-sidebar"
    :class="sidebarShow ? 'translate-x-0' : '-translate-x-full'"
>
    <div class="sidebar-content">
        <ul class="sidebar-menu">
            @foreach ($navbars as $navbar)
                @if (isset($navbar['child']))
                    <li x-data="{ showDropdown: @json($navbar['active']) }">
                        <button
                            class="sidebar-link !pl-3 {{ $navbar['active'] ? 'active' : 'inactive' }}"
                            type="button"
                            x-on:click="showDropdown = !showDropdown"
                        >
                            <x-icon
                                name="{{ $navbar['icon'] }}"
                                class="icon"
                            />
                            <span class="label">{{ $navbar['label'] }}</span>
                            <svg
                                class="arrow"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 10 6"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m1 1 4 4 4-4"
                                />
                            </svg>
                        </button>
                        <ul
                            class="dropdown"
                            x-show="showDropdown"
                            x-cloak
                        > 
                            @foreach ($navbar['child'] as $child)
                                <li class="nested">
                                    <a
                                        class="sidebar-link {{ $child['active'] ? 'active' : 'inactive' }}"
                                        href="{{ $child['url'] }}"
                                    >
                                        {{ $child['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li>
                        <a
                            class="sidebar-link !pl-3 {{ $navbar['active'] ? 'active' : 'inactive' }}"
                            href="{{ $navbar['url'] }}"
                        >
                            <x-icon
                                name="{{ $navbar['icon'] }}"
                                class="icon"
                            />
                            <span class="label">{{ $navbar['label'] }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</aside>
