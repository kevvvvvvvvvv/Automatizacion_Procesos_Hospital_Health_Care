@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
        @if (trim($slot) === 'Laravel')
            <img src={{ asset('images/Logo_HC_1.png') }} class="logo" alt="Health Care Logo">
        @else
            {!! $slot !!}
        @endif
        </a>
    </td>
</tr>
