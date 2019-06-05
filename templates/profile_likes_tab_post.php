<div class="post-mini__avatar user__avatar">
    <a class="user__avatar-link" href="profile.php&id=<?=$post['user'];?>">
        <?php if($post['avatar']):?><img class="post-mini__picture user__picture" src="<?=$post['avatar'];?>" alt="Аватар пользователя"><?php endif;?>
    </a>
</div>
<div class="post-mini__name-wrapper user__name-wrapper">
    <a class="post-mini__name user__name" href="profile.php&id=<?=$post['user'];?>">
        <span><?=$post['user_name'];?></span>
    </a>
    <div class="post-mini__action">
        <span class="post-mini__activity user__additional">Лайкнул вашу публикацию</span>
        <time class="post-mini__time user__additional" datetime="<?= $post['data_like'];?>"><?= $post['data_like'];?></time>
    </div>
</div>
