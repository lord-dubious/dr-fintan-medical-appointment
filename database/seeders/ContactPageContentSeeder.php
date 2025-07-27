<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;

class ContactPageContentSeeder extends Seeder
{
    /**
     * Seed the contact page dynamic content.
     */
    public function run(): void
    {
        // Consultation hours
        PageContent::setContent('contact', 'contact_hours', 'hour_1', 'Monday - Friday: 9am - 5pm', 'text');
        PageContent::setContent('contact', 'contact_hours', 'hour_2', 'Saturday: 10am - 2pm', 'text');
        PageContent::setContent('contact', 'contact_hours', 'hour_3', 'Sunday: Closed', 'text');

        // Map embed code removed per user request

        // Consultation and Teleconsultation Details
        PageContent::setContent('contact', 'consultation_details', 'text', '<p><strong>What to expect from a virtual consultation with Dr. Fintan</strong></p><p>Dr Fintan&rsquo;s medical practice is an amalgamation of Orthodox and Alternative medicine.</p><p>Yielding a blend which consists of elements of Complimentary, Functional, Orthomolecular as well as Lifestyle Medicine. This delivers a pharmacologically minimalist approach to health care. Most consultations end without a drug prescription, which makes for efficient cross border client care. Whats more, no Dr has a Global practice license. So my style overcomes that hurdle.</p><p>So, are you in search of a second opinion for a medical condition? Or do you just wish to get outright effective and natural medical advice at affordable cost?</p><p>Are you still sick or even worse despite taking prescribed medications or have you been advised to write your will due to some so called &ldquo;incurable condition&rdquo;?</p><p>Are you open to going Medically Offline as it were, to find your Health?</p><p>Then you have come to the right place. Welcome</p><ul><li><strong>Step One</strong> - Pick date and time and submit a short note succinctly conveying your medical challenge(s) and your expected solution. This is necessary for determining video or audio only consultation type.</li><li><strong>Step Two</strong> - Make payment using any convenient option as displayed.</li><li><strong>Step Three</strong> - Get a confirmation of payment and a link for the Teleconsultation.</li><li><strong>Step Four</strong> - Login/Call in for the Consultation and ensure to share all relevant investigation and medication information.</li></ul><p>Expecting you and assuring you of leaving the Consultation better than before!</p>', 'rich_text');
    }
}
