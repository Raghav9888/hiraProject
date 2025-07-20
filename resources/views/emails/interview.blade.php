<p>Hi {{ $name }},</p>

<p>You have been invited to an interview.</p>

<p><strong>Google Meet Link:</strong> <a href="{{ $link }}">{{ $link }}</a></p>

@if ($isAdmin)
    <p>This is a copy of the invitation sent to the practitioner.</p>
@endif

<p>Regards,<br>
    The Hira Collective Team</p>
