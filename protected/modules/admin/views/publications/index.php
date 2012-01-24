<h1 class="main">Публікації</h1>

<ul class="tabs">
    <a href="/admin/publications/news/" class="a_in_tab"><span>
        <li <?php if ($view == 'news') echo 'class="current"'; ?>>Новини</li>
    </span></a>
    <a href="/admin/publications/citystyle/" class="a_in_tab"><span>
        <li <?php if ($view == 'city_style') echo 'class="current"'; ?>>City - стиль</li>
    </span></a>
    <a href="/admin/publications/knowour/" class="a_in_tab"><span>
        <li <?php if ($view == 'know_our') echo 'class="current"'; ?>>Знай наших</li>
    </span></a>
    <a href="/admin/publications/tyca/" class="a_in_tab"><span>
        <li <?php if ($view == 'tyca') echo 'class="current"'; ?>>Tyca</li>
    </span></a>
    <a href="/admin/publications/participants/" class="a_in_tab"><span>
        <li <?php if ($view == 'participants') echo 'class="current"'; ?>>Учасники</li>
    </span></a>
</ul>
<div class="box visible">

    <?php $this->renderPartial($view, array('rows' => $data)); ?>

</div>
