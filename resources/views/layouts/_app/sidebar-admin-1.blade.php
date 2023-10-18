@php
    $navbars = [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard'),
            'active' => request()->routeIs('dashboard'),
            'icon' => 'heroicon-m-squares-2x2',
        ],
        [
            'label' => 'Mahasiswa',
            'active' => request()->routeIs('student.*'),
            'icon' => 'heroicon-m-squares-2x2',
            'child' => [
                [
                    'label' => 'Daftar Mahasiswa',
                    'url' => route('student.index'),
                    'active' => request()->routeIs('student.index'),
                ],
                [
                    'label' => 'Absensi Mahasiswa',
                    'url' => route('student.create'),
                    'active' => request()->routeIs('student.create'),
                ],
                [
                    'label' => 'Nilai Mahasiswa',
                    'url' => route('student.create'),
                    'active' => request()->routeIs('student.create'),
                ],
            ],
        ],
    ];
@endphp
<aside
    id="logo-sidebar"
    class="fixed left-0 top-0 z-40 h-screen w-64 -translate-x-full border-r border-background-200 bg-white pt-20 transition-transform dark:border-background-700 dark:bg-background-925 sm:translate-x-0"
    aria-label="Sidebar"
>
    <div class="h-full overflow-y-auto px-3 pb-4">
        <ul class="space-y-2 font-medium">
            @foreach ($navbars as $navbar)
                @if (isset($navbar['child']))
                    @php
                        $elid = Str::random(6);
                    @endphp
                    <li>
                        <button
                            type="button"
                            class="{{ $navbar['active'] ? 'bg-primary-600 dark:bg-primary-900  hover:bg-primary-800 dark:hover:bg-primary-950 text-white' : 'opacity-50 text-background-900 hover:bg-background-100 dark:text-white dark:hover:bg-background-700' }} group flex w-full items-center rounded-lg p-2 px-3.5 text-base duration-300"
                            aria-controls="dropdown-{{ $elid }}"
                            data-collapse-toggle="dropdown-{{ $elid }}"
                        >
                            <x-icon
                                name="{{ $navbar['icon'] }}"
                                class="h-5 w-5"
                            />
                            <span class="ml-3 flex-1 whitespace-nowrap text-left">
                                {{ $navbar['label'] }}
                            </span>
                            <svg
                                class="h-3 w-3"
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
                            id="dropdown-{{ $elid }}"
                            class="{{ $navbar['active'] ? 'block' : 'hidden' }} space-y-2 py-2"
                        >
                            @foreach ($navbar['child'] as $child)
                                <li class="pl-6">
                                    <a
                                        href="{{ $child['url'] }}"
                                        class="{{ $child['active'] ? 'bg-primary-600 dark:bg-primary-900  hover:bg-primary-800 dark:hover:bg-primary-950 text-white' : 'opacity-50 text-background-900 hover:bg-background-100 dark:text-white dark:hover:bg-background-700' }} group flex w-full items-center rounded-lg p-2 px-4"
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
                            href="{{ $navbar['url'] }}"
                            class="{{ $navbar['active'] ? 'bg-primary-600 dark:bg-primary-900  hover:bg-primary-800 dark:hover:bg-primary-950 text-white' : 'opacity-50 hover:bg-background-100 dark:hover:bg-background-700' }} group flex items-center rounded-lg p-2 px-3.5 duration-300"
                        >
                            <x-icon
                                name="{{ $navbar['icon'] }}"
                                class="h-5 w-5"
                            />
                            <span class="ml-3">{{ $navbar['label'] }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</aside>
