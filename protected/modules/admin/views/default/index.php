<?php
$this->breadcrumbs = array(
    'Установки сайту'
);
?>

<h1 class="main">Установки сайту</h1>
<form action="#" method="post">
    <table id="settings" class="no-ribs">
        <tr>
            <td width="500"><b>Назва сайту:</b>наприклад: "Моя домашня сторінка"</td>
            <td><input type="text" maxlength="255" name="settings[title]" value="<?php echo $title; ?>" /></td>
        </tr>
        <tr>
            <td><b>Опис (Description) сайту:</b>Короткий опис, не більше 200 символів</td>
            <td><input type="text" maxlength="255" name="settings[description]" value="<?php echo $description; ?>" /></td>
        </tr>
        <tr>
            <td><b>Ключові слова (Keywords) для сайту:</b>Введіть через кому основні ключові слова для вашого сайту</td>
            <td><input type="text" maxlength="255" name="settings[keywords]" value="<?php echo $keywords; ?>" /></td>
        </tr>
        <tr>
            <td><b>Вимкнути сайт:</b>Перевести сайт в стан offline, для проведення технічних робіт</td>
            <td>
                <select name="settings[offline]"  style="width: 120px;">
                    <option value="0" <?php if ($offline == 0) echo 'selected="selected"'; ?>>Онлайн</option>
                    <option value="1" <?php if ($offline == 1) echo 'selected="selected"'; ?>>Оффлайн</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><b>Повідомлення offline:</b>Повідомлення, яке виводиться якшо сайт у стані offline</td>
            <td><textarea name="settings[offlineText]" style="width:100%; height: 50px;"><?php echo $offlineText; ?></textarea></td>
        </tr>
        <tr>
            <td><b>E-mail адреса адміністратора:</b>Введіть e-mail адресу адміністратора сайту</td>
            <td><input type="text" maxlength="255" name="settings[adminEmail]" value="<?php echo $adminEmail; ?>" /></td>
        </tr>
    </table>
    <div class="submit">
        <input type="submit" value="Зберегти" />
    </div>
</form>