<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use App\Models\Major;
use App\Models\Faculty;
use Illuminate\Support\Facades\DB;

class MajorSeeder extends Seeder
{
    public function run()
    {
        $facultyOfEngineering = [
            'faculty' => 'Faculty of Engineering',
            'majors' => [
                [
                    'name' => 'Computer Science',
                    'courses' => [
                        ['name' => 'Introduction to Programming', 'code' => 'CS101'],
                        ['name' => 'Data Structures', 'code' => 'CS201'],
                        ['name' => 'Algorithm Design', 'code' => 'CS301'],
                        ['name' => 'Database Management', 'code' => 'CS401'],
                        ['name' => 'Web Development', 'code' => 'CS501'],
                    ],
                ],
                [
                    'name' => 'Electrical Engineering',
                    'courses' => [
                        ['name' => 'Electric Circuits', 'code' => 'EE101'],
                        ['name' => 'Digital Electronics', 'code' => 'EE201'],
                        ['name' => 'Control Systems', 'code' => 'EE301'],
                        ['name' => 'Power Systems', 'code' => 'EE401'],
                        ['name' => 'Renewable Energy', 'code' => 'EE501'],
                    ],
                ],
                [
                    'name' => 'Mechanical Engineering',
                    'courses' => [
                        ['name' => 'Thermodynamics', 'code' => 'ME101'],
                        ['name' => 'Fluid Mechanics', 'code' => 'ME201'],
                        ['name' => 'Mechanics of Materials', 'code' => 'ME301'],
                        ['name' => 'Machine Design', 'code' => 'ME401'],
                        ['name' => 'Automotive Engineering', 'code' => 'ME501'],
                    ],
                ],
                [
                    'name' => 'Civil Engineering',
                    'courses' => [
                        ['name' => 'Structural Analysis', 'code' => 'CE101'],
                        ['name' => 'Geotechnical Engineering', 'code' => 'CE201'],
                        ['name' => 'Transportation Engineering', 'code' => 'CE301'],
                        ['name' => 'Environmental Engineering', 'code' => 'CE401'],
                        ['name' => 'Construction Management', 'code' => 'CE501'],
                    ],
                ],
                [
                    'name' => 'Chemical Engineering',
                    'courses' => [
                        ['name' => 'Chemical Process Principles', 'code' => 'CHE101'],
                        ['name' => 'Mass Transfer', 'code' => 'CHE201'],
                        ['name' => 'Reaction Engineering', 'code' => 'CHE301'],
                        ['name' => 'Process Control', 'code' => 'CHE401'],
                        ['name' => 'Petroleum Refining', 'code' => 'CHE501'],
                    ],
                ],
                [
                    'name' => 'Aerospace Engineering',
                    'courses' => [
                        ['name' => 'Aerodynamics', 'code' => 'AE101'],
                        ['name' => 'Aircraft Structures', 'code' => 'AE201'],
                        ['name' => 'Propulsion Systems', 'code' => 'AE301'],
                        ['name' => 'Flight Dynamics', 'code' => 'AE401'],
                        ['name' => 'Spacecraft Design', 'code' => 'AE501'],
                    ],
                ]
            ]
        ];

        $facultyOfScience = [
            'faculty' => 'Faculty of Science',
            'majors' => [
                [
                    'name' => 'Physics',
                    'courses' => [
                        ['name' => 'Classical Mechanics', 'code' => 'PH101'],
                        ['name' => 'Electromagnetism', 'code' => 'PH201'],
                        ['name' => 'Quantum Mechanics', 'code' => 'PH301'],
                        ['name' => 'Thermodynamics', 'code' => 'PH401'],
                        ['name' => 'Astrophysics', 'code' => 'PH501'],
                    ],
                ],
                [
                    'name' => 'Chemistry',
                    'courses' => [
                        ['name' => 'General Chemistry', 'code' => 'CH101'],
                        ['name' => 'Organic Chemistry', 'code' => 'CH201'],
                        ['name' => 'Physical Chemistry', 'code' => 'CH301'],
                        ['name' => 'Analytical Chemistry', 'code' => 'CH401'],
                        ['name' => 'Inorganic Chemistry', 'code' => 'CH501'],
                    ],
                ],
                [
                    'name' => 'Biology',
                    'courses' => [
                        ['name' => 'Cell Biology', 'code' => 'BI101'],
                        ['name' => 'Genetics', 'code' => 'BI201'],
                        ['name' => 'Ecology', 'code' => 'BI301'],
                        ['name' => 'Anatomy', 'code' => 'BI401'],
                        ['name' => 'Evolutionary Biology', 'code' => 'BI501'],
                    ],
                ],
                [
                    'name' => 'Mathematics',
                    'courses' => [
                        ['name' => 'Calculus I', 'code' => 'MA101'],
                        ['name' => 'Calculus II', 'code' => 'MA201'],
                        ['name' => 'Linear Algebra', 'code' => 'MA301'],
                        ['name' => 'Discrete Mathematics', 'code' => 'MA401'],
                        ['name' => 'Probability and Statistics', 'code' => 'MA501'],
                    ],
                ],
                [
                    'name' => 'Computer Science',
                    'courses' => [
                        ['name' => 'Introduction to Programming', 'code' => 'CS101'],
                        ['name' => 'Data Structures', 'code' => 'CS201'],
                        ['name' => 'Algorithm Design', 'code' => 'CS301'],
                        ['name' => 'Database Management', 'code' => 'CS401'],
                        ['name' => 'Web Development', 'code' => 'CS501'],
                    ],
                ],
            ],
        ];

        $facultyOfBusiness = [
            'faculty' => 'Faculty of Business',
            'majors' => [
                [
                    'name' => 'Business Administration',
                    'courses' => [
                        ['name' => 'Principles of Marketing', 'code' => 'BA101'],
                        ['name' => 'Financial Accounting', 'code' => 'BA201'],
                        ['name' => 'Business Ethics', 'code' => 'BA301'],
                        ['name' => 'Strategic Management', 'code' => 'BA401'],
                        ['name' => 'Organizational Behavior', 'code' => 'BA501'],
                    ],
                ],
                [
                    'name' => 'Finance',
                    'courses' => [
                        ['name' => 'Financial Markets and Institutions', 'code' => 'FI101'],
                        ['name' => 'Investment Analysis', 'code' => 'FI201'],
                        ['name' => 'Corporate Finance', 'code' => 'FI301'],
                        ['name' => 'International Finance', 'code' => 'FI401'],
                        ['name' => 'Financial Risk Management', 'code' => 'FI501'],
                    ],
                ],
                [
                    'name' => 'International Business',
                    'courses' => [
                        ['name' => 'Global Marketing', 'code' => 'IB101'],
                        ['name' => 'International Trade', 'code' => 'IB201'],
                        ['name' => 'Cross-Cultural Management', 'code' => 'IB301'],
                        ['name' => 'International Business Law', 'code' => 'IB401'],
                        ['name' => 'Global Supply Chain Management', 'code' => 'IB501'],
                    ],
                ],
                [
                    'name' => 'Human Resource Management',
                    'courses' => [
                        ['name' => 'Human Resource Planning', 'code' => 'HR101'],
                        ['name' => 'Recruitment and Selection', 'code' => 'HR201'],
                        ['name' => 'Employee Training and Development', 'code' => 'HR301'],
                        ['name' => 'Labor Relations', 'code' => 'HR401'],
                        ['name' => 'Performance Management', 'code' => 'HR501'],
                    ],
                ],
                [
                    'name' => 'Entrepreneurship',
                    'courses' => [
                        ['name' => 'New Venture Creation', 'code' => 'EN101'],
                        ['name' => 'Entrepreneurial Finance', 'code' => 'EN201'],
                        ['name' => 'Innovation Management', 'code' => 'EN301'],
                        ['name' => 'Small Business Marketing', 'code' => 'EN401'],
                        ['name' => 'Social Entrepreneurship', 'code' => 'EN501'],
                    ],
                ],
            ],
        ];

        $facultyOfMedicine = [
            'faculty' => 'Faculty of Medicine',
            'majors' => [
                [
                    'name' => 'Medicine',
                    'courses' => [
                        ['name' => 'Anatomy', 'code' => 'MD101'],
                        ['name' => 'Physiology', 'code' => 'MD201'],
                        ['name' => 'Pathology', 'code' => 'MD301'],
                        ['name' => 'Pharmacology', 'code' => 'MD401'],
                        ['name' => 'Internal Medicine', 'code' => 'MD501'],
                    ],
                ],
                [
                    'name' => 'Nursing',
                    'courses' => [
                        ['name' => 'Health Assessment', 'code' => 'NS101'],
                        ['name' => 'Nursing Fundamentals', 'code' => 'NS201'],
                        ['name' => 'Medical-Surgical Nursing', 'code' => 'NS301'],
                        ['name' => 'Pediatric Nursing', 'code' => 'NS401'],
                        ['name' => 'Psychiatric Nursing', 'code' => 'NS501'],
                    ],
                ],
                [
                    'name' => 'Dentistry',
                    'courses' => [
                        ['name' => 'Oral Anatomy', 'code' => 'DT101'],
                        ['name' => 'Dental Materials', 'code' => 'DT201'],
                        ['name' => 'Operative Dentistry', 'code' => 'DT301'],
                        ['name' => 'Periodontology', 'code' => 'DT401'],
                        ['name' => 'Oral Surgery', 'code' => 'DT501'],
                    ],
                ],
                [
                    'name' => 'Pharmacy',
                    'courses' => [
                        ['name' => 'Pharmaceutical Chemistry', 'code' => 'PHM101'],
                        ['name' => 'Pharmacotherapy', 'code' => 'PHM201'],
                        ['name' => 'Pharmacokinetics', 'code' => 'PHM301'],
                        ['name' => 'Clinical Pharmacy', 'code' => 'PHM401'],
                        ['name' => 'Pharmacovigilance', 'code' => 'PHM501'],
                    ],
                ],
                [
                    'name' => 'Physiotherapy',
                    'courses' => [
                        ['name' => 'Musculoskeletal Physiotherapy', 'code' => 'PT101'],
                        ['name' => 'Neurological Physiotherapy', 'code' => 'PT201'],
                        ['name' => 'Cardiovascular Physiotherapy', 'code' => 'PT301'],
                        ['name' => 'Pediatric Physiotherapy', 'code' => 'PT401'],
                        ['name' => 'Geriatric Physiotherapy', 'code' => 'PT501'],
                    ],
                ],
            ],
        ];

        $facultyOfLaw = [
            'faculty' => 'Faculty of Law',
            'majors' => [
                [
                    'name' => 'Law',
                    'courses' => [
                        ['name' => 'Introduction to Law', 'code' => 'LW101'],
                        ['name' => 'Constitutional Law', 'code' => 'LW201'],
                        ['name' => 'Criminal Law', 'code' => 'LW301'],
                        ['name' => 'Contract Law', 'code' => 'LW401'],
                        ['name' => 'Environmental Law', 'code' => 'LW501'],
                    ],
                ],
                [
                    'name' => 'International Law',
                    'courses' => [
                        ['name' => 'Public International Law', 'code' => 'IL101'],
                        ['name' => 'Human Rights Law', 'code' => 'IL201'],
                        ['name' => 'International Criminal Law', 'code' => 'IL301'],
                        ['name' => 'International Trade Law', 'code' => 'IL401'],
                        ['name' => 'Diplomatic Law', 'code' => 'IL501'],
                    ],
                ],
                [
                    'name' => 'Business Law',
                    'courses' => [
                        ['name' => 'Corporate Law', 'code' => 'BL101'],
                        ['name' => 'Bankruptcy Law', 'code' => 'BL201'],
                        ['name' => 'Intellectual Property Law', 'code' => 'BL301'],
                        ['name' => 'Tax Law', 'code' => 'BL401'],
                        ['name' => 'Consumer Protection Law', 'code' => 'BL501'],
                    ],
                ],
                [
                    'name' => 'Family Law',
                    'courses' => [
                        ['name' => 'Marriage Law', 'code' => 'FL101'],
                        ['name' => 'Divorce Law', 'code' => 'FL201'],
                        ['name' => 'Child Custody Law', 'code' => 'FL301'],
                        ['name' => 'Adoption Law', 'code' => 'FL401'],
                        ['name' => 'Estate Planning Law', 'code' => 'FL501'],
                    ],
                ],
                [
                    'name' => 'Labor Law',
                    'courses' => [
                        ['name' => 'Employment Contracts', 'code' => 'LL101'],
                        ['name' => 'Labor Disputes', 'code' => 'LL201'],
                        ['name' => 'Workplace Safety Law', 'code' => 'LL301'],
                        ['name' => 'Labor Standards Law', 'code' => 'LL401'],
                        ['name' => 'Collective Bargaining Law', 'code' => 'LL501'],
                    ],
                ],
                [
                    'name' => 'Environmental Law',
                    'courses' => [
                        ['name' => 'Environmental Regulations', 'code' => 'EL101'],
                        ['name' => 'Climate Change Law', 'code' => 'EL201'],
                        ['name' => 'Wildlife Protection Law', 'code' => 'EL301'],
                        ['name' => 'Land Use Law', 'code' => 'EL401'],
                        ['name' => 'Water Law', 'code' => 'EL501'],
                    ],
                ],
            ],
        ];


        $facultyOfSocialSciences = [
            'faculty' => 'Faculty of Social Sciences',
            'majors' => [
                [
                    'name' => 'Sociology',
                    'courses' => [
                        ['name' => 'Introduction to Sociology', 'code' => 'SOC101'],
                        ['name' => 'Social Theory', 'code' => 'SOC201'],
                        ['name' => 'Cultural Sociology', 'code' => 'SOC301'],
                        ['name' => 'Social Research Methods', 'code' => 'SOC401'],
                        ['name' => 'Gender Studies', 'code' => 'SOC501'],
                    ],
                ],
                [
                    'name' => 'Political Science',
                    'courses' => [
                        ['name' => 'Introduction to Political Science', 'code' => 'POL101'],
                        ['name' => 'Comparative Politics', 'code' => 'POL201'],
                        ['name' => 'International Relations', 'code' => 'POL301'],
                        ['name' => 'Political Theory', 'code' => 'POL401'],
                        ['name' => 'Public Policy Analysis', 'code' => 'POL501'],
                    ],
                ],
                [
                    'name' => 'Economics',
                    'courses' => [
                        ['name' => 'Microeconomics', 'code' => 'ECO101'],
                        ['name' => 'Macroeconomics', 'code' => 'ECO201'],
                        ['name' => 'Development Economics', 'code' => 'ECO301'],
                        ['name' => 'International Economics', 'code' => 'ECO401'],
                        ['name' => 'Econometrics', 'code' => 'ECO501'],
                    ],
                ],
                [
                    'name' => 'Anthropology',
                    'courses' => [
                        ['name' => 'Cultural Anthropology', 'code' => 'ANT101'],
                        ['name' => 'Archaeology', 'code' => 'ANT201'],
                        ['name' => 'Biological Anthropology', 'code' => 'ANT301'],
                        ['name' => 'Linguistic Anthropology', 'code' => 'ANT401'],
                        ['name' => 'Applied Anthropology', 'code' => 'ANT501'],
                    ],
                ],
                [
                    'name' => 'Communication Studies',
                    'courses' => [
                        ['name' => 'Introduction to Communication', 'code' => 'COM101'],
                        ['name' => 'Media Studies', 'code' => 'COM201'],
                        ['name' => 'Interpersonal Communication', 'code' => 'COM301'],
                        ['name' => 'Intercultural Communication', 'code' => 'COM401'],
                        ['name' => 'Organizational Communication', 'code' => 'COM501'],
                    ],
                ],
            ],
        ];


        $facultyOfEducation = [
            'faculty' => 'Faculty of Education',
            'majors' => [
                [
                    'name' => 'Elementary Education',
                    'courses' => [
                        ['name' => 'Introduction to Elementary Education', 'code' => 'EDU101'],
                        ['name' => 'Childhood Development', 'code' => 'EDU201'],
                        ['name' => 'Teaching Strategies for Elementary Students', 'code' => 'EDU301'],
                        ['name' => 'Classroom Management', 'code' => 'EDU401'],
                        ['name' => 'Assessment in Elementary Education', 'code' => 'EDU501'],
                    ],
                ],
                [
                    'name' => 'Secondary Education',
                    'courses' => [
                        ['name' => 'Introduction to Secondary Education', 'code' => 'SEDU101'],
                        ['name' => 'Adolescent Development', 'code' => 'SEDU201'],
                        ['name' => 'Content Area Instruction', 'code' => 'SEDU301'],
                        ['name' => 'Inclusive Teaching Practices', 'code' => 'SEDU401'],
                        ['name' => 'Assessment in Secondary Education', 'code' => 'SEDU501'],
                    ],
                ],
                [
                    'name' => 'Special Education',
                    'courses' => [
                        ['name' => 'Introduction to Special Education', 'code' => 'SPED101'],
                        ['name' => 'Inclusive Education', 'code' => 'SPED201'],
                        ['name' => 'Behavior Management for Students with Disabilities', 'code' => 'SPED301'],
                        ['name' => 'Differentiated Instruction', 'code' => 'SPED401'],
                        ['name' => 'Assessment in Special Education', 'code' => 'SPED501'],
                    ],
                ],
                [
                    'name' => 'Educational Leadership',
                    'courses' => [
                        ['name' => 'Introduction to Educational Leadership', 'code' => 'LEAD101'],
                        ['name' => 'School Administration and Management', 'code' => 'LEAD201'],
                        ['name' => 'Educational Policy and Ethics', 'code' => 'LEAD301'],
                        ['name' => 'Instructional Leadership', 'code' => 'LEAD401'],
                        ['name' => 'Leading Change in Education', 'code' => 'LEAD501'],
                    ],
                ],
                [
                    'name' => 'Counselor Education',
                    'courses' => [
                        ['name' => 'Introduction to Counseling', 'code' => 'COUN101'],
                        ['name' => 'Theories of Counseling', 'code' => 'COUN201'],
                        ['name' => 'Group Counseling', 'code' => 'COUN301'],
                        ['name' => 'Career Counseling', 'code' => 'COUN401'],
                        ['name' => 'Multicultural Counseling', 'code' => 'COUN501'],
                    ],
                ],
                [
                    'name' => 'Physical Education',
                    'courses' => [
                        ['name' => 'Introduction to Physical Education', 'code' => 'PE101'],
                        ['name' => 'Kinesiology', 'code' => 'PE201'],
                        ['name' => 'Sports and Exercise Psychology', 'code' => 'PE301'],
                        ['name' => 'Teaching Methods in Physical Education', 'code' => 'PE401'],
                        ['name' => 'Health and Wellness Education', 'code' => 'PE501'],
                    ],
                ],
                [
                    'name' => 'Language Education',
                    'courses' => [
                        ['name' => 'Introduction to Language Education', 'code' => 'LANG101'],
                        ['name' => 'Second Language Acquisition', 'code' => 'LANG201'],
                        ['name' => 'Teaching English as a Second Language', 'code' => 'LANG301'],
                        ['name' => 'Curriculum Design for Language Education', 'code' => 'LANG401'],
                        ['name' => 'Assessment in Language Education', 'code' => 'LANG501'],
                    ],
                ],
            ],
        ];


        $facultyOfArts = [
            'faculty' => 'Faculty of Arts',
            'majors' => [
                [
                    'name' => 'English Literature',
                    'courses' => [
                        ['name' => 'Introduction to English Literature', 'code' => 'ENG101'],
                        ['name' => 'Shakespearean Literature', 'code' => 'ENG201'],
                        ['name' => 'Victorian Literature', 'code' => 'ENG301'],
                        ['name' => 'American Literature', 'code' => 'ENG401'],
                        ['name' => 'Contemporary Literature', 'code' => 'ENG501'],
                    ],
                ]
            ]
        ];

        $facultyOfCommunication = [
            'faculty' => 'Faculty of Communication',
            'majors' => [
                [
                    'name' => 'Mass Communication',
                    'courses' => [
                        ['name' => 'Introduction to Mass Communication', 'code' => 'COM101'],
                        ['name' => 'Media and Society', 'code' => 'COM201'],
                        ['name' => 'Journalism and News Writing', 'code' => 'COM301'],
                        ['name' => 'Advertising and Public Relations', 'code' => 'COM401'],
                        ['name' => 'Media Ethics', 'code' => 'COM501'],
                    ],
                ]
            ]
        ];

        $facultyOfEnvironmentalStudies = [
            'faculty' => 'Faculty of Environmental Studies',
            'majors' => [
                [
                    'name' => 'Environmental Science',
                    'courses' => [
                        ['name' => 'Introduction to Environmental Science', 'code' => 'ENV101'],
                        ['name' => 'Ecology and Conservation', 'code' => 'ENV201'],
                        ['name' => 'Environmental Policy and Law', 'code' => 'ENV301'],
                        ['name' => 'Sustainable Development', 'code' => 'ENV401'],
                        ['name' => 'Climate Change and Adaptation', 'code' => 'ENV501'],
                    ],
                ]
            ]
        ];

        $_faculties = [$facultyOfEngineering, $facultyOfScience, $facultyOfBusiness, $facultyOfMedicine, $facultyOfLaw, $facultyOfSocialSciences, $facultyOfEducation, $facultyOfArts, $facultyOfCommunication, $facultyOfEnvironmentalStudies];

        $faculties = Faculty::all();
        $faculties = collect(json_decode(json_encode($faculties->toArray())));
        $_majors = [];
        $_courses = [];
        try {
            DB::beginTransaction();

            foreach ($_faculties as $index_faculty => $_faculty) {
                $faculty = $faculties->where('name', $_faculty['faculty'])->first();
                foreach ($_faculty['majors'] as $index_major => $_major) {
                    $_majors[] = [
                        'name' => $_major['name'],
                        'faculty_id' => $faculty->id,
                    ];
                    foreach ($_major['courses'] as $index_courseData => $courseData) {
                        $_courses[] = [
                            'name' => $courseData['name'],
                            'major_id' => $index_major,
                            'faculty_id' => $faculty->id,
                            'code' => $courseData['code'],
                            'credits' => rand(2, 4), // Random credits between 2 to 4
                        ];
                    }
                }
            }

            DB::table('majors')->insert($_majors);
            $startID = DB::select('select last_insert_id() as id');
            $startID = $startID[0]->id;
            $lastID = $startID + count($_majors) - 1;
            $major_ids = range($startID, $lastID);

            foreach ($_courses as $key => $_course) {
                $_courses[$key]['major_id'] = $major_ids[$_course['major_id']];
            }

            foreach (array_chunk($_courses, 1000) as $key => $value) {
                DB::table('courses')->insert($value);
            }

            DB::commit();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }
    }
}
