<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\CalculatorSetting;
use App\Models\City;
use App\Models\FooterSetting;
use App\Models\HomepageSection;
use App\Models\NavigationItem;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(['email' => 'admin@navurja.test'], [
            'name' => 'Navurja Admin',
            'password' => Hash::make('password'),
        ]);

        foreach ([
            'site_name' => 'Navurja Renewable Energy Solutions',
            'tagline' => 'Powering a Sustainable Tomorrow',
            'primary_color' => '#0c6b3f',
            'secondary_color' => '#71c55d',
        ] as $key => $value) {
            Setting::putValue($key, $value);
        }

        FooterSetting::updateOrCreate(['id' => 1], [
            'company_name' => 'Navurja',
            'email' => 'info@navurja.com',
            'phone' => '+91 9876543210',
            'address' => 'New Delhi, India',
            'copyright_text' => 'Copyright '.date('Y').' Navurja. All rights reserved.',
        ]);

        \App\Models\Location::updateOrCreate(['id' => 1], [
            'office_name' => 'Navurja Head Office',
            'address' => 'New Delhi, India',
            'city' => 'New Delhi',
            'state' => 'Delhi',
            'country' => 'India',
            'pincode' => '110001',
            'phone' => '+91 9876543210',
            'alt_phone' => '+91 9876543211',
            'email' => 'info@navurja.com',
            'map_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3502.135688537682!2d77.2183204!3d28.6256847!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd34208a05c3%3A0xcf8b88f1abeb2145!2sConnaught%20Place%2C%20New%20Delhi%2C%20Delhi!5e0!3m2!1sen!2sin!4v1620000000000!5m2!1sen!2sin',
            'latitude' => '28.6256847',
            'longitude' => '77.2183204',
            'working_hours' => 'Mon - Sat: 9:00 AM - 6:00 PM'
        ]);

        foreach ([
            'cookie_consent_enabled' => '1',
            'cookie_popup_title' => 'We Value Your Privacy',
            'cookie_popup_content' => 'This website uses cookies to ensure you get the best experience.',
            'cookie_accept_text' => 'Accept',
            'cookie_reject_text' => 'Decline',
            'cookie_consent_expiry' => '30',
        ] as $key => $value) {
            Setting::putValue($key, $value);
        }

        foreach ([
            ['Privacy Policy', 'privacy-policy', '<p>This is the Privacy Policy page. Here you can describe how you collect, use, and protect user data.</p>'],
            ['Terms & Conditions', 'terms-and-conditions', '<p>This is the Terms & Conditions page. Here you can outline the rules and guidelines for using your website.</p>'],
            ['Cookie Policy', 'cookie-policy', '<p>This is the Cookie Policy page. Here you can describe how cookies are used on this site.</p>'],
            ['DMCA Policy', 'dmca-policy', '<p>This is the DMCA Policy page. Here you can outline the policy regarding copyright infringement claims.</p>'],
        ] as [$title, $slug, $content]) {
            \App\Models\Page::updateOrCreate(['slug' => $slug], [
                'title' => $title,
                'content' => $content,
                'is_published' => true,
            ]);
        }

        foreach ([['Home','#home',1],['About','#about',2],['Services','#services',3],['Projects','#projects',4],['Blog','/blog',5],['Calculator','/calculator',6],['Contact','#contact',7]] as [$label,$url,$order]) {
            NavigationItem::updateOrCreate(['label' => $label], ['url' => $url, 'sort_order' => $order, 'is_active' => true]);
        }

        HomepageSection::updateOrCreate(['key' => 'hero'], ['title' => 'Renewable energy systems built for modern India.', 'subtitle' => 'Powering a Sustainable Tomorrow', 'content' => 'Premium clean energy solutions for homes, businesses, and communities.']);
        HomepageSection::updateOrCreate(['key' => 'about'], ['title' => 'Clean technologies with practical engineering.', 'content' => 'Navurja Renewable Energy Solutions helps clients adopt renewable energy, sustainability practices, solar technologies, efficient power systems, and long-term energy savings strategies.']);
        HomepageSection::updateOrCreate(['key' => 'why'], ['title' => 'Reliable renewable energy guidance from planning to performance.', 'content' => 'We combine thoughtful design, transparent savings estimates, and responsive support.']);

        foreach ([
            ['Solar Panel Installation','Professional rooftop and commercial solar panel installation for dependable clean power.','☀',1],
            ['Renewable Energy Consulting','Feasibility studies, ROI planning, and sustainability roadmaps for modern properties.','◇',2],
            ['Sustainable Power Systems','Integrated renewable technologies, backup planning, and resilient power architecture.','⚡',3],
            ['Energy Efficiency Solutions','Audits and upgrades that reduce waste before and after renewable installation.','✓',4],
        ] as [$title,$description,$icon,$order]) {
            Service::updateOrCreate(['title' => $title], compact('description','icon') + ['sort_order' => $order, 'is_active' => true]);
        }

        foreach ([
            ['Residential Clean Energy Upgrade','A modern home renewable energy project focused on bill reduction and long-term sustainability.'],
            ['Commercial Sustainable Power System','A clean power design for a growing business seeking efficient, resilient operations.'],
            ['Institutional Energy Efficiency Plan','A phased renewable technology and efficiency roadmap for a community facility.'],
        ] as [$title,$description]) {
            Project::updateOrCreate(['title' => $title], ['description' => $description, 'is_active' => true]);
        }

        $category = BlogCategory::updateOrCreate(['slug' => 'renewable-energy'], ['name' => 'Renewable Energy']);
        Blog::updateOrCreate(['slug' => 'benefits-of-renewable-energy'], [
            'blog_category_id' => $category->id,
            'user_id' => $admin->id,
            'title' => 'Benefits of Renewable Energy for Modern Homes',
            'content' => '<h2>Why renewable energy matters</h2><p>Renewable energy helps modern homes lower monthly expenses, reduce carbon impact, and gain better control over future energy costs.</p><ul><li>Lower electricity bills</li><li>Cleaner everyday living</li><li>Improved property value</li><li>Long-term savings potential</li></ul><p>With careful planning, clean energy technologies can be practical, beautiful, and dependable.</p>',
            'meta_title' => 'Benefits of Renewable Energy for Modern Homes',
            'meta_description' => 'Learn how renewable energy supports savings, sustainability, and resilient homes.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        CalculatorSetting::updateOrCreate(['id' => 1], ['cost_per_kw' => 55000, 'monthly_savings_rate' => 0.82, 'co2_per_kw_year' => 1.25]);
        foreach ([['New Delhi',1.05],['Mumbai',.96],['Bengaluru',1.02],['Jaipur',1.16],['Chennai',1.08],['Hyderabad',1.1]] as [$name,$sun_factor]) {
            City::updateOrCreate(['name' => $name], compact('sun_factor'));
        }
    }
}
