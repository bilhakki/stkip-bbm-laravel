@php
    $navbars = [
        [
            'label' => 'Kelas',
            'url' => false,
            'active' => false,
            'icon' => 'heroicon-m-square-3-stack-3d',
        ],
        [
            'label' => 'Tugas',
            'url' => false,
            'active' => false,
            'icon' => 'heroicon-s-document-plus',
        ],
        [
            'label' => 'Perwalian',
            'url' => false,
            'active' => false,
            'icon' => 'heroicon-s-user',
            'child' => [
                [
                    'label' => 'Mahasiswa',
                    'url' => false,
                    'active' => false,
                ],
                [
                    'label' => 'Pengajuan KRS',
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
                            class="sidebar-link {{ $navbar['active'] ? 'active' : 'inactive' }} !pl-3"
                            type="button"
                            x-on:click="showDropdown = !showDropdown"
                        >
                            <x-icon
                                class="icon"
                                name="{{ $navbar['icon'] }}"
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
                            class="sidebar-link {{ $navbar['active'] ? 'active' : 'inactive' }} !pl-3"
                            href="{{ $navbar['url'] }}"
                        >
                            <x-icon
                                class="icon"
                                name="{{ $navbar['icon'] }}"
                            />
                            <span class="label">{{ $navbar['label'] }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</aside>
