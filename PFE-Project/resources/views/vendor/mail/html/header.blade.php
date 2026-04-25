@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
{{-- Laravel Logo Removed --}}
{{ $slot }}
</a>
</td>
</tr>
