<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
<h2>You’ve taken a powerful step.</h2>

<p>Hi {{ $user->first_name }} {{ $user->last_name }},</p>

<p>Your booking is confirmed. Whether it’s a session, workshop, or gathering - thank you for choosing to show up for
    yourself in this way. We’re honored to be part of your journey.</p>

<p>You’ll find all the details in your confirmation email and calendar invite.</p>

<p>If your practitioner or host has shared any notes or intake forms, you’ll find them below.</p>

<h3>Stay Connected:</h3>

<ul>
    <li>🌿 <a href="https://youtube.com">Nourish Your Spirit</a> - Explore grounding meditations and practices on YouTube
    </li>
    <li>📲 <a href="https://instagram.com">Join the Circle</a> - Soul care, stories, and community on Instagram</li>
    <li>📌 <a href="https://pinterest.com">Inspiration for Your Path</a> - Rituals and reflections on Pinterest</li>
    <li>🎙️ <a href="https://spotify.com">The Ultimate Human Experience</a> - Listen to conversations on healing,
        awakening, and possibility on our podcast
    </li>
</ul>

<h3>Here are your booking details:</h3>

@if($isPractitioner)
    <table style="border-collapse: collapse; width: 100%; max-width: 600px;">
        <tr>
            <td style="padding: 8px; border: 1px solid #ccc;"><strong>User Name:</strong></td>
            <td style="padding: 8px; border: 1px solid #ccc;">{{ @$order->first_name . ' ' . @$order->last_name }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ccc;"><strong>Offering Name:</strong></td>
            <td style="padding: 8px; border: 1px solid #ccc;">{{ @$show->name }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ccc;"><strong>Offering Price:</strong></td>
            <td style="padding: 8px; border: 1px solid #ccc;">{{ @$order->currency_symbol .  ' '.@$order->price }}</td>
        </tr>
    </table>

    @else
    <table style="border-collapse: collapse; width: 100%; max-width: 600px;">
        <tr>
            <td style="padding: 8px; border: 1px solid #ccc;"><strong>Practitioner Name:</strong></td>
            <td style="padding: 8px; border: 1px solid #ccc;">{{ @$show->user->name }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ccc;"><strong>Offering Name:</strong></td>
            <td style="padding: 8px; border: 1px solid #ccc;">{{ @$show->name }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ccc;"><strong>Offering Price:</strong></td>
            <td style="padding: 8px; border: 1px solid #ccc;">{{ @$order->currency_symbol .  ' '.@$order->price }}</td>
        </tr>
    </table>
@endif


<p>This moment matters. We’re so glad you’re here.</p>

<p>With love,<br>
    The Hira Collective</p>


<h3>Need to reschedule or cancel?</h3>
<p>We understand that life happens — and we’ve designed our policy to hold both your time and our practitioners’
    time
    with care.</p>
<ul>
    <li>You can reschedule your booking up to 24 hours in advance, up to two times.</li>
    <li>If you cancel your booking, a cancellation fee will apply (processed through Stripe), regardless of
        timing.
    </li>
</ul>

<p>This policy exists to honor the time, energy, and preparation our practitioners devote to your care — and to
    uphold
    the costs we incur to operate the platform, sustain fair pay, and maintain ethical standards.</p>

<p><strong>For Additional Support:</strong></p>
<h4>Technical Support</h4>
<p>For anything tech-related - including booking glitches, cancellations, or refund processing:</p>
<p>Connect with Mohit, Hira’s Technical Director</p>
<p>📧 Email: <a href="mailto:technicalsupport@thehiracollective.com">technicalsupport@thehiracollective.com</a></p>
<p>📱 Message Mohit on WhatsApp</p>

<h4>Community Support</h4>
<p>Need help choosing a practitioner or navigating the platform?</p>
<p>Connect with Rashida, Hira’s Community Director</p>
<p>📧 Email <a href="mailto:community@thehiracollective.com">community@thehiracollective.com</a></p>
<p>📞 Book a call with Rashida - join via video or phone, whichever you prefer!</p>

</body>
</html>
