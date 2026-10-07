<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        Profile::updateOrCreate(
            ['full_name' => 'Javeed Khan J'],
            [
                'headline' => 'Full Stack Developer | Laravel & PHP | Next.js | Node.js',
                'bio' => "Full Stack Developer with production experience architecting and shipping live web and mobile applications, including an end-to-end ERP system and a cross-platform mobile app published on the Google Play Store. Strong in REST API design, Role-Based Access Control, and real-time systems (WebSockets/Socket.io), with ownership spanning database schema through deployment.\n\nCertified Full Stack Developer (MERN) — GUVI, an IIT Madras incubation cell company.",
                'location' => 'Tamil Nadu, India',
                'email' => 'javeedkhanjohnbasha8@gmail.com',
                'phone' => '+91 8825885425',
                'resume' => 'uploads/portfolio/resume/Javeed_Khan_Resume.pdf',
                'linkedin_url' => 'https://www.linkedin.com/in/javeedkhan-j-706875235',
            ]
        );

        Skill::query()->delete();
        $skills = [
            ['name' => 'Laravel', 'category' => 'Backend', 'proficiency' => 95],
            ['name' => 'PHP', 'category' => 'Backend', 'proficiency' => 92],
            ['name' => 'Node.js', 'category' => 'Backend', 'proficiency' => 85],
            ['name' => 'Express.js', 'category' => 'Backend', 'proficiency' => 80],
            ['name' => 'REST API Design', 'category' => 'Backend', 'proficiency' => 90],

            ['name' => 'Next.js', 'category' => 'Frontend', 'proficiency' => 85],
            ['name' => 'React.js', 'category' => 'Frontend', 'proficiency' => 88],
            ['name' => 'React Native', 'category' => 'Frontend', 'proficiency' => 82],
            ['name' => 'Tailwind CSS', 'category' => 'Frontend', 'proficiency' => 88],
            ['name' => 'Bootstrap', 'category' => 'Frontend', 'proficiency' => 80],
            ['name' => 'Alpine.js', 'category' => 'Frontend', 'proficiency' => 75],

            ['name' => 'JavaScript (ES6+)', 'category' => 'Languages', 'proficiency' => 90],
            ['name' => 'TypeScript', 'category' => 'Languages', 'proficiency' => 85],
            ['name' => 'PHP', 'category' => 'Languages', 'proficiency' => 92],
            ['name' => 'Python', 'category' => 'Languages', 'proficiency' => 75],

            ['name' => 'MySQL', 'category' => 'Databases', 'proficiency' => 90],
            ['name' => 'MongoDB', 'category' => 'Databases', 'proficiency' => 85],
            ['name' => 'Database Schema Design', 'category' => 'Databases', 'proficiency' => 88],

            ['name' => 'Role-Based Access Control (RBAC)', 'category' => 'Authentication & Security', 'proficiency' => 88],

            ['name' => 'cPanel', 'category' => 'Cloud', 'proficiency' => 80],
            ['name' => 'Apache', 'category' => 'Cloud', 'proficiency' => 75],
            ['name' => 'CI/CD (GitHub Actions)', 'category' => 'Cloud', 'proficiency' => 78],

            ['name' => 'Git', 'category' => 'Tools', 'proficiency' => 90],
            ['name' => 'GitHub', 'category' => 'Tools', 'proficiency' => 90],
            ['name' => 'Postman', 'category' => 'Tools', 'proficiency' => 85],
        ];
        foreach ($skills as $index => $skill) {
            Skill::create($skill + ['sort_order' => $index + 1]);
        }

        Experience::query()->delete();
        Experience::create([
            'job_title' => 'Full Stack Developer',
            'company' => 'Mescope Solution',
            'start_date' => '2025-05-01',
            'is_current' => true,
            'description' => implode("\n", [
                'Build and maintain scalable web and mobile applications (Laravel, PHP, MySQL, Next.js, React Native) supporting complex business workflows in live production environments.',
                'Design and ship REST API-driven, real-time interfaces that replace page-reload workflows with live data updates, directly improving day-to-day usability for end users.',
                'Architect Role-Based Access Control (RBAC) systems enforcing secure, permission-scoped data access, and own full-stack features end-to-end — from database schema to UI to deployment.',
            ]),
            'sort_order' => 1,
        ]);
        Experience::create([
            'job_title' => 'Application Center Executive',
            'company' => 'Hettich India Pvt Ltd',
            'start_date' => '2023-02-01',
            'end_date' => '2024-09-01',
            'is_current' => false,
            'description' => implode("\n", [
                'Advised clients on technical product specifications in a high-traffic showroom, translating technical detail into purchase decisions through consultative selling.',
                'Conducted on-site technical assessments to match hardware specifications to project requirements.',
                'Compiled monthly sales and performance analytics to support senior management’s data-driven decisions.',
            ]),
            'sort_order' => 2,
        ]);

        Education::query()->delete();
        Education::create([
            'degree' => 'B.E. Mechanical Engineering',
            'institution' => 'Dhirajlal Gandhi College of Technology',
            'location' => 'Salem',
            'start_year' => '2019',
            'end_year' => '2023',
            'description' => 'CGPA: 7.9',
            'sort_order' => 1,
        ]);
        Education::create([
            'degree' => 'Higher Secondary Certificate (HSC)',
            'institution' => 'Sri Sarada Balamandir Boys Mat. Hr. Sec. School',
            'start_year' => '2017',
            'end_year' => '2019',
            'description' => 'Score: 62%',
            'sort_order' => 2,
        ]);

        Project::query()->delete();
        Project::create([
            'title' => 'ERP System — Manufacturing & Production Management',
            'summary' => 'Live end-to-end ERP for a battery manufacturer covering the full production lifecycle, from raw material through dispatch and returns.',
            'description' => implode("\n", [
                'Architected a live end-to-end ERP system for a battery manufacturer spanning the full production lifecycle: Raw Material, Bill of Materials, Work Order, Batch Manufacturing Record, Pre-Dispatch Inspection, Dispatch, and Returns.',
                'Built real-time inventory stock logs and adjustment mechanisms maintaining accurate, live stock availability across warehouse operations.',
                'Implemented non-conformance workflows (rework and dismantling) to handle production exceptions without disrupting the manufacturing pipeline.',
                'Delivered and maintained the system in a live production environment supporting daily operations with minimal downtime.',
            ]),
            'tech_stack' => 'Laravel, PHP, MySQL',
            'featured' => true,
            'sort_order' => 1,
        ]);
        Project::create([
            'title' => 'GivAsk — BNI Member Networking App',
            'summary' => 'Cross-platform app shipped to the Google Play Store so BNI Salem Region members can track business referrals during networking meetings.',
            'description' => implode("\n", [
                'Shipped a live cross-platform mobile app to the Google Play Store for BNI Salem Region members to track business referrals during networking meetings.',
                'Built the React Native frontend and a Laravel REST API backend handling authentication, member management, and business logic.',
                'Implemented secure, role-based member-only access, keeping the platform private to approved members.',
                'Designed the MySQL schema for meeting activities, member records, referrals, and networking statistics with real-time retrieval.',
            ]),
            'tech_stack' => 'React Native, Laravel, PHP, MySQL',
            'featured' => true,
            'sort_order' => 2,
        ]);
        Project::create([
            'title' => 'Task Management & Collaboration Platform',
            'summary' => 'Full-stack MERN application with a real-time Kanban board, embedded team chat and automated deadline reminders.',
            'description' => implode("\n", [
                'Architected a full-stack MERN application managing complex relational data between users, projects, and tasks.',
                'Built an interactive Kanban board (dnd-kit) with real-time task synchronization via Socket.io, embedded team chat, and automated deadline reminders (Node-cron, Nodemailer).',
                'Implemented RBAC with JWT and bcrypt for strict permission enforcement, and a Recharts-based dashboard visualizing KPIs, project velocity, and team capacity.',
            ]),
            'tech_stack' => 'MongoDB, Express.js, React.js, Node.js',
            'featured' => false,
            'sort_order' => 3,
        ]);
    }
}
