<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
<h4>{'Autostatus menu'|i18n( 'autostatus/log' )}</h4>
</div></div></div></div></div></div>

<ul>
    <li><a href={'autostatus/log'|ezurl()}>{'All events'|i18n( 'autostatus/log' )} ({$total_count})</a></li>
    <li><a href={'autostatus/log/0'|ezurl()}>{'Only successful events'|i18n( 'autostatus/log' )} ({$succeed_count})</a></li>
    <li><a href={'autostatus/log/1'|ezurl()}>{'Only error events'|i18n( 'autostatus/log' )} ({$error_count})</a></li>
</ul>

<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">

</div></div></div></div></div></div>


<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
<h4>{'Info'|i18n( 'autostatus/log' )}</h4>
</div></div></div></div></div></div>

<p>{'Events older than %maxage days are automatically removed by a periodic script.'|i18n( 'autostatus/log', '', hash( '%maxage', ezini( 'AutoStatusLogSettings', 'MaxAge', 'autostatus.ini' ) ) )}</p>

<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">

</div></div></div></div></div></div>
