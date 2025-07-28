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
        // Comprehensive professional biography
        PageContent::setContent('about', 'about_intro', 'text', '<p>Dr. Ekochin Fintan represents the distinguished second generation of the renowned EKOCHIN Family of Medical Practitioners. His multicultural upbringing spans Nigeria and Austria, where he developed fluency in Igbo, English, and German languages, providing him with a unique global perspective on healthcare delivery.</p><p>Following his foundational education in Nigeria, Dr. Fintan pursued advanced medical studies in Vienna, Austria, where he mastered Medical Latin and earned specialized training in medical photography. After a family bereavement, he returned to Nigeria to complete his medical degree, demonstrating his deep commitment to both family values and academic excellence.</p><p>His postgraduate journey began with groundbreaking work on the Human Stem Cell Transplantation project for Africa at Parklane Specialist Hospital. He then completed his residency training in Internal Medicine at the University of Nigeria Teaching Hospital, with prestigious rotations at Medanta Medicity Hospital and BLK Hospital in New Delhi, India (2011).</p><p>Dr. Fintan further specialized in Neurology and gained invaluable international experience practicing at the NOVANT-managed Forsyth Medical Center in Winston Salem, North Carolina, USA (2015-2016). This exposure to advanced American healthcare systems has enriched his clinical expertise and treatment methodologies.</p><p>Currently serving as Head of Neurology at ESUT Teaching Hospital Enugu and Senior Lecturer for Neurophysiology at Godfrey Okoye University College of Medicine, Dr. Fintan has also distinguished himself in public service as the former Commissioner for Health of Enugu State (2017-2019). He maintains active consultancy roles at Regions Hospital Enugu and serves as a board member of FIT Healthcare Limited.</p><p>Dr. Fintan is happily married to Dr. Cynthia and is a devoted father to three children, balancing his professional excellence with strong family commitments.</p>', 'rich_text');

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
