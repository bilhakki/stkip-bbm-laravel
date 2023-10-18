@php
    $navbars = [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard'),
            'active' => request()->routeIs('dashboard'),
            'icon' => 'heroicon-m-squares-2x2',
        ],
    ];

    if (in_array(auth()->user()->role, ['admin', UserRole::ACADEMIC_UNIVERSITY])) {
        // $navbars[] = [
        //     'label' => 'Struktur Universitas',
        //     'active' => request()->routeIs(['faculty.*', 'major.*']),
        //     'icon' => 'heroicon-m-squares-2x2',
        //     'child' => [
        //         [
        //             'label' => 'Fakultas',
        //             'url' => route('faculty.index'),
        //             'active' => request()->routeIs('faculty.index'),
        //         ],
        //         [
        //             'label' => 'Jurusan',
        //             'url' => route('major.index'),
        //             'active' => request()->routeIs('major.index'),
        //         ],
        //     ],
        // ];

        $navbars[] = [
            'label' => 'Dosen',
            'url' => route('lecturer.index'),
            'active' => request()->routeIs('lecturer.*'),
            'icon' => 'heroicon-m-squares-2x2',
        ];
    }

    $navbars[] = [
        'label' => 'Mahasiswa',
        'active' => request()->routeIs(['student.*', 'student-attendance.index', 'student-grade.index']),
        'icon' => 'heroicon-m-squares-2x2',
        'child' => [
            [
                'label' => 'Daftar Mahasiswa',
                'url' => route('student.index'),
                'active' => request()->routeIs('student.index'),
            ],
            [
                'label' => 'Absensi Mahasiswa',
                'url' => route('student-attendance.index'),
                'active' => request()->routeIs('student-attendance.index'),
            ],
            [
                'label' => 'Nilai Mahasiswa',
                'url' => route('student-grade.index'),
                'active' => request()->routeIs('student-grade.index'),
            ],
        ],
    ];

    $navbars[] = [
        'label' => 'Akademik',
        'active' => request()->routeIs(['season.index', 'room.index', 'course.index', 'classroom.index', 'tuition-payment.index']),
        'icon' => 'heroicon-m-squares-2x2',
        'child' => [],
    ];


    $navbars[count($navbars) - 1]['child'][] = [
        'label' => 'Semester',
        'url' => route('season.index'),
        'active' => request()->routeIs('season.index'),
    ];

    $navbars[count($navbars) - 1]['child'][] = [
        'label' => 'Ruang Kelas',
        'url' => route('room.index'),
        'active' => request()->routeIs('room.index'),
    ];
    $navbars[count($navbars) - 1]['child'][] = [
        'label' => 'Mata Kuliah',
        'url' => route('course.index'),
        'active' => request()->routeIs(['course.index']),
    ];
    $navbars[count($navbars) - 1]['child'][] = [
        'label' => 'Kelas',
        'url' => route('classroom.index'),
        'active' => request()->routeIs(['classroom.index']),
    ];
    $navbars[count($navbars) - 1]['child'][] = [
        'label' => 'Pembayaran SPP',
        'url' => route('tuition-payment.index'),
        'active' => request()->routeIs(['tuition-payment.index']),
    ];
@endphp
<aside
    class="sidebar fixed left-0 top-0 z-40 h-screen w-64 bg-white pt-20 transition-transform dark:bg-background-925 md:translate-x-0 md:bg-transparent"
    id="logo-sidebar"
    :class="sidebarShow ? 'translate-x-0' : '-translate-x-full'"
>
    <div class="sidebar-content">
        <ul class="sidebar-menu">
            @foreach ($navbars as $navbar)
                @if (isset($navbar['child']))
                    <li x-data="{ showDropdown: @json($navbar['active']) }">
                        <button
                            class="sidebar-link {{ $navbar['active'] ? 'active' : 'inactive' }}"
                            type="button"
                            x-on:click="showDropdown = !showDropdown"
                        >
                            {{-- <x-icon
                                name="{{ $navbar['icon'] }}"
                                class="icon"
                            /> --}}
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
                            class="sidebar-link {{ $navbar['active'] ? 'active' : 'inactive' }}"
                            href="{{ $navbar['url'] }}"
                        >
                            {{-- <x-icon
                                name="{{ $navbar['icon'] }}"
                                class="icon"
                            /> --}}
                            <span class="label">{{ $navbar['label'] }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</aside>
