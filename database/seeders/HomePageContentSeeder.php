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
        // Enhanced hero section content with compelling copywriting
        PageContent::setContent('home', 'hero', 'title', 'Dr. Fintan Ekochin');
        PageContent::setContent('home', 'hero', 'subtitle', 'Fellow WACP • Neurologist • Integrative Medicine Pioneer • Former Health Commissioner');
        PageContent::setContent('home', 'hero', 'paragraph_1', 'Experience world-class neurological care with Dr. Ekochin Fintan, a distinguished second-generation physician from the renowned EKOCHIN Family of Medical Practitioners. With multicultural expertise spanning Nigeria, Austria, India, and the USA, Dr. Fintan brings a unique global perspective to modern healthcare delivery.');
        PageContent::setContent('home', 'hero', 'paragraph_2', 'From his foundational education at the prestigious University of Nigeria College of Medicine to advanced training at leading medical institutions in New Delhi and North Carolina, Dr. Fintan has consistently pursued excellence in neurological care and integrative medicine.');
        PageContent::setContent('home', 'hero', 'paragraph_3', 'As Head of Neurology at ESUT Teaching Hospital and Senior Lecturer at Godfrey Okoye University, Dr. Fintan combines cutting-edge clinical practice with academic leadership. His tenure as Enugu State Commissioner for Health (2017-2019) demonstrates his commitment to advancing public health initiatives.');
        PageContent::setContent('home', 'hero', 'paragraph_4', 'Dr. Fintan\'s innovative approach integrates orthodox medicine with complementary therapies, offering patients comprehensive care that addresses both symptoms and underlying causes. His Fellowship of the West African College of Physicians (WACP) since 2016 reflects his dedication to maintaining the highest standards of medical practice.');
        
        // Enhanced philosophy section content
        PageContent::setContent('home', 'philosophy', 'title', 'Experience Transformative Healthcare Through Virtual Consultations');
        PageContent::setContent('home', 'philosophy', 'quote', 'My medical practice represents a revolutionary synthesis of Orthodox and Alternative medicine, seamlessly blending Complementary, Functional, Orthomolecular, and Lifestyle Medicine approaches. This innovative methodology prioritizes natural healing and prevention, often achieving remarkable results without pharmaceutical dependency. This pharmacologically minimalist philosophy not only promotes optimal health outcomes but also enables seamless international patient care, transcending geographical boundaries to deliver personalized medical excellence.');
        PageContent::setContent('home', 'philosophy', 'author', '— Dr. Fintan Ekochin, Fellow WACP');
    }
}
