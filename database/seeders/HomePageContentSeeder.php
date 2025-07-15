<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;

class HomePageContentSeeder extends Seeder
{
    /**
     * Seed the home page hero content.
     */
    public function run(): void
    {
        // Hero section content - correct information from the profile image
        PageContent::setContent('home', 'hero', 'title', 'Dr. Fintan Ekochin');
        PageContent::setContent('home', 'hero', 'subtitle', 'Fellow of the West African College of Physicians • Neurologist • Integrative Medicine Specialist');
        PageContent::setContent('home', 'hero', 'paragraph_1', 'Dr. Ekochin Fintan is one of two generations of the EKOCHIN Family of Doctors. He largely grew up in Nigeria with some years of childhood spent in Austria, where he added German to his Igbo and English language proficiency.');
        PageContent::setContent('home', 'hero', 'paragraph_2', 'After completing Primary and Secondary schools in Enugu and Nsukka, he earned an MBBS from the premier University of Nigeria, College of Medicine. Post graduation activities were first in the Paklose Specialist Hospital before going to do House training in Internal Medicine at the University Teaching Hospital both in New Delhi (2011).');
        PageContent::setContent('home', 'hero', 'paragraph_3', 'He later completed neurology residency in India and the USA, earning Fellowship of the West African College of Physicians. He currently serves as Head of Neurology at ESUT Teaching Hospital Enugu and Senior Lecturer for Neurophysiology at the Godfrey Okoye University College of Medicine.');
        PageContent::setContent('home', 'hero', 'paragraph_4', 'He served Enugu State as the Commissioner for Health between 2017 and 2019. He is a Fellow of the West African College of Physicians (since 2016) and is currently appointed as a Senior Lecturer for the ESUT Teaching Hospital Enugu as well as Senior Lecturer for Neurophysiology at the Godfrey Okoye University College of Medicine.');
        
        // Philosophy section content
        PageContent::setContent('home', 'philosophy', 'title', 'What to expect from a virtual consultation with Dr. Fintan');
        PageContent::setContent('home', 'philosophy', 'quote', 'Dr. Fintan\'s medical practice is an amalgamation of Orthodox and Alternative medicine, yielding a blend of Complementary, Functional, Orthomolecular as well as Lifestyle Medicine. This delivers a pharmacologically minimalist approach to healthcare. Most consultations end without a drug prescription, which makes for efficient cross border client care.');
        PageContent::setContent('home', 'philosophy', 'author', '— Dr. Fintan Ekochin');
    }
}