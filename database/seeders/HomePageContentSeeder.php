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
        
        // Enhanced philosophy section based on PDF content
        PageContent::setContent('home', 'philosophy', 'title', 'Experience Transformative Healthcare Through Virtual Consultations');
        PageContent::setContent('home', 'philosophy', 'quote', 'My medical practice represents a revolutionary synthesis of Orthodox and Alternative medicine, seamlessly blending Complementary, Functional, Orthomolecular, and Lifestyle Medicine approaches. This innovative methodology delivers a pharmacologically minimalist approach to healthcare, with most consultations achieving remarkable results without drug prescriptions. This philosophy not only promotes optimal health outcomes but also enables efficient cross-border patient care, overcoming traditional licensing limitations to deliver personalized medical excellence globally.');
        PageContent::setContent('home', 'philosophy', 'author', '— Dr. Fintan Ekochin, Fellow WACP');
        
        // Additional consultation information from PDF
        PageContent::setContent('home', 'consultation_intro', 'title', 'Seeking a Second Opinion or Natural Medical Solutions?');
        PageContent::setContent('home', 'consultation_intro', 'text', '<p>Whether you\'re seeking a second opinion for a medical condition, looking for effective and natural medical advice at affordable cost, or have been told your condition is "incurable" - you\'ve come to the right place.</p><p>Are you ready to explore going "medically offline" to find your health? Dr. Fintan\'s unique approach has helped countless patients achieve better outcomes through natural, integrative medicine.</p>');
        
        // Consultation process from PDF
        PageContent::setContent('home', 'consultation_process', 'title', 'Simple 4-Step Teleconsultation Process');
        $consultationSteps = [
            ['step' => '1', 'title' => 'Schedule Your Session', 'description' => 'Pick your preferred date and time, then submit a brief note about your medical challenges and expected solutions. This helps determine whether video or audio consultation is most appropriate.'],
            ['step' => '2', 'title' => 'Secure Payment', 'description' => 'Complete payment using any of our convenient payment options as displayed on the booking platform.'],
            ['step' => '3', 'title' => 'Receive Confirmation', 'description' => 'Get payment confirmation and receive your personalized teleconsultation link for the scheduled session.'],
            ['step' => '4', 'title' => 'Join Your Consultation', 'description' => 'Login for your consultation and share all relevant investigation results and medication information. Available via WhatsApp, Telegram, Google Meet, and Zoom.']
        ];
        PageContent::setContent('home', 'consultation_steps', 'items', json_encode($consultationSteps), 'json');
        
        // Call to action section from PDF
        PageContent::setContent('home', 'cta', 'title', 'Ready to Transform Your Health?');
        PageContent::setContent('home', 'cta', 'subtitle', 'Book Your Teleconsultation Today');
        PageContent::setContent('home', 'cta', 'text', 'Join thousands of patients who have experienced better health outcomes through Dr. Fintan\'s innovative integrative medicine approach. Video or audio consultations available via WhatsApp, Telegram, Google Meet, and Zoom.');
        PageContent::setContent('home', 'cta', 'button_text', 'Book Your Consultation');
        
        // Consultation promise from PDF
        PageContent::setContent('home', 'promise', 'text', 'We assure you of leaving the consultation better than before! Experience the difference of personalized, natural healthcare that addresses root causes, not just symptoms.');
    }
}
