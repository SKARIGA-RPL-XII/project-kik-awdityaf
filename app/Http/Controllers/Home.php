<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MembershipPlan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function __construct()
    {
        // Kalau mau pakai middleware nanti
        // $this->middleware('guest');
    }

    // ================= LANDING PAGE =================
    public function index()
    {
        $title = 'FitGym - Your Ultimate Fitness Destination';

        $plans = MembershipPlan::where('status', 'active')->get();

        return view('landing.index', compact('title', 'plans'));
    }

    // ================= ABOUT =================
    public function about()
    {
        $title = 'About FitGym - Modern Fitness Center';

        return view('landing.about', compact('title'));
    }

    // ================= SERVICES =================
    public function services()
    {
        $title = 'Our Services - FitGym';

        return view('landing.services', compact('title'));
    }

    // ================= MEMBERSHIP =================
    public function membership()
    {
        $title = 'Membership Plans - FitGym';

        $plans = MembershipPlan::where('status', 'active')->get();

        return view('landing.membership', compact('title', 'plans'));
    }

    // ================= CONTACT =================
    public function contact()
    {
        $title = 'Contact Us - FitGym';

        return view('landing.contact', compact('title'));
    }

    // ================= SEND MESSAGE =================
    public function sendMessage(Request $request)
    {
        // VALIDATION (ganti form_validation CI)
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email',
            'subject'    => 'required|string|max:150',
            'message'    => 'required|string',
            'phone'      => 'nullable|string|max:20',
        ]);

        $firstName = $validated['first_name'];
        $lastName  = $validated['last_name'];
        $email     = $validated['email'];
        $phone     = $validated['phone'] ?? null;
        $subject   = $validated['subject'];
        $message   = $validated['message'];

        // Subject Email
        $emailSubject = 'New Contact Form Submission - ' . ucfirst(str_replace('_', ' ', $subject));

        // Isi Email (HTML)
        $emailMessage = "
            <h3>New Contact Form Submission</h3>
            <p><strong>Name:</strong> {$firstName} {$lastName}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Phone:</strong> " . ($phone ?: 'Not provided') . "</p>
            <p><strong>Subject:</strong> " . ucfirst(str_replace('_', ' ', $subject)) . "</p>
            <p><strong>Message:</strong></p>
            <p>" . nl2br(e($message)) . "</p>
            <hr>
            <p><small>This message was sent from the FitGym contact form.</small></p>
        ";

        try {

            // Kirim Email (Laravel Mail)
            Mail::html($emailMessage, function ($mail) use ($email, $firstName, $lastName, $emailSubject) {

                $mail->from($email, $firstName . ' ' . $lastName);

                $mail->to('info@fitgym.com');

                $mail->subject($emailSubject);
            });

            return redirect()
                ->route('contact')
                ->with('success', 'Thank you for your message! We will get back to you within 24 hours.');

        } catch (\Exception $e) {

            // Log error
            Log::error('Contact form email failed: ' . $e->getMessage());

            return redirect()
                ->route('contact')
                ->with('success', 'Thank you for your message! We have received your inquiry and will get back to you soon.');
        }
    }

    // ================= JOIN =================
    public function join()
    {
        return redirect()->route('register');
    }
}