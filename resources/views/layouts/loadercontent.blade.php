@php
   $themeloader = ($loader == 'div') ? 'theme_loader_div' : 'theme_loader_fix';
   $nameloader = $name.'_loader';
@endphp

<div class="{!! $themeloader !!} {!! $nameloader !!}" style="display:none;">
    <div class="cell preloader5 loader-block divbox">
        <div class="circle-5 l"></div>
        <div class="circle-5 m"></div>
        <div class="circle-5 r"></div>
    </div>
</div>
