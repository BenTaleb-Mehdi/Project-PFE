<x-mail::message>
<div style="text-align: center; background-color: #ffffffff; padding: 40px 0; margin: -32px -32px 30px -32px; border-radius: 4px 4px 0 0;">
<img src="{{ $message->embed(public_path('images/logo.png')) }}" alt="IronCoach Logo" style="width: 160px; height: 160; filter: brightness(0) invert(1); border-radius: 50%;">
</div>

<h1 style="text-align: center; color: #18181b; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 25px;">Welcome to IronCoach</h1>

Hello,

Your coaching account has been successfully provisioned. You now have full access to your personalized dashboard, protocols, and progress tracking.

### ACCESS CREDENTIALS:

<x-mail::panel>
**USER:** {{ $email }}  
**PASS:** `{{ $password }}`
</x-mail::panel>

<x-mail::button :url="$url" color="primary">
ENTER DASHBOARD
</x-mail::button>

<div style="background-color: #f4f4f5; padding: 15px; border-radius: 4px; border-left: 4px solid #18181b; margin-top: 25px; font-size: 14px;">
<strong>SECURITY NOTE:</strong> For your protection, please change your password immediately after your first login.
</div>

---
**The IronCoach Team**  
*Precision // Performance // Progress*
</x-mail::message>
