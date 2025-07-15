<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;

class AboutPageContentSeeder extends Seeder
{
    /**
     * Seed the about page dynamic content.
     */
    public function run(): void
    {
        // Intro text
        PageContent::setContent('about', 'about_intro', 'text', '<p>Dr. Ekochin Fintan is one in the now two generations of the EKOCHIN Family of Doctors. He largely grew up in Nigeria with some years of childhood spent in Austria, where he added German to his Igbo and English language proficiency.</p><p>After completing Primary and Secondary schools in Nigeria he lived in Austria where he started Medical School in Vienna after studying Medical Latin and also completing a diploma in photographic equipment sales. On losing one of his Grandparents he returned and completed Medical School in Nigeria.</p><p>Postgraduate years have been spent working initially with the Human Stem Cell Transplantation project for Africa, the Parklane Specialist Hospital before going for residency training in Internal Medicine at the University of Nigeria Teaching Hospital with Rotations in India at the Medanta Medicity Hospital and BLK both in New Delhi (2011).</p><p>On completion of specialist training he went on to do a sub specialization in Neurology and has experienced Neurology practice at the NOVANT managed Forsyth Medical Center, Winston Salem, USA (North Carolina) 2015/2016.</p><p>He is a Fellow of the West African College of Physicians (since 2016) and is currently appointed as the Head of Neurology at the ESUT Teaching Hospital Enugu as well as Senior Lecturer for Neurophysiology at the Godfrey Okoye University College of Medicine. He served Enugu State as the Commissioner for Health between 2017 and 2019.</p><p>He also offers Consultancy services at the Regions Hospital Enugu in affiliation with Regions Neurosciences, Owerri, and is a board member of the FIT Healthcare Limited.</p><p>He is married to Dr. Cynthia and has three children.</p>', 'rich_text');

        // Qualifications from PWA AboutSection.tsx
        $qualifications = [
            "Fellow of the West African College of Physicians",
            "Head of Neurology at ESUT Teaching Hospital Enugu",
            "Senior Lecturer for Neurophysiology at Godfrey Okoye University",
            "Former Commissioner for Health, Enugu State (2017-2019)",
            "Experienced in Neurology practice in Nigeria, India and USA"
        ];
        PageContent::setContent('about', 'qualifications', 'items', json_encode($qualifications), 'json');

        // Education items as JSON
        $education = [
            ['title' => 'Medical School, Vienna & Nigeria', 'description' => 'Completed medical education in Austria and Nigeria'],
            ['title' => 'Residency Training in Internal Medicine', 'description' => 'University of Nigeria Teaching Hospital with rotations in India'],
            ['title' => 'Sub-specialization in Neurology', 'description' => 'Advanced training in neurological disorders'],
            ['title' => 'Fellowship WACP', 'description' => 'Fellow of the West African College of Physicians (since 2016)'],
        ];
        PageContent::setContent('about', 'education', 'items', json_encode($education), 'json');

        // Experience items as JSON
        $experience = [
            ['title' => 'Head of Neurology, ESUT Teaching Hospital Enugu', 'description' => 'Leading neurological care and treatment'],
            ['title' => 'Senior Lecturer, Godfrey Okoye University', 'description' => 'Teaching Neurophysiology at College of Medicine'],
            ['title' => 'Former Commissioner for Health, Enugu State', 'description' => 'Served from 2017-2019, leading public health initiatives'],
            ['title' => 'Neurology Practice Experience', 'description' => 'Practiced at Forsyth Medical Center, Winston Salem, USA (2015/2016)'],
            ['title' => 'Consultant, Regions Hospital Enugu', 'description' => 'Providing specialized neurological consultancy services'],
        ];
        PageContent::setContent('about', 'experience', 'items', json_encode($experience), 'json');

        // Specialties items as JSON
        $specialties = [
            'Fellow WACP',
            'Neurologist',
            'Integrative Medicine Specialist',
            'Lifestyle Medicine',
            'Former Health Commissioner',
            'Complementary Medicine',
            'Functional Medicine',
            'Orthomolecular Medicine',
        ];
        PageContent::setContent('about', 'specialties', 'items', json_encode($specialties), 'json');
    }
}