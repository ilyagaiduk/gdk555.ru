<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Мероприятия и участники</h1>

        <p class="lead">Используйте API ля управления участниками мероприятия.</p>

        <?php
        foreach($tableUsers as $key) {
            echo $key['members.fullname']."<br>";
        }
        ?>
    </div>


</div>
