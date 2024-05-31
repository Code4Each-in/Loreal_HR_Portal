@props(['url'])
<tr>
<td class="header">
<a href="" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<div class="d-flex align-items-center justify-content-between">
<a href="{{ url('dashboard') }}" class="logo d-flex align-items-center">
        <img src="{{ url('assets/img/logo.png') }}" alt="">
        <span class="d-none d-lg-block">L'Oréal</span>
      </a>
</div>
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
 